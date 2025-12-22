@extends('layouts.nursionist') @section('title', 'My Assigned Patients') @section('content')
<div class="min-h-screen"> <!-- Header -->
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">My Assigned Patients</h1>
                    <p class="text-gray-600 mt-2">Manage and monitor all patients assigned to you</p>
                </div> <!-- Stats -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="px-4 py-2 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-600 font-medium">Total Patients</p>
                        <p class="text-xl font-bold text-blue-800">{{ $patients->count() }}</p>
                    </div> @if($patients->where('type', 'ipd')->count() > 0) <div class="px-4 py-2 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-600 font-medium">Inpatient (IPD)</p>
                        <p class="text-xl font-bold text-green-800">{{ $patients->where('type', 'ipd')->count() }}</p>
                    </div> @endif @if($patients->where('type', 'opd')->count() > 0) <div class="px-4 py-2 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-yellow-600 font-medium">Outpatient (OPD)</p>
                        <p class="text-xl font-bold text-yellow-800">{{ $patients->where('type', 'opd')->count() }}</p>
                    </div> @endif
                </div>
            </div>
        </div>
    </div> <!-- Search and Filters -->
    <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative flex-1"> <input type="text" placeholder="Search patients by name, ID, or contact..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200" id="searchInput"> <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg> </div>
            <div class="flex items-center gap-3"> <select id="typeFilter" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm min-w-[140px]">
                    <option value="all">All Types</option>
                    <option value="ipd">IPD Only</option>
                    <option value="opd">OPD Only</option>
                </select> <select id="statusFilter" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm min-w-[140px]">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="discharged">Discharged</option>
                    <option value="pending">Pending</option>
                </select> </div>
        </div>
    </div> <!-- Patients Cards/Table View -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"> <!-- View Toggle -->
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600"> Showing {{ $patients->count() }} patients </div>
                <div class="flex items-center gap-2"> <button id="cardViewBtn" class="p-2 rounded-lg bg-blue-100 text-blue-600"> <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg> </button> <button id="tableViewBtn" class="p-2 rounded-lg text-gray-400 hover:text-gray-600"> <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg> </button> </div>
            </div>
        </div> <!-- Cards View (Default) -->
        <div id="cardsView" class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"> @forelse($patients as $patient) <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 patient-card" data-type="{{ $patient->type }}" data-status="{{ $patient->status }}"> <!-- Card Header -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if($patient->image)
                            <img src="{{ asset($patient->image) }}" alt="{{ $patient->full_name }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-lg"> {{ strtoupper(substr($patient->full_name, 0, 1)) }} </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $patient->full_name }}</h3>
                                <div class="flex items-center gap-2 mt-1"> <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">ID: {{ $patient->id }}</span> @if($patient->type == 'ipd')
                                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">IPD</span>

                                    @elseif($patient->type == 'emergency')
                                    <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Emergency</span>

                                    @elseif($patient->type == 'opd')
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded">OPD</span>

                                    @else
                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded">Unknown</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="relative group">
                            <button class="text-gray-400 hover:text-gray-600"> <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg> </button>
                            <!-- <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 hidden group-hover:block z-10">
                                <div class="py-1"> <button class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 open-patient-modal" data-patient-id="{{ $patient->id }}" data-patient-name="{{ json_encode($patient->full_name) }}" data-patient-age="{{ $patient->age }}" data-patient-gender="{{ json_encode($patient->gender) }}" data-patient-blood="{{ json_encode($patient->blood_group ?? 'N/A') }}" data-patient-type="{{ json_encode($patient->type) }}" data-patient-mobile="{{ json_encode($patient->mobile_no) }}" data-patient-alt-mobile="{{ json_encode($patient->alternate_no ?? 'N/A') }}" data-patient-email="{{ json_encode($patient->email) }}" data-patient-emergency="{{ json_encode($patient->father_spouse_name ?? 'N/A') }}" data-patient-address="{{ json_encode($patient->full_address) }}" data-patient-city="{{ json_encode($patient->city) }}" data-patient-state="{{ json_encode($patient->state) }}" data-patient-pin="{{ $patient->pin_code }}" data-patient-registered="{{ json_encode($patient->registered_through) }}" data-patient-status="{{ json_encode($patient->status) }}" data-patient-id-proof-type="{{ json_encode($patient->id_proof_type ?? 'N/A') }}" data-patient-id-number="{{ json_encode($patient->id_number ?? 'N/A') }}"> View Details </button> <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Medical Records</a> <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Schedule Visit</a> </div>
                            </div> -->
                        </div>
                    </div>
                </div> <!-- Card Body -->
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="space-y-1">
                            <p class="text-xs text-gray-500">Age & Gender</p>
                            <p class="text-sm font-medium text-gray-800"> {{ $patient->age }} yrs • {{ ucfirst($patient->gender) }} </p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-gray-500">Blood Group</p>
                            <p class="text-sm font-medium text-gray-800">{{ $patient->blood_group ?? 'N/A' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-gray-500">Contact</p>
                            <p class="text-sm font-medium text-gray-800">{{ $patient->mobile_no }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs text-gray-500">Status</p> <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if($patient->status == 'active') bg-green-100 text-green-800 @elseif($patient->status == 'discharged') bg-gray-100 text-gray-800 @else bg-yellow-100 text-yellow-800 @endif"> {{ ucfirst($patient->status) }} </span>
                        </div>
                    </div> <!-- Address -->
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Address</p>
                        <p class="text-sm text-gray-700 truncate" title="{{ $patient->full_address }}"> {{ Str::limit($patient->full_address, 60) }} </p>
                    </div> <!-- Additional Info -->
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center gap-2"> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg> <span>{{ $patient->email }}</span> </div> <span>{{ $patient->city }}, {{ $patient->state }}</span>
                    </div>
                </div> <!-- Card Footer -->
                <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500"> Registered: {{ $patient->registered_through }} </div> <button class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-200 open-patient-modal" data-patient-id="{{ $patient->id }}" data-patient-name="{{ json_encode($patient->full_name) }}" data-patient-age="{{ $patient->age }}" data-patient-gender="{{ json_encode($patient->gender) }}" data-patient-blood="{{ json_encode($patient->blood_group ?? 'N/A') }}" data-patient-type="{{ json_encode($patient->type) }}" data-patient-mobile="{{ json_encode($patient->mobile_no) }}" data-patient-alt-mobile="{{ json_encode($patient->alternate_no ?? 'N/A') }}" data-patient-email="{{ json_encode($patient->email) }}" data-patient-emergency="{{ json_encode($patient->father_spouse_name ?? 'N/A') }}" data-patient-address="{{ json_encode($patient->full_address) }}" data-patient-city="{{ json_encode($patient->city) }}" data-patient-state="{{ json_encode($patient->state) }}" data-patient-pin="{{ $patient->pin_code }}" data-patient-registered="{{ json_encode($patient->registered_through) }}" data-patient-status="{{ json_encode($patient->status) }}" data-patient-id-proof-type="{{ json_encode($patient->id_proof_type ?? 'N/A') }}" data-patient-id-number="{{ json_encode($patient->id_number ?? 'N/A') }}"> Quick View </button>
                    </div>
                </div>
            </div> @empty <!-- Empty State -->
            <div class="col-span-full py-12 text-center">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center"> <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.913a8 8 0 01-13.67-3.913L3 21" />
                        </svg> </div>
                    <div>
                        <p class="text-gray-500 font-medium">No patients assigned</p>
                        <p class="text-gray-400 text-sm mt-1">You don't have any patients assigned yet</p>
                    </div>
                </div>
            </div> @endforelse
        </div> <!-- Table View (Hidden by default) -->
        <div id="tableView" class="hidden overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Patient Details </th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Contact Info </th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Location </th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Medical Info </th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Status </th>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"> Actions </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200"> @forelse($patients as $patient) <tr class="hover:bg-gray-50 transition-colors duration-150 patient-row" data-type="{{ $patient->type }}" data-status="{{ $patient->status }}"> <!-- Patient Details -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                @if($patient->image)
                                <img src="{{ asset($patient->image) }}" alt="{{ $patient->full_name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold"> {{ strtoupper(substr($patient->full_name, 0, 1)) }} </div>
                                @endif
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-medium text-gray-900">{{ $patient->full_name }}</h4> <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">ID: {{ $patient->id }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1"> <span>{{ $patient->age }} years</span> <span>•</span> <span>{{ ucfirst($patient->gender) }}</span> </div>
                                </div>
                            </div>
                        </td> <!-- Contact Info -->
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2"> <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg> <span class="text-sm text-gray-700">{{ $patient->mobile_no }}</span> </div>
                                <div class="flex items-center gap-2"> <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg> <span class="text-sm text-gray-700 truncate max-w-[180px]">{{ $patient->email }}</span> </div>
                            </div>
                        </td> <!-- Location -->
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                <p class="text-sm text-gray-700">{{ $patient->city }}, {{ $patient->state }}</p>
                                <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $patient->full_address }}</p>
                            </div>
                        </td> <!-- Medical Info -->
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                <div class="text-sm text-gray-700"> <span class="font-medium">Blood:</span> {{ $patient->blood_group ?? 'N/A' }} </div>
                                <div class="text-sm text-gray-700"> <span class="font-medium">Type:</span> {{ strtoupper($patient->type) }} </div>
                                <div class="text-sm text-gray-700"> <span class="font-medium">Reg:</span> {{ $patient->registered_through }} </div>
                            </div>
                        </td> <!-- Status -->
                        <td class="py-4 px-4">
                            <div class="space-y-2"> <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($patient->status == 'active') bg-green-100 text-green-800 @elseif($patient->status == 'discharged') bg-gray-100 text-gray-800 @else bg-yellow-100 text-yellow-800 @endif"> {{ ucfirst($patient->status) }} </span> @if($patient->father_spouse_name) <p class="text-xs text-gray-500">Contact: {{ $patient->father_spouse_name }}</p> @endif </div>
                        </td> <!-- Actions -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2"> <button class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 open-patient-modal" data-patient-id="{{ $patient->id }}" data-patient-name="{{ json_encode($patient->full_name) }}" data-patient-age="{{ $patient->age }}" data-patient-gender="{{ json_encode($patient->gender) }}" data-patient-blood="{{ json_encode($patient->blood_group ?? 'N/A') }}" data-patient-type="{{ json_encode($patient->type) }}" data-patient-mobile="{{ json_encode($patient->mobile_no) }}" data-patient-alt-mobile="{{ json_encode($patient->alternate_no ?? 'N/A') }}" data-patient-email="{{ json_encode($patient->email) }}" data-patient-emergency="{{ json_encode($patient->father_spouse_name ?? 'N/A') }}" data-patient-address="{{ json_encode($patient->full_address) }}" data-patient-city="{{ json_encode($patient->city) }}" data-patient-state="{{ json_encode($patient->state) }}" data-patient-pin="{{ $patient->pin_code }}" data-patient-registered="{{ json_encode($patient->registered_through) }}" data-patient-status="{{ json_encode($patient->status) }}" data-patient-id-proof-type="{{ json_encode($patient->id_proof_type ?? 'N/A') }}" data-patient-id-number="{{ json_encode($patient->id_number ?? 'N/A') }}"> View </button>
                            </div>
                        </td>
                    </tr> @empty <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center"> <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.913a8 8 0 01-13.67-3.913L3 21" />
                                    </svg> </div>
                                <div>
                                    <p class="text-gray-500 font-medium">No patients assigned</p>
                                    <p class="text-gray-400 text-sm mt-1">You don't have any patients assigned yet</p>
                                </div>
                            </div>
                        </td>
                    </tr> @endforelse </tbody>
            </table>
        </div>
    </div>
</div> <!-- Patient Details Modal -->
<div id="patientModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Patient Details</h2>
                    <p class="text-gray-600 text-sm mt-1" id="modalPatientName">Patient Information</p>
                </div> <button onclick="closePatientModal()" class="text-gray-400 hover:text-gray-600 transition-colors"> <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg> </button>
            </div>
        </div> <!-- Modal Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> <!-- Left Column -->
                <div class="space-y-6"> <!-- Basic Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Basic Information</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500">Patient ID</p>
                                <p id="modalPatientId" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Age & Gender</p>
                                <p id="modalAgeGender" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Blood Group</p>
                                <p id="modalBloodGroup" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Patient Type</p>
                                <p id="modalPatientType" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                        </div>
                    </div> <!-- Contact Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Contact Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Mobile Number</p>
                                <p id="modalMobileNo" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Alternate Number</p>
                                <p id="modalAlternateNo" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email Address</p>
                                <p id="modalEmail" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Emergency Contact</p>
                                <p id="modalEmergencyContact" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                        </div>
                    </div> <!-- Registration Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Registration Details</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500">Registered Through</p>
                                <p id="modalRegisteredThrough" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Status</p>
                                <p id="modalStatus" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                        </div>
                    </div>
                </div> <!-- Right Column -->
                <div class="space-y-6"> <!-- Address -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Address Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Full Address</p>
                                <p id="modalFullAddress" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500">City</p>
                                    <p id="modalCity" class="text-sm font-medium text-gray-800">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">State</p>
                                    <p id="modalState" class="text-sm font-medium text-gray-800">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">PIN Code</p>
                                    <p id="modalPinCode" class="text-sm font-medium text-gray-800">-</p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ID Proof -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Identification</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500">ID Proof Type</p>
                                <p id="modalIdProofType" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">ID Number</p>
                                <p id="modalIdNumber" class="text-sm font-medium text-gray-800">-</p>
                            </div>
                        </div>
                    </div> <!-- Medical Summary -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h3 class="text-sm font-semibold text-blue-700 mb-3">Medical Summary</h3>
                        <div class="space-y-2">
                            <p class="text-sm text-blue-600">Assigned Nurse: <span class="font-medium text-blue-800">You</span></p>
                            <p class="text-sm text-blue-600">Patient Status: <span id="modalPatientStatus" class="font-medium text-blue-800">-</span></p>
                        </div>
                    </div> <!-- Quick Actions -->
                    <!-- <div class="bg-white p-2 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Quick Actions</h3>
                        <div class="flex flex-wrap gap-2"> <button class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"> View Medical History </button> <button class="px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition-colors duration-200"> Schedule Visit </button> <button class="px-3 py-1.5 bg-purple-600 text-white text-xs font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200"> Add Notes </button> </div>
                    </div> -->
                </div>
            </div>
        </div> <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200">
            <div class="flex justify-end"> <button onclick="closePatientModal()" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200"> Close </button> </div>
        </div>
    </div>
</div>
<script>
    // View Toggle 
    document.getElementById('cardViewBtn').addEventListener('click', function() {
        document.getElementById('cardsView').classList.remove('hidden');
        document.getElementById('tableView').classList.add('hidden');
        this.classList.add('bg-blue-100', 'text-blue-600');
        document.getElementById('tableViewBtn').classList.remove('bg-blue-100', 'text-blue-600');
    });
    document.getElementById('tableViewBtn').addEventListener('click', function() {
        document.getElementById('tableView').classList.remove('hidden');
        document.getElementById('cardsView').classList.add('hidden');
        this.classList.add('bg-blue-100', 'text-blue-600');
        document.getElementById('cardViewBtn').classList.remove('bg-blue-100', 'text-blue-600');
    });
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.patient-card');
        const rows = document.querySelectorAll('.patient-row');
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? '' : 'none';
        });
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    // Type Filter
    document.getElementById('typeFilter').addEventListener('change', function(e) {
        const selectedType = e.target.value;
        const cards = document.querySelectorAll('.patient-card');
        const rows = document.querySelectorAll('.patient-row');

        cards.forEach(card => {
            const type = card.dataset.type;
            const status = card.dataset.status;
            const matchesType = selectedType === 'all' || type === selectedType;
            const matchesStatus = document.getElementById('statusFilter').value === 'all' || status === document.getElementById('statusFilter').value;
            card.style.display = (matchesType && matchesStatus) ? '' : 'none';
        });
        rows.forEach(row => {
            const type = row.dataset.type;
            const status = row.dataset.status;
            const matchesType = selectedType === 'all' || type === selectedType;
            const matchesStatus = document.getElementById('statusFilter').value === 'all' || status === document.getElementById('statusFilter').value;
            row.style.display = (matchesType && matchesStatus) ? '' : 'none';
        });
    });

    // Status Filter
    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const selectedStatus = e.target.value;
        const cards = document.querySelectorAll('.patient-card');
        const rows = document.querySelectorAll('.patient-row');

        cards.forEach(card => {
            const type = card.dataset.type;
            const status = card.dataset.status;
            const matchesType = document.getElementById('typeFilter').value === 'all' || type === document.getElementById('typeFilter').value;
            const matchesStatus = selectedStatus === 'all' || status === selectedStatus;
            card.style.display = (matchesType && matchesStatus) ? '' : 'none';
        });
        rows.forEach(row => {
            const type = row.dataset.type;
            const status = row.dataset.status;
            const matchesType = document.getElementById('typeFilter').value === 'all' || type === document.getElementById('typeFilter').value;
            const matchesStatus = selectedStatus === 'all' || status === selectedStatus;
            row.style.display = (matchesType && matchesStatus) ? '' : 'none';
        });
    });

    // Modal Functions
    function openPatientModal(id, name, age, gender, blood, type, mobile, altMobile, email, emergencyContact, address, city, state, pin, registeredThrough, status, idProofType, idNumber) {
        document.getElementById('patientModal').classList.remove('hidden');
        document.getElementById('modalPatientName').innerText = name;
        document.getElementById('modalPatientId').innerText = id;
        document.getElementById('modalAgeGender').innerText = age + ' yrs • ' + gender;
        document.getElementById('modalBloodGroup').innerText = blood;
        document.getElementById('modalPatientType').innerText = type.toUpperCase();
        document.getElementById('modalMobileNo').innerText = mobile;
        document.getElementById('modalAlternateNo').innerText = altMobile;
        document.getElementById('modalEmail').innerText = email;
        document.getElementById('modalEmergencyContact').innerText = emergencyContact;
        document.getElementById('modalFullAddress').innerText = address;
        document.getElementById('modalCity').innerText = city;
        document.getElementById('modalState').innerText = state;
        document.getElementById('modalPinCode').innerText = pin;
        document.getElementById('modalRegisteredThrough').innerText = registeredThrough;
        document.getElementById('modalStatus').innerText = status.charAt(0).toUpperCase() + status.slice(1);
        document.getElementById('modalPatientStatus').innerText = status.charAt(0).toUpperCase() + status.slice(1);
        document.getElementById('modalIdProofType').innerText = idProofType;
        document.getElementById('modalIdNumber').innerText = idNumber;
    }

    function closePatientModal() {
        document.getElementById('patientModal').classList.add('hidden');
    }

    // Event delegation for opening patient modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('open-patient-modal')) {
            const data = e.target.dataset;
            openPatientModal(
                data.patientId,
                JSON.parse(data.patientName),
                data.patientAge,
                JSON.parse(data.patientGender),
                JSON.parse(data.patientBlood),
                JSON.parse(data.patientType),
                JSON.parse(data.patientMobile),
                JSON.parse(data.patientAltMobile),
                JSON.parse(data.patientEmail),
                JSON.parse(data.patientEmergency),
                JSON.parse(data.patientAddress),
                JSON.parse(data.patientCity),
                JSON.parse(data.patientState),
                data.patientPin,
                JSON.parse(data.patientRegistered),
                JSON.parse(data.patientStatus),
                JSON.parse(data.patientIdProofType),
                JSON.parse(data.patientIdNumber)
            );
        }
    });
</script>
</body>
<html>
@endsection