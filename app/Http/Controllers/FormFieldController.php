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
        $formFields = FormField::with(['form','formStep','formFieldType'])->get();
        return response()->json($formFields, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $this->storeValidator();
      if(request()->has('order_field')){
          $data['order_field'] = request('order_field');
          $formField = FormField::create($data);
        return response()->json($formField, 200);
      } else{
          $formFieldOrder = FormField::find($request->form_field_order);
          $data['order_field'] = $formFieldOrder->order_field;
          $formField = FormField::create($data);

          FormField::where('order_field', '>', $formFieldOrder->order_field)->increment('order_field', 1);
          $formFieldOrder->order_field++;
          $formFieldOrder->save();

          return response()->json($formField, 200);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FormField $formField)
    {
        $formField->load(['form','formStep']);
        return response()->json($formField, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FormField  $formField
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(FormField $formField, Request $request)
    {
        $result = $formField->update($this->updateValidator());
        if($request->form_field_order) {
          $formFieldOrder = FormField::find($request->form_field_order);
          if ($formFieldOrder->id !== $formField->id) {
            $formField->order_field = $formFieldOrder->order_field;
            $formField->save();
            FormField::where('order_field', '>', $formFieldOrder->order_field)->increment('order_field', 1);
            $formFieldOrder->order_field++;
            $formFieldOrder->save();
          }
        }
        return response()->json( $result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormField $formField)
    {
        $formField->delete();
        return response()->json(null, 200);
    }


    public function getFormFieldByForm(Request $request){
        $form_id = $request->input('form_id');
        $step_id = $request->input('step_id');
        $formFields = FormField::with(['form','formStep','formFieldType'])
                                ->where(function($query) use ($form_id, $step_id){
                                  if($form_id){
                                    $query->where('form_id', $form_id);
                                  }
                                  if($step_id){
                                    $query->where('form_step_id', $step_id);
                                  }
                                })
                                ->orderBy('order_field')
                                ->get();
        return response()->json($formFields, 200);

    }

    /**
     * Validate data passed for create new entity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function storeValidator(){
      return request()->validate([
          'name'                  => 'required|string|max:255',
          'order_field'           => 'nullable|integer',
          'rules'                 => 'nullable|string',
          'agreggation'           => 'nullable|boolean',
          'default_value'         => 'nullable|string|max:255',
          'form_id'               => 'required|integer|exists:forms,id',
          'form_field_type_id'    => 'required|integer|exists:form_field_types,id',
          'form_step_id'          => 'required|integer|exists:form_steps,id'
      ]);
  }
    public function updateValidator(){
      return request()->validate([
          'name'                  => 'sometimes|string|max:255',
          'order_field'           => 'nullable|integer',
          'rules'                 => 'nullable|string',
          'agreggation'           => 'nullable|boolean',
          'default_value'         => 'nullable|string|max:255',
          'form_id'               => 'sometimes|integer|exists:forms,id',
          'form_field_type_id'    => 'sometimes|integer|exists:form_field_types,id',
          'form_step_id'          => 'nullable|integer|exists:form_steps,id'
      ]);
  }
}
