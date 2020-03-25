<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    public function translates()
    {
        return $this->hasMany(AlertTranslation::class);
    }
}
