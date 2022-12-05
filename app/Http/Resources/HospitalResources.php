<?php

namespace App\Http\Resources;

use App\HospitalSituation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

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
    $observation_end = $request->query('observation_end');
    $observation_start = $request->query('observation_start');

    $result = [
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

      'situation' => $this->hospitalSituations()
        ->where(function ($query) use ($observation_start, $observation_end) {
          $query->whereBetween('last_update', [
            $observation_start,
            $observation_end,
          ]);
        })
        ->orderBy('last_update', 'desc')
        ->get(),

      'longitude' => $this->longitude,
      'latitude' => $this->latitude,
    ];

    $result['last_situation'] =
      sizeof($result['situation']) > 0 ? $result['situation'][0] : null;
    return $result;
  }
}
