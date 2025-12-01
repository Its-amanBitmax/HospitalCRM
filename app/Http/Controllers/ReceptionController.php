<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Reception;
use App\Models\Profession;
use App\Models\User;
use App\Models\PatientVisit;
use App\Models\RoomAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReceptionController extends Controller
{
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

        // Summary Data
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $todayVisits = PatientVisit::count();

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
            'totalAppointments',
            'todayAppointments',
            'todayVisits',
            'recentAppointments',
            'recentPatients'
        ));
    }

    public function get_appointments()
    {
        // Fetch all appointments of type 'Appointment' with related employee
        $appointments = Appointment::with('doctor')
            ->where('type', 'Appointment')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('receptionist.receptionist-appointments', compact('appointments'));
    }


    public function get_patients(Request $request)
    {
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

        return redirect()->route('visits.show')->with('success', 'User created successfully.');
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
}
