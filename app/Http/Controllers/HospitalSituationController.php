<?php

namespace App\Http\Controllers;

use App\HospitalSituation;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\HospitalSituationNew;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\HospitalResources;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\HospitalSituationResource;
use App\Http\Resources\HospitalSituationSingleResource;

class HospitalSituationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $hospitalSituation = HospitalSituation::where('hospital_id', $this->guard()->user()->hospitalManager->id)->orderBy('last_update', 'desc')->paginate(15);
            return HospitalSituationSingleResource::collection($hospitalSituation);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }

    }

    public function indexByHospital(int $hospital_id, ?int $page = 1,int $paginate = 15)
    {
        try {
            $hospitalSituation =  DB::table('hospital_situations_new')
            ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
            ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
            ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
            ->where('form_fields.name', '=', 'Nombre des cas confirmés')
            ->where('hospitals.id','=',intval($hospital_id))
            ->select('hospitals.id as hospital_id',
                'hospital_situations_new.last_update as last_update',
                DB::raw('SUM(CAST(hospital_situations_new.value as INT)) as confirmed'),
            )
            ->groupBy('hospitals.id','last_update')
            ->orderBy('last_update','desc')->paginate($paginate);

            return response()->json($hospitalSituation,201,[],JSON_NUMERIC_CHECK);
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
        $data = $this->validator($request->all());
        try {
            $data['hospital_id'] = $this->guard()->user()->hospitalManager->id;
            $hospitalSituation = HospitalSituation::create($data);
            return response()->json($hospitalSituation,201,[],JSON_NUMERIC_CHECK);
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
            $hospitalSituation = DB::table('hospital_situations_new')
            ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
            ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
            ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
            ->where('form_fields.name', '=', 'Nombre des cas confirmés')
            ->select('hospitals.name','hospitals.id as hospital_id',
                DB::raw('MAX(CAST(hospital_situations_new.last_update as DATE)) as last_update'),
                DB::raw('SUM(CAST(hospital_situations_new.value as INT)) as confirmed'),
            )
            ->groupBy('hospitals.name','hospitals.id')
            ->orderBy('last_update','desc')
            ->get();
            return response()->json($hospitalSituation,200,[],JSON_NUMERIC_CHECK);
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
