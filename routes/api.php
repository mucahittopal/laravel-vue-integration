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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/is-email-unique', 'Auth\RegisterController@check_email')->name('check.email');
Route::post('/credential-exist', 'Auth\LoginController@credential_exist')
    ->name('api.credential.exist');
//Route::post('/countries', 'CountryController@api_countries')
//    ->name('api.countries.index');
Route::get('/countries/{id}/zipcodes', 'Api\CountryController@zipcodes')->name('api.countries.zipcodes');
Route::apiResource('/countries', 'Api\CountryController', ['as' => 'api']);
Route::apiResource('/states', 'Api\StateController', ['as' => 'api']);
Route::apiResource('/cities', 'Api\CityController', ['as' => 'api']);
Route::get('/languages', function(){
    return \App\Http\Resources\LanguageResource::collection(\App\Language::orderBy('name')->get());
});
Route::get('/services', function(){
    return \App\Http\Resources\ServiceResource::collection(\App\Service::orderBy('name')->get());
});
Route::get('/referrers', function (){
    return \App\Http\Resources\ReferrerResource::collection(\App\Referrer::all());
});
Route::post('/search/services', 'ServiceController@api_search_service');
Route::post('/search/service-tags', 'ServiceController@api_search_service_tag');
Route::post('/search/service-or-tag', 'ServiceController@api_search_service_or_tag');
Route::post('/search/city-or-zipcode', 'Api\CityController@api_search_cityorzipcode');
