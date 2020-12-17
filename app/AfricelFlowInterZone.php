<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AfricelFlowInterZone extends Model
{
  public function zoneA()
  {
    return $this->belongsTo(AfricelHealthZone::class, 'zone_A', 'reference');
  }
  public function zoneB()
  {
    return $this->belongsTo(AfricelHealthZone::class, 'zone_B', 'reference');
  }
}
