<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PatientVisit;
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
            'total',
            'pending',
            'confirmed',
            'cancelled',
            'upcoming',
            'offline'
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

    public function doctorAppointments(Request $request)
    {
        $doctorId = auth('doctor')->id();

        // Summary counts
        $total = Appointment::where('doctor_id', $doctorId)->where('type', 'Appointment')->count();
        $pending = Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->where('type', 'Appointment')->count();
        $confirmed = Appointment::where('doctor_id', $doctorId)->where('status', 'Confirmed')->where('type', 'Appointment')->count();
        $cancelled = Appointment::where('doctor_id', $doctorId)->where('status', 'Cancelled')->where('type', 'Appointment')->count();

        // Query for all appointments with filters
        $query = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->where('type', 'Appointment');

        // Apply filters
        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Paginate the results
        $allAppointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        // Upcoming appointments (today + next 3 days) - not filtered
        $upcoming = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)->where('type', 'Appointment')
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->whereDate('appointment_date', '<=', Carbon::today()->addDays(3))
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        \Log::info("DoctorAppointments Debug: doctorId={$doctorId}, upcomingCount={$upcoming->count()}");

        return view('employee.doctor_appointments', compact(
            'total',
            'pending',
            'confirmed',
            'cancelled',
            'allAppointments',
            'upcoming'
        ));
    }

    public function doctorConsultations(Request $request)
    {
        $doctorId = auth('doctor')->id();

        // Summary counts for consultation type
        $total = Appointment::where('doctor_id', $doctorId)->where('type', 'consultation')->count();
        $pending = Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->where('type', 'consultation')->count();
        $confirmed = Appointment::where('doctor_id', $doctorId)->where('status', 'Confirmed')->where('type', 'consultation')->count();
        $cancelled = Appointment::where('doctor_id', $doctorId)->where('status', 'Cancelled')->where('type', 'consultation')->count();

        // Query for all consultations with filters
        $query = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->where('type', 'consultation');

        // Apply filters
        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Paginate the results
        $allConsultations = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        // Upcoming consultations (today + next 3 days) - not filtered
        $upcoming = Appointment::with(['doctor', 'user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->where('type', 'consultation')
            ->whereDate('appointment_date', '>=', Carbon::today())
            ->whereDate('appointment_date', '<=', Carbon::today()->addDays(3))
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('employee.doctor_consultations', compact(
            'total',
            'pending',
            'confirmed',
            'cancelled',
            'allConsultations',
            'upcoming'
        ));
    }




    public function doctorPatients(Request $request)
    {
        if (!auth('doctor')->check()) {
            abort(403, 'Unauthorized access');
        }

        $doctorId = auth('doctor')->id();

        $query = PatientVisit::with(['user', 'consultantAssignment.room', 'reception'])
            ->whereHas('consultantAssignment', function ($q) use ($doctorId) {
                $q->where('employee_id', $doctorId)
                    ->where('status', 'active');
            });

        // ✅ Server-side Filters
        if ($request->filled('patient_name')) {
            $patientName = $request->patient_name;
            $query->whereHas('user', function ($q) use ($patientName) {
                $q->where('full_name', 'like', "%$patientName%");
            });
        }

        if ($request->filled('visit_type')) {
            $query->where('visit_type', $request->visit_type);
        }

        if ($request->filled('date')) {
            $query->whereDate('date_of_visit', $request->date);
        }

        $patients = $query->orderBy('date_of_visit', 'desc')->get();

        return view('employee.doctor_patients', compact('patients'));
    }
}
