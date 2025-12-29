<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use App\Models\Expenses;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountantLoginController extends Controller
{
    public function Accountantlogin(Request $request)
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
        if (strtolower(trim($profession->title)) !== 'accountant') {
            return response()->json([
                'status' => false,
                'message' => 'Only Accountant can login here',
            ], 403);
        }

        // ✅ Remove old tokens (optional but recommended)
        $employee->tokens()->delete();

        // ✅ Create token
        $token = $employee->createToken('Accountant API Token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'employee' => $employee,
            'token'   => $token,
        ], 200);
    }

    public function get_profile(Request $request)
    {
        $accountant = $request->user(); // Sanctum auth accountant

        if (!$accountant) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Load all relations
        $accountant->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        // Full URL for accountant image
        if ($accountant->image) {
            $accountant->image = url('storage/' . $accountant->image);
        } else {
            $accountant->image = null;
        }

        // If department has image_url
        if ($accountant->department && $accountant->department->image_url) {
            $accountant->department->image_url = url('storage/' . $accountant->department->image_url);
        }

        return response()->json([
            'status' => true,
            'data' => $accountant
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $accountant = $request->user(); // Sanctum auth accountant

        if (!$accountant) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        DB::transaction(function () use ($request, $accountant) {

            // 1️⃣ Main accountant Profile
            $accountant->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'gender'     => $request->gender,
                'dob'        => $request->dob,
                'hire_date'  => $request->hire_date ?? $accountant->hire_date,
                'status'     => $request->status ?? $accountant->status,
            ]);

            // 2️⃣ Department
            if ($request->department_id) {
                $accountant->department()->associate($request->department_id);
                $accountant->save();
            }

            // 3️⃣ Addresses (sirf existing update)
            if ($request->addresses) {
                foreach ($request->addresses as $address) {
                    if (!empty($address['id'])) {
                        $existing = $accountant->addresses()->find($address['id']);
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
                        $existing = $accountant->professions()->find($profession['id']);
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
                        $existing = $accountant->qualifications()->find($qualification['id']);
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
                        $existing = $accountant->familyDetails()->find($family['id']);
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
                $accountant->image = str_replace('public/', '', $path);
                $accountant->save();
            }

            // 8️⃣ Documents Upload (optional, create new only)
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $doc) {
                    $path = $doc->store('public/employee_documents');
                    $accountant->documents()->create([
                        'document_type' => $doc->getClientOriginalName(),
                        'document_path' => str_replace('public/', '', $path),
                        'uploaded_at'   => now(),
                    ]);
                }
            }
        });

        // 🔹 Load fresh data with full URLs
        $accountant->load([
            'department',
            'payroll',
            'addresses',
            'professions',
            'qualifications',
            'documents',
            'familyDetails'
        ]);

        if ($accountant->image) {
            $accountant->image = url('public/storage/' . $accountant->image);
        }

        foreach ($accountant->documents as $doc) {
            if ($doc->document_path) {
                $doc->document_path = url('public/storage/' . $doc->document_path);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $accountant
        ], 200);
    }

    public function get_transactions(Request $request)
    {
        $query = Transaction::query();

        // Apply filters
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        // Apply sorting
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('transaction_date', 'asc');
                break;
            case 'amount_high':
                $query->orderBy('amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('amount', 'asc');
                break;
            default:
                $query->orderBy('transaction_date', 'desc');
                break;
        }

        $transactions = $query->get();

        // Return directly without complex formatting
        return response()->json([
            'status' => true,
            'message' => 'Transactions fetched successfully',
            'data' => $transactions
        ]);
    }

    public function create_transactions(Request $request)
    {
        try {
            // Logged-in user (Sanctum)
            $user = $request->user(); // auth:sanctum

            // Validation
            $validated = $request->validate([
                'module' => 'required|in:patients,doctors,nurses,blood_bank,employee,services,lab,reception,accountant,pharmacy',
                'amount' => 'required|numeric|min:0',
                'transaction_type' => 'required|in:credit,debit',
                'payment_mode' => 'required|in:cash,upi,card,online,cheque',
                'status' => 'required|in:paid,pending,cancelled,refunded',
                'transaction_date' => 'required|date',
                'remarks' => 'nullable|string|max:255',
            ]);

            // Unique Transaction ID
            $transactionId = 'TXN-' . strtoupper(uniqid());

            // Create Transaction
            $transaction = Transaction::create([
                'transaction_id'   => $transactionId,
                'module'           => $validated['module'],
                'amount'           => $validated['amount'],
                'transaction_type' => $validated['transaction_type'],
                'payment_mode'     => $validated['payment_mode'],
                'status'           => $validated['status'],
                'transaction_date' => $validated['transaction_date'],
                'remarks'          => $validated['remarks'] ?? null,
                'created_by'       => $user->id, // Sanctum user
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {

            Log::error('Transaction Store Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

  public function get_expenses()
    {
        $expenses = Expenses::with('department')
            ->latest()
            ->get(); // ❌ paginate hata diya

        return response()->json([
            'status' => true,
            'message' => 'Expenses fetched successfully',
            'data' => $expenses
        ], 200);
    }




}
