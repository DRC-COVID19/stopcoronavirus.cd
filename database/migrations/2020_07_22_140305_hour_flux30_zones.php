<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HourFlux30Zones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flux30_zones', function (Blueprint $table) {
            $table->time('Hour')->nullable();
            $table->string('Day_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flux30_zones', function (Blueprint $table) {
            $table->dropColumn('Hour');
            $table->dropColumn('Day_type');
        });
    }
}
