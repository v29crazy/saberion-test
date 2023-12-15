<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductAPIController;

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

Route::get('/products', 'ProductAPIController@index');
Route::post('/products', 'ProductAPIController@store');
Route::get('/products/{product}', 'ProductAPIController@show');
Route::put('/products/{product}', 'ProductAPIController@update');
Route::delete('/products/{product}', 'ProductAPIController@destroy');