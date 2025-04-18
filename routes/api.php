<?php

use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('customerRegister', [AuthApiData::class,'register']);
Route::post('login', [AuthApiData::class,'login']);
Route::post('logout', [AuthApiData::class, 'logout'])->middleware('auth:sanctum');
Route::get('sliderApi', [SliderController::class, 'ApiIndex']);
Route::get('courseApi', [CourseController::class, 'ApiIndex']);
Route::get('/courseApi/{id}', [CourseController::class, 'show']);
Route::get('lessonApi', [LessionController::class, 'ApiIndex']);
Route::get('newsApi', [NewsController::class, 'ApiIndex']);
Route::get('progress',[ProgressController::class,'indexApi']);
// purchase
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/payments', [PurchaseController::class, 'indexApi']);
    Route::post('/payments', [PurchaseController::class, 'store']);
    Route::patch('/payments/{id}', [PurchaseController::class, 'update']);
    Route::delete('/payments/{id}', [PurchaseController::class, 'destroy']);
});