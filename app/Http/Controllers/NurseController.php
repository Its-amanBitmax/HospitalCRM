<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\NurseTask;
use App\Models\Room;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    // Show the form
    public function get_task()
    {
        $nurses = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'Nurse');
        })->get();

        $doctors = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'Doctor');
        })->get();

        $departments = Department::all();
        $rooms = Room::all();

        return view('admin.nurse.all-patients', compact('nurses', 'doctors', 'departments', 'rooms'));
    }

    // Save form data
   public function save_nurse_task(Request $request)
{
    $request->validate([
        'nurse_id'      => 'nullable|exists:employees,id',
        'doctor_id'     => 'nullable|exists:employees,id',
        'department_id' => 'nullable|exists:departments,id',
        'room_id'       => 'nullable|exists:rooms,id',
        'tasks'         => 'required|array',
        'tasks.*.start_date' => 'required|date',
        'tasks.*.end_date'   => 'required|date|after_or_equal:tasks.*.start_date',
        'tasks.*.notes'      => 'nullable|string',
    ]);

    foreach ($request->tasks as $task) {
        NurseTask::create([
            'department_id' => $request->department_id,
            'room_id'       => $request->room_id,
            'nurse_id'      => $request->nurse_id,
            'doctor_id'     => $request->doctor_id,
            'notes'         => $task['notes'] ?? '',
            'start_date'    => $task['start_date'],
            'end_date'      => $task['end_date'],
        ]);
    }

    return redirect()->back()->with('success', 'Tasks created successfully!');
}

}
