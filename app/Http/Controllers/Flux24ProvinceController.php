<?php

namespace App\Http\Controllers;

use App\Flux24Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux24ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getGlobalDataIn(Request $request)
    {
        $data = $this->fluxGlobalValidator($request->all());;

        try {
            $flux = Flux24Province::select(['destination as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('destination')->get();

            $flux_reference = Flux24Province::select(['destination as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('destination')->get();

            return response()->json([
                'observations'=>$flux,
                'references'=>$flux_reference,
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
    public function getGlobalDataOut(Request $request)
    {
        $data = $this->fluxGlobalValidator($request->all());

        try {
            $flux = Flux24Province::select(['origin as zone','Date as date', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('origin','Date')->get();

                $flux_reference = Flux24Province::select(['origin as zone','Date as date', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('origin','Date')->get();

                return response()->json([
                    'observations'=>$flux,
                    'references'=>$flux_reference,
                ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginProvince(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Province::select(['origin', 'destination', DB::raw('sum(volume) as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->whereIn('Origin', $data['fluxGeoOptions'])
                        ->orWhereIn('Destination', $data['fluxGeoOptions']);
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
                $fluxRefences = Flux24Province::select(['origin', 'destination', DB::raw('sum(volume) as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['fluxGeoOptions'])
                            ->orWhereIn('Destination', $data['fluxGeoOptions']);
                    })
                    ->groupBy('Origin', 'destination')
                    ->get();
                $fluxRefencesData = [];
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
                        $fluxRefencesData[] = $value;
                    }
                }
            }


            $fluxData = [];
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
                $fluxData[] = $value;
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

    public function getFluxDataFromOriginDailyProvince(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Province::select(['Date as date', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where('immobility','3h')
                ->where(function ($q) use ($data) {
                    $q->whereIn('Origin', $data['fluxGeoOptions'])
                        ->orWhereIn('Destination', $data['fluxGeoOptions']);
                })->groupBy('Date')->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Province::select(['Date as date', DB::raw('sum(volume)as volume')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where('immobility','3h')
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['fluxGeoOptions'])
                            ->orWhereIn('Destination', $data['fluxGeoOptions']);
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

    public function getFluxDataFromOriginDailyProvinceCompare(Request $request)
    {
        $data = $this->fluxValidator($request->all());
        try {
            $flux = DB::select("SELECT origin, DATE as date , SUM(volume) AS volume
            FROM (
                SELECT origin,DATE, SUM(volume) AS volume FROM flux24_provinces GROUP BY origin, DATE
                UNION ALL
                SELECT destination AS origin,DATE, SUM(volume) AS volume FROM flux24_provinces GROUP BY destination, DATE
                )
                AS t
                WHERE DATE BETWEEN ? and ?
                GROUP BY origin,DATE ", [$data['preference_start'], $data['observation_end']]);

            return response()->json($flux);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginDailyInProvince(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Province::select(['Date as date', 'Destination as destination', 'Origin as origin', DB::raw('sum(volume)as volume,WEEKDAY(DATE) AS day')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where('immobility','3h')
                ->whereIn('Destination', $data['fluxGeoOptions'])
                ->groupBy('Date', 'day', 'destination', 'Origin')->get();

            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Province::select(['Destination as destination', 'Origin as origin', 'Date', DB::raw('sum(volume)as volume, WEEKDAY(DATE) AS day')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where('immobility','3h')
                    ->whereIn('Destination', $data['fluxGeoOptions'])
                    ->groupBy('day', 'Destination', 'Origin', 'Date')
                    ->orderBy('volume')
                    ->get();
            }
            $geoCodingFilePath = storage_path('app/fluxZones.json');
            $geoData = [];
            if (file_exists($geoCodingFilePath)) {
                $jsonString = file_get_contents($geoCodingFilePath);
                $geoData = json_decode($jsonString, true);
            }
            foreach ($flux as $value) {
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
            }

            return response()->json([
                'references' => $fluxRefences,
                'observations' => $flux,
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginDailyOutProvince(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Province::select(['Date as date', 'Origin as origin', 'Destination as destination', DB::raw('sum(volume)as volume,WEEKDAY(DATE) AS day')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where('immobility','3h')
                ->whereIn('Origin', $data['fluxGeoOptions'])
                ->groupBy('Date', 'day', 'origin', 'Destination')->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Province::select(['Origin as origin', 'Destination as destination', 'Date', DB::raw('sum(volume)as volume, WEEKDAY(DATE) AS day')])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where('immobility','3h')
                    ->whereIn('Origin', $data['fluxGeoOptions'])
                    ->groupBy('day', 'Destination', 'Origin', 'Date')
                    ->orderBy('volume')->get();
            }

            $geoCodingFilePath = storage_path('app/fluxZones.json');
            $geoData = [];
            if (file_exists($geoCodingFilePath)) {
                $jsonString = file_get_contents($geoCodingFilePath);
                $geoData = json_decode($jsonString, true);
            }
            foreach ($flux as $value) {
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
            }

            return response()->json([
                'references' => $fluxRefences,
                'observations' => $flux,
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FLux24Province  $fLux24Province
     * @return \Illuminate\Http\Response
     */
    public function show(FLux24Province $fLux24Province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FLux24Province  $fLux24Province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FLux24Province $fLux24Province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FLux24Province  $fLux24Province
     * @return \Illuminate\Http\Response
     */
    public function destroy(FLux24Province $fLux24Province)
    {
        //
    }

    public function fluxGlobalValidator($inputData)
    {
        return  Validator::make($inputData, [
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();
    }

    public function fluxValidator($inputData)
    {
        return  Validator::make($inputData, [
            'fluxGeoOptions' => 'required|array',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();
    }
}
