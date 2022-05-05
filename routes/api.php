<?php

use App\Http\Controllers\API\v1\{
    AdminController,
    AuthController,
    ConfirmUpdateRequestController,
    DeclineUpdateRequestController,
    UpdateController
};
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

Route::prefix('v1')->group(function (){
    Route::apiResource('admins', AdminController::class)->only('store');

    Route::prefix('admins')->group(function (){

        Route::controller(AuthController::class)->group(function (){

            Route::post('login', 'login');
            Route::post('logout', 'logout')->middleware('auth:sanctum');
        });

        Route::middleware('auth:sanctum')->middleware('role:admin')->group(function (){

            Route::post('updates/{id}/confirm', ConfirmUpdateRequestController::class);
            Route::post('updates/{id}/decline', DeclineUpdateRequestController::class);

            Route::apiResource('updates', UpdateController::class)->only('index', 'store');
        });
    });

});




