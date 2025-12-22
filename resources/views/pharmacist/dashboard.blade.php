@extends('layouts.pharmacist')

@section('title', 'Pharmacist Dashboard')

@section('content')

{{-- PAGE HEADER WITH STORE FILTER --}}
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Pharmacy Dashboard</h1>
        <p class="text-gray-500 mt-1">{{ now()->format('l, F j, Y') }}</p>
    </div>
    
    <div class="flex flex-col md:flex-row gap-3 mt-4 md:mt-0">
        {{-- STORE FILTER DROPDOWN --}}
        <div class="flex gap-3">
            <div class="relative">
                <select id="storeFilter" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <option value="">All Stores</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->store_name }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
            
            {{-- TIME FILTER BUTTONS --}}
            <div class="flex gap-2">
                <a href="?filter=today{{ request('store_id') ? '&store_id=' . request('store_id') : '' }}"
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $filter == 'today' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                    Today
                </a>

                <a href="?filter=week{{ request('store_id') ? '&store_id=' . request('store_id') : '' }}"
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $filter == 'week' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                    This Week
                </a>

                <a href="?filter=month{{ request('store_id') ? '&store_id=' . request('store_id') : '' }}"
                   class="px-4 py-2 rounded-lg transition-all duration-200 {{ $filter == 'month' ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                    This Month
                </a>
            </div>
        </div>
    </div>
</div>

{{-- CURRENT STORE INFO --}}
@if(request('store_id'))
    @php
        $currentStore = $stores->firstWhere('id', request('store_id'));
    @endphp
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Viewing: {{ $currentStore->store_name ?? 'Selected Store' }}</h3>
                    <p class="text-sm text-gray-600">Filtered data for selected store</p>
                </div>
            </div>
            <a href="{{ route('pharmacist.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Clear Filter →
            </a>
        </div>
    </div>
@endif

{{-- SUMMARY CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-blue-600">Total Medicines</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalMedicines) }}</p>
                <p class="text-xs text-gray-500 mt-1">Active inventory items</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-red-600">Low Stock</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($lowStockMedicines) }}</p>
                <p class="text-xs text-gray-500 mt-1">&lt; 10 units remaining</p>
            </div>
            <div class="p-3 bg-red-100 rounded-xl">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-green-600">Sales Count</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($salesCount) }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ ucfirst($filter) }} transactions</p>
            </div>
            <div class="p-3 bg-green-100 rounded-xl">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-purple-600">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">₹{{ number_format($salesRevenue, 2) }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ ucfirst($filter) }} earnings</p>
            </div>
            <div class="p-3 bg-purple-100 rounded-xl">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- ADVANCED REVENUE ANALYTICS --}}
