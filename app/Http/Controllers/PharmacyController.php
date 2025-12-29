<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Store;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{
    public function pharmacist_dashboard(Request $request)
    {
        $filter = $request->get('filter', 'today');
        $store_id = $request->get('store_id', null);

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

        // ------------------- GET ALL STORES -------------------
        $stores = Store::all();

        // ------------------- SUMMARY -------------------
        $totalMedicines = Medicine::count();
        $lowStockMedicines = Medicine::where('stock', '<', 10)->count();

        // ------------------- SALES QUERY -------------------
        $salesQuery = Sale::whereBetween('created_at', [$fromDate, $toDate]);

        if ($store_id) {
            $salesQuery->where('store_id', $store_id);
        }

        $salesCount = $salesQuery->count();
        $salesRevenue = $salesQuery->sum('grand_total');

        // ------------------- INVENTORY -------------------
        $inventoryStock = Medicine::sum('stock');

        // ------------------- GRAPH DATA -------------------
        $graphSales = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(grand_total) as total'),
            DB::raw('COUNT(id) as sales_count')
        )
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->when($store_id, function ($query) use ($store_id) {
                return $query->where('store_id', $store_id);
            })
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $graphSales->map(fn($sale) => Carbon::parse($sale->date)->format('d M'))->toArray();
        $salesData = $graphSales->pluck('total')->map(fn($t) => (float)$t)->toArray();
        $salesCountData = $graphSales->pluck('sales_count')->toArray();

        // ------------------- STORE-WISE REVENUE -------------------
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

        // Calculate total revenue for percentage
        $totalStoreRevenue = $storeRevenue->sum('revenue');

        // Add percentage to each store
        $storeRevenue = $storeRevenue->map(function ($store) use ($totalStoreRevenue) {
            $store->percentage = $totalStoreRevenue > 0 ? ($store->revenue / $totalStoreRevenue * 100) : 0;
            return $store;
        });

        // ------------------- STORE PERFORMANCE METRICS -------------------
        $storePerformance = [];
        if ($storeRevenue->count() > 0) {
            foreach ($storeRevenue as $store) {
                // Get daily data for each store for the trend line
                $dailyData = Sale::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(grand_total) as daily_revenue'),
                    DB::raw('COUNT(id) as daily_sales')
                )
                    ->whereBetween('created_at', [$fromDate, $toDate])
                    ->where('store_id', $store->id)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

                $storePerformance[] = [
                    'store' => $store,
                    'daily_revenue' => $dailyData->pluck('daily_revenue'),
                    'daily_sales' => $dailyData->pluck('daily_sales'),
                    'dates' => $dailyData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))
                ];
            }
        }

        // ------------------- RECENT SALES -------------------
        $recentSales = Sale::with('store')
            ->latest()
            ->limit(5)
            ->when($store_id, function ($query) use ($store_id) {
                return $query->where('store_id', $store_id);
            })
            ->get();

        return view('pharmacist.dashboard', compact(
            'totalMedicines',
            'lowStockMedicines',
            'salesCount',
            'salesRevenue',
            'inventoryStock',
            'labels',
            'salesData',
            'salesCountData',
            'recentSales',
            'storeRevenue',
            'storePerformance',
            'stores',
            'store_id',
            'filter'
        ));
    }


    public function profile_view()
    {
        $employee = \App\Models\Employee::with([
            'department',
            'addresses',
            'qualifications',
            'documents',
            'familyDetails',
            'payroll'
        ])->find(auth('pharmacist')->id());

        return view('pharmacist.view-profile', compact('employee'));
    }

      public function edit_profile()
    {
        $pharmacist = auth('pharmacist')->user();

       

        $pharmacist->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);

        return view('pharmacist.edit-profile', compact('pharmacist'));
    }


      public function update_profile(Request $request)
    {
        $pharmacist = auth('pharmacist')->user();

        if (!$pharmacist) {
            return redirect()->route('$pharmacist.login');
        }

        DB::transaction(function () use ($request, $pharmacist) {
            /* ================= BASIC UPDATE ================= */
            $pharmacist->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->date_of_birth,
                'hire_date' => $request->hire_date,
                'status' => $request->status,
                'department_id' => $request->department_id,
            ]);

            /* ================= IMAGE UPLOAD ================= */
            if ($request->hasFile('image')) {
                // delete old image
                if ($pharmacist->image && Storage::disk('public')->exists($pharmacist->image)) {
                    Storage::disk('public')->delete($pharmacist->image);
                }

                // store new image
                $path = $request->file('image')->store('employees', 'public');

                // update image column
                $pharmacist->update(['image' => $path]);
            }

            /* ================= ADDRESSES ================= */
            if ($request->addresses) {
                foreach ($request->addresses as $address) {
                    if (!empty($address['id'])) {
                        $existing = $pharmacist->addresses()->find($address['id']);
                        if ($existing) {
                            $existing->update([
                                'address_type' => $address['address_type'] ?? $existing->address_type,
                                'street' => $address['street'] ?? $existing->street,
                                'city' => $address['city'] ?? $existing->city,
                                'state' => $address['state'] ?? $existing->state,
                                'country' => $address['country'] ?? $existing->country,
                                'postal_code' => $address['postal_code'] ?? $existing->postal_code,
                            ]);
                        }
                    } else {
                        $pharmacist->addresses()->create([
                            'address_type' => $address['address_type'] ?? 'Home',
                            'street' => $address['street'] ?? '',
                            'city' => $address['city'] ?? '',
                            'state' => $address['state'] ?? '',
                            'country' => $address['country'] ?? '',
                            'postal_code' => $address['postal_code'] ?? '',
                        ]);
                    }
                }
            }

            /* ================= PROFESSIONS ================= */
            if ($request->professions) {
                foreach ($request->professions as $profession) {
                    if (!empty($profession['id'])) {
                        $existing = $pharmacist->professions()->find($profession['id']);
                        if ($existing) {
                            $existing->update([
                                'title' => $profession['title'] ?? $existing->title,
                                'department_id' => $profession['department_id'] ?? $existing->department_id,
                            ]);
                        }
                    } else {
                        $pharmacist->professions()->create([
                            'title' => $profession['title'] ?? '',
                            'department_id' => $profession['department_id'] ?? null,
                        ]);
                    }
                }
            }

            /* ================= QUALIFICATIONS ================= */
            if ($request->qualifications) {
                foreach ($request->qualifications as $qualification) {
                    if (!empty($qualification['id'])) {
                        $existing = $pharmacist->qualifications()->find($qualification['id']);
                        if ($existing) {
                            $existing->update([
                                'degree' => $qualification['degree'] ?? $existing->degree,
                                'institution' => $qualification['institution'] ?? $existing->institution,
                                'year_completed' => $qualification['year_completed'] ?? $existing->year_completed,
                            ]);
                        }
                    } else {
                        $pharmacist->qualifications()->create([
                            'degree' => $qualification['degree'] ?? '',
                            'institution' => $qualification['institution'] ?? '',
                            'year_completed' => $qualification['year_completed'] ?? '',
                        ]);
                    }
                }
            }

            /* ================= FAMILY DETAILS ================= */
            if ($request->family_details) {
                foreach ($request->family_details as $family) {
                    if (!empty($family['id'])) {
                        $existing = $pharmacist->familyDetails()->find($family['id']);
                        if ($existing) {
                            $existing->update([
                                'name' => $family['name'] ?? $existing->name,
                                'relationship' => $family['relationship'] ?? $existing->relationship,
                                'date_of_birth' => $family['date_of_birth'] ?? $existing->date_of_birth,
                                'contact_number' => $family['contact_number'] ?? $existing->contact_number,
                            ]);
                        }
                    } else {
                        $pharmacist->familyDetails()->create([
                            'name' => $family['name'] ?? '',
                            'relationship' => $family['relationship'] ?? '',
                            'date_of_birth' => $family['date_of_birth'] ?? null,
                            'contact_number' => $family['contact_number'] ?? '',
                        ]);
                    }
                }
            }

            /* ================= DOCUMENTS UPLOAD ================= */
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $doc) {
                    $storedPath = $doc->store('employee_documents', 'public');

                    $pharmacist->documents()->create([
                        'document_type' => $doc->getClientOriginalExtension(),
                        'document_path' => $storedPath,
                        'uploaded_at' => now(),
                    ]);
                }
            }

            /* ================= DELETE RELATED DATA ================= */
            // Delete addresses
            if ($request->filled('deleted_addresses')) {
                $ids = json_decode($request->deleted_addresses, true);
                if (is_array($ids) && count($ids) > 0) {
                    $pharmacist->addresses()->whereIn('id', $ids)->delete();
                }
            }

            // Delete professions
            if ($request->filled('deleted_professions')) {
                $ids = json_decode($request->deleted_professions, true);
                if (is_array($ids) && count($ids) > 0) {
                    $pharmacist->professions()->whereIn('id', $ids)->delete();
                }
            }

            // Delete qualifications
            if ($request->filled('deleted_qualifications')) {
                $ids = json_decode($request->deleted_qualifications, true);
                if (is_array($ids) && count($ids) > 0) {
                    $pharmacist->qualifications()->whereIn('id', $ids)->delete();
                }
            }

            // Delete family details
            if ($request->filled('deleted_family_details')) {
                $ids = json_decode($request->deleted_family_details, true);
                if (is_array($ids) && count($ids) > 0) {
                    $pharmacist->familyDetails()->whereIn('id', $ids)->delete();
                }
            }

            // Delete documents
            if ($request->filled('deleted_documents')) {
                $ids = json_decode($request->deleted_documents, true);

                if (is_array($ids) && count($ids) > 0) {
                    foreach ($pharmacist->documents()->whereIn('id', $ids)->get() as $doc) {
                        if (Storage::disk('public')->exists($doc->document_path)) {
                            Storage::disk('public')->delete($doc->document_path);
                        }

                        $doc->delete();
                    }
                }
            }
        });

        return redirect()
            ->back()
            ->with('success', 'Profile updated successfully');
    }









    
}
