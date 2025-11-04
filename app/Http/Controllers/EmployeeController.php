<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Speciality;
use App\Models\Qualification;
use App\Models\Document;
use App\Models\Payroll;
use App\Models\Address;
use App\Models\FamilyDetail;
use App\Models\Shift;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['department', 'specialities', 'professions'])->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Display a listing of doctors.
     */
    public function doctors()
    {
        $employees = Employee::with(['department', 'specialities', 'professions'])
            ->whereHas('professions', function($query) {
                $query->where('title', 'Doctor');
            })
            ->paginate(10);
        return view('admin.employees.doctors', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $specialities = Speciality::all();
        return view('admin.employees.create', compact('departments', 'specialities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('employees', 'public');
        }

        $employee = Employee::create($data);

        // Handle Qualifications
        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualificationData) {
                $employee->qualifications()->create($qualificationData);
            }
        }

        // Handle Documents
        if ($request->has('documents')) {
            foreach ($request->documents as $documentData) {
                if (isset($documentData['id'])) {
                    // Update existing document
                    $document = Document::find($documentData['id']);
                    if ($document) {
                        $updateData = ['document_type' => $documentData['document_type'] ?? null];
                        if (isset($documentData['document_file'])) {
                            Storage::disk('public')->delete($document->document_path);
                            $path = $documentData['document_file']->store('employee_documents', 'public');
                            $updateData['document_path'] = $path;
                            $updateData['uploaded_at'] = now();
                        }
                        $document->update($updateData);
                    }
                } else {
                    // Create new document
                    if (isset($documentData['document_file'])) {
                        $path = $documentData['document_file']->store('employee_documents', 'public');
                        $employee->documents()->create([
                            'document_type' => $documentData['document_type'] ?? null,
                            'document_path' => $path,
                            'uploaded_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Handle Payroll
        if ($request->has('payroll')) {
            $employee->payroll()->create($request->payroll);
        }

        // Handle Addresses
        if ($request->has('addresses')) {
            foreach ($request->addresses as $addressData) {
                $employee->addresses()->create($addressData);
            }
        }

        // Handle Family Details
        if ($request->has('family_details')) {
            foreach ($request->family_details as $familyData) {
                $employee->familyDetails()->create($familyData);
            }
        }

        // Handle Shifts
        if ($request->has('shifts')) {
            foreach ($request->shifts as $shiftData) {
                $employee->shifts()->create($shiftData);
            }
        }

        // Handle Professions
        if ($request->has('professions')) {
            foreach ($request->professions as $professionData) {
                $employee->professions()->create($professionData);
            }
        }

        // Handle Specialities
        if ($request->has('specialities')) {
            $specialityData = [];
            foreach ($request->specialities as $speciality) {
                $specialityData[$speciality['speciality_id']] = [
                    'proficiency_level' => $speciality['proficiency_level'] ?? null,
                    'years_of_experience' => $speciality['years_of_experience'] ?? null,
                ];
            }
            $employee->specialities()->attach($specialityData);
        }

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['department', 'specialities', 'qualifications', 'documents', 'payroll', 'addresses', 'familyDetails', 'shifts', 'professions']);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $specialities = Speciality::all();
        $employee->load(['specialities', 'qualifications', 'documents', 'payroll', 'addresses', 'familyDetails', 'shifts', 'professions']);
        return view('admin.employees.edit', compact('employee', 'departments', 'specialities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($employee->image) {
                    Storage::disk('public')->delete($employee->image);
                }
                $data['image'] = $request->file('image')->store('employees', 'public');
            }

            $employee->update($data);

            // Handle Qualifications
        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualificationData) {
                if (isset($qualificationData['id'])) {
                    $qualification = Qualification::find($qualificationData['id']);
                    if ($qualification) {
                        $qualification->update($qualificationData);
                    }
                } else {
                    $employee->qualifications()->create($qualificationData);
                }
            }
        }

        // Handle Documents
        if ($request->has('documents')) {
            foreach ($request->documents as $documentData) {
                if (isset($documentData['id'])) {
                    // Update existing document
                    $document = Document::find($documentData['id']);
                    if ($document) {
                        $updateData = ['document_type' => $documentData['document_type'] ?? null];
                        if (isset($documentData['document_file'])) {
                            Storage::disk('public')->delete($document->document_path);
                            $path = $documentData['document_file']->store('employee_documents', 'public');
                            $updateData['document_path'] = $path;
                            $updateData['uploaded_at'] = now();
                        }
                        $document->update($updateData);
                    }
                } else {
                    // Create new document
                    if (isset($documentData['document_file'])) {
                        $path = $documentData['document_file']->store('employee_documents', 'public');
                        $employee->documents()->create([
                            'document_type' => $documentData['document_type'] ?? null,
                            'document_path' => $path,
                            'uploaded_at' => now(),
                        ]);
                    }
                }
            }
        }

        // Handle Payroll
        if ($request->has('payroll')) {
            if ($employee->payroll) {
                $employee->payroll->update($request->payroll);
            } else {
                $employee->payroll()->create($request->payroll);
            }
        }

        // Handle Addresses
        if ($request->has('addresses')) {
            foreach ($request->addresses as $addressData) {
                if (isset($addressData['id'])) {
                    $address = Address::find($addressData['id']);
                    if ($address) {
                        $address->update($addressData);
                    }
                } else {
                    $employee->addresses()->create($addressData);
                }
            }
        }

        // Handle Family Details
        if ($request->has('family_details')) {
            foreach ($request->family_details as $familyData) {
                if (isset($familyData['id'])) {
                    $familyDetail = FamilyDetail::find($familyData['id']);
                    if ($familyDetail) {
                        $familyDetail->update($familyData);
                    }
                } else {
                    $employee->familyDetails()->create($familyData);
                }
            }
        }

        // Handle Shifts
        if ($request->has('shifts')) {
            foreach ($request->shifts as $shiftData) {
                if (isset($shiftData['id'])) {
                    $shift = Shift::find($shiftData['id']);
                    if ($shift) {
                        $shift->update($shiftData);
                    }
                } else {
                    $employee->shifts()->create($shiftData);
                }
            }
        }

        // Handle Professions
        if ($request->has('professions')) {
            foreach ($request->professions as $professionData) {
                if (isset($professionData['id'])) {
                    $profession = Profession::find($professionData['id']);
                    if ($profession) {
                        $profession->update($professionData);
                    }
                } else {
                    $employee->professions()->create($professionData);
                }
            }
        }

        // Handle Specialities
        if ($request->has('specialities')) {
            $specialityData = [];
            foreach ($request->specialities as $speciality) {
                $specialityData[$speciality['speciality_id']] = [
                    'proficiency_level' => $speciality['proficiency_level'] ?? null,
                    'years_of_experience' => $speciality['years_of_experience'] ?? null,
                ];
            }
            $employee->specialities()->sync($specialityData);
        } else {
            $employee->specialities()->detach();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully.'
            ]);
        }

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
        } catch (ValidationException $e) {
            Log::error('Validation error during employee update: ' . $e->getMessage(), [
                'employee_id' => $employee->id,
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            Log::error('Error during employee update: ' . $e->getMessage(), [
                'employee_id' => $employee->id,
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the employee: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while updating the employee: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->image) {
            Storage::disk('public')->delete($employee->image);
        }

        // Delete related documents
        foreach ($employee->documents as $document) {
            Storage::disk('public')->delete($document->document_path);
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
