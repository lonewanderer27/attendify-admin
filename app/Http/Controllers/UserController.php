<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            "users" => $users,
            "error" => null,
            "success" => true
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "error" => true,
                "success" => false
            ], 422); // 422 Unprocessable Entity
        }

        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                "user" => $user,
                "token" => $token,
                "error" => null,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found or incorrect password",
                "error" => true,
                "success" => false
            ], 401); // 401 Unauthorized
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                "user" => $user,
                "error" => null,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found",
                "error" => "User not found",
                "success" => false
            ], 404); // 404 Not Found
        }
    }

    public function showByEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json([
                "user" => $user,
                "error" => null,
                "success" => true
            ]);
        } else {
            return response()->json([
                "message" => "User not found",
                "error" => "User not found",
                "success" => false
            ], 404); // 404 Not Found
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors(),
                "error" => true,
                "success" => false
            ], 422); // 422 Unprocessable Entity
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        if ($user) {
            return response()->json([
                "user" => $user,
                "message" => "User created",
                "error" => null,
                "success" => true
            ], 201); // 201 Created
        } else {
            return response()->json([
                "message" => "User not created",
                "error" => "User not created",
                "success" => false
            ], 500); // 500 Internal Server Error
        }
    }

    // ADMIN ROUTES

    public function adminShowSignup() {
        return view("signup");
    }

    public function adminLogout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/signup')->with('message', 'You have been logged out!');
    }

    public function adminLogin(Request $request) {
        $formFields = $request->validate([
            'email'=> ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials'
        ])->onlyInput();
    }

    public function adminStore(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        // login
        auth()->login($user);

        // redirect
        return redirect('/')->with('message', "User created and logged in!");
    }
}
