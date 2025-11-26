<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reception;
use App\Models\Profession;
use App\Models\User;
use App\Models\PatientVisit;

class ReceptionController extends Controller
{
    // Show list of receptions with filters and pagination
    public function index(Request $request)
    {
        $totalReceptions = Reception::count();
        $activeReceptions = Reception::where('status', 'active')->count();
        $inactiveReceptions = Reception::where('status', 'inactive')->count();

        // Auto-generate next Reception ID
        $lastReception = Reception::latest('id')->first();
        $newNumber = $lastReception ? ((int) str_replace('RECEP', '', $lastReception->reception_id) + 1) : 1;
        $nextReceptionId = 'RECEP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $query = Reception::query();
        $query = Reception::with('employee');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reception_id', 'like', '%' . $search . '%')
                    ->orWhereHas('employee', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $receptions = $query->orderBy('id', 'desc')->paginate(10);
        $receptionists = Profession::where('title', 'Receptionist')
            ->with('employee')
            ->get();
        return view('admin.receptions.index', compact(
            'receptions',
            'totalReceptions',
            'activeReceptions',
            'inactiveReceptions',
            'nextReceptionId',
            'receptionists'
        ));
    }

    // Store new reception
    public function store(Request $request)
    {
        $request->validate([
            'reception_id' => 'required|string|unique:receptions,reception_id',
            'status' => 'required|in:active,inactive'
        ]);

        Reception::create([
            'reception_id' => $request->reception_id,
            'status' => $request->status
        ]);

        return redirect()->route('admin.reception.index')->with('success', 'Reception added successfully.');
    }

    // Update reception
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:receptions,id',
            'reception_id' => 'nullable|string|max:255',
            'assigned_employee' => 'nullable|exists:employees,id',
            'status' => 'nullable|in:active,inactive',
        ]);

        $reception = Reception::findOrFail($request->id);

        // Only update if present in the request
        if ($request->has('reception_id')) {
            $reception->reception_id = $request->reception_id;
        }

        if ($request->has('assigned_employee')) {
            $reception->assigned_employee = $request->assigned_employee;
        }

        if ($request->has('status')) {
            $reception->status = $request->status;
        }

        $reception->save();

        return redirect()->route('admin.reception.index')
            ->with('success', 'Reception updated successfully.');
    }



    // Delete reception
    public function destroy($id)
    {
        $reception = Reception::findOrFail($id);
        $reception->delete();

        return redirect()->route('admin.reception.index')->with('success', 'Reception deleted successfully.');
    }


    public function assignReceptionEmployee(Request $request, $receptionId)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Find or create the reception
        $reception = \App\Models\Reception::updateOrCreate(
            ['id' => $receptionId],
            [
                'assigned_employee' => $request->employee_id,
                'status' => 'active',
            ]
        );

        return redirect()->back()->with('success', 'Employee assigned successfully.');
    }


    public function reception_visit()
    {
        $users = \App\Models\User::where('type', 'opd')->get();
        return view('admin.receptions.opd', compact('users'));
    }

    public function reception_visit_users(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $visits = PatientVisit::where('user_id', $userId)->orderBy('date_of_visit', 'desc')->get();


        return view('admin.receptions.visits', compact('user', 'visits',));
    }
}
