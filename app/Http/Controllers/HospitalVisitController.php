<?php

namespace App\Http\Controllers;

use App\Models\HospitalVisit;
use App\Models\User;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HospitalVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HospitalVisit::with(['patient', 'doctor', 'creator']);

        // Filter by visit type
        if ($request->has('visit_type') && $request->visit_type) {
            $query->where('visit_type', $request->visit_type);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('scheduled_visit', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('scheduled_visit', '<=', $request->end_date);
        }

        // Search by visitor name or patient name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('visitor_name', 'like', "%{$search}%")
                  ->orWhereHas('patient', function($patientQuery) use ($search) {
                      $patientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        $stats = [
    'total' => HospitalVisit::count(),
    'scheduled' => HospitalVisit::where('status', 'scheduled')->count(),
    'completed' => HospitalVisit::where('status', 'completed')->count(),
    'emergency' => HospitalVisit::where('visit_type', 'emergency')->count(),
];


        $visits = $query->orderBy('scheduled_visit', 'desc')->paginate(15);

        return view('admin.visits.index', compact('visits', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = User::where('type', 'ipd')->orWhere('type', 'opd')->get();
        $doctors = Employee::with(['department', 'specialities', 'professions'])
            ->whereHas('professions', function($query) {
                $query->where('title', 'Doctor');
            })
            ->get();

        return view('admin.visits.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_contact' => 'nullable|string|max:20',
            'visitor_email' => 'nullable|email|max:255',
            'visitor_relation' => 'nullable|string|max:100',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'visit_type' => 'required|in:patient_visit,doctor_meeting,staff_meeting,delivery,emergency,invite,vendor',
            'purpose' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'patient_id' => 'nullable|exists:users,id',
            'patient_mr_no' => 'nullable|string|max:100',
            'doctor_id' => 'nullable|exists:employees,id',
            'scheduled_visit' => 'nullable|date',
            'id_proof_type' => 'nullable|string|max:50',
            'id_proof_number' => 'nullable|string|max:100',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::guard('admin')->id();

        // Set invite status if visit type is invite
        if ($request->visit_type === 'invite') {
            $data['invite_status'] = 'pending';
            $data['invited_at'] = now();
            // Generate unique invitation code
            $data['invitation_code'] = 'INV-' . strtoupper(uniqid());
        }

        HospitalVisit::create($data);

        return redirect()->route('admin.visits.index')->with('success', 'Hospital visit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HospitalVisit $visit)
    {
        $visit->load(['patient', 'doctor', 'creator', 'updater']);
        return view('admin.visits.show', compact('visit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HospitalVisit $visit)
    {
        $patients = User::where('type', 'ipd')->orWhere('type', 'opd')->get();
        $doctors = Employee::with(['department', 'specialities', 'professions'])
            ->whereHas('professions', function($query) {
                $query->where('title', 'Doctor');
            })
            ->get();

        return view('admin.visits.edit', compact('visit', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HospitalVisit $visit)
    {
        $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_contact' => 'nullable|string|max:20',
            'visitor_email' => 'nullable|email|max:255',
            'visitor_relation' => 'nullable|string|max:100',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'visit_type' => 'required|in:patient_visit,doctor_meeting,staff_meeting,delivery,emergency,invite,vendor',
            'purpose' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'patient_id' => 'nullable|exists:users,id',
            'patient_mr_no' => 'nullable|string|max:100',
            'doctor_id' => 'nullable|exists:employees,id',
            'scheduled_visit' => 'nullable|date',
            'status' => 'required|in:invited,scheduled,waiting,in_progress,completed,cancelled',
            'invite_status' => 'nullable|in:none,pending,accepted,declined',
            'invitation_code' => 'nullable|string|max:255|unique:hospital_visits,invitation_code,' . $visit->id,
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date',
            'id_proof_type' => 'nullable|string|max:50',
            'id_proof_number' => 'nullable|string|max:100',
            'badge_number' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['updated_by'] = Auth::guard('admin')->id();

        $visit->update($data);

        return redirect()->route('admin.visits.index')->with('success', 'Hospital visit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HospitalVisit $visit)
    {
        $visit->delete();

        return redirect()->route('admin.visits.index')->with('success', 'Hospital visit deleted successfully');
    }

    /**
     * Check in a visitor
     */
    public function checkIn(HospitalVisit $visit)
    {
        $visit->update([
            'check_in' => now(),
            'status' => 'in_progress',
            'updated_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Visitor checked in successfully');
    }

    /**
     * Check out a visitor
     */
    public function checkOut(HospitalVisit $visit)
    {
        $visit->update([
            'check_out' => now(),
            'status' => 'completed',
            'updated_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Visitor checked out successfully');
    }

    /**
     * Accept invitation
     */
    public function acceptInvite(HospitalVisit $visit)
    {
        $visit->update([
            'invite_status' => 'accepted',
            'updated_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Invitation accepted successfully');
    }

    /**
     * Decline invitation
     */
    public function declineInvite(HospitalVisit $visit)
    {
        $visit->update([
            'invite_status' => 'declined',
            'updated_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Invitation declined successfully');
    }

    /**
     * Generate invitation PDF
     */
    public function generateInvitationPDF(HospitalVisit $visit)
    {
        // Load relationships
        $visit->load(['patient', 'doctor']);

        // Get admin details for branding
        $admin = Admin::first();

        // Generate PDF
        $pdf = Pdf::loadView('admin.visits.invitation-pdf', compact('visit', 'admin'));

        // Return PDF download
        return $pdf->download('hospital_invitation_' . $visit->invitation_code . '.pdf');
    }
}
