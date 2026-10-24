<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->string('binance_api_key')->nullable();
            $table->string('binance_secret_key')->nullable();
            $table->string('usdt_wallet_address')->nullable();
            $table->string('usdt_network')->nullable();
            $table->decimal('usdt_exchange_rate', 15, 2)->default(25500);
            $table->text('welcome_message_en')->nullable();
        });

        Schema::table('telehub_products', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->text('description_en')->nullable();
        });

        Schema::table('telehub_bot_customers', function (Blueprint $table) {
            $table->string('language')->default('vi');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->dropColumn(['binance_api_key', 'binance_secret_key', 'usdt_wallet_address', 'usdt_network', 'usdt_exchange_rate', 'welcome_message_en']);
        });

        Schema::table('telehub_products', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'description_en']);
        });

        Schema::table('telehub_bot_customers', function (Blueprint $table) {
            $table->dropColumn('language');
        });
    }
};
