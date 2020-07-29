<?php

namespace App\Http\Resources;

use App\HospitalSituation;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalTotauxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'foam_beds' => $this->sum('foam_beds') ,
            'resuscitation_beds' => $this->sum('resuscitation_beds'),
            'doctors' => $this->sum('doctors'),
            'nurses' => $this->sum('nurses'),
            'para_medicals' => $this->sum('para_medicals'),
            'respirators' => $this->sum('respirators'),

            'confirmed' => $this->sum( function($a) { return $a->hospitalSituations->sum('confirmed') ; }) ,
            'sick' => $this->sum( function($a) { return $a->hospitalSituations->sum('sick') ; }),
            'healed' => $this->sum( function($a) { return $a->hospitalSituations->sum('healed') ; }),
            'dead' => $this->sum( function($a) { return $a->hospitalSituations->sum('dead') ; }),

            'occupied_foam_beds' => $this->sum( function($a) { return $a->hospitalSituations->sum('occupied_foam_beds') ; }),
            'occupied_resuscitation_beds' => $this->sum( function($a) { return $a->hospitalSituations->sum('occupied_resuscitation_beds') ; }),
            'occupied_respirators' => $this->sum( function($a) { return $a->hospitalSituations->sum('occupied_respirators') ; }),
            'resuscitation_ventilator' => $this->sum( function($a) { return $a->hospitalSituations->sum('resuscitation_ventilator') ; }),
            'oxygenator' => $this->sum( function($a) { return $a->hospitalSituations->sum('oxygenator') ; }),
            'individual_protection_equipment' => $this->sum( function($a) { return $a->hospitalSituations->sum('individual_protection_equipment') ; }),
            'masks' => $this->sum( function($a) { return $a->hospitalSituations->sum('masks') ; }),
            'rapid_screening' => $this->sum( function($a) { return $a->hospitalSituations->sum('rapid_screening') ; }),
            'x_ray' => $this->sum( function($a) { return $a->hospitalSituations->sum('x_ray') ; }),
            'automate_genexpert' => $this->sum( function($a) { return $a->hospitalSituations->sum('automate_genexpert') ; }),
            'gel_hydro_alcoolique' => $this->sum( function($a) { return $a->hospitalSituations->sum('gel_hydro_alcoolique') ; }),
            'check_point' => $this->sum( function($a) { return $a->hospitalSituations->sum('check_point') ; }),

            'chloroquine' => $this->sum( function($a) { return $a->hospitalSituations->sum('chloroquine') ; }),
            'hydrochloroquine' => $this->sum( function($a) { return $a->hospitalSituations->sum('hydrochloroquine') ; }),
            'hydrochloroquine' => $this->sum( function($a) { return $a->hospitalSituations->sum('hydrochloroquine') ; }),
            'azytromicine' => $this->sum( function($a) { return $a->hospitalSituations->sum('azytromicine') ; }),
            'Vitamince_c' => $this->sum( function($a) { return $a->hospitalSituations->sum('Vitamince_c') ; }),

            'doctors' => $this->sum( function($a) { return $a->hospitalSituations->sum('doctors') ; }),
            'nurses' => $this->sum( function($a) { return $a->hospitalSituations->sum('nurses') ; }),
            'para_medicals' => $this->sum( function($a) { return $a->hospitalSituations->sum('para_medicals') ; }),
        ];
    }
}
