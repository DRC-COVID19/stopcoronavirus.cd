<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFormRecurrenceNumber extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('forms', function (Blueprint $table) {
      $table->integer('form_recurrence_number')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('forms', function (Blueprint $table) {
      $table->removeColumn('form_recurrence_number');
    });
  }
}
