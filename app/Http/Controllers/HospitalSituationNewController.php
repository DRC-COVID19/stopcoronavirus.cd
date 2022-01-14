<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\HospitalSituationNew;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\HospitalSituationNewResource;
use Illuminate\Support\Facades\DB;

class HospitalSituationNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $hospitalSituation = HospitalSituationNew::where('hospital_id', $this->guard()->user()->hospitalManager->id)->orderBy('last_update', 'desc')->paginate(15);

            return HospitalSituationNewResource::collection($hospitalSituation);
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

            $hospitalSituationNew = HospitalSituationNew::create($data);

            return response()->json($hospitalSituationNew, 201, [], JSON_NUMERIC_CHECK);
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
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function show(HospitalSituationNew $hospitalSituationNew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HospitalSituationNew $hospitalSituationNew)
    {
        $data = $this->validator($request->all(), $hospitalSituationNew->id);
        try {
            $hospitalSituationNew->update(Arr::except($data, ['last_update', 'hospital_id']));
            return $hospitalSituationNew;
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
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalSituationNew $hospitalSituationNew)
    {
        //
    }

    function validator($data, $id = null)
    {
        return Validator::make($data, [
            "form_field_id" => 'nullable',
            "value" => 'nullable',
            'last_update' => [
                'date',
                'nullable',
                function ($attribute, $value, $fail) use ($id) {
                    if ($id) {
                        return;
                    }
                    $hospital_id = $this->guard()->user()->hospitalManager->id;
                    $exists = HospitalSituationNew::where('hospital_id', $hospital_id)
                        ->where('last_update', $value)->exists();
                    if ($exists) {
                        $fail("La {$value} a déjà une mise à jours");
                    }
                }
            ]
        ])->validate();
    }
    public function getSituationHospitalsAll()
    {
        $hospitalSituation = DB::table('hospital_situations_new')
            ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
            ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
            ->where('form_fields.name', '<>', 'EPI en manque')
            ->where('form_fields.name', '<>', 'Nom du CTCO de référence')
            ->select(
                'form_fields.name as form_field_name',
                DB::raw('sum(CAST(hospital_situations_new.value as INT)) as form_field_value'),
                'form_fields.capacity as form_field_capacity',
                'form_fields.form_step_id as form_step_id',
                'form_steps.title as form_step_title'
            )
            ->groupBy('form_step_id','form_step_title', 'form_field_name', 'form_field_capacity')
            ->get();
        return $hospitalSituation;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSituationByHospitals(Request $request)
    {

        $hospitalSituation = DB::table('hospital_situations_new')
            ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
            ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
            ->where('hospital_situations_new.hospital_id', '=', $request->hospital_id)
            ->select('hospitals.*', 'form_fields.name', 'hospital_situations_new.value')
            ->get();
        return $hospitalSituation;
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
