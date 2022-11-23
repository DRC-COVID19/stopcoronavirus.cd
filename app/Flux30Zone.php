<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flux30Zone extends Model
{
  protected $fillable = [
    'Date',
    'Origin',
    'Destination',
    'Immobility',
    'Home_Category',
    'Activity_Category',
    'Observation_Zone',
    'Mode',
    'Volume',
  ];
}