<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Revenue Analytics</h3>
            <p class="text-gray-500 text-sm">
                @if(request('store_id'))
                    {{ $currentStore->store_name ?? 'Selected Store' }} - {{ ucfirst($filter) }} Performance
                @else
                    All Stores - {{ ucfirst($filter) }} Performance Overview
                @endif
            </p>
        </div>
        <div class="flex gap-4">
            <div class="text-right">
                <p class="text-2xl font-bold text-gray-800">₹{{ number_format($salesRevenue, 2) }}</p>
                <p class="text-sm text-gray-500">Total Revenue</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-green-600">{{ number_format($salesCount) }}</p>
                <p class="text-sm text-gray-500">Total Sales</p>
            </div>
        </div>
    </div>
    
    {{-- Advanced Revenue Chart with Dual Axis --}}
    <div class="h-80">
        <canvas id="advancedRevenueChart"></canvas>
    </div>
    
    {{-- Revenue Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-100">
        <div class="text-center p-3 bg-blue-50 rounded-xl">
            <p class="text-sm text-gray-500">Daily Average</p>
            <p class="text-xl font-bold text-blue-600">
                ₹{{ $salesCount > 0 ? number_format($salesRevenue / count($labels), 2) : '0.00' }}
            </p>
            <p class="text-xs text-gray-500">Per day</p>
        </div>
        
        <div class="text-center p-3 bg-green-50 rounded-xl">
            <p class="text-sm text-gray-500">Avg Sale Value</p>
            <p class="text-xl font-bold text-green-600">
                ₹{{ $salesCount > 0 ? number_format($salesRevenue / $salesCount, 2) : '0.00' }}
            </p>
            <p class="text-xs text-gray-500">Per transaction</p>
        </div>
        
        <div class="text-center p-3 bg-purple-50 rounded-xl">
            <p class="text-sm text-gray-500">Peak Day</p>
            <p class="text-xl font-bold text-purple-600">
                @if(count($salesData) > 0)
                    ₹{{ number_format(max($salesData), 2) }}
                @else
                    ₹0.00
                @endif
            </p>
            <p class="text-xs text-gray-500">Highest revenue</p>
        </div>
        
        <!-- <div class="text-center p-3 bg-orange-50 rounded-xl">
            <p class="text-sm text-gray-500">Growth Trend</p>
            <p class="text-xl font-bold text-orange-600">
                @if(count($salesData) > 1)
                    @php
                        $first = $salesData[0];
                        $last = $salesData[count($salesData)-1];
                        $growth = $first > 0 ? (($last - $first) / $first * 100) : 0;
                    @endphp
                    {{ number_format($growth, 1) }}%
                @else
                    0%
                @endif
            </p>
            <p class="text-xs text-gray-500">Period change</p>
        </div> -->
    </div>
</div>

{{-- STORE PERFORMANCE ADVANCED ANALYSIS --}}
<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mb-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Store Performance Analysis</h3>
            <p class="text-gray-500 text-sm">Comparative analysis across all stores</p>
        </div>
        <div class="text-sm text-gray-500">
            {{ $storeRevenue->count() }} stores • {{ ucfirst($filter) }}
        </div>
    </div>
    
    {{-- Store Performance Heat Map --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h4 class="font-semibold text-gray-700 mb-4">Performance Metrics</h4>
        <div class="h-64">
            <canvas id="storeHeatMap"></canvas>
        </div>
    </div>
    
    {{-- Store Performance Details --}}
    @if($storeRevenue->count() > 0)
        <div class="mt-6">
            <h4 class="font-semibold text-gray-700 mb-4">Store-wise Performance Details</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Store</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Revenue</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Sales</th>
                            <th class="py-3 px-4 text-left font-semibold text-gray-600">Avg Sale</th>
                           
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($storeRevenue as $store)
                            @php
                                $performanceScore = min(100, ($store->percentage * 1.5) + ($store->sales_count / max($salesCount, 1) * 100));
                                $performanceColor = $performanceScore >= 80 ? 'bg-green-100 text-green-800' : 
                                                   ($performanceScore >= 60 ? 'bg-blue-100 text-blue-800' : 
                                                   ($performanceScore >= 40 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'));
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium text-gray-700">{{ $store->store_name }}</td>
                                <td class="py-3 px-4 font-bold text-gray-800">₹{{ number_format($store->revenue, 2) }}</td>
                                <td class="py-3 px-4">{{ $store->sales_count }}</td>
                                <td class="py-3 px-4">₹{{ number_format($store->avg_sale_value ?? 0, 2) }}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- ROW WITH GRAPH AND RECENT TRANSACTIONS --}}
<div class="flex flex-col lg:flex-row gap-8 mb-8">
    {{-- INVENTORY SUMMARY --}}
    <div class="lg:col-span-11 bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Inventory Overview</h3>
            <div class="text-right">
                <p class="text-2xl font-bold text-gray-800">{{ number_format($inventoryStock) }}</p>
                <p class="text-sm text-gray-500">Total units in stock</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Total Items</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalMedicines) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Adequate Stock</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalMedicines - $lowStockMedicines) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Low Stock</p>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($lowStockMedicines) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inventory Health Chart --}}
        <div class="mt-6">
            <h4 class="font-semibold text-gray-700 mb-4">Stock Health</h4>
            <div class="h-48">
                <canvas id="inventoryHealthChart"></canvas>
            </div>
        </div>
    </div>

    {{-- RECENT TRANSACTIONS --}}
    <div class="lg:col-span-9 bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Recent Transactions</h3>
                <p class="text-gray-500 text-sm">Latest {{ $recentSales->count() }} sales</p>
            </div>
            <a href="#?{{ request('store_id') ? 'store_id=' . request('store_id') : '' }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                View All
            </a>
        </div>

        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
            @forelse($recentSales as $sale)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-blue-50 transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-700">#{{ $sale->invoice_no }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $sale->customer_name ?? 'Walk-in Customer' }}
                                @if($sale->store)
                                    <span class="text-blue-600"> • {{ $sale->store->store_name }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800">₹{{ number_format($sale->grand_total, 2) }}</p>
                        <p class="text-xs text-gray-500">{{ $sale->created_at->format('h:i A') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500">No recent sales found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- CHART SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Store filter functionality
    const storeFilter = document.getElementById('storeFilter');
    if (storeFilter) {
        storeFilter.addEventListener('change', function() {
            const storeId = this.value;
            const currentUrl = new URL(window.location.href);
            const filter = currentUrl.searchParams.get('filter') || 'today';
            
            if (storeId) {
                window.location.href = `?filter=${filter}&store_id=${storeId}`;
            } else {
                window.location.href = `?filter=${filter}`;
            }
        });
    }

    // Advanced Revenue Chart with Dual Axis
    const advancedRevenueCtx = document.getElementById('advancedRevenueChart')?.getContext('2d');
    if (advancedRevenueCtx) {
        const revenueData = @json($salesData);
        const salesCountData = @json($salesCountData);
        const labels = @json($labels);
        
        if (revenueData.length > 0) {
            // Create gradients
            const revenueGradient = advancedRevenueCtx.createLinearGradient(0, 0, 0, 400);
            revenueGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
            revenueGradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');
            
            const salesGradient = advancedRevenueCtx.createLinearGradient(0, 0, 0, 400);
            salesGradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
            salesGradient.addColorStop(1, 'rgba(16, 185, 129, 0.05)');
            
            new Chart(advancedRevenueCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Revenue ₹',
                            data: revenueData,
                            borderColor: 'rgba(59, 130, 246, 1)',
                            backgroundColor: revenueGradient,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2
                        },
                        {
                            label: 'Sales Count',
                            data: salesCountData,
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            yAxisID: 'y1',
                            type: 'bar',
                            backgroundColor: 'rgba(16, 185, 129, 0.3)',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1f2937',
                            bodyColor: '#4b5563',
                            borderColor: '#e5e7eb',
                            borderWidth: 1,
                            padding: 12,
                            boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                            callbacks: {
                                label: function(context) {
                                    if (context.datasetIndex === 0) {
                                        return `Revenue: ₹${context.raw.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
                                    } else {
                                        return `Sales: ${context.raw}`;
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            },
                            ticks: {
                                color: '#6b7280',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                },
                                color: '#3B82F6',
                                font: { size: 11 }
                            },
                            title: {
                                display: true,
                                text: 'Revenue',
                                color: '#3B82F6'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: {
                                color: '#10B981',
                                font: { size: 11 }
                            },
                            title: {
                                display: true,
                                text: 'Sales Count',
                                color: '#10B981'
                            }
                        }
                    }
                }
            });
        }
    }



    // Store Heat Map (Bubble Chart)
    const storeHeatMapCtx = document.getElementById('storeHeatMap')?.getContext('2d');
    if (storeHeatMapCtx) {
        const storeData = @json($storeRevenue);
        
        if (storeData.length > 0) {
            const bubbleData = storeData.map((store, index) => ({
                x: store.sales_count,
                y: store.revenue / Math.max(store.sales_count, 1),
                r: Math.min(50, store.percentage * 2),
                label: store.store_name,
                revenue: store.revenue,
                sales: store.sales_count
            }));
            
            new Chart(storeHeatMapCtx, {
                type: 'bubble',
                data: {
                    datasets: [{
                        label: 'Store Performance',
                        data: bubbleData,
                        backgroundColor: bubbleData.map((_, index) => {
                            const colors = [
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(139, 92, 246, 0.7)',
                                'rgba(245, 158, 11, 0.7)',
                                'rgba(236, 72, 153, 0.7)'
                            ];
                            return colors[index % colors.length];
                        }),
                        borderColor: bubbleData.map((_, index) => {
                            const colors = [
                                'rgba(59, 130, 246, 1)',
                                'rgba(16, 185, 129, 1)',
                                'rgba(139, 92, 246, 1)',
                                'rgba(245, 158, 11, 1)',
                                'rgba(236, 72, 153, 1)'
                            ];
                            return colors[index % colors.length];
                        }),
                        borderWidth: 1
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
                            callbacks: {
                                label: function(context) {
                                    const data = context.raw;
                                    return [
                                        `Store: ${data.label}`,
                                        `Revenue: ₹${data.revenue.toLocaleString(undefined, {minimumFractionDigits: 2})}`,
                                        `Sales: ${data.sales}`,
                                        `Avg Sale: ₹${data.y.toLocaleString(undefined, {minimumFractionDigits: 2})}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Number of Sales',
                                color: '#6b7280',
                                font: { size: 12 }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Average Sale Value (₹)',
                                color: '#6b7280',
                                font: { size: 12 }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });
        }
    }

    // Inventory Health Chart
    const inventoryHealthCtx = document.getElementById('inventoryHealthChart')?.getContext('2d');
    if (inventoryHealthCtx) {
        const adequateStock = {{ $totalMedicines - $lowStockMedicines }};
        const lowStock = {{ $lowStockMedicines }};
        
        new Chart(inventoryHealthCtx, {
            type: 'doughnut',
            data: {
                labels: ['Adequate Stock', 'Low Stock'],
                datasets: [{
                    data: [adequateStock, lowStock],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = {{ $totalMedicines }};
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${context.label}: ${context.raw} items (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

@endsection