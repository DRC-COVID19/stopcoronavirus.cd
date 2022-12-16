<?php

namespace App\Http\Resources;

use App\HospitalSituation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class HospitalSituationResource extends JsonResource
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
      'confirmed' => $situationCumul->confirmed_cumul,
      'sick' => $this->sick,
      'healed' => $situationCumul->healed_cumul,
      'dead' => $situationCumul->dead_cumul,
      'occupied_Beds' => $this->occupied_Beds,
      'occupied_respirators' => $this->occupied_respirators,
      'masks' => $this->masks,
      'occupied_foam_beds' => $this->occupied_foam_beds,
      'occupied_resuscitation_beds' => $this->occupied_resuscitation_beds,
      'individual_protection_equipment' =>
        $this->individual_protection_equipment,
      'gel_hydro_alcoolique' => $this->gel_hydro_alcoolique,
      'resuscitation_ventilator' => $this->resuscitation_ventilator,
      'oxygenator' => $this->oxygenator,
      'rapid_screening' => $this->rapid_screening,
      'automate_genexpert' => $this->automate_genexpert,
      'x_ray' => $this->x_ray,
      'check_point' => $this->check_point,
      'chloroquine' => $this->chloroquine,
      'hydrochloroquine' => $this->hydrochloroquine,
      'azytromicine' => $this->azytromicine,
      'Vitamince_c' => $this->Vitamince_c,
      'last_update' => $this->last_update,
      'updated_manager_name' => $this->updated_manager_name,
      'created_manager_name' => $this->created_manager_name,
    ];
  }
}
