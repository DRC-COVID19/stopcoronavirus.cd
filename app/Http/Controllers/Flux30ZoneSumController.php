<?php

namespace App\Http\Controllers;

use App\Flux30ZoneSum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux30ZoneSumController extends Controller
{
  public function getHotspotMaps(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSum::select(['Date as date', 'hour', 'Observation_Zone', DB::raw('sum(volume) as volume, WEEKDAY(date) as day')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
        // ->where('destination', '!=', 'Hors_Zone')
        // ->where('origin', '!=', 'Hors_Zone')
        ->groupBy('Date', 'hour', 'day')
        ->orderBy('volume')
        ->get();

      $fluxReferences = Flux30ZoneSum::select(['Date as date', 'hour', 'Observation_Zone', DB::raw('sum(volume) as volume')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
        // ->where('destination', '!=', 'Hors_Zone')
        // ->where('origin', '!=', 'Hors_Zone')
        ->groupBy('Date', 'hour')
        ->orderBy('volume')
        ->get();

      // $fluxObservationMedia = 2;
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function fluxValidator($inputData)
  {
    return  Validator::make($inputData, [
      'fluxGeoOptions' => 'required|array',
      'preference_start' => 'nullable|date|before_or_equal:preference_end',
      'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
      'observation_start' => 'date|required',
      'observation_end' => 'date|required|after_or_equal:observation_start',
      'time_start' => "required|date_format:H:i",
      'time_end' => 'date_format:H:i|after:time_start'
    ])->validate();
  }
}
