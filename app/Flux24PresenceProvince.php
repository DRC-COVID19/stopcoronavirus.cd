<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flux24PresenceProvince extends Model
{
  protected $fillable = [
    'Date',
    'Day_type',
    'PresenceType',
    'Type',
    'Activity_Zone',
    'Home_Zone',
    'Zone',
    'Volume',
  ];
}
