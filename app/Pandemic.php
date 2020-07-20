<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pandemic extends Model
{
    protected $fillable = [
        "last_update",
        'confirmed',
        'health_zone_id',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
