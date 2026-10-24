<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$baseQ = \Dev\Telehub\Models\Order::from("telehub_orders")
    ->where("status", "completed")
    ->where("type", "!=", "warranty");

$warrantiesSub = \Illuminate\Support\Facades\DB::table('telehub_warranties')
    ->where('type', 'refund')
    ->select('order_id', \Illuminate\Support\Facades\DB::raw('SUM(refund_amount) as total_refund'))
    ->groupBy('order_id');

$revenueByDay = (clone $baseQ)
    ->leftJoinSub($warrantiesSub, 'w', 'w.order_id', '=', 'telehub_orders.id')
    ->select(
        \Illuminate\Support\Facades\DB::raw("DATE(telehub_orders.created_at) as date"), 
        \Illuminate\Support\Facades\DB::raw("SUM(telehub_orders.total_amount) - IFNULL(SUM(w.total_refund), 0) as total")
    )
    ->groupBy("date")
    ->orderBy("date", "asc")
    ->get();

print_r($revenueByDay->toArray());
