<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
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
}
