<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$order = \Dev\Telehub\Models\Order::latest('id')->first();
echo json_encode($order);
