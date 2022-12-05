<?php

namespace App\Http\Controllers;

use App\Flux24PresenceProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux24PresenceProvinceController extends Controller
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

  public function getFlux24PresenceDailyInProvince(Request $request)
  {
    $data = $this->fluxValidator($request->all());

    try {
      $flux = Flux24PresenceProvince::select([
        'Date as date',
        'Zone as zone',
        'PresenceType',
        DB::raw('sum("Volume") as volume,WEEKDAY("Date") AS day'),
      ])
        ->whereBetween('Date', [
          $data['observation_start'],
          $data['observation_end'],
        ])
        ->WhereIn('Zone', $data['fluxGeoOptions'])
        ->groupBy('Date', 'Zone', 'day', 'PresenceType')
        ->get();

      $fluxRefences = [];
      if (isset($data['preference_start']) && isset($data['preference_end'])) {
        $fluxRefences = Flux24PresenceProvince::select([
          'Zone as zone',
          'Date as date',
          'PresenceType',
          DB::raw('sum("Volume") as volume,WEEKDAY("Date") AS day'),
        ])
          ->whereBetween('Date', [
            $data['preference_start'],
            $data['preference_end'],
          ])
          ->WhereIn('Zone', $data['fluxGeoOptions'])
          ->groupBy('day', 'Zone', 'date', 'PresenceType')
          ->get();
      }

      return response()->json(
        [
          'references' => $fluxRefences,
          'observations' => $flux,
        ],
        200,
        [],
        JSON_NUMERIC_CHECK
      );
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
   * @param  \App\Flux24PresenceProvince  $flux24PresenceProvince
   * @return \Illuminate\Http\Response
   */
  public function show(Flux24PresenceProvince $flux24PresenceProvince)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Flux24PresenceProvince  $flux24PresenceProvince
   * @return \Illuminate\Http\Response
   */
  public function update(
    Request $request,
    Flux24PresenceProvince $flux24PresenceProvince
  ) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Flux24PresenceProvince  $flux24PresenceProvince
   * @return \Illuminate\Http\Response
   */
  public function destroy(Flux24PresenceProvince $flux24PresenceProvince)
  {
    //
  }

  public function fluxValidator($inputData)
  {
    return Validator::make($inputData, [
      'fluxGeoOptions' => 'required|array',
      'preference_start' => 'nullable|date|before_or_equal:preference_end',
      'preference_end' =>
        'nullable|date|before:observation_start|required_with:preference_start',
      'observation_start' => 'date|required|before_or_equal:observation_end',
      'observation_end' => 'date|required|after_or_equal:observation_start',
    ])->validate();
  }
}
