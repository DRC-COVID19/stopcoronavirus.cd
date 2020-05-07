<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\Http\Resources\HospitalResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\MyTrait\GClientSheet;

class DashBoardController extends Controller
{
    use GClientSheet;
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
       $values= $this->readSheetValue(env('SONDAGE_SPREADSHEET_ID'),env('SONDAGE_SHEET_NAME'));
       return $values;
    }
}
