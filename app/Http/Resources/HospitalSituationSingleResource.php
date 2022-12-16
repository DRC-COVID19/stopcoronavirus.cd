<?php

namespace App\Http\Resources;

use App\HospitalSituation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class HospitalSituationSingleResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    $situationCumul = HospitalSituation::select([
      DB::raw(
        'sum(confirmed) as confirmed_cumul,sum(healed) as healed_cumul,sum(dead) as dead_cumul'
      ),
    ])
      ->where('hospital_id', $this->hospital_id)
      ->first();
    return [
      'id' => $this->id,

      // epidemiologicalData
      'confirmed_cumul' => $situationCumul->confirmed_cumul,
      'sick' => $this->sick,
      'healed_cumul' => $situationCumul->healed_cumul,
      'dead_cumul' => $situationCumul->dead_cumul,
      'confirmed' => $this->confirmed,
      'healed' => $this->healed,
      'dead' => $this->dead,
      'dead' => $this->dead,
      'number_healed_discharged' => $this->number_healed_discharged,
      'number_patients_referred' => $this->number_patients_referred,
      'reference_ctco_name' => $this->reference_ctco_name,

      // patientCareCapacity
      'occupied_Beds' => $this->occupied_Beds,
      'occupied_respirators' => $this->occupied_respirators,
      'reserved_respirators_covid_19' => $this->reserved_respirators_covid_19,
      'number_beds_occupied_covid_19' => $this->number_beds_occupied_covid_19,
      'masks' => $this->masks,
      'occupied_foam_beds' => $this->occupied_foam_beds,
      'number_beds_reserved_covid_19' => $this->number_beds_reserved_covid_19,
      'occupied_resuscitation_beds' => $this->occupied_resuscitation_beds,
      'reserved_resuscitation_beds_covid_19' =>
        $this->reserved_resuscitation_beds_covid_19,
      'occupied_resuscitation_beds_covid_19' =>
        $this->occupied_resuscitation_beds_covid_19,
      'individual_protection_equipment' =>
        $this->individual_protection_equipment,
      'gel_hydro_alcoolique' => $this->gel_hydro_alcoolique,
      'resuscitation_ventilator' => $this->resuscitation_ventilator,
      'reserved_resuscitation_ventilator_covid_19' =>
        $this->reserved_resuscitation_ventilator_covid_19,
      'occupied_resuscitation_ventilator_covid_19' =>
        $this->occupied_resuscitation_ventilator_covid_19,
      'oxygenator' => $this->oxygenator,
      'reserved_oxygenator_covid_19' => $this->reserved_oxygenator_covid_19,
      'occupied_oxygenator_covid_19' => $this->occupied_oxygenator_covid_19,
      'lack_epi' => $this->lack_epi,
      'tdr_covid_19_required' => $this->tdr_covid_19_required,
      'tdr_covid_19_available' => $this->tdr_covid_19_available,
      'rapid_screening' => $this->rapid_screening,
      'automate_genexpert' => $this->automate_genexpert,
      'automate_genexpert_required' => $this->automate_genexpert_required,
      'x_ray' => $this->x_ray,
      'x_ray_required' => $this->x_ray_required,
      'check_point' => $this->check_point,

      // medications
      'chloroquine' => $this->chloroquine,
      'chloroquine_required' => $this->chloroquine_required,
      'hydrochloroquine' => $this->hydrochloroquine,
      'azytromicine' => $this->azytromicine,
      'azytromycine_required' => $this->azytromycine_required,
      'Vitamince_c' => $this->Vitamince_c,
      'vitamine_c_required' => $this->vitamine_c_required,
      'zinc_required' => $this->zinc_required,
      'zinc_available' => $this->zinc_available,
      'last_update' => $this->last_update,
      'updated_manager_name' => $this->updated_manager_name,
      'created_manager_name' => $this->created_manager_name,
    ];
  }
}
