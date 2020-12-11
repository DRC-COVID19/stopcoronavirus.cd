<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AfricelFlowInterZoneResource extends JsonResource
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
          'zoneA'=>$this->zoneA,
          'zoneB'=>$this->zoneB,
          'date'=>$this->date,
          'flow_AB'=>$this->flow_AB,
          'flow_BA'=>$this->flow_BA,
          'flow_tot'=>$this->flow_tot
        ];
    }
}
