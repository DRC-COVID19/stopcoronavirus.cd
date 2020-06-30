<?php

namespace App\Http\Resources;

use App\HospitalSituation;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResources extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'foam_beds' => $this->foam_beds,
            'occupied_beds' => $this->occupied_Beds,
            'resuscitation_beds' => $this->resuscitation_beds,
            'doctors' => $this->doctors,
            'nurses' => $this->nurses,
            'para_medicals' => $this->para_medicals,
            'respirators' => $this->respirators,
            // 'situation' => $this->hospitalSituations,
            'last_situation' => HospitalSituationResource::make($this->hospitalSituations()->orderBy('created_at', 'desc')->first()),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude
        ];
    }
}
