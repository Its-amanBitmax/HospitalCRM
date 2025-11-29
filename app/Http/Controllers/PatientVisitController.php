<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientVisit;
use App\Models\PatientCheckup;
use App\Models\PatientDocument;
use App\Models\reception;
use App\Models\RoomAssignment;
use Illuminate\Http\Request;

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




public function doctor_checkup($userId, Request $request)
{
    $doctorId = auth('doctor')->id();
    $fromDate = $request->query('from_date');
    $toDate   = $request->query('to_date');

    // Get visits for this doctor and user
    $visits = PatientVisit::with('user')
        ->whereHas('consultantAssignment', function($q) use ($doctorId) {
            $q->where('employee_id', $doctorId)
              ->where('status', 'active');
        })
        ->where('user_id', $userId)
        ->orderBy('date_of_visit', 'desc')
        ->get();

    // Get checkups for this user, apply date filter if provided
    $checkups = PatientCheckup::with('user', 'visit')
        ->where('user_id', $userId)
        ->when($fromDate, fn($q) => $q->whereDate('checkup_date', '>=', $fromDate))
        ->when($toDate, fn($q) => $q->whereDate('checkup_date', '<=', $toDate))
        ->orderBy('checkup_date', 'desc')
        ->get();

    $user = User::findOrFail($userId);

    return view('employee.doctor_checkup', compact('visits', 'checkups', 'user'));
}






// Show the create checkup form
public function doctorCreateCheckup($userId)
{
    $user = User::findOrFail($userId);

    // Only include visits assigned to this doctor
    $doctorId = auth('doctor')->id();
    $visits = PatientVisit::where('user_id', $userId)
        ->whereHas('consultantAssignment', function($q) use ($doctorId) {
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









}
