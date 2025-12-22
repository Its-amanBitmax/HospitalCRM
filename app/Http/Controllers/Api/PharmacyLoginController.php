<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PharmacyLoginController extends Controller
{
    public function pharmacistLogin(Request $request)
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

        // ✅ Check password
        if (!Hash::check($request->password, $employee->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid password',
            ], 401);
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

        // ✅ Only Pharmacist allowed
        if (strtolower(trim($profession->title)) !== 'pharmacist') {
            return response()->json([
                'status' => false,
                'message' => 'Only Pharmacist can login here',
            ], 403);
        }

        // ✅ Remove old tokens
        $employee->tokens()->delete();

        // ✅ Create token
        $token = $employee->createToken('Pharmacist API Token')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'  => 'Login successful',
            'employee' => $employee,
            'token'    => $token,
        ], 200);
    }

     public function get_profile(Request $request)
    {
        $pharmacy = $request->user(); // Sanctum auth pharmacyist

        if (!$pharmacy) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Load all relations
        $pharmacy->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        // Full URL for pharmacyist image
        if ($pharmacy->image) {
            $pharmacy->image = url('storage/' . $pharmacy->image);
        } else {
            $pharmacy->image = null;
        }

        // Department image URL
        if ($pharmacy->department && $pharmacy->department->image_url) {
            $pharmacy->department->image_url = url('storage/' . $pharmacy->department->image_url);
        }

        return response()->json([
            'status' => true,
            'data' => $pharmacy
        ], 200);
    }


     public function update_profile(Request $request)
    {
        $pharmacy = $request->user(); // Sanctum auth pharmacyist

        if (!$pharmacy) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        DB::transaction(function () use ($request, $pharmacy) {

            // 1️⃣ Main pharmacy Profile
            $pharmacy->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'gender'     => $request->gender,
                'dob'        => $request->dob,
                'hire_date'  => $request->hire_date ?? $pharmacy->hire_date,
                'status'     => $request->status ?? $pharmacy->status,
            ]);

            // 2️⃣ Department
            if ($request->department_id) {
                $pharmacy->department()->associate($request->department_id);
                $pharmacy->save();
            }

            // 3️⃣ Addresses (update existing only)
            if ($request->addresses) {
                foreach ($request->addresses as $address) {
                    if (!empty($address['id'])) {
                        $existing = $pharmacy->addresses()->find($address['id']);
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

            // 4️⃣ Professions (update existing only)
            if ($request->professions) {
                foreach ($request->professions as $profession) {
                    if (!empty($profession['id'])) {
                        $existing = $pharmacy->professions()->find($profession['id']);
                        if ($existing) {
                            $existing->update([
                                'title'         => $profession['title'] ?? $existing->title,
                                'department_id' => $profession['department_id'] ?? $existing->department_id,
                            ]);
                        }
                    }
                }
            }

            // 5️⃣ Qualifications (update existing only)
            if ($request->qualifications) {
                foreach ($request->qualifications as $qualification) {
                    if (!empty($qualification['id'])) {
                        $existing = $pharmacy->qualifications()->find($qualification['id']);
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

            // 6️⃣ Family Details (update existing only)
            if ($request->family_details) {
                foreach ($request->family_details as $family) {
                    if (!empty($family['id'])) {
                        $existing = $pharmacy->familyDetails()->find($family['id']);
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
                $pharmacy->image = str_replace('public/', '', $path);
                $pharmacy->save();
            }

            // 8️⃣ Documents Upload (create new only)
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $doc) {
                    $path = $doc->store('public/employee_documents');
                    $pharmacy->documents()->create([
                        'document_type' => $doc->getClientOriginalName(),
                        'document_path' => str_replace('public/', '', $path),
                        'uploaded_at'   => now(),
                    ]);
                }
            }
        });

        // 🔹 Load fresh data
        $pharmacy->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        // Image full URL
        if ($pharmacy->image) {
            $pharmacy->image = url('public/storage/' . $pharmacy->image);
        }

        // Documents full URL
        foreach ($pharmacy->documents as $doc) {
            if ($doc->document_path) {
                $doc->document_path = url('public/storage/' . $doc->document_path);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
            'data'    => $pharmacy
        ], 200);
    }
}
