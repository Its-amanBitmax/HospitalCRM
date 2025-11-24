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
        if ($employee->status !== 'active') {
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
