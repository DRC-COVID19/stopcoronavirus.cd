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

    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
