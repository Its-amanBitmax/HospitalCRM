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
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
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

        // Map old names to new names
        $updateData['full_name'] = $updateData['fullname'];
        $updateData['mobile_no'] = $updateData['phone_no'];
        $updateData['full_address'] = $updateData['address'];
        unset($updateData['fullname'], $updateData['phone_no'], $updateData['address']);

        $user->update($updateData);

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'mobile_no' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:20',
            'full_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
            'visit_type' => 'nullable|in:OPD,Emergency,Appointment',
            'date_of_visit' => 'nullable|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'department_consultant' => 'nullable|string|max:255',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
            'registered_through' => 'nullable|in:email,msg,whatsapp,offline',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique user_id with date and username
        $date = now()->format('Ymd');
        $username = $request->username ? strtoupper(substr($request->username, 0, 3)) : 'USR';
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
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => $request->password ? Hash::make($request->password) : null,
            'age' => $request->age,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'father_spouse_name' => $request->father_spouse_name,
            'alternate_no' => $request->alternate_no,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
            'id_proof_type' => $request->id_proof_type,
            'id_number' => $request->id_number,
            'type' => $request->type,
            'status' => $request->status,
            'registered_through' => $request->registered_through,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.registered-users')->with('success', 'User created successfully.');
    }

    public function showUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_no' => 'max:20',
            'password' => 'nullable|string|min:8',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:20',
            'full_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
            'visit_type' => 'nullable|in:OPD,Emergency,Appointment',
            'date_of_visit' => 'nullable|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'department_consultant' => 'nullable|string|max:255',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = \App\Models\User::findOrFail($id);

        $updateData = $request->only([
            'full_name', 'username', 'email', 'mobile_no', 'age', 'gender', 'blood_group',
            'father_spouse_name', 'alternate_no', 'full_address', 'city', 'state', 'pin_code',
            'visit_type', 'date_of_visit', 'chief_complaint', 'referred_by', 'department_consultant',
            'id_proof_type', 'id_number', 'type', 'status'
        ]);

        // Handle password update
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $updateData['image'] = 'image/' . $imageName;
        }

        $user->update($updateData);

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
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
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
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
            'full_name' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->phone_no,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'full_address' => $request->address,
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

    public function emergencyPatients()
    {
        return view('admin.emergency-patients');
    }

    public function getEmergencyPatients()
    {
        $users = \App\Models\User::where('type', 'emergency')->get();
        return response()->json($users);
    }

    public function updateEmergencyPatient(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $updateData = $request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']);
        // Map old names to new names
        $updateData['full_name'] = $updateData['fullname'];
        $updateData['mobile_no'] = $updateData['phone_no'];
        $updateData['full_address'] = $updateData['address'];
        unset($updateData['fullname'], $updateData['phone_no'], $updateData['address']);
        $user->update($updateData);
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteEmergencyPatient($id)
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
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $updateData = $request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']);
        // Map old names to new names
        $updateData['full_name'] = $updateData['fullname'];
        $updateData['mobile_no'] = $updateData['phone_no'];
        $updateData['full_address'] = $updateData['address'];
        unset($updateData['fullname'], $updateData['phone_no'], $updateData['address']);
        $user->update($updateData);
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
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $updateData = $request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']);
        // Map old names to new names
        $updateData['full_name'] = $updateData['fullname'];
        $updateData['mobile_no'] = $updateData['phone_no'];
        $updateData['full_address'] = $updateData['address'];
        unset($updateData['fullname'], $updateData['phone_no'], $updateData['address']);
        $user->update($updateData);
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteOpdPatient($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function dischargedPatients()
    {
        return view('admin.discharged-patients');
    }

    public function getDischargedPatients()
    {
        $users = \App\Models\User::where('status', 'discharged')->get();
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
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged'
        ]);

        $user = \App\Models\User::findOrFail($id);
        $updateData = $request->only(['fullname', 'username', 'email', 'phone_no', 'age', 'gender', 'address', 'type', 'status']);
        // Map old names to new names
        $updateData['full_name'] = $updateData['fullname'];
        $updateData['mobile_no'] = $updateData['phone_no'];
        $updateData['full_address'] = $updateData['address'];
        unset($updateData['fullname'], $updateData['phone_no'], $updateData['address']);
        $user->update($updateData);
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteDischargedPatient($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

  public function patientRegistration()
{
    // Logged-in user (admin or receptionist)
    $user = Auth::guard('admin')->user() ?? Auth::guard('receptionist')->user();

    // SAME DETAILS for both
    $admin = \App\Models\Admin::first(); 

    return view('admin.patient-registration', [
        'user' => $user,
        'admin' => $admin
    ]);
}


}
