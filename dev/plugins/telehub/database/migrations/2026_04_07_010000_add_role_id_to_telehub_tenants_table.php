<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('telehub_tenants', 'role_id')) {
            Schema::table('telehub_tenants', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id')->nullable()->after('user_id')->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('telehub_tenants', 'role_id')) {
            Schema::table('telehub_tenants', function (Blueprint $table) {
                $table->dropColumn('role_id');
            });
        }
    }
};
