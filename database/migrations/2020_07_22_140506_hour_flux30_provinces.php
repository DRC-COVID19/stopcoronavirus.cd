<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HourFlux30Provinces extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('flux30_provinces', function (Blueprint $table) {
      $table->time('Hour')->nullable();
      $table->string('Day_type')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('flux30_provinces', function (Blueprint $table) {
      $table->dropColumn('Hour');
    });
    Schema::table('flux30_provinces', function (Blueprint $table) {
      $table->dropColumn('Day_type');
    });
  }
}
