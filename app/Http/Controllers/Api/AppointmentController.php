<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use App\Models\Employee;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * 📅 Book an appointment (Authenticated User)
     */
  public function bookAppointment(Request $request)
{
    $user = $request->user(); // ✅ Logged-in user via token

    // ✅ Validate input using Validator
    $validator = Validator::make($request->all(), [
        'for_user_type' => 'required|in:self,relative',
        'relative_id' => 'nullable|exists:relatives,relative_id',
        'doctor_id' => 'required|exists:employees,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:H:i',
        'issue' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'shift_name' => 'nullable|string',
        'type' => 'required|in:Appointment,Video Consultation', // ✅ new field
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $data = $validator->validated();

    // ✅ Prevent double booking for same doctor & time (for same type)
    $exists = Appointment::where('doctor_id', $data['doctor_id'])
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->where('type', $data['type'])
        ->where('status', '!=', 'Cancelled')
        ->exists();

    if ($exists) {
        return response()->json([
            'status' => false,
            'message' => 'This time slot is already booked for the doctor.'
        ], 409);
    }

    // ✅ Create a unique appointment code
    $latestId = Appointment::max('appointment_id') + 1;
    $appointmentCode = 'APT-' . str_pad($latestId, 5, '0', STR_PAD_LEFT);

    // ✅ Create appointment
    $appointment = Appointment::create([
        'appointment_code' => $appointmentCode,
        'booked_by_user_id' => $user->id,
        'for_user_type' => $data['for_user_type'],
        'relative_id' => $data['for_user_type'] === 'relative' ? $data['relative_id'] : null,
        'doctor_id' => $data['doctor_id'],
        'appointment_date' => $data['appointment_date'],
        'appointment_time' => $data['appointment_time'],
        'issue' => $data['issue'] ?? null,
        'description' => $data['description'] ?? null,
        'type' => $data['type'], // ✅ Store the type
        'status' => 'Pending',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Appointment booked successfully!',
        'appointment' => $appointment,
        'user' => [
            'id' => $user->id,
            'name' => $user->full_name ?? $user->name ?? 'Unknown',
        ]
    ]);
}
    /**
     * 👤 Get all appointments for the authenticated user
     */
    public function getUserAppointments(Request $request)
    {
        $user = $request->user();

        $appointments = Appointment::with(['doctor', 'relative'])
            ->where('booked_by_user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->full_name,
            ],
            'appointments' => $appointments,
        ]);
    }

    /**
     * ❌ Cancel appointment (Authenticated User)
     */
    public function cancelAppointment($appointment_id, Request $request)
    {
        $user = $request->user();

        $appointment = Appointment::where('appointment_id', $appointment_id)
            ->where('booked_by_user_id', $user->id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'status' => false,
                'message' => 'Appointment not found or not yours.'
            ], 404);
        }

        if ($appointment->status === 'Cancelled') {
            return response()->json([
                'status' => false,
                'message' => 'Appointment already cancelled.'
            ], 400);
        }

        $appointment->update(['status' => 'Cancelled']);

        return response()->json([
            'status' => true,
            'message' => 'Appointment cancelled successfully.'
        ]);
    }
}
