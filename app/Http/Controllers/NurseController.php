<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\NurseTask;
use App\Models\Room;
use App\Models\Speciality;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NurseController extends Controller
{


    public function nurse_dashboard()
    {
        $nurse = auth('nurse')->user(); // Logged-in nurse

        // fetch profile + professions
        $employee = Employee::with('professions')
            ->where('id', $nurse->id)
            ->first();

        // Fetch nurse tasks/assignments
        $tasks = NurseTask::where('nurse_id', $nurse->id)
            ->with(['department', 'room', 'doctor', 'nurse'])
            ->orderBy('start_date', 'asc')
            ->get();

        // Get today's date
        $today = now()->format('Y-m-d');

        // Today's tasks
        $todayTasks = $tasks->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', '!=', 'completed');

        // Upcoming tasks (next 7 days)
        $upcomingTasks = $tasks->where('start_date', '>', $today)
            ->where('start_date', '<=', now()->addDays(7)->format('Y-m-d'));

        // Completed tasks
        $completedTasks = $tasks->where('status', 'completed');

        // Pending tasks
        $pendingTasks = $tasks->where('status', 'pending');

        // In-progress tasks (current)
        $inProgressTasks = $tasks->where('status', 'in-progress');

        // Current task (if any)
        $currentTask = $tasks->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', 'in-progress')
            ->first();

        // Specialities fetch karein - CORRECTION HERE
        // $nurse object hai, iska ID use karein
        $specialities = Speciality::where('employee_id', $nurse->id)->get();
        // OR agar Speciality model mein nurse_id column hai to:
        // $specialities = Speciality::where('nurse_id', $nurse->id)->get();

        return view('nurse.nurse-dashboard', compact(
            'employee',
            'tasks',
            'todayTasks',
            'upcomingTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks',
            'currentTask',
            'specialities'
        ));
    }



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

        return view('admin.nurse.create-task', compact('nurses', 'doctors', 'departments', 'rooms'));
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
                'status'      => 'pending',
            ]);
        }

        return redirect()->back()->with('success', 'Tasks created successfully!');
    }




    public function get_all_nurse_task(Request $request)
    {
        $query = NurseTask::with(['nurse', 'doctor', 'room', 'department'])
            ->orderBy('id', 'desc');

        // Optional: Add search functionality
        if ($request->has('search') && $request->search) {
            $query->whereHas('nurse', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
                ->orWhereHas('doctor', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('department', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        $tasks = $query->paginate(15);

        return view('admin.nurse.all-task', compact('tasks'));
    }


    public function edit_nurse_task($id)
    {
        $task = NurseTask::with(['nurse', 'doctor', 'room', 'department'])->findOrFail($id);

        $departments = \App\Models\Department::all();
        $rooms = \App\Models\Room::all();
        $doctors = \App\Models\Employee::whereHas('professions', fn($q) => $q->where('title', 'Doctor'))->get();
        $nurses = \App\Models\Employee::whereHas('professions', fn($q) => $q->where('title', 'Nurse'))->get();

        return view('admin.nurse.edit-task', compact('task', 'departments', 'rooms', 'doctors', 'nurses'));
    }

    public function update_nurse_task(Request $request, $id)
    {
        $request->validate([
            'nurse_id'      => 'nullable|exists:employees,id',
            'doctor_id'     => 'nullable|exists:employees,id',
            'department_id' => 'nullable|exists:departments,id',
            'room_id'       => 'nullable|exists:rooms,id',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
            'notes'         => 'nullable|string',
            'status'        => 'required|in:pending,in-progress,completed',
        ]);

        $task = NurseTask::findOrFail($id);

        $task->update([
            'department_id' => $request->department_id,
            'room_id'       => $request->room_id,
            'nurse_id'      => $request->nurse_id,
            'doctor_id'     => $request->doctor_id,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'notes'         => $request->notes,
            'status'        => $request->status,
        ]);

        return redirect()->route('nurse.tasks')->with('success', 'Nurse task updated successfully!');
    }


    public function delete_nurse_task($id)
    {
        // Find the task
        $task = NurseTask::find($id);

        if (!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }

        // Delete the task
        $task->delete();

        return redirect()->back()->with('success', 'Nurse task deleted successfully!');
    }

    // Add this method to your NurseController for updating task status
    // Add this method to your NurseController for updating only task status
    public function update_task_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $task = NurseTask::findOrFail($id);

        // Check if nurse is authorized to update this task
        $nurse = auth('nurse')->user();
        if ($task->nurse_id != $nurse->id) {
            return redirect()->back()->with('error', 'You are not authorized to update this task.');
        }

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->route('nurse.dashboard')->with('success', 'Task status updated successfully!');
    }



    public function nurse_attendance()
    {
        $employee = auth('nurse')->user();
        $today = Carbon::today('Asia/Kolkata')->toDateString();

        $filter = request()->get('filter', 'all');
        $startDate = null;
        $endDate = null;

        switch ($filter) {
            case 'weekly':
                $startDate = Carbon::today('Asia/Kolkata')->startOfWeek()->toDateString();
                $endDate = Carbon::today('Asia/Kolkata')->endOfWeek()->toDateString();
                break;

            case 'monthly':
                $startDate = Carbon::today('Asia/Kolkata')->startOfMonth()->toDateString();
                $endDate = Carbon::today('Asia/Kolkata')->endOfMonth()->toDateString();
                break;

            case 'today':
                $startDate = $today;
                $endDate = $today;
                break;

            case 'all':
            default:
                break;
        }

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        $history = Attendance::where('employee_id', $employee->id)
            ->when($filter === 'today', fn($q) => $q->where('date', $today))
            ->when($filter === 'weekly', fn($q) => $q->whereBetween('date', [$startDate, $endDate]))
            ->when($filter === 'monthly', fn($q) => $q->whereBetween('date', [$startDate, $endDate]))
            ->when($filter === 'all', fn($q) => $q)
            ->orderBy('date', 'desc')
            ->get();

        $totalDays = $history->count();
        $presentDays = $history->where('status', 'present')->count();
        $lateDays = $history->where('status', 'late')->count();
        $absentDays = $history->where('status', 'absent')->count();
        $halfDays = $history->where('status', 'half_day')->count();

        $attendancePercentage = $totalDays > 0
            ? round(($presentDays + ($halfDays * 0.5)) / $totalDays * 100, 1)
            : 0;

        $totalHours = 0;
        $daysWithClockOut = 0;

        foreach ($history as $record) {
            if ($record->check_in && $record->check_out) {
                $start = Carbon::createFromFormat('H:i:s', $record->check_in);
                $end = Carbon::createFromFormat('H:i:s', $record->check_out);
                $totalHours += $end->diffInHours($start, true);
                $daysWithClockOut++;
            }
        }

        $averageHours = $daysWithClockOut > 0 ? round($totalHours / $daysWithClockOut, 1) : 0;

        $weekRange = $startDate && $endDate ? Carbon::parse($startDate)->format('d M') . ' - ' . Carbon::parse($endDate)->format('d M') : null;
        $monthName = $filter === 'monthly' ? Carbon::today('Asia/Kolkata')->format('F Y') : null;

        return view('nurse.nurse_attendance', compact(
            'attendance',
            'history',
            'filter',
            'weekRange',
            'monthName',
            'totalDays',
            'presentDays',
            'lateDays',
            'employee',
            'absentDays',
            'halfDays',
            'attendancePercentage',
            'averageHours'
        ));
    }

    // Handle Nurse Clock In / Clock Out
    public function mark_nurse_attendance(Request $request)
    {
        $request->validate([
            'type' => 'required|in:clock_in,clock_out',
        ]);

        $employee = auth('nurse')->user();
        $today = Carbon::today('Asia/Kolkata')->toDateString();
        $now   = Carbon::now('Asia/Kolkata')->format('H:i:s');

        $attendance = Attendance::firstOrNew([
            'employee_id' => $employee->id,
            'date' => $today
        ]);

        try {
            if ($request->type === 'clock_in') {
                if ($attendance->check_in) {
                    return response()->json(['message' => 'Already Clocked In!'], 422);
                }

                $attendance->check_in = $now;
                $attendance->check_in_ip = $request->ip();
                $attendance->check_in_latitude = $request->latitude;
                $attendance->check_in_longitude = $request->longitude;
                $attendance->check_in_server = json_encode($request->server_info);
                $attendance->check_in_location = $request->location ?? null;

                $attendance->save();

                $checkInTime = Carbon::createFromFormat('H:i:s', $attendance->check_in, 'Asia/Kolkata');
                $morningLimit = Carbon::createFromTime(9, 30, 0, 'Asia/Kolkata');
                if ($checkInTime->gt($morningLimit)) {
                    $attendance->status = 'half_day';
                    $attendance->save();
                }

                return response()->json(['message' => 'Clocked In Successfully!']);
            }

            if ($request->type === 'clock_out') {
                if (!$attendance->check_in) {
                    return response()->json(['message' => 'Clock In first!'], 422);
                }
                if ($attendance->check_out) {
                    return response()->json(['message' => 'Already Clocked Out!'], 422);
                }

                $attendance->check_out = $now;
                $attendance->check_out_ip = $request->ip();
                $attendance->check_out_latitude = $request->latitude;
                $attendance->check_out_longitude = $request->longitude;
                $attendance->check_out_server = json_encode($request->server_info);
                $attendance->check_out_location = $request->location ?? null;

                $attendance->save();

                if ($attendance->check_in && $attendance->check_out) {
                    $checkInTime = Carbon::createFromFormat('H:i:s', $attendance->check_in, 'Asia/Kolkata');
                    $checkOutTime = Carbon::createFromFormat('H:i:s', $attendance->check_out, 'Asia/Kolkata');
                    $totalHours = $checkOutTime->diffInHours($checkInTime, true);

                    $morningLimit = Carbon::createFromTime(9, 30, 0, 'Asia/Kolkata');
                    $eveningLimit = Carbon::createFromTime(18, 30, 0, 'Asia/Kolkata');

                    if ($checkInTime->gt($morningLimit) || $checkOutTime->lt($eveningLimit)) {
                        $attendance->status = 'half_day';
                    } else {
                        $attendance->status = $totalHours >= 8 ? 'present' : ($totalHours >= 4 ? 'half_day' : 'absent');
                    }

                    $attendance->save();
                }

                return response()->json(['message' => 'Clocked Out Successfully!']);
            }
        } catch (\Exception $e) {
            Log::error('Nurse attendance error: ' . $e->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }



    public function get_patients_for_nurse()
    {
        // Fetch all patients
        $users = User::with('nurses')->paginate(10); // ye bahut important hai
        $nurses = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'Nurse');
        })->get();

        return view('admin.nurse.patient_list', compact('users', 'nurses'));
    }


    public function assignNurse(Request $request)
    {
        // Validate input
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'nurse_id'   => 'required|exists:employees,id',
        ]);

        // Find patient
        $patient = User::find($request->patient_id);

        // Assign nurse (attach to pivot table, without removing existing)
        $patient->nurses()->syncWithoutDetaching([$request->nurse_id]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Nurse assigned successfully.');
    }


  public function get_my_assigned_patients()
{
    $nurse = auth('nurse')->user(); 

    $patients = $nurse->patients; 
    return view('nurse.patient_list', compact('patients'));
}


public function get_beds()
{
    // Get all beds with their active assignment and user info
    $beds = \App\Models\Bed::with(['bedAssignments' => function($query) {
        $query->where('status', 'active')
              ->with('user'); // Assuming user relationship exists
    }])->get();
    
    return view('nurse.all-beds', compact('beds'));
}



}
