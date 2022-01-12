<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalLog extends Model
{
    //
    protected $fillable = ['name', 'address', 'beds', 'respirators', 'masks', 'latitude',
    'longitude', 'foam_beds', 'resuscitation_beds', 'doctors', 'nurses', 'para_medicals',
    'agent_id', 'hospital_id', 'created_at', 'updated_at'] ;

    public function agent()
    {
        return $this->belongsTo(Administrator::class,'agent_id');
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
    public function hospitalSituations()
    {
        return $this->hasMany(HospitalSituation::class, 'hospital_id');
    }
    public function hospitalSituationsNew()
    {
        return $this->hasMany(HospitalSituationNew::class, 'hospital_id');
    }
    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
