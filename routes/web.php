<?php

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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::get('/activity', function () {
    return view('activity');
})->name('activity');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/event', function () {
    return view('event');
})->name('event');