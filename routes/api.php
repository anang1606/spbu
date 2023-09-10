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
Route::post('user/logout', 'Api\UserController@logoutmesin');
Route::post('user/cekpin', 'Api\UserController@cekpin');
Route::post('user/gantipin', 'Api\UserController@gantipin');
Route::post('customer/cek', 'Api\CustomerController@cekdata');
Route::post('product/getall', 'Api\ProductController@getall');
Route::post('product/cekharga', 'Api\ProductController@cekharga');
Route::post('sales/create', 'Api\SalesController@createsales');
//===========test=============
Route::post('user/qrcodemake', 'Api\UserController@qrcodemake');
Route::post('user/qrcoderead', 'Api\UserController@qrcoderead');
