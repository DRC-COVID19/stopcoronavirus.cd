<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnValueOnCompletedFormFieldsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('completed_form_fields', function (Blueprint $table) {
      $table
        ->string('value')
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
    Schema::table('completed_form_fields', function (Blueprint $table) {
      //
    });
  }
}
