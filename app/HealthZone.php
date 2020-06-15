<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthZone extends Model
{
    protected $fillable = [
        "name",
        'longitude',
        'latitude'
    ];
}
