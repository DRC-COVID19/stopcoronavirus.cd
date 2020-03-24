<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PandemicStat extends Model
{
    protected $fillable = [
        "label",
        "value"
    ];
}
