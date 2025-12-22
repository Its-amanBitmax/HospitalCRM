<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private function generateUsername($fullName)
    {
        // Generate base username from full_name (first 3 letters, uppercase)
        $baseUsername = strtoupper(substr(str_replace(' ', '', $fullName), 0, 3));

        // Ensure uniqueness by appending numbers if needed
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function register(Request $request)
    {
        // ✅ Validation
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',

            'email'     => 'nullable|email|unique:users,email|required_without:mobile_no',
            'mobile_no' => 'nullable|string|max:15|unique:users,mobile_no|required_without:email',

            'username' => 'nullable|string|unique:users,username',
            'password' => 'required|string|min:8',

            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|in:male,female,other',
            'full_address' => 'nullable|string',

            'registered_through' => 'required|in:email,msg,whatsapp,offline',
            'type'   => 'nullable|in:ipd,opd,emergency,registered,online',
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
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ AUTO CREATE UNIQUE USER_ID (HERE ✅)
        $userId = 'USR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));

        // ✅ Image upload
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        // ✅ Create NEW user
        $user = User::create([
            'user_id' => $userId, // ✅ auto-generated
            'full_name' => $request->full_name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'username' => $request->username,

            'age' => $request->age,
            'gender' => $request->gender,
            'full_address' => $request->full_address,

            'password' => Hash::make($request->password),

            'registered_through' => $request->registered_through,
            'type' => $request->type,
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
            'data' => [
                'id' => $user->id,
                'user_id' => $user->user_id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'mobile_no' => $user->mobile_no,
                'image' => $user->image ? asset('/storage/'  . $user->image) : null,
            ]
        ], 201);
    }


    public function login(Request $request)
    {
        //  Validate request
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

        //  Find user by username
        $user = User::where('username', $request->username)->first();

        // If user not found
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }

        // If password doesn't match
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid username or password.',
            ], 401);
        }

        //  Check if user is active
        if ($user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive.',
            ], 403);
        }

        //  Generate token using Sanctum
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

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        // ✅ Check active status
        if ($user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive.',
            ], 403);
        }

        // ✅ Convert image path to full URL
        if (!empty($user->image)) {
            $user->image = asset($user->image);
        } else {
            $user->image = null;
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => $user,
        ], 200);
    }


    public function logout(Request $request)
    {
        //  Get authenticated user
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

    public function updateProfile(Request $request)
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

        // ✅ Validate request (including email, mobile_no as nullable)
        $validator = Validator::make($request->all(), [
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'mobile_no' => 'nullable|string|max:15|unique:users,mobile_no,' . $user->id,
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|in:male,female,other',
            'full_address' => 'nullable|string',
            'username' => 'nullable|string|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'registered_through' => 'nullable|in:email,msg,whatsapp,offline',
            'type' => 'nullable|in:ipd,opd,emergency,registered,online',
            'status' => 'nullable|in:active,inactive,discharged',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:15',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:255',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // ✅ Handle image upload
        $imagePath = $user->image; // Keep existing image if not updated
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        // ✅ Update user fields (including email, mobile_no)
        $user->update([
            'full_name' => $request->full_name ?? $user->full_name,
            'email' => $request->email ?? $user->email,
            'mobile_no' => $request->mobile_no ?? $user->mobile_no,
            'age' => $request->age ?? $user->age,
            'blood_group' => $request->blood_group ?? $user->blood_group,
            'gender' => $request->gender ?? $user->gender,
            'full_address' => $request->full_address ?? $user->full_address,
            'username' => $request->username ?? $user->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'registered_through' => $request->registered_through ?? $user->registered_through,
            'type' => $request->type ?? $user->type,
            'status' => $request->status ?? $user->status,
            'image' => $imagePath,
            'father_spouse_name' => $request->father_spouse_name ?? $user->father_spouse_name,
            'alternate_no' => $request->alternate_no ?? $user->alternate_no,
            'id_proof_type' => $request->id_proof_type ?? $user->id_proof_type,
            'id_number' => $request->id_number ?? $user->id_number,
            
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully.',
            'data' => $user,
        ], 200);
    }

    public function getUserById($id)
    {
        // Find user by ID
        $user = User::find($id);

        // If user not found
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User retrieved successfully.',
            'data' => $user,
        ], 200);
    }


    public function checkUserExists(Request $request)
    {
        // Step 1: Validate input
        $validator = Validator::make($request->all(), [
            'email'      => 'nullable|email:rfc,dns', // strict email validation
            'mobile_no'  => 'nullable|string|regex:/^[0-9]{10,15}$/', // only digits, 10-15 length
        ], [
            'email.email'       => 'Please enter a valid email address.',
            'mobile_no.regex'   => 'Mobile number must be 10 to 15 digits only.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Step 2: Check at least one field is provided
        if (empty($request->email) && empty($request->mobile_no)) {
            return response()->json([
                'status'  => false,
                'message' => 'Either email or mobile number is required.',
            ], 400);
        }

        // Step 3: Search user
        $query = User::query();

        if ($request->filled('email')) {
            $query->where('email', $request->email);
        }

        if ($request->filled('mobile_no')) {
            $query->orWhere('mobile_no', $request->mobile_no);
        }

        $user = $query->first();

        // Step 4: Return response
        return response()->json([
            'status'   => true,
            'exists'   => $user ? true : false,
            'username' => $user?->username ?? null,
        ], 200);
    }

    public function updateCredentials(Request $request)
    {
        // ✅ Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email',
            'mobile_no' => 'nullable|string|max:15',
            'username' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        
        if (empty($request->email) && empty($request->mobile_no)) {
            return response()->json([
                'status' => false,
                'message' => 'Either email or phone number is required.',
            ], 400);
        }

        
        $user = User::when($request->email, function ($query) use ($request) {
            $query->where('email', $request->email);
        })
            ->when($request->mobile_no, function ($query) use ($request) {
                $query->where('mobile_no', $request->mobile_no);
            })
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // ✅ Update logic based on username existence
        if (!empty($user->username)) {
            // If username already exists, prevent username update
            if (!empty($request->username) && $request->username !== $user->username) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username already exists, cannot update username.',
                ], 400);
            }

            // Only update password
            $user->update([
                'password' => bcrypt($request->password),
            ]);

            $message = 'Password updated successfully.';
        } else {
            // If username is null or empty, username is required
            if (empty($request->username)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username is required since it does not exist.',
                ], 400);
            }

            // ✅ Check if the new username already exists for another user
            $exists = User::where('username', $request->username)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'This username is already taken by another user.',
                ], 400);
            }

            // ✅ Update both username and password
            $user->update([
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);

            $message = 'Username and password updated successfully.';
        }

        // ✅ Return response
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'mobile_no' => $user->mobile_no,
            ],
        ], 200);
    }
}
