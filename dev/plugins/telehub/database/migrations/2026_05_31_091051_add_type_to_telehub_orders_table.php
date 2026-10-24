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
        Schema::table('telehub_orders', function (Blueprint $table) {
            $table->string('type', 30)->default('sale')->after('status')->comment('sale, warranty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telehub_orders', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
