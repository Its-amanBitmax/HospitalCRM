<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Mail\OtpMail;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'otp_email' => $request->email, 'otp_expires' => now()->addMinutes(10)]);

        try {
            Mail::to($request->email)->send(new OtpMail($otp));
            return response()->json(['message' => 'OTP sent to your email.']);
        } catch (\Exception $e) {
            // Log the OTP for testing if mail fails
            \Log::info("OTP for {$request->email}: $otp (Mail failed: " . $e->getMessage() . ")");
            return response()->json(['message' => 'OTP generated. Check server logs if email not received.']);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        if (session('otp') != $request->otp || now()->greaterThan(session('otp_expires'))) {
            return response()->json(['error' => 'Invalid or expired OTP.'], 400);
        }

        session(['otp_verified' => true]);

        return response()->json(['message' => 'OTP verified.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        if (!session('otp_verified') || session('otp_email') != $request->email) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $admin = Admin::where('email', session('otp_email'))->first();
        $admin->password = Hash::make($request->password);
        $admin->save();

        session()->forget(['otp', 'otp_email', 'otp_expires', 'otp_verified']);

        return response()->json(['message' => 'Password reset successfully.']);
    }

    public function registeredUsers()
    {
        return view('admin.registered-users');
    }

    public function getRegisteredUsers()
    {
        $users = \App\Models\User::all();
        return response()->json($users);
    }

    public function updateRegisteredUser(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:ipd,opd,registered,discharged',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = \App\Models\User::findOrFail($id);

        $updateData = $request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $updateData['image'] = 'image/' . $imageName;
        }

        $user->update($updateData);

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function addRegisteredUser(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'phone_no' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:ipd,opd,registered,discharged',
            'status' => 'required|in:active,inactive',
            'registered_through' => 'required|in:email_otp,msg,whatsapp,google',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique user_id with date and username
        $date = now()->format('Ymd');
        $username = strtoupper(substr($request->username, 0, 3));
        $userId = 'USR' . $date . $username . rand(100, 999);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        $user = \App\Models\User::create([
            'user_id' => $userId,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'type' => $request->type,
            'status' => $request->status,
            'registered_through' => $request->registered_through,
            'image' => $imagePath,
        ]);

        return response()->json(['message' => 'User added successfully.']);
    }

    public function deleteRegisteredUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function dischargedPatients()
    {
        return view('admin.discharged-patients');
    }

    public function getDischargedPatients()
    {
        $users = \App\Models\User::where('type', 'discharged')->get();
        return response()->json($users);
    }

    public function updateDischargedPatient(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:ipd,opd,registered,discharged',
            'status' => 'required|in:active,inactive'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update($request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']));
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteDischargedPatient($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function ipdPatients()
    {
        return view('admin.ipd-patients');
    }

    public function getIpdPatients()
    {
        $users = \App\Models\User::where('type', 'ipd')->get();
        return response()->json($users);
    }

    public function updateIpdPatient(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:ipd,opd,registered,discharged',
            'status' => 'required|in:active,inactive'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update($request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']));
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteIpdPatient($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function opdPatients()
    {
        return view('admin.opd-patients');
    }

    public function getOpdPatients()
    {
        $users = \App\Models\User::where('type', 'opd')->get();
        return response()->json($users);
    }

    public function updateOpdPatient(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:ipd,opd,registered,discharged',
            'status' => 'required|in:active,inactive'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $user->update($request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']));
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteOpdPatient($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
