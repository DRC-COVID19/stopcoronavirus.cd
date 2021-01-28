<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HealthZonePandemics extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pandemics', function (Blueprint $table) {
      if (env('APP_ENV') != "testing") {
        $table->dropForeign('pandemics_province_id_foreign');
      }
      $table->dropColumn('province_id');
      $table->bigInteger('health_zone_id')->unsigned()->nullable();
      if (env('APP_ENV') != "testing") {
        $table->index("health_zone_id");
      }
    });


    Schema::table('pandemics', function (Blueprint $table) {
      $table->dropColumn('township_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('pandemics', function (Blueprint $table) {
      $table->bigInteger('province_id')->index()->unsigned();
      $table->bigInteger('township_id')->index()->unsigned()->nullable();
      $table->foreign('province_id')->references('id')->on('provinces');
      $table->dropColumn('health_zone_id');
    });
  }
}
