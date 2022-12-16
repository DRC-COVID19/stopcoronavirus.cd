<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorReadChangeLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('administrator_read_change_logs', function (
      Blueprint $table
    ) {
      $table->id();
      $table->unsignedInteger('administrator_id');
      $table->unsignedBigInteger('change_log_id');

      $table
        ->foreign('administrator_id')
        ->on('admin_users')
        ->references('id')
        ->onDelete('CASCADE')
        ->onUpdate('CASCADE');
      $table
        ->foreign('change_log_id')
        ->on('change_logs')
        ->references('id')
        ->onDelete('CASCADE')
        ->onUpdate('CASCADE');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('administrator_read_change_logs');
  }
}
