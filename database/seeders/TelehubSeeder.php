<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Telehub\Models\BotConfig;
use Dev\Telehub\Models\BotCustomer;
use Dev\Telehub\Models\Category;
use Dev\Telehub\Models\Product;
use Dev\Telehub\Models\ProductItem;
use Dev\Telehub\Models\Tenant;
use Illuminate\Support\Facades\Hash;

class TelehubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Truncate tables to ensure a clean slate
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \Dev\Telehub\Models\BankWebhook::truncate();
        \Dev\Telehub\Models\DepositRequest::truncate();
        \Dev\Telehub\Models\BalanceLog::truncate();
        \Dev\Telehub\Models\BotCustomer::truncate();
        \Dev\Telehub\Models\ProductItem::truncate();
        \Dev\Telehub\Models\Product::truncate();
        \Dev\Telehub\Models\Category::truncate();
        \Dev\Telehub\Models\BotConfig::truncate();
        \Dev\Telehub\Models\Tenant::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create a Test Tenant
        $tenant = Tenant::create([
            'username' => 'huong',
            'email'    => 'huong@cms-tele.test',
            'password' => 'password123',
            'status'   => BaseStatusEnum::PUBLISHED,
        ]);

        // 2. Create Data for the Tenant
        Category::create([
            'tenant_id' => $tenant->id,
            'name'      => 'Category 1',
            'status'    => BaseStatusEnum::PUBLISHED,
        ]);

        $product = Product::create([
            'tenant_id'   => $tenant->id,
            'category_id' => 1,
            'name'        => 'Product 1',
            'price'       => 100000,
            'status'      => BaseStatusEnum::PUBLISHED,
        ]);

        ProductItem::create([
            'tenant_id'  => $tenant->id,
            'product_id' => $product->id,
            'content'    => 'Item 1 content',
        ]);

        BotCustomer::create([
            'tenant_id'   => $tenant->id,
            'telegram_id' => 12345678,
            'full_name'   => 'Customer 1',
            'balance'     => 1000000,
            'status'      => BaseStatusEnum::PUBLISHED,
        ]);

        BotConfig::create([
            'tenant_id' => $tenant->id,
            'bot_token' => '12345678:ABCDEF12345678',
            'status'    => BaseStatusEnum::PUBLISHED,
        ]);
    }
}
