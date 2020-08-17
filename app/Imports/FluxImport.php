<?php

namespace App\Imports;

use App\Flux;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class FluxImport implements ToModel, WithProgressBar
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] == 'Date' || $row[0] == "﻿Date") {
            return;
        }
        $flux = Flux::where('Date', $row[0])->where('origin', $row[1])->where('Destination', $row[2])
            ->where('Immobility', $row[3])->where('Home_Category', $row[4])->where('Activity_Category', $row[5])
            ->where('Observation_Zone', $row[6])->where('Mode', $row[7])->where('Volume', $row[8])->exists();
        if ($flux) {
            return;
        }
        return new Flux([
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
