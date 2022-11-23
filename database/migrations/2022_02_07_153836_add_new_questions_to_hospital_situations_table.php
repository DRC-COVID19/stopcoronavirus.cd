<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewQuestionsToHospitalSituationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('hospital_situations', function (Blueprint $table) {
      $table->integer('number_healed_discharged')->nullable();
      $table->integer('number_patients_referred')->nullable();
      $table->string('reference_ctco_name')->nullable();
      $table->integer('number_beds_reserved_covid_19')->nullable();
      $table->integer('number_beds_occupied_covid_19')->nullable();
      $table->integer('reserved_resuscitation_beds_covid_19')->nullable();
      $table->integer('occupied_resuscitation_beds_covid_19')->nullable();
      $table->integer('reserved_respirators_covid_19')->nullable();
      $table->integer('reserved_resuscitation_ventilator_covid_19')->nullable();
      $table->integer('occupied_resuscitation_ventilator_covid_19')->nullable();
      $table->integer('reserved_oxygenator_covid_19')->nullable();
      $table->integer('occupied_oxygenator_covid_19')->nullable();
      $table->string('lack_epi')->nullable();
      $table->integer('tdr_covid_19_required')->nullable();
      $table->integer('tdr_covid_19_available')->nullable();
      $table->integer('x_ray_required')->nullable();
      $table->integer('automate_genexpert_required')->nullable();
      $table->integer('chloroquine_required')->nullable();
      $table->integer('azytromycine_required')->nullable();
      $table->integer('vitamine_c_required')->nullable();
      $table->integer('zinc_required')->nullable();
      $table->integer('zinc_available')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('hospital_situations', function (Blueprint $table) {
      $table->dropColumn('number_healed_discharged');
      $table->dropColumn('number_patients_referred');
      $table->dropColumn('reference_ctco_name');
      $table->dropColumn('number_beds_reserved_covid_19');
      $table->dropColumn('number_beds_occupied_covid_19');
      $table->dropColumn('reserved_resuscitation_beds_covid_19');
      $table->dropColumn('occupied_resuscitation_beds_covid_19');
      $table->dropColumn('reserved_respirators_covid_19');
      $table->dropColumn('reserved_resuscitation_ventilator_covid_19');
      $table->dropColumn('occupied_resuscitation_ventilator_covid_19');
      $table->dropColumn('reserved_oxygenator_covid_19');
      $table->dropColumn('occupied_oxygenator_covid_19');
      $table->dropColumn('lack_epi');
      $table->dropColumn('tdr_covid_19_required');
      $table->dropColumn('tdr_covid_19_available');
      $table->dropColumn('x_ray_required');
      $table->dropColumn('automate_genexpert_required');
      $table->dropColumn('chloroquine_required');
      $table->dropColumn('azytromycine_required');
      $table->dropColumn('vitamine_c_required');
      $table->dropColumn('zinc_required');
      $table->dropColumn('zinc_available');
    });
  }
}
