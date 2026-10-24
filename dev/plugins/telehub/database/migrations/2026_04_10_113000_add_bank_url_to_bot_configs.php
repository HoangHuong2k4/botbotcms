<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->string('bank_api_url')->nullable()->after('qr_template')->comment('Full polling URL for the bank API');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->dropColumn('bank_api_url');
        });
    }
};
