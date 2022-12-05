<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flux24Province extends Model
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
