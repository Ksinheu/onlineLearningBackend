<?php

use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ForgotPasswordController;
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
Route::get('/lessons/{courseId}', [LessionController::class, 'getLessonsByCourse']);
Route::get('/lessons/count/course/{courseId}', [LessionController::class, 'countLessonsByCourse']);
Route::get('newsApi', [NewsController::class, 'ApiIndex']);
Route::post('/payments', [PurchaseController::class, 'store']);

Route::get('/customer/completed-courses', [PurchaseController::class, 'getCompletedCourses']);
// payment method
Route::get('/payment_method',[PaymentMethodController::class,'indexApi']);
Route::post('/comments',[CommentController::class,'store']);
Route::get('/comments/course/{course_id}', [CommentController::class, 'getByCourse']);
Route::get('/comments/count/course/{courseId}', [CommentController::class, 'countCommentsByCourse']);

Route::get('/contents/course/{courseId}',[ContentController::class,'indexApi']);
Route::get('/contents/count/course/{id}', [ContentController::class, 'countByCourseId']);

Route::get('/exercise/{courseId}',[ExerciseController::class,'showApi']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode']);
Route::post('/otp-login', [ForgotPasswordController::class, 'loginWithOtp']);

Route::post('/send-email', function (Request $request) {
    $validated = $request->validate([
        'to' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string',
    ]);

    Mail::raw($validated['message'], function ($msg) use ($validated) {
        $msg->to($validated['to'])
            ->subject($validated['subject']);
    });

    return response()->json(['status' => 'Email sent successfully']);
});