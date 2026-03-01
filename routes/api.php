<?php

use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\WorksInProgressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [TestController::class,'index']);

/**
 * Routes for the works in progress
 */
Route::get('/wips',[WorksInProgressController::class,'index']);
Route::get('/wips/{id}',[WorksInProgressController::class,'show']);
Route::post('/wips',[WorksInProgressController::class,'store']);
Route::put('/wips/{id}',[WorksInProgressController::class,'update']);
Route::delete('/wips/{id}',[WorksInProgressController::class,'destroy']);
