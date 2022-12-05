<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
  protected $fillable = ['name'];

  public function hospitalLogs()
  {
    return $this->hasMany(HospitalLog::class);
  }
  public function hospital()
  {
    return $this->hasMany(Hospital::class);
  }
}
