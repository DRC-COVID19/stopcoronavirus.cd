<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConflictResolutionMode extends Model
{
  use SoftDeletes;

  protected $fillable = ['name', 'slug'];

  public function forms()
  {
    return $this->hasMany(Form::class);
  }
}
