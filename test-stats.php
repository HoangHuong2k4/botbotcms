<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$query = \Dev\Telehub\Models\Order::from('telehub_orders');

$cloneForStats = clone $query;
$cloneForStats->orders = null; // Remove ordering to speed up subquery

$stats = \Illuminate\Support\Facades\DB::table('telehub_warranties')
    ->joinSub($cloneForStats->select('telehub_orders.id'), 'filtered_orders', 'filtered_orders.id', '=', 'telehub_warranties.order_id')
    ->where('telehub_warranties.type', 'refund')
    ->selectRaw('COUNT(*) as total_accs, SUM(refund_amount) as total_amount')
    ->first();

print_r($stats);
