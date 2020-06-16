<?php

namespace App\Http\Controllers;

use App\Flux;
use App\Hospital;
use App\Http\Resources\HospitalResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\MyTrait\GClientSheet;
use App\Http\MyTrait\GeoConding;
use App\Imports\FluxImport;
use App\PandemicStat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class DashBoardController extends Controller
{
    use GClientSheet, GeoConding;

    public function index()
    {
        $pandemicStats = PandemicStat::orderBy('last_update', 'DESC')->first();
        return view('diagnosticMaps.dashboard', compact('pandemicStats'));
    }

    public function getLastPandemicsRegion()
    {
        try {
            $pandemics = DB::select("SELECT health_zones.name, p1.confirmed, p1.sick, p1.seriously, p1.healed, p1.dead, p1.last_update 
        FROM pandemics p1
        INNER JOIN(
        SELECT MAX(pandemics.last_update) AS max_date, pandemics.health_zone_id 
        FROM  pandemics  group by  pandemics.health_zone_id ) p2
        ON p2.health_zone_id=p1.health_zone_id AND p2.max_date=p1.last_update
        INNER JOIN health_zones ON p1.health_zone_id=health_zones.id");
            return response()->json($pandemics);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

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
        $datafromDb = DB::table('diagnostics')
            ->select(['longitude', 'latitude', 'township', 'orientation', 'province', DB::raw('COUNT(*) as count')])
            ->groupBy('longitude', 'latitude', 'township', 'orientation', 'province')
            ->get();
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

        return response()->json(array_values($newArray));
    }

    function getAllDiagnosticStat()
    {
        $datafromDb = DB::table('diagnostics')
            ->select([DB::raw('COUNT(id) as count, orientation,CAST( created_at AS DATE) as created_at')])
            ->groupBy(DB::raw('CAST( created_at AS DATE)'), 'orientation')
            ->get();
        $newArray = [];

        foreach ($datafromDb as $value) {
            $index = $value->created_at;
            if (isset($newArray[$index])) {
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

        return response()->json(array_values($newArray));
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
            $key = strtoupper(Str::slug("{$value[3]}_{$value[4]}", '_'));
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
                // if ($value[15] == "Appeler le numéro vert") {
                //     if (isset($formattedArray[$key]['toll_free_number'])) {
                //         $formattedArray[$key]['toll_free_number'] += 1;
                //     } else {
                //         $formattedArray[$key]['toll_free_number'] = 1;
                //     }
                // }
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
                } else {
                    if (isset($formattedArray[$key]['not_price_increase'])) {
                        $formattedArray[$key]['not_price_increase'] += 1;
                    } else {
                        $formattedArray[$key]['not_price_increase'] = 1;
                    }
                }
                if (strpos($value[18], "Masque")) {
                    if (isset($formattedArray[$key]['not_mask'])) {
                        $formattedArray[$key]['not_mask'] += 1;
                    } else {
                        $formattedArray[$key]['not_mask'] = 1;
                    }
                } else {
                    if (isset($formattedArray[$key]['mask'])) {
                        $formattedArray[$key]['mask'] += 1;
                    } else {
                        $formattedArray[$key]['mask'] = 1;
                    }
                }
                if (strpos($value[18], 'Makala')) {
                    if (isset($formattedArray[$key]['not_makala'])) {
                        $formattedArray[$key]['not_makala'] += 1;
                    } else {
                        $formattedArray[$key]['not_makala'] = 1;
                    }
                } else {
                    if (isset($formattedArray[$key]['makala'])) {
                        $formattedArray[$key]['makala'] += 1;
                    } else {
                        $formattedArray[$key]['makala'] = 1;
                    }
                }
                if (strpos($value[18], 'Farine')) {
                    if (isset($formattedArray[$key]['not_flour'])) {
                        $formattedArray[$key]['not_flour'] += 1;
                    } else {
                        $formattedArray[$key]['not_flour'] = 1;
                    }
                } else {
                    if (isset($formattedArray[$key]['flour'])) {
                        $formattedArray[$key]['flour'] += 1;
                    } else {
                        $formattedArray[$key]['flour'] = 1;
                    }
                }
                if (strpos($value[18], 'Gel anti-bactérien')) {
                    if (isset($formattedArray[$key]['not_antibacterial_gel'])) {
                        $formattedArray[$key]['not_antibacterial_gel'] += 1;
                    } else {
                        $formattedArray[$key]['not_antibacterial_gel'] = 1;
                    }
                } else {
                    if (isset($formattedArray[$key]['antibacterial_gel'])) {
                        $formattedArray[$key]['antibacterial_gel'] += 1;
                    } else {
                        $formattedArray[$key]['antibacterial_gel'] = 1;
                    }
                }
            } else {
                $coordonne = null;
                if (isset($this->townGeocoding[$key])) {
                    $coordonne = $this->townGeocoding[$key];
                } else {
                    $coordonne = $this->addTownGeoCoding($value[4], $value[3]);
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
                    } else {
                        $formattedArray[$key]['not_price_increase'] = 1;
                    }
                    if (strpos($value[18], "Masque")) {
                        $formattedArray[$key]['not_mask'] = 1;
                    } else {
                        $formattedArray[$key]['mask'] = 1;
                    }
                    if (strpos($value[18], 'Makala')) {
                        $formattedArray[$key]['not_makala'] = 1;
                    } else {
                        $formattedArray[$key]['makala'] = 1;
                    }
                    if (strpos($value[18], 'Farine')) {
                        $formattedArray[$key]['not_flour'] = 1;
                    } else {
                        $formattedArray[$key]['flour'] = 1;
                    }
                    if (strpos($value[18], 'Farine')) {
                        $formattedArray[$key]['not_antibacterial_gel'] = 1;
                    } else {
                        $formattedArray[$key]['antibacterial_gel'] = 1;
                    }
                }
            }
        }
        return response()->json(array_values($formattedArray));
    }

    public function getFluxData(Request $request)
    {
        $data = Validator::make($request->all(), [
            'origin' => 'required|array',
            'destination' => 'required|array',
            'preference_start' => 'date|before_or_equal:preference_end',
            'preference_end' => 'date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();

        try {
            $flux = Flux::select(['origin', 'destination', DB::raw('sum(volume) as volume')])->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->groupBy('Origin', 'destination')
                ->whereIn('Origin', $data['origin'])
                ->whereIn('Destination', $data['destination'])->get();

            $geoCodingFilePath = storage_path('app/fluxZones.json');
            $geoData = [];
            if (file_exists($geoCodingFilePath)) {
                $jsonString = file_get_contents($geoCodingFilePath);
                $geoData = json_decode($jsonString, true);
            }
            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux::select(['origin', 'destination', DB::raw('sum(volume) as volume')])->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->groupBy('Origin', 'destination')
                    ->whereIn('Origin', $data['origin'])
                    ->whereIn('Destination', $data['destination'])->get();
                $fluxRefencesData=[];
                if (count($fluxRefences) > 0) {
                    foreach ($fluxRefences as $value) {
                        $value->{'isReference'} = true;
                        if (isset($geoData[strtoupper($value->origin)][0])) {
                            $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
                        } else {
                            continue;
                        }
                        if (isset($geoData[strtoupper($value->destination)][0])) {
                            $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
                        } else {
                            continue;
                        }
                        $fluxRefencesData[]=$value;
                    }
                }
            }
            $fluxData=[];
            foreach ($flux as $value) {
                if ($fluxRefences) {
                    foreach ($fluxRefences as $item) {
                        if ($item->origin == $value->origin && $item->destination == $value->destination) {
                            $value->{'reference_volume'} = $item->volume;
                            break;
                        }
                    }
                }
                if (isset($geoData[strtoupper($value->origin)][0])) {
                    $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
                } else {
                    continue;
                }
                if (isset($geoData[strtoupper($value->destination)][0])) {
                    $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
                } else {
                    continue;
                }
                $fluxData[]=$value;
            }
            if (is_array($fluxRefences)) {
                return response()->json($fluxData);
            }
            return response()->json(array_merge($fluxRefencesData, $fluxData));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataDaily(Request $request)
    {
        $data = Validator::make($request->all(), [
            'origin' => 'required|array',
            'destination' => 'required|array',
            'preference_start' => 'date|before_or_equal:preference_end',
            'preference_end' => 'date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();

        try {
            $flux = Flux::select(['Date as date', DB::raw('sum(volume) as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->groupBy('Date')
                ->whereIn('Origin', $data['origin'])
                ->whereIn('Destination', $data['destination'])->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux::select(['Date as date', DB::raw('sum(volume) as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->groupBy('Date')
                    ->whereIn('Origin', $data['origin'])
                    ->whereIn('Destination', $data['destination'])->get();

                if (count($fluxRefences) > 0) {
                    foreach ($fluxRefences as $value) {
                        $value->{'isReference'} = true;
                    }
                }
            }
            if (is_array($fluxRefences)) {
                return response()->json($flux);
            }
            return response()->json(array_merge($fluxRefences->toArray(), $flux->toArray()));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOrigin(Request $request)
    {
        $data = Validator::make($request->all(), [
            'filter_zone' => 'required|array',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();

        try {
            $flux = Flux::select(['origin', 'destination', DB::raw('sum(volume) as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->whereIn('Origin', $data['filter_zone'])
                        ->orWhereIn('Destination', $data['filter_zone']);
                })
                ->groupBy('Origin', 'destination')
                ->get();

            $geoCodingFilePath = storage_path('app/fluxZones.json');
            $geoData = [];
            if (file_exists($geoCodingFilePath)) {
                $jsonString = file_get_contents($geoCodingFilePath);
                $geoData = json_decode($jsonString, true);
            }
            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux::select(['origin', 'destination', DB::raw('sum(volume) as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['filter_zone'])
                            ->orWhereIn('Destination', $data['filter_zone']);
                    })
                    ->groupBy('Origin', 'destination')
                    ->get();
                $fluxRefencesData=[];
                if (count($fluxRefences) > 0) {
                    foreach ($fluxRefences as $value) {
                        $value->{'isReference'} = true;
                        if (isset($geoData[strtoupper($value->origin)][0])) {
                            $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
                        } else {
                            continue;
                        }
                        if (isset($geoData[strtoupper($value->destination)][0])) {
                            $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
                        } else {
                            continue;
                        }
                        $fluxRefencesData[]=$value;
                    }
                }
            }


            $fluxData=[];
            foreach ($flux as $value) {
                if ($fluxRefences) {
                    foreach ($fluxRefences as $item) {
                        if ($item->origin == $value->origin && $item->destination == $value->destination) {
                            $value->{'reference_volume'} = $item->volume;
                            break;
                        }
                    }
                }
                if (isset($geoData[strtoupper($value->origin)][0])) {
                    $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
                } else {
                    continue;
                }
                if (isset($geoData[strtoupper($value->destination)][0])) {
                    $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
                } else {
                    continue;
                }
                $fluxData[]=$value;
            }
            if (is_array($fluxRefences)) {
                return response()->json($fluxData);
            }
            return response()->json(array_merge($fluxRefencesData, $fluxData));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginDaily(Request $request)
    {
        $data = Validator::make($request->all(), [
            'filter_zone' => 'required|array',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();

        try {
            $flux = Flux::select(['Date as date', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->whereIn('Origin', $data['filter_zone'])
                        ->orWhereIn('Destination', $data['filter_zone']);
                })->groupBy('Date')->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux::select(['Date as date', DB::raw('sum(volume)as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['filter_zone'])
                            ->orWhereIn('Destination', $data['filter_zone']);
                    })->groupBy('Date')->get();

                if (count($fluxRefences) > 0) {
                    foreach ($fluxRefences as $value) {
                        $value->{'isReference'} = true;
                    }
                }
            }
            if (is_array($fluxRefences)) {
                return response()->json($flux);
            }
            return response()->json(array_merge($fluxRefences->toArray(), $flux->toArray()));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginDailyIn(Request $request)
    {
        $data = Validator::make($request->all(), [
            'filter_zone' => 'required|array',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();

        try {
            $flux = Flux::select(['Date as date','Destination as destination','Origin as origin', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->orWhereIn('Destination', $data['filter_zone']);
                })->groupBy('Date','destination','Origin')->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux::select(['Date as date','Destination as destination','Origin as origin', DB::raw('sum(volume)as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->orWhereIn('Destination', $data['filter_zone']);
                    })->groupBy('Date','Destination','Origin')->get();

                if (count($fluxRefences) > 0) {
                    foreach ($fluxRefences as $value) {
                        $value->{'isReference'} = true;
                    }
                }
            }
            if (is_array($fluxRefences)) {
                return response()->json($flux);
            }
            return response()->json(array_merge($fluxRefences->toArray(), $flux->toArray()));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginDailyOut(Request $request)
    {
        $data = Validator::make($request->all(), [
            'filter_zone' => 'required|array',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();

        try {
            $flux = Flux::select(['Date as date','Origin as origin', 'Destination as destination', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->orWhereIn('Origin', $data['filter_zone']);
                })->groupBy('Date','origin','Destination')->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux::select(['Date as date','Origin as origin', 'Destination as destination',DB::raw('sum(volume)as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['filter_zone']);
                    })->groupBy('Date','Destination','Origin')->get();

                if (count($fluxRefences) > 0) {
                    foreach ($fluxRefences as $value) {
                        $value->{'isReference'} = true;
                    }
                }
            }
            if (is_array($fluxRefences)) {
                return response()->json($flux);
            }
            return response()->json(array_merge($fluxRefences->toArray(), $flux->toArray()));
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxZone()
    {
        try {
            $zones = DB::select('SELECT origin FROM flux_24 UNION SELECT destination AS origin FROM flux_24 ');
            return response()->json($zones);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
}
