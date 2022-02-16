<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::with('formRecurrence')->orderBy('title')->get();
        return response()->json($forms, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $result = Form::create($this->validator());
        return response()->json( $result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function show(Form $form)
    {
        $form->load(['formRecurrence', 'formSteps','formFields.formFieldType']);
        return response()->json($form, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Form $form)
    {
        $result = $form->update($this->updateValidator());
        return response()->json( $result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return response()->json(null, 200);
    }

    public function validator(){
        return request()->validate([
            'title'                 => 'required|string|max:255',
            'publish'               => 'nullable|boolean',
            'form_recurrence_value' => 'nullable|string|max:255',
            'form_recurrence_id'    => 'required|integer|exists:form_recurrences,id'
        ]);
    }
    public function updateValidator(){
        return request()->validate([
            'title'                 => 'sometimes|string|max:255',
            'publish'               => 'nullable|boolean',
            'form_recurrence_value' => 'nullable|string|max:255',
            'form_recurrence_id'    => 'sometimes|integer|exists:form_recurrences,id'
        ]);
    }
    public function filter (Request $request) {
        try {
          $key_words=$request->get('key_words');
          $forms = Form::where('title', 'LIKE', "%{$key_words}%")->orWhere('title', 'LIKE' , "%{$key_words}%")->paginate(15);
          if (! $forms ) {
            return response()->json(['message' => "No form found"], 404);
          }
          return response()->json( $forms, 200);
        } catch (\Throwable $th) {
          if (env('APP_DEBUG') == true) {
            return response($th)->setStatusCode(500);
          }
          return response($th->getMessage())->setStatusCode(500);
        }
      }
}
