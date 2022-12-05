<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalSituationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('hospital_situations', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table
        ->integer('hospital_id')
        ->index()
        ->unsigned();
      $table->integer('confirmed')->default(0);
      $table->integer('sick')->nullable();
      $table->integer('healed')->nullable();
      $table->integer('dead')->nullable();
      $table->datetime('last_update');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('hospital_situations');
  }
}
