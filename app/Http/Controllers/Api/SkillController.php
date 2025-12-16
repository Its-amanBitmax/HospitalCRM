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

public function getAvailability(Employee $doctor, Request $request)
{
    // ============================
    // 1. Date range inputs
    // ============================
    $startDate = $request->query('from', Carbon::now()->subDays(30)->toDateString());
    $endDate   = $request->query('to', Carbon::now()->addDays(30)->toDateString());

    // ============================
    // 2. Load shifts
    // ============================
    $shifts = $doctor->shifts()->get(['shift_name', 'start_time', 'end_time']);

    // ============================
    // 3. Load schedules inside date range
    // ============================
    $schedules = $doctor->schedules()
        ->where('start_date', '<=', $endDate)
        ->where('end_date', '>=', $startDate)
        ->get(['start_date', 'end_date', 'start_time', 'end_time', 'task_type']);

    // ============================
    // 4. Load bookings
    // ============================
    $bookings = DB::table('appointments')
        ->where('doctor_id', $doctor->id)
        ->whereIn('status', ['Booked', 'Pending'])
        ->get(['appointment_date', 'appointment_time']);

    // ============================
    // 5. Build date range
    // ============================
    $dates = [];
    $current = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);

    while ($current->lte($end)) {
        $dates[] = $current->format('Y-m-d');
        $current->addDay();
    }

    $availabilityByDate = [];

    // ============================
    // 6. Build slot availability
    // ============================
    foreach ($dates as $date) {

        $availabilityByDate[$date] = [
            'appointments' => [],
            'consultations' => [],
        ];

        foreach ($shifts as $shift) {

            $shiftStart = Carbon::parse($date . ' ' . Carbon::parse($shift->start_time)->format('H:i:s'));
            $shiftEnd   = Carbon::parse($date . ' ' . Carbon::parse($shift->end_time)->format('H:i:s'));

            if ($shiftEnd->lessThan($shiftStart)) {
                $shiftEnd->addDay(); // Handle overnight shift
            }

            // Match schedules that affect this date
            $matchedSchedules = $schedules->filter(function ($schedule) use ($date, $shiftStart, $shiftEnd) {

                $schedStartDT = Carbon::parse($schedule->start_date . ' ' . Carbon::parse($schedule->start_time)->format('H:i:s'));
                $schedEndDT   = Carbon::parse($schedule->end_date . ' ' . Carbon::parse($schedule->end_time)->format('H:i:s'));

                if ($schedEndDT->lessThan($schedStartDT)) {
                    $schedEndDT->addDay();
                }

                return $shiftStart < $schedEndDT && $shiftEnd > $schedStartDT;
            });

            foreach ($matchedSchedules as $sched) {

                // Build full datetime for schedule for this specific date
                $schedStartDT = Carbon::parse($date . ' ' . Carbon::parse($sched->start_time)->format('H:i:s'));
                $schedEndDT   = Carbon::parse($date . ' ' . Carbon::parse($sched->end_time)->format('H:i:s'));

                if ($schedEndDT->lessThan($schedStartDT)) {
                    $schedEndDT->addDay();
                }

                // Determine real working range inside shift
                $currentSlot = $schedStartDT->greaterThan($shiftStart) ? $schedStartDT->copy() : $shiftStart->copy();
                $slotEndLimit = $schedEndDT->lessThan($shiftEnd) ? $schedEndDT->copy() : $shiftEnd->copy();

                while ($currentSlot->copy()->addMinutes(30)->lte($slotEndLimit)) {

                    $slotStartDT = $currentSlot->copy();
                    $slotEndDT   = $currentSlot->copy()->addMinutes(30);

                    // Check bookings
                    $isBooked = $bookings->contains(function ($booking) use ($slotStartDT, $slotEndDT) {

                        $times = explode('-', $booking->appointment_time);
                        $bookStartStr = trim($times[0]);
                        $bookEndStr   = isset($times[1])
                                        ? trim($times[1])
                                        : Carbon::parse($bookStartStr)->addMinutes(30)->format('h:i A');

                        $bookStart = Carbon::parse($booking->appointment_date . ' ' . $bookStartStr);
                        $bookEnd   = Carbon::parse($booking->appointment_date . ' ' . $bookEndStr);

                        return $slotStartDT < $bookEnd && $slotEndDT > $bookStart;
                    });

                    if (!$isBooked) {
                        $formattedSlot = [
                            'start' => $slotStartDT->format('h:i A'),
                            'end'   => $slotEndDT->format('h:i A'),
                            'shift_name' => $shift->shift_name,
                        ];

                        $taskType = strtolower($sched->task_type);

                        if ($taskType === 'appointment') {
                            $availabilityByDate[$date]['appointments'][] = $formattedSlot;
                        } 
                        else if ($taskType === 'consultation') {
                            $availabilityByDate[$date]['consultations'][] = $formattedSlot;
                        }
                    }

                    $currentSlot->addMinutes(30);
                }
            }
        }
    }

    // ============================
    // 7. Prepare final task list
    // ============================
    $taskAvailability = $schedules->map(function ($task) use ($shifts) {
        // Find matching shift based on time overlap (task within shift)
        $matchingShift = $shifts->first(function ($shift) use ($task) {
            $taskStart = Carbon::parse($task->start_time);
            $taskEnd = Carbon::parse($task->end_time);
            $shiftStart = Carbon::parse($shift->start_time);
            $shiftEnd = Carbon::parse($shift->end_time);

            // Handle overnight shifts
            if ($shiftEnd->lessThan($shiftStart)) {
                $shiftEnd->addDay();
            }

            return $taskStart >= $shiftStart && $taskEnd <= $shiftEnd;
        });

        return [
            'start_date' => $task->start_date,
            'end_date'   => $task->end_date,
            'start_time' => Carbon::parse($task->start_time)->format('h:i A'),
            'end_time'   => Carbon::parse($task->end_time)->format('h:i A'),
            'task_type'  => $task->task_type,
            'shift_name' => $matchingShift ? $matchingShift->shift_name : null,
        ];
    })->values();

    // ============================
    // 8. Filter availability to only include dates with slots
    // ============================
    $filteredAvailability = array_filter($availabilityByDate, function ($daySlots) {
        return !empty($daySlots['appointments']) || !empty($daySlots['consultations']);
    });

    // ============================
    // 9. Final response
    // ============================
    return response()->json([
        'doctor_id'          => $doctor->id,
        'doctor_name'        => $doctor->name,
        'slots_availability' => $filteredAvailability,
        'availability'       => $taskAvailability,
    ]);
}















}
