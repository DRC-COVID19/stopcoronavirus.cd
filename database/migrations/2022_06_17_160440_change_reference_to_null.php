<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeReferenceToNull extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('completed_form_histories', function (Blueprint $table) {
      $table
        ->string('reference')
        ->nullable()
        ->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('completed_form_histories', function (Blueprint $table) {
      $table->dropColumn('reference')->change();
    });
  }
}
