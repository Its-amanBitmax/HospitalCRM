<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;


class EmployeeLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('website.employee-login');
    }



public function login(Request $request)
{
    $request->validate([
        'identifier' => 'required',
        'password'   => 'required'
    ]);

    // Find employee using employee_code
    $employee = Employee::where('employee_code', $request->identifier)->first();

    \Log::info('Employee Fetched:', ['employee' => $employee]); // LOG EMPLOYEE

    if (!$employee) {
        \Log::error('Employee not found');
        return response()->json(['error' => 'Employee not found'], 200);
    }

    // Check password
    if (!Hash::check($request->password, $employee->password)) {
        \Log::error('Password mismatch for employee: '.$employee->employee_code);
        return response()->json(['error' => 'Wrong password'], 200);
    }

    // Fetch profession from professions table
    $profession = DB::table('professions')
        ->where('employee_id', $employee->id)
        ->first();

    \Log::info('Profession Data:', ['profession' => $profession]); // LOG PROFESSION

    // If no profession found
    if (!$profession) {
        \Log::error('No profession assigned for: '.$employee->employee_code);
        return response()->json(['error' => 'No profession assigned'], 200);
    }

    // Check if title is Doctor
    if (trim(strtolower($profession->title)) !== "doctor") {
        \Log::error('Access denied. Profession = '.$profession->title);
        return response()->json(['error' => 'Only Doctors can login here'], 200);
    }

    \Log::info('Doctor login success for: '.$employee->employee_code);

    // Login successful
    Auth::guard('doctor')->login($employee);

    return redirect()->route('employee.doctor.dashboard');
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.selection');
    }
}
