<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flux extends Model
{
  protected $table = 'flux_24';
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
