<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->string('telegram_admin_id', 100)->nullable()->after('bot_token');
            $table->string('telegram_notification_id', 100)->nullable()->after('telegram_admin_id');
            $table->string('telegram_sales_id', 100)->nullable()->after('telegram_notification_id');
            $table->string('bank_account_name', 150)->nullable()->after('bank_name');
        });
    }

    public function down(): void
    {
        Schema::table('telehub_bot_configs', function (Blueprint $table) {
            $table->dropColumn([
                'telegram_admin_id',
                'telegram_notification_id',
                'telegram_sales_id',
                'bank_account_name',
            ]);
        });
    }
};
