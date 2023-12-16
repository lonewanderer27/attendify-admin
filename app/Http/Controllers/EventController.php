<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $eventsQuery = Event::query();

        // If start_date is provided, filter events from that date onwards
        if ($startDate) {
            $eventsQuery->whereDate('start', '>=', $startDate);
        }

        // If end_date is provided, filter events up to that date
        if ($endDate) {
            $eventsQuery->whereDate('start', '<=', $endDate);
        }

        $events = $eventsQuery->withCount('attendees')->get();

        return response()->json([
            "events" => $events,
            "error" => null,
            "success" => true
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $event = Event::withCount('attendees')->find($id);

        if (!$event) {
            return response()->json([
                "message" => "Event not found",
                "error" => "Event not found",
                "success" => false
            ], 404); // 404 Not Found
        }

        return response()->json([
            "event" => $event,
            "error" => null,
            "success" => true
        ]);
    }

    public function adminStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:events',
            'photo' => 'nullable|url',
            'description' => 'nullable|string',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required',
            'location' => 'required|string',
            'organizer' => 'required|string',
            'organizer_email' => 'required|email',
            'organizer_approval' => 'required|boolean',
            'user_id' => 'required|integer|exists:users,id',
            'invite_code' => 'required|string|unique:events'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validator->errors(),
                "error" => true,
                "success" => false
            ], 422); // 422 Unprocessable Entity
        }

        $event = Event::create([
            'title' => $request->title,
            'photo' => $request->photo,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'organizer' => $request->organizer,
            'organizer_email' => $request->organizer_email,
            'organizer_approval' => $request->organizer_approval,
            'user_id' => $request->user_id,
            'invite_code' => $request->invite_code
        ]);

        $eventWithAttendeesCount = Event::withCount('attendees')->find($event->id);

        if ($eventWithAttendeesCount) {
            return redirect('/')->with('success', 'Event created successfully');
        } else {
            return view('dashboard', [
                'events' => null,
            ])->with('error', 'Event not created');
        }
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:events',
            'photo' => 'nullable|url',
            'description' => 'nullable|string',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required',
            'location' => 'required|string',
            'organizer' => 'required|string',
            'organizer_email' => 'required|email',
            'organizer_approval' => 'required|boolean',
            'user_id' => 'required|integer|exists:users,id',
            'invite_code' => 'required|string|unique:events'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validator->errors(),
                "error" => true,
                "success" => false
            ], 422); // 422 Unprocessable Entity
        }

        $event = Event::create([
            'title' => $request->title,
            'photo' => $request->photo,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'organizer' => $request->organizer,
            'organizer_email' => $request->organizer_email,
            'organizer_approval' => $request->organizer_approval,
            'user_id' => $request->user_id,
            'invite_code' => $request->invite_code
        ]);

        $eventWithAttendeesCount = Event::withCount('attendees')->find($event->id);

        if ($eventWithAttendeesCount) {
            return response()->json([
                "event" => $eventWithAttendeesCount,
                "message" => 'Event created successfully',
                "error" => null,
                "success" => true
            ], 201); // 201 Created
        } else {
            return response()->json([
                "message" => "Event not created",
                "error" => "Event not created",
                "success" => false
            ], 500); // 500 Internal Server Error
        }
    }
}
