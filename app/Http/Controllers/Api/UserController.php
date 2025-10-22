<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // ✅ Validate request
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone_no' => 'nullable|string|max:15|unique:users,phone_no',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'registered_through' => 'required|in:email_otp,msg,whatsapp,google',
            'type' => 'nullable|in:ipd,opd,registered,discharged',
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // ✅ Check at least one of email or phone
        if (empty($request->email) && empty($request->phone_no)) {
            return response()->json([
                'status' => false,
                'message' => 'Either email or phone number is required.',
            ], 400);
        }

        // ✅ Generate unique user_id like USR0001, USR0002
        $lastUser = User::orderBy('id', 'desc')->first();
        $nextId = $lastUser ? $lastUser->id + 1 : 1;
        $userId = 'USR' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // ✅ Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        // ✅ Create new user
        $user = User::create([
            'user_id' => $userId,
            'fullname' => $request->fullname,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'username' => $request->username,
            'password' => $request->password,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'registered_through' => $request->registered_through,
            'type' => $request->type ?? 'registered',
            'status' => $request->status ?? 'active',
            'image' => $imagePath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully.',
            'data' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        // ✅ Validate request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // ✅ Find user by username
        $user = User::where('username', $request->username)->first();

        // If user not found
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }

        // If password doesn't match
        if (!\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }

        // ✅ Check if user is active
        if ($user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive.',
            ], 403);
        }

        // ✅ Generate token using Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful.',
            'data' => $user,
            'token' => $token,
        ], 200);
    }

    public function getProfile()
    {
        // ✅ Get authenticated user
        $user = Auth::user();

        // If user not authenticated (though middleware should handle this)
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        // ✅ Check if user is active
        if ($user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive.',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        // ✅ Get authenticated user
        $user = Auth::user();

        // If user not authenticated (though middleware should handle this)
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        // ✅ Delete the current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
