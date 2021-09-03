<?php

namespace App\Http\Controllers;

use App\FormStep;
use Illuminate\Http\Request;

class FormStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formSteps = FormStep::with('form')->orderBy('title')->get();
        return response()->json($formSteps, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = FormStep::create($this->validator());
        return response()->json( $result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FormStep $formStep)
    {
        $formStep->load(['form']);
        return response()->json($formStep, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormStep $formStep)
    {
        $result = $formStep->update($this->updateValidator());
        return response()->json( $result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormStep $formStep)
    {
        $formStep->delete();
        return response()->json(null, 200);
    }

    public function validator(){
        return request()->validate([
            'title'                 => 'required|string|max:255',
            'step'                  => 'required|integer',
            'form_id'               => 'required|integer|exists:forms,id'
        ]);
    }
    public function updateValidator(){
        return request()->validate([
            'title'                 => 'sometimes|string|max:255',
            'step'                  => 'sometimes|integer',
            'form_id'               => 'sometimes|integer|exists:forms,id'
        ]);
    }

    public function filter (Request $request) {
        try {
          $key_words=$request->get('key_words');
          $formStep = FormStep::where('title', 'LIKE', "%{$key_words}%")->get();
          return response()->json( $formStep, 200);
        } catch (\Throwable $th) {
          if (env('APP_DEBUG') == true) {
            return response($th)->setStatusCode(500);
          }
          return response($th->getMessage())->setStatusCode(500);
        }
      }

    public function getFormStepByForm($form){
        $formSteps = FormStep::with('form')->where('form_id',$form)->get();
        return response()->json($formSteps, 200);

    }
}
