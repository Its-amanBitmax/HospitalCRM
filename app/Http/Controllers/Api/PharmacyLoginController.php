<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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


    public function create_store(Request $request)
    {
        // ✅ Validation (DB structure ke hisaab se)
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'license_no' => 'nullable|string|max:255',
            'gst_no'     => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string',
            'status'     => 'nullable|boolean', // 👈 tinyint(1)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $store = Store::create([
                'store_name' => $request->store_name,
                'owner_name' => $request->owner_name,
                'license_no' => $request->license_no,
                'gst_no'     => $request->gst_no,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'address'    => $request->address,
                'status'     => $request->status ?? 1, // 👈 default Active
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Store created successfully',
                'data'    => $store,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to create store',
            ], 500);
        }
    }

    public function update_store(Request $request, $id)
    {
        // ✅ Find store
        $store = Store::find($id);

        if (!$store) {
            return response()->json([
                'status'  => false,
                'message' => 'Store not found',
            ], 404);
        }

        // ✅ Validation
        $validator = Validator::make($request->all(), [
            'store_name' => 'sometimes|required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'license_no' => 'nullable|string|max:255',
            'gst_no'     => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string',
            'status'     => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            // ✅ Update fields
            $store->update([
                'store_name' => $request->store_name ?? $store->store_name,
                'owner_name' => $request->owner_name,
                'license_no' => $request->license_no,
                'gst_no'     => $request->gst_no,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'address'    => $request->address,
                'status'     => $request->status ?? $store->status,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Store updated successfully',
                'data'    => $store,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to update store',
            ], 500);
        }
    }

    public function getAllStore()
    {
        $stores = Store::all();

        return response()->json([
            'status' => true,
            'message' => 'Stores fetched successfully',
            'data' => $stores
        ], 200);
    }

    public function create_medicine(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id'       => 'required|exists:stores,id',
            'medicine_name'  => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'category'       => 'nullable|string|max:255',
            'batch_no'       => 'nullable|string|max:100',
            'expiry_date'    => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
            'status'         => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $medicine = new Medicine();
            $medicine->store_id       = $request->store_id;
            $medicine->medicine_name  = $request->medicine_name;
            $medicine->brand          = $request->brand;
            $medicine->category       = $request->category;
            $medicine->batch_no       = $request->batch_no;
            $medicine->expiry_date    = $request->expiry_date;
            $medicine->purchase_price = $request->purchase_price;
            $medicine->sale_price     = $request->sale_price;
            $medicine->stock          = $request->stock;
            $medicine->status         = $request->status ?? 1;

            // 📸 Image upload
            if ($request->hasFile('image')) {
                $image      = $request->file('image');
                $imageName  = time() . '_' . $image->getClientOriginalName();
                $imagePath  = $image->storeAs('medicines', $imageName, 'public');
                $medicine->image = $imagePath;
            }

            $medicine->save();

            return response()->json([
                'status'  => true,
                'message' => 'Medicine added successfully',
                'data'    => $medicine,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update_medicine(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'store_id'       => 'required|exists:stores,id',
            'medicine_name'  => 'required|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'category'       => 'nullable|string|max:255',
            'batch_no'       => 'nullable|string|max:100',
            'expiry_date'    => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'sale_price'     => 'required|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
            'status'         => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $medicine = Medicine::find($id);

            if (!$medicine) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Medicine not found',
                ], 404);
            }

            $medicine->store_id       = $request->store_id;
            $medicine->medicine_name  = $request->medicine_name;
            $medicine->brand          = $request->brand;
            $medicine->category       = $request->category;
            $medicine->batch_no       = $request->batch_no;
            $medicine->expiry_date    = $request->expiry_date;
            $medicine->purchase_price = $request->purchase_price;
            $medicine->sale_price     = $request->sale_price;
            $medicine->stock          = $request->stock;
            $medicine->status         = $request->status ?? $medicine->status;

            // 📸 Image upload (optional)
            if ($request->hasFile('image')) {

                // (Optional) old image delete
                if ($medicine->image && \Storage::disk('public')->exists($medicine->image)) {
                    \Storage::disk('public')->delete($medicine->image);
                }

                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imagePath = $request->file('image')
                    ->storeAs('medicines', $imageName, 'public');

                $medicine->image = $imagePath;
            }

            $medicine->save();

            return response()->json([
                'status'  => true,
                'message' => 'Medicine updated successfully',
                'data'    => $medicine,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getAllMedicines()
    {
        $medicines = Medicine::with('store')->get();

        $medicines->transform(function ($medicine) {
            if ($medicine->image) {
                $medicine->image = asset('storage/' . $medicine->image);
            } else {
                $medicine->image = null;
            }
            return $medicine;
        });

        return response()->json([
            'status'  => true,
            'message' => 'Medicines with store fetched successfully',
            'data'    => $medicines
        ], 200);
    }

    public function create_inventory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id'    => 'required|exists:stores,id',
            'medicine_id' => 'required|exists:medicines,id',
            'type'        => 'required|in:IN,OUT,SET',
            'quantity'    => 'required|integer|min:1',
            'reference'   => 'nullable|string|max:255',
            'note'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $medicine = Medicine::find($request->medicine_id);

            if (!$medicine) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Medicine not found',
                ], 404);
            }

            $before = $medicine->stock ?? 0;

            if ($request->type === 'IN') {
                $after = $before + $request->quantity;
            } elseif ($request->type === 'OUT') {

                if ($request->quantity > $before) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Insufficient stock',
                    ], 400);
                }

                $after = $before - $request->quantity;
            } else { // SET
                $after = $request->quantity;
            }

            $inventory = Inventory::create([
                'store_id'      => $request->store_id,
                'medicine_id'   => $medicine->id,
                'type'          => $request->type,
                'quantity'      => $request->quantity,
                'stock_before'  => $before,
                'stock_after'   => $after,
                'reference'     => $request->reference,
                'note'          => $request->note,
            ]);

            // update medicine stock
            $medicine->update(['stock' => $after]);

            // 🔥 Load relations
            $inventory->load(['store', 'medicine']);

            return response()->json([
                'status'  => true,
                'message' => 'Inventory updated successfully',
                'data'    => $inventory
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function getInventory()
    {
        $inventories = Inventory::with(['store', 'medicine'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Inventory list fetched successfully',
            'data' => $inventories
        ], 200);
    }

    public function create_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id'        => 'required|exists:stores,id',
            'payment_method' => 'required|string',
            'customer_name'  => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',

            'sub_total'    => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'tax'          => 'nullable|numeric|min:0',
            'grand_total'  => 'required|numeric|min:0',

            'items'               => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.price'       => 'required|numeric|min:0',
            'items.*.total'       => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            // ✅ Invoice number
            $invoiceNo = 'INV-' . now()->format('YmdHis');

            $sale = Sale::create([
                'invoice_no'     => $invoiceNo,
                'store_id'       => $request->store_id,
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'sub_total'      => $request->sub_total,
                'discount'       => $request->discount ?? 0,
                'tax'            => $request->tax ?? 0,
                'grand_total'    => $request->grand_total,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($request->items as $item) {

                $medicine = Medicine::lockForUpdate()->find($item['medicine_id']);

                if (!$medicine) {
                    throw new \Exception('Medicine not found');
                }

                // ❌ Stock protection
                if ($medicine->stock < $item['quantity']) {
                    throw new \Exception(
                        $medicine->medicine_name . ' stock not available'
                    );
                }

                // ✅ Save sale items
                SaleItem::create([
                    'sale_id'     => $sale->id,
                    'medicine_id' => $medicine->id,
                    'quantity'    => $item['quantity'],
                    'price'       => $item['price'],
                    'total'       => $item['total'],
                ]);

                // ✅ Deduct stock
                $medicine->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // 🔥 Load relations (optional)
            $sale->load('items.medicine', 'store');

            return response()->json([
                'status'  => true,
                'message' => 'Sale completed successfully',
                'data'    => $sale
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function getAllSales()
    {
        $sales = Sale::with([
            'items.medicine',
            'store'
        ])->get();

        return response()->json([
            'status'  => true,
            'message' => 'Sales fetched successfully',
            'data'    => $sales
        ], 200);
    }

    public function pharmacistDashboard(Request $request)
{
    $filter = $request->get('filter', 'today');
    $store_id = $request->get('store_id');

    // ------------------- FILTER DATES -------------------
    if ($filter === 'week') {
        $fromDate = Carbon::now()->startOfWeek();
        $toDate = Carbon::now()->endOfWeek();
    } elseif ($filter === 'month') {
        $fromDate = Carbon::now()->startOfMonth();
        $toDate = Carbon::now()->endOfMonth();
    } else {
        $fromDate = Carbon::today()->startOfDay();
        $toDate = Carbon::today()->endOfDay();
    }

    // ------------------- STORES -------------------
    $stores = Store::select('id', 'store_name')->get();

    // ------------------- SUMMARY -------------------
    $totalMedicines = Medicine::count();
    $lowStockMedicines = Medicine::where('stock', '<', 10)->count();
    $inventoryStock = Medicine::sum('stock');

    // ------------------- SALES -------------------
    $salesQuery = Sale::whereBetween('created_at', [$fromDate, $toDate])
        ->when($store_id, fn ($q) => $q->where('store_id', $store_id));

    $salesCount = $salesQuery->count();
    $salesRevenue = $salesQuery->sum('grand_total');

    // ------------------- STORE WISE REVENUE -------------------
    $storeRevenue = Sale::select(
        'stores.id',
        'stores.store_name',
        DB::raw('SUM(sales.grand_total) as revenue'),
        DB::raw('COUNT(sales.id) as sales_count'),
        DB::raw('AVG(sales.grand_total) as avg_sale_value')
    )
        ->join('stores', 'sales.store_id', '=', 'stores.id')
        ->whereBetween('sales.created_at', [$fromDate, $toDate])
        ->groupBy('stores.id', 'stores.store_name')
        ->orderByDesc('revenue')
        ->get();

    $totalStoreRevenue = $storeRevenue->sum('revenue');

    $storeRevenue = $storeRevenue->map(function ($store) use ($totalStoreRevenue) {
        return [
            'id' => $store->id,
            'store_name' => $store->store_name,
            'revenue' => (float) $store->revenue,
            'sales_count' => $store->sales_count,
            'avg_sale_value' => round($store->avg_sale_value, 2),
            'percentage' => $totalStoreRevenue > 0
                ? round(($store->revenue / $totalStoreRevenue) * 100, 2)
                : 0
        ];
    });

    // ------------------- RECENT SALES -------------------
    $recentSales = Sale::with('store:id,store_name')
        ->latest()
        ->limit(5)
        ->when($store_id, fn ($q) => $q->where('store_id', $store_id))
        ->get();

    // ------------------- API RESPONSE -------------------
    return response()->json([
        'status' => true,
        'message' => 'Pharmacist dashboard data fetched successfully',
        'filter' => $filter,
        'store_id' => $store_id,
        'summary' => [
            'total_medicines' => $totalMedicines,
            'low_stock_medicines' => $lowStockMedicines,
            'inventory_stock' => $inventoryStock,
            'sales_count' => $salesCount,
            'sales_revenue' => (float) $salesRevenue,
        ],
        'recent_sales' => $recentSales,
        'stores' => $stores,
    ], 200);
}

}
