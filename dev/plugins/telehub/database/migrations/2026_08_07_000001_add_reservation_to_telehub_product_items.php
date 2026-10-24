<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_product_items', function (Blueprint $table) {
            if (!Schema::hasColumn('telehub_product_items', 'reserved_until')) {
                $table->dateTime('reserved_until')->nullable()->default(null)->after('updated_at');
            }
            if (!Schema::hasColumn('telehub_product_items', 'reserved_by')) {
                $table->string('reserved_by', 100)->nullable()->default(null)->after('reserved_until');
            }
            // Thêm index nếu chưa có
            $indexes = DB::select("SHOW INDEX FROM telehub_product_items WHERE Key_name = 'idx_reserved_until_is_sold'");
            if (empty($indexes)) {
                $table->index(['reserved_until', 'is_sold'], 'idx_reserved_until_is_sold');
            }
        });
    }

    public function down(): void
    {
        Schema::table('telehub_product_items', function (Blueprint $table) {
            $indexes = DB::select("SHOW INDEX FROM telehub_product_items WHERE Key_name = 'idx_reserved_until_is_sold'");
            if (!empty($indexes)) {
                $table->dropIndex('idx_reserved_until_is_sold');
            }
            if (Schema::hasColumn('telehub_product_items', 'reserved_by')) {
                $table->dropColumn('reserved_by');
            }
            if (Schema::hasColumn('telehub_product_items', 'reserved_until')) {
                $table->dropColumn('reserved_until');
            }
        });
    }
};
