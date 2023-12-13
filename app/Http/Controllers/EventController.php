<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $events = Event::all();
        return response()->json([
            "events" => $events,
            "error" => false,
            "success" => true
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $event = Event::where("id", $id)->first();

        if (!$event) {
            return response()->json([
                "error" => "Event not found",
                "success" => false
            ]);
        }

        return response()->json([
            "event" => $event,
            "error" => false,
            "success" => true
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:events',
            'photo' => 'nullable|url',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'location' => 'required|string',
            'capacity' => 'required|integer',
            'organizer' => 'required|string',
            'organizer_email' => 'required|email',
            'user_id' => 'required|integer|exists:users,id',
            'invite_code' => 'required|string|unique:events'
        ]);


        if ($validator->fails()) {
            return response()->json([
                "error" => null,
                "errors" => $validator->errors(),
                "success" => false
            ]);
        }

        $event = Event::create([
            'title' => $request->title,
            'photo' => $request->photo,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'organizer' => $request->organizer,
            'organizer_email' => $request->organizer_email,
            'user_id' => $request->user_id,
            'invite_code' => $request->invite_code
        ]);

        if ($event) {
            return response()->json([
                "event" => $event,
                "error" => null,
                "success" => true
            ]);
        } else {
            return response()->json([
                "error" => "Event not created",
                "success" => false
            ], 500);
        }
    }
}
