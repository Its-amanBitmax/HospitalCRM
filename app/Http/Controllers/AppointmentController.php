<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
     public function index()
    {
        $total = Appointment::count();
        $pending = Appointment::where('status', 'Pending')->count();
        $confirmed = Appointment::where('status', 'Confirmed')->count();
        $cancelled = Appointment::where('status', 'Cancelled')->count();

        // Upcoming appointments (today + next 3 days)
        $today = Carbon::today();
        $upcoming = Appointment::with(['doctor', 'user', 'relative'])
    ->whereDate('appointment_date', '>=', Carbon::today())
    ->whereDate('appointment_date', '<=', Carbon::today()->addDays(3))
    ->orderBy('appointment_date', 'asc')
    ->orderBy('appointment_time', 'asc')
    ->get();

        return view('admin.appointments', compact(
            'total', 'pending', 'confirmed', 'cancelled', 'upcoming'
        ));
    }

    public function accept(Appointment $appointment)
{
    $appointment->update(['status' => 'Confirmed']);

    return redirect()->back()->with('success', 'Appointment confirmed successfully!');
}

public function reject(Appointment $appointment)
{
    $appointment->update(['status' => 'Cancelled']);

    return redirect()->back()->with('success', 'Appointment cancelled successfully!');
}

public function destroy(Appointment $appointment)
{
    $appointment->delete();

    return redirect()->back()->with('success', 'Appointment deleted successfully!');
}

public function videoConsultations()
{
    // Fetch only consultation appointments
    $consultations = Appointment::with(['doctor', 'user', 'relative'])
        ->where('type', 'consultation')
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'asc')
        ->get();

    // Counts for dashboard stats
    $confirmed = $consultations->where('status', 'Confirmed')->count();
    $cancelled = $consultations->where('status', 'Cancelled')->count();
    $total = $consultations->count();

    // Filter upcoming (next 3 days)
    $upcoming = $consultations->filter(function ($app) {
        return Carbon::parse($app->appointment_date)->between(Carbon::today(), Carbon::today()->addDays(3));
    });

    return view('admin.video-consultations', compact('consultations', 'confirmed', 'cancelled', 'total', 'upcoming'));
}

public function doctorAppointments()
{
    $doctorId = auth('doctor')->id();

    $total = Appointment::where('doctor_id', $doctorId)->count();
    $pending = Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->count();
    $confirmed = Appointment::where('doctor_id', $doctorId)->where('status', 'Confirmed')->count();
    $cancelled = Appointment::where('doctor_id', $doctorId)->where('status', 'Cancelled')->count();

    // Upcoming appointments (today + next 3 days) for this doctor
    $today = Carbon::today();
    $upcoming = Appointment::with(['doctor', 'user', 'relative'])
        ->where('doctor_id', $doctorId)
        ->whereDate('appointment_date', '>=', Carbon::today())
        ->whereDate('appointment_date', '<=', Carbon::today()->addDays(3))
        ->orderBy('appointment_date', 'asc')
        ->orderBy('appointment_time', 'asc')
        ->get();

    return view('employee.appointments', compact(
        'total', 'pending', 'confirmed', 'cancelled', 'upcoming'
    ));
}


}
