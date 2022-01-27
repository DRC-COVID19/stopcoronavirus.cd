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
           // $data['hospital_id'] = $this->guard()->user()->hospitalManager->id;

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
        // $observation_end = '2022-01-18';
        // $observation_start = '2022-01-14';
        // $township = '1';
        // $hospital = '2';
       
        try {
            // On réccupère toutes les dates où une mise à jour a pu etre poster
            // Surtout utile pour l'evolution globale

            $lastUpdates = HospitalSituationNew::where(function ($query) use ($hospital, $township) {
                if ($hospital) {
                    $query->where('hospital_id', intval($hospital));
                } else if ($township) {
                    $query->whereRaw(
                        '(SELECT township_id FROM hospitals WHERE id = hospital_id) = ?',
                        [$township]
                    );
                }
            })
                ->whereRaw('DATE(last_update) BETWEEN ? AND ? ', [$observation_start, $observation_end])
                ->select('last_update')
                ->pluck('last_update')
                ->unique()->sort()->values();

            $results = [
                'last_update' => [],
                'form_fields_names' => [],
            ];
            foreach ($lastUpdates as  $lastUpdate) {
                $hospitalSituation = HospitalSituationNew::where(function ($query) use ($hospital, $township) {
                    if ($hospital) {
                        $query->where('hospital_id', intval($hospital));
                    } else if ($township) {
                        $query->whereRaw(
                            '(SELECT township_id FROM hospitals WHERE id = hospital_id) = ?',
                            [$township]
                        );
                    }
                })
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
            ->where('last_update' , '<=' , $lastUpdate)
            ->whereRaw('DATE(last_update) BETWEEN ? AND ?', [$observation_start, $observation_end])
            ->whereNotExists(function($query) use($lastUpdate){
                // C'est ici qu'on s'assure que la situation actuellemnent lu est la dernière connu
                // pour l'hopital x à la date $last_update sur laquelle on boucle
                $query->select(DB::raw(1))
                ->from(DB::raw('hospital_situations_new AS h'))
                ->whereRaw("h.hospital_id = hospital_situations_new.hospital_id
                    AND h.last_update <='{$lastUpdate}'
                    AND (
                      h.last_update > hospital_situations_new.last_update OR
                      (h.last_update = hospital_situations_new.last_update AND h.id > hospital_situations_new.id )
                    )
                  ");
                    })
                    ->groupBy('form_step_id', 'form_step_title', 'form_field_name', 'form_field_capacity')
                    ->get();


                $results['last_update'][] = $lastUpdate;
                $results['form_fields_names'][] = $hospitalSituation;
            }

            return response()->json($results, 200, [], JSON_NUMERIC_CHECK);
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