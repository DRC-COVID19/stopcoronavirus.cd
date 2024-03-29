<?php

namespace App\Http\Controllers;

use App\Form;
use App\Hospital;
use App\HospitalLog;
use App\Administrator;
use App\HospitalSituation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\HospitalResources;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Http\Resources\AdministratorResource;

class HospitalController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $hospitals = Hospital::with(['agent', 'township'])->orderBy('name')->get();
    return response()->json($hospitals, 200);
  }

  public function allWithoutAgent()
  {
    $hospitals = Hospital::with(['agent', 'township'])->where('agent_id', null)->get();
    return response()->json($hospitals, 200);
  }

  public function indexByPaginate()
  {
    $hospitals = Hospital::with(['agent', 'township'])->orderBy('name')->paginate(15);
    return response()->json($hospitals, 200);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getHospitalList()
  {
    $hospitals = Hospital::orderBy('name')->get();
    return response()->json($hospitals, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreHospitalRequest $request)
  {
    $data = $request->validated();
    try {
      DB::beginTransaction();

      $hospital = Hospital::create($data);

      DB::commit();
      return response()->json($hospital, 201);
    } catch (\Throwable $th) {
      DB::rollBack();
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Hospital  $hospital
   * @return \Illuminate\Http\Response
   */
  public function show($hospital_id)
  {
    $formsAllVisibility = Form::with('formRecurrence')
      ->where('visible_all_hospitals', true)
      ->where('publish', true)
      ->get();

    $hospitalForms = Hospital::with([
      'forms' => function ($query) {
        $query->where('visible_all_hospitals', '<>', true)
          ->where('publish', true);
      },
      'forms.formRecurrence'
    ])
      ->find($hospital_id)
      ->forms
      ->filter(fn ($form) => $form->publish)
      ->merge($formsAllVisibility);

    $hospital = Hospital::find($hospital_id);
    $hospital->forms = $hospitalForms;

    return response()->json($hospital);
  }

  public function showDeep($hospital_id)
  {
    $formsAllVisibility = Form::with(
      [
        'formRecurrence',
        'completedForms' => function ($query) use ($hospital_id) {
          $query->select('id', 'created_manager_name', 'form_id', 'hospital_id', 'last_update', 'created_manager_first_name');
          $query->where('hospital_id', $hospital_id);
          $query->orderBy('last_update', 'desc');
        },
        'formSteps' => function ($query) {
          $query->select('id', 'form_id', 'title', 'step');
        },
        'formSteps.formFields' => function ($query) {
          $query->select('id', 'name', 'order_field', 'rules', 'form_step_id', 'default_value', 'form_field_type_id');
        },
        'formSteps.formFields.formFieldType' => function ($query) {
          $query->select('id', 'name');
        }
      ]
    )
      ->where('visible_all_hospitals', true)
      ->where('publish', true)
      ->get();

    $hospitalForms = Hospital::with([
      'forms' => function ($query) {
        $query->where('visible_all_hospitals', '<>', true)
          ->where('publish', true);
      },
      'forms.formRecurrence',
      'forms.completedForms' => function ($query)  use ($hospital_id) {
        $query->select('id', 'created_manager_name', 'form_id', 'hospital_id', 'last_update', 'created_manager_first_name');
        $query->where('hospital_id', $hospital_id);
        $query->orderBy('last_update', 'desc');
      },
      'forms.formSteps' => function ($query) {
        $query->select('id', 'form_id', 'title', 'step');
      },
      'forms.formSteps.formFields' => function ($query) {
        $query->select('id', 'name', 'order_field', 'rules', 'form_step_id', 'default_value', 'form_field_type_id');
      },
      'forms.formSteps.formFields.formFieldType' => function ($query) {
        $query->select('id', 'name');
      }
    ])
      ->find($hospital_id)
      ->forms
      ->merge($formsAllVisibility);

    $hospital = Hospital::find($hospital_id);
    $hospital->forms = $hospitalForms;

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
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Hospital  $hospital
   * @return \Illuminate\Http\Respo(nse
   */
  public function updateByAdmin(UpdateHospitalRequest $request, $id)
  {
    try {

      $data = $request->validated();
      $hospital = Hospital::find($id);
      if ($data['agent_id']) {
        $hospital->update(['agent_id' => $data['agent_id']]);
      } else if ($data['agent_id'] === null) {
        $hospital->update(['agent_id' => null]);
      }

      return response()->json($hospital, 201);
    } catch (\Throwable $th) {

      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Hospital  $hospital
   * @return \Illuminate\Http\Respo(nse
   */
  public function rejectAgent($id)
  {
    try {
      $hospital = Hospital::find($id);
      if (!$hospital) {
        return response()->json([], 404);
      }
      $hospital->update(['agent_id' => null]);
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
  public function destroy($hospital_id)
  {
    try {
      $hospitalDeleted = Hospital::destroy($hospital_id);

      return response()->json($hospitalDeleted, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getAgents()
  {
    try {

      $users = AdministratorResource::collection(Administrator::with(['hospitalManager', 'roles'])->get());
      return response()->json($users, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
  public function getHospitals(Request $request)
  {
    try {
      $hospitalsCompletedFormsData = CompletedFormController::getHospitalsCompletedFormsData($request)['hospitalsData'];
      foreach ($hospitalsCompletedFormsData as $index => $hospitalCompletedFormsData) {
        $hospitalsCompletedFormsData[$index]->aggregated = CompletedFormController::getAggregatedHospitalsDatas([$hospitalCompletedFormsData]);
        $hospitalsCompletedFormsData[$index]->last_update = collect($hospitalCompletedFormsData->completedForms)->max('last_update');
      }
      return response()->json($hospitalsCompletedFormsData, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
  public function filter(Request $request)
  {
    try {
      $key_words = $request->get('key_words');
      $forms = Hospital::where('name', 'LIKE', "%{$key_words}%")->orWhere('name', 'LIKE', "%{$key_words}%")->paginate(15);
      if (!$forms) {
        return response()->json(['message' => "Au hopital trouvé!"], 404);
      }
      return response()->json($forms, 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  private function getHospitalsFromFiltre($date_start, $date_end, $township)
  {
    $hospitalLogs = HospitalLog::where(function ($query) use ($date_start, $date_end) {
      $query
        ->whereRaw('DATE(updated_at) BETWEEN ? AND ?', [$date_start, $date_end])
        ->orWhereNull('updated_at');
    })
      ->where(function ($query) use ($township) {
        if ($township) $query->where('township_id', $township);
      })
      ->orderBy('updated_at', 'desc')
      ->get();

    $hospitals = Hospital::where(function ($query) use ($date_start, $date_end) {
      $query
        ->whereRaw('DATE(updated_at) BETWEEN ? AND ?', [$date_start, $date_end])
        ->orWhereNull('updated_at');
    })
      ->where(function ($query) use ($township) {
        if ($township) $query->where('township_id', $township);
      })
      ->orderBy('updated_at', 'desc')
      ->get();

    $hospitals =
      $hospitals->concat($hospitalLogs)->sortByDesc('updated_at')->values();

    $hospitals = $hospitals->map(function ($item, $key) {
      if (!$item->hospital_id) {
        $item->hospital_id = $item->id;
      }
      return $item;
    });

    $hospitalsFiltred = $hospitals->unique('hospital_id')->values();
    return $hospitalsFiltred;
  }

  public function getHospitalsTotaux(Request $request)
  {
    try {
      $observation_end = $request->query('observation_end');
      $observation_start = $request->query('observation_start');
      $township = $request->query('township');

      $hospitalsFiltred = $this->getHospitalsFromFiltre($observation_start, $observation_end, $township);

      $hospitals = collect([
        'beds' => $hospitalsFiltred->sum('beds'),
        'respirators' => $hospitalsFiltred->sum('respirators'),
        'foam_beds' => $hospitalsFiltred->sum('foam_beds'),
        'resuscitation_beds' => $hospitalsFiltred->sum('resuscitation_beds'),
        'doctors' => $hospitalsFiltred->sum('doctors'),
        'nurses' => $hospitalsFiltred->sum('nurses'),
        'para_medicals' => $hospitalsFiltred->sum('para_medicals'),
      ]);

      $hospitalsSituation1 = Hospital::where(function ($query) use ($township) {
        if ($township) $query->whereRaw('township_id = :township ', ['township' => $township]);
      })
        ->selectRaw(
          '
                SUM(
                    (SELECT occupied_foam_beds FROM hospital_situations
                      WHERE hospital_id = hospitals.id AND
                      DATE(last_update) BETWEEN DATE(:date_start1) AND DATE(:date_end1)
                      ORDER BY last_update DESC LIMIT 1)
                ) AS occupied_foam_beds ,
                SUM(
                    (SELECT occupied_resuscitation_beds FROM hospital_situations
                    WHERE hospital_id = hospitals.id AND
                    DATE(last_update) BETWEEN DATE(:date_start2) AND DATE(:date_end2)
                    ORDER BY last_update DESC LIMIT 1)
                ) AS occupied_resuscitation_beds ,
                SUM(
                    (SELECT occupied_respirators FROM hospital_situations
                    WHERE hospital_id = hospitals.id AND
                    DATE(last_update) BETWEEN DATE(:date_start3) AND DATE(:date_end3)
                    ORDER BY last_update DESC LIMIT 1)
                ) AS occupied_respirators ,
                SUM(
                    (SELECT resuscitation_ventilator FROM hospital_situations
                    WHERE hospital_id = hospitals.id AND
                    DATE(last_update) BETWEEN DATE(:date_start4) AND DATE(:date_end4)
                    ORDER BY last_update DESC LIMIT 1)
                ) AS resuscitation_ventilator ,
                SUM(
                    (SELECT oxygenator FROM hospital_situations
                    WHERE hospital_id = hospitals.id AND
                    DATE(last_update) BETWEEN DATE(:date_start5) AND DATE(:date_end5)
                    ORDER BY last_update DESC LIMIT 1)
                ) AS oxygenator
                ',
          [
            'date_start1' => $observation_start, 'date_end1' => $observation_end,
            'date_start2' => $observation_start, 'date_end2' => $observation_end,
            'date_start3' => $observation_start, 'date_end3' => $observation_end,
            'date_start4' => $observation_start, 'date_end4' => $observation_end,
            'date_start5' => $observation_start, 'date_end5' => $observation_end
          ]
        )
        ->first();

      $hospitalsSituation2 = HospitalSituation::whereRaw('DATE(last_update) BETWEEN ? AND ?', [$observation_start, $observation_end])
        ->where(function ($query) use ($township) {
          if ($township)
            $query->whereRaw(
              '(SELECT township_id FROM hospitals WHERE id = hospital_id) = ?',
              [$township]
            );
        })
        ->selectRaw(
          'SUM(confirmed) as confirmed, SUM(healed) as healed, SUM(dead) as dead, SUM(sick) as sick'
        )
        ->first();

      $results = $hospitals->merge($hospitalsSituation1)->merge($hospitalsSituation2);

      return response()->json($results, 200, [], JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHospitalEvolution($hospital = null, Request $request)
  {
    try {

      $observation_end = $request->query('observation_end');
      $observation_start = $request->query('observation_start');
      $township = $request->query('township');

      // On réccupère toutes les dates où une mise à jour a pu etre poster
      // Surtout utile pour l'evolution globale

      $last_updates = HospitalSituation::where(function ($query) use ($hospital, $township) {
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
        'occupied_respirators' => [],
        'occupied_resuscitation_beds' => [],
        'respirators' => [],
        'resuscitation_beds' => []
      ];

      // A une date donné, on réccupera pour chaque hopital sa dernière situation
      // Dans le but d'en faire la somme pour chacune d'elle dans le cas du rapport
      // pour la situation globale
      foreach ($last_updates as $last_update) {

        $hospitalSituation = HospitalSituation::where(function ($query) use ($hospital, $township) {
          if ($hospital) {
            $query->where('hospital_id', intval($hospital));
          } else if ($township) {
            $query->whereRaw(
              '(SELECT township_id FROM hospitals WHERE id = hospital_id) = ?',
              [$township]
            );
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
                  ) AS respirators,agent
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
              '
        )
          ->where('last_update', '<=', $last_update)
          ->whereRaw('DATE(last_update) BETWEEN ? AND ?', [$observation_start, $observation_end])
          ->whereNotExists(function ($query) use ($last_update) {
            // C'est ici qu'on s'assure que la situation actuellemnent lu est la dernière connu
            // pour l'hopital x à la date $last_update sur laquelle on boucle
            $query->select(DB::raw(1))
              ->from(DB::raw('hospital_situations AS h'))
              ->whereRaw("h.hospital_id = hospital_situations.hospital_id
                      AND h.last_update <='{$last_update}'
                      AND (
                        h.last_update > hospital_situations.last_update OR
                        (h.last_update = hospital_situations.last_update AND h.id > hospital_situations.id )
                      )
                    ");
          })
          ->first();

        $results['last_update'][] = $last_update;
        $results['occupied_respirators'][] = $hospitalSituation->occupied_respirators;
        $results['occupied_resuscitation_beds'][] = $hospitalSituation->occupied_resuscitation_beds;
        $results['respirators'][] = $hospitalSituation->respirators;
        $results['resuscitation_beds'][] = $hospitalSituation->resuscitation_beds;
      }

      return response()->json($results, 200, [], JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
  public function getHospitalByForm()
  {

    try {
      $townships = Hospital::with(['township' => function ($query) {
        $query->select('id', 'name')
          ->orderBy('name');
      }])->whereHas('completedForms')->select('id', 'name', 'township_id')->get();
      return response()->json($townships);
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
