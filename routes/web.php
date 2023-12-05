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

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/activity', function () {
    return view('activity');
});

Route::get('/support', function () {
    return view('support');
});

Route::get('settings', function () {
    return view('settings');
});

Route::get('event', function () {
    return view('event');
});