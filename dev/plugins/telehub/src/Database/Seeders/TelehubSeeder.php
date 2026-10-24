<?php

namespace Dev\Telehub\Database\Seeders;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Supports\BaseSeeder;
use Dev\Telehub\Models\Tenant;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\ProductItem;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\BalanceLog;
use Dev\Telehub\Models\DepositRequest;
use Dev\Telehub\Models\BankWebhook;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TelehubSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        Schema::disableForeignKeyConstraints();

        BalanceLog::query()->truncate();
        DepositRequest::query()->truncate();
        ProductItem::query()->truncate();
        BankWebhook::query()->truncate();
        BotCustomer::query()->truncate();
        Product::query()->truncate();
        BotConfig::query()->truncate();
        Tenant::query()->truncate();

        Schema::enableForeignKeyConstraints();

        for ($i = 1; $i <= 10; $i++) {
            $tenant = Tenant::query()->create([
                'username' => "tenant{$i}",
                'password' => Hash::make('password'),
                'email' => "tenant{$i}@example.com",
                'status' => BaseStatusEnum::PUBLISHED,
            ]);

            BotConfig::query()->create([
                'tenant_id' => $tenant->id,
                'bot_token' => "123456789:ABCDEFGH" . Str::random(10),
                'bank_code' => "VCB",
                'bank_num' => "0123456789",
                'bank_name' => "NGUYEN VAN A",
                'qr_template' => "compact",
                'status' => BaseStatusEnum::PUBLISHED,
            ]);

            for ($j = 1; $j <= 15; $j++) {
                $product = Product::query()->create([
                    'tenant_id' => $tenant->id,
                    'name' => "Product {$j} of Tenant {$i}",
                    'price' => rand(10, 500) * 1000,
                    'description' => "This is a dummy description for product {$j}",
                    'status' => BaseStatusEnum::PUBLISHED,
                ]);

                for ($l = 1; $l <= 10; $l++) {
                    ProductItem::query()->create([
                        'tenant_id' => $tenant->id,
                        'product_id' => $product->id,
                        'content' => "Account: user_{$l} | Pass: " . Str::random(8),
                        'is_sold' => (bool)rand(0, 1),
                    ]);
                }
            }

            for ($m = 1; $m <= 10; $m++) {
                $customer = BotCustomer::query()->create([
                    'tenant_id' => $tenant->id,
                    'telegram_id' => "100" . sprintf("%02d%02d", $i, $m),
                    'full_name' => "Customer {$m} of Tenant {$i}",
                    'balance' => rand(0, 1000) * 1000,
                    'status' => BaseStatusEnum::PUBLISHED,
                ]);

                BalanceLog::query()->create([
                    'tenant_id' => $tenant->id,
                    'customer_id' => $customer->id,
                    'type' => 'add',
                    'amount' => 100000,
                    'note' => 'Initial bonus',
                ]);

                if (rand(0, 1)) {
                    DepositRequest::query()->create([
                        'tenant_id' => $tenant->id,
                        'customer_id' => $customer->id,
                        'amount' => 50000,
                        'payment_code' => "TH" . strtoupper(Str::random(6)),
                        'status' => 'completed',
                    ]);
                }
            }

            BankWebhook::query()->create([
                'tenant_id' => $tenant->id,
                'tran_id_bank' => "FT" . strtoupper(Str::random(10)),
                'amount' => 100000,
                'description' => "TH" . strtoupper(Str::random(6)),
                'raw_json' => json_encode(['data' => 'dummy']),
            ]);
        }

        $this->finished();
    }
}
