<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HospitalSchedule;
use App\Models\TestBook;
use Illuminate\Http\Request;

class HospitalScheduleController extends Controller
{
    public function index()
{
    $schedules = HospitalSchedule::orderBy('start_date', 'asc')->get();

    $result = [];

    foreach ($schedules as $schedule) {

        $startDate = \Carbon\Carbon::parse($schedule->start_date)->startOfDay();
        $endDate   = \Carbon\Carbon::parse($schedule->end_date)->startOfDay();

        $days = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

            // 👇 Skip Sundays
            if ($date->isSunday()) {
                continue;
            }

            // Handling full day slot (00:00 to 00:00)
            if ($schedule->start_time == "00:00" && $schedule->end_time == "00:00") {
                $slotStart = $date->copy()->setTime(0, 0, 0);
                $slotEndTime = $date->copy()->addDay()->setTime(0, 0, 0);
            } else {
                $slotStart = \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->start_time);
                $slotEndTime = \Carbon\Carbon::parse($date->format('Y-m-d') . ' ' . $schedule->end_time);

                if ($slotEndTime->lte($slotStart)) {
                    $slotEndTime->addDay();
                }
            }

            $slots = [];

            while ($slotStart->lt($slotEndTime)) {
                $slotEnd = $slotStart->copy()->addHour();

                if ($slotEnd->gt($slotEndTime)) {
                    $slotEnd = $slotEndTime->copy();
                }

                // Check if this exact slot is booked
                $isBooked = TestBook::where('booking_date', $date->format('Y-m-d'))
                    ->where('start_time', $slotStart->format('h:i A'))
                    ->where('end_time', $slotEnd->format('h:i A'))
                    ->exists();

                if (!$isBooked) {
                    $slots[] = [
                        'slot_start' => $slotStart->format('h:i A'),
                        'slot_end'   => $slotEnd->format('h:i A'),
                    ];
                }

                $slotStart->addHour();
            }

            if (!empty($slots)) {
                $days[] = [
                    'date'  => $date->format('Y-m-d'),
                    'slots' => $slots,
                ];
            }
        }

        if (!empty($days)) {
            $result[] = [
                'schedule_id' => $schedule->id,
                'start_date'  => $startDate->format('Y-m-d'),
                'end_date'    => $endDate->format('Y-m-d'),
                'start_time'  => $schedule->start_time,
                'end_time'    => $schedule->end_time,
                'days'        => $days,
            ];
        }
    }

    return response()->json([
        'status' => true,
        'message' => 'Schedules with available hourly time slots',
        'data' => $result
    ]);
}

}
