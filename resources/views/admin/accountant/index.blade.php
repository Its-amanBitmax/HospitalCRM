@php
$layout = auth('accountant')->check() ? 'layouts.accountant' : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'Transactions Dashboard')

@section('content')
<div class="container max-w-[960px]">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Transactions Dashboard</h1>
                <p class="text-gray-600 mt-1">View and manage all financial transactions</p>
            </div>
            <a href="{{ route('admin.transctions.create') }}"
               class="inline-flex items-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Transaction
            </a>
        </div>
        <div class="mt-6 border-b border-gray-200"></div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Total Transactions</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $transactions->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Total Credit</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($transactions->where('transaction_type', 'credit')->sum('amount'), 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-600">Total Debit</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($transactions->where('transaction_type', 'debit')->sum('amount'), 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600">Net Balance</p>
                    @php
                        $creditTotal = $transactions->where('transaction_type', 'credit')->sum('amount');
                        $debitTotal = $transactions->where('transaction_type', 'debit')->sum('amount');
                        $netBalance = $creditTotal - $debitTotal;
                    @endphpQ
                    <p class="text-2xl font-bold text-gray-800 mt-2">₹{{ number_format($netBalance, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 mb-6 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                </h3>
                <button type="button" onclick="resetFilters()" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset
                </button>
            </div>
            
            <form id="filterForm" method="GET" action="{{ route('admin.transctions.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Module Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                        <select name="module" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Modules</option>
                            <option value="patients" {{ request('module') == 'patients' ? 'selected' : '' }}>Patients</option>
                            <option value="pharmacy" {{ request('module') == 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                            <option value="doctors" {{ request('module') == 'doctors' ? 'selected' : '' }}>Doctors</option>
                            <option value="nurses" {{ request('module') == 'nurses' ? 'selected' : '' }}>Nurses</option>
                            <option value="blood_bank" {{ request('module') == 'blood_bank' ? 'selected' : '' }}>Blood Bank</option>
                            <option value="employee" {{ request('module') == 'employee' ? 'selected' : '' }}>Employee</option>
                            <option value="services" {{ request('module') == 'services' ? 'selected' : '' }}>Services</option>
                            <option value="lab" {{ request('module') == 'lab' ? 'selected' : '' }}>Lab</option>
                            <option value="reception" {{ request('module') == 'reception' ? 'selected' : '' }}>Reception</option>
                            <option value="accountant" {{ request('module') == 'accountant' ? 'selected' : '' }}>Accountant</option>
                        </select>
                    </div>

                    <!-- Transaction Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="transaction_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Types</option>
                            <option value="credit" {{ request('transaction_type') == 'credit' ? 'selected' : '' }}>Credit (Income)</option>
                            <option value="debit" {{ request('transaction_type') == 'debit' ? 'selected' : '' }}>Debit (Expense)</option>
                        </select>
                    </div>

                    <!-- Payment Mode Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Mode</label>
                        <select name="payment_mode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Modes</option>
                            <option value="cash" {{ request('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="upi" {{ request('payment_mode') == 'upi' ? 'selected' : '' }}>UPI</option>
                            <option value="card" {{ request('payment_mode') == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="online" {{ request('payment_mode') == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Date Range Filters -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="amount_high" {{ request('sort') == 'amount_high' ? 'selected' : '' }}>Amount (High to Low)</option>
                            <option value="amount_low" {{ request('sort') == 'amount_low' ? 'selected' : '' }}>Amount (Low to High)</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        Showing {{ $transactions->count() }} transactions
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Apply Filters
                        </button>
                        @if(request()->hasAny(['module', 'transaction_type', 'payment_mode', 'status', 'from_date', 'to_date', 'sort']))
                        <a href="{{ route('admin.transctions.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Transaction Records</h3>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">Showing {{ $transactions->count() }} records</span>
                </div>
            </div>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Mode</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 flex items-center justify-center rounded-md 
                                                @if($transaction->module == 'patients') bg-blue-100 text-blue-800
                                                @elseif($transaction->module == 'pharmacy') bg-green-100 text-green-800
                                                @elseif($transaction->module == 'doctors') bg-purple-100 text-purple-800
                                                @elseif($transaction->module == 'nurses') bg-pink-100 text-pink-800
                                                @else bg-gray-100 text-gray-800 @endif
                                                mr-3">
                                                {{ substr(ucfirst($transaction->module), 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ ucfirst(str_replace('_', ' ', $transaction->module)) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium 
                                        @if($transaction->transaction_type == 'credit') text-green-600
                                        @else text-red-600 @endif">
                                        ₹{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($transaction->transaction_type == 'credit') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($transaction->transaction_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($transaction->payment_mode == 'cash')
                                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            @elseif($transaction->payment_mode == 'upi')
                                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                            @elseif($transaction->payment_mode == 'card')
                                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                            @endif
                                            <span class="text-sm text-gray-900">{{ ucfirst($transaction->payment_mode) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($transaction->status == 'paid') bg-green-100 text-green-800
                                            @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($transaction->status == 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->transaction_date->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-xs truncate" title="{{ $transaction->remarks }}">
                                            {{ $transaction->remarks ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No transactions found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request()->hasAny(['module', 'transaction_type', 'payment_mode', 'status', 'from_date', 'to_date', 'sort']))
                            Try adjusting your filters
                        @else
                            Get started by creating a new transaction
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function resetFilters() {
    document.getElementById('filterForm').reset();
    window.location.href = "{{ route('admin.transctions.index') }}";
}
</script>

<style>
    tr:hover {
        background-color: #f9fafb;
    }
    
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endsection