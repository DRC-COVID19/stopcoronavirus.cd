<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\CompletedForm;
use App\CompletedFormField;
use App\FormFieldType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCompletedFormRequest;
use Illuminate\Support\Facades\DB;


use function PHPSTORM_META\map;

class CompletedFormController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:dashboard')->except(['show', 'getAggregatedByHospitals']);
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
    public function getAgentLastUpdate()
    {

        try {
            $completedForms = collect();
            $hospitalIds = Hospital::all('id')
                ->pluck('id')
                ->unique()
                ->sort()
                ->values();

            foreach ($hospitalIds as $id) {

                $completedForm = CompletedForm::where('hospital_id', '=', intval($id));
                $completedForm = $this->selectCompletedForms($completedForm)
                    ->latest('last_update')
                    ->first();

                if ($completedForm === null) {
                    $completedForm = [
                        'diff_date' => -1,
                        'last_update' => null,
                        'hospital_id' => $id,
                        'name' => Hospital::where('id', $id)->select('name')->first()->name,
                        "created_manager_name" => null,
                    ];
                    $completedForms->push($completedForm);
                } else {
                    $completedForms->push($completedForm);
                }
            }
            return response()->json($completedForms, 200, [], JSON_NUMERIC_CHECK);
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

            $completedForm = CompletedForm::find($id);
            $completedForm = $this->selectCompletedForms($completedForm)
                ->orderBy('last_update')
                ->get();

            //$completedFormFields =$completedForm->take('completed_form_fields')->merge($this->arrayMapAndSort($completedForm));


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
    public function update(Request $request, CompletedForm $completedForm)
    {
        //
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
        return
            $completedForm
            ->with([
                'completedFormFields', 'completedFormFields.formField.formStep',
                'completedFormFields.formField.formFieldType', 'hospital'
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
    //   private function createReduce($arrayMapAndSort)
    //   {
    //     $formIds = collect();
    //     $formStepsList = collect();

    //     // $arrayMapAndSort ?$arrayMapAndSort:collect()
    //     // ->sort(fn($prevFormItem, $nextFormItem) =>$prevFormItem->formStepId - $nextFormItem->formStepId);
    //     // $arrayMapAndSort->each(function($item, $key) use($formIds){
    //     //     if ($formIds->every(fn($form)=> $form->formStepId !== $item->formStepId)) {
    //     //         $formIds->push([
    //     //           'formStepId'    => $item->formStepId,
    //     //           'form_step_title' => $item->form_step_title
    //     //         ]);
    //     //       }
    //     // });
    //     // $formStepsList = $formIds
    //     // ->map(function($form) use ($arrayMapAndSort){
    //     //     $formStep = [
    //     //       'formStepId'      => $form->formStepId,
    //     //       'form_step_title'   =>$form->form_step_title
    //     //     ];
    //     //     $formStep['form_field_values'] = $arrayMapAndSort->filter(fn($arr) => $arr->formStepId == $formStep->formStepId);
    //     //     return $formStep;
    //     //   });
    //     return $arrayMapAndSort[0];
    //     }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompletedForm  $completedForm
     * @return \Illuminate\Http\Response
     */

    public function getAggregatedByHospitals(Request  $request)
    {
        $observation_end = $request->input('observation_end');
        $observation_start = $request->input('observation_start');
        $township = $request->input('township');
        $hospital = $request->input('hospital');

        $hospitalsLastUpdate = DB::table('completed_forms')
            ->selectRaw('completed_forms.hospital_id, MAX(last_update) AS max_last_update')
            ->groupBy('completed_forms.hospital_id')
            ->get();

        $hospitalsData = [];
        foreach ($hospitalsLastUpdate as $hospitalLastUpdate) {
            $hospitalsData[] = Hospital::with([
                'completedForms' => function ($query) use ($hospitalLastUpdate) {
                    $query->where('last_update', $hospitalLastUpdate->max_last_update);
                },
                'completedForms.completedFormFields.formField.formStep',
                'completedForms.adminUser'
            ])
                ->find($hospitalLastUpdate->hospital_id);
        }

        return response()->json([
            'aggregated'  => $this->getAggregatedHospitalsDatas($hospitalsData),
            'data'        => $hospitalsData,
            'last_update' => $hospitalsLastUpdate->max('max_last_update')
        ], 200);
    }

    public function getAggregatedHospitalsDatas($hospitalsData)
    {
        $completedFormFields = collect($hospitalsData)
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
                }
                return [
                    'value'       => $aggregated,
                    'form_field'  => $targetFormField
                ];
            });
    }
}
