@php
$layout = auth('accountant')->check() ? 'layouts.accountant' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="min-h-screen ">
    <div class="max-w-[970px]">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Transaction Report</h1>
                    <p class="text-gray-600 mt-1 sm:mt-2 text-sm sm:text-base">View and analyze all financial transactions in the system</p>
                </div>
                
                {{-- Export buttons --}}
                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <div class="relative">
                        <select id="filter" 
                                class="appearance-none bg-white border border-gray-300 rounded-lg pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer w-full sm:w-auto">
                            <option value="">All Transactions</option>
                            <option value="today" {{ request('filter')=='today'?'selected':'' }}>Today</option>
                            <option value="week" {{ request('filter')=='week'?'selected':'' }}>This Week</option>
                            <option value="month" {{ request('filter')=='month'?'selected':'' }}>This Month</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <button type="button" onclick="applyFilter()"
                        class="inline-flex items-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 text-sm">
                        <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply
                    </button>
                    
                    <div class="relative group">
                        <button type="button"
                            class="inline-flex items-center px-3 sm:px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 transition-colors duration-200 text-sm">
                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2 2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </button>
                        <div class="absolute right-0 mt-2 w-40 sm:w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <button onclick="exportPDF()"
                                class="w-full text-left px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
                                </svg>
                                Export as PDF
                            </button>
                            <button onclick="exportExcel()"
                                class="w-full text-left px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg flex items-center border-t border-gray-100">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Export as Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl sm:rounded-2xl shadow-sm border border-blue-200 p-4 sm:p-6 transition-transform duration-200 hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-blue-700 mb-1">Total Amount</p>
                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
                            ₹{{ number_format($transactions->sum('amount'), 2) }}
                        </h3>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-600 rounded-lg sm:rounded-xl">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-blue-600 mt-2 sm:mt-3">Total transaction value</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl sm:rounded-2xl shadow-sm border border-green-200 p-4 sm:p-6 transition-transform duration-200 hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-green-700 mb-1">Total Transactions</p>
                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
                            {{ $transactions->count() }}
                        </h3>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-600 rounded-lg sm:rounded-xl">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-2 sm:mt-3">Number of all transactions</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl sm:rounded-2xl shadow-sm border border-purple-200 p-4 sm:p-6 transition-transform duration-200 hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-purple-700 mb-1">Paid</p>
                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
                            {{ $transactions->where('status','paid')->count() }}
                        </h3>
                    </div>
                    <div class="p-2 sm:p-3 bg-purple-600 rounded-lg sm:rounded-xl">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-purple-600 mt-2 sm:mt-3">Successfully paid transactions</p>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl sm:rounded-2xl shadow-sm border border-amber-200 p-4 sm:p-6 transition-transform duration-200 hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm font-medium text-amber-700 mb-1">Pending</p>
                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">
                            {{ $transactions->where('status','!=','paid')->count() }}
                        </h3>
                    </div>
                    <div class="p-2 sm:p-3 bg-amber-600 rounded-lg sm:rounded-xl">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-amber-600 mt-2 sm:mt-3">Transactions awaiting payment</p>
            </div>
        </div>

        {{-- Search and Quick Actions --}}
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-200 p-3 sm:p-4 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('admin.account.report') }}" id="searchForm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search transactions, IDs, or remarks..." 
                                   class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            @if(request('search'))
                            <button type="button" onclick="clearSearch()" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <button type="button" onclick="toggleAdvancedFilters()"
                                class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200 inline-flex items-center">
                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Advanced
                        </button>
                        <button type="submit" 
                                class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200 inline-flex items-center">
                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                    </div>
                </div>

                {{-- Advanced Filters (Hidden by default) --}}
                <div id="advancedFilters" class="hidden mt-4 pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="">All Status</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Payment Mode</label>
                            <select name="payment_mode" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="">All Modes</option>
                                <option value="cash" {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ request('payment_mode') == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="upi" {{ request('payment_mode') == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="bank_transfer" {{ request('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" name="from_date" value="{{ request('from_date') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" name="to_date" value="{{ request('to_date') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="clearFilters()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 mr-2">
                            Clear All
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Active Filters --}}
        @if(request()->has('search') || request()->has('status') || request()->has('payment_mode') || request()->has('from_date') || request()->has('to_date'))
        <div class="mb-4">
            <div class="flex flex-wrap gap-2">
                <span class="text-xs text-gray-600">Active filters:</span>
                @if(request('search'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Search: "{{ request('search') }}"
                    <button onclick="removeFilter('search')" class="ml-1.5 text-blue-600 hover:text-blue-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif
                @if(request('status'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Status: {{ ucfirst(request('status')) }}
                    <button onclick="removeFilter('status')" class="ml-1.5 text-green-600 hover:text-green-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif
                @if(request('payment_mode'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    Payment: {{ ucfirst(request('payment_mode')) }}
                    <button onclick="removeFilter('payment_mode')" class="ml-1.5 text-purple-600 hover:text-purple-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif
                @if(request('from_date') || request('to_date'))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                    Date: {{ request('from_date') ?: 'Start' }} to {{ request('to_date') ?: 'End' }}
                    <button onclick="removeDateFilters()" class="ml-1.5 text-amber-600 hover:text-amber-800">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
                @endif
            </div>
        </div>
        @endif

        {{-- Table --}}
        <div id="reportArea" class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Transaction Details</h3>
                    <span class="text-xs sm:text-sm text-gray-500">
                        Showing {{ $transactions->count() }} transaction{{ $transactions->count() !== 1 ? 's' : '' }}
                        @if($transactions->isEmpty())
                        - No transactions found
                        @endif
                    </span>
                </div>
            </div>
            
            @if($transactions->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transaction ID
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Module
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount (₹)
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                          
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $i => $t)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $i + 1 }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-7 w-7 sm:h-8 sm:w-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2 sm:mr-3">
                                        <svg class="h-3 w-3 sm:h-4 sm:w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs sm:text-sm font-medium text-gray-900 font-mono">
                                            {{ $t->transaction_id }}
                                        </div>
                                        @if($t->remarks)
                                        <div class="text-xs text-gray-500 truncate max-w-[120px] sm:max-w-[200px]">
                                            {{ $t->remarks }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ ucwords(str_replace('_',' ',$t->module)) }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 capitalize">
                                {{ $t->transaction_type }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 capitalize">
                                <div class="flex items-center">
                                    @php
                                        $paymentColors = [
                                            'cash' => 'bg-green-400',
                                            'card' => 'bg-blue-400',
                                            'upi' => 'bg-purple-400',
                                            'bank_transfer' => 'bg-indigo-400'
                                        ];
                                        $color = $paymentColors[$t->payment_mode] ?? 'bg-gray-400';
                                    @endphp
                                    <span class="inline-block w-2 h-2 rounded-full {{ $color }} mr-2"></span>
                                    {{ $t->payment_mode }}
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900 text-right amount-cell">
                                ₹{{ number_format($t->amount, 2) }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $t->status=='paid'?'bg-green-100 text-green-800':'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($t->transaction_date)->format('d M Y') }}
                                </div>
                            </td>
                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transactions->hasPages())
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-xs sm:text-sm text-gray-700">
                        Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} results
                    </div>
                    <div class="flex items-center justify-center sm:justify-end space-x-1">
                        {{ $transactions->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
            @endif

            @else
            <div class="px-4 sm:px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria</p>
                <div class="mt-6">
                    <button onclick="clearFilters()"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Clear All Filters
                    </button>
                </div>
            </div>
            @endif
        </div>

        {{-- Footer Notes --}}
        <div class="mt-4 sm:mt-6 text-center text-xs sm:text-sm text-gray-500">
            <p>Report generated on {{ now()->format('d M Y, h:i A') }} • Data refreshes every 15 minutes</p>
        </div>

    </div>
</div>

{{-- CSS Fixes --}}
<style>
    /* Ensure proper font rendering for PDF */
    .amount-cell {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        font-feature-settings: "tnum";
        font-variant-numeric: tabular-nums;
    }
</style>

{{-- Scripts --}}
<script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<script>
// Apply time filter
function applyFilter() {
    let filter = document.getElementById('filter').value;
    let url = new URL(window.location.href);
    filter ? url.searchParams.set('filter', filter) : url.searchParams.delete('filter');
    window.location.href = url;
}

// Toggle advanced filters
function toggleAdvancedFilters() {
    const filters = document.getElementById('advancedFilters');
    filters.classList.toggle('hidden');
}

// Clear search
function clearSearch() {
    const url = new URL(window.location.href);
    url.searchParams.delete('search');
    window.location.href = url;
}

// Remove specific filter
function removeFilter(filterName) {
    const url = new URL(window.location.href);
    url.searchParams.delete(filterName);
    window.location.href = url;
}

// Remove date filters
function removeDateFilters() {
    const url = new URL(window.location.href);
    url.searchParams.delete('from_date');
    url.searchParams.delete('to_date');
    window.location.href = url;
}

// Clear all filters
function clearFilters() {
    const url = new URL(window.location.href);
    const params = ['search', 'status', 'payment_mode', 'from_date', 'to_date', 'filter'];
    params.forEach(param => url.searchParams.delete(param));
    window.location.href = url;
}

// PDF Export - Manual Table Data Method for Reliable Rendering
function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape', 'pt', 'a4');

    // Set font to helvetica (most compatible)
    doc.setFont("helvetica");

    // Title
    doc.setFontSize(20);
    doc.setTextColor(37, 99, 235);
    doc.text("Transaction Report - Hospital Management System", 40, 40);

    // Subtitle
    doc.setFontSize(11);
    doc.setTextColor(75, 85, 99);
    doc.text(`Generated on: ${new Date().toLocaleDateString('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })}`, 40, 60);

    // Summary section
    doc.setFontSize(12);
    doc.setTextColor(0, 0, 0);
    doc.text("Summary:", 40, 85);
    doc.setFontSize(10);
    doc.text(`Total Amount: Rs. {{ number_format($transactions->sum('amount'), 2) }}`, 40, 100);
    doc.text(`Total Transactions: {{ $transactions->count() }}`, 40, 115);
    doc.text(`Paid Transactions: {{ $transactions->where('status','paid')->count() }}`, 40, 130);
    doc.text(`Pending Transactions: {{ $transactions->where('status','!=','paid')->count() }}`, 40, 145);

    // Prepare table data - Manual approach for better control
    const head = [
        ['Sr No.', 'Transaction ID', 'Module', 'Type', 'Payment Mode', 'Amount (Rs.)', 'Status', 'Date']
    ];

    const body = [];
    @foreach($transactions as $i => $t)
    body.push([
        '{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $i + 1 }}',
        '{{ $t->transaction_id }}',
        '{{ ucwords(str_replace("_"," ",$t->module)) }}',
        '{{ ucfirst($t->transaction_type) }}',
        '{{ ucfirst($t->payment_mode) }}',
        'Rs. {{ number_format($t->amount, 2) }}',
        '{{ ucfirst($t->status) }}',
        '{{ \Carbon\Carbon::parse($t->transaction_date)->format("d M Y") }}'
    ]);
    @endforeach

    // Generate table
    doc.autoTable({
        head: head,
        body: body,
        startY: 165,
        theme: 'striped',
        styles: {
            fontSize: 8,
            font: 'helvetica',
            cellPadding: 4,
            lineColor: [200, 200, 200],
            lineWidth: 0.5,
            textColor: [0, 0, 0]
        },
        headStyles: {
            fillColor: [31, 41, 55],
            textColor: [255, 255, 255],
            fontStyle: 'bold',
            fontSize: 9
        },
        tableWidth: 'auto'
    });

    // Add page numbers
    const pageCount = doc.internal.getNumberOfPages();
    for(let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(10);
        doc.setTextColor(100, 100, 100);
        doc.text(
            `Page ${i} of ${pageCount}`,
            doc.internal.pageSize.width - 100,
            doc.internal.pageSize.height - 20
        );
    }

    // Save PDF
    const filename = `Transaction_Report_${new Date().toISOString().split('T')[0]}.pdf`;
    doc.save(filename);
}

// Alternative: PDF Export using HTML TABLE method (if above doesn't work)
function exportPDFAlternative() {
    // Get the table HTML
    const table = document.querySelector('#reportArea table');
    if (!table) {
        alert('No data to export');
        return;
    }
    
    // Create a temporary clone to avoid affecting the original
    const tempTable = table.cloneNode(true);
    
    // Remove any rupee symbols from amount cells to prevent corruption
    const amountCells = tempTable.querySelectorAll('td:nth-child(6), th:nth-child(6)');
    amountCells.forEach(cell => {
        // Remove ₹ symbol and keep only numbers
        cell.textContent = cell.textContent.replace('₹', '').trim();
    });
    
    // Create PDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape', 'pt', 'a4');
    
    // Add title
    doc.setFontSize(20);
    doc.setTextColor(37, 99, 235);
    doc.text("Transaction Report - Hospital Management System", 40, 40);
    
    // Add subtitle
    doc.setFontSize(11);
    doc.setTextColor(75, 85, 99);
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 40, 60);
    
    // Convert table to PDF
    doc.autoTable({
        html: tempTable,
        startY: 80,
        theme: 'grid',
        styles: { 
            fontSize: 8,
            cellPadding: 4
        },
        headStyles: { 
            fillColor: [31, 41, 55],
            textColor: [255, 255, 255]
        }
    });
    
    // Save PDF
    doc.save('Transaction_Report.pdf');
}

// Excel Export
function exportExcel() {
    // Get table
    const table = document.querySelector('#reportArea table');
    if (!table) {
        alert('No data to export');
        return;
    }
    
    // Clone table to avoid modifying original
    const tempTable = table.cloneNode(true);
    
    // Remove rupee symbols from amount column for cleaner Excel export
    const amountHeaders = tempTable.querySelectorAll('th:nth-child(6)');
    const amountCells = tempTable.querySelectorAll('td:nth-child(6)');
    
    amountHeaders.forEach(header => {
        header.textContent = 'Amount';
    });
    
    amountCells.forEach(cell => {
        cell.textContent = cell.textContent.replace('₹', '').trim();
    });
    
    // Create workbook
    const wb = XLSX.utils.table_to_book(tempTable, { 
        sheet: "Transactions",
        raw: true 
    });
    
    // Add metadata
    if (!wb.Props) wb.Props = {};
    wb.Props.Title = "Transaction Report";
    wb.Props.Author = "Hospital Management System";
    wb.Props.CreatedDate = new Date();
    
    // Save file
    const filename = `Transaction_Report_${new Date().toISOString().split('T')[0]}.xlsx`;
    XLSX.writeFile(wb, filename);
}

// Initialize date inputs with default values
document.addEventListener('DOMContentLoaded', function() {
    // Set default date range to last 30 days if no dates are selected
    const fromDateInput = document.querySelector('input[name="from_date"]');
    const toDateInput = document.querySelector('input[name="to_date"]');
    
    if (fromDateInput && !fromDateInput.value) {
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
        fromDateInput.value = thirtyDaysAgo.toISOString().split('T')[0];
    }
    
    if (toDateInput && !toDateInput.value) {
        toDateInput.value = new Date().toISOString().split('T')[0];
    }
    
    // Submit form on filter change
    document.getElementById('filter').addEventListener('change', function() {
        applyFilter();
    });
});
</script>
@endsection