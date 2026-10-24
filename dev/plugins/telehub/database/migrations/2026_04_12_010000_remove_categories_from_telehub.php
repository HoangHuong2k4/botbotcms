<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('telehub_products', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('telehub_categories');
    }

    public function down(): void
    {
        Schema::create('telehub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::table('telehub_products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('tenant_id');
        });
    }
};
