@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Doctor Charge</h1>
                    <p class="text-gray-600 mt-1">Update existing charge details</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Form Section --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 md:p-8">
                        <form action="{{ route('admin.charges.update', $charge->id) }}" method="POST" id="chargeForm" class="space-y-6">
                            @csrf
                       

                            {{-- Doctor --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Select Doctor
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <select name="doctor_id"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none bg-white"
                                        required>
                                        <option value="">Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" @selected($charge->employee_id == $doctor->id)>
                                                Dr. {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('doctor_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Charge Type --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Charge Type
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="charge-type-option">
                                        <input type="radio" name="type" value="consultation" {{ $charge->type == 'consultation' ? 'checked' : '' }} class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition-all duration-200 text-center {{ $charge->type == 'consultation' ? 'border-blue-500 bg-blue-50' : '' }}">
                                            <div class="w-10 h-10 mx-auto mb-3 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900">Consultation</span>
                                        </div>
                                    </label>
                                    
                                    <label class="charge-type-option">
                                        <input type="radio" name="type" value="appointment" {{ $charge->type == 'appointment' ? 'checked' : '' }} class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition-all duration-200 text-center {{ $charge->type == 'appointment' ? 'border-green-500 bg-green-50' : '' }}">
                                            <div class="w-10 h-10 mx-auto mb-3 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900">Appointment</span>
                                        </div>
                                    </label>
                                    
                                    <label class="charge-type-option">
                                        <input type="radio" name="type" value="test" {{ $charge->type == 'test' ? 'checked' : '' }} class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 transition-all duration-200 text-center {{ $charge->type == 'test' ? 'border-purple-500 bg-purple-50' : '' }}">
                                            <div class="w-10 h-10 mx-auto mb-3 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900">Test</span>
                                        </div>
                                    </label>
                                </div>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Hidden select for form submission --}}
                            <select name="type" id="chargeType" class="hidden" required>
                                <option value="">Select Type</option>
                                <option value="consultation" {{ $charge->type == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="appointment" {{ $charge->type == 'appointment' ? 'selected' : '' }}>Appointment</option>
                                <option value="test" {{ $charge->type == 'test' ? 'selected' : '' }}>Test</option>
                            </select>

                            {{-- Sub Type (Consultation Only) --}}
                            <div id="subTypeDiv" class="{{ $charge->type == 'consultation' ? '' : 'hidden' }} transition-all duration-300 transform">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Consultation Type
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="sub-type-option">
                                        <input type="radio" name="sub_type" value="video" {{ $charge->sub_type == 'video' ? 'checked' : '' }} class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition-all duration-200 text-center {{ $charge->sub_type == 'video' ? 'border-blue-500 bg-blue-50' : '' }}">
                                            <div class="w-8 h-8 mx-auto mb-2 bg-blue-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Video</span>
                                        </div>
                                    </label>
                                    
                                    <label class="sub-type-option">
                                        <input type="radio" name="sub_type" value="voice" {{ $charge->sub_type == 'voice' ? 'checked' : '' }} class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition-all duration-200 text-center {{ $charge->sub_type == 'voice' ? 'border-blue-500 bg-blue-50' : '' }}">
                                            <div class="w-8 h-8 mx-auto mb-2 bg-green-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1 1 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Voice</span>
                                        </div>
                                    </label>
                                    
                                    <label class="sub-type-option">
                                        <input type="radio" name="sub_type" value="chat" {{ $charge->sub_type == 'chat' ? 'checked' : '' }} class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 transition-all duration-200 text-center {{ $charge->sub_type == 'chat' ? 'border-blue-500 bg-blue-50' : '' }}">
                                            <div class="w-8 h-8 mx-auto mb-2 bg-purple-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Chat</span>
                                        </div>
                                    </label>
                                </div>
                                @error('sub_type')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Charge Amount --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Charge Amount
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="charge" step="0.01" min="0" id="chargeAmount"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="0.00"
                                        value="{{ old('charge', $charge->charge) }}"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 mr-10">INR</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Enter the amount in Indian Rupees</p>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Description
                                    <span class="text-gray-400 font-normal ml-1">(Optional)</span>
                                </label>
                                <div class="relative">
                                    <textarea name="description" rows="4" id="descriptionText"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                        placeholder="Add details about this charge, duration, or special notes...">{{ old('description', $charge->description) }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                        <span id="charCount">{{ strlen($charge->description) }}</span>/500
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('admin.charges.index') }}"
                                    class="px-6 py-3 border border-gray-300 rounded-xl text-center font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Charge
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right: Summary Panel --}}
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        {{-- Summary Header --}}
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <div class="flex items-center">
                                <div class="bg-white p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white">Current Details</h3>
                            </div>
                            <p class="text-blue-100 text-sm mt-1">Existing charge information</p>
                        </div>

                        {{-- Summary Content --}}
                        <div class="p-6">
                            <div class="space-y-5">
                                {{-- Doctor Info --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Doctor</p>
                                            <p id="summaryDoctor" class="text-gray-900 font-semibold mt-1">
                                                @if($charge->doctor)
                                                    Dr. {{ $charge->doctor->name }}
                                                @else
                                                    Not assigned
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Charge Type --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Charge Type</p>
                                            <div class="flex items-center mt-1">
                                                <span id="summaryChargeType" class="text-gray-900 font-semibold capitalize">{{ $charge->type }}</span>
                                                @if($charge->sub_type)
                                                <span id="summarySubType" class="ml-2 text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800 capitalize">{{ $charge->sub_type }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Amount</p>
                                            <p id="summaryAmount" class="text-gray-900 font-semibold text-xl mt-1">₹{{ number_format($charge->charge, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Description</p>
                                            <p id="summaryDescription" class="text-gray-600 text-sm mt-1 italic">
                                                {{ $charge->description ? (strlen($charge->description) > 100 ? substr($charge->description, 0, 100) . '...' : $charge->description) : 'No description' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Created At --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Created</p>
                                            <p class="text-gray-900 font-medium mt-1">{{ $charge->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Quick Actions --}}
                                <div class="mt-6">
                                    <a href="{{ route('admin.charges.index') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-center font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 mb-3 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // DOM Elements
    const doctorSelect = document.querySelector('select[name="doctor_id"]');
    const chargeRadios = document.querySelectorAll('input[name="type"]');
    const subTypeRadios = document.querySelectorAll('input[name="sub_type"]');
    const chargeAmount = document.getElementById('chargeAmount');
    const descriptionText = document.getElementById('descriptionText');
    const hiddenSelect = document.getElementById('chargeType');
    const subTypeDiv = document.getElementById('subTypeDiv');
    
    // Summary Elements
    const summaryDoctor = document.getElementById('summaryDoctor');
    const summaryChargeType = document.getElementById('summaryChargeType');
    const summarySubType = document.getElementById('summarySubType');
    const summaryAmount = document.getElementById('summaryAmount');
    const summaryDescription = document.getElementById('summaryDescription');

    // Initialize with current data
    updateSummary();

    // Event Listeners
    doctorSelect.addEventListener('change', updateSummary);
    chargeAmount.addEventListener('input', updateSummary);
    descriptionText.addEventListener('input', updateSummary);

    // Charge Type Selection
    chargeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.checked) {
                // Update hidden select
                hiddenSelect.value = this.value;
                
                // Update UI for radio buttons
                document.querySelectorAll('.charge-type-option').forEach(div => {
                    div.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50', 
                                                             'border-green-500', 'bg-green-50',
                                                             'border-purple-500', 'bg-purple-50');
                });
                
                const parentDiv = this.closest('label').querySelector('div');
                if (this.value === 'consultation') {
                    parentDiv.classList.add('border-blue-500', 'bg-blue-50');
                    subTypeDiv.classList.remove('hidden');
                    setTimeout(() => {
                        subTypeDiv.classList.add('opacity-100', 'scale-100');
                    }, 10);
                } else if (this.value === 'appointment') {
                    parentDiv.classList.add('border-green-500', 'bg-green-50');
                    subTypeDiv.classList.add('hidden');
                } else if (this.value === 'test') {
                    parentDiv.classList.add('border-purple-500', 'bg-purple-50');
                    subTypeDiv.classList.add('hidden');
                }
                
                updateSummary();
            }
        });
    });

    // Sub Type Selection
    subTypeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.checked) {
                // Update UI for sub-type radio buttons
                document.querySelectorAll('.sub-type-option').forEach(div => {
                    div.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50');
                });
                
                const parentDiv = this.closest('label').querySelector('div');
                parentDiv.classList.add('border-blue-500', 'bg-blue-50');
                updateSummary();
            }
        });
    });

    // Character counter for description
    const charCount = document.getElementById('charCount');
    if (descriptionText && charCount) {
        descriptionText.addEventListener('input', function () {
            const length = this.value.length;
            charCount.textContent = length;
            
            if (length > 500) {
                charCount.classList.add('text-red-500');
                this.value = this.value.substring(0, 500);
            } else {
                charCount.classList.remove('text-red-500');
            }
            
            updateSummary();
        });
    }

    // Currency input formatting
    if (chargeAmount) {
        chargeAmount.addEventListener('blur', function () {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
                updateSummary();
            }
        });
    }

    // Update Summary Function
    function updateSummary() {
        // Update Doctor
        const selectedDoctorOption = doctorSelect.options[doctorSelect.selectedIndex];
        if (doctorSelect.value && summaryDoctor) {
            summaryDoctor.textContent = selectedDoctorOption.text;
        }

        // Update Charge Type
        const selectedType = document.querySelector('input[name="type"]:checked');
        if (selectedType && summaryChargeType) {
            let typeText = '';
            switch(selectedType.value) {
                case 'consultation':
                    typeText = 'Consultation';
                    break;
                case 'appointment':
                    typeText = 'Appointment';
                    break;
                case 'test':
                    typeText = 'Test';
                    break;
            }
            summaryChargeType.textContent = typeText;

                // Update Sub Type
                const selectedSubType = document.querySelector('input[name="sub_type"]:checked');
                if (selectedType.value === 'consultation' && selectedSubType) {
                    let subTypeText = '';
                    switch (selectedSubType.value) {
                        case 'video':
                            subTypeText = 'Video';
                            break;
                        case 'voice':
                            subTypeText = 'Voice';
                            break;
                        case 'chat':
                            subTypeText = 'Chat';
                            break;
                    }
                    if (summarySubType) {
                        summarySubType.textContent = subTypeText;
                        summarySubType.classList.remove('hidden');
                    }
                } else {
                    if (summarySubType) {
                        summarySubType.classList.add('hidden');
                    }
                }
        }

        // Update Amount
        if (chargeAmount.value && summaryAmount) {
            const amount = parseFloat(chargeAmount.value).toFixed(2);
            summaryAmount.textContent = `₹ ${amount}`;
        }

        // Update Description
        if (summaryDescription) {
            if (descriptionText.value.trim()) {
                const desc = descriptionText.value.length > 100
                    ? descriptionText.value.substring(0, 100) + '...'
                    : descriptionText.value;
                summaryDescription.textContent = desc;
            } else {
                summaryDescription.textContent = 'No description added';
            }
        }
    }

    // Initialize sub-type div animation
    if (subTypeDiv && !subTypeDiv.classList.contains('hidden')) {
        setTimeout(() => {
            subTypeDiv.classList.add('opacity-100', 'scale-100');
        }, 10);
    }
});
</script>

<style>
.charge-type-option input:checked + div,
.sub-type-option input:checked + div {
    border-width: 2px;
}

#subTypeDiv {
    opacity: 0;
    transform: scale(0.95);
}

#subTypeDiv:not(.hidden) {
    opacity: 1;
    transform: scale(1);
}

input:focus, textarea:focus, select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.summary-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.summary-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .sticky {
        position: static;
    }
}
</style>
@endsection