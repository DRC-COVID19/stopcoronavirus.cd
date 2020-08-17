<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalSituation extends Model
{
    protected $fillable = [
        'hospital_id',
        "confirmed",
        "sick",
        'healed',
        'dead',
        'occupied_Beds',
        'occupied_respirators',
        'masks',
        'occupied_foam_beds',
        'occupied_resuscitation_beds',
        'individual_protection_equipment',
        'gel_hydro_alcoolique',
        "resuscitation_ventilator",
        "oxygenator",
        "rapid_screening",
        "automate_genexpert",
        "x_ray",
        "check_point",
        "chloroquine",
        'hydrochloroquine',
        'azytromicine',
        'Vitamince_c',
        'last_update',
        'created_manager_name',
        'updated_manager_name'
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
