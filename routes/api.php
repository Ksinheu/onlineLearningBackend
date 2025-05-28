<?php

use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('customerRegister', [AuthApiData::class,'register']);
Route::get('Register', [AuthApiData::class,'indexApi']);
Route::post('login', [AuthApiData::class,'login']);
Route::post('logout', [AuthApiData::class, 'logout'])->middleware('auth:sanctum');
Route::get('/customer', [AuthApiData::class,'indexApi']);
Route::get('sliderApi', [SliderController::class, 'ApiIndex']);
Route::get('courseApi', [CourseController::class, 'ApiIndex']);
Route::get('/courseApi/{id}', [CourseController::class, 'show']);
Route::get('/lessonApi', [LessionController::class, 'ApiIndex']);
Route::get('/lessons/course/{courseId}', [LessionController::class, 'getLessonsByCourse']);

Route::get('newsApi', [NewsController::class, 'ApiIndex']);
// Route::get('progress',[ProgressController::class,'indexApi']);
// purchase
Route::middleware('auth:api')->post('/payments', [PurchaseController::class, 'store']);
// routes/api.php
// Route::middleware('auth:api')->post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
Route::post('/purchases', [PurchaseController::class, 'store']);
// Route::post('/payment', [AuthApiData::class, 'uploadPaySlip']);
Route::middleware('auth:sanctum')->post('/payment', [AuthApiData::class, 'uploadPaySlip']);

// payment method
Route::get('/payment_method',[PaymentMethodController::class,'indexApi']);
Route::post('/purchases/{id}/approve', [PurchaseController::class, 'approve']);