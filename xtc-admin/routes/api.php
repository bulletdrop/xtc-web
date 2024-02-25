<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Redis;

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

Route::group(['prefix' => 'auth'], function(){
    Route::post('login', function (Request $request) {
        return LoginController::login($request);
    });

    Route::get('currentAdmin', function (Request $request) {
        return LoginController::getCurrentAdmin($request);
    });

    Route::post('changePassword', function (Request $request){
        return LoginController::changePassword($request);
    });
});

Route::group(['prefix' => 'products'], function(){
    Route::post('store', function (Request $request) {
        return ProductController::store($request);
    });

    Route::post('delete', function (Request $request) {
        return ProductController::delete($request);
    });
});

Route::group(['prefix' => 'tickets'], function(){
    Route::post('delete', function (Request $request) {
        return TicketController::delete($request);
    });
});

Route::group(['prefix' => 'license'], function(){
    Route::post('store', function (Request $request) {
        return LicenseController::store($request);
    });

    Route::post('removeDay', function (Request $request){
        return LicenseController::removeDay($request);
    });
});

Route::group(['prefix' => 'stats'], function(){
    Route::post('save', function (Request $request) {
        return StatsController::saveStats($request);
    });
});
