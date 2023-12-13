<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\InvitedGuest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvitedGuestController extends Controller
{
    public function index()
    {
        $invited_guests = InvitedGuest::all();
        return response()->json([
            "invited_guests" => $invited_guests,
            "error" => null,
            "success" => true
        ]);
    }

    public function showByEvent($event_id)
    {
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found!",
                "message" => "Event not found!",
                "success" => false
            ], 404);
        }

        $guests = InvitedGuest::where('event_id', $event_id);

        return response()->json([
            "event" => $event,
            "invited_guests" => $guests,
            "error" => null,
            "success" => false
        ]);
    }

    public function inviteGuest(Request $request, $event_id)
    {
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found!",
                "message" => "Event not found!",
                "success" => false
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:user'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
                "success" => false
            ], 422);
        }


        $user = User::find('email', $request->email);

        if ($user) {
            $invitedGuest = InvitedGuest::create([
                'event_id' => $event_id,
                'user_id' => $user->id,
                'email' => $request->email,
            ]);

            return response()->json([
                "event" => $event,
                "message" => "Guest has been invited",
                "invited_guest" => $invitedGuest,
                "error" => null,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User cannot be found",
                "error" => "User cannot be found",
                "success" => true
            ]);
        }
    }

    public function inviteGuests(Request $request, $event_id)
    {
        $event = Event::find($event_id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found!",
                "message" => "Event not found!",
                "success" => false
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'emails' => 'required|array',
            'emails.*' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
                "success" => false
            ], 422);
        }

        $invitedGuests = [];

        foreach ($request->emails as $email) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $invitedGuest = InvitedGuest::create([
                    'event_id' => $event_id,
                    'user_id' => $user->id,
                    'email' => $email,
                ]);

                $invitedGuests[] = $invitedGuest;
            } else {
                // Handle the case where the user with the given email is not found
                // You may choose to skip or log these cases based on your requirements
            }
        }

        return response()->json([
            "event" => $event,
            "invited_guests" => $invitedGuests,
            "error" => null,
            "success" => true
        ]);
    }
}
