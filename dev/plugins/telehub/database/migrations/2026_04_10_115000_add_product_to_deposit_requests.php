<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_deposit_requests', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned()->nullable()->after('customer_id');
            $table->integer('quantity')->unsigned()->nullable()->after('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_deposit_requests', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'quantity']);
        });
    }
};
