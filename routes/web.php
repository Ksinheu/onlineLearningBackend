<?php

use App\Http\Controllers\AuthApiData;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;

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
Route::get('/slider', function () {
    return view('slider');
});
// Route::get('/slider',[SliderController::class,'index'])->name('slider');
Route::get('/sliders', [SliderController::class, 'store'])->name('sliders');
Route::post('/upload', [SliderController::class, 'store'])->name('image.upload');
// News
Route::get('/news', function () {
    return view('News.store');
});
Route::post('/uploadNews', [NewsController::class, 'store'])->name('news.upload');
