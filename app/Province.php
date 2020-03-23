<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        "name"
    ];

    public function smsDiffusions()
    {
        return $this->belongsToMany(SmsDiffusion::class);
    }
}
