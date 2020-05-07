<?php

namespace App\Http\Resources;

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
            'id'=>$this->id,
            'name' => $this->name,
            'address' => $this->address,
            'beds' => $this->beds,
            'occupied_beds' => $this->occupied_beds,
            'respirators' => $this->respirators,
            'occupied_respirators' => $this->occupied_respirators,
            'masks' => $this->masks,
            'situation'=>$this->hospitalSituations,
            'last_situation'=>$this->hospitalSituations()->orderBy('last_update','desc')->first(),
            'longitude'=>$this->longitude,
            'latitude'=>$this->latitude
        ];
    }
}
