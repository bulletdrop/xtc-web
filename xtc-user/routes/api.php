<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CreateAccountController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LicenseController;
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

Route::post(
    '/create-account',
    'CreateAccountController@verify'
);

Route::group(['prefix' => 'license'], function(){
    Route::post('redeem', function (Request $request) {
        return LicenseController::redeem($request);
    });

    Route::get('fetch', function(Request $request){
        return LicenseController::fetchJson($request);
    });
});

//group
Route::group(['prefix' => 'auth'], function(){
    Route::post('login', function (Request $request) {
        return LoginController::verify($request);
    });

    Route::post('register', function (Request $request) {
        return CreateAccountController::verify($request);
    });

    Route::group(['prefix' => 'session'], function(){
        Route::post('verify', function (Request $request){
            return SessionController::verify($request);
        });

        Route::get('logout', function (Request $request){
            return SessionController::logout($request);
        });
    });
});
