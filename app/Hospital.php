<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable=[
        'name',
        'address',
        'foam_beds',
        'resuscitation_beds',
        'respirators',
        'doctors',
        'nurses',
        'para_medicals'
    ];
    public function hospitalSituations()
    {
        return $this->hasMany(HospitalSituation::class);
    }

    public function agent()
    {
        return $this->belongsTo(Administrator::class,'agent_id');
    }
}
