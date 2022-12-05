<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlgoVersionDiagnostics extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('diagnostics', function (Blueprint $table) {
      $table->string('algo_version')->nullable();
      $table->string('form_version')->nullable();
      $table
        ->integer('duration')
        ->default(0)
        ->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('diagnostics', function (Blueprint $table) {
      $table->dropColumn(['algo_version', 'form_version', 'duration']);
    });
  }
}
