<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    public function index() {
        $otp_codes = OTP::all();
        return response()->json([
            "success" => true,
            "error" => false,
            "data" => $otp_codes
        ]);
    }

    public function store(Request $request)
    {
        // this function fetches the user_id from the request
        // and creates a new OTP for that user
        // then returns the OTP

        $validator = Validator::make($request->all(), [
            "user_id" => "required|exists:users,id"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "error" => true,
                "success" => false
            ]);
        }

        $otp = OTP::create([
            "user_id" => $request->user_id,
            "code" => rand(100000, 999999)
        ]);

        return response()->json([
            "message" => "OTP created successfully",
            "error" => false,
            "success" => true,
            "data" => $otp
        ]);
    }
}
