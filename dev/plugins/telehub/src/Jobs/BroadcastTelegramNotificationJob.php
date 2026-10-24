<?php

namespace Dev\Telehub\Jobs;

use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\BotConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Pool;
use Dev\Base\Enums\BaseStatusEnum;

class BroadcastTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;
    public int $tries = 1;
    public int $maxExceptions = 1;

    public function __construct(
        protected string $message,
        protected ?int $tenantId = null,
        protected ?string $image = null,
        protected ?array $replyMarkup = null
    ) {}

    public function handle(): void
    {
        @set_time_limit(0);

        // 1. Chuẩn bị định dạng tin nhắn (Emoji Premium)
        $formattedMessage = $this->message;
        $formattedMessage = preg_replace('/\[(?:emoji[:_])?(\d{18,20})\]/', '___EMOJI_$1___', $formattedMessage);
        $formattedMessage = preg_replace('/\b(\d{18,20})\b/', '___EMOJI_$1___', $formattedMessage);
        $formattedMessage = preg_replace('/___EMOJI_(\d{18,20})___/', '<tg-emoji emoji-id="$1">📢</tg-emoji>', $formattedMessage);

        // 2. Chuẩn bị ảnh nếu có
        $imageUrl = null;
        if ($this->image) {
            $imageUrl = \Dev\Media\Facades\AppMedia::getImageUrl($this->image);
            if ($imageUrl && !preg_match('/^https?:\/\//', $imageUrl)) {
                $imageUrl = url($imageUrl);
            }
        }

        $encodedReplyMarkup = $this->replyMarkup ? json_encode($this->replyMarkup) : null;

        // 3. Lấy cấu hình Bot của các tenant liên quan trước (tránh N+1 query)
        $botConfigs = BotConfig::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->when($this->tenantId, fn($q) => $q->where('tenant_id', $this->tenantId))
            ->get()
            ->keyBy('tenant_id');

        if ($botConfigs->isEmpty()) {
            Log::warning('[BroadcastTelegramNotificationJob] No active BotConfig found for broadcast.');
            return;
        }

        // 4. Lấy danh sách khách hàng có trạng thái published
        $customersQuery = BotCustomer::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->when($this->tenantId, fn($q) => $q->where('tenant_id', $this->tenantId));

        $totalCustomers = (clone $customersQuery)->count();
        Log::info("[BroadcastTelegramNotificationJob] Starting broadcast to {$totalCustomers} published users.");

        $successCount = 0;
        $prunedCount = 0;
        $batchSize = 25; // 25 tin/giây (ngưỡng an toàn theo quy chuẩn Telegram 30 req/s)

        $customersQuery->chunkById($batchSize, function ($customers) use (
            $botConfigs, $formattedMessage, $imageUrl, $encodedReplyMarkup,
            &$successCount, &$prunedCount
        ) {
            $startTime = microtime(true);

            // Gửi song song qua Http::pool (Async Multi-cURL) với try/catch an toàn
            try {
                $responses = Http::pool(function (Pool $pool) use ($customers, $botConfigs, $formattedMessage, $imageUrl, $encodedReplyMarkup) {
                    $requests = [];
                    foreach ($customers as $customer) {
                        $botConfig = $botConfigs->get($customer->tenant_id);
                        if (!$botConfig || empty($botConfig->bot_token)) {
                            continue;
                        }

                        $url = $imageUrl
                            ? "https://api.telegram.org/bot{$botConfig->bot_token}/sendPhoto"
                            : "https://api.telegram.org/bot{$botConfig->bot_token}/sendMessage";

                        $payload = [
                            'chat_id' => $customer->telegram_id,
                            'parse_mode' => 'HTML',
                        ];

                        if ($imageUrl) {
                            $payload['photo'] = $imageUrl;
                            $payload['caption'] = $formattedMessage;
                        } else {
                            $payload['text'] = $formattedMessage;
                        }

                        if ($encodedReplyMarkup) {
                            $payload['reply_markup'] = $encodedReplyMarkup;
                        }

                        $requests[$customer->id] = $pool->as((string)$customer->id)
                            ->timeout(8)
                            ->post($url, $payload);
                    }
                    return $requests;
                });
            } catch (\Throwable $e) {
                Log::error("[BroadcastTelegramNotificationJob] Batch Http::pool error: " . $e->getMessage());
                return;
            }

            // Xử lý kết quả trả về từ Telegram
            foreach ($customers as $customer) {
                $cid = (string)$customer->id;
                if (!isset($responses[$cid])) {
                    continue;
                }

                $res = $responses[$cid];
                if ($res instanceof \Illuminate\Http\Client\Response) {
                    if ($res->successful()) {
                        $successCount++;
                    } else {
                        $status = $res->status();
                        $data = $res->json();
                        $desc = $data['description'] ?? '';

                        // Nếu bot bị chặn hoặc người dùng xóa tài khoản / chat không tồn tại
                        if ($status === 403 || ($status === 400 && (str_contains($desc, 'chat not found') || str_contains($desc, 'user not found') || str_contains($desc, 'user is deactivated')))) {
                            $this->pruneCustomer($customer, $desc);
                            $prunedCount++;
                        }
                    }
                }
            }

            // Giải phóng bộ nhớ sau mỗi batch
            unset($responses);

            // Đảm bảo mỗi batch 25 user cách nhau ít nhất 1 giây để tuân thủ Telegram rate limit (30 msg/s)
            $elapsed = microtime(true) - $startTime;
            if ($elapsed < 1.0) {
                usleep((int)((1.0 - $elapsed) * 1000000));
            }
        });

        Log::info("[BroadcastTelegramNotificationJob] Completed broadcast. Success: {$successCount}, Dead users pruned: {$prunedCount}");
    }

    public function failed(?\Throwable $exception): void
    {
        Log::error("[BroadcastTelegramNotificationJob] Permanent failure: " . ($exception ? $exception->getMessage() : 'Unknown'));
    }

    protected function pruneCustomer(BotCustomer $customer, string $reason = ''): void
    {
        $hasBalance = $customer->balance > 0;
        $hasOrders = $customer->orders()->exists();
        $hasDeposits = $customer->depositRequests()->exists();

        if (!$hasBalance && !$hasOrders && !$hasDeposits) {
            try {
                DB::table('telehub_customer_activities')->where('customer_id', $customer->id)->delete();
                DB::table('telehub_dealer_prices')->where('customer_id', $customer->id)->delete();
                $customer->delete();
                Log::info("[Broadcast] Auto-deleted blocked customer ID {$customer->id} (Telegram: {$customer->telegram_id}) - Reason: {$reason}");
            } catch (\Throwable $ex) {
                Log::error("[Broadcast] Failed auto-deleting customer {$customer->id}: " . $ex->getMessage());
            }
        } else {
            $customer->update(['status' => BaseStatusEnum::DRAFT]);
            Log::info("[Broadcast] Marked blocked customer ID {$customer->id} (Telegram: {$customer->telegram_id}) as DRAFT due to existing financial/order history - Reason: {$reason}");
        }
    }
}
