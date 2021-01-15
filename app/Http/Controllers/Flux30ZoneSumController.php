<?php

namespace App\Http\Controllers;

use App\Flux30ZoneSum;
use App\Flux30ZoneSumByDate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux30ZoneSumController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:dashboard');
  }

  public function getHotspotMaps(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSumByDate::select(['Observation_Zone', DB::raw('sum("volume") as volume')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('date', [$data['observation_start'], $data['observation_end']])
        ->groupBy('Observation_Zone', "date")
        ->orderBy('volume')
        ->get();


      $fluxReferences = Flux30ZoneSumByDate::select(['Observation_Zone', DB::raw('sum("volume") as volume')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('date', [$data['preference_start'], $data['preference_end']])
        ->groupBy('Observation_Zone', 'date')
        ->orderBy('volume')
        ->get();

      $fluxObservationGroup = $fluxObservations->groupBy('observation_Zone');
      $fluxReferenceGroup = $fluxReferences->groupBy('observation_Zone');
      $fluxObservationWithMedian = [];
      $fluxReferenceWithMedian = [];

      foreach ($fluxObservationGroup as $key => $observation) {
        $median = $observation->median('volume');
        $fluxObservationWithMedian[] = [
          "volume" => $median,
          "origin" => $key
        ];
      }
      foreach ($fluxReferenceGroup as $key => $reference) {
        $median = $reference->median('volume');
        $fluxReferenceWithMedian[] = [
          "volume" => $median,
          "origin" => $key
        ];
      }

      return  response()->json([
        "observations" => $fluxObservationWithMedian,
        "references" => $fluxReferenceWithMedian
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotTypeMaps(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSumByDate::select(['observation_Zone', DB::raw('sum(volume) as volume')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sum_by_dates.Observation_Zone');
        });
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
        ->groupBy('Observation_Zone', "date")
        ->orderBy('volume')
        ->get();

      $fluxReferences = Flux30ZoneSumByDate::select(['observation_Zone', DB::raw('sum(volume) as volume')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sum_by_dates.Observation_Zone');
        });
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
        ->groupBy('Observation_Zone', 'date')
        ->orderBy('volume')
        ->get();

      $fluxObservationGroup = $fluxObservations->groupBy('observation_Zone');
      $fluxReferenceGroup = $fluxReferences->groupBy('observation_Zone');
      $fluxObservationWithMedian = [];
      $fluxReferenceWithMedian = [];

      foreach ($fluxObservationGroup as $key => $observation) {
        $median = $observation->median('volume');
        $fluxObservationWithMedian[] = [
          "volume" => $median,
          "origin" => $key
        ];
      }
      foreach ($fluxReferenceGroup as $key => $reference) {
        $median = $reference->median('volume');
        $fluxReferenceWithMedian[] = [
          "volume" => $median,
          "origin" => $key
        ];
      }

      return  response()->json([
        "observations" => $fluxObservationWithMedian,
        "references" => $fluxReferenceWithMedian
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotGeneral(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSumByDate::select([DB::raw('sum("volume") as volume')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('date', [$data['observation_start'], $data['observation_end']])
        ->groupBy("date")
        ->orderBy('volume')
        ->get();

      $fluxReferences = Flux30ZoneSumByDate::select([DB::raw('sum("volume") as volume')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('date', [$data['preference_start'], $data['preference_end']])
        ->groupBy('date')
        ->orderBy('volume')
        ->get();

      $observationMedia = $fluxObservations->median('volume');
      $referenceMedia = $fluxReferences->median('volume');

      return  response()->json([
        "observations" => $observationMedia,
        "references" => $referenceMedia
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotTypeGeneral(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSumByDate::select([DB::raw('sum(volume) as volume')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sum_by_dates.Observation_Zone');
        });
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('date', [$data['observation_start'], $data['observation_end']])
        ->groupBy("date")
        ->orderBy('volume')
        ->get();

      $fluxReferences = Flux30ZoneSumByDate::select([DB::raw('sum(volume) as volume')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sum_by_dates.Observation_Zone');
        });
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('date', [$data['preference_start'], $data['preference_end']])
        ->groupBy('date')
        ->orderBy('volume')
        ->get();

      $observationMedia = $fluxObservations->median('volume');
      $referenceMedia = $fluxReferences->median('volume');

      return  response()->json([
        "observations" => $observationMedia,
        "references" => $referenceMedia
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotDaily(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSum::select(['Date as date', 'Hour as hour', DB::raw('sum("Volume") as volume, WEEKDAY("Date") as day')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
        ->whereBetween('Hour', [$data['time_start'], $data['time_end']])
        ->groupBy('Date', 'Hour', 'day',)
        ->orderBy('volume')
        ->get();

      $fluxReferences = Flux30ZoneSum::select(['Date as date', 'Hour as hour', DB::raw('sum("Volume") as volume, WEEKDAY("Date") as day')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
        ->whereBetween('Hour', [$data['time_start'], $data['time_end']])
        ->groupBy('Date', 'Hour', 'day')
        ->orderBy('volume')
        ->get();

      $fluxObservationGroup = $fluxObservations->groupBy('day');
      $fluxReferenceGroup = $fluxReferences->groupBy('day');
      $ObservationFormatted = [];

      foreach ($fluxObservationGroup as $key => $observation) {
        if (!isset($fluxReferenceGroup[$key])) {
          continue;
        }
        $reference = $fluxReferenceGroup[$key]->toArray();
        foreach ($observation as $value) {
          $referenceHour = array_filter($reference, function ($item) use ($value) {
            return $item['hour'] == $value->hour;
          });
          if (count($referenceHour) == 0) {
            continue;
          }
          $median = collect($referenceHour)->median('volume');
          $value->{'volume_reference'} = $median;
          $difference = $value->volume - $median;
          $value->{'percent'} = ($difference * 100) / $median;
          $value->{'difference'} = $difference;
          $ObservationFormatted[] = $value;
        }
      }

      return  response()->json([
        "observations" => array_values(collect($ObservationFormatted)->sortBy('hour')->groupBy('date')->toArray()),
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotTypeDaily(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $fluxObservations = Flux30ZoneSum::select(['Date as date', 'Hour as hour', DB::raw('sum("Volume") as volume, WEEKDAY("Date") as day')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sums.Observation_Zone');
        });
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxObservations->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }
      $fluxObservations = $fluxObservations->whereBetween('Date', [$data['observation_start'], $data['observation_end']])

        ->whereBetween('Hour', [$data['time_start'], $data['time_end']])
        ->groupBy('Date', 'Hour', 'day',)
        ->orderBy('volume')
        ->get();

      $fluxReferences = Flux30ZoneSum::select(['Date as date', 'Hour as hour', DB::raw('sum("Volume") as volume, WEEKDAY("Date") as day')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sums.Observation_Zone');
        });;
      if ($data['fluxGeoOptions'] != 'Tout') {
        $fluxReferences->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }
      $fluxReferences = $fluxReferences->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
        ->whereBetween('Hour', [$data['time_start'], $data['time_end']])
        ->groupBy('Date', 'Hour', 'day')
        ->orderBy('volume')
        ->get();

      $fluxObservationGroup = $fluxObservations->groupBy('day');
      $fluxReferenceGroup = $fluxReferences->groupBy('day');
      $ObservationFormatted = [];

      foreach ($fluxObservationGroup as $key => $observation) {
        if (!isset($fluxReferenceGroup[$key])) {
          continue;
        }
        $reference = $fluxReferenceGroup[$key]->toArray();

        foreach ($observation as $value) {
          $referenceHour = array_filter($reference, function ($item) use ($value) {
            return $item['hour'] == $value->hour;
          });
          if (count($referenceHour) == 0) {
            continue;
          }
          $median = collect($referenceHour)->median('volume');
          $value->{'volume_reference'} = $median;
          $difference = $value->volume - $median;
          $value->{'percent'} = ($difference * 100) / $median;
          $value->{'difference'} = $difference;
          $ObservationFormatted[] = $value;
        }
      }

      return  response()->json([
        "observations" => array_values(collect($ObservationFormatted)->sortBy('hour')->groupBy('date')->toArray()),
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotTendance(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $flux = Flux30ZoneSum::select(['Date as date', 'Hour as hour', DB::raw('sum("Volume") as volume')]);
      if ($data['fluxGeoOptions'] != 'Tout') {
        $flux->where('Observation_Zone', $data['fluxGeoOptions']);
      }
      $flux = $flux->whereBetween('Date', [$data['preference_start'], $data['observation_end']])
        ->whereBetween('Hour', [$data['time_start'], $data['time_end']])
        ->groupBy('Date', 'Hour')
        ->orderBy('Date')
        ->orderBy('Hour')
        ->get();

      $fluxGroup = array_values($flux->groupBy('date')->toArray());
      return  response()->json([
        "observations" => $fluxGroup,
      ], 200);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getHotspotTypeTendance(Request $request)
  {
    $data = $this->fluxValidator($request->all());
    try {
      $data['fluxGeoOptions'] = $data['fluxGeoOptions'][0];
      $flux = Flux30ZoneSum::select(['Date as date', 'Hour as hour', DB::raw('sum("Volume") as volume')])
        ->join('flux_hot_spots', function ($q) {
          $q->on('flux_hot_spots.name', 'flux30_zone_sums.Observation_Zone');
        });
      if ($data['fluxGeoOptions'] != 'Tout') {
        $flux->where('flux_hot_spots.type', $data['fluxGeoOptions']);
      }

      $flux = $flux->whereBetween('Date', [$data['preference_start'], $data['observation_end']])
        // ->whereBetween('hour', [$data['time_start'], $data['time_end']])
        ->groupBy('Date', 'Hour')
        ->orderBy('Date')
        ->orderBy('Hour')
        ->get();

      $fluxGroup = array_values($flux->groupBy('date')->toArray());

      return  response()->json([
        "observations" => $fluxGroup,
      ], 200);
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
      'time_end' => 'required|date_format:H:i|after_or_equal:time_start'
    ])->validate();
  }
}
