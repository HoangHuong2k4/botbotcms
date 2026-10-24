<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCodeToTelehubOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telehub_orders', function (Blueprint $table) {
            $table->string('code', 60)->nullable()->after('id');
        });

        // Initialize old data
        DB::statement("UPDATE telehub_orders SET code = CONCAT('DH', id) WHERE code IS NULL");

        Schema::table('telehub_orders', function (Blueprint $table) {
            $table->unique('code', 'telehub_orders_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telehub_orders', function (Blueprint $table) {
            $table->dropUnique('telehub_orders_code_unique');
            $table->dropColumn('code');
        });
    }
}

