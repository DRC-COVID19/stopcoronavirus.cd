<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedFormFieldsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('completed_form_fields', function (Blueprint $table) {
      $table->id();
      $table->string('value');
      $table->unsignedBigInteger('completed_form_id');
      $table->unsignedBigInteger('form_field_id');

      $table
        ->foreign('completed_form_id')
        ->references('id')
        ->on('completed_forms');
      $table
        ->foreign('form_field_id')
        ->references('id')
        ->on('form_fields');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('completed_form_fields');
  }
}
