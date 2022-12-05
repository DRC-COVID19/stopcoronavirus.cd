<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlux24PresenceZonesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('flux24_presence_zones', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->date('Date');
      $table->string('Day_type');
      $table->string('PresenceType');
      $table->string('Type');
      $table->string('Activity_Zone');
      $table->string('Home_Zone');
      $table->string('Zone');
      $table->float('Volume');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('flux24_presence_zones');
  }
}
