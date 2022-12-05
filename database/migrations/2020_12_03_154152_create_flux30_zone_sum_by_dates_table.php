<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlux30ZoneSumByDatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('flux30_zone_sum_by_dates', function (Blueprint $table) {
      $table->id();
      $table->date('date');
      $table->string('Observation_Zone');
      $table->double('volume');

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
    Schema::dropIfExists('flux30_zone_sum_by_dates');
  }
}
