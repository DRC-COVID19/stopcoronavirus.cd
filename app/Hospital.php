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

    public function agent()
    {
        return $this->belongsTo(Administrator::class,'agent_id');
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function($model){
            $data = $model->getOriginal() ;
            unset($data['created_at']);
            unset($data['upfated_at']);

            HospitalLog::create($data) ;
        });
    }
}
