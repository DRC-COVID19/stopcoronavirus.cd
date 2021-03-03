<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTownshipToHospitals extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('hospitals', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('township_id')->nullable();

      $table->foreign('township_id')->references('id')->on('townships');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('hospitals', function (Blueprint $table) {
      //
      if (env('APP_ENV') != "testing") {
        $table->dropForeign('hospitals_township_id_foreign');
      }
      $table->dropColumn('township_id');
    });
  }
}
