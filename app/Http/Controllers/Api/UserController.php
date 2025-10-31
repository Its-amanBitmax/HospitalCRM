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
        if (!\Hash::check($request->password, $user->password)) {
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
        //  Get authenticated user
        $user = Auth::user();

        // If user not authenticated (though middleware should handle this)
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        //  Check if user is active
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

        // ✅ Validate request (excluding email, mobile_no)
        $validator = Validator::make($request->all(), [
            'full_name' => 'nullable|string|max:255',
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

        // ✅ Update user fields (excluding email, mobile_no)
        $user->update([
            'full_name' => $request->full_name ?? $user->full_name,
            'age' => $request->age ?? $user->age,
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
        // Validate request: at least one of email or phone, and password required
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

        // Check if at least one of email or phone is provided
        if (empty($request->email) && empty($request->phone)) {
            return response()->json([
                'status' => false,
                'message' => 'Either email or phone is required.',
            ], 400);
        }

        // Find user by email or phone
        $user = User::where('email', $request->email)
            ->orWhere('mobile_no', $request->phone)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Check if username exists
        if ($user->username) {
            // Username exists, only update password
            if ($request->username) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username already exists, cannot update username.',
                ], 400);
            }
            $user->update([
                'password' => bcrypt($request->password),
            ]);
            $message = 'Password updated successfully.';
        } else {
            // No username, update both username and password
            if (!$request->username) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username is required since it does not exist.',
                ], 400);
            }
            $user->update([
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);
            $message = 'Username and password updated successfully.';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $user,
        ], 200);
    }
}
