<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\TestCheckup;
use Illuminate\Http\Request;
use App\Models\TestBook;
use App\Models\TestReport;
use App\Models\User;

class TestAndCheckupController extends Controller
{
    public function get_all_testcheckup()
    {
        // Fetch all test/checkup records
        $tests = TestCheckup::with('department')->get();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'data' => $tests
        ]);
    }





    public function test_booking(Request $request)
    {
        // Authenticated user via Sanctum
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        // Validate request
        $request->validate([
            'test_id'      => 'required|exists:test_checkups,id',
            'booking_date' => 'required|date',
            'start_time'   => 'required|string',
            'end_time'     => 'required|string',
        ]);

        // Check duplicate booking for overlapping time
        $existing = TestBook::where('user_id', $user->id)
            ->where('test_checkup_id', $request->test_id)
            ->where('booking_date', $request->booking_date)
            ->where(function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })
            ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'This test is already booked in the selected time slot.'
            ]);
        }

        // Create booking
        $booking = TestBook::create([
            'user_id'           => $user->id,
            'test_checkup_id'   => $request->test_id,
            'booking_date'      => $request->booking_date,
            'start_time'        => $request->start_time,
            'end_time'          => $request->end_time,
            'status'            => 'Booked',
        ]);

        // Load related test and user data
        $booking->load(['test', 'user']);

        return response()->json([
            'status' => true,
            'message' => 'Test booking created successfully',
            'data' => $booking
        ]);
    }





    public function Userbookings(Request $request)
    {
        // Authenticated user via Sanctum
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        // Fetch all bookings of this user with related test and user data
        $bookings = TestBook::with(['test', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'User bookings fetched successfully',
            'data' => $bookings
        ]);
    }






    // Upload report as a user
    public function upload_report_as_user(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'user_status' => 'nullable|string',
            'doctor_id' => 'nullable|exists:doctors,id'
        ]);

        try {
            $file = $request->file('report_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('testreports', $fileName, 'public');

            $report = new TestReport();
            $report->user_id = auth()->id();
            $report->doctor_id = $request->doctor_id;
            $report->file_path = $filePath;  // 🔥 only relative path saved
            $report->file_name = $fileName;
            $report->user_status = $request->user_status ?? null;
            $report->doctor_status = $request->doctor_status ?? null;
            $report->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Report uploaded successfully by user',
                'data' => [
                    'report' => $report,
                    'file_url' => asset('storage/' . $filePath)
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload report',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    // Upload report as a doctor
    public function upload_report_as_doctor(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'doctor_status' => 'required|string',
            'user_status' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id'
        ]);

        try {
            $file = $request->file('report_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('testreports', $fileName, 'public');

            $report = new TestReport();

            // IMPORTANT CHANGE ⇒ doctor_id = auth user id
            $report->doctor_id = auth()->id();     // logged-in USER ID will be used

            $report->user_id = $request->user_id;
            $report->file_path = $filePath;
            $report->file_name = $fileName;
            $report->user_status = $request->user_status ?? null;
            $report->doctor_status = $request->doctor_status;
            $report->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Report uploaded successfully by doctor',
                'data' => [
                    'report' => $report,
                    'file_url' => asset('storage/' . $filePath)
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload report',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
