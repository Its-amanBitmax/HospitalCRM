<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

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
            'registered_through' => 'required|in:email_otp,msg,whatsapp,google',
            'type' => 'nullable|in:ipd,opd,registered,discharged',
            'status' => 'nullable|in:active,inactive',
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

        // ✅ Create new user
        $user = User::create([
            'user_id' => $userId,
            'fullname' => $request->fullname,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'username' => $request->username,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'registered_through' => $request->registered_through,
            'type' => $request->type ?? 'registered',
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully.',
            'data' => $user,
        ], 201);
    }
}
