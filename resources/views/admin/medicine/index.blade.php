@php
$layout = auth('pharmacist')->check() ? 'layouts.pharmacist' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        Medicine Management
                    </h1>
                    <p class="text-gray-600 mt-1">Manage all medicines across pharmacy stores</p>
                </div>
                
                <!-- Add Medicine Button -->
                <a href="{{ route('admin.medicine.create') }}"
                   class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Medicine
                </a>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Medicines</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">
                                {{ $medicines->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Medicines</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">
                                {{ $medicines->where('status', 1)->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Low Stock (< 10)</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">
                                {{ $medicines->where('stock', '<', 10)->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-yellow-50 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0l-7.244 7.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Out of Stock</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">
                                {{ $medicines->where('stock', 0)->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-red-50 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-green-800">{{ session('success') }}</p>
                        <p class="text-sm text-green-700 mt-1">The medicine has been updated successfully.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow border border-gray-200 p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <!-- Search -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           placeholder="Search medicines by name, brand, or store..."
                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                           id="searchInput">
                </div>
                
                <!-- Filters -->
                <div class="flex gap-3">
                    <select class="px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 text-sm" id="storeFilter">
                        <option value="">All Stores</option>
                        @foreach($medicines->unique('store_id')->pluck('store') as $store)
                            @if($store)
                                <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                            @endif
                        @endforeach
                    </select>
                    
                    <select class="px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 text-sm" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="1">Active Only</option>
                        <option value="0">Inactive Only</option>
                    </select>
                    
                    <button class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium text-sm transition duration-200 flex items-center" id="clearFilters">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">All Medicines</h3>
                    <div class="text-sm text-gray-500">
                        Showing {{ $medicines->count() }} medicines
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>#</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Medicine Details
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Store
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock & Pricing
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($medicines as $medicine)
                        <tr class="hover:bg-gray-50 transition duration-150 medicine-row"
                            data-store="{{ $medicine->store_id }}"
                            data-status="{{ $medicine->status }}"
                            data-name="{{ strtolower($medicine->medicine_name) }}"
                            data-brand="{{ strtolower($medicine->brand ?? '') }}"
                            data-category="{{ strtolower($medicine->category ?? '') }}">
                            <!-- Serial Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $loop->iteration }}
                                </div>
                            </td>
                            
                            <!-- Medicine Details -->
                            <td class="px-6 py-4">
                                <div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            @if($medicine->image && Storage::exists('public/' . $medicine->image))
                                                <img src="{{ asset('storage/' . $medicine->image) }}" 
                                                     alt="{{ $medicine->medicine_name }}"
                                                     class="h-8 w-8 rounded-lg object-cover">
                                            @else
                                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 medicine-name">
                                                {{ $medicine->medicine_name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $medicine->brand ?? 'No brand' }}
                                                @if($medicine->category)
                                                    • {{ $medicine->category }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Store -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $medicine->store->store_name ?? 'No store' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $medicine->store->owner_name ?? 'No owner' }}
                                </div>
                            </td>
                            
                            <!-- Stock & Pricing -->
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Stock:</span>
                                        <span class="text-sm font-medium {{ $medicine->stock < 10 ? 'text-red-600' : 'text-gray-900' }}">
                                            {{ $medicine->stock }} units
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Price:</span>
                                        <span class="text-sm font-bold text-green-600">
                                            ₹{{ number_format($medicine->sale_price, 2) }}
                                        </span>
                                    </div>
                                    @if($medicine->batch_no)
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        Batch: {{ $medicine->batch_no }}
                                    </div>
                                    @endif
                                    @if($medicine->expiry_date)
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Exp: {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('M Y') }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($medicine->status)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <span class="w-2 h-2 bg-gray-500 rounded-full mr-1.5"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- View -->
                                    <!-- <a href="{{ route('admin.medicine.show', $medicine->id) }}"
                                       class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition duration-200"
                                       title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a> -->
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('admin.medicine.edit', $medicine->id) }}"
                                       class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded-lg transition duration-200"
                                       title="Edit Medicine">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Delete -->
                                    <form action="{{ route('admin.medicine.destroy', $medicine->id) }}" 
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirmDelete(event, '{{ $medicine->medicine_name }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition duration-200"
                                                title="Delete Medicine">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No medicines found</h3>
                                    <p class="text-gray-500 mb-4">Get started by adding your first medicine</p>
                                    <a href="{{ route('admin.medicine.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Add Medicine
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <!-- <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-900">Need to add medicine?</p>
                        <a href="{{ route('admin.medicine.create') }}" class="text-sm text-blue-600 hover:text-blue-800 mt-1 block">
                            Create new medicine →
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-100">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-900">Export medicine list</p>
                        <button class="text-sm text-green-600 hover:text-green-800 mt-1 block">
                            Download CSV report →
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl p-4 border border-purple-100">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-purple-900">Low stock alert</p>
                        <a href="#" class="text-sm text-purple-600 hover:text-purple-800 mt-1 block low-stock-link">
                            View {{ $medicines->where('stock', '<', 10)->count() }} items →
                        </a>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<script>
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const storeFilter = document.getElementById('storeFilter');
        const statusFilter = document.getElementById('statusFilter');
        const clearFilters = document.getElementById('clearFilters');
        const medicineRows = document.querySelectorAll('.medicine-row');
        const lowStockLink = document.querySelector('.low-stock-link');
        
        // Function to filter rows
        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStore = storeFilter.value;
            const selectedStatus = statusFilter.value;
            
            medicineRows.forEach(row => {
                const storeId = row.getAttribute('data-store');
                const status = row.getAttribute('data-status');
                const name = row.getAttribute('data-name');
                const brand = row.getAttribute('data-brand');
                const category = row.getAttribute('data-category');
                
                // Check search term
                const matchesSearch = searchTerm === '' || 
                    name.includes(searchTerm) || 
                    brand.includes(searchTerm) || 
                    category.includes(searchTerm);
                
                // Check store filter
                const matchesStore = selectedStore === '' || storeId === selectedStore;
                
                // Check status filter
                const matchesStatus = selectedStatus === '' || status === selectedStatus;
                
                // Show/hide row based on filters
                row.style.display = (matchesSearch && matchesStore && matchesStatus) ? '' : 'none';
            });
        }
        
        // Event listeners for filtering
        if (searchInput) {
            searchInput.addEventListener('keyup', filterRows);
        }
        
        if (storeFilter) {
            storeFilter.addEventListener('change', filterRows);
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', filterRows);
        }
        
        // Clear filters
        if (clearFilters) {
            clearFilters.addEventListener('click', function() {
                searchInput.value = '';
                storeFilter.value = '';
                statusFilter.value = '';
                filterRows();
            });
        }
        
        // Low stock link filter
        if (lowStockLink) {
            lowStockLink.addEventListener('click', function(e) {
                e.preventDefault();
                statusFilter.value = '1'; // Active only
                searchInput.value = '';
                storeFilter.value = '';
                
                // Highlight low stock rows
                medicineRows.forEach(row => {
                    const stockCell = row.querySelector('.text-red-600');
                    if (stockCell) {
                        row.style.display = '';
                        row.classList.add('bg-yellow-50');
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        
        // Add animation to table rows
        medicineRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
            row.classList.add('animate-fadeIn');
        });
        
        // Stock level indicators
        const stockCells = document.querySelectorAll('.text-red-600');
        stockCells.forEach(cell => {
            const stockText = cell.textContent;
            const stockValue = parseInt(stockText);
            if (stockValue < 5) {
                cell.classList.add('font-bold');
                const row = cell.closest('tr');
                row.classList.add('bg-red-50');
            } else if (stockValue < 10) {
                cell.classList.add('font-medium');
                const row = cell.closest('tr');
                row.classList.add('bg-yellow-50');
            }
        });
    });
    
    // Delete confirmation
    function confirmDelete(event, medicineName) {
        event.preventDefault();
        
        if (confirm(`Are you sure you want to delete "${medicineName}"? This action cannot be undone.`)) {
            event.target.closest('form').submit();
        }
        
        return false;
    }
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
        opacity: 0;
    }
    
    /* Custom scrollbar for table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Hover effects */
    tr:hover {
        background-color: #f9fafb;
    }
    
    /* Focus styles */
    button:focus, a:focus, input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Stock level colors */
    .bg-red-50 {
        background-color: #fef2f2;
    }
    
    .bg-yellow-50 {
        background-color: #fffbeb;
    }
</style>
@endsection