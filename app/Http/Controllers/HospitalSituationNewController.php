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

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSituationHospitalsAll()
    {
        try {
            $results['formFieldsFiltered'] = [];
            $results['allFormFields'] = [];
            $hospitalSituation = DB::table('hospital_situations_new')
                ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                ->where('form_fields.name', '<>', 'EPI en manque')
                ->where('form_fields.name', '<>', 'Nom du CTCO de référence')
                ->select(
                    'form_fields.name as form_field_name',
                    DB::raw('SUM(CAST(hospital_situations_new.value as INT)) as form_field_value'),
                    'form_fields.capacity as form_field_capacity',
                    'form_fields.form_step_id as form_step_id',
                    'form_steps.title as form_step_title'
                )
                ->groupBy('form_step_id', 'form_step_title', 'form_field_name', 'form_field_capacity')
                ->get();

            $formFieldsFiltered = DB::table('hospital_situations_new')
                ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                ->where('form_fields.name', '=', 'Nombre des cures de vitamine C disponible')
                ->orWhere('form_fields.name', '=', 'Nombre des ventilateurs de réanimation occupés par des cas COVID-19')
                ->where('form_fields.name', '<>', 'EPI en manque')
                ->where('form_fields.name', '<>', 'Nom du CTCO de référence')
                ->select(
                    'form_fields.name as form_field_name',
                    'hospital_situations_new.value as form_field_value',
                    'hospital_situations_new.last_update as last_update',
                    'form_fields.capacity as form_field_capacity',
                    'form_fields.form_step_id as form_step_id',
                    'form_steps.title as form_step_title',
                    'form_fields.id as form_field_id'
                )
                ->orderBy('last_update', 'asc')
                // ->groupBy('form_field_id','form_field_name','form_field_value','hospital_situations_new.last_update','form_field_capacity','form_step_id','form_step_title')
                ->get();

            $results['formFieldsFiltered'] = $formFieldsFiltered;
            $results['allFormFields'] = $hospitalSituation;

            return response()->json($results, 200, [], JSON_NUMERIC_CHECK);
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

    public function getSituationsByHospital(Request $request)
    {
        try {

            $hospitalSituation = DB::table('hospital_situations_new')
                ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                ->where('hospital_situations_new.hospital_id', '=', $request->query('hospital_id'))
                ->where('form_fields.name', '<>', 'EPI en manque')
                ->where('form_fields.name', '<>', 'Nom du CTCO de référence')
                ->select(
                    'form_fields.name as form_field_name',
                    DB::raw('SUM(CAST(hospital_situations_new.value as INT)) as form_field_value'),
                    'form_fields.capacity as form_field_capacity',
                    'form_fields.form_step_id as form_step_id',
                    'form_steps.title as form_step_title'
                )
                ->groupBy('form_step_id', 'form_step_title', 'form_field_name', 'form_field_capacity')
                ->get();


            return response()->json($hospitalSituation, 200, [], JSON_NUMERIC_CHECK);
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
    public function getSituations(Request $request)
    {

        $observation_end = $request->input('observation_end');
        $observation_start = $request->input('observation_start');
        $township = $request->input('township');
        $hospital = $request->input('hospital');

        try {
            // On réccupère toutes les dates où une mise à jour a pu etre poster
            // Surtout utile pour l'evolution globale
            if ($observation_start == null) {

                $observation_start = DB::table('hospital_situations_new')
                    ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                    ->where(function ($query) use ($township, $hospital) {
                        if ($hospital) {
                            $query->where('hospital_situations_new.hospital_id', '=', $hospital);
                        } else {
                            $query->where('hospitals.township_id', '=', $township);
                        }
                    })
                    ->min('hospital_situations_new.last_update');

                $hospitalSituation = DB::table('hospital_situations_new')
                    ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                    ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                    ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                    ->join('townships', 'townships.id', '=', 'hospitals.township_id')
                    ->whereBetween('hospital_situations_new.last_update', [$observation_start, $observation_end])
                    ->where('form_fields.name', '<>', 'EPI en manque')
                    ->where('form_fields.name', '<>', 'Nom du CTCO de référence')
                    ->where(function ($query) use ($township, $hospital) {
                        if ($hospital) {
                            $query->where('hospital_situations_new.hospital_id', '=', $hospital);
                        } else {
                            $query->where('hospitals.township_id', '=', $township);
                        }
                    })
                    ->select(
                        'form_fields.name as form_field_name',
                        DB::raw('SUM(CAST(hospital_situations_new.value as INT)) as form_field_value'),
                        'form_fields.capacity as form_field_capacity',
                        'form_fields.form_step_id as form_step_id',
                        'form_steps.title as form_step_title'
                    )
                    ->groupBy('form_step_id', 'form_step_title', 'form_field_name', 'form_field_capacity')
                    ->get();
            } else if ($observation_end == $observation_start) {
                $hospitalSituation = DB::table('hospital_situations_new')
                    ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                    ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                    ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                    ->join('townships', 'townships.id', '=', 'hospitals.township_id')
                    ->whereDate('hospital_situations_new.last_update',  $observation_end)
                    ->where(function ($query) use ($township, $hospital) {
                        if ($hospital) {
                            $query->where('hospital_situations_new.hospital_id', '=', $hospital);
                        } else {
                            $query->where('hospitals.township_id', '=', $township);
                        }
                    })
                    ->select(
                        'form_fields.name as form_field_name',
                        'hospital_situations_new.value as form_field_value',
                        'form_fields.capacity as form_field_capacity',
                        'form_fields.form_step_id as form_step_id',
                        'form_steps.title as form_step_title'
                    )
                    ->get();
            } else if ($observation_end !== $observation_start) {

                $situationAgregged = DB::table('hospital_situations_new')
                    ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                    ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                    ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                    ->join('townships', 'townships.id', '=', 'hospitals.township_id')
                    ->whereBetween('hospital_situations_new.last_update', [$observation_start, $observation_end])
                    ->where(function ($query) use ($township, $hospital) {
                        if ($hospital) {
                            $query->where('hospital_situations_new.hospital_id', '=', $hospital);
                        } else {
                            $query->where('hospitals.township_id', '=', $township);
                        }
                    })
                    ->where('form_fields.name', '<>', 'EPI en manque')
                    ->where('form_fields.name', '<>', 'Nom du CTCO de référence')
                    ->where('form_fields.agreggation', true)
                    ->select(
                        'form_fields.name as form_field_name',
                        DB::raw('SUM(CAST(hospital_situations_new.value as INT)) as form_field_value'),
                        'form_fields.capacity as form_field_capacity',
                        'form_fields.form_step_id as form_step_id',
                        'form_steps.title as form_step_title'
                    )
                    ->groupBy('form_step_id', 'form_step_title', 'form_field_name', 'form_field_capacity')
                    ->get()->toArray();

                $situationNotAgregged = DB::table('hospital_situations_new')
                    ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                    ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                    ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                    ->join('townships', 'townships.id', '=', 'hospitals.township_id')
                    ->whereDate('hospital_situations_new.last_update',  $observation_end)
                    ->where(function ($query) use ($township, $hospital) {
                        if ($hospital) {
                            $query->where('hospital_situations_new.hospital_id', '=', $hospital);
                        } else {
                            $query->where('hospitals.township_id', '=', $township);
                        }
                    })
                    ->where('form_fields.agreggation', false)
                    ->select(
                        'form_fields.name as form_field_name',
                        'hospital_situations_new.value as form_field_value',
                        'form_fields.capacity as form_field_capacity',
                        'form_fields.form_step_id as form_step_id',
                        'form_steps.title as form_step_title'
                    )
                    ->get()->toArray();
                $hospitalSituation = [...$situationAgregged, ...$situationNotAgregged];
            }


            $results = [
                'form_fields_names' => $hospitalSituation,
            ];

            return response()->json($results, 200, [], JSON_NUMERIC_CHECK);
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
    public function getObservationSituationHospital(Request $request)
    {
        $observation_end = $request->input('observation_end');
        $observation_start = $request->input('observation_start');
        $township = $request->input('township');

        try {
            $observation = DB::table('hospital_situations_new')
                ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                ->join('admin_user_hospital', 'admin_user_hospital.hospital_id', '=', 'hospitals.id')
                ->join('admin_users', 'admin_user_hospital.admin_user_id', '=', 'admin_users.id')
                ->join('townships', 'townships.id', '=', 'hospitals.township_id')
                ->select(
                    'form_fields.name as form_field_name',
                    'hospital_situations_new.value as form_field_value',
                    'hospitals.id as hospital_id',
                    'hospitals.name as hospital_name',
                    'hospital_situations_new.last_update as date',
                    'admin_users.username as phone_number'
                )
                ->whereBetween('hospital_situations_new.last_update', [$observation_start, $observation_end])
                ->where(function ($query) use ($township) {
                    if ($township) $query->where('hospitals.township_id', '=', $township);
                })
                ->orderBy('date', 'desc')

                // ->groupBy('form_fields.name', 'hospital_situations_new.value', 'hospitals.id', 'hospital_situations_new.name', '')
                ->get();

            return response()->json($observation, 200, [], JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
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
