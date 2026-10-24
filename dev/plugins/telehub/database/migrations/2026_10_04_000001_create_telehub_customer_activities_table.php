<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('telehub_customer_activities')) {
            return;
        }

        // Hourly bucket of bot interactions per customer (written by api-tele middleware).
        // One row per (customer, date, hour) → small table, cheap to aggregate for DAU/WAU/MAU.
        Schema::create('telehub_customer_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->unsignedBigInteger('customer_id');
            $table->date('activity_date');
            $table->unsignedTinyInteger('activity_hour');
            $table->unsignedInteger('hits')->default(1);
            $table->timestamp('last_seen_at')->nullable();

            $table->unique(['customer_id', 'activity_date', 'activity_hour'], 'telehub_cust_act_unique');
            $table->index(['tenant_id', 'activity_date'], 'telehub_cust_act_tenant_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telehub_customer_activities');
    }
};
