<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // ---------------------------
    // Fetch All Teacher Usernames
    // ---------------------------
    public function fetchTeacherUsernames()
    {
        // Return full objects with id & name
        $teachers = User::where('role', 'teacher')->get(['id', 'username as name']);
        return response()->json($teachers);
    }


    // ---------------------------
    // API Registration
    // ---------------------------
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role ?? 'Teacher', 
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    // ---------------------------
    // API Login
    // ---------------------------
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid password'
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $user
        ]);
    }

    // ---------------------------
    // API Logout
    // ---------------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
