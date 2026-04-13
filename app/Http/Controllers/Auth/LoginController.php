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
    // Fetch Active Teacher Usernames
    // ---------------------------
    public function fetchTeacherUsernames()
    {
        $teachers = User::where('role', 'teacher')
            ->where('status', 'active')
            ->select('id', 'username as name')
            ->orderBy('id', 'desc')
            ->get(); // keep this simple (no need pagination here)

        return response()->json($teachers);
    }


    // ---------------------------
    // Fetch All Users (PAGINATED 🔥)
    // ---------------------------
    public function fetchAllUsers(Request $request)
    {
        $query = User::query();

        // -------------------------
        // SEARCH
        // -------------------------
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // -------------------------
        // FILTER: STATUS
        // -------------------------
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // -------------------------
        // FILTER: ROLE
        // -------------------------
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // -------------------------
        // FETCH DATA
        // -------------------------
        $users = $query
            ->select('id', 'username', 'email', 'role', 'status')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($users);
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
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'active', // ✅ updated
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
        $user = User::where('email', $request->email)
            ->where('status', 'active') // ✅ updated
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found or deactivated'
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
    // Update User
    // ---------------------------
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $request->validate([
            'username' => 'sometimes|string|unique:users,username,' . $id,
            'email' => 'sometimes|string|email|unique:users,email,' . $id,
            'role' => 'sometimes|in:admin,teacher',
            'password' => 'nullable|min:6'
        ]);

        $user->username = $request->username ?? $user->username;
        $user->email = $request->email ?? $user->email;
        $user->role = $request->role ?? $user->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    // ---------------------------
    // Deactivate User
    // ---------------------------
    public function deactivateUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->status = 'deactivated'; // ✅ updated
        $user->save();

        return response()->json([
            'message' => 'User deactivated successfully'
        ]);
    }

    // ---------------------------
    // Activate User (NEW 🔥)
    // ---------------------------
    public function activateUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->status = 'active'; // ✅ activate
        $user->save();

        return response()->json([
            'message' => 'User activated successfully'
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
