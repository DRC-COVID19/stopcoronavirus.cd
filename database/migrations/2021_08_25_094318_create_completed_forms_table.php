<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedFormsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('completed_forms', function (Blueprint $table) {
      $table->id();
      $table->string('reference');
      $table->boolean('synchronized')->default(false);
      $table->unsignedBigInteger('form_id');
      $table->unsignedBigInteger('admin_user_id');
      $table->unsignedBigInteger('hospital_id');

      $table
        ->foreign('form_id')
        ->references('id')
        ->on('forms');
      $table
        ->foreign('admin_user_id')
        ->references('id')
        ->on('admin_users');
      $table
        ->foreign('hospital_id')
        ->references('id')
        ->on('hospitals');
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
    Schema::dropIfExists('completed_forms');
  }
}
