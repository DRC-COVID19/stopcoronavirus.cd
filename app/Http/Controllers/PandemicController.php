<?php

namespace App\Http\Controllers;

use App\Pandemic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Pandemic as PandemicRessources;

class PandemicController extends Controller
{
    public function validate_form($data)
    {
        return Validator::make($data, [
            'confirmed' => 'nullable|numeric',
            'sick' => 'nullable|numeric',
            'dead' => 'nullable|numeric',
            'seriously' => 'nullable|numeric',
            'healed' => 'nullable|numeric',
            'health_zone_id' => 'required|numeric',
            'last_update' => 'date'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $pandemics = Pandemic::orderBy('last_update', 'DESC')->paginate(15);
            return PandemicRessources::collection($pandemics);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function create () {

    }

    public function getHealthZoneTopConfirmed(Request $request)
    {
        $data = Validator::make($request->all(), [
            'fluxGeoOptions' => 'required|string'
        ])->validate();
        try {
            $pandemics = DB::select("SELECT MAX(p1.last_update) AS last_update, p2.name, SUM(p1.confirmed) AS confirmed, SUM(p1.healed) AS healed, SUM(p1.dead) AS dead
            FROM pandemics p1
            INNER JOIN health_zones p2 ON p1.health_zone_id=p2.id
            INNER JOIN provinces p3 ON p3.id=p2.province_id
            WHERE p3.name=?
            GROUP BY p2.name
            ORDER BY confirmed DESC
            LIMIT 5
            ", [$data['fluxGeoOptions']]);
            return response()->json($pandemics,200,[],JSON_NUMERIC_CHECK);
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
     * @param  \App\Pandemic  $pandemic
     * @return \Illuminate\Http\Response
     */
    public function show(Pandemic $pandemic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pandemic  $pandemic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pandemic $pandemic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pandemic  $pandemic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pandemic $pandemic)
    {
        //
    }
}
