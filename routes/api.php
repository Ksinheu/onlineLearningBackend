<?php

use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('customerRegister', [AuthApiData::class,'register']);
Route::get('/customers/{id}', [AuthApiData::class, 'show']);
Route::post('login', [AuthApiData::class,'login']);
Route::post('logout', [AuthApiData::class, 'logout'])->middleware('auth:sanctum');
Route::get('/customer', [AuthApiData::class,'indexApi']);
Route::get('sliderApi', [SliderController::class, 'ApiIndex']);
Route::get('courseApi', [CourseController::class, 'ApiIndex']);
Route::get('/courseApi/{id}', [CourseController::class, 'showApi']);
Route::get('/lessonApi', [LessionController::class, 'ApiIndex']);
Route::get('/lessons/course/{courseId}', [LessionController::class, 'getLessonsByCourse']);
Route::get('newsApi', [NewsController::class, 'ApiIndex']);
Route::post('/payments', [PurchaseController::class, 'store']);
Route::get('/customer/completed-courses', [PurchaseController::class, 'getCompletedCourses']);
// payment method
Route::get('/payment_method',[PaymentMethodController::class,'indexApi']);
Route::post('/comments',[CommentController::class,'store']);
Route::get('/content',[ContentController::class,'indexApi']);
Route::post('/purchases/{id}/approve', [PurchaseController::class, 'approve']);
Route::post('/reset-password', [AuthApiData::class, 'resetPassword']);
Route::post('/forgot-password', [AuthApiData::class, 'forgotPassword']);


Route::get('/test-mail', function () {
    Mail::raw('This is a test email from Laravel.', function ($message) {
        $message->to('youremail@example.com')
                ->subject('Test Email');
    });

    return 'Mail sent!';
});