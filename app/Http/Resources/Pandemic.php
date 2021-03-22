<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pandemic extends JsonResource
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
            'confirmed' => $this->confirmed,
            'sick' => $this->sick,
            'dead' => $this->dead,
            'seriously' => $this->seriously,
            'health_zone_id' => $this->health_zone_id,
            'healed' => $this->healed,
            'health_zone' => $this->health_zone,
            'last_update' => $this->last_update
        ];
    }
}
