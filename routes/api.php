<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\InvitedGuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
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
//Route::get('user/{id}', [UserController::class, 'show']);
Route::get('users/id/{id}', [UserController::class, 'show']);
Route::get('users/email/{email}', [UserController::class, 'showByEmail']);
Route::post('users', [UserController::class, 'store']);

Route::post("login", [UserController::class, "login"]);
Route::post('register', [UserController::class, 'store']);

Route::get('events', [EventController::class, 'index']);
//Route::get('event/{id}', [EventController::class, 'show']);
Route::get('events/id/{id}', [EventController::class, 'show']);
Route::get('events/id/{id}/attendees', [AttendeeController::class, 'showByEvent']);
Route::post('events', [EventController::class, 'store']);

Route::get('attendees', [AttendeeController::class, 'index']);
Route::get("attendees/event/id/{id}", [AttendeeController::class, 'showByEvent']);
Route::get("attendees/event/id/{id}/pending", [AttendeeController::class, 'showPendingAttendeesByEvent']);
Route::get("attendees/event/id/{event_id}/user/id/{user_id}", [AttendeeController::class, 'showByEventAndUser']);
Route::post("attendees", [AttendeeController::class, 'createByEvent']);
Route::get("attendees/id/{id}", [AttendeeController::class, 'show']);
Route::post("attendees/id/{id}/approve", [AttendeeController::class, 'approveAttendance']);
Route::post("attendees/id/{id}/deny", [AttendeeController::class, 'denyAttendance']);

Route::get("invited_guests", [InvitedGuestController::class, 'index']);
Route::get("invited_guests/event/id/{id}", [InvitedGuestController::class, 'showByEvent']);
Route::post('invited_guests/event/id/{id}', [InvitedGuestController::class, 'inviteGuests']);
