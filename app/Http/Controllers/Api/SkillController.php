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
    $endDate   = $request->query('to', Carbon::now()->addDays(30)->toDateString());

    // ===== Fetch shifts =====
    $shifts = $doctor->shifts()->get(['shift_name', 'start_time', 'end_time']);

    // ===== Fetch schedules (Appointment + Consultation) =====
    $schedules = $doctor->schedules()
        ->get(['start_date', 'end_date', 'start_time', 'end_time', 'task_type']);

    // ===== Fetch all bookings =====
    $bookings = DB::table('appointments')
        ->where('doctor_id', $doctor->id)
        ->whereIn('status', ['Booked', 'Pending'])
        ->get(['appointment_date', 'appointment_time']);

    // ===== Prepare all relevant dates =====
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

    $availabilityByDate = [];

    foreach ($dates as $date) {
        $dayAvailability = [];

        foreach ($shifts as $shift) {
            $shiftStart = Carbon::parse($shift->start_time);
            $shiftEnd   = Carbon::parse($shift->end_time);

            // Find all schedules overlapping this date + shift
            $matchedSchedules = $schedules->filter(function($schedule) use ($date, $shift) {
                $scheduleStart = Carbon::parse($schedule->start_date.' '.$schedule->start_time);
                $scheduleEnd   = Carbon::parse($schedule->end_date.' '.$schedule->end_time);
                $shiftStartDT  = Carbon::parse($date.' '.$shift->start_time);
                $shiftEndDT    = Carbon::parse($date.' '.$shift->end_time);

                return $shiftStartDT < $scheduleEnd && $shiftEndDT > $scheduleStart;
            });

            foreach ($matchedSchedules as $matchedSchedule) {
                $taskType = strtolower($matchedSchedule->task_type);
                $slots = [];

                $current = max(Carbon::parse($matchedSchedule->start_time), $shiftStart)->copy();
                $endTime = min(Carbon::parse($matchedSchedule->end_time), $shiftEnd);

                // Generate 30-min slots
                while ($current < $endTime) {
                    $slotEnd = $current->copy()->addMinutes(30);
                    $slotStartDT = Carbon::parse($date.' '.$current->format('H:i:s'));
                    $slotEndDT   = Carbon::parse($date.' '.$slotEnd->format('H:i:s'));

                    $isBooked = $bookings->contains(function($booking) use ($date, $slotStartDT, $slotEndDT) {
                        $bookStart = Carbon::parse($booking->appointment_date.' '.$booking->appointment_time);
                        $bookEnd   = $bookStart->copy()->addMinutes(30);
                        return $booking->appointment_date == $date && $slotStartDT < $bookEnd && $slotEndDT > $bookStart;
                    });

                    if (!$isBooked) {
                        $slots[] = [
                            'start' => $slotStartDT->format('h:i A'),
                            'end'   => $slotEndDT->format('h:i A'),
                        ];
                    }

                    $current = $slotEnd;
                }

                $dayAvailability[] = [
                    'shift_name'      => $shift->shift_name,
                    'task_type'       => $taskType,
                    'available_slots' => $slots,
                ];
            }
        }

        $availabilityByDate[$date] = $dayAvailability;
    }

    // ===== Prepare task list =====
    $shiftData = $shifts->map(function ($shift) {
        return [
            'shift_name' => $shift->shift_name,
            'start_time' => Carbon::parse($shift->start_time)->format('H:i:s'),
            'end_time'   => Carbon::parse($shift->end_time)->format('H:i:s'),
        ];
    });

    // Case-insensitive task_type filtering for both Appointment & Consultation
    $tasks = $schedules
        ->filter(fn($task) => in_array(strtolower($task->task_type), ['appointment', 'consultation']) &&
                              $task->start_date >= $startDate &&
                              $task->end_date <= $endDate);

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

            if ($shiftEnd->lt($shiftStart)) { // night shift
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
            'task_type'  => $task->task_type, // Appointment or Consultation
        ];
    })->values();

    return response()->json([
        'doctor_id'          => $doctor->id,
        'doctor_name'        => $doctor->name,
        'slots_availability' => $availabilityByDate,
        'availability'       => $taskAvailability,
    ]);
}













}
