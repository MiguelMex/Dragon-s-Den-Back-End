<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorksInProgressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

/**
 * Routes for the works in progress
 */
Route::get('/wips',[WorksInProgressController::class,'index']);
Route::get('/wips/{id}',[WorksInProgressController::class,'show']);
Route::post('/wips',[WorksInProgressController::class,'store']);
Route::put('/wips/{id}',[WorksInProgressController::class,'update']);
Route::delete('/wips/{id}',[WorksInProgressController::class,'destroy']);

/**
 * Auth routes
 */
Route::get('/users',[AuthController::class,'index']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * Routes protected by tokens
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/password', [AuthController::class, 'updatePassword']);
});

