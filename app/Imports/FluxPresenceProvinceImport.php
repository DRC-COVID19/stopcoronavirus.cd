<?php

namespace App\Imports;

use App\Flux24PresenceProvince;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class FluxPresenceProvinceImport implements ToModel, WithProgressBar
{
  use Importable;
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    if ($row[0] == 'Date' || $row[0] == '﻿Date') {
      return;
    }
    return new Flux24PresenceProvince([
      'Date' => $row[0],
      'Day_type' => $row[1],
      'PresenceType' => $row[2],
      'Type' => $row[3],
      'Activity_Zone' => $row[4],
      'Home_Zone' => $row[5],
      'Zone' => $row[6],
      'Volume' => $row[7],
    ]);
  }
}
