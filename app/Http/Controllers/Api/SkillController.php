<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speciality;
use App\Models\Employee;
use Carbon\Carbon;

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

public function getAvailability(Employee $doctor, Request $request)
{
    $startDate = $request->query('from', Carbon::now()->subDays(30)->toDateString());
    $endDate = $request->query('to', Carbon::now()->addDays(30)->toDateString());

    // ✅ Fetch doctor's shifts
    $shifts = $doctor->shifts()
        ->get(['shift_name', 'start_time', 'end_time'])
        ->map(function ($shift) {
            return [
                'shift_name' => $shift->shift_name,
                'start_time' => Carbon::parse($shift->start_time)->format('H:i:s'),
                'end_time'   => Carbon::parse($shift->end_time)->format('H:i:s'),
            ];
        });

    // ✅ Fetch both Appointment & Video Consultation tasks
    $tasks = $doctor->schedules()
        ->whereIn('task_type', ['Appointment', 'Video Consultation'])
        ->whereBetween('start_date', [$startDate, $endDate])
        ->get(['start_date', 'end_date', 'start_time', 'end_time', 'task_type']);

    // ✅ Match each task to its shift
    $availability = $tasks->map(function ($task) use ($shifts) {
        $taskStart = Carbon::parse($task->start_time)->format('H:i:s');
        $taskEnd   = Carbon::parse($task->end_time)->format('H:i:s');
        $shiftName = 'Unknown';

        foreach ($shifts as $shift) {
            $shiftStart = Carbon::parse($shift['start_time']);
            $shiftEnd   = Carbon::parse($shift['end_time']);

            // Normal shift (same day)
            if ($shift['start_time'] <= $taskStart && $taskEnd <= $shift['end_time']) {
                $shiftName = $shift['shift_name'];
                break;
            }

            // Overnight shift (e.g., 20:00 → 03:00)
            if ($shiftEnd->lt($shiftStart)) {
                if ($taskStart >= $shift['start_time'] || $taskEnd <= $shift['end_time']) {
                    $shiftName = $shift['shift_name'];
                    break;
                }
            }
        }

        return [
            'shift_name' => $shiftName,
            'start_date' => $task->start_date,
            'end_date'   => $task->end_date,
            'start_time' => Carbon::parse($task->start_time)->format('h:i A'),
            'end_time'   => Carbon::parse($task->end_time)->format('h:i A'),
            'task_type'  => $task->task_type,
        ];
    })->values();

    // ✅ Final JSON Response
    return response()->json([
        'doctor_id' => $doctor->id,
        'doctor_name' => $doctor->name,
        'availability' => $availability,
    ]);
}


}
