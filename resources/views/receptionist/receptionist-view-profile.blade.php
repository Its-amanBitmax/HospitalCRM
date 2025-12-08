@extends('layouts.receptionist')

@section('content')
<div class="min-h-screen  ">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    @if($employee->image)
                        <div class="relative">
                            <img src="{{ Storage::url($employee->image) }}"
                                 alt="Profile Image"
                                 class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full p-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 shadow-lg">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Basic Info -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-4xl font-bold mb-2">{{ $employee->name }}</h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-blue-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Employee Code: {{ $employee->employee_code }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Department: {{ $employee->department?->department_name ?? '-' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Status:
                            <span class="ml-1 px-3 py-1 rounded-full text-sm font-medium {{ $employee->status == 'Active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                {{ $employee->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Contact & Personal Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Contact Details -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-full mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Contact Details</h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800">{{ $employee->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-gray-800">{{ $employee->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Info -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-full mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Personal Info</h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium text-gray-800">{{ $employee->gender ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="font-medium text-gray-800">{{ $employee->date_of_birth?->format('d M, Y') ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8m0 0V4"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-gray-500">Hire Date</p>
                        <p class="font-medium text-gray-800">{{ $employee->hire_date?->format('d M, Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Addresses -->
    @if($employee->addresses->isNotEmpty())
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <div class="flex items-center mb-6">
            <div class="bg-purple-100 p-3 rounded-full mr-3">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Addresses</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($employee->addresses as $address)
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-start">
                    <div class="bg-purple-500 text-white rounded-full p-2 mr-3 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-purple-800 mb-2">{{ $address->address_type ?? 'Address' }}</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            {{ $address->street ?? '' }}<br>
                            {{ $address->city ?? '' }}, {{ $address->state ?? '' }}, {{ $address->country ?? '' }} - {{ $address->postal_code ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Qualifications -->
    @if($employee->qualifications->isNotEmpty())
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
        <div class="flex items-center mb-6">
            <div class="bg-orange-100 p-3 rounded-full mr-3">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Qualifications</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($employee->qualifications as $qualification)
            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 p-4 rounded-lg border border-orange-200 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start">
                    <div class="bg-orange-500 text-white rounded-full p-2 mr-3 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 mb-1"><strong>Degree:</strong> {{ $qualification->degree ?? '' }}</p>
                        <p class="text-sm text-gray-600 mb-1"><strong>Institution:</strong> {{ $qualification->institution ?? '' }}</p>
                        <p class="text-sm text-gray-600"><strong>Year Completed:</strong> {{ $qualification->year_completed ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Documents -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500">
        <div class="flex items-center mb-6">
            <div class="bg-gray-100 p-3 rounded-full mr-3">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Documents</h3>
        </div>

        @if($employee->documents->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($employee->documents as $document)
                    @php
                        $fileExists = Storage::disk('public')->exists($document->document_path);
                        $isImage = in_array(strtolower(pathinfo($document->document_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp

                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-4 rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($isImage && $fileExists)
                                    <img src="{{ Storage::url($document->document_path) }}" alt="{{ $document->document_type ?? 'Document' }}" class="w-12 h-12 rounded-lg object-cover mr-3 border border-gray-300">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $document->document_type ?? 'Document' }}</p>
                                    </div>
                            </div>
                            @if($fileExists)
                                <a href="{{ Storage::url($document->document_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="text-red-500 text-sm">File missing</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 p-8 rounded-lg text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Documents Uploaded</h4>
                <p class="text-gray-600 mb-4">No documents have been uploaded for this employee yet.</p>
                <p class="text-sm text-gray-500">Documents can be uploaded through the Admin panel by editing this employee.</p>
            </div>
        @endif
    </div>

    <!-- Family Details -->
    @if($employee->familyDetails->isNotEmpty())
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-pink-500">
        <div class="flex items-center mb-6">
            <div class="bg-pink-100 p-3 rounded-full mr-3">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Family Details</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($employee->familyDetails as $family)
            <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-lg border border-pink-200 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start">
                    <div class="bg-pink-500 text-white rounded-full p-2 mr-3 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-pink-800 mb-2">{{ $family->name ?? '-' }}</h4>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p><span class="font-medium">Relationship:</span> {{ $family->relationship ?? '-' }}</p>
                            <p><span class="font-medium">Date of Birth:</span> {{ $family->date_of_birth ? $family->date_of_birth->format('d M Y') : '-' }}</p>
                            <p><span class="font-medium">Contact:</span> {{ $family->contact_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Payroll -->
    @if($employee->payroll)
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-teal-500">
        <div class="flex items-center mb-6">
            <div class="bg-teal-100 p-3 rounded-full mr-3">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Payroll Information</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if(is_iterable($employee->payroll))
                @foreach($employee->payroll as $payroll)
                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-4 rounded-lg border border-teal-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start">
                        <div class="bg-teal-500 text-white rounded-full p-2 mr-3 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-teal-800 mb-2">Salary: {{ $payroll->salary ?? '-' }}</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><span class="font-medium">Bank Account:</span> {{ $payroll->bank_account ?? '-' }}</p>
                                <p><span class="font-medium">Bank Name:</span> {{ $payroll->bank_name ?? '-' }}</p>
                                <p><span class="font-medium">IFSC Code:</span> {{ $payroll->ifsc_code ?? '-' }}</p>
                                <p><span class="font-medium">UPI Number:</span> {{ $payroll->upi_number ?? '-' }}</p>
                                <p><span class="font-medium">PF Number:</span> {{ $payroll->pf_number ?? '-' }}</p>
                                <p><span class="font-medium">Payment Frequency:</span> {{ $payroll->payment_frequency ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-4 rounded-lg border border-teal-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start">
                        <div class="bg-teal-500 text-white rounded-full p-2 mr-3 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-teal-800 mb-2">Salary: {{ $employee->payroll->salary ?? '-' }}</h4>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><span class="font-medium">Bank Account:</span> {{ $employee->payroll->bank_account ?? '-' }}</p>
                                <p><span class="font-medium">Bank Name:</span> {{ $employee->payroll->bank_name ?? '-' }}</p>
                                <p><span class="font-medium">IFSC Code:</span> {{ $employee->payroll->ifsc_code ?? '-' }}</p>
                                <p><span class="font-medium">UPI Number:</span> {{ $employee->payroll->upi_number ?? '-' }}</p>
                                <p><span class="font-medium">PF Number:</span> {{ $employee->payroll->pf_number ?? '-' }}</p>
                                <p><span class="font-medium">Payment Frequency:</span> {{ $employee->payroll->payment_frequency ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection