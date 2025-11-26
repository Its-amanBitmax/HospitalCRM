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
        'appointment_time' => 'required|date_format:h:i A',
        'issue' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'shift_name' => 'nullable|string',
        'type' => 'required|in:Appointment,consultation',
        'subtype' => 'nullable|in:by voicecall,by chat,by video call',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $data = $validator->validated();

    // ✅ Convert appointment_time from 12-hour to 24-hour format
    $data['appointment_time'] = Carbon::createFromFormat('h:i A', $data['appointment_time'])->format('H:i');

    // ✅ Prevent double booking for same doctor & time (for same type and subtype)
    $exists = Appointment::where('doctor_id', $data['doctor_id'])
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->where('type', $data['type'])
        ->where('subtype', $data['subtype'] ?? null)
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
        'subtype' => $data['subtype'] ?? null, // ✅ Store the subtype
        'status' => 'Pending',
    ]);

    // ✅ Format appointment time to 12-hour format with AM/PM for response
    $appointment->appointment_time = Carbon::createFromFormat('H:i', $appointment->appointment_time)->format('h:i A');

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

    // Loop through each appointment and handle doctor and relative images
    $appointments->each(function ($appointment) {
        // Check for doctor and relative and modify the image field to full URL
        foreach (['doctor', 'relative'] as $relation) {
            if ($appointment->$relation && $appointment->$relation->image) {
                // Replace the image field with the full image URL
                $appointment->$relation->image = url('storage/' . $appointment->$relation->image);
            }
        }
    });

    // Return the response
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

    $request->validate([
        'cancel_reason' => 'required|string',
    ]);

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

    $appointment->update([
        'status'        => 'Cancelled',
        'cancel_reason' => $request->cancel_reason,
    ]);

    return response()->json([
        'status'        => true,
        'message'       => 'Appointment cancelled successfully.',
        'cancel_reason' => $appointment->cancel_reason,
    ]);
}




//      public function UserByAppointments(Request $request)
// {
//     $user = $request->user();

   
//     $appointments = $user->appointments()
//         ->with(['doctor', 'relative']) 
//         ->orderBy('appointment_date', 'asc') 
//         ->get();

//     $appointmentsCount = $appointments->count();

//     return response()->json([
//         'status' => true,
//         'appointments_count' => $appointmentsCount,  
//         'appointments' => $appointments,
//         'user' => [
//             'id' => $user->id,
//             'name' => $user->full_name ?? $user->name ?? 'Unknown',
//         ]
//     ]);
// }


}
