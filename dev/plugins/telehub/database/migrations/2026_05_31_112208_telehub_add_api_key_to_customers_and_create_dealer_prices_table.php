<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('telehub_bot_customers', function (Blueprint $table) {
            $table->string('api_key', 100)->nullable()->unique();
            $table->boolean('is_dealer')->default(false);
        });

        Schema::create('telehub_dealer_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 15, 2);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('telehub_tenants')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('telehub_bot_customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('telehub_products')->onDelete('cascade');
            $table->unique(['customer_id', 'product_id'], 'dealer_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telehub_dealer_prices');

        Schema::table('telehub_bot_customers', function (Blueprint $table) {
            $table->dropColumn(['api_key', 'is_dealer']);
        });
    }
};
