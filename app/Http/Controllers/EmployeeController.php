<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Qualification;
use App\Models\Document;
use App\Models\Payroll;
use App\Models\Address;
use App\Models\FamilyDetail;
use App\Models\Shift;
use App\Models\Profession;
use App\Models\Expertise;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['qualifications', 'documents', 'payroll', 'addresses', 'familyDetails', 'shifts', 'professions.department', 'expertise'])->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->only([
                'name', 'email', 'phone', 'date_of_birth', 'gender', 'hire_date'
            ]);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('images', 'public');
            }

            $employee = Employee::create($data);

            // Create related records if provided
            if ($request->has('qualifications')) {
                foreach ($request->qualifications as $qualification) {
                    $employee->qualifications()->create($qualification);
                }
            }

            if ($request->has('documents')) {
                foreach ($request->documents as $document) {
                    $documentData = [
                        'document_type' => $document['document_type'],
                        'document_path' => null,
                    ];
                    if (isset($document['document_file']) && $document['document_file']->isValid()) {
                        $path = $document['document_file']->store('documents', 'public');
                        $documentData['document_path'] = $path;
                    }
                    $employee->documents()->create($documentData);
                }
            }

            if ($request->has('payroll')) {
                $employee->payroll()->create($request->payroll);
            }

            if ($request->has('addresses')) {
                foreach ($request->addresses as $address) {
                    $employee->addresses()->create($address);
                }
            }

            if ($request->has('family_details')) {
                foreach ($request->family_details as $familyDetail) {
                    $employee->familyDetails()->create($familyDetail);
                }
            }

            if ($request->has('shifts')) {
                foreach ($request->shifts as $shift) {
                    $employee->shifts()->create($shift);
                }
            }

            if ($request->has('professions')) {
                foreach ($request->professions as $profession) {
                    if (!empty($profession['title'])) {
                        $employee->professions()->create($profession);
                    }
                }
            }

            if ($request->has('expertise')) {
                foreach ($request->expertise as $expertise) {
                    if (!empty($expertise['skill'])) {
                        $employee->expertise()->create($expertise);
                    }
                }
            }
        });

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['qualifications', 'documents', 'payroll', 'addresses', 'familyDetails', 'shifts', 'professions', 'expertise'])->findOrFail($id);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with(['qualifications', 'documents', 'payroll', 'addresses', 'familyDetails', 'shifts', 'professions', 'expertise'])->findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        DB::transaction(function () use ($request, $employee) {
            $data = $request->only([
                'name', 'email', 'phone', 'date_of_birth', 'gender', 'hire_date'
            ]);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('images', 'public');
            }

            $employee->update($data);

            // Update or create related records
            if ($request->has('qualifications')) {
                $existingIds = [];
                foreach ($request->qualifications as $qualification) {
                    if (isset($qualification['id']) && $qualification['id']) {
                        // Update existing qualification
                        $qual = $employee->qualifications()->find($qualification['id']);
                        if ($qual) {
                            $qual->degree = $qualification['degree'] ?? $qual->degree;
                            $qual->institution = $qualification['institution'] ?? $qual->institution;
                            $qual->year_completed = $qualification['year_completed'] ?? $qual->year_completed;
                            $qual->save();
                            $existingIds[] = $qual->id;
                        }
                    } else {
                        // Create new qualification if any field is filled
                        if (!empty($qualification['degree']) || !empty($qualification['institution']) || !empty($qualification['year_completed'])) {
                            $newQual = $employee->qualifications()->create($qualification);
                            $existingIds[] = $newQual->id;
                        }
                    }
                }
                // Delete qualifications not in the request
                $employee->qualifications()->whereNotIn('id', $existingIds)->delete();
            }

            if ($request->has('documents')) {
                $existingIds = [];
                foreach ($request->documents as $document) {
                    if (isset($document['id']) && $document['id']) {
                        // Update existing document
                        $doc = $employee->documents()->find($document['id']);
                        if ($doc) {
                            $doc->document_type = $document['document_type'];
                            if (isset($document['document_file']) && $document['document_file']->isValid()) {
                                $path = $document['document_file']->store('documents', 'public');
                                $doc->document_path = $path;
                            }
                            $doc->save();
                            $existingIds[] = $doc->id;
                        }
                    } else {
                        // Create new document only if document_type is provided
                        if (!empty($document['document_type'])) {
                            $documentData = [
                                'document_type' => $document['document_type'],
                                'document_path' => null,
                            ];
                            if (isset($document['document_file']) && $document['document_file']->isValid()) {
                                $path = $document['document_file']->store('documents', 'public');
                                $documentData['document_path'] = $path;
                            }
                            $newDoc = $employee->documents()->create($documentData);
                            $existingIds[] = $newDoc->id;
                        }
                    }
                }
                // Delete documents not in the request
                $employee->documents()->whereNotIn('id', $existingIds)->delete();
            }

            if ($request->has('payroll')) {
                $employee->payroll()->updateOrCreate([], $request->payroll);
            }

            if ($request->has('addresses')) {
                $existingIds = [];
                foreach ($request->addresses as $address) {
                    if (isset($address['id']) && $address['id']) {
                        // Update existing address
                        $addr = $employee->addresses()->find($address['id']);
                        if ($addr) {
                            $addr->address_type = $address['address_type'] ?? $addr->address_type;
                            $addr->street = $address['street'] ?? $addr->street;
                            $addr->city = $address['city'] ?? $addr->city;
                            $addr->state = $address['state'] ?? $addr->state;
                            $addr->country = $address['country'] ?? $addr->country;
                            $addr->postal_code = $address['postal_code'] ?? $addr->postal_code;
                            $addr->save();
                            $existingIds[] = $addr->id;
                        }
                    } else {
                        // Create new address if any key field is filled
                        if (!empty($address['address_type']) || !empty($address['street']) || !empty($address['city']) || !empty($address['state']) || !empty($address['country'])) {
                            $newAddr = $employee->addresses()->create($address);
                            $existingIds[] = $newAddr->id;
                        }
                    }
                }
                // Delete addresses not in the request
                $employee->addresses()->whereNotIn('id', $existingIds)->delete();
            }

            if ($request->has('family_details')) {
                $existingIds = [];
                foreach ($request->family_details as $familyDetail) {
                    if (isset($familyDetail['id']) && $familyDetail['id']) {
                        // Update existing family detail
                        $fam = $employee->familyDetails()->find($familyDetail['id']);
                        if ($fam) {
                            $fam->name = $familyDetail['name'] ?? $fam->name;
                            $fam->relationship = $familyDetail['relationship'] ?? $fam->relationship;
                            $fam->date_of_birth = $familyDetail['date_of_birth'] ?? $fam->date_of_birth;
                            $fam->contact_number = $familyDetail['contact_number'] ?? $fam->contact_number;
                            $fam->save();
                            $existingIds[] = $fam->id;
                        }
                    } else {
                        // Create new family detail if key fields are filled
                        if (!empty($familyDetail['name']) || !empty($familyDetail['relationship'])) {
                            $newFam = $employee->familyDetails()->create($familyDetail);
                            $existingIds[] = $newFam->id;
                        }
                    }
                }
                // Delete family details not in the request
                $employee->familyDetails()->whereNotIn('id', $existingIds)->delete();
            }

            if ($request->has('shifts')) {
                $existingIds = [];
                foreach ($request->shifts as $shift) {
                    if (isset($shift['id']) && $shift['id']) {
                        // Update existing shift
                        $sh = $employee->shifts()->find($shift['id']);
                        if ($sh) {
                            $sh->shift_name = $shift['shift_name'] ?? $sh->shift_name;
                            $sh->start_time = $shift['start_time'] ?? $sh->start_time;
                            $sh->end_time = $shift['end_time'] ?? $sh->end_time;
                            $sh->save();
                            $existingIds[] = $sh->id;
                        }
                    } else {
                        // Create new shift if key fields are filled
                        if (!empty($shift['shift_name']) || !empty($shift['start_time']) || !empty($shift['end_time'])) {
                            $newSh = $employee->shifts()->create($shift);
                            $existingIds[] = $newSh->id;
                        }
                    }
                }
                // Delete shifts not in the request
                $employee->shifts()->whereNotIn('id', $existingIds)->delete();
            }

            if ($request->has('professions')) {
                $existingIds = [];
                foreach ($request->professions as $profession) {
                    if (isset($profession['id']) && $profession['id']) {
                        // Update existing profession
                        $prof = $employee->professions()->find($profession['id']);
                        if ($prof) {
                            $prof->title = $profession['title'] ?? $prof->title;
                            $prof->department_id = $profession['department_id'] ?? $prof->department_id;
                            $prof->save();
                            $existingIds[] = $prof->id;
                        }
                    } else {
                        // Create new profession if title is filled
                        if (!empty($profession['title'])) {
                            $newProf = $employee->professions()->create($profession);
                            $existingIds[] = $newProf->id;
                        }
                    }
                }
                // Delete professions not in the request
                $employee->professions()->whereNotIn('id', $existingIds)->delete();
            }

            if ($request->has('expertise')) {
                $existingIds = [];
                foreach ($request->expertise as $expertise) {
                    if (isset($expertise['id']) && $expertise['id']) {
                        // Update existing expertise
                        $exp = $employee->expertise()->find($expertise['id']);
                        if ($exp) {
                            $exp->skill = $expertise['skill'] ?? $exp->skill;
                            $exp->proficiency_level = $expertise['proficiency_level'] ?? $exp->proficiency_level;
                            $exp->years_of_experience = $expertise['years_of_experience'] ?? $exp->years_of_experience;
                            $exp->save();
                            $existingIds[] = $exp->id;
                        }
                    } else {
                        // Create new expertise if skill is filled
                        if (!empty($expertise['skill'])) {
                            $newExp = $employee->expertise()->create($expertise);
                            $existingIds[] = $newExp->id;
                        }
                    }
                }
                // Delete expertise not in the request
                $employee->expertise()->whereNotIn('id', $existingIds)->delete();
            }
        });

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
