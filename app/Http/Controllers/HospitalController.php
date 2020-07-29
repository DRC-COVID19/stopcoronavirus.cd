<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\HospitalSituation;
use App\Http\Resources\HospitalResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        return response()->json($hospital);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validator($request->all());

        try {
            $hospital = Hospital::find($id);
            if (!$hospital) {
                return response()->json([], 404);
            }
            $hospital->update($data);
            return response()->json($hospital, 201);
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
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        //
    }

    public function getHospials()
    {
        try {
            $hospitals = HospitalResources::collection(Hospital::get());
            return response()->json($hospitals);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getHospitalsTotaux()
    {
        try {
            $hospitals = Hospital::selectRaw(
                'SUM(beds) AS beds , SUM(respirators) AS respirators, SUM(foam_beds) AS foam_beds ,
                 SUM(resuscitation_beds) AS resuscitation_beds, SUM(doctors) AS doctors, SUM(nurses) AS nurses ,
                 SUM(para_medicals) AS para_medicals,

                 SUM(
                     (SELECT occupied_foam_beds FROM hospital_situations
                      WHERE hospital_id = hospitals.id ORDER BY last_update LIMIT 1)
                 ) AS occupied_foam_beds ,
                 SUM(
                    (SELECT occupied_resuscitation_beds FROM hospital_situations
                     WHERE hospital_id = hospitals.id ORDER BY last_update LIMIT 1)
                 ) AS occupied_resuscitation_beds ,
                 SUM(
                    (SELECT occupied_respirators FROM hospital_situations
                     WHERE hospital_id = hospitals.id ORDER BY last_update LIMIT 1)
                 ) AS occupied_respirators ,
                 SUM(
                    (SELECT resuscitation_ventilator FROM hospital_situations
                     WHERE hospital_id = hospitals.id ORDER BY last_update LIMIT 1)
                 ) AS resuscitation_ventilator ,
                 SUM(
                    (SELECT oxygenator FROM hospital_situations
                     WHERE hospital_id = hospitals.id ORDER BY last_update LIMIT 1)
                 ) AS oxygenator
                '
            )->first();


            $hospitalsSituation = HospitalSituation::selectRaw(
                'SUM(confirmed) as confirmed, SUM(healed) as healed, SUM(dead) as dead'
            )->first();

            $results = array_merge($hospitals->toArray(), $hospitalsSituation->toArray());

            return response()->json($results);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function getHospitalEvolution($hospital = null)
    {
        try {
            $hospitalSituations = HospitalSituation::where(function ($query) use ($hospital) {
                if ($hospital){
                    $query->where('hospital_id', intval($hospital));
                }
            })->select([
                'last_update', 'occupied_respirators', 'occupied_resuscitation_beds',
                DB::raw(
                    '(occupied_respirators * 100 /
                            (SELECT respirators FROM
                                (SELECT id, updated_at, respirators from hospitals
                                    UNION
                                    SELECT hospital_id AS id, updated_at, respirators from hospital_logs
                                ) AS a
                                WHERE a.id = hospital_id
                                ORDER BY(a.updated_at <= last_update) DESC , a.updated_at DESC
                                LIMIT 1
                            )
                        ) AS taux_respirators'
                ),
                DB::raw(
                    '(occupied_resuscitation_beds * 100 /
                            (SELECT resuscitation_beds FROM
                                (SELECT id, updated_at, resuscitation_beds from hospitals
                                    UNION
                                    SELECT hospital_id AS id, updated_at, resuscitation_beds from hospital_logs
                                ) AS a
                                WHERE a.id = hospital_id
                                ORDER BY(a.updated_at <= last_update) DESC , a.updated_at DESC
                                LIMIT 1
                            )
                        ) AS taux_resuscitation_beds'
                )
            ])
                ->orderBy('last_update')
                ->get();

            $results = [
                'last_update' => [],
                'occupied_respirators' => [],
                'occupied_resuscitation_beds' => [],
                'taux_respirators' => [],
                'taux_resuscitation_beds' => []
            ];
            foreach ($hospitalSituations as $data) {
                $results['last_update'][] = $data->last_update;
                $results['occupied_respirators'][] = $data->occupied_respirators;
                $results['occupied_resuscitation_beds'][] = $data->occupied_resuscitation_beds;
                $results['taux_respirators'][] = $data->taux_respirators;
                $results['taux_resuscitation_beds'][] = $data->taux_resuscitation_beds;
            }
            return response()->json($results);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    public function validator($data, $id = null)
    {
        return Validator::make($data, [
            'name' => 'required',
            'address' => 'required',
            'foam_beds' => 'numeric|required',
            'resuscitation_beds' => 'numeric|required',
            'respirators' => 'numeric|required',
            'doctors' => 'numeric|required',
            'nurses' => 'numeric|required',
            'para_medicals' => 'numeric|required'
        ])->validate();
    }
}
