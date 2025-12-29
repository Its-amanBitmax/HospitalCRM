@extends('layouts.accountant')

@section('content')


<!-- Quick Filter Presets -->
<div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 mb-2">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Quick Filter Presets</h2>
            <p class="text-gray-600 text-sm">Common filter combinations</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ request()->url() }}?year={{ $selectedYear }}&month={{ now()->month }}&module=all&transaction_type=all"
                class="px-4 py-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 text-sm font-medium rounded-lg transition">
                Current Month
            </a>
            <a href="{{ request()->url() }}?year={{ $selectedYear }}&month=all&module=blood_bank&transaction_type=all"
                class="px-4 py-2 bg-green-50 hover:bg-green-100 border border-green-200 text-green-700 text-sm font-medium rounded-lg transition">
                Blood Bank Only
            </a>
            <a href="{{ request()->url() }}?year={{ $selectedYear }}&month=all&module=all&transaction_type=credit"
                class="px-4 py-2 bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-700 text-sm font-medium rounded-lg transition">
                Credits Only
            </a>
            <a href="{{ request()->url() }}?year={{ $selectedYear }}&month=all&module=all&transaction_type=debit"
                class="px-4 py-2 bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 text-sm font-medium rounded-lg transition">
                Debits Only
            </a>
            <a href="{{ request()->url() }}?year={{ $selectedYear }}&month={{ now()->subMonth()->month }}&module=all&transaction_type=all"
                class="px-4 py-2 bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 text-yellow-700 text-sm font-medium rounded-lg transition">
                Previous Month
            </a>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="mb-8 bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Accountant Dashboard</h1>
            <p class="text-gray-600 mt-1">Financial overview with advanced filtering</p>
        </div>

        <!-- Active Filters Badge -->
        @if($activeFilterCount > 0)
        <div class="flex items-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mr-3">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                {{ $activeFilterCount }} active filter{{ $activeFilterCount > 1 ? 's' : '' }}
            </span>
            <a href="{{ request()->url() }}" class="text-sm text-red-600 hover:text-red-800">
                Clear All Filters
            </a>
        </div>
        @endif
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ request()->url() }}" class="mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Year Filter -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select id="year" name="year" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Month Filter -->
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select id="month" name="month" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="all" {{ $selectedMonth == 'all' || !$selectedMonth ? 'selected' : '' }}>All Months</option>
                    @foreach($months as $month)
                    <option value="{{ $month['value'] }}" {{ $selectedMonth == $month['value'] ? 'selected' : '' }}>
                        {{ $month['full'] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Module Filter -->
            <div>
                <label for="module" class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                <select id="module" name="module" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="all" {{ $selectedModule == 'all' || !$selectedModule ? 'selected' : '' }}>All Modules</option>
                    @foreach($availableModules as $module)
                    <option value="{{ $module }}" {{ $selectedModule == $module ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $module)) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Transaction Type Filter -->
            <div>
                <label for="transaction_type" class="block text-sm font-medium text-gray-700 mb-1">Transaction Type</label>
                <select id="transaction_type" name="transaction_type" onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    <option value="all" {{ $selectedTransactionType == 'all' || !$selectedTransactionType ? 'selected' : '' }}>All Types</option>
                    @foreach($availableTransactionTypes as $type)
                    <option value="{{ $type }}" {{ $selectedTransactionType == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Clear Filters Button -->
        <div class="mt-4 flex justify-end">
            <a href="{{ request()->url() }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear All Filters
            </a>
        </div>

        <!-- Active Filters Display -->
        @if($activeFilterCount > 0)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap gap-2">
                @if($selectedMonth && $selectedMonth !== 'all')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Month: {{ $months[$selectedMonth-1]['full'] ?? '' }}
                    <button type="button" onclick="removeFilter('month')" class="ml-1.5 text-blue-600 hover:text-blue-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif

                @if($selectedModule && $selectedModule !== 'all')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Module: {{ ucfirst(str_replace('_', ' ', $selectedModule)) }}
                    <button type="button" onclick="removeFilter('module')" class="ml-1.5 text-green-600 hover:text-green-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif

                @if($selectedTransactionType && $selectedTransactionType !== 'all')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    Type: {{ ucfirst($selectedTransactionType) }}
                    <button type="button" onclick="removeFilter('transaction_type')" class="ml-1.5 text-purple-600 hover:text-purple-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif
            </div>
        </div>
        @endif
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Expenses Card -->
    <div class="bg-gradient-to-br from-white to-red-50 p-6 rounded-xl shadow-md border border-red-100">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-red-600 mb-1">Total Expenses</p>
                <h3 class="text-2xl font-bold text-gray-800">₹{{ number_format($totalExpenses, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-2">
                    @if($selectedMonth && $selectedMonth !== 'all')
                    {{ $months[$selectedMonth-1]['full'] ?? '' }} {{ $selectedYear }}
                    @else
                    {{ $selectedYear }}
                    @endif
                </p>
            </div>
            <div class="p-3 rounded-xl bg-red-100">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Transactions Card -->
    <div class="bg-gradient-to-br from-white to-green-50 p-6 rounded-xl shadow-md border border-green-100">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-green-600 mb-1">Total Transactions</p>
                <h3 class="text-2xl font-bold text-gray-800">₹{{ number_format($totalTransactions, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-2">{{ $transactionCount }} transactions</p>
            </div>
            <div class="p-3 rounded-xl bg-green-100">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 01118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Average Transaction Card -->
    <div class="bg-gradient-to-br from-white to-blue-50 p-6 rounded-xl shadow-md border border-blue-100">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-blue-600 mb-1">Avg. Transaction</p>
                <h3 class="text-2xl font-bold text-gray-800">₹{{ number_format($averageTransaction, 2) }}</h3>
                <p class="text-xs text-gray-500 mt-2">Based on filtered data</p>
            </div>
            <div class="p-3 rounded-xl bg-blue-100">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Filters Card -->
    <div class="bg-gradient-to-br from-white to-purple-50 p-6 rounded-xl shadow-md border border-purple-100">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-purple-600 mb-1">Filter Summary</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $activeFilterCount }}/3</h3>
                <p class="text-xs text-gray-500 mt-2">Filters active</p>
            </div>
            <div class="p-3 rounded-xl bg-purple-100">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Main Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Expenses Chart Card -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Monthly Expenses</h2>
                <p class="text-gray-600 text-sm">
                    @if($selectedMonth && $selectedMonth !== 'all')
                    {{ $months[$selectedMonth-1]['full'] ?? '' }} {{ $selectedYear }}
                    @else
                    {{ $selectedYear }}
                    @endif
                </p>
            </div>
            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Expenses</span>
                </div>
            </div>
        </div>
        <div class="h-80">
            @if(array_sum($expensesData) > 0)
            <canvas id="expensesChart"></canvas>
            @else
            <div class="h-full flex flex-col items-center justify-center text-gray-400">
                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg">No expense data for selected filters</p>
                <p class="text-sm mt-1">Try different filter combinations</p>
            </div>
            @endif
        </div>
        @if($topExpenseCategories->count() > 0)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Top Expense Categories</h3>
            <div class="space-y-2">
                @foreach($topExpenseCategories as $category)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full bg-red-500 mr-3"></div>
                        <span class="text-sm text-gray-700 truncate max-w-xs">{{ $category->reason }}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">₹{{ number_format($category->total, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Transactions Chart Card -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Monthly Transactions</h2>
                <p class="text-gray-600 text-sm">
                    @if($selectedModule && $selectedModule !== 'all')
                    Module: {{ ucfirst(str_replace('_', ' ', $selectedModule)) }} |
                    @endif
                    @if($selectedTransactionType && $selectedTransactionType !== 'all')
                    Type: {{ ucfirst($selectedTransactionType) }} |
                    @endif
                    {{ $selectedYear }}
                </p>
            </div>
            <div class="flex items-center space-x-4 mt-2 sm:mt-0">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Credit</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Debit</span>
                </div>
            </div>
        </div>
        <div class="h-80">
            @if(array_sum($transactionsData) > 0)
            <canvas id="transactionsChart"></canvas>
            @else
            <div class="h-full flex flex-col items-center justify-center text-gray-400">
                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg">No transaction data for selected filters</p>
                <p class="text-sm mt-1">Try different filter combinations</p>
            </div>
            @endif
        </div>
        @if($moduleSummary->count() > 0)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Module-wise Summary</h3>
            <div class="space-y-2">
                @foreach($moduleSummary as $module)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-2 h-2 rounded-full bg-green-500 mr-3"></div>
                        <span class="text-sm text-gray-700 capitalize">{{ str_replace('_', ' ', $module->module) }}</span>
                        <span class="text-xs text-gray-500 ml-2">({{ $module->count }})</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-800">₹{{ number_format($module->total, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Statistics & Details Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Transaction Type Breakdown -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Transaction Breakdown</h2>
            @if($transactionSummary->count() > 0)
            <div class="space-y-4">
                @foreach($transactionSummary as $summary)
                <div class="bg-gradient-to-r {{ $summary->transaction_type == 'credit' ? 'from-green-50 to-white' : 'from-red-50 to-white' }} p-4 rounded-lg border {{ $summary->transaction_type == 'credit' ? 'border-green-100' : 'border-red-100' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 rounded-lg {{ $summary->transaction_type == 'credit' ? 'bg-green-100' : 'bg-red-100' }} mr-3">
                                <svg class="w-5 h-5 {{ $summary->transaction_type == 'credit' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($summary->transaction_type == 'credit')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    @endif
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 capitalize">{{ $summary->transaction_type }}</p>
                                <p class="text-sm text-gray-500">{{ $summary->count }} transactions</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold {{ $summary->transaction_type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                ₹{{ number_format(abs($summary->total), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p>No transaction data for selected filters</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Recent Transactions</h2>
                    <p class="text-gray-600 text-sm">Filtered results (latest 10)</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">
                        Showing {{ $recentTransactions->count() }} transactions
                    </span>
                    <a href="?{{ http_build_query(request()->except('page')) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            @if($recentTransactions->count() > 0)
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID & Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Module & Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $transaction->transaction_id }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $transaction->module) }}</span>
                                    <span class="text-xs text-gray-500 capitalize">{{ $transaction->transaction_type }}</span>
                                    @if($transaction->remarks)
                                    <div class="text-xs text-gray-400 truncate max-w-xs mt-1">{{ $transaction->remarks }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-lg font-bold {{ $transaction->transaction_type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->transaction_type == 'credit' ? '+' : '-' }}₹{{ number_format(abs($transaction->amount), 2) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $transaction->payment_mode }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $transaction->status == 'paid' ? 'bg-green-100 text-green-800' : 
                                           ($transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">No transactions found with current filters</p>
                <p class="text-sm text-gray-400 mt-1">Try adjusting your filter settings</p>
            </div>
            @endif
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Function to remove individual filters
    function removeFilter(filterName) {
        const url = new URL(window.location.href);
        url.searchParams.delete(filterName);

        // If removing month, set to 'all'
        if (filterName === 'month') {
            url.searchParams.set('month', 'all');
        }

        window.location.href = url.toString();
    }

    // Initialize Charts when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Expenses Chart
        @if(array_sum($expensesData) > 0)
        const expensesCtx = document.getElementById('expensesChart');
        new Chart(expensesCtx, {
            type: 'bar',
            data: {
                labels: @json($expensesLabels),
                datasets: [{
                    label: 'Expenses (₹)',
                    data: @json($expensesData),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(220, 38, 38, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#ef4444',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return '₹' + context.parsed.y.toLocaleString('en-IN');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString('en-IN');
                            },
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Amount (₹)',
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        @endif

        // Transactions Chart (Combined Credit/Debit)
        @if(array_sum($transactionsData) > 0)
        const transactionsCtx = document.getElementById('transactionsChart');
        new Chart(transactionsCtx, {
            type: 'line',
            data: {
                labels: @json($transactionsLabels),
                datasets: [{
                        label: 'Credit (₹)',
                        data: @json($creditData),
                        borderColor: 'rgba(34, 197, 94, 1)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(34, 197, 94, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Debit (₹)',
                        data: @json($debitData),
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 3,
                        borderDash: [5, 5],
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#22c55e',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '₹' + context.parsed.y.toLocaleString('en-IN');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString('en-IN');
                            },
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Amount (₹)',
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: 'Inter, system-ui, sans-serif'
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        @endif

        // Add animation to cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all cards for animation
        document.querySelectorAll('.bg-gradient-to-br, .bg-white').forEach((el) => {
            observer.observe(el);
        });
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Custom scrollbar styling */
    .overflow-hidden::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .overflow-hidden::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .overflow-hidden::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .overflow-hidden::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Smooth transitions */
    .transition {
        transition: all 0.3s ease;
    }

    /* Gradient text for highlights */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

@endsection