<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormFieldType extends Model
{
  use SoftDeletes;

  const TYPE_TEXT = 1;
  const TYPE_NUMBER = 2;
  const TYP_BOOLEAN = 3;
  const TYPE_DATE = 1;

  protected $fillable = ['name'];

  public function formFields()
  {
    return $this->hasMany(FormField::class);
  }
}