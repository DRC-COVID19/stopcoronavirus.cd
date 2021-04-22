<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pandemic extends Model
{
    protected $fillable = [
        "last_update",
        'sick',
        'confirmed',
        'health_zone_id',
        'seriously',
        'dead',
        'healed'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function health_zone()
    {
        return $this->belongsTo(HealthZone::class);
    }
}
