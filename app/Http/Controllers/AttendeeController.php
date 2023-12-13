<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\InvitedGuest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $attendees = Attendee::all();
        return response()->json([
            "attendees" => $attendees,
            "error" => null,
            "success" => true
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $attendee = Attendee::find($id);

        if ($attendee) {
            return response()->json([
                "attendee" => $attendee,
                "error" => null,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "Attendee not found",
                "error" => "Attendee not found",
                "success" => false
            ], 404); // 404 Not Found
        }
    }

    public function showByEvent($event_id): \Illuminate\Http\JsonResponse
    {
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found!",
                "message" => "Event not found!",
                "success" => false
            ], 404); // 404 Not Found
        }

        $attendees = Attendee::where('event_id', $event_id)->get();

        return response()->json([
            "event" => $event,
            "attendees" => $attendees,
            "error" => null,
            "success" => true
        ]);
    }

    public function approveAttendance($attendee_id): \Illuminate\Http\JsonResponse
    {
        $attendee = Attendee::find($attendee_id);

        if (!$attendee) {
            return response()->json([
                "message" => "Attendee not found!",
                "error" => "Attendee not found!",
                "success" => false,
            ], 404); // 404 Not Found
        }

        $attendee->status = true;
        $attendee->save();

        return response()->json([
            "attendee" => $attendee,
            "message" => "Attendance approved",
            "error" => null,
            "success" => true,
        ]);
    }

    public function createByEvent(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'event_id' => 'required|integer|exists:events,id'
        ]);

        // Add a custom rule to check for uniqueness of user_id and event_id
        $validator->addExtension('unique_attendee', function ($attribute, $value, $parameters) {
            return Attendee::where('user_id', $parameters[0])
                ->where('event_id', $parameters[1])
                ->doesntExist();
        });

        $validator->sometimes('user_id', 'unique_attendee:'.$request->user_id.','.$request->event_id, function ($input) {
            return true; // This callback is executed only when validation is required
        });

        if ($validator->fails()) {
            return response()->json([
                "error" => "Validation failed",
                "errors" => $validator->errors(),
                "success" => false,
            ], 422); // 422 Unprocessable Entity
        }

        // Check if the user exists in InvitedGuests
        $isInvited = InvitedGuest::where('user_id', $request->user_id)
            ->where('event_id', $request->event_id)
            ->exists();

        $status = (bool) $isInvited;

        $attendee = Attendee::create([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'status' => $status
        ]);

        if ($attendee) {
            $statusCode = $status ? 200 : 202; // 200 OK or 202 Accepted

            return response()->json([
                "attendee" => $attendee,
                "message" => $status ? "Attendance approved" : "Attendance pending",
                "error" => null,
                "success" => true
            ], $statusCode);
        } else {
            return response()->json([
                "error" => "Attendance not attended",
                "message" => "Attendance not attended",
                "success" => false
            ], 500); // 500 Internal Server Error
        }
    }
}
