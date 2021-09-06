<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FormField;

class FormFieldController extends Controller
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
      $formField = FormField::create($this->storeValidator($request));
      return response()->json($formField, 200);
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
     * Validate data passed for create new entity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function storeValidator(Request $request){
      return request()->validate([
          'name'                  => 'required|string|max:255',
          'order_field'           => 'nullable|integer',
          'rules'                 => 'nullable|string',
          'default_value'         => 'nullable|string|max:255',
          'form_id'               => 'required|integer|exists:forms,id',
          'form_field_type_id'    => 'required|integer|exists:form_field_types,id',
          'form_step_id'          => 'nullable|integer|exists:form_steps,id'
      ]);
  }
}
