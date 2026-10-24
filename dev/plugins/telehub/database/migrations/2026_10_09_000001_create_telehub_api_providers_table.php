<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('telehub_api_providers')) {
            Schema::create('telehub_api_providers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tenant_id')->nullable()->index();
                $table->string('name', 191);
                $table->string('base_url', 255);
                $table->string('auth_type', 50)->default('header'); // header, bearer
                $table->string('header_name', 100)->default('X-API-Key');
                $table->text('api_key');
                $table->string('partner_id', 100)->nullable();
                $table->string('endpoint_catalog', 255)->default('/api/v2/catalog');
                $table->string('endpoint_orders', 255)->default('/api/v2/orders');
                $table->string('endpoint_balance', 255)->default('/api/v2/me');
                $table->decimal('balance', 15, 2)->default(0);
                $table->string('currency', 20)->default('VND');
                $table->string('status', 30)->default('active'); // active, inactive
                $table->timestamp('last_sync_at')->nullable();
                $table->longText('raw_data')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('telehub_products', function (Blueprint $table) {
            if (!Schema::hasColumn('telehub_products', 'is_api_product')) {
                $table->boolean('is_api_product')->default(false)->after('status')->index();
            }
            if (!Schema::hasColumn('telehub_products', 'api_provider_id')) {
                $table->unsignedBigInteger('api_provider_id')->nullable()->after('is_api_product')->index();
            }
            if (!Schema::hasColumn('telehub_products', 'api_product_id')) {
                $table->string('api_product_id', 191)->nullable()->after('api_provider_id')->index();
            }
            if (!Schema::hasColumn('telehub_products', 'api_cost_price')) {
                $table->decimal('api_cost_price', 15, 2)->nullable()->after('api_product_id');
            }
            if (!Schema::hasColumn('telehub_products', 'api_stock')) {
                $table->integer('api_stock')->default(0)->after('api_cost_price');
            }
            if (!Schema::hasColumn('telehub_products', 'api_delivery_mode')) {
                $table->string('api_delivery_mode', 50)->nullable()->after('api_stock');
            }
            if (!Schema::hasColumn('telehub_products', 'api_markup_percent')) {
                $table->decimal('api_markup_percent', 8, 2)->nullable()->after('api_delivery_mode');
            }
        });

        Schema::table('telehub_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('telehub_orders', 'api_provider_id')) {
                $table->unsignedBigInteger('api_provider_id')->nullable()->after('total_amount')->index();
            }
            if (!Schema::hasColumn('telehub_orders', 'api_order_code')) {
                $table->string('api_order_code', 100)->nullable()->after('api_provider_id')->index();
            }
            if (!Schema::hasColumn('telehub_orders', 'api_response')) {
                $table->longText('api_response')->nullable()->after('api_order_code');
            }
            if (!Schema::hasColumn('telehub_orders', 'api_status')) {
                $table->string('api_status', 50)->nullable()->after('api_response');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telehub_api_providers');

        Schema::table('telehub_products', function (Blueprint $table) {
            $table->dropColumn([
                'is_api_product',
                'api_provider_id',
                'api_product_id',
                'api_cost_price',
                'api_stock',
                'api_delivery_mode',
                'api_markup_percent',
            ]);
        });

        Schema::table('telehub_orders', function (Blueprint $table) {
            $table->dropColumn([
                'api_provider_id',
                'api_order_code',
                'api_response',
                'api_status',
            ]);
        });
    }
};
