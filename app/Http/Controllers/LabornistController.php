<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestCheckup;
use App\Models\TestBook;
use App\Models\TestReport;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LabornistController extends Controller
{
    public function dashboard()
    {
        $laborist = auth('laborist')->user();

        // Get laborist ID from employees table (assuming laborist is an employee with department_id for lab)
        $laboristId = $laborist->id;

        // Total Counts based on your database structure
        $testCheckupsCount = TestCheckup::where('status', 'active')->count();
        $testCheckups = TestCheckup::with('department')->get();

        // For test bookings - we need to check relationships
        // Assuming testbook table has relationships
        $testBookingsCount = TestBook::count();

        // For test reports - using the test_reports table
        $testReportsCount = TestReport::count();

        // Today's statistics
        $todayReportsCount = TestReport::whereDate('created_at', Carbon::today())->count();
        $todayBookingsCount = TestBook::whereDate('created_at', Carbon::today())->count();

        // Recent Test Reports with patient data
        $recentReports = TestReport::with(['user', 'doctor'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Bookings with user and test data
        $recentBookings = TestBook::with(['user', 'test'])
            ->whereDate('booking_date', '>=', Carbon::today())
            ->orderBy('booking_date')
            ->take(5)
            ->get();

        // Pending bookings (with status 'pending' or 'booked')
        $pendingBookings = TestBook::whereIn('status', ['pending', 'booked'])
            ->count();

        // Active patients count (users who have done tests)
        $activePatientsCount = User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('test_reports')
                ->distinct();
        })
            ->count();

        // Weekly performance data
        $weeklyData = TestReport::select(
            DB::raw('DAYNAME(created_at) as day'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy(DB::raw('DAYNAME(created_at)'))
            ->orderBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get()
            ->keyBy('day');

        // Most common tests
        $commonTests = TestBook::select('test_checkup_id', DB::raw('COUNT(*) as count'))
            ->with('test')
            ->groupBy('test_checkup_id')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('labornist.dashboard', compact(
            'laborist',
            'testCheckupsCount',
            'testCheckups',
            'testBookingsCount',
            'testReportsCount',
            'recentReports',
            'recentBookings',
            'pendingBookings',
            'todayReportsCount',
            'todayBookingsCount',
            'weeklyData',
            'activePatientsCount',
            'commonTests'
        ));
    }

    public function view_profile()
    {
        $labornist = auth('laborist')->user();
        $labornist->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);

        return view('labornist.view-profile', compact('labornist'));
    }

    public function downloadProfilePDF()
    {
        $labornist = auth('laborist')->user();
        $labornist->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);

        $pdf = Pdf::loadView('labornist.profile-pdf', compact('labornist'));

        return $pdf->download($labornist->name . '-Profile.pdf');
    }


    
    public function edit_profile()
    {
        $labornist = auth('laborist')->user();
        $labornist->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);



        return view('labornist.edit-profile', compact('labornist'));
    }

    public function update_profile(Request $request)
    {
        $labornist = auth('laborist')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $labornist->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'status' => 'required|in:Active,Inactive',
            'department_id' => 'nullable|exists:departments,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update basic information
        $labornist->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'status' => $request->status,
            'department_id' => $request->department_id,
        ]);

        // Handle profile image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($labornist->image && file_exists(storage_path('app/public/' . $labornist->image))) {
                unlink(storage_path('app/public/' . $labornist->image));
            }

            $imagePath = $request->file('image')->store('employees', 'public');
            $labornist->update(['image' => $imagePath]);
        }

        // Handle addresses
        $existingAddressIds = [];
        if ($request->has('addresses')) {
            foreach ($request->addresses as $key => $addressData) {
                if (str_starts_with($key, 'new_')) {
                    // New address
                    $newAddress = $labornist->addresses()->create($addressData);
                    $existingAddressIds[] = $newAddress->id;
                } else {
                    // Update existing address
                    $existingAddressIds[] = $addressData['id'];
                    $address = $labornist->addresses()->find($addressData['id']);
                    if ($address) {
                        $address->update([
                            'street' => $addressData['street'] ?? '',
                            'city' => $addressData['city'] ?? '',
                            'state' => $addressData['state'] ?? '',
                        ]);
                    }
                }
            }
        }
        // Delete addresses that are not in the form
        $labornist->addresses()->whereNotIn('id', $existingAddressIds)->delete();

        // Handle qualifications
        $existingQualificationIds = [];
        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $key => $qualData) {
                if (str_starts_with($key, 'new_')) {
                    // New qualification
                    $newQualification = $labornist->qualifications()->create($qualData);
                    $existingQualificationIds[] = $newQualification->id;
                } else {
                    // Update existing qualification
                    $existingQualificationIds[] = $qualData['id'];
                    $qualification = $labornist->qualifications()->find($qualData['id']);
                    if ($qualification) {
                        $qualification->update([
                            'degree' => $qualData['degree'] ?? '',
                            'institution' => $qualData['institution'] ?? '',
                            'year_completed' => $qualData['year_completed'] ?? null,
                        ]);
                    }
                }
            }
        }
        // Delete qualifications that are not in the form
        $labornist->qualifications()->whereNotIn('id', $existingQualificationIds)->delete();

        // Handle documents
        $existingDocumentIds = [];
        if ($request->has('documents')) {
            foreach ($request->documents as $key => $docData) {
                if (str_starts_with($key, 'new_')) {
                    // New document
                    if (isset($docData['document_path']) && $request->hasFile("documents.{$key}.document_path")) {
                        $filePath = $request->file("documents.{$key}.document_path")->store('documents', 'public');
                        $docData['document_path'] = $filePath;
                    }
                    $newDocument = $labornist->documents()->create($docData);
                    $existingDocumentIds[] = $newDocument->id;
                } else {
                    // Update existing document
                    $existingDocumentIds[] = $docData['id'];
                    $document = $labornist->documents()->find($docData['id']);
                    if ($document) {
                        $updateData = [
                            'document_type' => $docData['document_type'] ?? '',
                        ];

                        if (isset($docData['document_path']) && $request->hasFile("documents.{$key}.document_path")) {
                            // Delete old file if exists
                            if ($document->document_path && file_exists(storage_path('app/public/' . $document->document_path))) {
                                unlink(storage_path('app/public/' . $document->document_path));
                            }

                            $filePath = $request->file("documents.{$key}.document_path")->store('documents', 'public');
                            $updateData['document_path'] = $filePath;
                        }

                        $document->update($updateData);
                    }
                }
            }
        }
        // Delete documents that are not in the form
        $labornist->documents()->whereNotIn('id', $existingDocumentIds)->delete();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
?>
