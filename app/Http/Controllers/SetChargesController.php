<?php

namespace App\Http\Controllers;

use App\Models\DoctorCharge;
use App\Models\Employee;
use Illuminate\Http\Request;

class SetChargesController extends Controller
{
    public function index()
    {
        $charges = DoctorCharge::with('doctor')->latest()->paginate(10);
        return view('admin.charges.index', compact('charges'));
    }





    public function create()
    {
        $doctors = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'doctor');
        })->get();

        return view('admin.charges.create', compact('doctors'));
    }



    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'doctor_id' => 'required|exists:employees,id',
            'type' => 'required|in:consultation,appointment,test',
            'sub_type' => 'required_if:type,consultation|nullable|in:video,voice,chat',
            'charge' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Check if charge already exists
            $existingCharge = DoctorCharge::where('employee_id', $request->doctor_id)
                ->where('type', $request->type)
                ->where('sub_type', $request->sub_type)
                ->exists();

            if ($existingCharge) {
                return redirect()
                    ->back()
                    ->with('error', 'A charge for this doctor already exists.')
                    ->withInput();
            }

            // ✅ Store data
            DoctorCharge::create([
                'employee_id' => $request->doctor_id,
                'type'        => $request->type,
                'sub_type'    => $request->type === 'consultation' ? $request->sub_type : null,
                'charge'      => $request->charge,
                'description' => $request->description,
            ]);

            // ✅ Redirect with success message
            return redirect()
                ->route('admin.charges.index')
                ->with('success', 'Doctor charge added successfully');
        } catch (\Exception $e) {
            // Handle errors
            return redirect()
                ->back()
                ->with('error', 'Failed to add doctor charge. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $charge = DoctorCharge::findOrFail($id);

        $doctors = Employee::whereHas('professions', function ($q) {
            $q->where('title', 'doctor');
        })->get();

        return view('admin.charges.edit', compact('charge', 'doctors'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:employees,id',
            'type' => 'required|in:consultation,appointment,test',
            'sub_type' => 'required_if:type,consultation|nullable|in:video,voice,chat',
            'charge' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $charge = DoctorCharge::findOrFail($id);

        $exists = DoctorCharge::where('employee_id', $request->doctor_id)
            ->where('type', $request->type)
            ->where('sub_type', $request->type === 'consultation' ? $request->sub_type : null)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()
                ->with('error', 'A charge for this doctor already exists.')
                ->withInput();
        }

        $charge->update([
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
                ->with('error', 'Failed to delete doctor charge. Please try again.');
        }
    }
}
