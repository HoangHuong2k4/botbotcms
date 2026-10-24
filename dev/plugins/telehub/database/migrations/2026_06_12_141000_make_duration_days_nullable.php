<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('telehub_products', function (Blueprint $table) {
            $table->integer('duration_days')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('telehub_products', function (Blueprint $table) {
            $table->integer('duration_days')->default(30)->change();
        });
    }
};
