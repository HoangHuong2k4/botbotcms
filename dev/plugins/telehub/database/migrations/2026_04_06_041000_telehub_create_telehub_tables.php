<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // 1. Nhóm Quản lý Người thuê (Tenants & Config)
        Schema::dropIfExists('telehub_tenants');
        Schema::create('telehub_tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('email', 150)->unique();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::dropIfExists('telehub_bot_configs');
        Schema::create('telehub_bot_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->string('bot_token', 255);
            $table->string('bank_code', 20)->nullable();
            $table->string('bank_num', 50)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('qr_template', 255)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        // 2. Nhóm Sản phẩm & Kho hàng (Inventory)
        Schema::dropIfExists('telehub_categories');
        Schema::create('telehub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::dropIfExists('telehub_products');
        Schema::create('telehub_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('category_id');
            $table->string('name', 255);
            $table->decimal('price', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::dropIfExists('telehub_product_items');
        Schema::create('telehub_product_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('product_id');
            $table->text('content');
            $table->boolean('is_sold')->default(false);
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamps();
        });

        // 3. Nhóm Khách hàng & Ví tiền (Customer & Wallet)
        Schema::dropIfExists('telehub_bot_customers');
        Schema::create('telehub_bot_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->bigInteger('telegram_id')->unique();
            $table->string('full_name', 255)->nullable();
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::dropIfExists('telehub_balance_logs');
        Schema::create('telehub_balance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('customer_id');
            $table->string('type', 20); // IN, OUT
            $table->decimal('amount', 15, 2);
            $table->string('note', 255)->nullable();
            $table->timestamps();
        });

        // 4. Nhóm Giao dịch & Webhook (Payment)
        Schema::dropIfExists('telehub_deposit_requests');
        Schema::create('telehub_deposit_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('customer_id');
            $table->decimal('amount', 15, 2);
            $table->string('payment_code', 50)->unique();
            $table->string('status', 60)->default('pending'); // pending, success, failed
            $table->timestamps();
        });

        Schema::dropIfExists('telehub_bank_webhooks');
        Schema::create('telehub_bank_webhooks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('tran_id_bank', 100)->unique();
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->json('raw_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telehub_bank_webhooks');
        Schema::dropIfExists('telehub_deposit_requests');
        Schema::dropIfExists('telehub_balance_logs');
        Schema::dropIfExists('telehub_bot_customers');
        Schema::dropIfExists('telehub_product_items');
        Schema::dropIfExists('telehub_products');
        Schema::dropIfExists('telehub_categories');
        Schema::dropIfExists('telehub_bot_configs');
        Schema::dropIfExists('telehub_tenants');
    }
};
