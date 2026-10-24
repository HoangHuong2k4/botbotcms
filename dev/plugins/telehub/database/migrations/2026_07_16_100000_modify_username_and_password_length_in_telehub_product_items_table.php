<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('telehub_product_items', function (Blueprint $table) {
            $table->text('username')->nullable()->change();
            $table->text('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('telehub_product_items', function (Blueprint $table) {
            $table->string('username', 255)->nullable()->change();
            $table->string('password', 255)->nullable()->change();
        });
    }
};
