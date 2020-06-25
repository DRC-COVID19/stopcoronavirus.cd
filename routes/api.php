<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\PandemicStat;
use App\Http\Resources\PandemicStat as PandemicStatResource;

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
    return new PandemicStatResource(PandemicStat::orderBy('last_update', 'ASC')->get());
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
        Route::post('reset-password/{user_id}','AuthController@resetPassword');
    });
    Route::get('hospitals/', 'DashBoardController@getHospials');
    Route::get('orientation-medical-result', 'DashBoardController@getAllDiagnostics');
    Route::get('orientation-medical-stats', 'DashBoardController@getAllDiagnosticStat');
    Route::get('sondages', 'DashBoardController@getSondages');
    Route::get('cavid-cases', 'DashBoardController@getLastPandemicsRegion');
    Route::get('cavid-cases/statistics', 'DashBoardController@getLastPandemicsStatistics');
    Route::get('cavid-cases/statistics/daily', 'DashBoardController@getLastPandemicsStatisticsDaily');
    Route::post('flux-24', 'DashBoardController@getFluxData');
    Route::post('flux-24-daily', 'DashBoardController@getFluxDataDaily');
    Route::post('flux-24-origin', 'DashBoardController@getFluxDataFromOrigin');
    Route::post('flux-24-origin-provinces', 'DashBoardController@getFluxDataFromOriginProvince');
    Route::get('flux-zone', 'DashBoardController@getFluxZone');
    Route::get('flux-provinces', 'DashBoardController@getFluxProvinces');
    Route::post('flux-24-origin-daily', 'DashBoardController@getFluxDataFromOriginDaily');
    Route::post('flux-24-origin-daily-provinces', 'DashBoardController@getFluxDataFromOriginDailyProvince');
    Route::post('flux-24-origin-daily-in', 'DashBoardController@getFluxDataFromOriginDailyIn');
    Route::post('flux-24-origin-daily-out', 'DashBoardController@getFluxDataFromOriginDailyOut');

    Route::post('flux-24-origin-daily-in-provinces', 'DashBoardController@getFluxDataFromOriginDailyInProvince');
    Route::post('flux-24-origin-daily-out-provinces', 'DashBoardController@getFluxDataFromOriginDailyOutProvince');
});

Route::post('self-test', 'SelfTestController@apiCovidTest');
