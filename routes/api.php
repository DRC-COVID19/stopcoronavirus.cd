<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


use App\PandemicStat;
use App\Http\Resources\PandemicStat as PandemicStatResource;

Route::get('/lastpandemicstat', function () {
    return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->first());
});

Route::get('/pandemicstats', function () {
    return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->get());
});
