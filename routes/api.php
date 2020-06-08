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

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('hospitals/', 'DashBoardController@getHospials');
    Route::get('orientation-medical-result', 'DashBoardController@getAllDiagnostics');
    Route::get('orientation-medical-stats','DashBoardController@getAllDiagnosticStat');
    Route::get('sondages', 'DashBoardController@getSondages');
    Route::get('cavid-cases', 'DashBoardController@getLastPandemicsRegion');
    Route::post('flux-24', 'DashBoardController@getFluxData');
    Route::post('flux-24-origin', 'DashBoardController@getFluxDataFromOrigin');
    Route::get('flux-zone', 'DashBoardController@getFluxZone');

});

Route::post('self-test', 'SelfTestController@apiCovidTest');
