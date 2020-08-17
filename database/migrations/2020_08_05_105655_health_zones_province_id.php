<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HealthZonesProvinceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_zones', function (Blueprint $table) {
            $table->integer('province_id')->index()->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_zones', function (Blueprint $table) {
            $table->dropColumn('province_id');
        });
    }
}
