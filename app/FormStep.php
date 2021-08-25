<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormStep extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'step',
        'form_id'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    
}
