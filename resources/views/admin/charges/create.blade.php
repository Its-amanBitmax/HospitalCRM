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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Create Charge</h1>
                    <p class="text-gray-600 mt-1">Add medical service charges for doctors</p>
                </div>
            </div>
        </div>

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

        <form action="{{ route('admin.charges.store') }}" method="POST" class="px-8 py-8">
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
                                    Charge Type 
                                </label>
                                <div class="relative">
                                    <select name="name" 
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200 appearance-none">
                                        <option value="">Select Charge Type</option>
                                        <option value="bed" {{ old('name') == 'bed' ? 'selected' : '' }}>Bed Charge</option>
                                        <option value="room" {{ old('name') == 'room' ? 'selected' : '' }}>Room Charge</option>
                                        <option value="ambulance" {{ old('name') == 'ambulance' ? 'selected' : '' }}>Ambulance Service</option>
                                        <option value="opd" {{ old('name') == 'opd' ? 'selected' : '' }}>OPD Consultation</option>
                                        <option value="ipd" {{ old('name') == 'ipd' ? 'selected' : '' }}>IPD Admission</option>
                                        <option value="emergency" {{ old('name') == 'emergency' ? 'selected' : '' }}>Emergency Service</option>
                                        <option value="icu" {{ old('name') == 'icu' ? 'selected' : '' }}>ICU Charges</option>
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
                                    Doctor 
                                </label>
                                <div class="relative">
                                    <select name="doctor_id" 
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200 appearance-none">
                                        <option value="">Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                                data-fees="{{ $doctor->consultation_fees ?? '0' }}"
                                                {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
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

                        <!-- Service Type Selection - Checkbox with Unselect -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Service Type 
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
                                           {{ old('type') == 'consultation' ? 'checked' : '' }}>
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
                                           {{ old('type') == 'appointment' ? 'checked' : '' }}>
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
                                           {{ old('type') == 'test' ? 'checked' : '' }}>
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

                        <!-- Consultation Mode (Dynamic) - Checkbox with Unselect -->
                        <div class="mt-8" id="consultation-mode" style="display: none;">
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Consultation Mode
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
                                           {{ old('sub_type') == 'video' ? 'checked' : '' }}>
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
                                           {{ old('sub_type') == 'voice' ? 'checked' : '' }}>
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
                                           {{ old('sub_type') == 'chat' ? 'checked' : '' }}>
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
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200 resize-none">{{ old('description') }}</textarea>
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
                                       value="{{ old('charge') }}"
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
                                    <span id="preview-amount" class="font-semibold text-gray-800">₹0.00</span>
                                </div>
                                <div class="pt-3 mt-3 border-t border-gray-300">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-800">Total Amount:</span>
                                        <span id="preview-total" class="text-xl font-bold text-blue-600">₹0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        <button type="submit"
                                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Charge
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

    // Initialize checkboxes from existing data (for form validation errors)
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

        // Show/hide consultation mode section
        updateConsultationModeSection();
        updateStatus();
        updatePreview();
    }

    // Update service checkbox visual state
    function updateServiceCheckboxVisual(wrapper, isChecked) {
        const checkbox = wrapper.querySelector('.service-type-checkbox');
        const indicator = wrapper.querySelector('.service-checkbox-indicator');
        
        if (isChecked) {
            wrapper.classList.add('service-checked');
            indicator.classList.remove('hidden');
            
            // Uncheck other service checkboxes
            serviceTypeCheckboxes.forEach(cb => {
                if (cb !== checkbox && cb.checked) {
                    const otherWrapper = cb.closest('.service-type-checkbox-wrapper');
                    const otherIndicator = otherWrapper.querySelector('.service-checkbox-indicator');
                    
                    cb.checked = false;
                    otherWrapper.classList.remove('service-checked');
                    otherIndicator.classList.add('hidden');
                    updateServiceCheckboxVisual(otherWrapper, false);
                }
            });
        } else {
            wrapper.classList.remove('service-checked');
            indicator.classList.add('hidden');
        }
        
        updateConsultationModeSection();
        updateStatus();
    }

    // Update consultation checkbox visual state
    function updateConsultationCheckboxVisual(wrapper, isChecked) {
        const checkbox = wrapper.querySelector('.consultation-checkbox');
        const indicator = wrapper.querySelector('.consultation-checkbox-indicator');
        
        if (isChecked) {
            wrapper.classList.add('consultation-checked');
            indicator.classList.remove('hidden');
            
            // Uncheck other consultation checkboxes
            consultationCheckboxes.forEach(cb => {
                if (cb !== checkbox && cb.checked) {
                    const otherWrapper = cb.closest('.consultation-checkbox-wrapper');
                    const otherIndicator = otherWrapper.querySelector('.consultation-checkbox-indicator');
                    
                    cb.checked = false;
                    otherWrapper.classList.remove('consultation-checked');
                    otherIndicator.classList.add('hidden');
                    updateConsultationCheckboxVisual(otherWrapper, false);
                }
            });
        } else {
            wrapper.classList.remove('consultation-checked');
            indicator.classList.add('hidden');
        }
        
        updateStatus();
    }

    // Show/hide consultation mode section
    function updateConsultationModeSection() {
        const consultationSelected = Array.from(serviceTypeCheckboxes)
            .some(cb => cb.value === 'consultation' && cb.checked);
        
        if (consultationSelected) {
            consultationMode.style.display = 'block';
            modeStatus.style.display = 'block';
        } else {
            consultationMode.style.display = 'none';
            modeStatus.style.display = 'none';
            
            // Uncheck all consultation checkboxes
            consultationCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                const wrapper = checkbox.closest('.consultation-checkbox-wrapper');
                const indicator = wrapper.querySelector('.consultation-checkbox-indicator');
                wrapper.classList.remove('consultation-checked');
                indicator.classList.add('hidden');
            });
        }
    }

    // Update status display
    function updateStatus() {
        // Update service status
        const selectedService = Array.from(serviceTypeCheckboxes)
            .find(cb => cb.checked);
        
        if (selectedService) {
            const serviceInfo = serviceData[selectedService.value];
            serviceStatusText.textContent = serviceInfo.name;
            serviceStatus.style.borderLeftColor = getColor(serviceInfo.color);
            serviceStatus.style.borderLeftWidth = '4px';
            serviceStatus.style.paddingLeft = '12px';
        } else {
            serviceStatusText.textContent = 'Not selected';
            serviceStatus.style.borderLeftColor = '';
            serviceStatus.style.borderLeftWidth = '';
            serviceStatus.style.paddingLeft = '';
        }

        // Update mode status
        if (consultationMode.style.display === 'block') {
            const selectedMode = Array.from(consultationCheckboxes)
                .find(cb => cb.checked);
            
            if (selectedMode) {
                const modeInfo = modeData[selectedMode.value];
                modeStatusText.textContent = modeInfo.name;
                modeStatus.style.borderLeftColor = getColor(modeInfo.color);
                modeStatus.style.borderLeftWidth = '4px';
                modeStatus.style.paddingLeft = '12px';
            } else {
                modeStatusText.textContent = 'Not selected';
                modeStatus.style.borderLeftColor = '';
                modeStatus.style.borderLeftWidth = '';
                modeStatus.style.paddingLeft = '';
            }
        }
    }

    // Get color for borders
    function getColor(colorName) {
        const colors = {
            'blue': '#3b82f6',
            'green': '#10b981',
            'purple': '#8b5cf6'
        };
        return colors[colorName] || '#e5e7eb';
    }

    // Update amount preview
    function updatePreview() {
        const amount = parseFloat(chargeInput.value) || 0;
        const formattedAmount = new Intl.NumberFormat('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);
        
        previewAmount.textContent = `₹${formattedAmount}`;
        previewTotal.textContent = `₹${formattedAmount}`;
    }

    // Quick amount button click
    quickAmountBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const amount = btn.dataset.amount;
            chargeInput.value = amount;
            updatePreview();
            
            // Add visual feedback
            btn.classList.add('bg-blue-500', 'text-white');
            setTimeout(() => {
                btn.classList.remove('bg-blue-500', 'text-white');
            }, 300);
        });
    });

    // Clear all service type selections
    clearServiceTypeBtn.addEventListener('click', () => {
        serviceTypeCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            const wrapper = checkbox.closest('.service-type-checkbox-wrapper');
            const indicator = wrapper.querySelector('.service-checkbox-indicator');
            wrapper.classList.remove('service-checked');
            indicator.classList.add('hidden');
        });
        updateConsultationModeSection();
        updateStatus();
    });

    // Clear all consultation mode selections
    clearConsultationBtn.addEventListener('click', () => {
        consultationCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            const wrapper = checkbox.closest('.consultation-checkbox-wrapper');
            const indicator = wrapper.querySelector('.consultation-checkbox-indicator');
            wrapper.classList.remove('consultation-checked');
            indicator.classList.add('hidden');
        });
        updateStatus();
    });

    // Doctor selection change - update charge if consultation is selected
    doctorSelect.addEventListener('change', () => {
        const selectedOption = doctorSelect.options[doctorSelect.selectedIndex];
        const fees = parseFloat(selectedOption.dataset.fees) || 0;
        
        // Only auto-fill if consultation is selected
        const consultationSelected = Array.from(serviceTypeCheckboxes)
            .some(cb => cb.value === 'consultation' && cb.checked);
        
        if (consultationSelected && fees > 0) {
            chargeInput.value = fees;
            updatePreview();
        }
    });

    // Charge input change
    chargeInput.addEventListener('input', updatePreview);

    // Reset form button
    resetBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            document.querySelector('form').reset();
            initializeCheckboxes();
            chargeInput.value = '';
            updatePreview();
        }
    });

    // Service type checkbox click
    serviceTypeWrappers.forEach(wrapper => {
        wrapper.addEventListener('click', (e) => {
            const checkbox = wrapper.querySelector('.service-type-checkbox');
            const isCurrentlyChecked = checkbox.checked;
            
            if (isCurrentlyChecked) {
                // Uncheck
                checkbox.checked = false;
                updateServiceCheckboxVisual(wrapper, false);
            } else {
                // Check
                checkbox.checked = true;
                updateServiceCheckboxVisual(wrapper, true);
            }
            
            e.preventDefault();
        });
    });

    // Consultation mode checkbox click
    consultationWrappers.forEach(wrapper => {
        wrapper.addEventListener('click', (e) => {
            const checkbox = wrapper.querySelector('.consultation-checkbox');
            const isCurrentlyChecked = checkbox.checked;
            
            if (isCurrentlyChecked) {
                // Uncheck
                checkbox.checked = false;
                updateConsultationCheckboxVisual(wrapper, false);
            } else {
                // Check
                checkbox.checked = true;
                updateConsultationCheckboxVisual(wrapper, true);
            }
            
            e.preventDefault();
        });
    });

    // Initialize everything
    initializeCheckboxes();
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const serviceType = document.querySelector('input[name="type"]:checked');
    const consultationMode = document.querySelector('input[name="sub_type"]:checked');
    const charge = document.querySelector('input[name="charge"]').value;
    
    // Check if consultation is selected but no mode is selected
    if (serviceType && serviceType.value === 'consultation' && !consultationMode) {
        alert('Please select a consultation mode (Video Call, Voice Call, or Chat)');
        e.preventDefault();
        return;
    }
    
    // Check if charge amount is valid
    if (!charge || parseFloat(charge) <= 0) {
        alert('Please enter a valid charge amount');
        e.preventDefault();
        return;
    }
});
</script>
@endsection