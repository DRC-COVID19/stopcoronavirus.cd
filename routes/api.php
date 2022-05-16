<?php

use App\Http\Controllers\ChangeLogController;
use App\Http\Controllers\HospitalSituationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\PandemicStat;
use App\Http\Resources\PandemicStat as PandemicStatResource;
use Encore\Admin\Form\Row;

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


// Route::post('/migrate-hospital-situation-controller', 'MigrateHospitalSituationController@migrateToCompletedForm');


Route::get('/lastpandemicstat', function () {
  return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->first());
});

Route::get('/pandemicstats', function () {
  return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->get());
});

Route::get('/debug-sentry', function () {
  throw new Exception('My first Sentry error!');
});

Route::get('/pandemicstatsasc', function () {
  /**
   * Récupère la situation epidémiologique
   */
  return new PandemicStatResource(PandemicStat::orderBy('last_update', 'ASC')->get());
});

Route::post('/medicale-orientation', 'DiagnosticController@store');

Route::group(['prefix' => 'admin_users'], function () {
  Route::get('/filter', 'AdministratorController@filter');
});

Route::apiResource('admin_users', 'AdministratorController');

Route::group(['prefix' => 'admin_users'], function () {
  Route::get('/agents-hospital', 'AdministratorController@getAgentHospitals');
});

Route::apiResource('admin_roles', 'AdminRoleController');

Route::group(['prefix' => 'pandemic-stats'], function () {
  Route::get('/filter', 'PandemicStatController@filter');
  Route::get('/', 'PandemicStatController@index');
  Route::post('/', 'PandemicStatController@store');
  Route::get('/{pandemic_stat_id}', 'PandemicStatController@show');
  Route::put('/{pandemic_stat_id}', 'PandemicStatController@update');
  Route::delete('/{pandemic_stat_id}', 'PandemicStatController@destroy');
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

  Route::group(['prefix' => 'change-log'], function () {
    Route::post('read', 'ChangeLogController@setChangeLogRead');
    Route::get('/filter', 'ChangeLogController@filter');
  });
  Route::apiResource('change-log', "ChangeLogController");


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
    Route::get('/{last_update}/hospital_id/{hospital_id}', 'HospitalSituationController@getSituationsByHospitalAndLastUpdate');
    Route::get('/agent-last-update', 'HospitalSituationController@getAgentLastUpdate');
  });

  Route::group(['prefix' => 'completed_forms'], function () {
    Route::get('/by-hospital/{hospital_id}', 'CompletedFormController@indexByHospital');
    Route::get('/get-latest-hospital-update', 'CompletedFormController@getLatestHospitalUpdate');
    Route::get('/{last_update}/hospital_id/{hospital_id}', 'CompletedFormController@getSituationsByHospitalAndLastUpdate');

    Route::post('/get-aggregated-by-hospitals', "CompletedFormController@getAggregatedByHospitals");
    Route::post('/get-data-by-hospitals', "CompletedFormController@getDataByHospitals");
    Route::get('/get-all-filtered', "CompletedFormController@getAllFiltered");

    Route::get('/check-last_update/{hospital_id}/{last_update}', 'CompletedFormController@checkLastUpdate');
  });

  Route::group(['prefix' => 'hospitals-data'], function () {
    Route::get('/by-paginate', 'HospitalController@indexByPaginate');
    Route::get('/filter', 'HospitalController@filter');
    Route::get('/get-agents', 'HospitalController@getAgents');
    Route::patch('/update-by-admin/{hospital_id}', 'HospitalController@updateByAdmin');
    Route::patch('/{id}/reject-agent', 'HospitalController@rejectAgent');
  });

 /***
 * forms routes
 */
  Route::group(['prefix' => 'forms'], function () {
    Route::get('/recent-form', 'FormController@recentForm');
    Route::get('/filter', 'FormController@filter');
    Route::get('/get-form-filtered', 'FormController@getFormFiltered');
  });



  Route::get('health-zones', 'FluxZoneController@getHealthZoneWithProvince');
  // Route::apiResource('townships','TownshipController');
  Route::apiResource('hospital-situations', "HospitalSituationController");
  Route::resource('hospital-situations-new', "HospitalSituationNewController");
  Route::post('get-by-hospital-situations', "HospitalSituationController@getSituationByHospitals");
  // Route::post('get-by-hospital-situations', "HospitalSituationNewController@getSituationByHospitals");
  Route::post('get-situations', "HospitalSituationNewController@getSituations");
  Route::resource('hospital-situations', "HospitalSituationController");

  Route::resource('hospitals-data', 'HospitalController');
  Route::apiResource('forms', 'FormController');
  Route::apiResource('form-steps', 'FormStepController');
  Route::resource('form-recurrences', 'FormRecurrenceController');
  Route::apiResource('completed_forms', 'CompletedFormController');
  Route::group(['prefix' => 'forms'], function () {
    Route::get('/filter', 'FormController@filter');
  });
  Route::group(['prefix' => 'form-steps'], function () {
    Route::get('/filter', 'FormStepController@filter');
    Route::get('get-form/{form}', 'FormStepController@getFormStepByForm');
  });
  Route::group(['prefix' => 'hospitals'], function () {
    Route::get('/', 'HospitalController@getHospitals'); //ok
    Route::get('/all-Without-agent', 'HospitalController@allWithoutAgent'); //ok
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

  Route::apiResource('form-field-types', 'FormFieldTypeController');
  Route::apiResource('form-fields', 'FormFieldController');
  Route::group(['prefix' => 'form-fields'], function () {
    Route::get('get-form/{form}', 'FormFieldController@getFormFieldByForm');
  });
});

Route::post('self-test', 'SelfTestController@apiCovidTest');
