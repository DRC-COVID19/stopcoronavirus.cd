<?php

namespace App\Http\Controllers;

use App\Flux;
use App\Flux24Sum;
use App\HealthZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux24ZoneController extends Controller
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

    //Zones 24h
    public function getFluxDataFromOrigin(Request $request)
    {
        $data = $this->fluxValidator($request->all());
        try {
            $flux = Flux24Sum::select(['origin', 'destination', 'volume', 'day'])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->where(function ($q) use ($data) {
                    $q->whereIn('Origin', $data['fluxGeoOptions'])
                        ->orWhereIn('Destination', $data['fluxGeoOptions']);
                })
                ->where('destination', '!=', 'Hors_Zone')
                ->where('origin', '!=', 'Hors_Zone')
                // ->groupBy('Origin', 'destination', 'day')
                ->get();

            $geoCodingFilePath = storage_path('app/fluxZones.json');
            $geoData = [];
            if (file_exists($geoCodingFilePath)) {
                $jsonString = file_get_contents($geoCodingFilePath);
                $geoData = json_decode($jsonString, true);
            }
            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Sum::select(['origin', 'destination', 'volume', 'day'])
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['fluxGeoOptions'])
                            ->orWhereIn('Destination', $data['fluxGeoOptions']);
                    })
                    ->where('destination', '!=', 'Hors_Zone')
                    ->where('origin', '!=', 'Hors_Zone')
                    // ->groupBy('Origin', 'destination', 'day')
                    ->get();
                $fluxRefencesData = [];
                // if (count($fluxRefences) > 0) {
                //     foreach ($fluxRefences as $value) {
                //         $value->{'isReference'} = true;
                //         if (isset($geoData[strtoupper($value->origin)][0])) {
                //             $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
                //         } else {
                //             continue;
                //         }
                //         if (isset($geoData[strtoupper($value->destination)][0])) {
                //             $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
                //         } else {
                //             continue;
                //         }
                //         $fluxRefencesData[] = $value;
                //     }
                // }
            }


            $fluxData = [];
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
                $fluxData[] = $value;
            }
            return response()->json([
                'references' => $fluxRefences,
                'observations' => $fluxData
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
    public function getFluxDataFromOriginDailyCompare(Request $request)
    {
        $data = $this->fluxValidator($request->all());
        try {
            // $flux = DB::select("SELECT origin,  date , volume FROM (
            //     SELECT origin,date, volume AS volume FROM flux24_sums 

            //     UNION ALL
            //     SELECT destination AS origin,date, volume FROM flux24_sums )
            //     AS t");
            $fluxOrigin = Flux24Sum::select(['origin', 'date', DB::raw('sum(volume) as volume')])
                ->groupBy('origin', 'date')
                ->get();
            $fluxDestination = Flux24Sum::select(['destination as origin', 'date', DB::raw('sum(volume) as volume')])
                ->groupBy('destination', 'date')
                ->get();

            return response()->json(['origin' => $fluxOrigin, 'destination' => $fluxDestination]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getFluxDataFromOriginDaily(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Sum::select(['Date as date', DB::raw('sum(volume) as volume')])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->whereIn('Origin', $data['fluxGeoOptions'])
                        ->orWhereIn('Destination', $data['fluxGeoOptions']);
                })
                ->where('destination', '!=', 'Hors_Zone')
                ->where('origin', '!=', 'Hors_Zone')
                ->groupBy('Date')
                ->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Sum::select(['Date as date', DB::raw('sum(volume) as volume')])
                    // ->where('Observation_Zone', 'ZoneGlobale')
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->where(function ($q) use ($data) {
                        $q->whereIn('Origin', $data['fluxGeoOptions'])
                            ->orWhereIn('Destination', $data['fluxGeoOptions']);
                    })
                    ->where('destination', '!=', 'Hors_Zone')
                    ->where('origin', '!=', 'Hors_Zone')
                    ->groupBy('Date')
                    ->get();

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
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Sum::select(['Date as date', 'Destination as destination', 'Origin as origin', 'volume', 'day'])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->whereIn('Destination', $data['fluxGeoOptions'])
                // ->where('destination', '!=', 'Hors_Zone')
                ->where('origin', '!=', 'Hors_Zone')
                // ->groupBy('Date', 'day', 'destination', 'Origin')
                ->get();

            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Sum::select(['Destination as destination', 'Origin as origin', 'date', 'volume', 'day'])
                    // ->where('Observation_Zone', 'ZoneGlobale')
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->whereIn('Destination', $data['fluxGeoOptions'])
                    // ->where('destination', '!=', 'Hors_Zone')
                    ->where('origin', '!=', 'Hors_Zone')
                    // ->groupBy('day', 'Destination', 'Origin', 'Date')
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
    public function getFluxDataFromOriginDailyOut(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Sum::select(['Date as date', 'Origin as origin', 'Destination as destination', 'volume', 'day'])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->whereIn('Origin', $data['fluxGeoOptions'])
                ->where('destination', '!=', 'Hors_Zone')
                // ->where('origin', '!=', 'Hors_Zone')
                // ->groupBy('Date', 'day', 'origin', 'Destination')
                ->get();

            $fluxRefences = [];
            if (isset($data['preference_start']) && isset($data['preference_end'])) {
                $fluxRefences = Flux24Sum::select(['Origin as origin', 'Destination as destination', 'Date', 'volume', 'day'])
                    // ->where('Observation_Zone', 'ZoneGlobale')
                    ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                    ->whereIn('Origin', $data['fluxGeoOptions'])
                    ->where('destination', '!=', 'Hors_Zone')
                    // ->where('origin', '!=', 'Hors_Zone')
                    // ->groupBy('day', 'Destination', 'Origin', 'Date')
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
     * @param  \App\Flux  $flux
     * @return \Illuminate\Http\Response
     */
    public function show(Flux $flux)
    {
        //
    }

    public function getGlobalDataInByProvince(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            // $health_zones = HealthZone::select('health_zones.name')
            //     ->join('provinces', 'provinces.id', "=", 'health_zones.province_id')
            //     ->whereIn('provinces.name', $data['fluxGeoOptions'])
            //     ->get()->pluck('name');

            $general_observation = Flux24Sum::select(['Date as date', DB::raw('sum(volume) as volume, WEEKDAY(DATE) AS day')])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('date', [$data['observation_start'], $data['observation_end']])
                ->where(function ($q) use ($data) {
                    $q->where('destination', $data['fluxGeoOptions'])
                        ->orWhere('origin', $data['fluxGeoOptions']);
                })
                ->where('destination', '!=', 'Hors_Zone')
                ->where('origin', '!=', 'Hors_Zone')
                ->orderBy('date')
                ->groupBy('date', 'day')
                ->get();

            $general_reference = Flux24Sum::select(['Date as date', DB::raw('sum(volume) as volume, WEEKDAY(DATE) AS day')])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('date', [$data['preference_start'], $data['preference_end']])
                ->where(function ($q) use ($data) {
                    $q->where('destination', $data['fluxGeoOptions'])
                        ->orWhere('origin', $data['fluxGeoOptions']);
                })
                ->where('destination', '!=', 'Hors_Zone')
                ->where('origin', '!=', 'Hors_Zone')
                ->orderBy('date')
                ->groupBy('date', 'day')
                ->get();

            $flux = Flux24Sum::select(['destination as zone', 'Date as date', 'volume'])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->orderBy('volume', 'desc')
                ->where('destination', $data['fluxGeoOptions'])
                ->where('origin', '!=', 'Hors_Zone')
                // ->groupBy('destination', 'date')
                ->get();

            $flux_reference = Flux24Sum::select(['destination as zone', 'Date as date', 'volume'])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                ->orderBy('volume', 'desc')
                ->where('destination', $data['fluxGeoOptions'])
                // ->where('destination','!=','Hors_Zone')
                ->where('origin', '!=', 'Hors_Zone')
                // ->groupBy('destination', 'date')
                ->get();
            return response()->json([
                'observations' => $flux,
                'references' => $flux_reference,
                'general_reference' => $general_reference,
                'general_observation' => $general_observation,
                'zone' => $data['fluxGeoOptions']
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
    public function getGlobalDataOutByProvince(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            // $health_zones = HealthZone::select('health_zones.name')
            //     ->join('provinces', 'provinces.id', "=", 'health_zones.province_id')
            //     ->whereIn('provinces.name', $data['fluxGeoOptions'])
            //     ->get()->pluck('name');

            $flux = Flux24Sum::select(['origin as zone', 'Date as date', 'volume'])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->where('origin', $data['fluxGeoOptions'])
                ->orderBy('volume', 'desc')
                ->where('destination', '!=', 'Hors_Zone')
                // ->where('origin','!=','Hors_Zone')
                // ->groupBy('origin', 'Date')
                ->get();
            $flux_reference = Flux24Sum::select(['origin as zone', 'Date as date', 'volume'])
                // ->where('Observation_Zone', 'ZoneGlobale')
                ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                ->where('origin', $data['fluxGeoOptions'])
                ->orderBy('volume', 'desc')
                ->where('destination', '!=', 'Hors_Zone')
                // ->where('origin','!=','Hors_Zone')
                // ->groupBy('origin', 'date')
                ->get();

            return response()->json([
                'observations' => $flux,
                'references' => $flux_reference,
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flux  $flux
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flux $flux)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flux  $flux
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flux $flux)
    {
        //
    }

    public function fluxValidator($inputData)
    {
        return  Validator::make($inputData, [
            'fluxGeoOptions' => 'required|string',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();
    }
}
