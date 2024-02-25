<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoaderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getDLL', function (Request $request) {
    return LoaderController::getDLL($request);
});

Route::group(['prefix' => 'auth'], function(){
    Route::post('login', function (Request $request) {
        return UserController::login($request);
    });

    Route::post('hwid', function (Request $request) {
        return UserController::loginHWID($request);
    });

    Route::post('ban', function (Request $request) {
        return UserController::BanByHWID($request);
    });
});
