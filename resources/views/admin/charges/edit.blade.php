@extends('layouts.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Modern Container -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        
        <!-- Clean Header -->
        <div class="bg-white px-8 py-8 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-blue-50 rounded-xl">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Doctor Charge</h1>
                    <p class="text-gray-600 mt-1">Update medical service charge information</p>
                </div>
            </div>
        </div>

        {{-- Error / Success Messages --}}
        @if(session('error'))
        <div class="mx-8 mt-8">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-red-700">{{ session('error') }}</span>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.charges.update', $charge->id) }}" method="POST" class="px-8 py-8">
            @csrf
            

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Form Fields -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Information Section -->
                    <div class="space-y-8">
                        <!-- Charge Type & Doctor -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Charge Type <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="name" 
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200 appearance-none">
                                        <option value="">Select Charge Type</option>
                                        <option value="Bed" {{ old('name', $charge->name) == 'Bed' ? 'selected' : '' }}>Bed</option>
                                        <option value="Room" {{ old('name', $charge->name) == 'Room' ? 'selected' : '' }}>Room</option>
                                        <option value="Ambulance" {{ old('name', $charge->name) == 'Ambulance' ? 'selected' : '' }}>Ambulance</option>
                                        <option value="OPD" {{ old('name', $charge->name) == 'OPD' ? 'selected' : '' }}>OPD</option>
                                        <option value="IPD" {{ old('name', $charge->name) == 'IPD' ? 'selected' : '' }}>IPD</option>
                                        <option value="Emergency" {{ old('name', $charge->name) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                        <option value="ICU" {{ old('name', $charge->name) == 'ICU' ? 'selected' : '' }}>ICU</option>
                                    </select>
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Doctor <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="doctor_id" 
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200 appearance-none">
                                        <option value="">Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                                data-fees="{{ $doctor->consultation_fees ?? '0' }}"
                                                {{ old('doctor_id', $charge->employee_id) == $doctor->id ? 'selected' : '' }}>
                                            Dr. {{ $doctor->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('doctor_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Type Selection - Checkbox with Unselect Option -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Service Type <span class="text-red-500">*</span>
                                </label>
                                <button type="button" id="clear-service-type" class="text-sm text-gray-500 hover:text-red-600 transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear All
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Consultation Checkbox -->
                                <label class="cursor-pointer service-type-checkbox-wrapper">
                                    <input type="checkbox" name="type" value="consultation" 
                                           class="sr-only service-type-checkbox"
                                           {{ old('type', $charge->type) == 'consultation' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-blue-400 transition duration-200 service-checked:border-blue-500 service-checked:bg-blue-50">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-800">Consultation</div>
                                                <div class="text-sm text-gray-600 mt-1">Doctor consultation</div>
                                            </div>
                                            <div class="service-checkbox-indicator ml-3 hidden">
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Appointment Checkbox -->
                                <label class="cursor-pointer service-type-checkbox-wrapper">
                                    <input type="checkbox" name="type" value="appointment" 
                                           class="sr-only service-type-checkbox"
                                           {{ old('type', $charge->type) == 'appointment' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-green-400 transition duration-200 service-checked:border-green-500 service-checked:bg-green-50">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-800">Appointment</div>
                                                <div class="text-sm text-gray-600 mt-1">Appointment</div>
                                            </div>
                                            <div class="service-checkbox-indicator ml-3 hidden">
                                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Test Checkbox -->
                                <label class="cursor-pointer service-type-checkbox-wrapper">
                                    <input type="checkbox" name="type" value="test" 
                                           class="sr-only service-type-checkbox"
                                           {{ old('type', $charge->type) == 'test' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-purple-400 transition duration-200 service-checked:border-purple-500 service-checked:bg-purple-50">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-medium text-gray-800">Test</div>
                                                <div class="text-sm text-gray-600 mt-1">Medical test</div>
                                            </div>
                                            <div class="service-checkbox-indicator ml-3 hidden">
                                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="mt-3 text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Select one service type. Click again to unselect.
                            </div>
                            @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Consultation Mode (Dynamic) - Checkbox with Unselect Option -->
                        <div class="mt-8" id="consultation-mode" style="display: {{ old('type', $charge->type) == 'consultation' ? 'block' : 'none' }};">
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Consultation Mode <span class="text-red-500">*</span>
                                </label>
                                <button type="button" id="clear-consultation-mode" class="text-sm text-gray-500 hover:text-red-600 transition duration-200 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Clear All
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Video Call Checkbox -->
                                <label class="cursor-pointer consultation-checkbox-wrapper">
                                    <input type="checkbox" name="sub_type" value="video" 
                                           class="sr-only consultation-checkbox"
                                           {{ old('sub_type', $charge->sub_type) == 'video' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-blue-400 transition duration-200 consultation-checked:border-blue-500 consultation-checked:bg-blue-50 text-center">
                                        <div class="flex items-center justify-center mb-3">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="consultation-checkbox-indicator ml-3 hidden">
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="font-medium text-gray-800">Video Call</div>
                                        <div class="text-sm text-gray-600 mt-1">Face-to-face</div>
                                    </div>
                                </label>

                                <!-- Voice Call Checkbox -->
                                <label class="cursor-pointer consultation-checkbox-wrapper">
                                    <input type="checkbox" name="sub_type" value="voice" 
                                           class="sr-only consultation-checkbox"
                                           {{ old('sub_type', $charge->sub_type) == 'voice' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-green-400 transition duration-200 consultation-checked:border-green-500 consultation-checked:bg-green-50 text-center">
                                        <div class="flex items-center justify-center mb-3">
                                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                                </svg>
                                            </div>
                                            <div class="consultation-checkbox-indicator ml-3 hidden">
                                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="font-medium text-gray-800">Voice Call</div>
                                        <div class="text-sm text-gray-600 mt-1">Audio only</div>
                                    </div>
                                </label>

                                <!-- Chat Checkbox -->
                                <label class="cursor-pointer consultation-checkbox-wrapper">
                                    <input type="checkbox" name="sub_type" value="chat" 
                                           class="sr-only consultation-checkbox"
                                           {{ old('sub_type', $charge->sub_type) == 'chat' ? 'checked' : '' }}>
                                    <div class="p-4 border-2 border-gray-300 rounded-lg hover:border-purple-400 transition duration-200 consultation-checked:border-purple-500 consultation-checked:bg-purple-50 text-center">
                                        <div class="flex items-center justify-center mb-3">
                                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                            </div>
                                            <div class="consultation-checkbox-indicator ml-3 hidden">
                                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="font-medium text-gray-800">Chat</div>
                                        <div class="text-sm text-gray-600 mt-1">Text based</div>
                                    </div>
                                </label>
                            </div>
                            <div class="mt-3 text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Select one consultation mode. Click again to unselect.
                            </div>
                            @error('sub_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="mt-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Description <span class="text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <textarea name="description"
                                  rows="4"
                                  placeholder="Enter additional details about this charge..."
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200 resize-none">{{ old('description', $charge->description) }}</textarea>
                        @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Pricing & Actions -->
                <div class="space-y-8">
                    <!-- Pricing Section -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Pricing</h3>
                        
                        <!-- Charge Amount -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">
                                Charge Amount <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₹</span>
                                </div>
                                <input type="number"
                                       name="charge"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('charge', $charge->charge) }}"
                                       placeholder="0.00"
                                       class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 text-lg font-semibold text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200"
                                       id="charge-input">
                            </div>

                            <!-- Quick Amount Buttons -->
                            <div class="mt-6">
                                <div class="text-sm text-gray-600 mb-3">Quick select:</div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" class="quick-amount-btn px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition duration-200" data-amount="100">₹100</button>
                                    <button type="button" class="quick-amount-btn px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition duration-200" data-amount="500">₹500</button>
                                    <button type="button" class="quick-amount-btn px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition duration-200" data-amount="1000">₹1,000</button>
                                    <button type="button" class="quick-amount-btn px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition duration-200" data-amount="2000">₹2,000</button>
                                    <button type="button" class="quick-amount-btn px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition duration-200" data-amount="5000">₹5,000</button>
                                </div>
                            </div>

                            @error('charge')
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="text-sm text-red-600">
                                    {{ $message }}
                                </div>
                            </div>
                            @enderror
                        </div>

                        <!-- Selection Status -->
                        <div class="space-y-4">
                            <!-- Service Selection Status -->
                            <div id="service-status" class="p-3 bg-white border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Service Type:</span>
                                    <span id="service-status-text" class="text-sm text-gray-600">Not selected</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    Click on a service type to select, click again to unselect
                                </div>
                            </div>

                            <!-- Mode Selection Status -->
                            <div id="mode-status" class="p-3 bg-white border border-gray-200 rounded-lg" style="display: none;">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Consultation Mode:</span>
                                    <span id="mode-status-text" class="text-sm text-gray-600">Not selected</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    Will appear when Consultation service is selected
                                </div>
                            </div>
                        </div>

                        <!-- Amount Summary -->
                        <div class="pt-6 border-t border-gray-300">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Charge Amount:</span>
                                    <span id="preview-amount" class="font-semibold text-gray-800">₹{{ number_format($charge->charge, 2) }}</span>
                                </div>
                                <div class="pt-3 mt-3 border-t border-gray-300">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-800">Total Amount:</span>
                                        <span id="preview-total" class="text-xl font-bold text-blue-600">₹{{ number_format($charge->charge, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <button type="submit"
                                class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Charge
                        </button>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('admin.charges.index') }}"
                               class="py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            
                            <button type="button"
                                    id="reset-form"
                                    class="py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </button>
                        </div>
                        
                        <!-- Help Text -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-sm text-gray-600">
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-gray-400 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>All amounts are in Indian Rupees (₹). Enter the exact charge amount to be billed.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const serviceTypeCheckboxes = document.querySelectorAll('.service-type-checkbox');
    const serviceTypeWrappers = document.querySelectorAll('.service-type-checkbox-wrapper');
    const consultationCheckboxes = document.querySelectorAll('.consultation-checkbox');
    const consultationWrappers = document.querySelectorAll('.consultation-checkbox-wrapper');
    const consultationMode = document.getElementById('consultation-mode');
    const clearServiceTypeBtn = document.getElementById('clear-service-type');
    const clearConsultationBtn = document.getElementById('clear-consultation-mode');
    const doctorSelect = document.querySelector('select[name="doctor_id"]');
    const chargeInput = document.getElementById('charge-input');
    const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
    const resetBtn = document.getElementById('reset-form');
    
    // Status elements
    const serviceStatus = document.getElementById('service-status');
    const serviceStatusText = document.getElementById('service-status-text');
    const modeStatus = document.getElementById('mode-status');
    const modeStatusText = document.getElementById('mode-status-text');
    
    // Preview elements
    const previewAmount = document.getElementById('preview-amount');
    const previewTotal = document.getElementById('preview-total');

    // Service and Mode data
    const serviceData = {
        'consultation': { name: 'Consultation', color: 'blue' },
        'appointment': { name: 'Appointment', color: 'green' },
        'test': { name: 'Test', color: 'purple' }
    };

    const modeData = {
        'video': { name: 'Video Call', color: 'blue' },
        'voice': { name: 'Voice Call', color: 'green' },
        'chat': { name: 'Chat', color: 'purple' }
    };

    // Initialize checkboxes from existing data
    function initializeCheckboxes() {
        // Update service checkboxes
        serviceTypeCheckboxes.forEach(checkbox => {
            const wrapper = checkbox.closest('.service-type-checkbox-wrapper');
            const indicator = wrapper.querySelector('.service-checkbox-indicator');
            
            if (checkbox.checked) {
                wrapper.classList.add('service-checked');
                indicator.classList.remove('hidden');
                updateServiceCheckboxVisual(wrapper, true);
            } else {
                wrapper.classList.remove('service-checked');
                indicator.classList.add('hidden');
                updateServiceCheckboxVisual(wrapper, false);
            }
        });

        // Update consultation checkboxes
        consultationCheckboxes.forEach(checkbox => {
            const wrapper = checkbox.closest('.consultation-checkbox-wrapper');
            const indicator = wrapper.querySelector('.consultation-checkbox-indicator');
            
            if (checkbox.checked) {
                wrapper.classList.add('consultation-checked');
                indicator.classList.remove('hidden');
                updateConsultationCheckboxVisual(wrapper, true);
            } else {
                wrapper.classList.remove('consultation-checked');
                indicator.classList.add('hidden');
                updateConsultationCheckboxVisual(wrapper, false);
            }
        });

        updateStatusDisplays();
        toggleConsultationMode();
    }

    // Update service checkbox visual state
    function updateServiceCheckboxVisual(wrapper, isChecked) {
        const card = wrapper.querySelector('div[class*="border-"]');
        if (isChecked) {
            if (wrapper.querySelector('input[value="consultation"]')) {
                card.classList.add('border-blue-500', 'bg-blue-50');
                card.classList.remove('border-gray-300', 'hover:border-blue-400');
            } else if (wrapper.querySelector('input[value="appointment"]')) {
                card.classList.add('border-green-500', 'bg-green-50');
                card.classList.remove('border-gray-300', 'hover:border-green-400');
            } else if (wrapper.querySelector('input[value="test"]')) {
                card.classList.add('border-purple-500', 'bg-purple-50');
                card.classList.remove('border-gray-300', 'hover:border-purple-400');
            }
        } else {
            if (wrapper.querySelector('input[value="consultation"]')) {
                card.classList.remove('border-blue-500', 'bg-blue-50');
                card.classList.add('border-gray-300', 'hover:border-blue-400');
            } else if (wrapper.querySelector('input[value="appointment"]')) {
                card.classList.remove('border-green-500', 'bg-green-50');
                card.classList.add('border-gray-300', 'hover:border-green-400');
            } else if (wrapper.querySelector('input[value="test"]')) {
                card.classList.remove('border-purple-500', 'bg-purple-50');
                card.classList.add('border-gray-300', 'hover:border-purple-400');
            }
        }
    }

    // Update consultation checkbox visual state
    function updateConsultationCheckboxVisual(wrapper, isChecked) {
        const card = wrapper.querySelector('div[class*="border-"]');
        if (isChecked) {
            if (wrapper.querySelector('input[value="video"]')) {
                card.classList.add('border-blue-500', 'bg-blue-50');
                card.classList.remove('border-gray-300', 'hover:border-blue-400');
            } else if (wrapper.querySelector('input[value="voice"]')) {
                card.classList.add('border-green-500', 'bg-green-50');
                card.classList.remove('border-gray-300', 'hover:border-green-400');
            } else if (wrapper.querySelector('input[value="chat"]')) {
                card.classList.add('border-purple-500', 'bg-purple-50');
                card.classList.remove('border-gray-300', 'hover:border-purple-400');
            }
        } else {
            if (wrapper.querySelector('input[value="video"]')) {
                card.classList.remove('border-blue-500', 'bg-blue-50');
                card.classList.add('border-gray-300', 'hover:border-blue-400');
            } else if (wrapper.querySelector('input[value="voice"]')) {
                card.classList.remove('border-green-500', 'bg-green-50');
                card.classList.add('border-gray-300', 'hover:border-green-400');
            } else if (wrapper.querySelector('input[value="chat"]')) {
                card.classList.remove('border-purple-500', 'bg-purple-50');
                card.classList.add('border-gray-300', 'hover:border-purple-400');
            }
        }
    }

    // Toggle consultation mode visibility based on service selection
    function toggleConsultationMode() {
        const consultationCheckbox = document.querySelector('input[name="type"][value="consultation"]');
        if (consultationCheckbox && consultationCheckbox.checked) {
            consultationMode.style.display = 'block';
            setTimeout(() => {
                consultationMode.style.opacity = '1';
            }, 10);
            modeStatus.style.display = 'block';
        } else {
            consultationMode.style.opacity = '0';
            setTimeout(() => {
                consultationMode.style.display = 'none';
                modeStatus.style.display = 'none';
                // Clear consultation mode selection when consultation is not selected
                clearConsultationSelection();
            }, 300);
        }
    }

    // Clear consultation mode selection
    function clearConsultationSelection() {
        consultationCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            const wrapper = checkbox.closest('.consultation-checkbox-wrapper');
            wrapper.classList.remove('consultation-checked');
            wrapper.querySelector('.consultation-checkbox-indicator').classList.add('hidden');
            updateConsultationCheckboxVisual(wrapper, false);
        });
        updateStatusDisplays();
    }

    // Clear all service type selections
    function clearServiceTypeSelection() {
        serviceTypeCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            const wrapper = checkbox.closest('.service-type-checkbox-wrapper');
            wrapper.classList.remove('service-checked');
            wrapper.querySelector('.service-checkbox-indicator').classList.add('hidden');
            updateServiceCheckboxVisual(wrapper, false);
        });
        updateStatusDisplays();
        toggleConsultationMode();
    }

    // Update status displays
    function updateStatusDisplays() {
        // Update service status
        const selectedService = Array.from(serviceTypeCheckboxes).find(cb => cb.checked);
        if (selectedService) {
            const service = serviceData[selectedService.value];
            serviceStatusText.textContent = service.name;
            serviceStatusText.className = `text-sm font-medium text-${service.color}-600`;
        } else {
            serviceStatusText.textContent = 'Not selected';
            serviceStatusText.className = 'text-sm text-gray-600';
        }

        // Update mode status
        const selectedMode = Array.from(consultationCheckboxes).find(cb => cb.checked);
        if (selectedMode) {
            const mode = modeData[selectedMode.value];
            modeStatusText.textContent = mode.name;
            modeStatusText.className = `text-sm font-medium text-${mode.color}-600`;
        } else {
            modeStatusText.textContent = 'Not selected';
            modeStatusText.className = 'text-sm text-gray-600';
        }
    }

    // Service Type checkbox click handler - SINGLE SELECT with UNSELECT
    serviceTypeWrappers.forEach(wrapper => {
        wrapper.addEventListener('click', function(e) {
            const checkbox = this.querySelector('.service-type-checkbox');
            const indicator = this.querySelector('.service-checkbox-indicator');
            
            // Toggle the clicked checkbox
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                // If we're checking this box, uncheck all other service type checkboxes
                serviceTypeCheckboxes.forEach(cb => {
                    if (cb !== checkbox) {
                        cb.checked = false;
                        const otherWrapper = cb.closest('.service-type-checkbox-wrapper');
                        otherWrapper.classList.remove('service-checked');
                        otherWrapper.querySelector('.service-checkbox-indicator').classList.add('hidden');
                        updateServiceCheckboxVisual(otherWrapper, false);
                    }
                });
                
                // Check the clicked checkbox
                this.classList.add('service-checked');
                indicator.classList.remove('hidden');
                updateServiceCheckboxVisual(this, true);
            } else {
                // If we're unchecking this box
                this.classList.remove('service-checked');
                indicator.classList.add('hidden');
                updateServiceCheckboxVisual(this, false);
            }
            
            updateStatusDisplays();
            toggleConsultationMode();
        });
    });

    // Consultation Mode checkbox click handler - SINGLE SELECT with UNSELECT
    consultationWrappers.forEach(wrapper => {
        wrapper.addEventListener('click', function(e) {
            const checkbox = this.querySelector('.consultation-checkbox');
            const indicator = this.querySelector('.consultation-checkbox-indicator');
            
            // Toggle the clicked checkbox
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                // If we're checking this box, uncheck all other consultation mode checkboxes
                consultationCheckboxes.forEach(cb => {
                    if (cb !== checkbox) {
                        cb.checked = false;
                        const otherWrapper = cb.closest('.consultation-checkbox-wrapper');
                        otherWrapper.classList.remove('consultation-checked');
                        otherWrapper.querySelector('.consultation-checkbox-indicator').classList.add('hidden');
                        updateConsultationCheckboxVisual(otherWrapper, false);
                    }
                });
                
                // Check the clicked checkbox
                this.classList.add('consultation-checked');
                indicator.classList.remove('hidden');
                updateConsultationCheckboxVisual(this, true);
            } else {
                // If we're unchecking this box
                this.classList.remove('consultation-checked');
                indicator.classList.add('hidden');
                updateConsultationCheckboxVisual(this, false);
            }
            
            updateStatusDisplays();
        });
    });

    // Clear all service type selections
    clearServiceTypeBtn.addEventListener('click', function() {
        clearServiceTypeSelection();
    });

    // Clear all consultation mode selections
    clearConsultationBtn.addEventListener('click', function() {
        clearConsultationSelection();
    });

    // Doctor selection auto-fill
    doctorSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const fees = selectedOption.getAttribute('data-fees');
        
        // Auto-fill charge with doctor's fees if empty
        if (!chargeInput.value && fees) {
            chargeInput.value = fees;
            updatePreview();
        }
    });

    // Quick amount buttons
    quickAmountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = this.getAttribute('data-amount');
            chargeInput.value = amount;
            updatePreview();
            
            // Visual feedback
            this.classList.add('bg-blue-100', 'text-blue-700');
            setTimeout(() => {
                this.classList.remove('bg-blue-100', 'text-blue-700');
            }, 300);
        });
    });

    // Update preview on charge input
    chargeInput.addEventListener('input', updatePreview);

    // Update preview function
    function updatePreview() {
        const amount = parseFloat(chargeInput.value) || 0;

        // Update preview values
        previewAmount.textContent = '₹' + formatIndianNumber(amount);
        previewTotal.textContent = '₹' + formatIndianNumber(amount);
    }

    // Format number in Indian style (1,00,000.00)
    function formatIndianNumber(num) {
        return num.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Reset form to original values
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset all changes? All unsaved changes will be lost.')) {
            // Get original values from data attributes or initial load
            const originalCharge = {{ $charge->charge }};
            const originalType = "{{ $charge->type }}";
            const originalSubType = "{{ $charge->sub_type }}";
            
            // Reset form values
            document.querySelector('form').reset();
            
            // Restore specific values
            chargeInput.value = originalCharge;
            
            // Uncheck all service type checkboxes first
            serviceTypeCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                const wrapper = checkbox.closest('.service-type-checkbox-wrapper');
                wrapper.classList.remove('service-checked');
                wrapper.querySelector('.service-checkbox-indicator').classList.add('hidden');
                updateServiceCheckboxVisual(wrapper, false);
            });
            
            // Check the original service type if it exists
            if (originalType) {
                const originalServiceCheckbox = document.querySelector(`.service-type-checkbox[value="${originalType}"]`);
                if (originalServiceCheckbox) {
                    originalServiceCheckbox.checked = true;
                    const wrapper = originalServiceCheckbox.closest('.service-type-checkbox-wrapper');
                    wrapper.classList.add('service-checked');
                    wrapper.querySelector('.service-checkbox-indicator').classList.remove('hidden');
                    updateServiceCheckboxVisual(wrapper, true);
                }
            }

            // Uncheck all consultation mode checkboxes first
            consultationCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                const wrapper = checkbox.closest('.consultation-checkbox-wrapper');
                wrapper.classList.remove('consultation-checked');
                wrapper.querySelector('.consultation-checkbox-indicator').classList.add('hidden');
                updateConsultationCheckboxVisual(wrapper, false);
            });
            
            // Check the original consultation mode if it exists
            if (originalSubType) {
                const originalModeCheckbox = document.querySelector(`.consultation-checkbox[value="${originalSubType}"]`);
                if (originalModeCheckbox) {
                    originalModeCheckbox.checked = true;
                    const wrapper = originalModeCheckbox.closest('.consultation-checkbox-wrapper');
                    wrapper.classList.add('consultation-checked');
                    wrapper.querySelector('.consultation-checkbox-indicator').classList.remove('hidden');
                    updateConsultationCheckboxVisual(wrapper, true);
                }
            }
            
            updateStatusDisplays();
            toggleConsultationMode();
            updatePreview();
        }
    });

    // Add smooth transition for consultation mode
    consultationMode.style.transition = 'opacity 0.3s ease';

    // Initialize checkboxes
    initializeCheckboxes();

    // Initialize preview
    updatePreview();

    // Add focus effects
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-100');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-100');
        });
    });
});
</script>

