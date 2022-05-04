<?php

use App\Http\Controllers\API\v1\{
    AdminController,
    AuthController
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
        Route::post('login', [AuthController::class, 'login']);
    });


});




