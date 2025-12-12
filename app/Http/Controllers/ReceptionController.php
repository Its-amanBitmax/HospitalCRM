<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Reception;
use App\Models\Profession;
use App\Models\User;
use App\Models\PatientVisit;
use App\Models\RoomAssignment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ReceptionController extends Controller
{
    private function checkAssignedReception()
    {
        $assignedReception = Reception::with('employee')->where('assigned_employee', auth('receptionist')->id())->first();
        if (!$assignedReception) {
            return view('receptionist.receptionist-dashboard'); // This will show the modal
        }
        return null;
    }

    // Show list of receptions with filters and pagination
    public function index(Request $request)
    {
        $totalReceptions = Reception::count();
        $activeReceptions = Reception::where('status', 'active')->count();
        $inactiveReceptions = Reception::where('status', 'inactive')->count();

        // Auto-generate next Reception ID
        $lastReception = Reception::latest('id')->first();
        $newNumber = $lastReception ? ((int) str_replace('RECEP', '', $lastReception->reception_id) + 1) : 1;
        $nextReceptionId = 'RECEP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $query = Reception::query();
        $query = Reception::with('employee');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reception_id', 'like', '%' . $search . '%')
                    ->orWhereHas('employee', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $receptions = $query->orderBy('id', 'desc')->paginate(10);
        $receptionists = Profession::where('title', 'Receptionist')
            ->with('employee')
            ->get();
        return view('admin.receptions.index', compact(
            'receptions',
            'totalReceptions',
            'activeReceptions',
            'inactiveReceptions',
            'nextReceptionId',
            'receptionists'
        ));
    }

    // Store new reception
    public function store(Request $request)
    {
        $request->validate([
            'reception_id' => 'required|string|unique:receptions,reception_id',
            'status' => 'required|in:active,inactive'
        ]);

        Reception::create([
            'reception_id' => $request->reception_id,
            'status' => $request->status
        ]);

        return redirect()->route('admin.reception.index')->with('success', 'Reception added successfully.');
    }

    // Update reception
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:receptions,id',
            'reception_id' => 'nullable|string|max:255',
            'assigned_employee' => 'nullable|exists:employees,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        $reception = Reception::findOrFail($request->id);

        // Only update if present in the request
        if ($request->has('reception_id')) {
            $reception->reception_id = $request->reception_id;
        }

        if ($request->has('assigned_employee')) {
            $reception->assigned_employee = $request->assigned_employee;
        }

        if ($request->has('status')) {
            $reception->status = $request->status;
        }

        $reception->save();

        return redirect()->route('admin.reception.index')
            ->with('success', 'Reception updated successfully.');
    }

    // Delete reception
    public function destroy($id)
    {
        $reception = Reception::findOrFail($id);
        $reception->delete();

        return redirect()->route('admin.reception.index')->with('success', 'Reception deleted successfully.');
    }


    public function assignReceptionEmployee(Request $request, $receptionId)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Find or create the reception
        $reception = \App\Models\Reception::updateOrCreate(
            ['id' => $receptionId],
            [
                'assigned_employee' => $request->employee_id,
                'status' => 'active',
            ]
        );

        return redirect()->back()->with('success', 'Employee assigned successfully.');
    }


    public function unassignReceptionEmployee($id)
    {
        $reception = \App\Models\Reception::findOrFail($id);
        $reception->assigned_employee = null;
        $reception->save();

        return redirect()->back()->with('success', 'Employee unassigned successfully.');
    }

    public function reception_visit()
    {
        $users = \App\Models\User::all();
        return view('admin.receptions.opd', compact('users'));
    }

    public function reception_visit_users(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $visits = PatientVisit::where('user_id', $userId)->orderBy('date_of_visit', 'desc')->get();
        return view('admin.receptions.visits', compact('user', 'visits',));
    }


    public function get_receptions()
    {
        $receptions = Reception::with('employee')->get();

        // Get assigned reception for the current receptionist
        $assignedReception = Reception::with('employee')->where('assigned_employee', auth('receptionist')->id())->first();

        // Summary Data
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $todayVisits = PatientVisit::count();
        $receptionCount = Reception::count();

        // Recent Appointments
        $recentAppointments = Appointment::with(['doctor', 'relative'])
            ->orderBy('appointment_date', 'desc')
            ->take(10)
            ->get();

        // 🔥 NEW: Recent Patients (last 10 visits)
        $recentPatients = PatientVisit::with('user')
            ->orderBy('date_of_visit', 'desc')
            ->take(10)
            ->get();

        return view('receptionist.receptionist-dashboard', compact(
            'receptions',
            'assignedReception',
            'totalAppointments',
            'todayAppointments',
            'todayVisits',
            'recentAppointments',
            'recentPatients',
            'receptionCount'
        ));
    }

    public function get_appointments()
    {
        // Check if receptionist has assigned reception
        $check = $this->checkAssignedReception();
        if ($check) return $check;

        // Fetch all appointments of type 'Appointment' with related employee
        $appointments = Appointment::with('doctor')

            ->orderBy('appointment_date', 'desc')
            ->where('status', 'confirmed')
            ->get();

        return view('receptionist.receptionist-appointments', compact('appointments'));
    }


    public function get_patients(Request $request)
    {
        // Check if receptionist has assigned reception
        $check = $this->checkAssignedReception();
        if ($check) return $check;

        // Start query for patients
        $query = User::query();

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile_no', 'like', '%' . $search . '%');
            });
        }

        // Apply type filter if provided
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Fetch filtered patients
        $patients = $query->get();

        // Count by type (always show all types for filter options)
        $allPatients = User::all();
        $typeCounts = $allPatients->groupBy('type')->map->count();

        return view('receptionist.receptionist-patients', compact('patients', 'typeCounts'));
    }




    public function showUserVisits(User $user)
    {
        $userVisits = PatientVisit::with(['reception', 'consultantAssignment.room', 'consultantAssignment.employee'])
            ->where('user_id', $user->id)
            ->orderBy('date_of_visit', 'desc')
            ->get();

        return view('receptionist.receptionist-visit', [
            'user' => $user,
            'visits' => $userVisits
        ]);
    }

    // Show form to create a visit for a specific user
    public function createUserVisit(User $user)
    {
        // Check if receptionist has assigned reception
        $check = $this->checkAssignedReception();
        if ($check) return $check;

        // Fetch all receptions
        $receptions = Reception::all();

        // Fetch rooms assigned to doctors (or receptionist context)
        $assignedRooms = RoomAssignment::with(['room', 'employee'])->get();

        return view('receptionist.receptionist-create-visit', compact('user', 'receptions', 'assignedRooms'));
    }


    // Store a new visit
    public function storeUserVisit(Request $request, User $user)
    {
        $data = $request->validate([
            'visit_type' => 'required|string|max:255',
            'date_of_visit' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|exists:receptions,id',
            'department_consultant' => 'nullable|exists:room_assignments,id',
        ]);

        $data['user_id'] = $user->id;

        PatientVisit::create($data);

        // Return JSON for your fetch
        return response()->json([
            'success' => true,
            'message' => 'Visit added successfully.'
        ]);
    }


    // Edit a visit
    public function editUserVisit(User $user, PatientVisit $visit)
    {
        // Get all active receptions (or as per your logic)
        $receptions = Reception::all();

        // Get rooms assigned to doctors (or as per your logic)
        $assignedRooms = RoomAssignment::with(['room', 'employee'])->get();

        return view('receptionist.receptionist-edit-visit', compact('user', 'visit', 'receptions', 'assignedRooms'));
    }


    // Update a visit
    public function updateUserVisit(Request $request, User $user, PatientVisit $visit)
    {
        $data = $request->validate([
            'visit_type' => 'required|string|max:255',
            'date_of_visit' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|exists:receptions,id',
            'department_consultant' => 'nullable|exists:room_assignments,id',
        ]);

        $visit->update($data);

        return redirect()->route('visits.show', $user->id)
            ->with('success', 'Visit updated successfully.');
    }

    // Delete a visit
    public function deleteUserVisit(User $user, PatientVisit $visit)
    {
        $visit->delete();

        return redirect()->route('visits.show', $user->id)
            ->with('success', 'Visit deleted successfully.');
    }



    public function patient_create()
    {
        return view('receptionist.receptionist-create-patient');
    }


    public function patient_save(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'mobile_no' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:20',
            'full_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
            'visit_type' => 'nullable|in:OPD,Emergency,Appointment',
            'date_of_visit' => 'nullable|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'department_consultant' => 'nullable|string|max:255',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
            'registered_through' => 'nullable|in:email,msg,whatsapp,offline',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique user_id with date and username
        $date = now()->format('Ymd');
        $username = $request->username ? strtoupper(substr($request->username, 0, 3)) : 'USR';
        $userId = 'USR' . $date . $username . rand(100, 999);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        $user = \App\Models\User::create([
            'user_id' => $userId,
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => $request->password ? Hash::make($request->password) : null,
            'age' => $request->age,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'father_spouse_name' => $request->father_spouse_name,
            'alternate_no' => $request->alternate_no,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
            'id_proof_type' => $request->id_proof_type,
            'id_number' => $request->id_number,
            'type' => $request->type,
            'status' => $request->status,
            'registered_through' => $request->registered_through,
            'image' => $imagePath,
        ]);

        return redirect()->route('receptionist.patients')->with('success', 'User created successfully.');
    }

    public function patient_edit($id)
    {
        $user = User::findOrFail($id);

        return view('receptionist.receptionist-edit-patient', compact('user'));
    }

    public function patient_update(Request $request, $id)
    {
        $patient = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $patient->id,
            'email' => 'nullable|email|unique:users,email,' . $patient->id,
            'mobile_no' => 'required|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:20',
            'full_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
            'visit_type' => 'nullable|in:OPD,Emergency,Appointment',
            'date_of_visit' => 'nullable|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'department_consultant' => 'nullable|string|max:255',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
            'registered_through' => 'nullable|in:email,msg,whatsapp,offline',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image update
        $imagePath = $patient->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        $patient->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'age' => $request->age,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'father_spouse_name' => $request->father_spouse_name,
            'alternate_no' => $request->alternate_no,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
            'id_proof_type' => $request->id_proof_type,
            'id_number' => $request->id_number,
            'type' => $request->type,
            'status' => $request->status,
            'registered_through' => $request->registered_through,
            'image' => $imagePath,
        ]);

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Patient updated successfully.'
            ]);
        }

        return redirect()->route('visits.show')->with('success', 'Patient updated successfully.');
    }

    public function patient_delete($id)
    {
        $user = User::findOrFail($id);


        Appointment::where('booked_by_user_id', $id)->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Patient deleted successfully.');
    }


    public function ViewUsers(User $user)
    {
        // Patient Visits
        $userVisits = PatientVisit::with(['reception', 'consultantAssignment.room', 'consultantAssignment.employee'])
            ->where('user_id', $user->id)
            ->orderBy('date_of_visit', 'desc')
            ->get();

        // Appointments
        $appointments = Appointment::where(function ($q) use ($user) {

            // Self appointments (booked for the same user)
            $q->where(function ($self) use ($user) {
                $self->where('for_user_type', 'self')
                    ->where('booked_by_user_id', $user->id);
            });

            // Relative appointments (if this user is a relative)
            $q->orWhere(function ($rel) use ($user) {
                $rel->where('for_user_type', 'relative')
                    ->where('relative_id', $user->id);
            });
        })
            ->orderBy('appointment_date', 'desc')
            ->get();


        return view('receptionist.receptionist-view-patients', [
            'user' => $user,
            'visits' => $userVisits,
            'appointments' => $appointments
        ]);
    }


    public function get_profile_settings()
    {
        $employee = auth('receptionist')->user();
        return view('receptionist.receptionist-profile-setting', compact('employee'));
    }


    public function profile_view()
    {
        $employee = \App\Models\Employee::with([
            'department',
            'addresses',
            'qualifications',
            'documents',
            'familyDetails',
            'payroll'
        ])->find(auth('receptionist')->id());

        return view('receptionist.receptionist-view-profile', compact('employee'));
    }




    public function update_profile(Request $request)
    {
        $user = auth('receptionist')->user();

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:employees,email,' . $user->id,
            'phone'          => 'nullable|string|max:20',
            'gender'         => 'nullable|in:Male,Female,Other',
            'status'         => 'required|in:Active,Inactive',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        // Update fields
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->gender        = $request->gender;
        $user->status        = $request->status;
        // Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('employees', 'public');
            $user->image = $path;
        }
        $user->save();
        return back()->with('success', 'Profile Updated Successfully!');
    }





    public function receptionist_attendence()
    {
        $employee = auth('receptionist')->user();
        $today = Carbon::today('Asia/Kolkata')->toDateString();

        // Get filter from request or default to 'all'
        $filter = request()->get('filter', 'all');
        $startDate = null;
        $endDate = null;

        // Calculate date ranges based on filter
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
                // No date filter for all records
                break;
        }

        // Get today's attendance
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        // Get attendance history based on filter
        $history = Attendance::where('employee_id', $employee->id)
            ->when($filter === 'today', function ($query) use ($today) {
                return $query->where('date', $today);
            })
            ->when($filter === 'weekly', function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->when($filter === 'monthly', function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->when($filter === 'all', function ($query) {
                // No additional filter for all records
                return $query;
            })
            ->orderBy('date', 'desc')
            ->get();

        // Calculate statistics
        $totalDays = $history->count();
        $presentDays = $history->where('status', 'present')->count();
        $lateDays = $history->where('status', 'late')->count();
        $absentDays = $history->where('status', 'absent')->count();
        $halfDays = $history->where('status', 'half_day')->count();

        // Calculate attendance percentage
        $attendancePercentage = $totalDays > 0
            ? round(($presentDays + ($halfDays * 0.5)) / $totalDays * 100, 1)
            : 0;

        // Calculate average working hours
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

        // Get current week and month names
        $weekRange = $startDate && $endDate ?
            Carbon::parse($startDate)->format('d M') . ' - ' . Carbon::parse($endDate)->format('d M') :
            null;

        $monthName = $filter === 'monthly' ?
            Carbon::today('Asia/Kolkata')->format('F Y') :
            null;

        return view('receptionist.receptionist_attendance', compact(
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

    // Handle Clock In / Clock Out
    public function mark_receptionist_attendence(Request $request)
    {
        $request->validate([
            'type' => 'required|in:clock_in,clock_out',
        ]);

        $employee = auth('receptionist')->user();
        $today = Carbon::today('Asia/Kolkata')->toDateString(); // +5:30 timezone
        $now   = Carbon::now('Asia/Kolkata')->format('H:i:s');    // +5:30 timezone

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

                // Use location provided by JavaScript (from Nominatim API) or fallback to IP-based location
                if ($request->location) {
                    $attendance->check_in_location = $request->location;
                    Log::info('Clock in location from JavaScript: ' . $request->location);
                } else {
                    // Fallback to IP-based location if no location provided
                    try {
                        $ip = $request->ip();
                        $locationData = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
                        if ($locationData && $locationData['status'] === 'success') {
                            $attendance->check_in_location = $locationData['city'] . ', ' . $locationData['regionName'] . ', ' . $locationData['country'];
                            Log::info('Clock in fallback IP location: ' . $attendance->check_in_location);
                        } else {
                            Log::warning('Failed to get IP location for clock in');
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to fetch IP location for clock in: ' . $e->getMessage());
                    }
                }

                $attendance->save();

                // Check if clock-in is after 9:30 AM, mark as half-day
                $checkInTime = Carbon::createFromFormat('H:i:s', $attendance->check_in, 'Asia/Kolkata');
                $morningLimit = Carbon::createFromTime(9, 30, 0, 'Asia/Kolkata');
                if ($checkInTime->gt($morningLimit)) {
                    $attendance->status = 'half_day';
                    $attendance->save();
                    Log::info('Clock in: late arrival, marked as half_day');
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

                // Use location provided by JavaScript (from Nominatim API) or fallback to IP-based location
                if ($request->location) {
                    $attendance->check_out_location = $request->location;
                    Log::info('Clock out location from JavaScript: ' . $request->location);
                } else {
                    // Fallback to IP-based location if no location provided
                    try {
                        $ip = $request->ip();
                        $locationData = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
                        if ($locationData && $locationData['status'] === 'success') {
                            $attendance->check_out_location = $locationData['city'] . ', ' . $locationData['regionName'] . ', ' . $locationData['country'];
                            Log::info('Clock out fallback IP location: ' . $attendance->check_out_location);
                        } else {
                            Log::warning('Failed to get IP location for clock out');
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to fetch IP location for clock out: ' . $e->getMessage());
                    }
                }

                $attendance->save();

                // Calculate total hours worked and update status
                if ($attendance->check_in && $attendance->check_out) {
                    $checkInTime = Carbon::createFromFormat('H:i:s', $attendance->check_in, 'Asia/Kolkata');
                    $checkOutTime = Carbon::createFromFormat('H:i:s', $attendance->check_out, 'Asia/Kolkata');
                    $totalHours = $checkOutTime->diffInHours($checkInTime, true);

                    Log::info('Clock out: check_in=' . $attendance->check_in . ', check_out=' . $attendance->check_out . ', totalHours=' . $totalHours);

                    // Check for half-day conditions: clock in after 9:30 AM or clock out before 6:30 PM
                    $morningLimit = Carbon::createFromTime(9, 30, 0, 'Asia/Kolkata');
                    $eveningLimit = Carbon::createFromTime(18, 30, 0, 'Asia/Kolkata');

                    if ($checkInTime->gt($morningLimit) || $checkOutTime->lt($eveningLimit)) {
                        $attendance->status = 'half_day';
                        Log::info('Clock out: half-day due to late clock-in or early clock-out');
                    } else {
                        // Update status based on total hours worked
                        if ($totalHours >= 8) {
                            $attendance->status = 'present';
                        } elseif ($totalHours >= 4) {
                            $attendance->status = 'half_day';
                        } else {
                            $attendance->status = 'absent';
                        }
                    }

                    Log::info('Clock out: setting status to ' . $attendance->status);
                    $attendance->save();
                    Log::info('Clock out: status saved successfully');
                }

                return response()->json(['message' => 'Clocked Out Successfully!']);
            }
        } catch (\Exception $e) {
            Log::error('Attendance marking error: ' . $e->getMessage());
            Log::error('Request data: ' . json_encode($request->all()));
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }
}
