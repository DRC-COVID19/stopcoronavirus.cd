<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\CompletedForm;
use App\FormFieldType;
use App\CompletedFormField;
use Illuminate\Http\Request;
use function PHPSTORM_META\map;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


use App\Http\Requests\StoreCompletedFormRequest;
use App\Http\Requests\UpdateCompletedFormRequest;

class CompletedFormController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:dashboard')->except(['show', 'getAggregatedByHospitals', 'getDataByHospitals']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function indexByHospital(int $hospital_id, int $paginate = 15)
    {
        try {
            $completedForms = CompletedForm::where('hospital_id', '=', intval($hospital_id));
            $completedForms = $this->selectCompletedForms($completedForms)
                ->distinct('last_update')
                ->orderBy('last_update', 'desc')
                ->paginate($paginate);

            return response()->json($completedForms, 206);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
    public function getLatestHospitalUpdate(Request $request)
    {
        $formId = $request->query('form_id');
        try {
            $hospitals = Hospital::with(['completedForms' => function ($query) use($formId)  {
                if ($formId) {
                  $query->where('form_id', $formId);
                }
                $query
                  ->select('*')
                  ->selectRaw('CAST(NOW() as DATE) - (last_update) as diff_date')
                  ->orderBy('last_update', 'desc');
              },
              'completedForms.form'])
            ->get();

            $hospitalsSanitized = $hospitals->map(function ($hospital) {
                if (sizeof($hospital->completedForms) > 0) {
                  $hospital['diff_date'] = $hospital->completedForms[0]->diff_date ;
                  $hospital['last_update'] = $hospital->completedForms[0]->last_update ;
                  $hospital['created_manager_name'] = $hospital->completedForms[0]->created_manager_name ;
                  $hospital['created_manager_first_name'] = $hospital->completedForms[0]->created_manager_first_name ;
                } else {
                  $hospital['diff_date'] = -1 ;
                  $hospital['last_update'] = null ;
                }
                return $hospital;
            });

            return response()->json($hospitalsSanitized, 200, [], JSON_NUMERIC_CHECK);
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
    public function store(StoreCompletedFormRequest $request)
    {
        try {

            $admin_user =  $this->guard()->user();
            $completedForm = CompletedForm::create(array_merge(
                $request->validated(),
                ['admin_user_id' => $admin_user->id]
            ));


            $completedFormFields = $request['completed_form_fields'];

            foreach ($completedFormFields as $formFieldKey => $formFieldValue) {
                CompletedFormField::create([
                    'form_field_id'     => $formFieldKey,
                    'value'             => $formFieldValue,
                    'completed_form_id' => $completedForm->id
                ]);
            }
            return response()->json($completedForm, 200, []);
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
     * @param  \App\CompletedForm  $completedForm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $completedForm = CompletedFormField::with('completedForm', 'formField.formStep')
                ->where('completed_form_id', $id)
                ->orderBy('created_at')
                ->get();

            return response()->json($completedForm, 206);
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
     * @param  \App\CompletedForm  $completedForm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompletedFormRequest $request, CompletedForm $completedForm)
    {
        try {
            $data = $request->validated();
            $updatedManagerName = $data['updated_manager_name'];
            $updatedManagerFirstName = $data['updated_manager_first_name'];
            $completedFormFields = $data['completed_form_fields'];

            foreach ($completedFormFields as $formFieldKey => $formFieldValue) {

                $completedFormField = CompletedFormField::where(['completed_form_id' => $completedForm->id, 'form_field_id' => $formFieldKey])->first();
                if ($completedFormField && $completedFormField->value !== $formFieldValue) {
                    $completedFormField->update([
                        'value'                 => $formFieldValue,
                        'updated_manager_name'  => $updatedManagerName,
                        'updated_manager_first_name'  => $updatedManagerFirstName
                    ]);
                } else if (!$completedFormField) {
                    CompletedFormField::create([
                        'form_field_id'          => $formFieldKey,
                        'value'                 => $formFieldValue,
                        'completed_form_id'     => $completedForm->id,
                        'updated_manager_name'  => $updatedManagerName,
                        'updated_manager_first_name'  => $updatedManagerFirstName

                    ]);
                }
            }
            return response()->json($completedForm, 200, []);
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
     * @param  \App\CompletedForm  $completedForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompletedForm $completedForm)
    {
        //
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

    private function selectCompletedForms($completedForm)
    {
        return $completedForm
            ->with([
                'completedFormFields.formField.formStep',
                'completedFormFields.formField.formFieldType',
                'hospital'
            ])
            ->select('*')
            ->selectRaw('CAST(NOW() as DATE) - (last_update) as diff_date');
    }


    private function arrayMapAndSort($completedForm)
    {
        return $completedForm
            ->map(function ($form) {
                return
                    $form->completedFormFields
                    ->sort(function ($a, $b) {
                        return $a->order_field - $b->order_field;
                    });
            })[0];
    }


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompletedForm  $completedForm
     * @return \Illuminate\Http\Response
     */

    public function getAggregatedByHospitals(Request $request)
    {

        $hospitalsCompletedFormsData = self::getHospitalsCompletedFormsData($request);


        return response()->json([
            'aggregated'  => self::getAggregatedHospitalsDatas($hospitalsCompletedFormsData['hospitalsData']),
            'last_update' => $hospitalsCompletedFormsData['lastUpdate']
        ], 200);
    }
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompletedForm  $completedForm
     * @return \Illuminate\Http\Response
     */
    public function getDataByHospitals(Request $request)
    {

        $hospitalsCompletedFormsData = self::getHospitalsCompletedFormsData($request);

        return response()->json([
            'data'        => $hospitalsCompletedFormsData['hospitalsData'],
            'last_update' => $hospitalsCompletedFormsData['lastUpdate'],
        ], 200);
    }

    static public function getHospitalsCompletedFormsData(Request $request)
    {
        $observation_end = $request->input('observation_end');
        $observation_start = $request->input('observation_start');
        $township = $request->input('township');
        $hospital = $request->input('hospital');

        $hospitalsLastUpdate = CompletedForm
            ::whereHas('hospital', function ($query) use ($hospital, $township) {
                if ($township) {
                    $query->where('township_id', $township);
                }
                if ($hospital) {
                    $query->where('id', $hospital);
                }
            })
            ->where(function ($query) use ($observation_end, $observation_start) {
                if ($observation_end && $observation_start) {
                    $query->whereBetween('last_update', [$observation_start, $observation_end]);
                } else if ($observation_end) {
                    $query->where('last_update', '<=', $observation_end);
                }
            })
            ->selectRaw('completed_forms.hospital_id, MAX(last_update) AS max_last_update')
            ->groupBy('completed_forms.hospital_id')
            ->get();

        $hospitalsData = [];
        foreach ($hospitalsLastUpdate as $hospitalLastUpdate) {
            $hospitalsData[] = Hospital::with([
                'completedForms' => function ($query) use ($hospitalLastUpdate, $observation_end, $observation_start) {
                    if ($observation_end && $observation_start) {
                        $query->whereBetween('last_update', [$observation_start, $observation_end]);
                    } else {
                        $query->where('last_update', $hospitalLastUpdate->max_last_update);
                    }
                },
                'completedForms.completedFormFields' => function ($query) {
                    $query->whereHas('formField');
                },
                'completedForms.completedFormFields.formField.formStep',
                'completedForms.adminUser'
            ])


                ->find($hospitalLastUpdate->hospital_id);
        }


        return [
            'hospitalsData' => $hospitalsData,
            'lastUpdate'    => $hospitalsLastUpdate->max('max_last_update')
        ];
    }

    static public function getAggregatedHospitalsDatas($hospitalsDatas)
    {


        $completedFormFields = collect($hospitalsDatas)
            ->flatMap(function ($hospitalData) {
                return $hospitalData->completedForms;
            })
            ->flatMap(function ($completedForm) {
                return $completedForm->completedFormFields;
            })
            ->filter(function ($completedFormField) {
                return $completedFormField->formField->form_field_type_id === FormFieldType::TYPE_NUMBER;
            });



        $completedFormFieldsGroup = $completedFormFields->groupBy('form_field_id')->values();
        return $completedFormFieldsGroup
            ->map(function ($completedFormFieldGroup) {
                $targetFormField = $completedFormFieldGroup[0]->formField ?? null;
                $aggregated = $completedFormFieldGroup->sum('value');
                if ($targetFormField && !$targetFormField->agreggation) {
                    $aggregated /= $completedFormFieldGroup->count();
                    if (is_float($aggregated)) {
                        $aggregated = number_format($aggregated, 2);
                    }
                }
                return [
                    'value'       => $aggregated,
                    'form_field'  => $targetFormField
                ];
            });
    }

    public function checkLastUpdate($hospitalId, $lastUpdate)
    {
        return CompletedForm::where('last_update', $lastUpdate)->where('hospital_id', $hospitalId)->count();
    }

    public function getAllFiltered(Request $request) {
        $formId = $request->query('form_id');
        $hospitalId = $request->query('hospital_id');
        $perPage = $request->query('per_page') ?? 15;

        $query = CompletedForm::with(['hospital', 'form']);

        if ($formId) {
          $query = $query->where('form_id', $formId);
        }
        if ($hospitalId) {
          $query = $query->where('hospital_id', $hospitalId);
        }

        $data = $query
          ->select('*')
          ->selectRaw('CAST(NOW() as DATE) - (last_update) as diff_date')
          ->orderBy('last_update', 'desc')
          ->paginate($perPage);

        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}
