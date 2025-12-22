@php
$layout = auth('pharmacist')->check() ? 'layouts.pharmacist' : 'layouts.layout';
@endphp

@extends($layout)
@section('content')
<div class="min-h-screen ">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 md:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Inventory Logs</h1>
                    <p class="text-gray-600 mt-1">Track all inventory transactions and stock movements</p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Search Box -->
                    <div class="relative flex-1 sm:flex-none">
                        <input type="text" id="searchInput" placeholder="Search logs..." 
                               class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <!-- Add Entry Button -->
                    <a href="{{ route('admin.inventory.create') }}" 
                       class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Entry
                    </a>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Logs</p>
                            <p class="text-xl font-semibold text-gray-800">{{ $inventories->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stock IN</p>
                            <p class="text-xl font-semibold text-gray-800">
                                {{ $inventories->where('type', 'IN')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-50 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stock OUT</p>
                            <p class="text-xl font-semibold text-gray-800">
                                {{ $inventories->where('type', 'OUT')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Avg Qty</p>
                            <p class="text-xl font-semibold text-gray-800">
                                {{ number_format($inventories->avg('quantity') ?? 0, 1) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="mb-6 bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <h3 class="font-medium text-gray-700">Filters</h3>
                </div>
                <div class="flex flex-wrap gap-3">
                    <!-- Store Filter -->
                    <!-- <select id="storeFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Stores</option>
                        @foreach($stores ?? [] as $store)
                        <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                        @endforeach
                    </select> -->
                    
                    <!-- Type Filter -->
                    <select id="typeFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        <option value="IN">IN</option>
                        <option value="OUT">OUT</option>
                    </select>
                    
                    <!-- Date Filter -->
                    <select id="dateFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Time</option>
                        <option value="7">Last 7 days</option>
                        <option value="30">Last 30 days</option>
                        <option value="90">Last 90 days</option>
                    </select>
                    
                    <!-- Clear Filters Button -->
                    <button id="clearFilters" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Table Container -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Inventory Transactions</h2>
                    <div class="flex items-center space-x-3">
                        <!-- Record Count -->
                        <!-- <span id="recordCount" class="text-sm text-gray-500">{{ $inventories->count() }} records</span> -->
                        <!-- Export Button -->
                        <!-- <button onclick="exportToCSV()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </button> -->
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable" data-sort="date">
                                <div class="flex items-center">
                                    Date & Time
                                    <svg class="w-4 h-4 ml-1 text-gray-400 sort-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable" data-sort="store">
                                Store
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable" data-sort="medicine">
                                Medicine
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable" data-sort="type">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable" data-sort="quantity">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock Movement
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer sortable" data-sort="reference">
                                Reference
                            </th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTable" class="bg-white divide-y divide-gray-200">
                        @foreach($inventories as $inv)
                        <tr class="hover:bg-gray-50 transition duration-150 inventory-row" 
                            data-store="{{ $inv->store->id ?? '' }}"
                            data-type="{{ $inv->type }}"
                            data-date="{{ $inv->created_at->timestamp }}"
                            data-quantity="{{ $inv->quantity }}"
                            data-medicine="{{ strtolower($inv->medicine->medicine_name ?? '') }}"
                            data-reference="{{ strtolower($inv->reference ?? '') }}"
                            data-row-text="{{ strtolower($inv->store->store_name ?? '') }} {{ strtolower($inv->medicine->medicine_name ?? '') }} {{ strtolower($inv->type) }} {{ $inv->quantity }} {{ strtolower($inv->reference ?? '') }} {{ $inv->created_at->format('Y-m-d') }}">
                            <!-- Date Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $inv->created_at->format('d M, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $inv->created_at->format('h:i A') }}</div>
                            </td>
                            
                            <!-- Store Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-50 rounded-lg mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ $inv->store->store_name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            
                            <!-- Medicine Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $inv->medicine->medicine_name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $inv->medicine->category ?? 'General' }}</div>
                            </td>
                            
                            <!-- Type Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inv->type == 'IN')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    Stock IN
                                </span>
                                @elseif($inv->type == 'OUT')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                    Stock OUT
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                    {{ $inv->type }}
                                </span>
                                @endif
                            </td>
                            
                            <!-- Quantity Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $inv->quantity }}</div>
                                    <span class="ml-2 text-xs text-gray-500">units</span>
                                </div>
                            </td>
                            
                            <!-- Stock Movement Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm text-gray-500 mr-2">{{ $inv->stock_before }}</div>
                                    <svg class="w-4 h-4 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <div class="text-sm font-medium text-gray-900 ml-2">{{ $inv->stock_after }}</div>
                                </div>
                                @php
                                    $maxStock = max($inv->stock_before, $inv->stock_after);
                                    $percentage = $maxStock > 0 ? min(100, ($inv->stock_before / $maxStock) * 100) : 0;
                                @endphp
                                <div class="mt-1 w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </td>
                            
                            <!-- Reference Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inv->reference)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $inv->reference }}
                                </span>
                                @else
                                <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Empty State -->
                <div id="emptyState" class="hidden px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No inventory logs found</h3>
                        <p class="text-gray-500 mb-4">Try adjusting your filters or search terms</p>
                        <button id="clearEmptyState" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                        Showing <span id="showingCount">{{ $inventories->count() }}</span> of 
                        <span id="totalCount">{{ $inventories->count() }}</span> records
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sortable:hover {
    background-color: #f9fafb;
}
.sort-icon.asc {
    transform: rotate(180deg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const storeFilter = document.getElementById('storeFilter');
    const typeFilter = document.getElementById('typeFilter');
    const dateFilter = document.getElementById('dateFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const clearEmptyStateBtn = document.getElementById('clearEmptyState');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');
    const recordCount = document.getElementById('recordCount');
    const showingCount = document.getElementById('showingCount');
    const totalCount = document.getElementById('totalCount');
    const inventoryTable = document.getElementById('inventoryTable');
    
    // Get all rows
    const inventoryRows = document.querySelectorAll('.inventory-row');
    const totalRecords = inventoryRows.length;
    
    // Filter state
    let filterState = {
        store: '',
        type: '',
        date: '',
        search: ''
    };
    
    // Sort state
    let currentSort = { column: null, direction: 'asc' };
    
    // Simple filter function without complex arrays
    function applyFilters() {
        let visibleCount = 0;
        const now = new Date();
        
        inventoryRows.forEach(row => {
            let showRow = true;
            
            // Store filter
            if (filterState.store) {
                const storeId = row.getAttribute('data-store');
                if (storeId !== filterState.store) {
                    showRow = false;
                }
            }
            
            // Type filter
            if (filterState.type && showRow) {
                const type = row.getAttribute('data-type');
                if (type !== filterState.type) {
                    showRow = false;
                }
            }
            
            // Date filter
            if (filterState.date && showRow) {
                const rowDateTimestamp = parseInt(row.getAttribute('data-date')) * 1000;
                const rowDate = new Date(rowDateTimestamp);
                const daysAgo = parseInt(filterState.date);
                const cutoffDate = new Date(now.getTime() - (daysAgo * 24 * 60 * 60 * 1000));
                
                if (rowDate < cutoffDate) {
                    showRow = false;
                }
            }
            
            // Search filter
            if (filterState.search && showRow) {
                const searchText = filterState.search.toLowerCase();
                const rowText = row.getAttribute('data-row-text') || '';
                if (!rowText.includes(searchText)) {
                    showRow = false;
                }
            }
            
            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update counts
        updateCounts(visibleCount);
    }
    
    function updateCounts(visibleCount) {
        // Update record counts
        if (recordCount) {
            recordCount.textContent = `${visibleCount} records`;
        }
        if (showingCount) {
            showingCount.textContent = visibleCount;
        }
        if (totalCount) {
            totalCount.textContent = totalRecords;
        }
        
        // Show/hide empty state
        if (visibleCount === 0 && totalRecords > 0) {
            emptyState.classList.remove('hidden');
            inventoryTable.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            inventoryTable.classList.remove('hidden');
        }
    }
    
    // Setup filter event listeners
    function setupFilterListeners() {
        // Store filter
        if (storeFilter) {
            storeFilter.addEventListener('change', function() {
                filterState.store = this.value;
                applyFilters();
            });
        }
        
        // Type filter
        typeFilter.addEventListener('change', function() {
            filterState.type = this.value;
            applyFilters();
        });
        
        // Date filter
        dateFilter.addEventListener('change', function() {
            filterState.date = this.value;
            applyFilters();
        });
        
        // Clear filters button
        clearFiltersBtn.addEventListener('click', function() {
            filterState = { store: '', type: '', date: '', search: '' };
            if (storeFilter) storeFilter.value = '';
            typeFilter.value = '';
            dateFilter.value = '';
            searchInput.value = '';
            applyFilters();
        });
        
        // Clear filters from empty state
        if (clearEmptyStateBtn) {
            clearEmptyStateBtn.addEventListener('click', function() {
                filterState = { store: '', type: '', date: '', search: '' };
                if (storeFilter) storeFilter.value = '';
                typeFilter.value = '';
                dateFilter.value = '';
                searchInput.value = '';
                applyFilters();
            });
        }
        
        // Search with debouncing
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            filterState.search = e.target.value.toLowerCase();
            
            searchTimeout = setTimeout(() => {
                applyFilters();
            }, 300);
        });
    }
    
    // Setup sort event listeners - SIMPLIFIED
    function setupSortListeners() {
        const sortableHeaders = document.querySelectorAll('.sortable');
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-sort');
                const icon = this.querySelector('.sort-icon');
                
                // Update sort direction
                if (currentSort.column === column) {
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort.column = column;
                    currentSort.direction = 'asc';
                }
                
                // Update icons
                sortableHeaders.forEach(h => {
                    h.querySelector('.sort-icon').classList.remove('asc');
                });
                if (currentSort.direction === 'desc') {
                    icon.classList.add('asc');
                }
                
                // Sort rows
                sortRows(column, currentSort.direction);
            });
        });
    }
    
    function sortRows(column, direction) {
        // Convert NodeList to array for sorting
        const rowsArray = Array.from(inventoryRows);
        
        rowsArray.sort((a, b) => {
            let aValue, bValue;
            
            switch(column) {
                case 'date':
                    aValue = parseInt(a.getAttribute('data-date'));
                    bValue = parseInt(b.getAttribute('data-date'));
                    break;
                case 'quantity':
                    aValue = parseFloat(a.getAttribute('data-quantity'));
                    bValue = parseFloat(b.getAttribute('data-quantity'));
                    break;
                case 'store':
                    aValue = (a.querySelector('td:nth-child(2) span')?.textContent || '').toLowerCase();
                    bValue = (b.querySelector('td:nth-child(2) span')?.textContent || '').toLowerCase();
                    break;
                case 'medicine':
                    aValue = a.getAttribute('data-medicine') || '';
                    bValue = b.getAttribute('data-medicine') || '';
                    break;
                case 'type':
                    aValue = a.getAttribute('data-type') || '';
                    bValue = b.getAttribute('data-type') || '';
                    break;
                case 'reference':
                    aValue = a.getAttribute('data-reference') || '';
                    bValue = b.getAttribute('data-reference') || '';
                    break;
                default:
                    return 0;
            }
            
            if (aValue < bValue) {
                return direction === 'asc' ? -1 : 1;
            } else if (aValue > bValue) {
                return direction === 'asc' ? 1 : -1;
            }
            return 0;
        });
        
        // Reorder rows in table
        rowsArray.forEach(row => {
            inventoryTable.appendChild(row);
        });
        
        // Reapply filters after sorting
        applyFilters();
    }
    
    // Export to CSV function
    window.exportToCSV = function() {
        const rows = [];
        const headers = ['Date', 'Time', 'Store', 'Medicine', 'Type', 'Quantity', 'Stock Before', 'Stock After', 'Reference'];
        rows.push(headers.join(','));
        
        // Get only visible rows
        const visibleRows = Array.from(inventoryRows).filter(row => row.style.display !== 'none');
        
        if (visibleRows.length === 0) {
            alert('No data to export! Please adjust your filters.');
            return;
        }
        
        visibleRows.forEach(row => {
            const rowData = [
                new Date(parseInt(row.getAttribute('data-date')) * 1000).toLocaleDateString(),
                new Date(parseInt(row.getAttribute('data-date')) * 1000).toLocaleTimeString(),
                row.querySelector('td:nth-child(2) span')?.textContent || '',
                row.getAttribute('data-medicine') || '',
                row.getAttribute('data-type') || '',
                row.getAttribute('data-quantity') || '',
                row.querySelector('td:nth-child(6) .text-sm.text-gray-500')?.textContent || '',
                row.querySelector('td:nth-child(6) .text-sm.font-medium')?.textContent || '',
                row.getAttribute('data-reference') || ''
            ];
            rows.push(rowData.map(cell => `"${cell}"`).join(','));
        });
        
        const csvContent = rows.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `inventory_logs_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
    
    // Initialize
    setupFilterListeners();
    setupSortListeners();
    
    // Initial count update
    updateCounts(totalRecords);
});
</script>
@endsection