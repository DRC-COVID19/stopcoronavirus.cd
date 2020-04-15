<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "PageController@index")->name('home');
Route::get('/mesures-de-protection-contre-le-coronavirus', "PageController@officialMeasure")->name('officialMeasure');
Route::get('/directives-prises-par-le-gouvernement', "PageController@preventativeMeasures")->name('preventativeMeasures');
Route::get('/idees-recues-fake-news', "PageController@stereotypes")->name('stereotypes');

Route::get('/orientation-medicale','SelfTestController@diagnostic')->name('diagnostic');
Route::group(['prefix' => 'self-test'], function () {
    Route::get('/{step}','SelfTestController@back')->name('selfTest.back');
    Route::get('/', 'SelfTestController@seltTest')->name('selfTest.get');
    Route::post('/', 'SelfTestController@storeSelfTest')->name('seltTest.post');
});
