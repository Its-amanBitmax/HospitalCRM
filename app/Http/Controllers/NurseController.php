<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Attendance;
use App\Models\Bed;
use App\Models\BedAssignment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\NurseTask;
use App\Models\Room;
use App\Models\Speciality;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            ->orderBy('start_date', 'desc')
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

        // $users = User::all();

        return view('admin.nurse.create-task', compact('nurses', 'doctors', 'departments', 'rooms',));
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

    // In your Controller (e.g., BedController.php)
    public function get_beds()
    {
        // Get all beds with their ward and active assignment with user
        $beds = Bed::with(['ward', 'bedAssignments' => function ($query) {
            $query->where('status', 'active')->with(['user' => function ($q) {
                // Select additional user fields for detailed view
                $q->select('id', 'type', 'email', 'mobile_no', 'full_address', 'full_name', 'age', 'gender', 'blood_group', 'father_spouse_name', 'alternate_no', 'city', 'state', 'pin_code');
            }]);
        }])->get();

        return view('nurse.all-beds', compact('beds'));
    }


    // NurseController.php में
    public function getAvailableUsers($type)
    {
        try {
            // Validate type parameter
            $validTypes = ['ipd', 'opd', 'emergency'];
            if (!in_array(strtolower($type), $validTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid patient type'
                ], 400);
            }

            // Get users who are NOT currently assigned to any active bed
            $assignedUserIds = BedAssignment::where('status', 'active')
                ->pluck('user_id')
                ->toArray();

            // Get users by type who are not assigned
            $users = User::where('type', strtolower($type))
                ->whereNotIn('id', $assignedUserIds)
                ->select(
                    'id',
                    'email',
                    'full_name',
                    'mobile_no',
                    'type',
                    'full_address',
                    'age',
                    'gender',
                    'blood_group',
                    'father_spouse_name',
                    'city',
                    'state',
                    'pin_code',
                    'alternate_no'
                )
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users,
                'count' => $users->count(),
                'type' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching users: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Assign a bed to a user
     */
    public function assignBed(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'user_id' => 'required|exists:users,id',
            'assigned_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Check if bed is available
            $bed = Bed::find($request->bed_id);
            if ($bed->status !== 'Active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bed is not available for assignment'
                ]);
            }

            // Check if user already has active bed assignment
            $existingAssignment = BedAssignment::where('user_id', $request->user_id)
                ->where('status', 'active')
                ->first();

            if ($existingAssignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already has an active bed assignment'
                ]);
            }

            // Create bed assignment
            $assignment = BedAssignment::create([
                'user_id' => $request->user_id,
                'bed_id' => $request->bed_id,
                'assigned_date' => $request->assigned_date,
                'status' => 'active',
            ]);

            // Update bed status
            $bed->update(['status' => 'Occupied']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bed assigned successfully',
                'assignment' => $assignment
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error assigning bed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Discharge a patient from bed
     */
    public function dischargePatient($assignmentId)
    {
        DB::beginTransaction();

        try {
            $assignment = BedAssignment::findOrFail($assignmentId);

            // Update assignment status
            $assignment->update([
                'status' => 'discharged',
                'discharge_date' => now(),
            ]);

            // Update bed status back to Active
            $bed = $assignment->bed;
            $bed->update(['status' => 'Active']);

            DB::commit();

            return redirect()->route('nurse.all.bads')
                ->with('success', 'Patient discharged successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('nurse.all.bads')
                ->with('error', 'Error discharging patient: ' . $e->getMessage());
        }
    }


    // Controller में कोई change नहीं
    public function get_today_appointments()
    {
        $today = Carbon::today()->toDateString();

        $appointments = Appointment::with(['user', 'doctor', 'doctor.department', 'relative'])
            ->whereDate('appointment_date', $today)
            ->where('status', 'Confirmed')
            ->orderByRaw("TIME(STR_TO_DATE(SUBSTRING_INDEX(appointment_time, '-', 1), '%h:%i %p'))")
            ->get();

        return view('nurse.nurse-appointments', compact('appointments'));
    }


    public function get_emergency_patients()
    {
        // Set Asia/Kolkata timezone
        date_default_timezone_set('Asia/Kolkata');

        $emergencyPatients = User::where('type', 'emergency')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        // Check if it's an AJAX request
        if (request()->ajax() || request()->has('ajax')) {
            return response()->json([
                'html' => view('nurse.emergency_content_partial', compact('emergencyPatients'))->render(),
                'count' => $emergencyPatients->count(),
                'timestamp' => now()->toDateTimeString()
            ]);
        }

        return view('nurse.emergency_patient', compact('emergencyPatients'));
    }



    public function get_profile()
    {
        // 'nurse' guard से employee डाटा fetch करें
        $nurse = auth('nurse')->user();

        if (!$nurse) {
            return redirect()->route('nurse.login');
        }

        // Employee के साथ सभी related data fetch करें
        $nurse->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);

        return view('nurse.profile', compact('nurse'));
    }

    public function view_profile()
    {
        $nurse = auth('nurse')->user();

        if (!$nurse) {
            return redirect()->route('nurse.login');
        }

        $nurse->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);

        return view('nurse.edit-profile', compact('nurse'));
    }


    public function update_profile(Request $request)
{
    $nurse = auth('nurse')->user();

    if (!$nurse) {
        return redirect()->route('nurse.login');
    }

    DB::transaction(function () use ($request, $nurse) {
        /* ================= BASIC UPDATE ================= */
        $nurse->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->date_of_birth,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
            'department_id' => $request->department_id,
        ]);

        /* ================= IMAGE UPLOAD ================= */
        if ($request->hasFile('image')) {
            // delete old image
            if ($nurse->image && Storage::disk('public')->exists($nurse->image)) {
                Storage::disk('public')->delete($nurse->image);
            }

            // store new image
            $path = $request->file('image')->store('employees', 'public');

            // update image column
            $nurse->update(['image' => $path]);
        }

        /* ================= ADDRESSES ================= */
        if ($request->addresses) {
            foreach ($request->addresses as $address) {
                if (!empty($address['id'])) {
                    $existing = $nurse->addresses()->find($address['id']);
                    if ($existing) {
                        $existing->update([
                            'address_type' => $address['address_type'] ?? $existing->address_type,
                            'street' => $address['street'] ?? $existing->street,
                            'city' => $address['city'] ?? $existing->city,
                            'state' => $address['state'] ?? $existing->state,
                            'country' => $address['country'] ?? $existing->country,
                            'postal_code' => $address['postal_code'] ?? $existing->postal_code,
                        ]);
                    }
                } else {
                    $nurse->addresses()->create([
                        'address_type' => $address['address_type'] ?? 'Home',
                        'street' => $address['street'] ?? '',
                        'city' => $address['city'] ?? '',
                        'state' => $address['state'] ?? '',
                        'country' => $address['country'] ?? '',
                        'postal_code' => $address['postal_code'] ?? '',
                    ]);
                }
            }
        }

        /* ================= PROFESSIONS ================= */
        if ($request->professions) {
            foreach ($request->professions as $profession) {
                if (!empty($profession['id'])) {
                    $existing = $nurse->professions()->find($profession['id']);
                    if ($existing) {
                        $existing->update([
                            'title' => $profession['title'] ?? $existing->title,
                            'department_id' => $profession['department_id'] ?? $existing->department_id,
                        ]);
                    }
                } else {
                    $nurse->professions()->create([
                        'title' => $profession['title'] ?? '',
                        'department_id' => $profession['department_id'] ?? null,
                    ]);
                }
            }
        }

        /* ================= QUALIFICATIONS ================= */
        if ($request->qualifications) {
            foreach ($request->qualifications as $qualification) {
                if (!empty($qualification['id'])) {
                    $existing = $nurse->qualifications()->find($qualification['id']);
                    if ($existing) {
                        $existing->update([
                            'degree' => $qualification['degree'] ?? $existing->degree,
                            'institution' => $qualification['institution'] ?? $existing->institution,
                            'year_completed' => $qualification['year_completed'] ?? $existing->year_completed,
                        ]);
                    }
                } else {
                    $nurse->qualifications()->create([
                        'degree' => $qualification['degree'] ?? '',
                        'institution' => $qualification['institution'] ?? '',
                        'year_completed' => $qualification['year_completed'] ?? '',
                    ]);
                }
            }
        }

        /* ================= FAMILY DETAILS ================= */
        if ($request->family_details) {
            foreach ($request->family_details as $family) {
                if (!empty($family['id'])) {
                    $existing = $nurse->familyDetails()->find($family['id']);
                    if ($existing) {
                        $existing->update([
                            'name' => $family['name'] ?? $existing->name,
                            'relationship' => $family['relationship'] ?? $existing->relationship,
                            'date_of_birth' => $family['date_of_birth'] ?? $existing->date_of_birth,
                            'contact_number' => $family['contact_number'] ?? $existing->contact_number,
                        ]);
                    }
                } else {
                    $nurse->familyDetails()->create([
                        'name' => $family['name'] ?? '',
                        'relationship' => $family['relationship'] ?? '',
                        'date_of_birth' => $family['date_of_birth'] ?? null,
                        'contact_number' => $family['contact_number'] ?? '',
                    ]);
                }
            }
        }

        /* ================= DOCUMENTS UPLOAD ================= */
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                $storedPath = $doc->store('employee_documents', 'public');

                $nurse->documents()->create([
                    'document_type' => $doc->getClientOriginalExtension(),
                    'document_path' => $storedPath,
                    'uploaded_at' => now(),
                ]);
            }
        }

        /* ================= DELETE RELATED DATA ================= */
        // Delete addresses
        if ($request->filled('deleted_addresses')) {
            $ids = json_decode($request->deleted_addresses, true);
            if (is_array($ids) && count($ids) > 0) {
                $nurse->addresses()->whereIn('id', $ids)->delete();
            }
        }

        // Delete professions
        if ($request->filled('deleted_professions')) {
            $ids = json_decode($request->deleted_professions, true);
            if (is_array($ids) && count($ids) > 0) {
                $nurse->professions()->whereIn('id', $ids)->delete();
            }
        }

        // Delete qualifications
        if ($request->filled('deleted_qualifications')) {
            $ids = json_decode($request->deleted_qualifications, true);
            if (is_array($ids) && count($ids) > 0) {
                $nurse->qualifications()->whereIn('id', $ids)->delete();
            }
        }

        // Delete family details
        if ($request->filled('deleted_family_details')) {
            $ids = json_decode($request->deleted_family_details, true);
            if (is_array($ids) && count($ids) > 0) {
                $nurse->familyDetails()->whereIn('id', $ids)->delete();
            }
        }

        // Delete documents
        if ($request->filled('deleted_documents')) {
            $ids = json_decode($request->deleted_documents, true);
            
            if (is_array($ids) && count($ids) > 0) {
                foreach ($nurse->documents()->whereIn('id', $ids)->get() as $doc) {
                    if (Storage::disk('public')->exists($doc->document_path)) {
                        Storage::disk('public')->delete($doc->document_path);
                    }
                    
                    $doc->delete();
                }
            }
        }
    });

    return redirect()
        ->back()
        ->with('success', 'Profile updated successfully');
}

    

   
}
