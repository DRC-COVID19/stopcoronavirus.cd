<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfricelFlowHorsZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('africel_flow_hors_zones', function (Blueprint $table) {
            $table->id();
            $table->string('zone_name');
            $table->string('date');
            $table->double('flow_out');
            $table->double('flow_in');
            $table->double('flow_out');
            $table->double('flow_tot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('africel_flow_hors_zones');
    }
}
