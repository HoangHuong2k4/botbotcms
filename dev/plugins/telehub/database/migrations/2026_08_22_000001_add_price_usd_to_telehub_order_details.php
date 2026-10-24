<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_order_details', function (Blueprint $table) {
            // Lưu giá USD gốc (chỉ có khi dealer dùng giá sỉ USD)
            $table->decimal('price_usd', 10, 2)->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_order_details', function (Blueprint $table) {
            $table->dropColumn('price_usd');
        });
    }
};
