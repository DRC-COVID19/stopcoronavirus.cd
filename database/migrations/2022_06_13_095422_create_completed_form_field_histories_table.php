<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedFormFieldHistoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('completed_form_field_histories', function (
      Blueprint $table
    ) {
      $table->id();
      $table->string('value');
      $table->unsignedBigInteger('completed_form_history_id');
      $table->unsignedBigInteger('form_field_id');
      $table->string('updated_manager_name');
      $table->string('updated_manager_first_name');

      $table
        ->foreign('completed_form_history_id')
        ->references('id')
        ->on('completed_form_histories');
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
    Schema::dropIfExists('completed_form_field_histories');
  }
}
