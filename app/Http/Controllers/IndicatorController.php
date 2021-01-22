<?php

namespace App\Http\Controllers;

use App\Flux;
use App\Flux24Province;
use App\Pandemic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndicatorController extends Controller
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


    public function getIndicatorsZone(Request $request)
    {
        $data = $this->validateData($request->all());
        try {
            $axeX = [];
            $axeY = [];
            switch ($data['x']) {
                case 1:
                    $axeX = Flux::select(['Origin as name', 'Date as date', DB::raw('sum("Volume") as x')])
                        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                        ->WhereIn('Origin', $data['geoOptions'])
                        ->groupBy('Origin', 'Date')->get();
                    break;
                case 2:
                    $axeX = Flux::select(['Destination as name', 'Date as date', DB::raw('sum("Volume") as x')])
                        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                        ->WhereIn('Destination', $data['geoOptions'])
                        ->groupBy('Destination', 'Date')->get();
                    break;
                default:
                    # code...
                    break;
            }

            switch ($data['y']) {
                case 1:
                    $axeY = Pandemic::select(['health_zones.name', DB::raw('CAST(last_update AS DATE) as date,SUM(confirmed) as y')])
                        ->join('health_zones', 'health_zones.id', '=', 'pandemics.health_zone_id')
                        ->whereBetween('last_update', [$data['observation_start'], $data['observation_end']])
                        ->WhereIn('health_zones.name', $data['geoOptions'])
                        ->groupBy('health_zones.name', 'last_update')->get();
                    break;
                case 2:
                    $axeY = Pandemic::select(['health_zones.name', DB::raw('CAST(last_update AS DATE) as date,SUM(healed) as y')])
                        ->join('health_zones', 'health_zones.id', '=', 'pandemics.health_zone_id')
                        ->whereBetween('last_update', [$data['observation_start'], $data['observation_end']])
                        ->WhereIn('health_zones.name', $data['geoOptions'])
                        ->groupBy('health_zones.name', 'last_update')->get();
                    break;
                case 3:
                    $axeY = Pandemic::select(['health_zones.name', DB::raw('CAST(last_update AS DATE) as date,SUM(dead) as y')])
                        ->join('health_zones', 'health_zones.id', '=', 'pandemics.health_zone_id')
                        ->whereBetween('last_update', [$data['observation_start'], $data['observation_end']])
                        ->WhereIn('health_zones.name', $data['geoOptions'])
                        ->groupBy('health_zones.name', 'last_update')->get();
                    break;
                default:
                    # code...
                    break;
            }
            $mergeArray = array_merge($axeX->toArray(), $axeY->toArray());

            return response()->json($mergeArray,200,[],JSON_NUMERIC_CHECK);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validateData($inputData)
    {
        return  Validator::make($inputData, [
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'geoOptions' => 'required|array',
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();
    }
}
