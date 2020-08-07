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
            // On réccupère toutes les dates où une mise à jour a pu etre poster
            // Surtout utile pour l'evolution globale

            $last_updates = HospitalSituation::where(function ($query) use ($hospital) {
              if ($hospital) $query->where('hospital_id', intval($hospital));
            })
            ->select('last_update')
            ->pluck('last_update')
            ->unique()->sort()->values() ;

            $results = [
              'last_update' => [],
              'occupied_respirators' => [],
              'occupied_resuscitation_beds' => [],
              'respirators' => [],
              'resuscitation_beds' => []
            ];

            // A une date donné, on réccupera pour chaque hopital sa dernière situation
            // Dans le but d'en faire la somme pour chacune d'elle dans le cas du rapport
            // pour la situation globale
            foreach ($last_updates as $last_update) {

              $hospitalSituation = HospitalSituation::where(function ($query) use ($hospital) {
                  if ($hospital){
                      $query->where('hospital_id', intval($hospital));
                  }
              })->selectRaw(
                ' SUM(occupied_respirators) AS occupied_respirators,
                  SUM(occupied_resuscitation_beds) AS occupied_resuscitation_beds,
                  SUM(
                    (SELECT respirators FROM
                      (SELECT id, updated_at, respirators from hospitals
                        UNION
                        SELECT hospital_id AS id, updated_at, respirators from hospital_logs
                      ) AS a
                      WHERE a.id = hospital_id AND a.respirators IS NOT NULL
                      ORDER BY(a.updated_at <= last_update) DESC , a.updated_at DESC
                      LIMIT 1
                    )
                  ) AS respirators,
                  SUM(
                    (SELECT resuscitation_beds FROM
                      (SELECT id, updated_at, resuscitation_beds from hospitals
                        UNION
                        SELECT hospital_id AS id, updated_at, resuscitation_beds from hospital_logs
                        WHERE respirators IS NOT NULL
                      ) AS a
                      WHERE a.id = hospital_id AND a.resuscitation_beds IS NOT NULL
                      ORDER BY(a.updated_at <= last_update) DESC , a.updated_at DESC
                      LIMIT 1
                    )
                  ) AS resuscitation_beds
              ')
              ->where('last_update' , '<=' , $last_update)
              ->whereNotExists(function($query) use($last_update){
                  // C'est ici qu'on s'assure que la situation actuellemnent lu est la dernière connu
                  // pour l'hopital x à la date $last_update sur laquelle on boucle
                  $query->select(DB::raw(1))
                  ->from(DB::raw('hospital_situations AS h'))
                  ->whereRaw('h.hospital_id = hospital_situations.hospital_id
                      AND h.last_update <= "' . $last_update . '"
                      AND (
                        h.last_update > hospital_situations.last_update OR
                        (h.last_update = hospital_situations.last_update AND h.id > hospital_situations.id )
                      )
                    ') ;
              })
              ->first();

              $results['last_update'][] = $last_update ;
              $results['occupied_respirators'][] = $hospitalSituation->occupied_respirators;
              $results['occupied_resuscitation_beds'][] = $hospitalSituation->occupied_resuscitation_beds;
              $results['respirators'][] = $hospitalSituation->respirators;
              $results['resuscitation_beds'][] = $hospitalSituation->resuscitation_beds;

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
