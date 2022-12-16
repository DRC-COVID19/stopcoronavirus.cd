<?php

namespace App\Imports;

use App\HealthZone;
use App\Province;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class HealthZoneImport implements ToModel, WithProgressBar
{
  use Importable;
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    if ($row[0] == 'province' || $row[0] == '﻿province') {
      return;
    }
    $province_id = null;
    $province = Province::where('name', $row[0])->first();
    if ($province) {
      $province_id = $province->id;
    }

    $healthZone = HealthZone::where('name', $row[1])->first();
    if ($healthZone) {
      $healthZone->update([
        'province_id' => $province_id,
      ]);
      return;
    }
    return new HealthZone([
      'name' => $row[1],
      'province_id' => $province_id,
    ]);
  }
}
