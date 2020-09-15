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

//best pratice to route protected, avoid use middleware in controller you may forget
Route::group(['middleware' => 'auth:api'], function() {
    // get user profile
    Route::get('findUser', 'API\UserController@search');

    Route::post('change-password', 'API\ChangePasswordController@store');


});

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('user', 'API\UserController');
    Route::apiResource('product', 'API\ProductController');
});

