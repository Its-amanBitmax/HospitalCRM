@php
$layout = auth('pharmacist')->check() ? 'layouts.pharmacist' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="min-h-screen ">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Medicine
                    </h1>
                    <p class="text-gray-600 mt-1">Update medicine information and details</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                        Medicine ID: {{ $medicine->id }}
                    </span>
                    <span class="px-3 py-1 {{ $medicine->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} text-xs font-medium rounded-full">
                        {{ $medicine->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <h2 class="text-lg font-semibold text-white">Update Medicine Information</h2>
                    </div>
                    <div class="text-sm text-blue-100">
                        Last updated: {{ $medicine->updated_at->format('d M, Y') }}
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form method="POST" action="{{ route('admin.medicine.update', $medicine->id) }}" enctype="multipart/form-data" class="p-6 sm:p-8">
                @csrf
                @method('PUT')
                
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

                <!-- Store & Basic Info Section -->
                <div class="space-y-6">
                    <!-- Store Selection -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Store Information
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-5">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Select Store <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <select name="store_id" required
                                            class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('store_id') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 appearance-none bg-white">
                                        @foreach($stores as $store)
                                            <option value="{{ $store->id }}" {{ old('store_id', $medicine->store_id) == $store->id ? 'selected' : '' }}>
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
                        </div>
                    </div>

                    <!-- Medicine Basic Information -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Basic Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Medicine Name -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Medicine Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="medicine_name" required
                                           value="{{ old('medicine_name', $medicine->medicine_name) }}"
                                           placeholder="Enter medicine name"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('medicine_name') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                                @error('medicine_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Brand -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Brand
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="brand"
                                           value="{{ old('brand', $medicine->brand) }}"
                                           placeholder="Enter brand name"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Category
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="category"
                                           value="{{ old('category', $medicine->category) }}"
                                           placeholder="e.g., Antibiotic, Analgesic"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                            </div>

                            <!-- Batch No -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Batch Number
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="batch_no"
                                           value="{{ old('batch_no', $medicine->batch_no) }}"
                                           placeholder="Enter batch number"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                            </div>

                            <!-- Expiry Date -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Expiry Date
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="date" name="expiry_date"
                                           value="{{ old('expiry_date', $medicine->expiry_date ? \Carbon\Carbon::parse($medicine->expiry_date)->format('Y-m-d') : '') }}"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock Section -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pricing & Stock
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- Purchase Price -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Purchase Price
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">₹</span>
                                    </div>
                                    <input type="number" step="0.01" name="purchase_price"
                                           value="{{ old('purchase_price', $medicine->purchase_price) }}"
                                           placeholder="0.00"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                            </div>

                            <!-- Sale Price -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Sale Price <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">₹</span>
                                    </div>
                                    <input type="number" step="0.01" name="sale_price" required
                                           value="{{ old('sale_price', $medicine->sale_price) }}"
                                           placeholder="0.00"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border {{ $errors->has('sale_price') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                                @error('sale_price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Stock Quantity
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <input type="number" name="stock"
                                           value="{{ old('stock', $medicine->stock) }}"
                                           placeholder="Enter quantity"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Medicine Image
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Current Image -->
                            @if($medicine->image)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Image</p>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $medicine->image) }}" 
                                         alt="{{ $medicine->medicine_name }}"
                                         class="w-24 h-24 object-cover rounded-lg border border-gray-300">
                                    <div>
                                        <p class="text-sm text-gray-600">Current medicine image</p>
                                        <label class="mt-2 flex items-center text-sm text-red-600 cursor-pointer hover:text-red-800">
                                            <input type="checkbox" name="remove_image" value="1" class="mr-2">
                                            <span>Remove current image</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- New Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Upload New Image (Optional)
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition duration-200 relative">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload a file</span>
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF up to 2MB
                                        </p>
                                    </div>
                                    <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Medicine Status
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Activation Status
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <select name="status"
                                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200 appearance-none bg-white">
                                        <option value="1" {{ old('status', $medicine->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $medicine->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Set medicine availability in the system</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-500">
                            Medicine ID: <span class="font-medium text-gray-700">{{ $medicine->id }}</span>
                            • Created: <span class="font-medium text-gray-700">{{ $medicine->created_at->format('d M, Y') }}</span>
                            • Last Updated: <span class="font-medium text-gray-700">{{ $medicine->updated_at->format('d M, Y') }}</span>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.medicine.index') }}"
                               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-medium flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Medicines
                            </a>
                            <button type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Medicine
                            </button>
                        </div>
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
                    <p class="text-sm font-medium text-blue-800">Editing Tips</p>
                    <ul class="mt-1 text-sm text-blue-700 space-y-1">
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Update only the fields that need changes to maintain data integrity
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Check expiry dates regularly to avoid selling expired medicines
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-1 h-1 bg-blue-500 rounded-full mt-1.5 mr-2"></span>
                            Sale price should be higher than purchase price for profit margin
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
    
    /* File upload hover effect */
    .border-dashed:hover {
        border-color: #60a5fa;
        background-color: #eff6ff;
    }
</style>

<script>
    // Form validation enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const requiredFields = form.querySelectorAll('[required]');
        
        // Add real-time validation feedback
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('border-red-500', 'bg-red-50');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-500', 'bg-red-50');
                    this.classList.add('border-gray-300');
                }
            });
            
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('border-red-500', 'bg-red-50');
                    this.classList.add('border-gray-300');
                }
            });
        });
        
        // Price validation - Sale price should be >= Purchase price
        const purchasePrice = document.querySelector('input[name="purchase_price"]');
        const salePrice = document.querySelector('input[name="sale_price"]');
        
        function validatePrices() {
            if (purchasePrice.value && salePrice.value) {
                const purchase = parseFloat(purchasePrice.value);
                const sale = parseFloat(salePrice.value);
                
                if (sale < purchase) {
                    salePrice.classList.add('border-red-500', 'bg-red-50');
                    
                    // Create or update warning message
                    let warning = salePrice.parentNode.querySelector('.price-warning');
                    if (!warning) {
                        warning = document.createElement('p');
                        warning.className = 'text-red-500 text-xs mt-1 price-warning';
                        salePrice.parentNode.appendChild(warning);
                    }
                    warning.textContent = 'Sale price should be higher than purchase price';
                } else {
                    salePrice.classList.remove('border-red-500', 'bg-red-50');
                    const warning = salePrice.parentNode.querySelector('.price-warning');
                    if (warning) warning.remove();
                }
            }
        }
        
        if (purchasePrice && salePrice) {
            purchasePrice.addEventListener('input', validatePrices);
            salePrice.addEventListener('input', validatePrices);
        }
        
        // File upload preview
        const fileInput = document.querySelector('input[name="image"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const uploadArea = fileInput.closest('.border-dashed');
                    const svg = uploadArea.querySelector('svg');
                    const text = uploadArea.querySelector('.text-sm');
                    
                    if (svg && text) {
                        svg.classList.add('hidden');
                        text.innerHTML = `
                            <p class="font-medium text-green-600">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB • Click to change</p>
                        `;
                        
                        // Preview image
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'w-16 h-16 object-cover rounded-lg mx-auto mb-2';
                            uploadArea.insertBefore(img, svg);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        }
        
        // Set expiry date min to today
        const expiryDateInput = document.querySelector('input[name="expiry_date"]');
        if (expiryDateInput) {
            const today = new Date().toISOString().split('T')[0];
            expiryDateInput.min = today;
        }
        
        // Toggle remove image checkbox
        const removeImageCheckbox = document.querySelector('input[name="remove_image"]');
        const currentImage = document.querySelector('img[src*="storage/"]');
        
        if (removeImageCheckbox && currentImage) {
            removeImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    currentImage.classList.add('opacity-50');
                } else {
                    currentImage.classList.remove('opacity-50');
                }
            });
        }
        
        // Show confirmation before leaving page if form is dirty
        let formChanged = false;
        const formInputs = form.querySelectorAll('input, textarea, select');
        
        formInputs.forEach(input => {
            // Check initial values
            const initialValue = input.value;
            
            input.addEventListener('input', () => {
                formChanged = input.value !== initialValue;
            });
            
            input.addEventListener('change', () => {
                formChanged = input.value !== initialValue;
            });
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
        
        // Form submit handler
        form.addEventListener('submit', function() {
            formChanged = false;
        });
    });
</script>
@endsection