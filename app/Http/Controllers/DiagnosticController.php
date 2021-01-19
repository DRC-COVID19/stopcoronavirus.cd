<?php

namespace App\Http\Controllers;

use App\Diagnostic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosticController extends Controller
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
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
    $data = Validator::make( $request->all(),[
      "start_at" => 'required',
      "temperature_cat" => 'required',
      "param" => 'required',
      "cough" => 'required',
      "agueusia_anosmia" => 'required',
      "sore_throat_aches" => 'required',
      "diarrhea" => 'required',
      "tiredness" => 'required',
      "tiredness_details" => 'required',
      "feeding_day" => 'required',
      "breathlessness" => 'required',
      "age" => 'required',
      "size" => 'required',
      "weight" => 'required',
      "heart_disease" => 'required',
      "diabetes" => 'required',
      "cancer" => 'required',
      "breathing_disease" => 'required',
      "kidney_disease" => 'required',
      "liver_disease" => 'required',
      "pregnant" => 'required',
      "immunosuppressant_disease" => 'required',
      "immunosuppressant_drug" => 'required',
      "province" => 'required',
      "town" => "nullable",
      "township" => "nullable",
      "imc" => 'required',
      "orientation" => "required",
      "results_message" => 'required',
      "algo_version" => 'required',
      "form_version" => 'required',
      "fever_algo" => 'required',
      "immunosuppressant_disease_algo" => 'required',
      "immunosuppressant_drug_algo" => 'required',
      "heart_disease_algo" => 'required',
      "duration" => 'required',
      "age_range" => 'required',
    ])->validate();
    try {
      Diagnostic::create($data);
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
   * @param  \App\Diagnostic  $diagnostic
   * @return \Illuminate\Http\Response
   */
  public function show(Diagnostic $diagnostic)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Diagnostic  $diagnostic
   * @return \Illuminate\Http\Response
   */
  public function edit(Diagnostic $diagnostic)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Diagnostic  $diagnostic
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Diagnostic $diagnostic)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Diagnostic  $diagnostic
   * @return \Illuminate\Http\Response
   */
  public function destroy(Diagnostic $diagnostic)
  {
    //
  }
}
