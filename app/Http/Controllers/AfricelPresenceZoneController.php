<?php

namespace App\Http\Controllers;

use App\AfricelPresenceZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AfricelPresenceZoneController extends Controller
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

  public function getByName(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $zoneData = AfricelPresenceZone::select(['zone_name as reference','africel_health_zones.name', 'date', 'volume'])
        ->join('africel_health_zones', function ($q) {
          $q->on('africel_health_zones.reference', '=', 'africel_presence_zones.zone_name');
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
   * @param  \App\AfricelPresenceZone  $africelPresenceZone
   * @return \Illuminate\Http\Response
   */
  public function show(AfricelPresenceZone $africelPresenceZone)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\AfricelPresenceZone  $africelPresenceZone
   * @return \Illuminate\Http\Response
   */
  public function edit(AfricelPresenceZone $africelPresenceZone)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\AfricelPresenceZone  $africelPresenceZone
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AfricelPresenceZone $africelPresenceZone)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\AfricelPresenceZone  $africelPresenceZone
   * @return \Illuminate\Http\Response
   */
  public function destroy(AfricelPresenceZone $africelPresenceZone)
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
