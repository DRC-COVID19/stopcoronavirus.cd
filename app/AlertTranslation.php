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

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
}
