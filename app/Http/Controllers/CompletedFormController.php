<?php

namespace App\Http\Controllers;

use App\User;
use App\CompletedForm;
use App\CompletedFormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCompletedFormRequest;

class CompletedFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dashboard')->except([]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompletedFormRequest $request)
    {
       

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
        return response()->json($completedForm,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

}
