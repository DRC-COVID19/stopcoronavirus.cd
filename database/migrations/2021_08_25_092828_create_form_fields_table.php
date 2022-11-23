<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('form_fields', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->integer('order_field');
      $table->string('rules');
      $table->unsignedBigInteger('form_id');
      $table->unsignedBigInteger('form_field_type_id');
      $table->unsignedBigInteger('form_step_id')->nullable();

      $table
        ->foreign('form_id')
        ->references('id')
        ->on('forms');
      $table
        ->foreign('form_field_type_id')
        ->references('id')
        ->on('form_field_types');
      $table
        ->foreign('form_step_id')
        ->references('id')
        ->on('form_steps');
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
    Schema::dropIfExists('form_fields');
  }
}
