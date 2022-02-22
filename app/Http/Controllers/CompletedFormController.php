<?php

namespace App\Http\Controllers;

use App\CompletedForm;
use App\CompletedFormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCompletedFormRequest;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompletedFormRequest $request)
    {
        $completedFormRequest= $request->validated();

        Log::info('completedFormRequest: ',[$completedFormRequest]);
        // $admin_user = Auth::user();
        //$completedForm = new CompletedForm();

        // $completedForm->admin_user->associate($admin_user);
 
        // $completedFormFields = $completedFormRequest['completed_form_fields'];
        // foreach ($completedFormFields as $formField) {
        // }

        return response()->json('kitoko',200);
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
}
