<?php

namespace App\Imports;

use App\Flux24Province;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class Flux24ProvinceImport implements ToModel,WithProgressBar
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0]=='Date' || $row[0]=="﻿Date") {
            return;
        }
        return new Flux24Province([
            'Date' => $row[0],
            'Origin' => $row[1],
            'Destination' => $row[2],
            'Immobility' => $row[3],
            'Home_Category' => $row[4],
            'Activity_Category' => $row[5],
            'Observation_Zone' => $row[6],
            'Mode' => $row[7],
            'Volume' => $row[8]
        ]);
    }
}
