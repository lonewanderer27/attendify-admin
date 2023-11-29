<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            "users" => $users,
            "error" => false,
            "success" => true
        ]);
    }

    public function login_secure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "error" => true,
                "success" => false
            ]);
        }

        $user = User::where("username", $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                "user" => $user,
                "token" => $token,
                "error" => false,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found or incorrect password",
                "error" => true,
                "success" => false
            ]);
        }
    }

    public function login_unsecure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "error" => true,
                "success" => false
            ]);
        }

        $user = User::where("username", $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                "user" => $user,
                "error" => false,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found or incorrect password",
                "error" => true,
                "success" => false
            ]);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json([
                "user" => $user,
                "error" => false,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found",
                "error" => true,
                "success" => false
            ]);
        }
    }

    public function showByUsername($username)
    {
        $user = User::findByUsername($username);
        if ($user) {
            return response()->json([
                "user" => $user,
                "error" => false,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found",
                "error" => true,
                "success" => false
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "username" => "required|unique:users",
            "email" => "required|unique:users",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "error" => true,
                "success" => false
            ]);
        }

        $user = User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        if ($user) {
            return response()->json([
                "user" => $user,
                "message" => "User created",
                "error" => false,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not created",
                "error" => true,
                "success" => false
            ]);
        }
    }
}
