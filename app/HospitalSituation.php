<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalSituation extends Model
{
  protected $fillable = [
    'hospital_id',

    // epidemiologicalData
    'confirmed',
    'sick',
    'healed',
    'dead',
    'number_healed_discharged',
    'number_patients_referred',
    'reference_ctco_name',

    // patientCareCapacity
    'occupied_foam_beds',
    'occupied_resuscitation_beds',
    'occupied_respirators',
    'resuscitation_ventilator',
    'masks',
    'individual_protection_equipment',
    'oxygenator',
    'rapid_screening',
    'x_ray',
    'automate_genexpert',
    'gel_hydro_alcoolique',
    'check_point',
    'number_beds_reserved_covid_19',
    'number_beds_occupied_covid_19',
    'reserved_resuscitation_beds_covid_19',
    'occupied_resuscitation_beds_covid_19',
    'reserved_respirators_covid_19',
    'reserved_resuscitation_ventilator_covid_19',
    'occupied_resuscitation_ventilator_covid_19',
    'reserved_oxygenator_covid_19',
    'occupied_oxygenator_covid_19',
    'lack_epi',
    'tdr_covid_19_required',
    'tdr_covid_19_available',
    'x_ray_required',
    'automate_genexpert_required',

    'occupied_Beds',

    // medications
    'chloroquine',
    'chloroquine_required',
    'hydrochloroquine',
    'azytromicine',
    'azytromycine_required',
    'Vitamince_c',
    'vitamine_c_required',
    'zinc_required',
    'zinc_available',

    'last_update',
    'created_manager_name',
    'updated_manager_name',
  ];

  public function hospital()
  {
    return $this->belongsTo(Hospital::class);
  }
  public function hospitalLog()
  {
    return $this->belongsTo(HospitalLog::class, 'hospital_id');
  }
}
