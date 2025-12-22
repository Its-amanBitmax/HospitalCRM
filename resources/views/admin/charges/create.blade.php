@extends('layouts.layout')

@section('content')
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

<div class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Add Doctor Charge</h1>
                    <p class="text-gray-600 mt-1">Assign charges to specific doctors</p>
                </div>
            </div>
        </div>

        {{-- Success Toast --}}
        <div id="successToast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg transform translate-y-full opacity-0 transition-all duration-300 z-50">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span id="toastMessage">Copied to clipboard!</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left: Form Section --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 md:p-8">
                        <form action="{{ route('admin.charges.store') }}" method="POST" class="space-y-6" id="chargeForm">
                            @csrf

                            {{-- Doctor Selection --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Select Doctor
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <select name="doctor_id" id="doctorSelect"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none bg-white"
                                        required>
                                        <option value="">Select a doctor</option>
                                        @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">
                                            Dr.{{ $doctor->name }}
                                            @if($doctor->specialization)
                                            - {{ $doctor->specialization }}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('doctor_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Type Selection --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Charge Type
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="charge-type-option">
                                        <input type="radio" name="type" value="consultation" class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition-all duration-200 text-center">
                                            <div class="w-10 h-10 mx-auto mb-3 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900">Consultation</span>
                                        </div>
                                    </label>

                                    <label class="charge-type-option">
                                        <input type="radio" name="type" value="appointment" class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition-all duration-200 text-center">
                                            <div class="w-10 h-10 mx-auto mb-3 bg-green-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900">Appointment</span>
                                        </div>
                                    </label>

                                    <label class="charge-type-option">
                                        <input type="radio" name="type" value="test" class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 transition-all duration-200 text-center">
                                            <div class="w-10 h-10 mx-auto mb-3 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900">Test</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Hidden select for form submission --}}
                            <select name="type" id="chargeType" class="hidden" required>
                                <option value="">Select Type</option>
                                <option value="consultation">Consultation</option>
                                <option value="appointment">Appointment</option>
                                <option value="test">Test</option>
                            </select>

                            {{-- Sub Type (Consultation only) --}}
                            <div id="subTypeDiv" class="hidden transition-all duration-300 transform">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Consultation Type
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <label class="sub-type-option">
                                        <input type="radio" name="sub_type" value="video" class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition-all duration-200 text-center">
                                            <div class="w-8 h-8 mx-auto mb-2 bg-blue-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Video Call</span>
                                        </div>
                                    </label>

                                    <label class="sub-type-option">
                                        <input type="radio" name="sub_type" value="voice" class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition-all duration-200 text-center">
                                            <div class="w-8 h-8 mx-auto mb-2 bg-green-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Voice Call</span>
                                        </div>
                                    </label>

                                    <label class="sub-type-option">
                                        <input type="radio" name="sub_type" value="chat" class="sr-only">
                                        <div class="p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 transition-all duration-200 text-center">
                                            <div class="w-8 h-8 mx-auto mb-2 bg-purple-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Chat</span>
                                        </div>
                                    </label>
                                </div>
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
                                        placeholder="Add details about this charge, duration, or special notes..."></textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                        <span id="charCount">0</span>/500
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ url()->previous() }}"
                                    class="px-6 py-3 border border-gray-300 rounded-xl text-center font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                    Save Charge
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
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white">Charge Summary</h3>
                            </div>
                            <p class="text-blue-100 text-sm mt-1">Live preview of your charge details</p>
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
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Doctor</p>
                                            <p id="summaryDoctor" class="text-gray-900 font-semibold mt-1">Not selected</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Charge Type --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Charge Type</p>
                                            <div class="flex items-center mt-1">
                                                <span id="summaryChargeType" class="text-gray-900 font-semibold">Not selected</span>
                                                <span id="summarySubType" class="ml-2 text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800 hidden"></span>
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
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Amount</p>
                                            <p id="summaryAmount" class="text-gray-900 font-semibold text-xl mt-1">₹ 0.00</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="summary-item">
                                    <div class="flex items-start">
                                        <div class="bg-gray-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-500">Description</p>
                                            <p id="summaryDescription" class="text-gray-600 text-sm mt-1 italic">No description added</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status Indicators --}}
                                <div class="bg-gray-50 rounded-xl p-4 mt-6">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Completion Status</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Doctor Selected</span>
                                            <span id="statusDoctor" class="w-3 h-3 rounded-full bg-red-400"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Charge Type</span>
                                            <span id="statusType" class="w-3 h-3 rounded-full bg-red-400"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600">Amount Set</span>
                                            <span id="statusAmount" class="w-3 h-3 rounded-full bg-red-400"></span>
                                        </div>
                                        <div class="pt-3 border-t border-gray-200">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-700">Total Progress</span>
                                                <span id="progressPercentage" class="text-sm font-semibold text-blue-600">0%</span>
                                            </div>
                                            <div class="mt-2 bg-gray-200 rounded-full h-2">
                                                <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Quick Actions --}}
                                <div class="mt-6">
                                    <button type="button" id="clearFormBtn"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl text-center font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 mb-3 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Clear Form
                                    </button>
                                    <button type="button" id="copySummaryBtn"
                                        class="w-full px-4 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-medium hover:from-gray-700 hover:to-gray-800 transition-all duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        Copy Summary
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Doctor Search Modal (unchanged) --}}
<div id="doctorSearchModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Search Doctor</h3>
                <input type="text" id="doctorSearchInput"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4"
                    placeholder="Type doctor name...">
                <div id="doctorSearchResults" class="max-h-60 overflow-y-auto"></div>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // DOM Elements
        const doctorSelect = document.getElementById('doctorSelect');
        const chargeRadios = document.querySelectorAll('input[name="type"]');
        const subTypeRadios = document.querySelectorAll('input[name="sub_type"]');
        const chargeAmount = document.getElementById('chargeAmount');
        const descriptionText = document.getElementById('descriptionText');
        const clearFormBtn = document.getElementById('clearFormBtn');
        const copySummaryBtn = document.getElementById('copySummaryBtn');
        const successToast = document.getElementById('successToast');
        const toastMessage = document.getElementById('toastMessage');

        // Summary Elements
        const summaryDoctor = document.getElementById('summaryDoctor');
        const summaryChargeType = document.getElementById('summaryChargeType');
        const summarySubType = document.getElementById('summarySubType');
        const summaryAmount = document.getElementById('summaryAmount');
        const summaryDescription = document.getElementById('summaryDescription');

        // Status Elements
        const statusDoctor = document.getElementById('statusDoctor');
        const statusType = document.getElementById('statusType');
        const statusAmount = document.getElementById('statusAmount');
        const progressBar = document.getElementById('progressBar');
        const progressPercentage = document.getElementById('progressPercentage');

        // Initialize
        updateSummary();
        updateProgress();

        // Event Listeners
        doctorSelect.addEventListener('change', function() {
            updateSummary();
            updateProgress();
        });

        chargeAmount.addEventListener('input', function() {
            updateSummary();
            updateProgress();
        });

        descriptionText.addEventListener('input', function() {
            updateSummary();
        });

        // Clear Form Button
        clearFormBtn.addEventListener('click', clearForm);

        // Copy Summary Button
        copySummaryBtn.addEventListener('click', copySummary);

        // Charge Type Selection
        chargeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    // Update hidden select
                    document.getElementById('chargeType').value = this.value;

                    // Update UI for radio buttons
                    document.querySelectorAll('.charge-type-option').forEach(div => {
                        div.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50',
                            'border-green-500', 'bg-green-50',
                            'border-purple-500', 'bg-purple-50');
                    });

                    const parentDiv = this.closest('label').querySelector('div');
                    if (this.value === 'consultation') {
                        parentDiv.classList.add('border-blue-500', 'bg-blue-50');
                        document.getElementById('subTypeDiv').classList.remove('hidden');
                        setTimeout(() => {
                            document.getElementById('subTypeDiv').classList.add('opacity-100', 'scale-100');
                        }, 10);
                    } else if (this.value === 'appointment') {
                        parentDiv.classList.add('border-green-500', 'bg-green-50');
                        document.getElementById('subTypeDiv').classList.add('hidden');
                    } else if (this.value === 'test') {
                        parentDiv.classList.add('border-purple-500', 'bg-purple-50');
                        document.getElementById('subTypeDiv').classList.add('hidden');
                    }

                    updateSummary();
                    updateProgress();
                }
            });
        });

        // Sub Type Selection
        subTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
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
            descriptionText.addEventListener('input', function() {
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
            chargeAmount.addEventListener('blur', function() {
                if (this.value) {
                    this.value = parseFloat(this.value).toFixed(2);
                    updateSummary();
                    updateProgress();
                }
            });
        }

        // Update Summary Function
        function updateSummary() {
            // Update Doctor
            const selectedDoctorOption = doctorSelect.options[doctorSelect.selectedIndex];
            if (doctorSelect.value) {
                summaryDoctor.textContent = selectedDoctorOption.text;
                statusDoctor.classList.remove('bg-red-400');
                statusDoctor.classList.add('bg-green-500');
            } else {
                summaryDoctor.textContent = 'Not selected';
                statusDoctor.classList.remove('bg-green-500');
                statusDoctor.classList.add('bg-red-400');
            }

            // Update Charge Type
            const selectedType = document.querySelector('input[name="type"]:checked');
            if (selectedType) {
                let typeText = '';
                switch (selectedType.value) {
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
                    summarySubType.textContent = subTypeText;
                    summarySubType.classList.remove('hidden');
                } else {
                    summarySubType.classList.add('hidden');
                }

                statusType.classList.remove('bg-red-400');
                statusType.classList.add('bg-green-500');
            } else {
                summaryChargeType.textContent = 'Not selected';
                summarySubType.classList.add('hidden');
                statusType.classList.remove('bg-green-500');
                statusType.classList.add('bg-red-400');
            }

            // Update Amount
            if (chargeAmount.value) {
                const amount = parseFloat(chargeAmount.value).toFixed(2);
                summaryAmount.textContent = `₹ ${amount}`;
                statusAmount.classList.remove('bg-red-400');
                statusAmount.classList.add('bg-green-500');
            } else {
                summaryAmount.textContent = '₹ 0.00';
                statusAmount.classList.remove('bg-green-500');
                statusAmount.classList.add('bg-red-400');
            }

            // Update Description
            if (descriptionText.value.trim()) {
                const desc = descriptionText.value.length > 100 ?
                    descriptionText.value.substring(0, 100) + '...' :
                    descriptionText.value;
                summaryDescription.textContent = desc;
            } else {
                summaryDescription.textContent = 'No description added';
            }
        }

        // Update Progress Function
        function updateProgress() {
            let completed = 0;
            const total = 3; // Doctor, Type, Amount

            if (doctorSelect.value) completed++;
            if (document.querySelector('input[name="type"]:checked')) completed++;
            if (chargeAmount.value) completed++;

            const percentage = Math.round((completed / total) * 100);
            progressBar.style.width = `${percentage}%`;
            progressPercentage.textContent = `${percentage}%`;
        }

        // Clear Form Function
        function clearForm() {
            if (confirm('Are you sure you want to clear the form? All entered data will be lost.')) {
                // Reset doctor selection
                doctorSelect.selectedIndex = 0;

                // Clear radio buttons
                chargeRadios.forEach(radio => radio.checked = false);
                subTypeRadios.forEach(radio => radio.checked = false);

                // Clear UI classes
                document.querySelectorAll('.charge-type-option').forEach(div => {
                    div.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50',
                        'border-green-500', 'bg-green-50',
                        'border-purple-500', 'bg-purple-50');
                });

                document.querySelectorAll('.sub-type-option').forEach(div => {
                    div.querySelector('div').classList.remove('border-blue-500', 'bg-blue-50');
                });

                // Hide sub-type div
                document.getElementById('subTypeDiv').classList.add('hidden');

                // Clear inputs
                chargeAmount.value = '';
                descriptionText.value = '';

                // Reset hidden select
                document.getElementById('chargeType').value = '';

                // Reset character count
                if (charCount) {
                    charCount.textContent = '0';
                    charCount.classList.remove('text-red-500');
                }

                // Update summary and progress
                updateSummary();
                updateProgress();

                // Show toast notification
                showToast('Form cleared successfully');
            }
        }

        // Copy Summary Function
        function copySummary() {
            const doctor = summaryDoctor.textContent;
            const chargeType = summaryChargeType.textContent;
            const subType = summarySubType.classList.contains('hidden') ? '' : summarySubType.textContent;
            const amount = summaryAmount.textContent;
            const description = summaryDescription.textContent;

            const summaryText = `💳 Doctor Charge Summary
────────────────────
👨‍⚕️ Doctor: ${doctor}
📋 Type: ${chargeType}${subType ? ` (${subType})` : ''}
💰 Amount: ${amount}
📝 Description: ${description}
────────────────────
📅 Created: ${new Date().toLocaleDateString('en-IN', { 
    year: 'numeric', 
    month: 'short', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
})}`;

            // Create a temporary textarea to copy
            const textArea = document.createElement('textarea');
            textArea.value = summaryText;
            document.body.appendChild(textArea);
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showToast('Summary copied to clipboard!');

                    // Visual feedback on button
                    copySummaryBtn.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Copied!
                `;
                    copySummaryBtn.classList.remove('from-gray-600', 'to-gray-700');
                    copySummaryBtn.classList.add('from-green-600', 'to-green-700');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        copySummaryBtn.innerHTML = `
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Copy Summary
                    `;
                        copySummaryBtn.classList.remove('from-green-600', 'to-green-700');
                        copySummaryBtn.classList.add('from-gray-600', 'to-gray-700');
                    }, 2000);
                } else {
                    showToast('Failed to copy. Please try again.', 'error');
                }
            } catch (err) {
                console.error('Copy failed:', err);
                showToast('Copy failed. Please try again.', 'error');
            }

            // Clean up
            document.body.removeChild(textArea);
        }

        // Show Toast Function
        function showToast(message, type = 'success') {
            toastMessage.textContent = message;

            // Set color based on type
            if (type === 'success') {
                successToast.classList.remove('bg-red-500');
                successToast.classList.add('bg-green-500');
            } else {
                successToast.classList.remove('bg-green-500');
                successToast.classList.add('bg-red-500');
            }

            // Show toast
            successToast.classList.remove('translate-y-full', 'opacity-0');
            successToast.classList.add('translate-y-0', 'opacity-100');

            // Hide after 3 seconds
            setTimeout(() => {
                successToast.classList.remove('translate-y-0', 'opacity-100');
                successToast.classList.add('translate-y-full', 'opacity-0');
            }, 3000);
        }

        // Form validation
        const form = document.getElementById('chargeForm');
        form.addEventListener('submit', function(e) {
            // Validate doctor selection
            if (!doctorSelect.value) {
                e.preventDefault();
                showError(doctorSelect, 'Please select a doctor');
                return false;
            }

            // Validate charge type
            const chargeSelect = document.getElementById('chargeType');
            if (!chargeSelect.value) {
                e.preventDefault();
                alert('Please select a charge type');
                return false;
            }

            // Validate consultation type if consultation is selected
            if (chargeSelect.value === 'consultation' &&
                !Array.from(subTypeRadios).some(radio => radio.checked)) {
                e.preventDefault();
                alert('Please select a consultation type');
                return false;
            }
        });

        function showError(element, message) {
            // Remove any existing error
            const existingError = element.parentElement.querySelector('.error-message');
            if (existingError) existingError.remove();

            // Add error styling
            element.classList.add('border-red-500');

            // Create error message
            const errorDiv = document.createElement('p');
            errorDiv.className = 'mt-1 text-sm text-red-600 error-message';
            errorDiv.textContent = message;

            element.parentElement.appendChild(errorDiv);

            // Focus on the element
            element.focus();

            // Remove error after interaction
            element.addEventListener('input', function() {
                this.classList.remove('border-red-500');
                if (errorDiv.parentElement) {
                    errorDiv.remove();
                }
            }, {
                once: true
            });
        }
    });
</script>

<style>
    .charge-type-option input:checked+div,
    .sub-type-option input:checked+div {
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

    input:focus,
    textarea:focus,
    select:focus {
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

    /* Status indicator animations */
    #statusDoctor,
    #statusType,
    #statusAmount {
        transition: all 0.3s ease;
    }

    /* Progress bar animation */
    #progressBar {
        transition: width 0.5s ease-in-out;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .sticky {
            position: static;
        }
    }

    /* Summary text truncation */
    #summaryDescription {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Toast animation */
    #successToast {
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    /* Button hover effects */
    #clearFormBtn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    #copySummaryBtn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection