<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompletedFormField extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'value',
        'completed_form_id',
        'form_field_id'
    ];


    public function completedForm()
    {
        return $this->belongsTo(CompletedForm::class);
    }

    public function formField()
    {
        return $this->belongsTo(FormField::class);
    }
}
