<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Form extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'form_reccurence_value',
        'form_reccurence_id'
    ];

    public function formReccurence()
    {
        return $this->belongsTo(FormReccurence::class);
    }
}
