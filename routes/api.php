<?php

use Illuminate\Http\Request;

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

Route::post('city', 'CityController@create');
Route::post('delivery-times', 'DeliverytimeController@create');
Route::post('city/{city_id}/delivery-times', 'CityController@attach');
Route::post('city/{city_id}/exclude/', 'CityController@exclude');
Route::post('city/{city_id}/excludeall/', 'CityController@excludeAll');
Route::post('city/{city_id}/delivery-dates-times/{number_of_days_to_get}', 'CityController@getDeliveryDatesTimes');