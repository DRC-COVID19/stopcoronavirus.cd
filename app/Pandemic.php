<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pandemic extends Model
{
    //
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
