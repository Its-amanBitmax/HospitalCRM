<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AccountantController extends Controller
{
    public function my_account()
    {
        return view('admin.accountant.account');
    }

    public function reports(Request $request)
    {
        $query = Transaction::query();

        // Time-based filters
        if ($request->filter === 'today') {
            $query->whereDate('transaction_date', Carbon::today());
        } elseif ($request->filter === 'week') {
            $query->whereBetween('transaction_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($request->filter === 'month') {
            $query->whereMonth('transaction_date', Carbon::now()->month)
                ->whereYear('transaction_date', Carbon::now()->year);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhere('remarks', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        // Advanced filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        // Paginate results
        $transactions = $query->latest()->paginate(20);

        return view('admin.accountant.report', compact('transactions'));
    }




    public function account_dashboard(Request $request)
    {
        // Get filters from request
        $selectedYear = $request->input('year', now()->year);
        $selectedMonth = $request->input('month', null);
        $selectedModule = $request->input('module', 'all');
        $selectedTransactionType = $request->input('transaction_type', 'all');

        // Initialize query builders
        $expensesQuery = Expenses::query();
        $transactionsQuery = Transaction::query();

        // Apply year filter
        $expensesQuery->whereYear('date', $selectedYear);
        $transactionsQuery->whereYear('transaction_date', $selectedYear);

        // Apply month filter if selected
        if ($selectedMonth && $selectedMonth !== 'all') {
            $expensesQuery->whereMonth('date', $selectedMonth);
            $transactionsQuery->whereMonth('transaction_date', $selectedMonth);
        }

        // Apply module filter if selected
        if ($selectedModule && $selectedModule !== 'all') {
            $transactionsQuery->where('module', $selectedModule);
        }

        // Apply transaction type filter if selected
        if ($selectedTransactionType && $selectedTransactionType !== 'all') {
            $transactionsQuery->where('transaction_type', $selectedTransactionType);
        }

        // Calculate totals with filters applied
        $totalExpenses = $expensesQuery->sum('amount');
        $totalTransactions = $transactionsQuery->sum('amount');

        // Count transactions
        $transactionCount = $transactionsQuery->count();
        $averageTransaction = $transactionCount > 0 ? $totalTransactions / $transactionCount : 0;

        // Get unique modules for filter
        $availableModules = Transaction::select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module')
            ->toArray();

        // Get transaction types for filter
        $availableTransactionTypes = ['credit', 'debit'];

        // Get months for the selected year
        $months = [];
        $fullMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create($selectedYear, $i, 1);
            $months[] = [
                'value' => $i,
                'short' => $date->format('M'),
                'full' => $date->format('F')
            ];
            $fullMonths[] = $date->format('F Y');
        }

        // Initialize data arrays with zeros
        $expensesData = array_fill(0, 12, 0);
        $transactionsData = array_fill(0, 12, 0);
        $creditData = array_fill(0, 12, 0);
        $debitData = array_fill(0, 12, 0);

        // Get expenses data by month for all months
        $expensesByMonth = Expenses::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $selectedYear)
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('date', $selectedMonth);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill expenses data
        foreach ($expensesByMonth as $month => $total) {
            $expensesData[$month - 1] = $total;
        }

        // Get transactions data by month with filters
        $transactionsByMonthQuery = Transaction::selectRaw('MONTH(transaction_date) as month, SUM(amount) as total')
            ->whereYear('transaction_date', $selectedYear)
            ->when($selectedModule && $selectedModule !== 'all', function ($query) use ($selectedModule) {
                return $query->where('module', $selectedModule);
            })
            ->when($selectedTransactionType && $selectedTransactionType !== 'all', function ($query) use ($selectedTransactionType) {
                return $query->where('transaction_type', $selectedTransactionType);
            });

        $transactionsByMonth = $transactionsByMonthQuery
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Get credit transactions by month
        $creditsByMonth = Transaction::selectRaw('MONTH(transaction_date) as month, SUM(amount) as total')
            ->whereYear('transaction_date', $selectedYear)
            ->where('transaction_type', 'credit')
            ->when($selectedModule && $selectedModule !== 'all', function ($query) use ($selectedModule) {
                return $query->where('module', $selectedModule);
            })
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('transaction_date', $selectedMonth);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Get debit transactions by month
        $debitsByMonth = Transaction::selectRaw('MONTH(transaction_date) as month, SUM(amount) as total')
            ->whereYear('transaction_date', $selectedYear)
            ->where('transaction_type', 'debit')
            ->when($selectedModule && $selectedModule !== 'all', function ($query) use ($selectedModule) {
                return $query->where('module', $selectedModule);
            })
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('transaction_date', $selectedMonth);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill transactions data
        foreach ($transactionsByMonth as $month => $total) {
            $transactionsData[$month - 1] = $total;
        }

        // Fill credit/debit data
        foreach ($creditsByMonth as $month => $total) {
            $creditData[$month - 1] = $total;
        }

        foreach ($debitsByMonth as $month => $total) {
            $debitData[$month - 1] = abs($total);
        }

        // Get recent transactions with filters
        $recentTransactions = Transaction::query()
            ->when($selectedModule && $selectedModule !== 'all', function ($query) use ($selectedModule) {
                return $query->where('module', $selectedModule);
            })
            ->when($selectedTransactionType && $selectedTransactionType !== 'all', function ($query) use ($selectedTransactionType) {
                return $query->where('transaction_type', $selectedTransactionType);
            })
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('transaction_date', $selectedMonth);
            })
            ->latest('transaction_date')
            ->take(10)
            ->get();

        // Get top expense categories
        $topExpenseCategories = Expenses::select('reason', DB::raw('SUM(amount) as total'))
            ->whereYear('date', $selectedYear)
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('date', $selectedMonth);
            })
            ->groupBy('reason')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Get transaction summary by type
        $transactionSummary = Transaction::select(
            'transaction_type',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total')
        )
            ->whereYear('transaction_date', $selectedYear)
            ->when($selectedModule && $selectedModule !== 'all', function ($query) use ($selectedModule) {
                return $query->where('module', $selectedModule);
            })
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('transaction_date', $selectedMonth);
            })
            ->groupBy('transaction_type')
            ->get();

        // Get module-wise summary
        $moduleSummary = Transaction::select(
            'module',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total')
        )
            ->whereYear('transaction_date', $selectedYear)
            ->when($selectedTransactionType && $selectedTransactionType !== 'all', function ($query) use ($selectedTransactionType) {
                return $query->where('transaction_type', $selectedTransactionType);
            })
            ->when($selectedMonth && $selectedMonth !== 'all', function ($query) use ($selectedMonth) {
                return $query->whereMonth('transaction_date', $selectedMonth);
            })
            ->groupBy('module')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Get available years for dropdown
        $expensesYears = Expenses::selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $transactionsYears = Transaction::selectRaw('YEAR(transaction_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Include fixed range from 2020 to current year + 1
        $fixedYears = range(2020, now()->year + 1);

        $availableYears = array_unique(array_merge($expensesYears, $transactionsYears, $fixedYears));

        rsort($availableYears);

        // Prepare month labels for charts
        $monthLabels = [];
        foreach ($months as $month) {
            $monthLabels[] = $month['short'];
        }

        // Get active filter count
        $activeFilterCount = 0;
        if ($selectedMonth && $selectedMonth !== 'all') $activeFilterCount++;
        if ($selectedModule && $selectedModule !== 'all') $activeFilterCount++;
        if ($selectedTransactionType && $selectedTransactionType !== 'all') $activeFilterCount++;

        return view('accountants.account-dashboard', [
            // Filters
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'selectedModule' => $selectedModule,
            'selectedTransactionType' => $selectedTransactionType,

            // Data
            'totalExpenses' => $totalExpenses,
            'totalTransactions' => $totalTransactions,
            'averageTransaction' => $averageTransaction,
            'transactionCount' => $transactionCount,

            // Chart data
            'expensesLabels' => $monthLabels,
            'expensesData' => $expensesData,
            'transactionsLabels' => $monthLabels,
            'transactionsData' => $transactionsData,
            'creditData' => $creditData,
            'debitData' => $debitData,
            'fullMonths' => $fullMonths,

            // Filter options
            'availableYears' => $availableYears,
            'availableModules' => $availableModules,
            'availableTransactionTypes' => $availableTransactionTypes,
            'months' => $months,

            // Additional data
            'recentTransactions' => $recentTransactions,
            'topExpenseCategories' => $topExpenseCategories,
            'transactionSummary' => $transactionSummary,
            'moduleSummary' => $moduleSummary,

            // Stats
            'activeFilterCount' => $activeFilterCount,
        ]);
    }



    

    public function account_profile()
    {
        $accountant = auth('accountant')->user();
        $accountant->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);
        return view('accountants.profile', compact('accountant'));
    }




    public function edit_profile()
    {
        $accountant = auth('accountant')->user();
        $accountant->load(['department', 'payroll', 'addresses', 'professions', 'qualifications', 'documents', 'familyDetails']);
        return view('accountants.update-profile', compact('accountant'));
    }


    public function update_profile(Request $request)
    {
        $accountant = auth('accountant')->user();

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $accountant->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'emergency_contact' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($accountant->image && Storage::exists('public/' . $accountant->image)) {
                    Storage::delete('public/' . $accountant->image);
                }

                // Store new image
                $imagePath = $request->file('image')->store('accountant-profiles', 'public');
                $validated['image'] = $imagePath;
            }

            // Update accountant
            $accountant->update($validated);

            // Update addresses using relationship
            if ($request->has('addresses')) {
                foreach ($request->addresses as $addressData) {
                    if (isset($addressData['id'])) {
                        $accountant->addresses()->where('id', $addressData['id'])->update([
                            'street' => $addressData['street'] ?? null,
                            'city' => $addressData['city'] ?? null,
                            'state' => $addressData['state'] ?? null,
                            'country' => $addressData['country'] ?? null,
                            'postal_code' => $addressData['postal_code'] ?? null,
                        ]);
                    }
                }
            }

            // Update qualifications
            if ($request->has('qualifications')) {
                foreach ($request->qualifications as $qualData) {
                    if (isset($qualData['id'])) {
                        $accountant->qualifications()->where('id', $qualData['id'])->update([
                            'degree' => $qualData['degree'] ?? null,
                            'institution' => $qualData['institution'] ?? null,
                            'year_completed' => $qualData['year_completed'] ?? null,
                        ]);
                    }
                }
            }

            // Update family details
            if ($request->has('familyDetails')) {
                foreach ($request->familyDetails as $familyData) {
                    if (isset($familyData['id'])) {
                        $accountant->familyDetails()->where('id', $familyData['id'])->update([
                            'name' => $familyData['name'] ?? null,
                            'relationship' => $familyData['relationship'] ?? null,
                            'date_of_birth' => $familyData['date_of_birth'] ?? null,
                            'contact_number' => $familyData['contact_number'] ?? null,
                        ]);
                    }
                }
            }

            // Update payroll
            if ($request->has('payroll') && $accountant->payroll) {
                $accountant->payroll->update([
                    'bank_name' => $request->payroll['bank_name'] ?? null,
                    'bank_account' => $request->payroll['bank_account'] ?? null,
                    'ifsc_code' => $request->payroll['ifsc_code'] ?? null,
                    'upi_number' => $request->payroll['upi_number'] ?? null,
                    'pf_number' => $request->payroll['pf_number'] ?? null,
                ]);
            }

            return redirect()->route('accountant.profile.edit')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
