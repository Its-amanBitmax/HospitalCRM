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


public function get_patients()
{
    // Fetch all users with type 'patient'
   $patients = User::all();

    // Count by type (optional, if you have multiple patient types)
    $typeCounts = $patients->groupBy('type')->map->count();

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




}
