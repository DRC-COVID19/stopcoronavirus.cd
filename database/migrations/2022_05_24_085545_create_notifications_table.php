<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('form_id');
      $table->string('title');
      $table->string('message');
      $table
        ->foreign('form_id')
        ->references('id')
        ->on('forms');
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
    Schema::dropIfExists('notifications');
  }
}
