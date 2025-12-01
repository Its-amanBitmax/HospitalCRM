<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function getTodaySchedules(Request $request)
    {
        $employee = auth('sanctum')->user();

        if (!$employee) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $today = Carbon::today();

        $schedules = Schedule::where('employee_id', $employee->id)
            ->whereDate('start_date', $today)
            ->orderBy('start_time', 'asc')
            ->get();

        return response()->json([
            'message' => 'Today\'s schedules retrieved successfully',
            'schedules' => $schedules
        ]);
    }   
}