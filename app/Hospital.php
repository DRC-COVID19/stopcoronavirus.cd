<?php

namespace App;

use App\HospitalSituationNew;
use App\Events\HospitalUpdatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    // use SoftDeletes;
    protected $fillable=[
        'name',
        'address',
        'latitude',
        'longitude',
        'foam_beds',
        'resuscitation_beds',
        'respirators',
        'doctors',
        'nurses',
        'para_medicals',
        'agent_id',
        'township_id',
    ];
    public function hospitalSituations()
    {
        return $this->hasMany(HospitalSituation::class);
    }

    public function hospitalSituationsNew(){
        return $this->hasMany(HospitalSituationNew::class);
    }
    public function hospitalLogs()
    {
        return $this->hasMany(HospitalLog::class);
    }
    public function completedForms()
    {
        return $this->hasMany(CompletedForm::class);
    }

    public function agent()
    {
        return $this->belongsTo(Administrator::class,'agent_id');
    }
    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function($model){
            $data = $model->getOriginal() ;
            unset($data['id']) ;
            $data['hospital_id'] = $model->id ;

            HospitalLog::create($data) ;
        });
    }
}
