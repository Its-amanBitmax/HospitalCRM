<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Attendance;
use App\Models\User;
use App\Models\PatientVisit;
use App\Models\PatientCheckup;
use App\Models\PatientDocument;
use App\Models\EmployeeSpeciality;
use App\Models\reception;
use App\Models\RoomAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PatientVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $visits = PatientVisit::with('reception')
            ->where('user_id', $userId)
            ->orderBy('date_of_visit', 'desc')
            ->get();
        $checkups = PatientCheckup::where('user_id', $userId)->orderBy('checkup_date', 'desc')->get();
        $documents = PatientDocument::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('admin.users.visits', compact('user', 'visits', 'checkups', 'documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($userId)
    {
        $user = User::findOrFail($userId);
        $receptions = Reception::all();
        $assignedRooms = RoomAssignment::with([
            'room:id,room_id',
            'employee:id,name'
        ])
            ->where('status', 'active')
            ->get();
        return view('admin.users.create-visit', compact('user', 'receptions', 'assignedRooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        $request->validate([
            'visit_type' => 'required|string',
            'date_of_visit' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string',
            'department_consultant' => 'nullable|string',
        ]);

        PatientVisit::create([
            'user_id' => $userId,
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
        ]);

        return response()->json(['success' => true, 'message' => 'Visit created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($userId, $visitId)
    {
        $user = User::findOrFail($userId);
        $visit = PatientVisit::where('id', $visitId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $receptions = Reception::all();

        // Fetch room assignments with employee + room for dropdown
        $assignedRooms = RoomAssignment::with('room', 'employee')
            ->where('status', 'active')
            ->get();

        return view('admin.users.edit-visit', compact('user', 'visit', 'receptions', 'assignedRooms'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userId, $visitId)
    {
        $request->validate([
            'visit_type' => 'required|string',
            'date_of_visit' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string',
            'department_consultant' => 'nullable|string',
        ]);

        $visit = PatientVisit::where('id', $visitId)->where('user_id', $userId)->firstOrFail();
        $visit->update([
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
        ]);

        return redirect()->route('admin.users.visits', $userId)->with('success', 'Visit updated successfully');
    }

    /**
     * Show the form for creating a new checkup.
     */
    public function createCheckup($userId)
    {
        $user = User::findOrFail($userId);
        $visits = PatientVisit::where('user_id', $userId)->orderBy('date_of_visit', 'desc')->get();
        return view('admin.users.create-checkup', compact('user', 'visits'));
    }

    /**
     * Store a newly created checkup in storage.
     */
    public function storeCheckup(Request $request, $userId)
    {
        $request->validate([
            'visit_id' => 'nullable|exists:patient_visits,id',
            'checkup_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        PatientCheckup::create([
            'user_id' => $userId,
            'visit_id' => $request->visit_id,
            'checkup_date' => $request->checkup_date,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
        ]);

        return response()->json(['success' => true, 'message' => 'Checkup created successfully']);
    }

    /**
     * Show the form for creating a new document.
     */
    public function createDocument($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.users.create-document', compact('user'));
    }

    /**
     * Store a newly created document in storage.
     */
    public function storeDocument(Request $request, $userId)
    {
        $request->validate([
            'document_type' => 'required|string',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');

        PatientDocument::create([
            'user_id' => $userId,
            'document_type' => $request->document_type,
            'document_path' => $path,
        ]);

        return response()->json(['success' => true, 'message' => 'Document uploaded successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId, $visitId)
    {
        $visit = PatientVisit::where('id', $visitId)->where('user_id', $userId)->firstOrFail();
        $visit->delete();

        return redirect()->route('admin.users.visits', $userId)->with('success', 'Visit deleted successfully');
    }

    /**
     * Show the form for editing the specified checkup.
     */
    public function editCheckup($userId, $checkupId)
    {
        $user = User::findOrFail($userId);
        $checkup = PatientCheckup::where('id', $checkupId)->where('user_id', $userId)->firstOrFail();
        $visits = PatientVisit::where('user_id', $userId)->orderBy('date_of_visit', 'desc')->get();
        return view('admin.users.edit-checkup', compact('user', 'checkup', 'visits'));
    }

    /**
     * Update the specified checkup in storage.
     */
    public function updateCheckup(Request $request, $userId, $checkupId)
    {
        $request->validate([
            'visit_id' => 'nullable|exists:patient_visits,id',
            'checkup_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        $checkup = PatientCheckup::where('id', $checkupId)->where('user_id', $userId)->firstOrFail();
        $checkup->update([
            'visit_id' => $request->visit_id,
            'checkup_date' => $request->checkup_date,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
        ]);

        return response()->json(['success' => true, 'message' => 'Checkup updated successfully']);
    }

    /**
     * Remove the specified checkup from storage.
     */
    public function destroyCheckup($userId, $checkupId)
    {
        $checkup = PatientCheckup::where('id', $checkupId)->where('user_id', $userId)->firstOrFail();
        $checkup->delete();

        return redirect()->route('admin.users.visits', $userId)->with('success', 'Checkup deleted successfully');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroyDocument($userId, $documentId)
    {
        $document = PatientDocument::where('id', $documentId)->where('user_id', $userId)->firstOrFail();
        // Optionally delete the file from storage
        if (\Storage::disk('public')->exists($document->document_path)) {
            \Storage::disk('public')->delete($document->document_path);
        }
        $document->delete();

        return redirect()->route('admin.users.visits', $userId)->with('success', 'Document deleted successfully');
    }





    public function doctor_visit_summary(Request $request, $userId)
    {
        // Get user details
        $user = User::findOrFail($userId);

        // Patient Visits (with Reception)
        $visits = PatientVisit::with('reception')
            ->where('user_id', $userId)
            ->orderBy('date_of_visit', 'desc')
            ->get();

        // Patient Checkups
        $checkups = PatientCheckup::where('user_id', $userId)
            ->orderBy('checkup_date', 'desc')
            ->get();

        // Patient Documents
        $documents = PatientDocument::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Return Doctor Panel View
        return view('employee.doctor_patient_summary', compact(
            'user',
            'visits',
            'checkups',
            'documents'
        ));
    }

    // Show the create checkup form
    public function doctorCreateCheckup($userId)
    {
        $user = User::findOrFail($userId);

        // Only include visits assigned to this doctor
        $doctorId = auth('doctor')->id();
        $visits = PatientVisit::where('user_id', $userId)
            ->whereHas('consultantAssignment', function ($q) use ($doctorId) {
                $q->where('employee_id', $doctorId)
                    ->where('status', 'active');
            })
            ->orderBy('date_of_visit', 'desc')
            ->get();

        return view('employee.doctor_create_checkup', compact('user', 'visits'));
    }

    // Store checkup (server-side)
    public function storePatientCheckup(Request $request, $userId)
    {
        $request->validate([
            'checkup_date' => 'required|date',
            'visit_id' => 'nullable|exists:patient_visits,id',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        $checkup = new PatientCheckup();
        $checkup->user_id = $userId;
        $checkup->visit_id = $request->visit_id;
        $checkup->checkup_date = $request->checkup_date;
        $checkup->diagnosis = $request->diagnosis;
        $checkup->treatment = $request->treatment;
        $checkup->save();

        return redirect()->route('employee.doctor_patients')
            ->with('success', 'Checkup created successfully!');
    }

    public function doctor_Edit_Checkup($userId, $checkupId)
    {
        $user = User::findOrFail($userId);
        $checkup = PatientCheckup::findOrFail($checkupId);

        // You forgot this part — required for dropdown
        $visits = PatientVisit::where('user_id', $userId)
            ->orderBy('date_of_visit', 'desc')
            ->get();

        return view('employee.doctor_edit_checkup', compact('user', 'checkup', 'visits'));
    }

    public function doctor_update_Checkup(Request $request, $userId, $checkupId)
    {
        $request->validate([
            'visit_id' => 'nullable|exists:patient_visits,id',
            'checkup_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        // Only match checkup id + user id
        $checkup = PatientCheckup::where('id', $checkupId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Update values
        $checkup->update([
            'visit_id' => $request->visit_id,
            'checkup_date' => $request->checkup_date,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
        ]);

        return redirect()
            ->route('employee.users.summary', $userId)
            ->with('success', 'Checkup updated successfully.');
    }


    public function doctor_delete_Checkup($userId, $checkupId)
    {
        // Find checkup for this user
        $checkup = PatientCheckup::where('id', $checkupId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Delete the checkup
        $checkup->delete();

        // Redirect back with success message
        return redirect()
            ->route('employee.users.summary', $userId)
            ->with('success', 'Checkup deleted successfully.');
    }



    public function doctorCreateDocument($userId)
    {
        $user = User::findOrFail($userId);
        return view('employee.doctor_create_document', compact('user'));
    }

    public function doctorStoreDocument(Request $request, $userId)
    {
        $request->validate([
            'document_type' => 'required|string',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');

        PatientDocument::create([
            'user_id' => $userId,
            'document_type' => $request->document_type,
            'document_path' => $path,
        ]);

        return redirect()
            ->route('employee.users.summary', $userId)
            ->with('success', 'Document uploaded successfully.');
    }

    public function doctorDeleteDocument($userId, $documentId)
    {
        $document = PatientDocument::where('id', $documentId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Delete file from storage if exists
        if (\Storage::disk('public')->exists($document->document_path)) {
            \Storage::disk('public')->delete($document->document_path);
        }

        $document->delete();

        return redirect()
            ->route('employee.users.summary', $userId)
            ->with('success', 'Document deleted successfully.');
    }


    public function reports()
    {
        // 1. Get logged-in doctor ID
        $doctorId = auth('doctor')->id();

        // 2. Get room assignment IDs assigned to this doctor
        $assignmentIds = RoomAssignment::where('employee_id', $doctorId)
            ->pluck('id');

        // 3. Get patient IDs who visited these assignments
        $patientIds = PatientVisit::whereIn('department_consultant', $assignmentIds)
            ->pluck('user_id')
            ->unique();

        // 4. Get documents for these patients
        $reports = PatientDocument::whereIn('user_id', $patientIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employee.doctor_patient_report', compact('reports'));
    }

    public function doctor_profile_settings()
    {
        $doctor = auth('doctor')->user();

        // fetch address
        $address = Address::where('employee_id', $doctor->id)->first();

        return view('employee.doctor_profile_settings', compact('doctor', 'address'));
    }

    public function update_doctor_profile(Request $request)
    {
        $doctor = auth('doctor')->user();

        // ===========================
        // UPDATE DOCTOR BASIC DETAILS
        // ===========================
        $doctor->name          = $request->name;
        $doctor->email         = $request->email;
        $doctor->phone         = $request->phone;
        $doctor->gender        = $request->gender;
        $doctor->date_of_birth = $request->date_of_birth;

        // If doctor uploads image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('doctor_images', 'public');
            $doctor->image = $path;
        }

        $doctor->save();

        // ===========================
        // UPDATE OR CREATE ADDRESS
        // ===========================
        Address::updateOrCreate(
            ['employee_id' => $doctor->id],  // WHERE employee_id = ?
            [
                'address_type' => 'Home',
                'street'       => $request->street,
                'city'         => $request->city,
                'state'        => $request->state,
                'country'      => $request->country,
                'postal_code'  => $request->postal_code,
            ]
        );

        return back()->with('success', 'Profile updated successfully');
    }





    public function settings()
    {
        $doctor = auth('doctor')->user();

        // Load all related data like admin edit page
        $doctor->load([
            'department',
            'specialities',
            'qualifications',
            'documents',
            'payroll',
            'addresses',
            'familyDetails',
            'shifts',
            'professions'
        ]);

        // dd($doctor);

        return view('employee.doctor_settings', compact('doctor'));
    }


public function doctor_attendence(Request $request)
{
    $doctor = auth('doctor')->user();
    $today = Carbon::now('Asia/Kolkata')->toDateString();
    $filter = $request->query('filter', 'today');

    $historyQuery = Attendance::where('employee_id', $doctor->id)
        ->orderBy('date', 'desc');

    if ($filter === 'today') {
        $historyQuery->where('date', $today);
    } elseif ($filter === 'weekly') {
        $historyQuery->whereBetween('date', [
            Carbon::now('Asia/Kolkata')->startOfWeek()->toDateString(),
            Carbon::now('Asia/Kolkata')->endOfWeek()->toDateString()
        ]);
    } elseif ($filter === 'monthly') {
        $historyQuery->whereBetween('date', [
            Carbon::now('Asia/Kolkata')->startOfMonth()->toDateString(),
            Carbon::now('Asia/Kolkata')->endOfMonth()->toDateString()
        ]);
    }

    $history = $historyQuery->get();

    $attendance = Attendance::where('employee_id', $doctor->id)
        ->where('date', $today)
        ->first();

    return view('employee.doctor_attendence', compact('doctor', 'attendance', 'history', 'filter'));
}

public function doctor_attendance_mark(Request $request)
{
    $request->validate([
        'type' => 'required|in:clock_in,clock_out',
        'notes' => 'nullable|string|max:500'
    ]);

    $doctor = auth('doctor')->user();
    $now = Carbon::now('Asia/Kolkata');
    $today = $now->toDateString();
    $time24 = $now->format('H:i:s'); // Store full time in DB

    $attendance = Attendance::firstOrNew([
        'employee_id' => $doctor->id,
        'date' => $today
    ]);

    if ($request->type === 'clock_in') {
        if ($attendance->check_in) {
            return response()->json(['message' => 'Already Clocked In!'], 400);
        }

        // Determine status
        $attendance->status = $time24 <= '09:30:00' ? 'present' : 'half_day';
        $attendance->check_in = $time24;
        $attendance->notes = $request->notes;
        $attendance->save();

        return response()->json(['message' => 'Clocked In Successfully!']);
    }

    if ($request->type === 'clock_out') {
        if (!$attendance->check_in) {
            return response()->json(['message' => 'Clock In first!'], 400);
        }
        if ($attendance->check_out) {
            return response()->json(['message' => 'Already Clocked Out!'], 400);
        }

        $attendance->check_out = $time24;
        $attendance->notes = $request->notes;
        $attendance->save();

        return response()->json(['message' => 'Clocked Out Successfully!']);
    }
}

}
