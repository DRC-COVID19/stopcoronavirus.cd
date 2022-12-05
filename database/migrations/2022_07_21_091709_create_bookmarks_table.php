<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bookmarks', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->integer('form_id');
      $table->text('row');
      $table->text('column');
      $table->string('display_type');
      $table->string('aggregator_type')->nullable();
      $table->string('params1')->nullable();
      $table->string('params2')->nullable();

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
    Schema::dropIfExists('bookmarks');
  }
}
