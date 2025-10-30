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
    // ✅ Basic validation (without unique rules, we'll handle uniqueness manually)
    $validator = Validator::make($request->all(), [
        'full_name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'mobile_no' => 'nullable|string|max:15',
        'age' => 'nullable|integer|min:1|max:120',
        'gender' => 'nullable|in:male,female,other',
        'full_address' => 'nullable|string',
        'username' => 'required|string',
        'password' => 'required|string|min:8',
        'registered_through' => 'required|in:email,msg,whatsapp,offline',
        'type' => 'nullable|in:ipd,opd,emergency,registered,online',
        'status' => 'nullable|in:active,inactive,discharged',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'father_spouse_name' => 'nullable|string|max:255',
        'alternate_no' => 'nullable|string|max:15',
        'id_proof_type' => 'nullable|string|max:255',
        'id_number' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 400);
    }

    // ✅ Check at least one of email or mobile_no
    if (empty($request->email) && empty($request->mobile_no)) {
        return response()->json([
            'status' => false,
            'message' => 'Either email or mobile number is required.',
        ], 400);
    }

    // ✅ Find existing user (by email or mobile_no)
    $existingUser = User::where('email', $request->email)
        ->orWhere('mobile_no', $request->mobile_no)
        ->first();

    // ✅ Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('image'), $imageName);
        $imagePath = 'image/' . $imageName;
    }

    // ✅ If user exists → update only allowed fields
    if ($existingUser) {
        $existingUser->update([
            'full_name' => $request->full_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'full_address' => $request->full_address,
            'password' => $request->password,
            'registered_through' => $request->registered_through,
            'type' => $request->type ?? $existingUser->type,
            'status' => $request->status ?? $existingUser->status,
            'image' => $imagePath ?? $existingUser->image,
            'father_spouse_name' => $request->father_spouse_name,
            'alternate_no' => $request->alternate_no,
            'id_proof_type' => $request->id_proof_type,
            'id_number' => $request->id_number,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully (email, mobile, and username unchanged).',
            'data' => $existingUser,
        ], 200);
    }

    // ✅ Create new user if not found
    $date = now()->format('Ymd');
    $username = strtoupper(substr($request->username, 0, 3));
    $userId = 'USR' . $date . $username . rand(100, 999);

    $user = User::create([
        'user_id' => $userId,
        'full_name' => $request->full_name,
        'age' => $request->age,
        'gender' => $request->gender,
        'full_address' => $request->full_address,
        'username' => $request->username,
        'password' => $request->password,
        'mobile_no' => $request->mobile_no,
        'email' => $request->email,
        'registered_through' => $request->registered_through,
        'type' => $request->type ?? 'registered',
        'status' => $request->status ?? 'active',
        'image' => $imagePath,
        'father_spouse_name' => $request->father_spouse_name,
        'alternate_no' => $request->alternate_no,
        'id_proof_type' => $request->id_proof_type,
        'id_number' => $request->id_number,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User registered successfully.',
        'data' => $user,
    ], 200);
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
