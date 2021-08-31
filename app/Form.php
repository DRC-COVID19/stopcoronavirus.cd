<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Form extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'publish',
        'form_recurrence_value',
        'form_recurrence_id'
    ];

    public function formRecurrence()
    {
        return $this->belongsTo(FormRecurrence::class);
    }
}
