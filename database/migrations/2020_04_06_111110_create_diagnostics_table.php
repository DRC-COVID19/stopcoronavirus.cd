<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('diagnostics', function (Blueprint $table) {
      $table->id();
      $table->integer('age');
      $table->string('age_range');
      $table->boolean('sore_throat_aches');
      $table->boolean('agueusia_anosmia');
      $table->boolean('breathlessness');
      $table->boolean('cough');
      $table->boolean('diarrhea');
      $table->boolean('tiredness');
      $table->boolean('tiredness_details')->nullable();
      $table->boolean('breathing_disease');
      $table->boolean('diabetes');
      $table->boolean('cancer');
      $table->boolean('feeding_day');
      $table->boolean('kidney_disease');
      $table->boolean('liver_disease');
      $table->integer('pregnant');
      $table->string('temperature_cat');
      $table->boolean('fever_algo');
      $table->integer('heart_disease');
      $table->boolean('heart_disease_algo');
      $table->boolean('immunosuppressant_disease_algo');
      $table->integer('immunosuppressant_disease');
      $table->integer('immunosuppressant_drug');
      $table->boolean('immunosuppressant_drug_algo');
      $table->string('orientation');
      $table->string('township')->nullable();
      $table->string('town')->nullable();
      $table->string('province')->nullable();
      $table->text('results_message');
      $table->string('latitude')->nullable();
      $table->string('longitude')->nullable();

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
    Schema::dropIfExists('diagnostics');
  }
}
