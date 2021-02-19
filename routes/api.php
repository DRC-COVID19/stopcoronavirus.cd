<?php

use App\Flux;
use App\Flux24PresenceZone;
use App\Flux24Province;
use App\Flux30ZoneSum;
use App\Flux30ZoneSumByDate;
use App\Http\Controllers\HospitalSituationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\PandemicStat;
use App\Http\Resources\PandemicStat as PandemicStatResource;
use Encore\Admin\Grid\Filter\Where;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/lastpandemicstat', function () {
  return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->first());
});

Route::get('/pandemicstats', function () {
  return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->get());
});

Route::get('/pandemicstatsasc', function () {
  /**
   * Récupère la situation epidémiologique
   */
  return new PandemicStatResource(PandemicStat::orderBy('last_update', 'ASC')->get());
});

Route::post('/medicale-orientation', 'DiagnosticController@store');

Route::apiResource('admin_users', 'AdministratorController');

Route::apiResource('admin_roles', 'AdminRoleController');

Route::group(['prefix' => 'pandemic-stats'], function () {
  Route::get('/', 'PandemicStatController@index');
  Route::post('/', 'PandemicStatController@store');
  Route::get('/{pandemic_stat_id}', 'PandemicStatController@show');
  Route::put('/{pandemic_stat_id}', 'PandemicStatController@update');
  Route::delete('/{pandemic_stat_id}', 'PandemicStatController@destroy');
});

