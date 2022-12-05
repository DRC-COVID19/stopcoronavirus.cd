<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlux30ZoneSumsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('flux30_zone_sums', function (Blueprint $table) {
      $table->id();
      $table
        ->date('Date')
        ->nullable()
        ->index();
      $table
        ->time('Hour')
        ->nullable()
        ->index();
      $table->string('Day_type');
      $table
        ->string('Origin')
        ->nullable()
        ->index();
      $table
        ->string('Destination')
        ->nullable()
        ->index();
      $table->string('Immobility')->nullable();
      $table->string('Home_Category')->nullable();
      $table->string('Activity_Category')->nullable();
      $table
        ->string('Observation_Zone')
        ->nullable()
        ->index();
      $table->string('Mode')->nullable();
      $table
        ->float('Volume')
        ->default(0)
        ->nullable();
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
    Schema::dropIfExists('flux30_zone_sums');
  }
}
