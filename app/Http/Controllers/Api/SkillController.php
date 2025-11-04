<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speciality;
use App\Models\Employee;

class SkillController extends Controller
{
    // Fetch all records
public function index(Request $request)
{
    $skills = \App\Models\Speciality::all()->map(function ($item) {
        if ($item->image) {
            // Convert image path to full URL
            $item->image = asset('storage/' . $item->image);
        } else {
            $item->image = asset('images/default.png'); // optional default image
        }
        return $item;
    });

    return response()->json([
        'status' => true,
        'message' => 'All skills fetched successfully',
        'data' => $skills
    ]);
}

public function getDoctors()
{
    $doctors = Employee::with(['professions', 'specialities', 'qualifications'])
        ->whereHas('professions', function ($query) {
            $query->where('title', 'Doctor');
        })
        ->get()
        ->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'employee_code' => $employee->employee_code,
                'image' => $employee->image ? asset('storage/' . $employee->image) : null,
                'hire_date' => $employee->hire_date,

                // ✅ Qualifications from your table
                'qualifications' => $employee->qualifications->map(function ($qualification) {
                    return [
                        'id' => $qualification->id,
                        'degree' => $qualification->degree,
                        'institution' => $qualification->institution,
                        'year_completed' => $qualification->year_completed,
                    ];
                })->toArray(),

                // ✅ Existing specialities
                'specialities' => $employee->specialities->map(function ($speciality) {
                    return [
                        'speciality_id' => $speciality->id,
                        'skill' => $speciality->skill,
                        'proficiency_level' => $speciality->pivot->proficiency_level,
                        'years_of_experience' => $speciality->pivot->years_of_experience,
                        'image' => $speciality->image ? asset('storage/' . $speciality->image) : null,
                    ];
                })->toArray(),
            ];
        });

    return response()->json([
        'success' => true,
        'data' => $doctors,
        'count' => $doctors->count(),
    ]);
}
}