Route::group(['prefix' => 'flux-test', 'middleware' => 'cache.headers:private;max_age=3600'], function () {
  Route::get('/data-1', function (Request $request) {
    $activity = $request->get('activity');
    $data = Flux::on('mysql')->select(['date', DB::raw('sum(volume) as volume')])
      ->where('Destination', "Gombe")
      ->whereBetween('Date', ['2020-02-01', '2020-12-31'])
      ->where('Immobility', '3h')
      ->orderBy('date')
      ->groupBy('date');

    if ($activity == 'work') {
      $data->where('Activity_Category', 'Destination_Zone_Worker');
    } else if ($activity == 'study') {
      $data->where('Activity_Category', 'Study_Zone_Worker');
    }

    $data = $data->get();
    return response()->json($data);
  });

  Route::get('/data-2', function (Request $request) {
    $start = $request->get('start');
    $end = $request->get('end');
    $data = Flux::on('mysql')
      ->select(['origin', DB::raw('sum(volume)  AS volume,MONTH(date) as month')])
      ->join('health_zones', function ($q) {
        $q->on('health_zones.name', 'flux_24.origin');
      })
      ->join('provinces', function ($q) {
        $q->on('provinces.id', 'health_zones.province_id');
      })
      ->where('Destination', "Gombe")
      ->where('Immobility', '3h')
      ->where('Home_Category', 'Origin_Zone_Resident')
      ->where('provinces.name', 'Kinshasa')
      ->whereBetween('Date', [$start, $end])
      ->groupBy('origin', 'month')
      ->orderBy('volume', 'DESC')
      ->get();

    $dataGroup = $data->groupBy('origin');
    $dataFormatted = [];
    foreach ($dataGroup as $key => $value) {
      $avg = $value->avg('volume');
      $dataFormatted[] = [
        'origin' => $key,
        'volume' => round($avg)
      ];
    }
    return response()->json($dataFormatted);
  });

  Route::get('/data-3', function (Request $request) {
    $zone = $request->get('zone');
    $data = Flux30ZoneSum::select(['Hour', 'Date', DB::raw('sum("Volume")  AS volume')])
      ->where('Destination', $zone)
      ->whereBetween('Date', ['2020-11-17', '2020-12-18'])
      ->groupBy('Hour', 'Date')
      ->orderBy('Date')
      ->get();
    $dataAfter = Flux30ZoneSum::select(['Hour', 'Date', DB::raw('sum("Volume")  AS volume')])
      ->where('Destination', $zone)
      ->whereBetween('Date', ['2020-12-18', '2020-12-31'])
      ->groupBy('Hour', 'Date')
      ->orderBy('Date')
      ->get();

    $dataGoupAfter = $dataAfter->groupBy("Hour");
    $dataFormattedAfter = [];
    foreach ($dataGoupAfter as  $key => $value) {
      $avg = $value->average('volume');
      $dataFormattedAfter[] = [
        'date' => $key,
        'volume' => round($avg)
      ];
    }
    $dataGoup = $data->groupBy("Hour");
    $dataFormatted = [];
    foreach ($dataGoup as  $key => $value) {
      $avg = $value->average('volume');
      $dataFormatted[] = [
        'date' => $key,
        'volume' => round($avg)
      ];
    }
    return response()->json(['before' => $dataFormatted, 'after' => $dataFormattedAfter]);
  });

  Route::get('/data-3-out', function (Request $request) {
    $zone = $request->get('zone');
    $data = Flux30ZoneSum::select(['Hour', 'Date', DB::raw('sum("Volume")  AS volume')])
      ->where('Origin', $zone)
      ->whereBetween('Date', ['2020-11-17', '2020-12-18'])
      ->groupBy('Hour', 'Date')
      ->orderBy('Date')
      ->get();
    $dataAfter = Flux30ZoneSum::select(['Hour', 'Date', DB::raw('sum("Volume")  AS volume')])
      ->where('Origin', $zone)
      ->whereBetween('Date', ['2020-12-18', '2020-12-31'])
      ->groupBy('Hour', 'Date')
      ->orderBy('Date')
      ->get();

    $dataGoupAfter = $dataAfter->groupBy("Hour");
    $dataFormattedAfter = [];
    foreach ($dataGoupAfter as  $key => $value) {
      $avg = $value->average('volume');
      $dataFormattedAfter[] = [
        'date' => $key,
        'volume' => round($avg)
      ];
    }
    $dataGoup = $data->groupBy("Hour");
    $dataFormatted = [];
    foreach ($dataGoup as  $key => $value) {
      $avg = $value->average('volume');
      $dataFormatted[] = [
        'date' => $key,
        'volume' => round($avg)
      ];
    }
    return response()->json(['before' => $dataFormatted, 'after' => $dataFormattedAfter]);
  });

  Route::get('/data-4', function (Request $request) {
    $zone = $request->get('zone');
    $data = Flux24PresenceZone::select(['Zone as zone', 'Date as date', DB::raw('SUM("Volume")  AS volume')])
      // ->join('health_zones', function ($q) {
      //   $q->on('health_zones.name', 'flux24_presence_zones.Zone');
      // })
      // ->join('provinces', function ($q) {
      //   $q->on('provinces.id', 'health_zones.province_id');
      // })
      ->where('PresenceType', 'Nuit')
      ->where('Zone', $zone)
      ->whereRaw('"Home_Zone"="Zone"')
      // ->where('provinces.name', 'Kinshasa')
      ->whereBetween('Date', ['2020-02-01', '2020-12-31'])
      ->groupBy('Zone', 'Date')
      // ->orderBy('Volume', 'DESC')
      ->get();
    return response()->json($data);
  });
  Route::get('/data-4-1', function (Request $request) {
    // $zone = $request->get('zone');
    $data = Flux24PresenceZone::select(['Zone as zone', DB::raw('SUM("Volume")  AS volume')])
      ->join('health_zones', function ($q) {
        $q->on('health_zones.name', 'flux24_presence_zones.Zone');
      })
      ->join('provinces', function ($q) {
        $q->on('provinces.id', 'health_zones.province_id');
      })
      ->where('PresenceType', 'Nuit')
      ->whereRaw('"Home_Zone"="Zone"')
      ->where('provinces.name', 'Kinshasa')
      ->whereBetween('Date', ['2020-02-01', '2020-12-31'])
      ->groupBy('Zone', 'Date')
      ->orderBy('volume', 'DESC')
      ->get();

    $dataGoup = $data->groupBy("zone");
    $dataFormatted = [];

    foreach ($dataGoup as  $key => $value) {
      $avg = $value->average('volume');
      $dataFormatted[] = [
        'origin' => $key,
        'volume' => round($avg)
      ];
    }
    return response()->json($dataFormatted);
  });

  Route::get('/data-6', function (Request $request) {
    $zone = $request->get('zone');
    $data = Flux30ZoneSumByDate::select(['date as date', "Observation_Zone", 'volume'])
      ->where('Observation_Zone', $zone)
      ->whereBetween('date', ['2020-02-01', '2020-12-31'])
      ->orderBy('date')
      ->get();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
  });

  Route::get('/data-7-in', function (Request $request) {
    $data = Flux24Province::select(['Date as date', DB::raw('sum("Volume")  AS volume')])
      ->where('Destination', "Kinshasa")
      ->whereBetween('Date', ['2020-02-01', '2020-12-31'])
      ->groupBy('Date')
      ->orderBy('Date')
      ->get();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
  });

  Route::get('/data-7-out', function (Request $request) {
    $data = Flux24Province::select(['Date as date', DB::raw('sum("Volume")  AS volume')])
      ->where('Origin', "Kinshasa")
      ->whereBetween('Date', ['2020-02-01', '2020-12-31'])
      ->groupBy('Date')
      ->orderBy('Date')
      ->get();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
  });

  Route::get('/data-7-top-in', function (Request $request) {
    $date_start = $request->get('date_start');
    $date_end = $request->get('date_end');
    $data = Flux24Province::select(['Origin as origin', DB::raw('sum("Volume")  AS volume,date_trunc(\'month\', "Date") as month')])
      ->where('Destination', "Kinshasa")
      ->whereBetween('Date', [$date_start, $date_end])
      ->groupBy('Origin', 'month')
      ->orderBy('volume', 'DESC')
      // ->limit(10)
      ->get();
    $dataGroup = $data->groupBy('origin');

    $dataFormatted = [];
    foreach ($dataGroup as $key => $value) {
      $avg = $value->avg('volume');
      $dataFormatted[] = [
        'origin' => $key,
        'volume' => round($avg)
      ];
    }
    return response()->json($dataFormatted, 200, [], JSON_NUMERIC_CHECK);
  });
});


