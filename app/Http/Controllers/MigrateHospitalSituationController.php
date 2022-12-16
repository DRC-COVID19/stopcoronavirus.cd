<?php

namespace App\Http\Controllers;

use App\CompletedForm;
use App\CompletedFormField;
use App\Form;
use App\Hospital;
use App\HospitalSituation;
use Illuminate\Http\Request;

class MigrateHospitalSituationController extends Controller
{
  const MAP_COLUMN_TO_FORM_FIELD = [
    '2' => 'confirmed',
    '3' => 'sick',
    '4' => 'healed',
    '5' => 'dead',
    '6' => 'number_healed_discharged',
    '7' => 'number_patients_referred',
    '8' => 'reference_ctco_name',
    '9' => 'occupied_foam_beds',
    '10' => 'number_beds_reserved_covid_19',
    '11' => 'number_beds_occupied_covid_19',
    '12' => 'occupied_resuscitation_beds',
    '13' => 'reserved_resuscitation_beds_covid_19',
    '14' => 'occupied_resuscitation_beds_covid_19',
    '15' => 'occupied_respirators',
    '16' => 'reserved_respirators_covid_19',
    '17' => 'resuscitation_ventilator',
    '18' => 'reserved_resuscitation_ventilator_covid_19',
    '19' => 'occupied_resuscitation_ventilator_covid_19',
    '20' => 'masks',
    '21' => 'individual_protection_equipment',
    '22' => 'oxygenator',
    '23' => 'reserved_oxygenator_covid_19',
    '24' => 'occupied_oxygenator_covid_19',
    '25' => 'lack_epi',
    '26' => 'tdr_covid_19_required',
    '27' => 'tdr_covid_19_available',
    '28' => 'rapid_screening',
    '35' => 'x_ray_required',
    '30' => 'x_ray',
    '31' => 'automate_genexpert_required',
    '32' => 'automate_genexpert',
    '33' => 'gel_hydro_alcoolique',
    '36' => 'check_point',
    '37' => 'chloroquine_required',
    '38' => 'chloroquine',
    '39' => 'hydrochloroquine',
    '40' => 'azytromycine_required',
    '41' => 'azytromicine',
    '42' => 'vitamine_c_required',
    '43' => 'Vitamince_c',
    '44' => 'zinc_required',
    '45' => 'zinc_available',
  ];

  //
  public function migrateToCompletedForm()
  {
    $hospitalSituations = HospitalSituation::all();
    $form = Form::with('formFields')->find(1);

    foreach ($hospitalSituations as $hospitalSituation) {
      $hospital = Hospital::find($hospitalSituation->hospital_id);
      $completedForm = CompletedForm::create([
        'form_id' => 1,
        'admin_user_id' => $hospital->agent->id,
        'hospital_id' => $hospitalSituation->hospital_id,
        'created_manager_name' => $hospitalSituation->created_manager_name,
        'last_update' => $hospitalSituation->last_update,
      ]);

      foreach ($form->formFields as $formField) {
        CompletedFormField::create([
          'form_field_id' => $formField->id,
          'value' =>
            $hospitalSituation[self::MAP_COLUMN_TO_FORM_FIELD[$formField->id]],
          'completed_form_id' => $completedForm->id,
        ]);
      }
    }
    return 1;
  }
}
