<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsDiffusionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sms_diffusions', function (Blueprint $table) {
      $table->id();
      $table->enum('status', ['DRAFT', 'VALIDATED'])->default('DRAFT');
      $table->text('content_fr')->nullable();
      $table->text('content_li')->nullable();
      $table->text('content_sw')->nullable();
      $table->text('content_ts')->nullable();
      $table->text('content_ki')->nullable();
      $table->dateTime('date_diffusion');
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
    Schema::dropIfExists('sms_diffusions');
  }
}
