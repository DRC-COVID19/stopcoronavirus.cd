<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HealthZoneResource extends JsonResource
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
            'confirmed' => $this->name,
            'sick' => $this->email,
            'dead' => $this->username,
            'seriously' => $this->avatar,
            'healed' => $this->roles,
            'health_zone' => $this->health_zone(),
            'last_update' => $this->roles()->where('name', 'Administrator')->exists()
        ];
    }
}
