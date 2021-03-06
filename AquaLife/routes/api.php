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

Route::get('/fish', 'Api\FishApi@index')->name("api.fish.index");
Route::get('/fish/{id}', 'Api\FishApi@show')->name("api.fish.show");
Route::get('/accessories', 'Api\AccessoryApi@index')->name("api.accessory.index");
Route::get('/accessories/{id}', 'Api\AccessoryApi@show')->name("api.accessory.show");
