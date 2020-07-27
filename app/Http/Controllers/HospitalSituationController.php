<?php

namespace App\Http\Controllers;

use App\HospitalSituation;
use App\Http\Resources\HospitalResources;
use App\Http\Resources\HospitalSituationResource;
use App\Http\Resources\HospitalSituationSingleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HospitalSituationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitalSituation = HospitalSituation::where('hospital_id', $this->guard()->user()->hospitalManager->id)->orderBy('created_at', 'desc')->paginate(15);
        return HospitalSituationSingleResource::collection($hospitalSituation);
    }

    public function indexByHospital($hospital_id)
    {
        $hospitalSituation = HospitalSituation::where('hospital_id', $hospital_id)
            ->orderBy('created_at', 'desc')->paginate(15);
        return HospitalSituationSingleResource::collection($hospitalSituation);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validator($request->all());
        try {
            $data['hospital_id'] = $this->guard()->user()->hospitalManager->id;
            $hospitalSituation = HospitalSituation::create($data);
            return response()->json($hospitalSituation, 201);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HospitalSituation  $hospitalSituation
     * @return \Illuminate\Http\Response
     */
    public function show(HospitalSituation $hospitalSituation)
    {
        return response()->json(HospitalSituationSingleResource::make($hospitalSituation));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HospitalSituation  $hospitalSituation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HospitalSituation $hospitalSituation)
    {
        $data = $this->validator($request->all(), $hospitalSituation->id);
        try {
            $hospitalSituation->update(Arr::except($data, ['last_update', 'hospital_id']));
            return $hospitalSituation;
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getAgentLastUpdate()
    {
        try {
            $lastUpdate = DB::select('SELECT p1.hospital_id, p2.name, MAX(p1.last_update) AS last_update, SUM(p1.confirmed) AS confirmed 
            FROM hospital_situations p1 
            INNER JOIN hospitals p2 ON p1.hospital_id=p2.id  GROUP BY hospital_id
            ORDER BY last_update desc
            ');
            return response()->json($lastUpdate);
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
     * @param  \App\HospitalSituation  $hospitalSituation
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalSituation $hospitalSituation)
    {
        //
    }

    function validator($data, $id = null)
    {
        return Validator::make($data, [
            "confirmed" => 'nullable',
            "sick" => 'nullable',
            'healed' => 'nullable',
            'dead' => 'nullable',
            'occupied_Beds' => 'nullable',
            'occupied_respirators' => 'nullable',
            'masks' => 'nullable',
            'occupied_foam_beds' => 'nullable',
            'occupied_resuscitation_beds' => 'nullable',
            'individual_protection_equipment' => 'nullable',
            'gel_hydro_alcoolique' => 'nullable',
            "resuscitation_ventilator" => 'nullable',
            "oxygenator" => 'nullable',
            "rapid_screening" => 'nullable',
            "automate_genexpert" => 'nullable',
            "x_ray" => 'nullable',
            "check_point" => 'nullable',
            "chloroquine" => 'nullable',
            'hydrochloroquine' => 'nullable',
            'azytromicine' => 'nullable',
            'Vitamince_c' => 'nullable',
            'created_manager_name' => 'nullable',
            'updated_manager_name' => 'nullable',
            'last_update' => [
                'date',
                'required',
                function ($attribute, $value, $fail) use ($id) {
                    if ($id) {
                        return;
                    }
                    $hospital_id = $this->guard()->user()->hospitalManager->id;
                    $exists = HospitalSituation::where('hospital_id', $hospital_id)
                        ->where('last_update', $value)->exists();
                    if ($exists) {
                        $fail("La {$value} a déjà une mise à jours");
                    }
                }
            ]
        ])->validate();
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('dashboard');
    }
}
