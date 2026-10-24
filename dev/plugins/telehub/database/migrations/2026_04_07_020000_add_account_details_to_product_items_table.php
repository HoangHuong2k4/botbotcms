<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('telehub_product_items', function (Blueprint $table) {
            $table->string('username')->nullable()->after('product_id');
            $table->string('password')->nullable()->after('username');
            $table->text('note')->nullable()->after('password');
            $table->unsignedBigInteger('customer_id')->nullable()->after('is_sold')->index();
        });
    }

    public function down(): void
    {
        Schema::table('telehub_product_items', function (Blueprint $table) {
            $table->dropColumn(['username', 'password', 'note', 'customer_id']);
        });
    }
};
