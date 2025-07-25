<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\LessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\testMailController;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
// Show the form to request a password reset link
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

// Handle the form POST to send the reset link email
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

// Show "Reset Password" form (via token from email)
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

// Handle actual password update submission
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [AuthApiData::class, 'index'])->name('dashboard');
// slider
Route::resource('slider', SliderController::class);
// News
Route::resource('news', NewsController::class);
// Course
Route::resource('course',CourseController::class);
// Route to get all lessons for a course (if needed via controller)
Route::get('/courses/{course}/lessons', [CourseController::class, 'lessons'])->name('courses.lessons');

// lession
Route::resource('lession',LessionController::class);
// assignment
Route::resource('assignment',AssignmentController::class);
// submission
Route::resource('submission', SubmissionController::class);
// notification
Route::resource('notification',NotificationController::class);
Route::patch('/notification/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

// payment
Route::resource('payment',PurchaseController::class);
// payment method
Route::resource('payment_method',PaymentMethodController::class);
// exercise
Route::resource('exercise',ExerciseController::class);
Route::get('/lessons/by-course/{courseId}', [ExerciseController::class, 'getLessonsByCourse']);

// content
Route::resource('content',ContentController::class);
Route::get('/lessons/by-course/{courseId}', [ContentController::class, 'getLessonsByCourse']);
Route::resource('comments', CommentController::class);

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/payments', \App\Http\Livewire\AdminPaymentAlerts::class)->name('payments');
});
Route::get('/exercise/{id}', [ExerciseController::class, 'index'])->name('exercise.byCourse');


// this is route for test mail 
Route::get('/test-mail',[testMailController::class,'index'])->name('test.mail');

