<?php

namespace App\Http\Controllers;

use App\Pandemic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
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
        ])->validate();
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
        $data = $this->validate_form($request->all());
        try {
            DB::beginTransaction();
            $pandemy = Pandemic::create($data);
            DB::commit();
            return response()->json(['message' => 'Situation ajoutee avec success'], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pandemic_id)
    {
        $data = $this->validate_form($request->all());
        try {
            $pandemy = Pandemic::find($pandemic_id);
            if (! $pandemy) {
                return response()->json(['message'=> "id de la situation invalide"], 404);
            }
            $check = $pandemy->update(Arr::except($data, 'last_update', 'health_zone_id'));
            if (! $check) {
                return response()->json(['message' => 'Error, try later'], 500);
            }
            return response()->json($pandemy, 202);
        } catch (\Throwable $th) {
            DB::rollback();
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Sorts data with by specified last_update or health_zone_id or a combination of them both.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function filter(Request $request)
    {
        try {
            if ($request->get('health_zone_id')->any()) {
                // $pandemy = Pandemic::where('last_update', '=', $request->get('date'))->andWhere()
            }
            $pandemy = Pandemic::where('last_update', $request->get('date'))->first();
            return response()->json($pandemy, 202);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
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
