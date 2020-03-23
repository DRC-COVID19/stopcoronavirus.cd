<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvinceSmsDiffusion extends Model
{
    protected $fillable = [
        "province_id",
        "sms_diffusion_id"
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function smsDiffusion()
    {
        return $this->belongsTo(SmsDiffusion::class);
    }
}
