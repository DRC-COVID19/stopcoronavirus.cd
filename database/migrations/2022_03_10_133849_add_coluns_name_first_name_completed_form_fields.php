<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunsNameFirstNameCompletedFormFields extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('completed_form_fields', function (Blueprint $table) {
      $table->string('updated_manager_first_name')->nullable();
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
