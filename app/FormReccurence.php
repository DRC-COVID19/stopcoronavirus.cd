<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormReccurence extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'required_value'
    ];

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
}
