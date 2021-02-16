<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PandemicStat extends Model
{
  protected $fillable = [
    'confirmed',
    'local',
    'imported',
    'sick',
    'seriously',
    'healed',
    'dead',
    'last_update'
  ];
}
