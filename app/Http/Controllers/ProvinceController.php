<?php

namespace App\Http\Controllers;
use App\HealthZone;
use App\Http\Resources\HealthZoneResource;
use App\Http\Resources\ProvinceResource;
use App\Province;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function form_validator($data)
    {
        return Validator::make($data, [
            "name" => "required|string",
            "longitude" => "numeric|required",
            "latitude" => "numeric|required"
        ])->validate();
    }

    public function index()
    {
        try {
            $provinces = Province::orderBy('id', 'DESC')->paginate(15);
            return ProvinceResource::collection($provinces);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function store(Request $request)
    {
        $data = $this->form_validator($request->all());
        try {
            DB::beginTransaction();
            $province = Province::create($data);
            DB::commit();
            return response()->json($province, 201, []);
        } catch (\Throwable $th) {
            DB::rollBack();
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function show()
    {
        //
    }

    public function destroy($province_id)
    {
        try {
            $province = Province::find($province_id);
            if (!$province) {
                return response()->json(["message" => "Resource not found",], 404);
            }
            $province->destroy();
            return response()->json(null, 202);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function update()
    {

    }

    public function filter()
    {
        //
    }
}
