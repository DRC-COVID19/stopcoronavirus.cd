<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePandemicStatsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pandemic_stats', function (Blueprint $table) {
      $table->id();
      $table->integer('confirmed')->default(0);
      $table->integer('sick')->nullable();
      $table->integer('seriously')->nullable();
      $table->integer('healed')->nullable();
      $table->integer('dead')->nullable();
      $table->integer('imported')->nullable();
      $table->integer('local')->nullable();
      $table->datetime('last_update');
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
    Schema::dropIfExists('pandemic_stats');
  }
}
