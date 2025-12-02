<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Appointment;
use App\Models\PatientCheckup;
use Illuminate\Support\Facades\DB;

class DoctorLoginController extends Controller
{
public function login(Request $request)
{
    // ✅ Validation
    $validator = Validator::make($request->all(), [
        'employee_code' => 'required|string',
        'password'      => 'required|string|min:6',
    ], [
        'employee_code.required' => 'Employee code is required',
        'password.required'      => 'Password is required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // ✅ Find employee
    $employee = Employee::where('employee_code', $request->employee_code)->first();

    if (!$employee) {
        return response()->json([
            'status' => false,
            'message' => 'Employee not found',
        ], 404);
    }

    // ✅ Check active status
    if ($employee->status !== 'Active') {
        return response()->json([
            'status' => false,
            'message' => 'Account is inactive',
        ], 403);
    }

    // ✅ Password verify
    if (!Hash::check($request->password, $employee->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    // ✅ Fetch profession
    $profession = DB::table('professions')
        ->where('employee_id', $employee->id)
        ->first();

    if (!$profession) {
        return response()->json([
            'status' => false,
            'message' => 'No profession assigned',
        ], 403);
    }

    // ✅ Only Doctors allowed
    if (strtolower(trim($profession->title)) !== 'doctor') {
        return response()->json([
            'status' => false,
            'message' => 'Only Doctors can login here',
        ], 403);
    }

    // ✅ Remove old tokens (optional but recommended)
    $employee->tokens()->delete();

    // ✅ Create token
    $token = $employee->createToken('Doctor API Token')->plainTextToken;

    return response()->json([
        'status'  => true,
        'message' => 'Login successful',
        'employee'=> $employee,
        'token'   => $token,
    ], 200);
}




    public function logout(Request $request)
    {
        $employee = auth('sanctum')->user();

        if (!$employee) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $employee->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
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

        // Full image URL
        if ($employee->image) {
            $employee->image = asset('storage/' . $employee->image);
        }

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'employee' => $employee
        ]);
    }

public function updateProfile(Request $request)
{
    $employee = auth('sanctum')->user();

    if (!$employee) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    // ✅ Validator
    $validator = Validator::make($request->all(), [
        'name'              => 'sometimes|string|max:255',
        'email'             => 'sometimes|email|unique:employees,email,' . $employee->id,
        'phone'             => 'sometimes|string|max:15',
        'gender'            => 'sometimes|string|in:Male,Female,Other',
        'date_of_birth'     => 'sometimes|date',
        'image'             => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',

        'address'           => 'sometimes|array',
        'address.street'    => 'sometimes|string|max:255',
        'address.city'      => 'sometimes|string|max:100',
        'address.state'     => 'sometimes|string|max:100',
        'address.country'   => 'sometimes|string|max:100',
        'address.postal_code'=> 'sometimes|string|max:20',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // ✅ Update employee basic fields
    $employee->fill($request->only([
        'name',
        'email',
        'phone',
        'gender',
        'date_of_birth'
    ]));

    // ✅ Image upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('employees', 'public');
        $employee->image = $path;
    }

    $employee->save();

    // ✅ Home Address (Update or Create)
    if ($request->has('address')) {
        $addressData = $request->input('address');

        $address = $employee->addresses()
            ->where('address_type', 'Home')
            ->first();

        if ($address) {
            $address->update($addressData);
        } else {
            $employee->addresses()->create(
                array_merge($addressData, ['address_type' => 'Home'])
            );
        }
    }

    // ✅ Load relations
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

    // ✅ Full image URL
    if ($employee->image) {
        $employee->image = asset('storage/' . $employee->image);
    }

    return response()->json([
        'status'  => true,
        'message' => 'Profile updated successfully',
        'employee'=> $employee
    ], 200);
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

        // Get consultations (patient checkups) filtered by doctor
        $consultations = PatientCheckup::with(['visit.user'])
            ->whereHas('visit.consultantAssignment', function ($query) use ($employee) {
                $query->where('employee_id', $employee->id);
            })
            ->orderBy('checkup_date', 'desc')
            ->get();

        return response()->json([
            'message' => 'Appointments and consultations retrieved successfully',
            'appointments' => $appointments,
            'consultations' => $consultations
        ]);
    }

    // public function updateAppointmentStatus(Request $request)
    // {
    //     $employee = auth('sanctum')->user();

    //     if (!$employee) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     // Validate request
    //     $validator = Validator::make($request->all(), [
    //         'appointment_id' => 'required|exists:appointments,appointment_id',
    //         'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
    //         'type' => 'required|in:Appointment,Consultation',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // Find the appointment and ensure it belongs to the authenticated doctor
    //     $appointment = Appointment::where('appointment_id', $request->appointment_id)
    //         ->where('doctor_id', $employee->id)
    //         ->where('type', $request->type)
    //         ->first();

    //     if (!$appointment) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Appointment not found or does not belong to you.'
    //         ], 404);
    //     }

    //     // Update the status
    //     $appointment->update(['status' => $request->status]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Appointment status updated successfully.',
    //         'appointment' => $appointment
    //     ]);
    // }
    
    
    public function updateAppointmentStatus(Request $request)
    {
        $employee = auth('sanctum')->user();

        if (!$employee) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,appointment_id',
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
            'type' => 'required|in:Appointment,consultation',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the appointment and ensure it belongs to the authenticated doctor
        $appointment = Appointment::where('appointment_id', $request->appointment_id)
            ->where('doctor_id', $employee->id)
            ->where('type', $request->type)
            ->first();

        if (!$appointment) {
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found or does not belong to you.'
            ], 404);
        }

        // Update the status
        $appointment->update(['status' => $request->status]);

        return response()->json([
            'status' => true,
            'message' => 'Appointment status updated successfully.',
            'appointment' => $appointment
        ]);
    }
    
    
    
    
    
    
}