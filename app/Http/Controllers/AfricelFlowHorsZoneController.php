<?php

namespace App\Http\Controllers;

use App\AfricelFlowHorsZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AfricelFlowHorsZoneController extends Controller
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

  public function getByName(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $zoneData = AfricelFlowHorsZone::select(['zone_name as reference', 'africel_health_zones.name as name', 'date','flow_out','flow_in', 'flow_tot'])
        ->join('africel_health_zones', function ($q) {
          $q->on('africel_health_zones.reference', '=', 'africel_flow_hors_zones.zone_name');
        })
        ->where('africel_health_zones.name', $data['fluxGeoOptions'])
        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])->get();
      return response()->json($zoneData);
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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\AfricelFlowHorsZone  $africelFlowHorsZone
   * @return \Illuminate\Http\Response
   */
  public function show(AfricelFlowHorsZone $africelFlowHorsZone)
  {
    //
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\AfricelFlowHorsZone  $africelFlowHorsZone
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AfricelFlowHorsZone $africelFlowHorsZone)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\AfricelFlowHorsZone  $africelFlowHorsZone
   * @return \Illuminate\Http\Response
   */
  public function destroy(AfricelFlowHorsZone $africelFlowHorsZone)
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
