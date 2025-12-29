<?php

namespace App\Http\Controllers;

use App\Models\DoctorCharge;
use App\Models\Employee;
use Illuminate\Http\Request;

class SetChargesController extends Controller
{
    /**
     * List all charges
     */
    public function index()
    {
        $charges = DoctorCharge::with('doctor')
            ->latest()
            ->paginate(10);

        return view('admin.charges.index', compact('charges'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $doctors = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'doctor');
        })->get();

        return view('admin.charges.create', compact('doctors'));
    }

    /**
     * Store new charge
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'nullable|string|max:255',
            'doctor_id'   => 'nullable|exists:employees,id',
            'type'        => 'nullable|in:consultation,appointment,test',
            'sub_type'    => 'nullable:type,consultation|nullable|in:video,voice,chat',
            'charge'      => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Duplicate check
            $exists = DoctorCharge::where('employee_id', $request->doctor_id)
                ->where('name', $request->name)
                ->where('type', $request->type)
                ->where('sub_type', $request->type === 'consultation' ? $request->sub_type : null)
                ->exists();

            if ($exists) {
                return back()
                    ->with('error', 'This charge is doctor already exists.')
                    ->withInput();
            }

            DoctorCharge::create([
                'name'        => $request->name,
                'employee_id' => $request->doctor_id,
                'type'        => $request->type,
                'sub_type'    => $request->type === 'consultation' ? $request->sub_type : null,
                'charge'      => $request->charge,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.charges.index')
                ->with('success', 'Doctor charge added successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to add doctor charge.')
                ->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $charge = DoctorCharge::findOrFail($id);

        $doctors = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'doctor');
        })->get();

        return view('admin.charges.edit', compact('charge', 'doctors'));
    }

    /**
     * Update charge
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'nullable|string|max:255',
            'doctor_id'   => 'nullable|exists:employees,id',
            'type'        => 'nullable|in:consultation,appointment,test',
            'sub_type'    => 'nullable:type,consultation|nullable|in:video,voice,chat',
            'charge'      => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $charge = DoctorCharge::findOrFail($id);

        // Duplicate check (ignore current record)
        $exists = DoctorCharge::where('employee_id', $request->doctor_id)
            ->where('name', $request->name)
            ->where('type', $request->type)
            ->where('sub_type', $request->type === 'consultation' ? $request->sub_type : null)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()
                ->with('error', 'This charge is doctor already exists.')
                ->withInput();
        }

        $charge->update([
            'name'        => $request->name,
            'employee_id' => $request->doctor_id,
            'type'        => $request->type,
            'sub_type'    => $request->type === 'consultation' ? $request->sub_type : null,
            'charge'      => $request->charge,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.charges.index')
            ->with('success', 'Doctor charge updated successfully');
    }

    /**
     * Delete charge
     */
    public function destroy($id)
    {
        try {
            $charge = DoctorCharge::findOrFail($id);
            $charge->delete();

            return redirect()
                ->route('admin.charges.index')
                ->with('success', 'Doctor charge deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.charges.index')
                ->with('error', 'Failed to delete doctor charge.');
        }
    }
}
