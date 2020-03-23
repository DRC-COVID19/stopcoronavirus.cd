<?php

use App\Admin\Controllers\AlertController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\PostController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('posts', "PostController");
    $router->resource('alerts', "AlertController");
    $router->resource('categories', "CategoryController");
    $router->resource('sms-diffusions', "SmsDiffusionController");
    $router->resource('provinces', "ProvinceController");
    $router->resource('pandemic-stats', "PandemicStatController");
});
