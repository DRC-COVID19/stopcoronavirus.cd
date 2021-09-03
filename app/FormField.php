<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'order_field',
        'rules',
        'default_value',
        'form_id',
        'form_field_type_id',
        'form_step_id'
    ];

    public function formFieldType()
    {
        return $this->belongsTo(FormFieldType::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function formStep()
    {
        return $this->belongsTo(FormStep::class);
    }
}
