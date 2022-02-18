<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\HospitalSituation;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\HospitalSituationNew;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
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
            //$hospitalSituation = HospitalSituationNew::where('hospital_id', $this->guard()->user()->hospitalManager->id)->orderBy('last_update', 'desc')->paginate(15);
            $hospitalSituation = HospitalSituationNew::all();
            return $hospitalSituation;
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
            ->where('hospitals.id','=',intval($hospital_id))
            ->distinct('last_update')
            ->select(
                'hospital_situations_new.id',
                DB::raw('CAST(NOW() as DATE) - CAST(hospital_situations_new.created_at as DATE) as diff_date'),
                'hospital_situations_new.last_update as last_update',
                'hospital_situations_new.created_manager_name as name',
            )
            ->orderBy('last_update','desc')
            ->paginate($paginate);

            return response()->json($hospitalSituation,201,[],JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }

        
    }

    public function store(Request $request)
    {
        
        $data = $this->validator($request->all(), ['create' => 'required', 'update'=>'nullable']);
        try {
           // $data['hospital_id'] = $this->guard()->user()->hospitalManager->id;
            // Log::info('hospitalData',[$request->all()]);
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
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {  
        try {
            $hospitalSituation =  DB::table('hospital_situations_new')
            ->where('hospitals.id','=',intval($id))
            ->select(
                    'form_fields.name as form_field_name',
                    'form_fields.order_field as order_field ',
                    'form_field_types.name as form_field_type_name',
                    'hospital_situations_new.value as value',
                    'hospital_situations_new.last_update as last_update',
                    'hospital_situations_new.created_manager_name',
                    'hospital_situations_new.updated_manager_name',
                    'form_fields.capacity as form_field_capacity',
                    'form_fields.form_step_id as form_step_id',
                    'form_steps.title as form_step_title',
                    'form_fields.id as id'
            )
            ->orderBy('last_update','desc')->get();

            return response()->json($hospitalSituation,201,[],JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
        return response()->json($hospitalSituation);
    }
     /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function getSituationsByHospitalAndLastUpdate($last_update, int $hospital_id)
    {  
        try {
            $hospitalSituation =  DB::table('hospital_situations_new')
            ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
            ->join('form_field_types','form_fields.form_field_type_id','=','form_field_types.id')
            ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
            ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
            ->where('hospital_situations_new.last_update','=',$last_update)
            ->where('hospitals.id','=',intval($hospital_id))
            ->select(
                    'form_fields.name as name',
                    'form_fields.order_field as order_field ',
                    'form_field_types.name as form_field_type',
                    'hospital_situations_new.value as default_value',
                    'hospital_situations_new.last_update as last_update',
                    'hospital_situations_new.created_manager_name',
                    'hospital_situations_new.updated_manager_name',
                    'form_fields.capacity as form_field_capacity',
                    'form_fields.form_step_id as form_step_id',
                    'form_steps.title as form_step_title',
                    'form_fields.id as id'
            )
            ->orderBy('last_update','desc')->get();
            return response()->json($hospitalSituation,201,[],JSON_NUMERIC_CHECK);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
        return response()->json($hospitalSituation);
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hospital_id)
    {
        $data = $this->validator($request->all(), ['create' => 'nullable', 'update'=>'required']);
        try {
            $hospitalSituationNew= HospitalSituationNew::where(['last_update' => $data['last_update'],'hospital_id' => $hospital_id, 'form_field_id' => $data['form_field_id']])
                                            ->update($data);
                                         
             Log::info('hospitalData: ',[$request->all()]);
         
           // HospitalSituationNew::updated(Arr::except($data, ['last_update', 'hospital_id']));
            return $hospitalSituationNew;
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
            $situations=[];
            $hospitalIds = Hospital::all('id')
            ->pluck('id')
            ->unique()
            ->sort()
            ->values();
          //CAST(NOW() as DATE) - CAST(hospital_situations_new.created_at as DATE))

            foreach ($hospitalIds as $id) {

              $hospitalSituation = DB::table('hospital_situations_new')
                ->join('form_fields', 'hospital_situations_new.form_field_id', '=', 'form_fields.id')
                ->join('form_steps', 'form_fields.form_step_id', '=', 'form_steps.id')
                ->join('hospitals', 'hospital_situations_new.hospital_id', '=', 'hospitals.id')
                ->where('hospital_situations_new.hospital_id','=',intval($id))
                ->select(DB::raw('CAST(NOW() as DATE) - CAST(hospital_situations_new.created_at as DATE) as diff_date'),'hospital_situations_new.last_update','hospitals.id as hospital_id','hospitals.name', 'hospital_situations_new.created_manager_name')
                ->latest('last_update')
                ->first();

              if ($hospitalSituation === null) 
              {
                  $hospitalSituation = [
                    'diff_date' => -1,
                    'last_update' => null,
                    'hospital_id' =>$id,
                    'name' =>Hospital::where('id',$id)->select('name')->first()->name,
                    "created_manager_name" => null,
                  ];
                  array_push($situations, $hospitalSituation);
              }
              else
              {
                array_push($situations, $hospitalSituation);
              }
              
            }
            //$sortSituations =usort($situations,fn($a,$b)=> $b['last_update'] -$a['last_update']);

            return response()->json($situations,200,[],JSON_NUMERIC_CHECK);
          
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

    private function getUniquesLastUpdates(){
        $uniquesLastUpdates = HospitalSituationNew::all('last_update')
        ->pluck('last_update')
        ->unique()
        ->sort()
        ->values();
        return $uniquesLastUpdates;
    }
    function validator($data, ?array $updateRules=[])
    {
        return Validator::make($data, [
            "form_field_id" => 'required',
            "value" => 'required',
            'created_manager_name'  => $updateRules['create'], 
            'updated_manager_name'  => $updateRules['update'],
            'hospital_id'=>'required',
            'last_update' => 'required|date'
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
