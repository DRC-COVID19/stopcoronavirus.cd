<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminUserHospital extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admin_user_hospital', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('admin_user_id');
      $table->unsignedBigInteger('hospital_id');
      $table
        ->foreign('admin_user_id')
        ->references('id')
        ->on('admin_users');
      $table
        ->foreign('hospital_id')
        ->references('id')
        ->on('hospitals');
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
    Schema::dropIfExists('admin_user_hospital');
  }
}
