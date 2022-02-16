<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormFieldType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];


    public function formFields()
    {
        return $this->hasMany(FormField::class);
    }
}
