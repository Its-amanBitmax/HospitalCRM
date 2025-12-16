<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NurseLoginController extends Controller
{
    public function login(Request $request)
    {
        // ✅ Validation
        $validator = Validator::make($request->all(), [
            'employee_code' => 'required|string',
            'password'      => 'required|string|min:6',
        ], [
            'employee_code.required' => 'Employee code is required',
            'password.required'      => 'Password is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // ✅ Find employee
        $employee = Employee::where('employee_code', $request->employee_code)->first();

        if (!$employee) {
            return response()->json([
                'status' => false,
                'message' => 'Employee not found',
            ], 404);
        }

        // ✅ Check active status
        if ($employee->status !== 'Active') {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive',
            ], 403);
        }


        // ✅ Fetch profession
        $profession = DB::table('professions')
            ->where('employee_id', $employee->id)
            ->first();

        if (!$profession) {
            return response()->json([
                'status' => false,
                'message' => 'No profession assigned',
            ], 403);
        }

        // ✅ Only Doctors allowed
        if (strtolower(trim($profession->title)) !== 'nurse') {
            return response()->json([
                'status' => false,
                'message' => 'Only Nurse can login here',
            ], 403);
        }

        // ✅ Remove old tokens (optional but recommended)
        $employee->tokens()->delete();

        // ✅ Create token
        $token = $employee->createToken('Doctor API Token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'employee' => $employee,
            'token'   => $token,
        ], 200);
    }



    public function get_profile(Request $request)
    {
        $nurse = $request->user(); //get_profile sanctum se auth nurse

        if (!$nurse) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $nurse->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        return response()->json([
            'status' => true,
            'data' => $nurse
        ], 200);
    }







    public function update_profile(Request $request)
    {
        $nurse = $request->user(); // Sanctum auth nurse

        if (!$nurse) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        DB::transaction(function () use ($request, $nurse) {

            // 1️⃣ Main Nurse Profile
            $nurse->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'gender'     => $request->gender,
                'dob'        => $request->dob,
                'hire_date'  => $request->hire_date ?? $nurse->hire_date,
                'status'     => $request->status ?? $nurse->status,
            ]);

            // 2️⃣ Department
            if ($request->department_id) {
                $nurse->department()->associate($request->department_id);
                $nurse->save();
            }

            // 3️⃣ Addresses (sirf existing update)
            if ($request->addresses) {
                foreach ($request->addresses as $address) {
                    if (!empty($address['id'])) {
                        $existing = $nurse->addresses()->find($address['id']);
                        if ($existing) {
                            $existing->update([
                                'address_type' => $address['address_type'] ?? $existing->address_type,
                                'street'       => $address['street'] ?? $existing->street,
                                'city'         => $address['city'] ?? $existing->city,
                                'state'        => $address['state'] ?? $existing->state,
                                'country'      => $address['country'] ?? $existing->country,
                                'postal_code'  => $address['postal_code'] ?? $existing->postal_code,
                            ]);
                        }
                    }
                }
            }

            // 4️⃣ Professions (sirf existing update)
            if ($request->professions) {
                foreach ($request->professions as $profession) {
                    if (!empty($profession['id'])) {
                        $existing = $nurse->professions()->find($profession['id']);
                        if ($existing) {
                            $existing->update([
                                'title'         => $profession['title'] ?? $existing->title,
                                'department_id' => $profession['department_id'] ?? $existing->department_id,
                            ]);
                        }
                    }
                }
            }

            // 5️⃣ Qualifications (sirf existing update)
            if ($request->qualifications) {
                foreach ($request->qualifications as $qualification) {
                    if (!empty($qualification['id'])) {
                        $existing = $nurse->qualifications()->find($qualification['id']);
                        if ($existing) {
                            $existing->update([
                                'degree'         => $qualification['degree'] ?? $existing->degree,
                                'institution'    => $qualification['institution'] ?? $existing->institution,
                                'year_completed' => $qualification['year_completed'] ?? $existing->year_completed,
                            ]);
                        }
                    }
                }
            }

            // 6️⃣ Family Details (sirf existing update)
            if ($request->family_details) {
                foreach ($request->family_details as $family) {
                    if (!empty($family['id'])) {
                        $existing = $nurse->familyDetails()->find($family['id']);
                        if ($existing) {
                            $existing->update([
                                'name'           => $family['name'] ?? $existing->name,
                                'relationship'   => $family['relationship'] ?? $existing->relationship,
                                'date_of_birth'  => $family['date_of_birth'] ?? $existing->date_of_birth,
                                'contact_number' => $family['contact_number'] ?? $existing->contact_number,
                            ]);
                        }
                    }
                }
            }

            // 7️⃣ Image Upload (optional)
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/employees');
                $nurse->image = str_replace('public/', '', $path);
                $nurse->save();
            }

            // 8️⃣ Documents Upload (optional, create new only)
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $doc) {
                    $path = $doc->store('public/employee_documents');
                    $nurse->documents()->create([
                        'document_type' => $doc->getClientOriginalName(),
                        'document_path' => str_replace('public/', '', $path),
                        'uploaded_at'   => now(),
                    ]);
                }
            }
        });

        // 🔹 Load fresh data with full URLs
        $nurse->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        if ($nurse->image) {
            $nurse->image = url('public/storage/' . $nurse->image);
        }

        foreach ($nurse->documents as $doc) {
            if ($doc->document_path) {
                $doc->document_path = url('public/storage/' . $doc->document_path);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $nurse
        ], 200);
    }


    public function myPatients(Request $request)
    {
        $nurse = $request->user(); // Sanctum nurse

        if (!$nurse) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Nurse image from storage
        $nurseData = $nurse->toArray();
        $nurseData['image'] = $nurse->image ? asset('storage/' . $nurse->image) : null;

        // Assigned patients with images from public folder
        $patients = $nurse->patients->map(function ($patient) {
            $patientData = $patient->toArray();

            // Agar patient image public folder me hai
            $patientData['image'] = $patient->image ? asset($patient->image) : null;

            return $patientData;
        });

        return response()->json([
            'status' => true,
            'message' => 'Nurse and assigned patients fetched successfully',
            'data' => [
                'nurse' => $nurseData,
                'patients' => $patients
            ]
        ], 200);
    }
}
