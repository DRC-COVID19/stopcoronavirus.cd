<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\Http\Resources\HospitalResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\MyTrait\GClientSheet;
use App\Http\MyTrait\GeoConding;

class DashBoardController extends Controller
{
    use GClientSheet, GeoConding;
    public function getHospials()
    {
        try {
            $hospitals = HospitalResources::collection(Hospital::get());
            return response()->json($hospitals);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    function getAllDiagnostics()
    {
        $datafromDb = DB::table('diagnostics')->select(['longitude', 'latitude', 'township', 'orientation', 'province', DB::raw('COUNT(*) as count')])
            ->groupBy('longitude', 'latitude', 'township', 'orientation', 'province')->get();
        $newArray = [];

        foreach ($datafromDb as $value) {
            $province = str_replace('-', "_", $value->province);
            $province = str_replace(' ', "_", $province);
            $township = str_replace('-', "_", $value->township);
            $township = str_replace(' ', "_", $township);
            $index = strtoupper($province . "_" . $township);
            if (array_key_exists($index, $newArray)) {
                switch ($value->orientation) {
                    case 'FIN5':
                        $newArray[$index]->{'FIN5'} = $value->count;
                        break;
                    case 'FIN8':
                        $newArray[$index]->{'FIN8'} = $value->count;
                        break;
                    default:
                        if (isset($newArray[$index]->FIN)) {
                            $newArray[$index]->FIN += $value->count;
                        } else {
                            $newArray[$index]->{'FIN'} = $value->count;
                        }
                        break;
                }
            } else {
                $newArray[$index] = $value;
                switch ($value->orientation) {
                    case 'FIN5':
                        $newArray[$index]->{'FIN5'} = $value->count;
                        break;
                    case 'FIN8':
                        $newArray[$index]->{'FIN8'} = $value->count;
                        break;
                    default:
                        $newArray[$index]->{'FIN'} = $value->count;
                        break;
                }
            }
        }

        return response()->json($newArray);
    }

    public function getSondages()
    {
        $sheetsValues = $this->readSheetValue(env('SONDAGE_SPREADSHEET_ID'), env('SONDAGE_SHEET_NAME'));
        $formattedArray = [];
        $countArray = count($sheetsValues);
        $geoCodingFilePath = storage_path('app/townGeocoding.json');
        if (file_exists($geoCodingFilePath)) {
            $jsonString = file_get_contents($geoCodingFilePath);
            $this->townGeocoding = json_decode($jsonString, true);
        }
        for ($i = 1; $i < $countArray; $i++) {
            $value = $sheetsValues[$i];
            $key = strtoupper("{$value[4]}_{$value[3]}");
            if (isset($formattedArray[$key])) {
                $formattedArray[$key] = $formattedArray[$key];
                $formattedArray[$key]['count'] += 1;
                if ($value[9] == "Inquiet" || $value[9] == "Très inquiet") {
                    if (isset($formattedArray[$key]['worried'])) {
                        $formattedArray[$key]['worried'] += 1;
                    } else {
                        $formattedArray[$key]['worried'] = 1;
                    }
                }
                if ($value[9] == "Pas très inquiet" || $value[9] == "Un peu inquiet" || $value[9] == "Pas inquiet") {
                    if (isset($formattedArray[$key]['not_worried'])) {
                        $formattedArray[$key]['not_worried'] += 1;
                    } else {
                        $formattedArray[$key]['not_worried'] = 1;
                    }
                }
                if ($value[11] == "Possible" || $value[11] == "Bien sûr") {
                    if (isset($formattedArray[$key]['catch_virus'])) {
                        $formattedArray[$key]['catch_virus'] += 1;
                    } else {
                        $formattedArray[$key]['catch_virus'] = 1;
                    }
                } else {
                    if (isset($formattedArray[$key]['not_catch_virus'])) {
                        $formattedArray[$key]['not_catch_virus'] += 1;
                    } else {
                        $formattedArray[$key]['not_catch_virus'] = 1;
                    }
                }
                if ($value[15] == "Appeler le numéro vert") {
                    if (isset($formattedArray[$key]['toll_free_number'])) {
                        $formattedArray[$key]['toll_free_number'] += 1;
                    } else {
                        $formattedArray[$key]['toll_free_number'] = 1;
                    }
                }
                if (
                    $value[20] == "Je ne peux plus travailler" ||
                    $value[20] == "Je suis au chômage technique" ||
                    $value[20] == "Je n'ai plus de clients"
                ) {

                    if (isset($formattedArray[$key]['not_work'])) {
                        $formattedArray[$key]['not_work'] += 1;
                    } else {
                        $formattedArray[$key]['not_work'] = 1;
                    }
                }
                if (strpos($value[22], "Augmentation des prix")) {
                    if (isset($formattedArray[$key]['price_increase'])) {
                        $formattedArray[$key]['price_increase'] += 1;
                    } else {
                        $formattedArray[$key]['price_increase'] = 1;
                    }
                }
                if (
                    strpos($value[18], "Masque") ||
                    strpos($value[18], 'Makala') ||
                    strpos($value[18], 'Farine') ||
                    strpos($value[18], 'viande')
                ) {
                    if (isset($formattedArray[$key]['other_difficulty'])) {
                        $formattedArray[$key]['other_difficulty'] += 1;
                    } else {
                        $formattedArray[$key]['other_difficulty'] = 1;
                    }
                }
            } else {
                $coordonne = null;
                if (isset($this->townGeocoding[$key])) {
                    $coordonne = $this->townGeocoding[$key];
                } else {
                    //$coordonne = $this->addTownGeoCoding($value[4], $value[3]);
                }

                if ($coordonne) {
                    $formattedArray[$key]['count'] = 1;
                    $formattedArray[$key]['province'] = $value[3];
                    $formattedArray[$key]['town'] = $value[4];
                    $formattedArray[$key]['longitude'] = $coordonne[0];
                    $formattedArray[$key]['latitude'] = $coordonne[1];
                    if ($value[9] == "Inquiet" || $value[9] == "Très inquiet") {
                        $formattedArray[$key]['worried'] = 1;
                    }
                    if ($value[9] == "Pas très inquiet" || $value[9] == "Un peu inquiet") {
                        $formattedArray[$key]['not_worried'] = 1;
                    }
                    if ($value[15] == "Appeler le numéro vert") {
                        $formattedArray[$key]['toll_free_number'] = 1;
                    }
                    if ($value[11] == "Possible" || $value[11] == "Bien sûr") {
                        $formattedArray[$key]['catch_virus'] = 1;
                    } else {
                        $formattedArray[$key]['not_catch_virus'] = 1;
                    }
                    if (
                        $value[20] == "Je ne peux plus travailler" ||
                        $value[20] == "Je suis au chômage technique" ||
                        $value[20] == "Je n'ai plus de clients"
                    ) {
                        $formattedArray[$key]['not_work'] = 1;
                    }
                    if (strpos("Augmentation des prix", $value[22])) {
                        $formattedArray[$key]['price_increase'] = 1;
                    }
                    if (
                        strpos("Masque", $value[18]) || strpos(" Makala", $value[18]) || strpos(" Farine", $value[18])
                        || strpos("viande", $value[18])
                    ) {
                        $formattedArray[$key]['other_difficulty'] = 1;
                    }
                }
            }
        }
        return response()->json(array_values($formattedArray));
    }
}
