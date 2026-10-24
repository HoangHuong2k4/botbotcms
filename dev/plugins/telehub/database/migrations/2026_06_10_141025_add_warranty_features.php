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
        // 1. Thêm cột duration_days vào bảng telehub_products
        Schema::table('telehub_products', function (Blueprint $table) {
            if (!Schema::hasColumn('telehub_products', 'duration_days')) {
                $table->integer('duration_days')->default(30)->after('price')->comment('Thời gian sử dụng của sản phẩm (theo ngày)');
            }
        });

        // 2. Thêm cột status vào bảng telehub_product_items
        Schema::table('telehub_product_items', function (Blueprint $table) {
            if (!Schema::hasColumn('telehub_product_items', 'status')) {
                $table->string('status', 30)->default('active')->after('is_sold')->comment('Trạng thái của tài khoản: active, revoked, replaced');
            }
        });

        // 3. Tạo bảng telehub_warranties
        Schema::create('telehub_warranties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_item_id')->index();
            $table->string('type', 30)->default('refund')->comment('Loại bảo hành: refund (hoàn tiền), replace (đổi trả)');
            $table->integer('days_used')->default(0)->comment('Số ngày đã dùng');
            $table->decimal('refund_amount', 15, 2)->default(0)->comment('Số tiền đã hoàn lại');
            $table->string('status', 30)->default('completed')->comment('Trạng thái bảo hành');
            $table->string('note', 255)->nullable()->comment('Ghi chú / Lý do bảo hành');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telehub_warranties');

        Schema::table('telehub_product_items', function (Blueprint $table) {
            if (Schema::hasColumn('telehub_product_items', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('telehub_products', function (Blueprint $table) {
            if (Schema::hasColumn('telehub_products', 'duration_days')) {
                $table->dropColumn('duration_days');
            }
        });
    }
};
