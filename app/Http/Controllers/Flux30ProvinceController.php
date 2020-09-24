<?php

namespace App\Http\Controllers;

use App\Flux30Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux30ProvinceController extends Controller
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
   * @param  \App\Flux30Province  $flux30Province
   * @return \Illuminate\Http\Response
   */
  public function show(Flux30Province $flux30Province)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Flux30Province  $flux30Province
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Flux30Province $flux30Province)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Flux30Province  $flux30Province
   * @return \Illuminate\Http\Response
   */
  public function destroy(Flux30Province $flux30Province)
  {
    //
  }

  public function getFluxDataFromOriginProvince(Request $request)
  {
    $data = $this->fluxValidator($request->all());

    try {
      $flux = Flux30Province::select(['origin', 'destination', DB::raw('sum(volume) as volume')])
        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
        ->where(function ($q) use ($data) {
          $q->whereIn('Origin', $data['fluxGeoOptions'])
            ->orWhereIn('Destination', $data['fluxGeoOptions']);
        })
        ->groupBy('Origin', 'destination')
        ->get();

      $geoCodingFilePath = storage_path('app/fluxZones.json');
      $geoData = [];
      if (file_exists($geoCodingFilePath)) {
        $jsonString = file_get_contents($geoCodingFilePath);
        $geoData = json_decode($jsonString, true);
      }
      $fluxRefences = [];
      if (isset($data['preference_start']) && isset($data['preference_end'])) {
        $fluxRefences = Flux30Province::select(['origin', 'destination', DB::raw('sum(volume) as volume')])
          ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
          ->where(function ($q) use ($data) {
            $q->whereIn('Origin', $data['fluxGeoOptions'])
              ->orWhereIn('Destination', $data['fluxGeoOptions']);
          })
          ->groupBy('Origin', 'destination')
          ->get();
        $fluxRefencesData = [];
        if (count($fluxRefences) > 0) {
          foreach ($fluxRefences as $value) {
            $value->{'isReference'} = true;
            if (isset($geoData[strtoupper($value->origin)][0])) {
              $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
            } else {
              continue;
            }
            if (isset($geoData[strtoupper($value->destination)][0])) {
              $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
            } else {
              continue;
            }
            $fluxRefencesData[] = $value;
          }
        }
      }


      $fluxData = [];
      foreach ($flux as $value) {
        if ($fluxRefences) {
          foreach ($fluxRefences as $item) {
            if ($item->origin == $value->origin && $item->destination == $value->destination) {
              $value->{'reference_volume'} = $item->volume;
              break;
            }
          }
        }
        if (isset($geoData[strtoupper($value->origin)][0])) {
          $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
        } else {
          continue;
        }
        if (isset($geoData[strtoupper($value->destination)][0])) {
          $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
        } else {
          continue;
        }
        $fluxData[] = $value;
      }
      if (is_array($fluxRefences)) {
        return response()->json($fluxData);
      }
      return response()->json(array_merge($fluxRefencesData, $fluxData));
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getFluxDataFromOriginDailyProvince(Request $request)
  {
    $data = $this->fluxValidator($request->all());

    try {
      $flux = Flux30Province::select(['Date as date', DB::raw('sum(volume)as volume')])
        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
        ->where('immobility', '3h')

        ->where(function ($q) use ($data) {
          $q->whereIn('Origin', $data['fluxGeoOptions'])
            ->orWhereIn('Destination', $data['fluxGeoOptions']);
        })
        ->where('destination', '!=', 'Hors_Zone')
        ->where('origin', '!=', 'Hors_Zone')
        ->groupBy('Date')->get();

      $fluxRefences = [];
      if (isset($data['preference_start']) && isset($data['preference_end'])) {
        $fluxRefences = Flux30Province::select(['Date as date', DB::raw('sum(volume)as volume')])
          ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
          ->where('immobility', '3h')
          ->where(function ($q) use ($data) {
            $q->whereIn('Origin', $data['fluxGeoOptions'])
              ->orWhereIn('Destination', $data['fluxGeoOptions']);
          })
          ->where('destination', '!=', 'Hors_Zone')
          ->where('origin', '!=', 'Hors_Zone')
          ->groupBy('Date')->get();

        if (count($fluxRefences) > 0) {
          foreach ($fluxRefences as $value) {
            $value->{'isReference'} = true;
          }
        }
      }
      if (is_array($fluxRefences)) {
        return response()->json($flux);
      }
      return response()->json(array_merge($fluxRefences->toArray(), $flux->toArray()));
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getFluxDataFromOriginDailyInProvince(Request $request)
  {
    $data = $this->fluxValidator($request->all());

    try {
      $flux = Flux30Province::select(['Date as date','hour', 'Destination as destination', 'Origin as origin', DB::raw('sum(volume)as volume,WEEKDAY(DATE) AS day')])
        ->where('Date', $data['observation_start'])
        ->where('immobility', '3h')
        ->whereIn('Destination', $data['fluxGeoOptions'])
        // ->where('destination','!=','Hors_Zone')
        ->orderBy('date')
        ->where('origin', '!=', 'Hors_Zone')
        ->groupBy('Date', 'day', 'destination', 'Origin','hour')->get();

      $fluxRefences = Flux30Province::select(['Destination as destination','hour', 'Origin as origin', 'date', DB::raw('sum(volume)as volume, WEEKDAY(DATE) AS day')])
        ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
        ->where('immobility', '3h')
        ->whereIn('Destination', $data['fluxGeoOptions'])
        // ->where('destination','!=','Hors_Zone')
        ->where('origin', '!=', 'Hors_Zone')
        ->groupBy('day', 'Destination', 'Origin', 'Date','hour')
        ->orderBy('date')
        ->get();

      // dump($fluxRefences->toArray());
      // echo 'group';
      dump($fluxRefences->groupBy('date'));

      exit;



      $geoCodingFilePath = storage_path('app/fluxZones.json');
      $geoData = [];
      if (file_exists($geoCodingFilePath)) {
        $jsonString = file_get_contents($geoCodingFilePath);
        $geoData = json_decode($jsonString, true);
      }
      foreach ($flux as $value) {
        if (isset($geoData[strtoupper($value->origin)][0])) {
          $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
        } else {
          continue;
        }
        if (isset($geoData[strtoupper($value->destination)][0])) {
          $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
        } else {
          continue;
        }
      }

      return response()->json([
        'references' => $fluxRefences,
        'observations' => $flux,
      ]);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getFluxDataFromOriginDailyOutProvince(Request $request)
  {
    $data = $this->fluxValidator($request->all());

    try {
      $flux = Flux30Province::select(['Date as date', 'Origin as origin', 'Destination as destination', DB::raw('sum(volume)as volume,WEEKDAY(DATE) AS day')])
        ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
        ->where('immobility', '3h')
        ->whereIn('Origin', $data['fluxGeoOptions'])
        ->where('destination', '!=', 'Hors_Zone')
        // ->where('origin','!=','Hors_Zone')
        ->orderBy('date')
        ->groupBy('Date', 'day', 'origin', 'Destination')->get();

      $fluxRefences = [];
      if (isset($data['preference_start']) && isset($data['preference_end'])) {
        $fluxRefences = Flux30Province::select(['Origin as origin', 'Destination as destination', 'Date', DB::raw('sum(volume)as volume, WEEKDAY(DATE) AS day')])
          ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
          ->where('immobility', '3h')
          ->whereIn('Origin', $data['fluxGeoOptions'])
          // ->where('destination','!=','Hors_Zone')
          ->where('origin', '!=', 'Hors_Zone')
          ->groupBy('day', 'Destination', 'Origin', 'Date')
          ->orderBy('date')->get();
      }

      $geoCodingFilePath = storage_path('app/fluxZones.json');
      $geoData = [];
      if (file_exists($geoCodingFilePath)) {
        $jsonString = file_get_contents($geoCodingFilePath);
        $geoData = json_decode($jsonString, true);
      }
      foreach ($flux as $value) {
        if (isset($geoData[strtoupper($value->origin)][0])) {
          $value->{'position_start'} = $geoData[strtoupper($value->origin)][0]['coordinates'];
        } else {
          continue;
        }
        if (isset($geoData[strtoupper($value->destination)][0])) {
          $value->{'position_end'} = $geoData[strtoupper($value->destination)][0]['coordinates'];
        } else {
          continue;
        }
      }

      return response()->json([
        'references' => $fluxRefences,
        'observations' => $flux,
      ]);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function fluxGlobalValidator($inputData)
  {
    return  Validator::make($inputData, [
      'preference_start' => 'nullable|date|before_or_equal:preference_end',
      'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
      'observation_start' => 'date|required|before_or_equal:observation_end',
      'observation_end' => 'date|required|after_or_equal:observation_start',
    ])->validate();
  }

  public function fluxValidator($inputData)
  {
    return  Validator::make($inputData, [
      'fluxGeoOptions' => 'required|array',
      'preference_start' => 'nullable|date|before_or_equal:preference_end',
      'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
      'observation_start' => 'date|required',
      // 'observation_end' => 'date|required|after_or_equal:observation_start',
    ])->validate();
  }
}
