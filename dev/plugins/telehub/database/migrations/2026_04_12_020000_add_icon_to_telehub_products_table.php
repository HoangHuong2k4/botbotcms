<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('telehub_products', function (Blueprint $table) {
            $table->string('icon', 255)->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_products', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
