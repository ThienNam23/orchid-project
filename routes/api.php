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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

JsonApi::register('default')->routes(function ($api) {
    $api->resource('albums')->relationships(function ($relations) {
        $relations->hasMany('songs');
    });
    $api->resource('songs')->relationships(function ($relations) {
        $relations->hasOne('album');
        $relations->hasMany('artists');
        $relations->hasMany('categories');
    });
    $api->resource('artists')->relationships(function ($relations) {
        $relations->hasMany('songs');
    });
    $api->resource('categories')->relationships(function ($relations) {
        $relations->hasMany('songs');
    });
});
