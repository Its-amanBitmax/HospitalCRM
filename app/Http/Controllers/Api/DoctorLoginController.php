<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Appointment;
use App\Models\PatientCheckup;
use Illuminate\Support\Facades\DB;

class DoctorLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password'   => 'required'
        ]);

        // Find employee using employee_code
        $employee = Employee::where('employee_code', $request->identifier)->first();

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        // Check if employee is active
        if ($employee->status !== 'Active') {
            return response()->json(['error' => 'Account is inactive'], 403);
        }

        // Check password
        if (!Hash::check($request->password, $employee->password)) {
            return response()->json(['error' => 'Wrong password'], 401);
        }

        // Fetch profession from professions table
        $profession = DB::table('professions')
            ->where('employee_id', $employee->id)
            ->first();

        // If no profession found
        if (!$profession) {
            return response()->json(['error' => 'No profession assigned'], 403);
        }

        // Check if title is Doctor
        if (trim(strtolower($profession->title)) !== "doctor") {
            return response()->json(['error' => 'Only Doctors can login here'], 403);
        }

        // Create token
        $token = $employee->createToken('Doctor API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'employee' => $employee,
            'token' => $token
        ]);
    }



    public function logout(Request $request)
{
    
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Logout successful'
    ]);
}


    public function getProfile(Request $request)
    {
        $employee = auth('sanctum')->user();

        if (!$employee) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Load related data
        $employee->load([
            'department',
            'qualifications',
            'documents',
            'payroll',
            'addresses',
            'familyDetails',
            'shifts',
            'professions',
            'specialities',
            'schedules',
            
        ]);

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'employee' => $employee
        ]);
    }


public function updateProfile(Request $request)
{
    $employee = auth('sanctum')->user();

    if (!$employee) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Validation for specified fields
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:employees,email,' . $employee->id,
        'phone' => 'sometimes|string|max:15',
        'gender' => 'sometimes|string|in:Male,Female,Other',
        'date_of_birth' => 'sometimes|date',
        'image' => 'sometimes|image|max:2048',
        'address' => 'sometimes|array',
        'address.street' => 'sometimes|string|max:255',
        'address.city' => 'sometimes|string|max:100',
        'address.state' => 'sometimes|string|max:100',
        'address.country' => 'sometimes|string|max:100',
        'address.postal_code' => 'sometimes|string|max:20',
    ]);

    // Update core employee attributes
    $employee->fill($request->only(['name', 'email', 'phone', 'gender', 'date_of_birth']));

    // Handle image upload if present
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('employees', 'public');
        $employee->image = $path;
    }

    $employee->save();

    // Update or create Home address specifically
    if ($request->has('address')) {
        $addressData = $request->input('address');
        $address = $employee->addresses()->where('address_type', 'Home')->first();

        if ($address) {
            $address->update($addressData);
        } else {
            $employee->addresses()->create(array_merge($addressData, ['address_type' => 'Home']));
        }
    }

    // Load all relationships
    $employee->load([
        'department',
        'qualifications',
        'documents',
        'payroll',
        'addresses',
        'familyDetails',
        'shifts',
        'professions',
        'specialities',
        'schedules',
    ]);

    // **ADD THIS: Convert image path to full URL**
    if ($employee->image) {
        $employee->image = asset('storage/' . $employee->image);
    }

    return response()->json([
        'message' => 'Profile updated successfully',
        'employee' => $employee
    ]);
}














    
    public function getAppointmentsAndConsultations(Request $request)
    {
        $employee = auth('sanctum')->user();

        if (!$employee) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get appointments for this doctor
        $appointments = Appointment::where('doctor_id', $employee->id)
            ->with(['user', 'relative'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Get consultations (patient checkups) - note: patient_visits table does not have doctor_id, so returning all
        $consultations = PatientCheckup::with(['visit.user'])
            ->orderBy('checkup_date', 'desc')
            ->get();

        return response()->json([
            'message' => 'Appointments and consultations retrieved successfully',
            'appointments' => $appointments,
            'consultations' => $consultations
        ]);
    }
}
