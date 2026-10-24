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
        Schema::table('telehub_deposit_requests', function (Blueprint $table) {
            $table->decimal('usdt_amount', 15, 6)->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telehub_deposit_requests', function (Blueprint $table) {
            $table->dropColumn('usdt_amount');
        });
    }
};
