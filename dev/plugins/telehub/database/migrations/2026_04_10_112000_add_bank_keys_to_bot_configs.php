<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->string('bank_api_token')->nullable()->after('qr_template');
            $table->string('webhook_signature')->nullable()->after('bank_api_token');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->dropColumn(['bank_api_token', 'webhook_signature']);
        });
    }
};
