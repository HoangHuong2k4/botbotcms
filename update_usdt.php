<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tenant_id = 5;

\Illuminate\Support\Facades\DB::table('telehub_bot_configs')->where('tenant_id', $tenant_id)->update([
    'binance_api_key' => '5by6bMpye7L9ByfcnyHnfaTgahw7UAoBNLh5uP1vj8dlsHtQVZRUabBqxqz6rInx',
    'binance_secret_key' => 'GpVPVFDppFRApQPjhCDBkwPk0a2Of0NOgh5RwiaxWV5SePvD8yyTB2Up7grPQ6m8',
    'usdt_wallet_address' => '0x7a02f34f89bc01d76303ff87c56d3eb4f08fed1d',
    'usdt_network' => 'BSC',
    'usdt_exchange_rate' => 25500
]);

echo "USDT config updated for tenant 5.\n";
