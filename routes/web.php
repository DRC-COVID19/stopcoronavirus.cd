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
Route::get('/official_measures', "PageController@officialMeasure")->name('officialMeasure');
Route::get('/preventative_measures', "PageController@preventativeMeasures")->name('preventativeMeasures');
Route::get('/stereotypes', "PageController@stereotypes")->name('stereotypes');
