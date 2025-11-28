<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Speciality;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
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






// public function getAvailability(Employee $doctor)
// {
//     $shifts = $doctor->shifts()->get(['shift_name', 'start_time', 'end_time']);
//     $schedules = DB::table('schedules')
//         ->where('employee_id', $doctor->id)
//         ->whereIn('task_type', ['Appointment', 'consultation'])
//         ->get(['start_date', 'end_date', 'start_time', 'end_time', 'task_type']);
//     $appointments = DB::table('appointments')
//         ->where('doctor_id', $doctor->id)
//         ->whereIn('status', ['Booked', 'Pending'])
//         ->get(['appointment_date', 'appointment_time']);

//     $availabilityByDate = [];
//     $dates = [];
//     foreach ($schedules as $schedule) {
//         $current = Carbon::parse($schedule->start_date);
//         $end     = Carbon::parse($schedule->end_date);
//         while ($current->lte($end)) {
//             $dates[$current->format('Y-m-d')] = true;
//             $current->addDay();
//         }
//     }
//     $dates = array_keys($dates);
//     foreach ($dates as $date) {
//         $dayAvailability = [];
//         foreach ($shifts as $shift) {
//             $shiftStart = Carbon::parse($shift->start_time);
//             $shiftEnd   = Carbon::parse($shift->end_time);
//             $slots = [];
//             $current = $shiftStart->copy();

//             while ($current < $shiftEnd) {
//                 $slotEnd = $current->copy()->addMinutes(30);
//                 $slots[] = [
//                     'start' => Carbon::parse($date.' '.$current->format('H:i:s'))->format('h:i A'),
//                     'end'   => Carbon::parse($date.' '.$slotEnd->format('H:i:s'))->format('h:i A'),
//                 ];
//                 $current = $slotEnd;
//             }

//             // Remove slots that are already booked in appointments
//             foreach ($appointments as $app) {
//                 if ($app->appointment_date != $date) continue;

//                 $bookStart = Carbon::parse($app->appointment_date.' '.$app->appointment_time);
//                 $bookEnd   = $bookStart->copy()->addMinutes(30);

//                 $slots = array_filter($slots, function ($slot) use ($date, $bookStart, $bookEnd) {
//                     $slotStart = Carbon::parse($date.' '.$slot['start']);
//                     $slotEndTime = Carbon::parse($date.' '.$slot['end']);

//                     return !($slotStart < $bookEnd && $slotEndTime > $bookStart);
//                 });
//             }

//             // Determine shift task_type from schedules
//             $shiftTaskType = null;
//             foreach ($schedules as $schedule) {
//                 $scheduleStart = Carbon::parse($schedule->start_date.' '.$schedule->start_time);
//                 $scheduleEnd   = Carbon::parse($schedule->end_date.' '.$schedule->end_time);
//                 $shiftRangeStart = Carbon::parse($date.' '.$shift->start_time);
//                 $shiftRangeEnd   = Carbon::parse($date.' '.$shift->end_time);

//                 if ($shiftRangeStart < $scheduleEnd && $shiftRangeEnd > $scheduleStart) {
//                     $shiftTaskType = $schedule->task_type;
//                     break; // take first overlapping schedule
//                 }
//             }

//             $dayAvailability[] = [
//                 'shift_name'      => $shift->shift_name,
//                 'task_type'       => $shiftTaskType, // now under shift
//                 'available_slots' => array_values($slots),
//             ];
//         }

//         $availabilityByDate[$date] = $dayAvailability;
//     }

//     return response()->json([
//         'doctor_id'   => $doctor->id,
//         'doctor_name' => $doctor->name,
//         'availability'=> $availabilityByDate,
//     ]);
// }










