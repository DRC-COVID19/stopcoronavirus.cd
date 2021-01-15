<?php

namespace App\Http\Controllers;

use App\AfricelFlowInterZone;
use App\Http\Resources\AfricelFlowInterZoneResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AfricelFlowInterZoneController extends Controller
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
      $zoneData = AfricelFlowInterZone::select(['date', 'flow_AB', 'flow_BA', 'flow_tot',DB::raw('(select name from africel_health_zones where reference="zone_A"  ) as "zoneA",(select name from africel_health_zones where reference="zone_B"  ) as "zoneB"')])
        ->join('africel_health_zones', function ($q) {
          $q->on('africel_health_zones.reference', '=', 'africel_flow_inter_zones.zone_A')
          ->orOn('africel_health_zones.reference', '=', 'africel_flow_inter_zones.zone_B');
        })
        ->where('africel_health_zones.name', $data['fluxGeoOptions'])
        ->whereBetween('date', [$data['observation_start'], $data['observation_end']])->get();
        return response()->json($zoneData,200,[],JSON_NUMERIC_CHECK);
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
   * @param  \App\AfricelFlowInterZone  $africelFlowInterZone
   * @return \Illuminate\Http\Response
   */
  public function show(AfricelFlowInterZone $africelFlowInterZone)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\AfricelFlowInterZone  $africelFlowInterZone
   * @return \Illuminate\Http\Response
   */
  public function edit(AfricelFlowInterZone $africelFlowInterZone)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\AfricelFlowInterZone  $africelFlowInterZone
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AfricelFlowInterZone $africelFlowInterZone)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\AfricelFlowInterZone  $africelFlowInterZone
   * @return \Illuminate\Http\Response
   */
  public function destroy(AfricelFlowInterZone $africelFlowInterZone)
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
