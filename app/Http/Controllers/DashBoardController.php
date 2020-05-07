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
            $index = $province . "_" . $township;
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
        $i = 0;
        foreach ($sheetsValues as $value) {
            if ($i == 0) {
                $i++;
                continue;
            }
            $key = "{$value[3]}_{$value[4]}";
            if (array_key_exists($key, $formattedArray)) {
                $formattedArray[$key]['count'] += 1;
                if ($value[9] == "Inquiet" || $value[9] == "Très inquiet") {
                    if (array_key_exists('worried', $formattedArray[$key])) {
                        $formattedArray[$key]['worried'] += 1;
                    } else {
                        $formattedArray[$key]['worried'] = 1;
                    }
                }
                if ($value[15] == "Appeler le numéro vert") {
                    if (array_key_exists('toll_free_number', $formattedArray[$key])) {
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

                    if (array_key_exists('not_work', $formattedArray[$key])) {
                        $formattedArray[$key]['not_work'] += 1;
                    } else {
                        $formattedArray[$key]['not_work'] = 1;
                    }
                }
                if (strpos("Augmentation des prix", $value[22])) {
                    if (array_key_exists('price_increase', $formattedArray[$key])) {
                        $formattedArray[$key]['price_increase'] += 1;
                    } else {
                        $formattedArray[$key]['price_increase'] = 1;
                    }
                }
                if (
                    strpos("Masque", $value[18]) ||
                    strpos("Makala", $value[18]) ||
                    strpos("Farine", $value[18]) ||
                    strpos("viande", $value[18])
                ) {
                    if (array_key_exists('other_difficulty', $formattedArray[$key])) {
                        $formattedArray[$key]['other_difficulty'] += 1;
                    } else {
                        $formattedArray[$key]['other_difficulty'] = 1;
                    }
                }
            } else {
                $coordonne = $this->addTownGeoCoding($value[3], $value[4]);
                if ($coordonne) {
                    $formattedArray[$key]['count'] = 1;
                    $formattedArray[$key]['province'] = $value[3];
                    $formattedArray[$key]['town'] = $value[4];
                    $formattedArray[$key]['longitude'] = $coordonne[0];
                    $formattedArray[$key]['latitude'] = $coordonne[1];
                    if ($value[9] == "Inquiet" || $value[9] == "Très inquiet") {
                        $formattedArray[$key]['worried'] = 1;
                    }
                    if ($value[15] == "Appeler le numéro vert") {
                        $formattedArray[$key]['toll_free_number'] = 1;
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
            $i++;
            dump($i);
        }
        return $formattedArray;
    }
}
