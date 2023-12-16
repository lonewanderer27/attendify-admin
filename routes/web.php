<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name("dashboard")->middleware('auth');
Route::post('/events', [EventController::class, "adminStore"])->name("events")->middleware('auth');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/signup', [UserController::class, 'adminShowSignup'])->name("signup");
Route::post("/signup", [UserController::class, 'adminStore'])->name("signup");
Route::post("/signin", [UserController::class, 'adminLogin'])->name('signin');
Route::post("/logout", [UserController::class, 'adminLogout'])->name('logout');

Route::get('/activity', function () {
    return view('activity');
})->name('activity');

Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

Route::get('/event', function () {
    return view('event');
})->name('event');

Route::get('/welcome', function() {
    return view('welcome');
})->name('welcome');
