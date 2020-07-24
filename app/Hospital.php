<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\HospitalUpdatedEvent;

class Hospital extends Model
{
    public function hospitalSituations()
    {
        return $this->hasMany(HospitalSituation::class);
    }
    public function hospitalLogs()
    {
        return $this->hasMany(HospitalLog::class);
    }

    public function agent()
    {
        return $this->belongsTo(Administrator::class,'agent_id');
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function($model){
            $data = $model->getOriginal() ;
            $data['hospital_id'] = $model->id ;

            HospitalLog::create($data) ;
        });
    }
}
