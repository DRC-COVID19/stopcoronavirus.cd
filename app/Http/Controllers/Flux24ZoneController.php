<?php

namespace App\Http\Controllers;

use App\Flux;
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
        $data = Validator::make($request->all(), [
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
            'fluxGeoOptions'=>'required|array'
        ])->validate();

        try {
            $health_zones = HealthZone::select('health_zones.name')
                ->join('provinces', 'provinces.id', "=", 'health_zones.province_id')
                ->whereIn('provinces.name', $data['fluxGeoOptions'])
                ->get()->pluck('name');

            $flux = Flux::select(['destination as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->orderBy('volume', 'desc')
                ->whereIn('destination', $health_zones)
                ->groupBy('destination')->get();

            return response()->json($flux);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
    public function getGlobalDataOutByProvince(Request $request)
    {
        $data = Validator::make($request->all(), [
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
            'fluxGeoOptions'=>'required|array'
        ])->validate();

        try {
            $health_zones = HealthZone::select('health_zones.name')
                ->join('provinces', 'provinces.id', "=", 'health_zones.province_id')
                ->whereIn('provinces.name', $data['fluxGeoOptions'])
                ->get()->pluck('name');
                
            $flux = Flux::select(['origin as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->whereIn('origin', $health_zones)
                ->orderBy('volume', 'desc')
                ->groupBy('origin')->get();

            return response()->json($flux);
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
}
