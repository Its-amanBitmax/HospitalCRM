@php
$layout = auth('pharmacist')->check() ? 'layouts.pharmacist' : 'layouts.layout';
@endphp

@extends($layout)
@section('content')
<div class="min-h-screen ">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Add Inventory Entry
                    </h1>
                    <p class="text-gray-600 mt-1">Manage stock movement and inventory adjustments</p>
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                        New Entry
                    </span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                        Required Fields: *
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <h2 class="text-lg font-semibold text-white">Inventory Entry Form</h2>
                </div>
            </div>

            <!-- Form Content -->
            <form method="POST" action="{{ route('admin.inventory.store') }}" class="p-6 sm:p-8">
                @csrf
                
                <!-- Required Fields Alert -->
                <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-blue-700">All fields are required for inventory tracking</p>
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                            <ul class="mt-1 text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-start">
                                        <span class="inline-block w-1 h-1 bg-red-500 rounded-full mt-1.5 mr-2"></span>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- Store & Medicine Selection -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Store & Medicine Selection
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Store Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Store <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <select name="store_id" required
                                            class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('store_id') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 appearance-none bg-white">
                                        <option value="" selected disabled>Select a store</option>
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                                {{ $store->store_name }} - {{ $store->owner_name ?? 'No owner' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('store_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Medicine Selection -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Medicine <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <select name="medicine_id" required
                                            class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('medicine_id') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 appearance-none bg-white"
                                            id="medicineSelect">
                                        <option value="" selected disabled>Select a medicine</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" 
                                                    data-stock="{{ $medicine->stock }}"
                                                    {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
                                                {{ $medicine->medicine_name }} (Stock: {{ $medicine->stock }})
                                                @if($medicine->brand)
                                                    - {{ $medicine->brand }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('medicine_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <div class="text-xs text-gray-500" id="stockInfo">
                                    Select a medicine to see current stock
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Transaction Details
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- Transaction Type -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Transaction Type <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <select name="type" required
                                            class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 appearance-none bg-white"
                                            id="transactionType">
                                        <option value="IN" {{ old('type') == 'IN' ? 'selected' : '' }}>IN (Add Stock)</option>
                                        <option value="OUT" {{ old('type') == 'OUT' ? 'selected' : '' }}>OUT (Reduce Stock)</option>
                                        <option value="ADJUST" {{ old('type') == 'ADJUST' ? 'selected' : '' }}>ADJUST (Set Stock)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <input type="number" name="quantity" required min="1"
                                           value="{{ old('quantity') }}"
                                           placeholder="Enter quantity"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('quantity') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                           id="quantityInput">
                                </div>
                                @error('quantity')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <div class="text-xs text-gray-500" id="quantityHelp">
                                    Enter the quantity for this transaction
                                </div>
                            </div>

                            <!-- Reference -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Reference Number
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="reference"
                                           value="{{ old('reference') }}"
                                           placeholder="e.g., PO-123, INV-456"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                                <p class="text-xs text-gray-500">Optional: Purchase order or invoice number</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Additional Information
                        </h3>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Notes (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <textarea name="note" rows="4"
                                          placeholder="Enter any additional notes about this inventory transaction..."
                                          class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 resize-none"
                                          >{{ old('note') }}</textarea>
                            </div>
                            <p class="text-xs text-gray-500">Add reason for adjustment, supplier details, or other relevant information</p>
                        </div>
                    </div>

                    <!-- Calculation Preview -->
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Stock Calculation Preview
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="bg-white p-3 rounded-lg border border-blue-100">
                                <div class="text-gray-500">Current Stock</div>
                                <div class="text-lg font-semibold text-gray-900" id="currentStock">-</div>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-blue-100">
                                <div class="text-gray-500">Transaction Type</div>
                                <div class="text-lg font-semibold text-gray-900" id="previewType">-</div>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-blue-100">
                                <div class="text-gray-500">New Stock After</div>
                                <div class="text-lg font-semibold text-green-700" id="newStock">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('admin.inventory.index') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Inventory
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Inventory Entry
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Tips -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-800">Inventory Management Tips</p>
                    <ul class="mt-1 text-sm text-blue-700 space-y-1">
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Use <strong>IN</strong> for stock additions (purchases, returns)
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Use <strong>OUT</strong> for stock reductions (sales, damages)
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Use <strong>ADJUST</strong> to set exact stock (corrections, audits)
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Always add reference numbers for tracking and audit purposes
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar for textareas */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    /* Focus styles */
    input:focus, textarea:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Smooth transitions */
    input, textarea, select, button {
        transition: all 0.2s ease-in-out;
    }
    
    /* Error field styling */
    .border-red-500:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
</style>

<script>
    // Stock calculation and validation
    document.addEventListener('DOMContentLoaded', function() {
        const medicineSelect = document.getElementById('medicineSelect');
        const transactionType = document.getElementById('transactionType');
        const quantityInput = document.getElementById('quantityInput');
        const currentStockEl = document.getElementById('currentStock');
        const previewTypeEl = document.getElementById('previewType');
        const newStockEl = document.getElementById('newStock');
        const stockInfoEl = document.getElementById('stockInfo');
        const quantityHelpEl = document.getElementById('quantityHelp');
        
        let currentStock = 0;
        let selectedType = transactionType.value;
        let quantity = 0;
        
        // Update stock info when medicine is selected
        medicineSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            currentStock = parseInt(selectedOption.dataset.stock) || 0;
            
            currentStockEl.textContent = currentStock;
            stockInfoEl.textContent = `Current stock: ${currentStock} units`;
            stockInfoEl.className = 'text-xs ' + (currentStock < 10 ? 'text-red-500 font-medium' : 'text-gray-500');
            
            updateStockPreview();
        });
        
        // Update when transaction type changes
        transactionType.addEventListener('change', function() {
            selectedType = this.value;
            updateTransactionTypeInfo();
            updateStockPreview();
        });
        
        // Update when quantity changes
        quantityInput.addEventListener('input', function() {
            quantity = parseInt(this.value) || 0;
            updateStockPreview();
            
            // Validate quantity for OUT transactions
            if (selectedType === 'OUT' && quantity > currentStock) {
                this.classList.add('border-red-500', 'bg-red-50');
                quantityHelpEl.textContent = `Cannot reduce more than current stock (${currentStock})`;
                quantityHelpEl.classList.add('text-red-500');
            } else {
                this.classList.remove('border-red-500', 'bg-red-50');
                quantityHelpEl.textContent = 'Enter the quantity for this transaction';
                quantityHelpEl.classList.remove('text-red-500');
            }
        });
        
        // Update transaction type info display
        function updateTransactionTypeInfo() {
            let typeText = '';
            let typeColor = '';
            
            switch(selectedType) {
                case 'IN':
                    typeText = 'Stock Addition (+ IN)';
                    typeColor = 'text-green-600';
                    previewTypeEl.className = 'text-lg font-semibold ' + typeColor;
                    previewTypeEl.textContent = typeText;
                    break;
                case 'OUT':
                    typeText = 'Stock Reduction (- OUT)';
                    typeColor = 'text-red-600';
                    previewTypeEl.className = 'text-lg font-semibold ' + typeColor;
                    previewTypeEl.textContent = typeText;
                    break;
                case 'ADJUST':
                    typeText = 'Stock Adjustment (= ADJUST)';
                    typeColor = 'text-blue-600';
                    previewTypeEl.className = 'text-lg font-semibold ' + typeColor;
                    previewTypeEl.textContent = typeText;
                    break;
            }
        }
        
        // Calculate and update stock preview
        function updateStockPreview() {
            if (!currentStock && currentStock !== 0) {
                newStockEl.textContent = '-';
                return;
            }
            
            let newStock = currentStock;
            
            switch(selectedType) {
                case 'IN':
                    newStock = currentStock + quantity;
                    newStockEl.textContent = newStock;
                    newStockEl.className = 'text-lg font-semibold text-green-700';
                    break;
                case 'OUT':
                    newStock = currentStock - quantity;
                    newStockEl.textContent = newStock;
                    newStockEl.className = newStock < 0 ? 'text-lg font-semibold text-red-600' : 'text-lg font-semibold text-orange-600';
                    break;
                case 'ADJUST':
                    newStock = quantity;
                    newStockEl.textContent = newStock;
                    newStockEl.className = 'text-lg font-semibold text-blue-700';
                    break;
            }
        }
        
        // Form validation before submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            // Validate OUT transactions
            if (selectedType === 'OUT' && quantity > currentStock) {
                e.preventDefault();
                alert(`Cannot reduce ${quantity} units when current stock is only ${currentStock}.`);
                quantityInput.focus();
                return false;
            }
            
            // Validate ADJUST transactions
            if (selectedType === 'ADJUST' && quantity < 0) {
                e.preventDefault();
                alert('Stock quantity cannot be negative.');
                quantityInput.focus();
                return false;
            }
            
            // Validate medicine selection
            if (!medicineSelect.value) {
                e.preventDefault();
                alert('Please select a medicine.');
                medicineSelect.focus();
                return false;
            }
            
            return true;
        });
        
        // Initialize on page load
        updateTransactionTypeInfo();
        
        // Auto-populate old values if validation failed
        const oldMedicineId = "{{ old('medicine_id') }}";
        if (oldMedicineId && medicineSelect) {
            medicineSelect.value = oldMedicineId;
            medicineSelect.dispatchEvent(new Event('change'));
        }
        
        const oldQuantity = "{{ old('quantity') }}";
        if (oldQuantity && quantityInput) {
            quantityInput.value = oldQuantity;
            quantityInput.dispatchEvent(new Event('input'));
        }
        
        const oldType = "{{ old('type') }}";
        if (oldType && transactionType) {
            transactionType.value = oldType;
            transactionType.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection