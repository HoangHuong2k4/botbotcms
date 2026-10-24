<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_bot_customers', function (Blueprint $table) {
            $table->string('username')->nullable()->after('full_name');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_bot_customers', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
