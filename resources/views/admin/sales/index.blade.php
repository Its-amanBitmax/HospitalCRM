@php
$layout = auth('pharmacist')->check() ? 'layouts.pharmacist' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="container">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Sales / Billing List</h1>
                    <p class="text-gray-600 mt-1">Manage all sales transactions</p>
                </div>
                
                <a href="{{ route('admin.sales.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Sale
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Sales</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="total-sales">₹{{ number_format($sales->sum('grand_total'), 2) }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="total-orders">{{ $sales->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Cash Payments</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="cash-payments">{{ $sales->where('payment_method', 'cash')->count() }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Digital Payments</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="digital-payments">{{ $sales->whereIn('payment_method', ['upi', 'card'])->count() }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               id="search-input"
                               placeholder="Search by invoice, customer, or store..." 
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <select id="store-filter" class="px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        <option value="">All Stores</option>
                        @foreach($stores ?? [] as $store)
                            <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                        @endforeach
                    </select>
                    
                    <select id="payment-filter" class="px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        <option value="">All Payments</option>
                        <option value="cash">Cash</option>
                        <option value="upi">UPI</option>
                        <option value="card">Card</option>
                        <option value="credit">Credit</option>
                    </select>
                    
                    <button id="reset-filters" class="px-4 py-2.5 rounded-lg border border-gray-300 hover:bg-gray-50 transition duration-200 text-sm font-medium">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Invoice Details
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Customer & Store
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Amount
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Payment
                            </th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Date & Time
                            </th>
                           
                        </tr>
                    </thead>
                    <tbody id="sales-table-body" class="bg-white divide-y divide-gray-200">
                        @forelse($sales as $sale)
                            <tr class="sale-row hover:bg-gray-50 transition duration-150" 
                                data-invoice="{{ $sale->invoice_no }}"
                                data-customer="{{ strtolower($sale->customer_name ?? '') }}"
                                data-store="{{ $sale->store_id }}"
                                data-payment="{{ $sale->payment_method }}"
                                data-amount="{{ $sale->grand_total }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 row-index">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-gray-900 invoice-no">{{ $sale->invoice_no }}</span>
                                        <span class="text-xs text-gray-500 mt-1">Sale ID: {{ $sale->id }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900 customer-name">
                                            {{ $sale->customer_name ?: 'Walk-in Customer' }}
                                        </span>
                                        <span class="text-sm text-gray-500 mt-1 store-name">
                                            {{ $sale->store->store_name ?? '' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col items-start">
                                        <span class="font-bold text-gray-900 text-lg grand-total">
                                            ₹{{ number_format($sale->grand_total, 2) }}
                                        </span>
                                        <div class="flex gap-2 mt-1">
                                            <span class="text-xs text-gray-500">
                                                Sub: ₹{{ number_format($sale->sub_total, 2) }}
                                            </span>
                                            @if($sale->discount > 0)
                                                <span class="text-xs text-green-600">
                                                    Disc: ₹{{ number_format($sale->discount, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium payment-method
                                            {{ $sale->payment_method == 'cash' ? 'bg-green-100 text-green-800' :
                                               ($sale->payment_method == 'upi' ? 'bg-blue-100 text-blue-800' :
                                               ($sale->payment_method == 'card' ? 'bg-purple-100 text-purple-800' :
                                               'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                        @if($sale->payment_method == 'credit')
                                            <span class="text-xs text-gray-500 mt-1">Due: ₹0.00</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-gray-900">
                                            {{ $sale->created_at->format('d M, Y') }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $sale->created_at->format('h:i A') }}
                                        </span>
                                    </div>
                                </td>

                                
                            </tr>
                        @empty
                            <tr id="no-results">
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No sales found</h3>
                                        <p class="text-gray-500 mb-4">Start by creating your first sale</p>
                                        <a href="{{ route('admin.sales.create') }}"
                                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Create First Sale
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Results Count -->
            @if($sales->count() > 0)
                <div id="results-count" class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-500">
                    Showing {{ $sales->count() }} {{ $sales->count() == 1 ? 'sale' : 'sales' }}
                </div>
            @endif
        </div>

        <!-- Export Options -->
        @if($sales->count() > 0)
            <div class="mt-6 flex justify-end">
                <div class="inline-flex rounded-lg border border-gray-300 overflow-hidden">
                    <button class="px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200 border-r border-gray-300">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export PDF
                    </button>
                    <button class="px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Export Excel
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Store original data for reset
const originalSalesData = @json($sales);
let allRows = [];

function printInvoice(saleId) {
    window.open(`/admin/sales/${saleId}/print`, '_blank');
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all rows
    allRows = Array.from(document.querySelectorAll('.sale-row'));
    
    // Get filter elements
    const searchInput = document.getElementById('search-input');
    const storeFilter = document.getElementById('store-filter');
    const paymentFilter = document.getElementById('payment-filter');
    const resetButton = document.getElementById('reset-filters');
    
    // Add event listeners
    if(searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    
    if(storeFilter) {
        storeFilter.addEventListener('change', filterTable);
    }
    
    if(paymentFilter) {
        paymentFilter.addEventListener('change', filterTable);
    }
    
    if(resetButton) {
        resetButton.addEventListener('click', resetFilters);
    }
    
    // Initial filter
    filterTable();
});

function filterTable() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const selectedStore = document.getElementById('store-filter').value;
    const selectedPayment = document.getElementById('payment-filter').value;
    
    let visibleRows = 0;
    let totalSales = 0;
    let cashPayments = 0;
    let digitalPayments = 0;
    
    allRows.forEach((row, index) => {
        const invoiceNo = row.getAttribute('data-invoice').toLowerCase();
        const customerName = row.getAttribute('data-customer');
        const storeId = row.getAttribute('data-store');
        const paymentMethod = row.getAttribute('data-payment');
        const amount = parseFloat(row.getAttribute('data-amount'));
        
        // Check search filter
        const matchesSearch = searchTerm === '' || 
                            invoiceNo.includes(searchTerm) || 
                            customerName.includes(searchTerm) ||
                            row.querySelector('.store-name').textContent.toLowerCase().includes(searchTerm);
        
        // Check store filter
        const matchesStore = selectedStore === '' || storeId === selectedStore;
        
        // Check payment filter
        const matchesPayment = selectedPayment === '' || paymentMethod === selectedPayment;
        
        // Show/hide row based on filters
        if(matchesSearch && matchesStore && matchesPayment) {
            row.style.display = '';
            row.querySelector('.row-index').textContent = visibleRows + 1;
            visibleRows++;
            
            // Update stats
            totalSales += amount;
            if(paymentMethod === 'cash') cashPayments++;
            if(['upi', 'card'].includes(paymentMethod)) digitalPayments++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update stats cards
    updateStatsCards(visibleRows, totalSales, cashPayments, digitalPayments);
    
    // Show/hide no results message
    const noResults = document.getElementById('no-results');
    if(noResults) {
        noResults.style.display = visibleRows === 0 ? '' : 'none';
    }
    
    // Update results count
    const resultsCount = document.getElementById('results-count');
    if(resultsCount) {
        if(visibleRows === 0) {
            resultsCount.textContent = 'No sales found';
        } else {
            resultsCount.textContent = `Showing ${visibleRows} ${visibleRows === 1 ? 'sale' : 'sales'}`;
        }
    }
}

function updateStatsCards(totalOrders, totalSales, cashCount, digitalCount) {
    const totalSalesEl = document.getElementById('total-sales');
    const totalOrdersEl = document.getElementById('total-orders');
    const cashPaymentsEl = document.getElementById('cash-payments');
    const digitalPaymentsEl = document.getElementById('digital-payments');
    
    if(totalSalesEl) totalSalesEl.textContent = `₹${totalSales.toFixed(2)}`;
    if(totalOrdersEl) totalOrdersEl.textContent = totalOrders;
    if(cashPaymentsEl) cashPaymentsEl.textContent = cashCount;
    if(digitalPaymentsEl) digitalPaymentsEl.textContent = digitalCount;
}

function resetFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('store-filter').value = '';
    document.getElementById('payment-filter').value = '';
    
    filterTable();
}
</script>

<style>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Smooth transitions */
tr {
    transition: all 0.15s ease-in-out;
}

/* Better table row hover */
tbody tr:hover {
    background-color: #f8fafc;
}

/* Animation for filtered rows */
.sale-row {
    transition: opacity 0.3s ease;
}
</style>

@endsection