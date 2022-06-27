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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'as' => 'v1.' ], function () {
    Route::post('auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('auth/forgot-password', [App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
    Route::post('auth/reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
    Route::middleware('auth:api')->post('auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::middleware('auth:api')->post('auth/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword']);
    Route::middleware('auth:api')->get('auth/user', [App\Http\Controllers\Api\AuthController::class, 'user']);

    Route::apiResource('positions', App\Http\Controllers\Api\PositionController::class);
});
