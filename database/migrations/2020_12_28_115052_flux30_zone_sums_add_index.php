<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Flux30ZoneSumsAddIndex extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('flux30_zone_sums', function (Blueprint $table) {
      $table->index('Date', 'index_date');
      $table->index('Observation_Zone', 'index_Observation_Zone');
      $table->index('Hour', 'hour_index');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('flux30_zone_sums', function (Blueprint $table) {
      $table->dropIndex('index_date');
      $table->dropIndex('index_Observation_Zone');
      $table->dropIndex('hour_index');
    });
  }
}
