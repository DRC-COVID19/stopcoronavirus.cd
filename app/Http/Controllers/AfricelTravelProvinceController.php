<?php

namespace App\Http\Controllers;

use App\AfricelTravelProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AfricelTravelProvinceController extends Controller
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

  public function getByProvince(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $provinceData = AfricelTravelProvince::select(['province_name as name', 'date', 'volume'])
        ->where('province_name', $data['fluxGeoOptions'])
        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])->get();
      return response()->json($provinceData);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\AfricelTravelProvince  $africelTravelProvince
   * @return \Illuminate\Http\Response
   */
  public function show(AfricelTravelProvince $africelTravelProvince)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\AfricelTravelProvince  $africelTravelProvince
   * @return \Illuminate\Http\Response
   */
  public function edit(AfricelTravelProvince $africelTravelProvince)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\AfricelTravelProvince  $africelTravelProvince
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AfricelTravelProvince $africelTravelProvince)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\AfricelTravelProvince  $africelTravelProvince
   * @return \Illuminate\Http\Response
   */
  public function destroy(AfricelTravelProvince $africelTravelProvince)
  {
    //
  }

  public function fluxValidator($inputData)
  {
    return  Validator::make($inputData, [
      'fluxGeoOptions' => 'required',
      'preference_start' => 'nullable|date|before_or_equal:preference_end',
      'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
      'observation_start' => 'date|required|before_or_equal:observation_end',
      'observation_end' => 'date|required|after_or_equal:observation_start',
    ])->validate();
  }
}
