<?php

namespace App\Http\Controllers;

use App\HospitalSituation;
use App\Http\Resources\HospitalResources;
use App\Http\Resources\HospitalSituationResource;
use App\Http\Resources\HospitalSituationSingleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        return response()->json(HospitalSituationResource::make($hospitalSituation));
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
        //
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

    function validator($data)
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
            'last_update' => 'date|required'
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
