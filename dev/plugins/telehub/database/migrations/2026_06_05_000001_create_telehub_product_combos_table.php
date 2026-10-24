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
        Schema::create('telehub_product_combos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('min_quantity')->default(2)->comment('Mua tối thiểu X acc để kích hoạt combo');
            $table->enum('type', ['discount', 'bonus'])->default('discount')->comment('discount=giảm giá, bonus=tặng acc');
            $table->decimal('discount_percent', 5, 2)->nullable()->comment('Giảm bao nhiêu % mỗi acc (type=discount)');
            $table->decimal('discount_amount', 15, 2)->nullable()->comment('Giảm bao nhiêu đồng mỗi acc (type=discount)');
            $table->integer('bonus_qty')->nullable()->comment('Tặng thêm bao nhiêu acc (type=bonus)');
            $table->string('label', 100)->nullable()->comment('Nhãn hiển thị, ví dụ: Super Deal');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('telehub_tenants')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('telehub_products')->onDelete('cascade');
        });

        // Thêm combo_id vào order_details để track đơn combo
        Schema::table('telehub_order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('combo_id')->nullable()->after('price')->comment('Combo đã áp dụng');
            $table->integer('bonus_qty')->nullable()->after('combo_id')->comment('Số acc tặng thêm từ combo');
        });

        // Thêm combo_id và bonus_qty vào deposit_requests để xử lý QR tự động
        Schema::table('telehub_deposit_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('combo_id')->nullable()->after('quantity')->comment('Combo sẽ áp dụng khi thanh toán');
            $table->integer('bonus_qty')->nullable()->after('combo_id')->comment('Số acc tặng từ combo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telehub_deposit_requests', function (Blueprint $table) {
            $table->dropColumn(['combo_id', 'bonus_qty']);
        });

        Schema::table('telehub_order_details', function (Blueprint $table) {
            $table->dropColumn(['combo_id', 'bonus_qty']);
        });

        Schema::dropIfExists('telehub_product_combos');
    }
};
