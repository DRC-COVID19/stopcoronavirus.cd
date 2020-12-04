<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfricelFlowInterZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('africel_flow_inter_zones', function (Blueprint $table) {
            $table->id();
            $table->string('zone_A');
            $table->string('zone_B');
            $table->date('date');
            $table->double('flow_AB');
            $table->double('flow_BA');
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
        Schema::dropIfExists('africel_flow_inter_zones');
    }
}
