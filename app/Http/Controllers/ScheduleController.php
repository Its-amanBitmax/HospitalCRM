<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Shift;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class ScheduleController extends Controller
{
    public function index(Employee $employee)
    {
        $schedules = $employee->schedules()->latest()->get();
        return view('admin.schedules.index', compact('employee', 'schedules'));
    }

public function create(Employee $employee)
{
    $shifts = $employee->shifts()->get(); // get all shifts
    return view('admin.schedules.create', compact('employee', 'shifts'));
}

public function store(Request $request, Employee $employee)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'task_type' => 'required|string|in:Appointment,Video Consultation,OPD,IPD,Emergency,Room Duty,Other',
    ]);

    // 🧠 Instead of creating one per day, create a single entry for the whole range
    $employee->schedules()->create([
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'task_type' => $request->task_type,
    ]);

    return redirect()->route('schedules.index', $employee)
                     ->with('success', 'Task scheduled successfully!');
}


    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Task deleted successfully!');
    }

    public function edit(Schedule $schedule)
{
    $employee = $schedule->employee;
    return view('admin.schedules.edit', compact('schedule', 'employee'));
}

public function update(Request $request, Schedule $schedule)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'task_type' => 'required|string|in:Appointment,Video Consultation,OPD,IPD,Emergency,Room Duty,Other',
    ]);

    $schedule->update($request->only('start_date', 'end_date', 'start_time', 'end_time', 'task_type'));

    return redirect()->route('schedules.index', $schedule->employee)
                     ->with('success', 'Task updated successfully!');
}

}

