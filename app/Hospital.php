<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public function hospitalSituations()
    {
        return $this->hasMany(HospitalSituation::class);
    }

    public function agent()
    {
        return $this->belongsTo(Administrator::class,'agent_id');
    }
}
