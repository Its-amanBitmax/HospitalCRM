<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientVisit;
use App\Models\PatientCheckup;
use App\Models\PatientDocument;
use Illuminate\Http\Request;

class PatientVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $visits = PatientVisit::where('user_id', $userId)->orderBy('date_of_visit', 'desc')->get();
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
        return view('admin.users.create-visit', compact('user'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Show the form for creating a new checkup.
     */
    public function createCheckup($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.users.create-checkup', compact('user'));
    }

    /**
     * Store a newly created checkup in storage.
     */
    public function storeCheckup(Request $request, $userId)
    {
        $request->validate([
            'checkup_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ]);

        PatientCheckup::create([
            'user_id' => $userId,
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
    public function destroy(string $id)
    {
        //
    }
}
