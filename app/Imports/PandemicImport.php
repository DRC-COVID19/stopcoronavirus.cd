<?php

namespace App\Imports;

use App\HealthZone;
use App\Pandemic;
use Encore\Admin\Form\Field\Datetime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class PandemicImport implements ToModel,WithProgressBar
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
        $healthZone = HealthZone::where('name', $row[1])->first();
        if (!$healthZone) {
            $filePath = storage_path('app/messing.json');
            $data = [];
            if (file_exists($filePath)) {
                $jsonString = file_get_contents($filePath);
                $data = json_decode($jsonString, true);
                $data[] = $row[1];
                $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
                file_put_contents($filePath, stripslashes($newJsonString));
            } else {
                $data[] = $row[1];
                $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
                file_put_contents($filePath, stripslashes($newJsonString));
            }
            return;
        }
        $date = \DateTime::createFromFormat('m/d/Y', $row[0]);
        return new Pandemic([
            "last_update" => $date->format('Y-m-d') ,
            'confirmed' => $row[2]??0,
            'health_zone_id' => $healthZone->id,
        ]);
    }
}
