<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\CompletedForm;
use App\CompletedFormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCompletedFormRequest;

use function PHPSTORM_META\map;

class CompletedFormController extends Controller
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
    public function indexByHospital(int $hospital_id, int $paginate = 15)
    {
        try {
            $completedForms =CompletedForm::where('hospital_id','=', intval($hospital_id));
            $completedForms = $this->selectCompletedForms($completedForms)
            ->distinct('last_update')
            ->orderBy('last_update','desc')
            ->paginate($paginate);

            return response()->json($completedForms,206);
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
            $completedForms=[];
            $hospitalIds = Hospital::all('id')
            ->pluck('id')
            ->unique()
            ->sort()
            ->values();

            foreach ($hospitalIds as $id) {

                 $completedForm = CompletedForm::where('hospital_id','=', intval($id));
                 $completedForm = $this->selectCompletedForms($completedForm)
                ->latest('last_update')
                ->first();

              if ($completedForm === null)
              {
                  $completedForm = [
                    'diff_date' => -1,
                    'last_update' => null,
                    'hospital_id' =>$id,
                    'name' =>Hospital::where('id',$id)->select('name')->first()->name,
                    "created_manager_name" => null,
                  ];
                  array_push($completedForms, $completedForm);
              }
              else
              {
                         
                array_push($completedForms, $completedForm);
              }

            }
            //$sortSituations =usort($completedForms,fn($a,$b)=> $b['last_update'] -$a['last_update']);

            return response()->json($completedForms,200,[],JSON_NUMERIC_CHECK);

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
              ['admin_user_id' => $admin_user->id ]
            ));
    
     
            $completedFormFields = $request['completed_form_fields'];
    
            foreach ($completedFormFields as $formFieldKey => $formFieldValue) {
                CompletedFormField::create([
                    'form_field_id'     => $formFieldKey,
                    'value'             => $formFieldValue,
                    'completed_form_id' => $completedForm->id
                ]);
            }
            return response()->json($completedForm,200, []);

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
            
            return response()->json($completedForm,206);
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
               'completedFormFields','completedFormFields.formField.formStep',
               'completedFormFields.formField.formFieldType','hospital'
               ])
        ->select('*')
        ->selectRaw('CAST(NOW() as DATE) - (last_update) as diff_date');
  }

  private function formatCompletedForms($completedForm){
   return function() use ($completedForm){
    [
        'diff_date'     => $completedForm['diff_date'],
        'last_update'   => $completedForm['last_update'],
        'hospital_id'   => $completedForm['hospital_id'],
        'name'          => $completedForm['hospital']['name'],
        "created_manager_name" => $completedForm['created_manager_name'],
      ];
   };
  }
}

