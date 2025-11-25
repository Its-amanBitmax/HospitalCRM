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

        // All offline appointments (type = 'Appointment')
        $offline = Appointment::with(['doctor', 'user', 'relative'])
            ->where('type', 'Appointment')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('admin.appointments', compact(
            'total', 'pending', 'confirmed', 'cancelled', 'upcoming', 'offline'
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

        // Summary counts
        $total = Appointment::where('doctor_id', $doctorId)->count();
        $pending = Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->count();
        $confirmed = Appointment::where('doctor_id', $doctorId)->where('status', 'Confirmed')->count();
        $cancelled = Appointment::where('doctor_id', $doctorId)->where('status', 'Cancelled')->count();

        // All appointments for this doctor
        $allAppointments = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Upcoming appointments (today + next 3 days)
        $upcoming = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->whereDate('appointment_date', '<=', Carbon::today()->addDays(3))
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        \Log::info("DoctorAppointments Debug: doctorId={$doctorId}, upcomingCount={$upcoming->count()}");

        return view('employee.doctor_appointments', compact(
            'total', 'pending', 'confirmed', 'cancelled', 'allAppointments', 'upcoming'
        ));
    }

    public function doctorConsultations()
    {
        $doctorId = auth('doctor')->id();

        // Summary counts for consultation type
        $total = Appointment::where('doctor_id', $doctorId)->where('type', 'consultation')->count();
        $pending = Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->where('type', 'consultation')->count();
        $confirmed = Appointment::where('doctor_id', $doctorId)->where('status', 'Confirmed')->where('type', 'consultation')->count();
        $cancelled = Appointment::where('doctor_id', $doctorId)->where('status', 'Cancelled')->where('type', 'consultation')->count();

        // All consultations for this doctor
        $allConsultations = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->where('type', 'consultation')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Upcoming consultations (today + next 3 days)
        $upcoming = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->where('type', 'consultation')
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->whereDate('appointment_date', '<=', Carbon::today()->addDays(3))
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('employee.doctor_consultations', compact(
            'total', 'pending', 'confirmed', 'cancelled', 'allConsultations', 'upcoming'
        ));
    }



}