Route::group([
  'prefix' => 'dashboard',
  // 'middleware' => 'auth:dashboard',
], function () {
  Route::group([
    'prefix' => 'auth'
  ], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('lost-password', 'AuthController@asKResetPassword');
    Route::get('check-token/{token}', 'AuthController@checkResetPasswordToken');
    Route::post('reset-password/{user_id}', 'AuthController@resetPassword');
    Route::post('register', 'AuthController@store');
  });




  Route::group(['prefix' => 'flux', 'middleware' => 'cache.headers:private;max_age=3600'], function () {

    Route::group(['prefix' => 'africell'], function () {
      Route::get('health-zone', 'AfricelHealthZoneController@index'); //ok
      Route::group(['prefix' => 'presence'], function () {
        Route::get('provinces', 'AfricelTravelProvinceController@getByProvince'); //ok
        Route::get('zones', 'AfricelPresenceZoneController@getByName'); //ok
      });
      Route::group(['prefix' => 'hors-zone'], function () {
        Route::get('zones', 'AfricelFlowHorsZoneController@getByName'); //ok
      });
      Route::group(['prefix' => 'in-out'], function () {
        Route::get('zones', 'AfricelFlowInterZoneController@getByName'); //ok
      });
    });

    Route::group(['prefix' => 'predefined'], function () {
      Route::group(['prefix' => 'zones'], function () {
        Route::group(['prefix' => 'h-24'], function () {
          Route::get('/', 'DashBoardController@getFluxDataPredefined');
          Route::get('/daily', 'DashBoardController@getFluxDataPredefinedDaily');
          Route::get('/daily-compare', 'DashBoardController@getFluxDataPredefinedDailyCompare');
          Route::get('/daily-in', 'DashBoardController@getFluxDataPredefinedDailyIn');
          Route::get('/daily-out', 'DashBoardController@getFluxDataPredefinedDailyOut');
        });
      });
    });

    Route::group(['prefix' => 'origin'], function () {
      Route::group(['prefix' => 'zones'], function () {
        Route::group(['prefix' => 'h-24'], function () {
          Route::get('/', 'Flux24ZoneController@getFluxDataFromOrigin');
          Route::get('/daily', 'Flux24ZoneController@getFluxDataFromOriginDaily'); //ok
          Route::get('/daily-compare', 'Flux24ZoneController@getFluxDataFromOriginDailyCompare'); //ok
          Route::get('daily-in', 'Flux24ZoneController@getFluxDataFromOriginDailyIn'); //ok
          Route::get('daily-out', 'Flux24ZoneController@getFluxDataFromOriginDailyOut'); //ok
          Route::get('/global-in/province', 'Flux24ZoneController@getGlobalDataInByProvince'); //ok
          Route::get('/global-out/province', 'Flux24ZoneController@getGlobalDataOutByProvince'); //ok
        });
        Route::group(['prefix' => 'm-30'], function () {
          Route::get('/', 'DashBoardController@getFlux30DataFromOrigin');
          Route::get('/daily-compare', 'DashBoardController@getFlux30DataFromOriginDailyCompare');
          Route::get('/daily', 'DashBoardController@getFlux30DataFromOriginDaily');
          Route::get('daily-in', 'DashBoardController@getFlux30DataFromOriginDailyIn');
          Route::get('daily-out', 'DashBoardController@getFlux30DataFromOriginDailyOut');
        });

        Route::group(['prefix' => 'presence'], function () {
          Route::group(['prefix' => 'h-24'], function () {
            Route::get('/', 'DashBoardController@getFlux24PresenceZone'); //ok
            Route::get('/daily', 'DashBoardController@getFlux24PresenceZoneDaily'); //ok
            Route::get('/daily-in', 'Flux24PresenceZoneController@getFlux24PresenceDailyInZone'); //ok
          });
        });
      });
      Route::group(['prefix' => 'provinces'], function () {
        Route::group(['prefix' => 'h-24'], function () {
          Route::get('/', 'Flux24ProvinceController@getFluxDataFromOriginProvince'); //ok
          Route::get('/daily', 'Flux24ProvinceController@getFluxDataFromOriginDailyProvince'); //ok
          Route::get('/daily-compare', 'Flux24ProvinceController@getFluxDataFromOriginDailyProvinceCompare');
          Route::get('/daily-in', 'Flux24ProvinceController@getFluxDataFromOriginDailyInProvince'); //ok
          Route::get('/daily-out', 'Flux24ProvinceController@getFluxDataFromOriginDailyOutProvince'); //ok
          Route::get('/global-in', 'Flux24ProvinceController@getGlobalDataIn'); //ok
          Route::get('/global-out', 'Flux24ProvinceController@getGlobalDataOut'); //ok
        });
        Route::group(['prefix' => 'm-30'], function () {
          Route::get('/', 'Flux30ProvinceController@getFluxDataFromOriginProvince');
          Route::get('/daily', 'Flux30ProvinceController@getFluxDataFromOriginDailyProvince');
          Route::get('/daily-in', 'Flux30ProvinceController@getFluxDataFromOriginDailyInProvince');
          Route::get('/daily-out', 'Flux30ProvinceController@getFluxDataFromOriginDailyOutProvince');
        });

        Route::group(['prefix' => 'presence'], function () {
          Route::group(['prefix' => 'h-24'], function () {
            Route::get('/', 'DashBoardController@getFlux24PresenceProvince'); //ok
            Route::get('/daily', 'DashBoardController@getFlux24PresenceProvinceDaily'); //ok
            Route::get('/daily-in', 'Flux24PresenceProvinceController@getFlux24PresenceDailyInProvince'); //ok
          });
        });
      });
    });

    Route::group(['prefix' => 'hotspots'], function () {
      Route::get('list', 'FluxHotSpotController@index'); //ok
      Route::get('maps', 'Flux30ZoneSumController@getHotspotMaps'); //ok
      Route::get('tendance', 'Flux30ZoneSumController@getHotspotTendance'); //ok
      Route::get('daily', 'Flux30ZoneSumController@getHotspotDaily'); //ok
      Route::get('daily-date', 'Flux30ZoneSumController@getHotspotDailyByDate'); //ok
      Route::get('general', 'Flux30ZoneSumController@getHotspotGeneral'); //ok

      Route::group(['prefix' => 'types'], function () {
        Route::get('list', 'FluxHotSpotController@index'); //ok
        Route::get('maps', 'Flux30ZoneSumController@getHotspotTypeMaps'); //ok
        Route::get('tendance', 'Flux30ZoneSumController@getHotspotTypeTendance'); //ok
        Route::get('daily', 'Flux30ZoneSumController@getHotspotTypeDaily'); //ok
        Route::get('daily-date', 'Flux30ZoneSumController@getHotspotTypeDailyByDate');
        Route::get('general', 'Flux30ZoneSumController@getHotspotTypeGeneral'); //ok
      });
    });
  });
  Route::group(['prefix' => 'hospital-situations'], function () {
    Route::get('/by-hospital/{hospital_id}', 'HospitalSituationController@indexByHospital');

    Route::get('/agent-last-update', 'HospitalSituationController@getAgentLastUpdate'); //ok
  });

  Route::get('health-zones', 'FluxZoneController@getHealthZoneWithProvince');

  Route::resource('hospital-situations', "HospitalSituationController");

  Route::resource('hospitals-data', 'HospitalController');
  Route::group(['prefix' => 'hospitals'], function () {
    Route::get('/', 'HospitalController@getHospials'); //ok
    Route::get('/evolution/{hospital?}', 'HospitalController@getHospitalEvolution'); //ok
    Route::get('/totaux', 'HospitalController@getHospitalsTotaux'); //ok
  });
  Route::group(['prefix' => 'indicators'], function () {
    Route::group(['prefix' => 'zones'], function () {
      Route::get('/', 'IndicatorController@getIndicatorsZone'); //ok
    });
  });
  Route::get('orientation-medical-result', 'DashBoardController@getAllDiagnostics'); //ok
  Route::get('orientation-medical-stats', 'DashBoardController@getAllDiagnosticStat'); //ok
  Route::get('sondages', 'DashBoardController@getSondages'); //ok
  Route::get('cavid-cases', 'DashBoardController@getLastPandemicsRegion'); //ok
  Route::get('cavid-cases/statistics', 'DashBoardController@getLastPandemicsStatistics'); //ok
  Route::get('cavid-cases/statistics/daily', 'DashBoardController@getLastPandemicsStatisticsDaily'); //ok
  Route::post('flux-24', 'DashBoardController@getFluxData'); //ok
  Route::post('flux-24-daily', 'DashBoardController@getFluxDataDaily'); //ok
  Route::get('flux-zone', 'FluxZoneController@index'); //ok
  Route::get('flux-provinces', 'DashBoardController@getFluxProvinces'); //ok

  Route::get('/townships', 'DashBoardController@getTownships'); //ok

  Route::group(['prefix' => 'pandemics'], function () {
    Route::get('top-confirmed', 'PandemicController@getHealthZoneTopConfirmed');
  });
});

Route::post('self-test', 'SelfTestController@apiCovidTest');
