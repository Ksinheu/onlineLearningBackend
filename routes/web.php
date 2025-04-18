<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubmissionController;
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
// lession
Route::resource('lession',LessionController::class);
// assignment
Route::resource('assignment',AssignmentController::class);
// submission
Route::resource('submission', SubmissionController::class);
// notification
Route::resource('notification',NotificationController::class);
Route::patch('/notification/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
// progress
Route::resource('progress',ProgressController::class);