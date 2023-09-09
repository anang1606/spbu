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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('testing','Api\TestController@index');

Route::get('upgrade','Api\ApiController@upgrade');

Route::post('user/login', 'Api\UserController@login');
Route::post('user/cekpin', 'Api\UserController@cekpin');

Route::post('sales/create', 'Api\SalesController@createsales');

Route::post('user/qrcodemake', 'Api\UserController@qrcodemake');
Route::post('user/qrcoderead', 'Api\UserController@qrcoderead');
