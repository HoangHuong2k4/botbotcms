<?php

namespace Dev\Telehub\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Dev\Telehub\Models\BotCustomer;
use Dev\Base\Enums\BaseStatusEnum;
use Exception;

class SendTelegramNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 30;
    public int $maxExceptions = 1;

    public function __construct(
        protected string $botToken,
        protected string $telegramId,
        protected string $message,
        protected ?string $image = null,
        protected ?array $replyMarkup = null
    ) {}

    public function handle(): void
    {
        try {
            $formattedMessage = $this->message;

            // Tự động nhận diện và bọc các ID Custom Emoji Premium (18-20 chữ số) để hiển thị chuyển động
            $formattedMessage = preg_replace('/\[(?:emoji[:_])?(\d{18,20})\]/', '___EMOJI_$1___', $formattedMessage);
            $formattedMessage = preg_replace('/\b(\d{18,20})\b/', '___EMOJI_$1___', $formattedMessage);
            $formattedMessage = preg_replace('/___EMOJI_(\d{18,20})___/', '<tg-emoji emoji-id="$1">📢</tg-emoji>', $formattedMessage);

            if ($this->image) {
                // Gửi ảnh kèm chú thích
                $imageUrl = \Dev\Media\Facades\AppMedia::getImageUrl($this->image);
                if ($imageUrl && !preg_match('/^https?:\/\//', $imageUrl)) {
                    $imageUrl = url($imageUrl);
                }
                
                $payload = [
                    'chat_id' => $this->telegramId,
                    'photo' => $imageUrl,
                    'caption' => $formattedMessage,
                    'parse_mode' => 'HTML',
                ];
                if ($this->replyMarkup) {
                    $payload['reply_markup'] = json_encode($this->replyMarkup);
                }
                $response = Http::timeout(10)->post("https://api.telegram.org/bot{$this->botToken}/sendPhoto", $payload);
            } else {
                // Chỉ gửi tin nhắn văn bản
                $payload = [
                    'chat_id' => $this->telegramId,
                    'text' => $formattedMessage,
                    'parse_mode' => 'HTML',
                ];
                if ($this->replyMarkup) {
                    $payload['reply_markup'] = json_encode($this->replyMarkup);
                }
                $response = Http::timeout(10)->post("https://api.telegram.org/bot{$this->botToken}/sendMessage", $payload);
            }

            if (!$response->successful()) {
                $statusCode = $response->status();
                $body = $response->json() ?? [];
                $desc = $body['description'] ?? '';

                Log::warning("Telegram send failed to {$this->telegramId}: [{$statusCode}] {$desc}");

                // Kiểm tra nếu bot bị chặn hoặc người dùng không tồn tại / xóa tài khoản
                if ($statusCode === 403 || ($statusCode === 400 && (str_contains($desc, 'chat not found') || str_contains($desc, 'user not found') || str_contains($desc, 'user is deactivated')))) {
                    $this->pruneDeadCustomer($desc);
                    return;
                }

                // Nếu bị rate limit (429), nhả lại queue và chờ retry
                if ($statusCode === 429) {
                    $retryAfter = $body['parameters']['retry_after'] ?? 5;
                    $this->release($retryAfter);
                    return;
                }

                // Với các lỗi 4xx khác (bad request, lỗi HTML parse entity, message too long...),
                // việc retry hoặc lưu vào failed_jobs sẽ không có tác dụng và làm đầy database
                if ($statusCode >= 400 && $statusCode < 500) {
                    Log::warning("[SendTelegramNotificationJob] Client error [{$statusCode}] to {$this->telegramId}: {$desc}. Aborting gracefully.");
                    return;
                }

                $response->throw();
            }
        } catch (Exception $e) {
            $msg = $e->getMessage();
            Log::info("Failed to send telegram notification to {$this->telegramId}: " . $msg);
            if (str_contains($msg, '403') || str_contains($msg, '400') || str_contains($msg, 'chat not found') || str_contains($msg, 'user is deactivated')) {
                return;
            }
            if ($this->attempts() >= $this->tries) {
                Log::error("[SendTelegramNotificationJob] Max attempts reached for {$this->telegramId}: " . $msg);
                return;
            }
            throw $e;
        }
    }

    protected function pruneDeadCustomer(string $reason = ''): void
    {
        $customer = BotCustomer::where('telegram_id', $this->telegramId)->first();
        if (!$customer) {
            return;
        }

        $hasBalance = $customer->balance > 0;
        $hasOrders = $customer->orders()->exists();
        $hasDeposits = $customer->depositRequests()->exists();

        if (!$hasBalance && !$hasOrders && !$hasDeposits) {
            try {
                DB::table('telehub_customer_activities')->where('customer_id', $customer->id)->delete();
                DB::table('telehub_dealer_prices')->where('customer_id', $customer->id)->delete();
                $customer->delete();
                Log::info("[Notification] Deleted blocked customer ID {$customer->id} (Telegram: {$this->telegramId}) - Reason: {$reason}");
            } catch (\Throwable $ex) {
                Log::error("[Notification] Failed deleting customer {$customer->id}: " . $ex->getMessage());
            }
        } else {
            $customer->update(['status' => BaseStatusEnum::DRAFT]);
            Log::info("[Notification] Marked blocked customer ID {$customer->id} (Telegram: {$this->telegramId}) as DRAFT due to financial/order history - Reason: {$reason}");
        }
    }
}
