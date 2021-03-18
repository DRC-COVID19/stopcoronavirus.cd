<?php

namespace App\Http\Controllers;

use App\Pandemic;
use App\HealthZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class HealthZoneController extends Controller
{
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
            return response()->json($pandemics, 200, [], JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function health_zone(Request $request)
    {
        try {
            $health_zone = HealthZone::select('id', 'name')->where('id', $request->get('health_zone_id'))->paginate(15);
            return response()->json($health_zone, 202);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function index()
    {
        //
        try {
            $health_zones = HealthZone::orderBy('id', 'DESC')->paginate(15);
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function create()
    {
        //
    }

    public function filter()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
