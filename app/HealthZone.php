<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthZone extends Model
{
    protected $fillable = [
        "name",
        'longitude',
        'latitude',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function pandemic()
    {
        return $this->hasMany(Pandemic::class);
    }

}
