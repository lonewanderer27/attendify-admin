<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'index']);
Route::get('users/id/{id}', [UserController::class, 'show']);
Route::get('users/username/{username}', [UserController::class, 'showByUsername']);
Route::post('users', [UserController::class, 'store']);

Route::post('login/unsecure', [UserController::class, 'login_unsecure']);
Route::post('login/secure', [UserController::class, 'login_secure']);