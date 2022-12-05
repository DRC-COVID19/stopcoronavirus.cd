<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProvincesGeolocalisation extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('provinces', function (Blueprint $table) {
      $table->string('latitude')->nullable();
      $table->string('longitude')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('provinces', function (Blueprint $table) {
      $table->dropColumn('latitude');
      $table->dropColumn('longitude');
    });
  }
}
