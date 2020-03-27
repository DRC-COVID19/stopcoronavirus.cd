<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertTranslation extends Model
{
    protected $fillable=[
        "title",
        "content",
        'locale',
        'alert_id'
    ];

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }
}
