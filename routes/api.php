<?php

use App\Http\Controllers\Api\AgeRestrictionsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChaptersController;
use App\Http\Controllers\Api\CollectionsController;
use App\Http\Controllers\Api\DraftsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\WorksController;
use App\Http\Controllers\Api\WorksInProgressController;
use App\Http\Controllers\Api\GenresController;
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
Route::get('/wips/{id}/user',[WorksInProgressController::class,'user']);
Route::get('/wips/{id}/drafts',[WorksInProgressController::class,'drafts']);

/**
 * Routes for Age Restrictions
 */
Route::controller(AgeRestrictionsController::class)->group(function(){
    Route::get('/restrictions','index');
    Route::get('/restrictions/{id}','show');
    Route::post('/restrictions','store');
    Route::put('/restrictions/{id}','update');
    Route::delete('/restrictions/{id}','destroy');
    Route::get('/restrictions/{id}/works','work');
});

/**
 * Routes for drafts
 */
Route::controller(DraftsController::class)->group(function(){
    Route::get('/draft','index');
    Route::get('/draftFromWip/{wip}','wipIndex');
    Route::get('/draft/{id}','show');
    Route::post('/draft','store');
    Route::put('/draft/{id}','update');
    Route::delete('/draft/{id}','destroy');
    Route::get('/draft/{id}/wip','workInProgress');
});

/**
 * Routes for Genres
 */
Route::controller(GenresController::class)->group(function(){
    Route::get('/genre','index');
    Route::get('/genre/{id}','show');
    Route::post('/genre','store');
    Route::put('/genre/{id}','update');
    Route::delete('/genre/{id}','destroy');
    Route::get('/genre/{id}/works','work');
});

/**
 * Auth routes
 */
Route::get('/users',[AuthController::class,'index']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * Routes to pull user's resources
 */
Route::controller(UsersController::class)->group(function(){
    Route::get('/user/{id}/wips','wips');
});

/**
 * Routes protected by tokens
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/password', [AuthController::class, 'updatePassword']);
});

/**
 * Routes for the chapter controller
 */
Route::controller(ChaptersController::class)->group(function(){
    Route::get('/chapter','index');
    Route::get('/chapter/{id}','show');
    Route::post('/chapter','store');
    Route::put('/chapter/{id}','update');
    Route::delete('/chapter/{id}','destroy');
    Route::get('/chapter/{id}/work','work');
    Route::get('/chapter/{id}/history','readHistory');
});

Route::controller(WorksController::class)->group(function(){
    Route::get('/works','index');
    Route::get('/works/{id}','show');
    Route::post('/works','store');
    Route::put('/works/{id}','update');
    Route::delete('/works/{id}','destroy');
    Route::get('/works/{id}/author','author');
});

/**
 * Routes for collections
 */
Route::controller(CollectionsController::class)->group(function(){
    Route::get('/collections','index');
    Route::get('/collections/{id}','show');
    Route::post('/collections','store');
    Route::put('/collections/{id}','update');
    Route::delete('/collections/{id}','destroy');
    Route::get('/collections/{id}/works','works');
    Route::get('/collections/{id}/user','user');
});

