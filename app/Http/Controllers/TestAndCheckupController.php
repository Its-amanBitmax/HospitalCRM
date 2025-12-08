<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TestCheckup;
use App\Models\TestBook;
use App\Models\User;
use App\Models\TestReport;
use Illuminate\Http\Request;

class TestAndCheckupController extends Controller
{
    public function test_and_checkup(Request $request)
    {
        $query = TestCheckup::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by fasting required
        if ($request->has('fasting_required') && $request->fasting_required != '') {
            $query->where('fasting_required', $request->fasting_required == 'yes');
        }

        // Search by test name, description, or sample type
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('test_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('sample_type', 'like', '%' . $search . '%');
            });
        }

        // Get unique categories for filter dropdown
        $categories = TestCheckup::distinct()->pluck('category')->filter();

        // Get stats
        $totalTests = TestCheckup::count();
        $activeTests = TestCheckup::where('status', 'active')->count();
        $inactiveTests = TestCheckup::where('status', 'inactive')->count();

        $tests = $query->latest()->get();

        return view('admin.testandcheckup.index', compact('tests', 'categories', 'totalTests', 'activeTests', 'inactiveTests'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.testandcheckup.create', compact('departments'));
    }


    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'test_name' => 'required|string|max:255',
            'test_code' => 'nullable|string|max:50|unique:test_checkups,test_code',
            'category' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'sample_required' => 'required|boolean',
            'sample_type' => 'nullable|string|max:100',
            'fasting_required' => 'required|boolean',
            'unit' => 'nullable|string|max:50',
            'tat' => 'nullable|string|max:100',
            'normal_range' => 'nullable|string',
            'instructions' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Set sample_type to null if sample not required
        if (!$request->sample_required) {
            $validated['sample_type'] = null;
        }

        // Create the test/checkup
        TestCheckup::create($validated);

        return redirect()->route('admin.test.checkup')
            ->with('success', 'Test/Checkup created successfully!');
    }



    // Show edit form
    public function edit($id)
    {
        $test = TestCheckup::findOrFail($id);
        $departments = Department::all();
        return view('admin.testandcheckup.edit', compact('test', 'departments'));
    }

    // Update the test/checkup
    public function update(Request $request, $id)
    {
        $test = TestCheckup::findOrFail($id);

        $validated = $request->validate([
            'test_name' => 'required|string|max:255',
            'test_code' => 'nullable|string|max:50|unique:test_checkups,test_code,' . $test->id,
            'category' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'sample_required' => 'required|boolean',
            'sample_type' => 'nullable|string|max:100',
            'fasting_required' => 'required|boolean',
            'unit' => 'nullable|string|max:50',
            'tat' => 'nullable|string|max:100',
            'normal_range' => 'nullable|string',
            'instructions' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if (!$request->sample_required) {
            $validated['sample_type'] = null;
        }

        $test->update($validated);

        return redirect()->route('admin.test.checkup')
            ->with('success', 'Test/Checkup updated successfully!');
    }

    public function destroy($id)
    {
        $test = TestCheckup::findOrFail($id);

        // If ranges are linked, delete them also
        if ($test->ranges) {
            $test->ranges()->delete();
        }

        $test->delete();

        return redirect()->route('admin.test.checkup')
            ->with('success', 'Test / Checkup deleted successfully!');
    }




public function test_book_users()
{
    $users = User::whereHas('testBook')->with('testBook.test')->get();

    return view('admin.testandcheckup.test-user-list', compact('users'));
}

public function uploadReport(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'booking_id' => 'required|exists:testbook,id',
        'report_file' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        'doctor_id' => 'required|exists:employees,id',
        'test_name' => 'required|string',
    ]);

    $file = $request->file('report_file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = $file->storeAs('test_reports', $fileName, 'public');

    TestReport::create([
        'user_id' => $request->user_id,
        'doctor_id' => $request->doctor_id,
        'file_path' => $filePath,
        'file_name' => $request->test_name . '_' . $fileName,
        'user_status' => 'active',
        'doctor_status' => 'active',
    ]);

    // Update test booking status to completed
    $booking = TestBook::find($request->booking_id);
    $booking->update(['status' => 'completed']);

    return response()->json(['success' => true, 'message' => 'Report uploaded and test marked as completed.']);
}

public function updateStatus(Request $request)
{
    $request->validate([
        'booking_id' => 'required|exists:testbook,id',
        'status' => 'required|in:in_progress,completed,booked',
    ]);

    $booking = TestBook::find($request->booking_id);
    $booking->update(['status' => $request->status]);

    return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
}
















    
}