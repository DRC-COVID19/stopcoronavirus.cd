<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalSituation extends Model
{
    protected $fillable=[
        'hospital_id',
        'confirmed',
        'sick',
        'healed',
        'dead',
        'last_update'
    ];
}
