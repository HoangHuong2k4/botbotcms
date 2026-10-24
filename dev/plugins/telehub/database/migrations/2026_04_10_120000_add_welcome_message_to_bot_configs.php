<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->text('welcome_message')->nullable()->after('bot_token');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->dropColumn('welcome_message');
        });
    }
};
