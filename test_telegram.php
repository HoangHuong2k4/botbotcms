<?php
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Jobs\SendTelegramNotificationJob;

$product = Product::query()->where('status', 'published')->first();
if (!$product) {
    echo "No product found.\n";
    exit;
}

$botConfig = BotConfig::query()
    ->where('tenant_id', $product->tenant_id)
    ->where('status', 'published')
    ->first();

if (!$botConfig || !$botConfig->bot_token) {
    echo "No bot config found.\n";
    exit;
}

$currentStock = \Dev\Telehub\Models\ProductItem::query()
    ->where('product_id', $product->id)
    ->where('is_sold', false)
    ->count();

$message = "[5458603043203327669][5458603043203327669]<b>Thống báo có hàng mới</b>[5458603043203327669][5458603043203327669]\n";
$message .= ($product->icon ? $product->icon . ' ' : '') . "<b>{$product->name}</b>\n";
$message .= "[5397916757333654639] <b>Vừa thêm: 1</b>\n";
$message .= "[5278467510604160626] <b>Kho hiện tại: {$currentStock}</b>\n";

$replyMarkup = [
    'inline_keyboard' => [
        [
            ['text' => '🛒 Mua ngay', 'callback_data' => "buy_{$product->id}"]
        ]
    ]
];

SendTelegramNotificationJob::dispatchSync(
    $botConfig->bot_token,
    '7353915691',
    $message,
    null,
    $replyMarkup
);

echo "Test message sent to 7353915691 for product: {$product->name}\n";
