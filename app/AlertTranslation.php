<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertTranslation extends Model
{
    protected $fillable=[
        "title",
        "content",
        'local'
    ];
}