<style>
/* Smooth transitions */
input, select, textarea, button {
    transition: all 0.2s ease;
}

/* Custom focus styles */
input:focus, select:focus, textarea:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Consultation mode animation */
#consultation-mode {
    opacity: {{ old('type', $charge->type) == 'consultation' ? '1' : '0' }};
}

/* Hover effects */
.quick-amount-btn:hover {
    transform: translateY(-1px);
}

/* Card hover effect */
.bg-gray-50:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}

/* Update button specific styling */
button[type="submit"] {
    background: linear-gradient(135deg, #10b981, #059669);
}

button[type="submit"]:hover {
    background: linear-gradient(135deg, #059669, #047857);
}

/* Checkbox card styling */
.service-type-checkbox-wrapper,
.consultation-checkbox-wrapper {
    user-select: none;
}

.service-type-checkbox-wrapper:hover > div,
.consultation-checkbox-wrapper:hover > div {
    border-color: currentColor;
}

/* Checkbox indicator animation */
.service-checkbox-indicator,
.consultation-checkbox-indicator {
    transition: all 0.2s ease;
    transform: scale(0.8);
}

.service-type-checkbox-wrapper.service-checked .service-checkbox-indicator,
.consultation-checkbox-wrapper.consultation-checked .consultation-checkbox-indicator {
    transform: scale(1);
}

/* Status card styling */
#service-status, #mode-status {
    transition: all 0.2s ease;
}

#service-status:hover, #mode-status:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Color classes for dynamic text coloring */
.text-blue-600 { color: #2563eb; }
.text-green-600 { color: #059669; }
.text-purple-600 { color: #7c3aed; }
.text-gray-600 { color: #4b5563; }

/* Clear button hover effect */
#clear-service-type:hover,
#clear-consultation-mode:hover {
    transform: translateY(-1px);
}
</style>
@endsection