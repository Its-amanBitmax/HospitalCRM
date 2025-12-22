<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\PatientVisit;
use App\Models\Reception;
use App\Models\RoomAssignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ReceptionloginController extends Controller
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

        // ✅ Only Reception allowed
        if (strtolower(trim($profession->title)) !== 'receptionist') {
            return response()->json([
                'status' => false,
                'message' => 'Only Reception can login here',
            ], 403);
        }

        // ✅ Remove old tokens
        $employee->tokens()->delete();

        // ✅ Create token
        $token = $employee->createToken('Reception API Token')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'  => 'Login successful',
            'employee' => $employee,
            'token'    => $token,
        ], 200);
    }

    public function get_profile(Request $request)
    {
        $reception = $request->user(); // Sanctum auth receptionist

        if (!$reception) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Load all relations
        $reception->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        // Full URL for receptionist image
        if ($reception->image) {
            $reception->image = url('storage/' . $reception->image);
        } else {
            $reception->image = null;
        }

        // Department image URL
        if ($reception->department && $reception->department->image_url) {
            $reception->department->image_url = url('storage/' . $reception->department->image_url);
        }

        return response()->json([
            'status' => true,
            'data' => $reception
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $reception = $request->user(); // Sanctum auth receptionist

        if (!$reception) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        DB::transaction(function () use ($request, $reception) {

            // 1️⃣ Main Reception Profile
            $reception->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'gender'     => $request->gender,
                'dob'        => $request->dob,
                'hire_date'  => $request->hire_date ?? $reception->hire_date,
                'status'     => $request->status ?? $reception->status,
            ]);

            // 2️⃣ Department
            if ($request->department_id) {
                $reception->department()->associate($request->department_id);
                $reception->save();
            }

            // 3️⃣ Addresses (update existing only)
            if ($request->addresses) {
                foreach ($request->addresses as $address) {
                    if (!empty($address['id'])) {
                        $existing = $reception->addresses()->find($address['id']);
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
                        $existing = $reception->professions()->find($profession['id']);
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
                        $existing = $reception->qualifications()->find($qualification['id']);
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
                        $existing = $reception->familyDetails()->find($family['id']);
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
                $reception->image = str_replace('public/', '', $path);
                $reception->save();
            }

            // 8️⃣ Documents Upload (create new only)
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $doc) {
                    $path = $doc->store('public/employee_documents');
                    $reception->documents()->create([
                        'document_type' => $doc->getClientOriginalName(),
                        'document_path' => str_replace('public/', '', $path),
                        'uploaded_at'   => now(),
                    ]);
                }
            }
        });

        // 🔹 Load fresh data
        $reception->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        // Image full URL
        if ($reception->image) {
            $reception->image = url('public/storage/' . $reception->image);
        }

        // Documents full URL
        foreach ($reception->documents as $doc) {
            if ($doc->document_path) {
                $doc->document_path = url('public/storage/' . $doc->document_path);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Profile updated successfully',
            'data'    => $reception
        ], 200);
    }

    public function get_receptions()
    {
        // All receptions with employee
        $receptions = Reception::with('employee')->get();

        // Logged-in receptionist (Sanctum / auth)
        $receptionist = auth()->user();

        // Assigned reception for logged-in receptionist
        $assignedReception = null;
        if ($receptionist) {
            $assignedReception = Reception::with('employee')
                ->where('assigned_employee', $receptionist->id)
                ->first();
        }

        // Summary Data
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $todayVisits = PatientVisit::whereDate('date_of_visit', today())->count();
        $receptionCount = Reception::count();
        $recentVisitCount = PatientVisit::count();
        // Recent Appointments
        // $recentAppointments = Appointment::with(['doctor', 'relative'])
        //     ->orderBy('appointment_date', 'desc')
        //     ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'receptions'          => $receptions,
                'assigned_reception' => $assignedReception,

                'summary' => [
                    'total_appointments' => $totalAppointments,
                    'today_appointments' => $todayAppointments,
                    'today_visits'       => $todayVisits,
                    'reception_count'    => $receptionCount,
                    'recent_patients'     => $recentVisitCount,
                ],

                // 'recent_appointments' => $recentAppointments,

            ]
        ], 200);
    }

    public function get_appointments()
    {
        $appointments = Appointment::with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $appointments
        ], 200);
    }

    public function get_patients(Request $request)
    {
        // Start query for patients
        $query = User::query();

        // 🔍 Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile_no', 'like', '%' . $search . '%');
            });
        }

        // 🏷 Type filter
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Fetch patients
        $patients = $query->orderBy('created_at', 'desc')->get();

        // Convert image path to full URL (public folder)
        $patients->transform(function ($patient) {
            if ($patient->image) {
                // public path
                $patient->image = url($patient->image);
            } else {
                $patient->image = null;
            }
            return $patient;
        });

        // Count by type (for filter options)
        $typeCounts = User::select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        return response()->json([
            'status' => true,
            'data' => [
                'patients' => $patients,
                'type_counts' => $typeCounts
            ]
        ], 200);
    }

    public function showUserVisits(User $user)
    {
        $userVisits = PatientVisit::with([
            'reception',
            'consultantAssignment.room',
            'consultantAssignment.employee'
        ])
            ->where('user_id', $user->id)
            ->orderBy('date_of_visit', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'mobile_no' => $user->mobile_no,
                    'image' => $user->image
                        ? url('public/' . $user->image)
                        : null
                ],
                'visits' => $userVisits
            ]
        ], 200);
    }

    public function createUserVisit()
    {
        // Fetch all receptions
        $receptions = Reception::all();

        // Fetch all room assignments with room & employee
        $assignedRooms = RoomAssignment::with(['room', 'employee'])->get();

        return response()->json([
            'status' => true,
            'data' => [
                'receptions' => $receptions,
                'assigned_rooms' => $assignedRooms
            ]
        ], 200);
    }

    public function storeUserVisit(Request $request, $user_id)
    {
        $data = $request->validate([
            'visit_type' => 'required|string|max:255',
            'date_of_visit' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|exists:receptions,id',
            'department_consultant' => 'nullable|exists:room_assignments,id',
        ]);

        $data['user_id'] = $user_id;

        // Create visit
        $visit = PatientVisit::create($data);

        // 🔥 Load related data AFTER create
        $visit->load([
            'reception', // referred_by relation
            'consultantAssignment.room',
            'consultantAssignment.employee'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Visit added successfully',
            'data' => $visit
        ], 201);
    }


    public function updateUserVisit(Request $request, $user_id, $visit_id)
    {
        $data = $request->validate([
            'visit_type' => 'required|string|max:255',
            'date_of_visit' => 'required|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|exists:receptions,id',
            'department_consultant' => 'nullable|exists:room_assignments,id',
        ]);

        // Visit find with user validation
        $visit = PatientVisit::where('id', $visit_id)
            ->where('user_id', $user_id)
            ->firstOrFail();

        // Update visit
        $visit->update($data);

        // 🔥 Load related data AFTER update
        $visit->load([
            'reception', // referred_by relation
            'consultantAssignment.room',
            'consultantAssignment.employee'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Visit updated successfully',
            'data' => $visit
        ], 200);
    }



    public function patient_save(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'mobile_no' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:20',
            'full_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
            'visit_type' => 'nullable|in:OPD,Emergency,Appointment',
            'date_of_visit' => 'nullable|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'department_consultant' => 'nullable|string|max:255',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
            'registered_through' => 'nullable|in:email,msg,whatsapp,offline',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique user_id with date and username
        $date = now()->format('Ymd');
        $usernamePart = $request->username ? strtoupper(substr($request->username, 0, 3)) : 'USR';
        $userId = 'USR' . $date . $usernamePart . rand(100, 999);

        // Handle image upload (to public folder)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        $user = \App\Models\User::create([
            'user_id' => $userId,
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => $request->password ? Hash::make($request->password) : null,
            'age' => $request->age,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'father_spouse_name' => $request->father_spouse_name,
            'alternate_no' => $request->alternate_no,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
            'id_proof_type' => $request->id_proof_type,
            'id_number' => $request->id_number,
            'type' => $request->type,
            'status' => $request->status,
            'registered_through' => $request->registered_through,
            'image' => $imagePath,
        ]);

        // Return JSON response with full image URL
        if ($user->image) {
            $user->image = url($user->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Patient created successfully.',
            'data' => $user
        ], 201);
    }

    public function patient_update(Request $request, $id)
    {
        $patient = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $patient->id,
            'email' => 'nullable|email|unique:users,email,' . $patient->id,
            'mobile_no' => 'required|string|max:20',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'father_spouse_name' => 'nullable|string|max:255',
            'alternate_no' => 'nullable|string|max:20',
            'full_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
            'visit_type' => 'nullable|in:OPD,Emergency,Appointment',
            'date_of_visit' => 'nullable|date',
            'chief_complaint' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'department_consultant' => 'nullable|string|max:255',
            'id_proof_type' => 'nullable|string|max:255',
            'id_number' => 'nullable|string|max:255',
            'type' => 'required|in:ipd,opd,emergency,registered,discharged',
            'status' => 'required|in:active,inactive,discharged',
            'registered_through' => 'nullable|in:email,msg,whatsapp,offline',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /* ---------- Image Handling ---------- */
        $imagePath = $patient->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);
            $imagePath = 'image/' . $imageName;
        }

        /* ---------- Update Data ---------- */
        $patient->update([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => $request->password ? Hash::make($request->password) : $patient->password,
            'age' => $request->age,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'father_spouse_name' => $request->father_spouse_name,
            'alternate_no' => $request->alternate_no,
            'full_address' => $request->full_address,
            'city' => $request->city,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
            'visit_type' => $request->visit_type,
            'date_of_visit' => $request->date_of_visit,
            'chief_complaint' => $request->chief_complaint,
            'referred_by' => $request->referred_by,
            'department_consultant' => $request->department_consultant,
            'id_proof_type' => $request->id_proof_type,
            'id_number' => $request->id_number,
            'type' => $request->type,
            'status' => $request->status,
            'registered_through' => $request->registered_through,
            'image' => $imagePath,
        ]);

        /* ---------- Full Image URL ---------- */
        if ($patient->image) {
            $patient->image = url($patient->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Patient updated successfully.',
            'data' => $patient
        ], 200);
    }





    public function myAttendances(Request $request)
    {
        $user = auth()->user(); // logged-in employee

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $attendances = Attendance::with('employee')
            ->where('employee_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'count' => $attendances->count(),
            'data' => $attendances
        ], 200);
    }
}