public function getAvailability(Employee $doctor, Request $request)
{
    $startDate = $request->query('from', Carbon::now()->subDays(30)->toDateString());
    $endDate = $request->query('to', Carbon::now()->addDays(30)->toDateString());

    // ============ PART A : SLOTS AVAILABILITY (FIRST FUNCTION) =============

    $shifts = $doctor->shifts()->get(['shift_name', 'start_time', 'end_time']);

    $schedules = DB::table('schedules')
        ->where('employee_id', $doctor->id)
        ->whereIn('task_type', ['Appointment', 'consultation'])
        ->get(['start_date', 'end_date', 'start_time', 'end_time', 'task_type']);

    $appointments = DB::table('appointments')
        ->where('doctor_id', $doctor->id)
        ->whereIn('status', ['Booked', 'Pending'])
        ->get(['appointment_date', 'appointment_time']);

    $availabilityByDate = [];
    $dates = [];

    foreach ($schedules as $schedule) {
        $current = Carbon::parse($schedule->start_date);
        $end     = Carbon::parse($schedule->end_date);

        while ($current->lte($end)) {
            $dates[$current->format('Y-m-d')] = true;
            $current->addDay();
        }
    }

    $dates = array_keys($dates);

    foreach ($dates as $date) {
        $dayAvailability = [];

        foreach ($shifts as $shift) {
            $shiftStart = Carbon::parse($shift->start_time);
            $shiftEnd   = Carbon::parse($shift->end_time);
            $slots = [];
            $current = $shiftStart->copy();

            while ($current < $shiftEnd) {
                $slotEnd = $current->copy()->addMinutes(30);

                $slots[] = [
                    'start' => Carbon::parse($date.' '.$current->format('H:i:s'))->format('h:i A'),
                    'end'   => Carbon::parse($date.' '.$slotEnd->format('H:i:s'))->format('h:i A'),
                ];

                $current = $slotEnd;
            }

            // Remove booked slots
            foreach ($appointments as $app) {
                if ($app->appointment_date != $date) continue;

                $bookStart = Carbon::parse($app->appointment_date.' '.$app->appointment_time);
                $bookEnd   = $bookStart->copy()->addMinutes(30);

                $slots = array_filter($slots, function ($slot) use ($date, $bookStart, $bookEnd) {
                    $slotStart = Carbon::parse($date.' '.$slot['start']);
                    $slotEndTime = Carbon::parse($date.' '.$slot['end']);

                    return !($slotStart < $bookEnd && $slotEndTime > $bookStart);
                });
            }

            // task type
            $shiftTaskType = null;

            foreach ($schedules as $schedule) {
                $scheduleStart = Carbon::parse($schedule->start_date.' '.$schedule->start_time);
                $scheduleEnd   = Carbon::parse($schedule->end_date.' '.$schedule->end_time);

                $shiftRangeStart = Carbon::parse($date.' '.$shift->start_time);
                $shiftRangeEnd   = Carbon::parse($date.' '.$shift->end_time);

                if ($shiftRangeStart < $scheduleEnd && $shiftRangeEnd > $scheduleStart) {
                    $shiftTaskType = $schedule->task_type;
                    break;
                }
            }

            $dayAvailability[] = [
                'shift_name'      => $shift->shift_name,
                'task_type'       => $shiftTaskType,
                'available_slots' => array_values($slots),
            ];
        }

        $availabilityByDate[$date] = $dayAvailability;
    }

    // ============ PART B : TASK LIST (SECOND FUNCTION) =============

    $shiftData = $doctor->shifts()
        ->get(['shift_name', 'start_time', 'end_time'])
        ->map(function ($shift) {
            return [
                'shift_name' => $shift->shift_name,
                'start_time' => Carbon::parse($shift->start_time)->format('H:i:s'),
                'end_time'   => Carbon::parse($shift->end_time)->format('H:i:s'),
            ];
        });

    $tasks = $doctor->schedules()
        ->whereIn('task_type', ['Appointment', 'consultation'])
        ->whereBetween('start_date', [$startDate, $endDate])
        ->get(['start_date', 'end_date', 'start_time', 'end_time', 'task_type']);

    $taskAvailability = $tasks->map(function ($task) use ($shiftData) {
        $taskStart = Carbon::parse($task->start_time)->format('H:i:s');
        $taskEnd   = Carbon::parse($task->end_time)->format('H:i:s');
        $shiftName = 'Unknown';

        foreach ($shiftData as $shift) {
            $shiftStart = Carbon::parse($shift['start_time']);
            $shiftEnd   = Carbon::parse($shift['end_time']);

            if ($shift['start_time'] <= $taskStart && $taskEnd <= $shift['end_time']) {
                $shiftName = $shift['shift_name'];
                break;
            }

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

    // ============ FINAL MERGED RESPONSE =============

    return response()->json([
        'doctor_id'   => $doctor->id,
        'doctor_name' => $doctor->name,

        // from first function
        'slots_availability' => $availabilityByDate,

        // from second function
        'availability' => $taskAvailability,
    ]);
}













}
