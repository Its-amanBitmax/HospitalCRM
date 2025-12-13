@extends('layouts.nursionist')
@section('title', 'All Beds Management')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header with success/error messages -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Bed Management</h1>
            <p class="text-gray-600 mt-1">Overview of all hospital beds and their current status</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-2 md:flex md:items-center md:space-x-4 mt-4 md:mt-0 gap-2">
            <div class="bg-blue-50 px-3 py-2 rounded-lg">
                <span class="text-xs text-gray-600">Total:</span>
                <span class="ml-1 font-bold text-blue-700">{{ $beds->count() }}</span>
            </div>
            <div class="bg-green-50 px-3 py-2 rounded-lg">
                <span class="text-xs text-gray-600">Active:</span>
                <span class="ml-1 font-bold text-green-700">
                    {{ $beds->where('status', 'Active')->count() }}
                </span>
            </div>
            <div class="bg-red-50 px-3 py-2 rounded-lg">
                <span class="text-xs text-gray-600">Occupied:</span>
                <span class="ml-1 font-bold text-red-700">
                    {{ $beds->where('status', 'Occupied')->count() }}
                </span>
            </div>
            <div class="bg-yellow-50 px-3 py-2 rounded-lg">
                <span class="text-xs text-gray-600">Maintenance:</span>
                <span class="ml-1 font-bold text-yellow-700">
                    {{ $beds->where('status', 'Maintenance')->count() }}
                </span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
            <!-- Filters -->
            <div class="flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-3 w-full">
                <div class="relative flex-1">
                    <input type="text"
                        placeholder="Search beds by ID, ward, or patient..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
                        id="searchInput">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto text-sm"
                    id="statusFilter">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Occupied">Occupied</option>
                    <option value="Maintenance">Maintenance</option>
                </select>

                <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-auto text-sm"
                    id="typeFilter">
                    <option value="">All Types</option>
                    <option value="General">General</option>
                    <option value="Critical">Critical</option>
                    <option value="Deluxe">Deluxe</option>
                </select>

                <button onclick="resetFilters()" class="text-sm text-gray-600 hover:text-gray-800 flex items-center justify-center md:justify-start px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </button>
            </div>
        </div>

        <!-- Filter Results Count -->
        <div class="mt-4 pt-4 border-t border-gray-100">
            <span class="text-sm text-gray-500" id="filterCount">
                {{ $beds->count() }} beds found
            </span>
        </div>
    </div>

    <!-- Card View -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4" id="bedCardsContainer">
            @foreach($beds as $bed)
            @php
                $currentAssignment = $bed->bedAssignments->where('status', 'active')->first();
                $assignedUser = $currentAssignment->user ?? null;
            @endphp
            
            <div class="card-item border border-gray-200 rounded-lg hover:shadow-md transition-all duration-200 transform hover:-translate-y-1"
                data-status="{{ $bed->status }}"
                data-type="{{ $bed->type }}"
                data-bed-id="{{ $bed->id }}"
                data-bed-number="{{ $bed->bed_id }}"
                data-ward-id="{{ $bed->ward_id }}"
                data-ward-name="{{ $bed->ward ? $bed->ward->name : 'Ward ' . $bed->ward_id }}"
                @if($bed->ward && $bed->ward->floor)
                data-ward-floor="{{ $bed->ward->floor }}"
                @endif
                data-search="{{ strtolower($bed->bed_id . ' ' . ($bed->ward ? $bed->ward->name : '') . ' ' . ($assignedUser ? $assignedUser->email : '')) }}"
                @if($assignedUser)
                data-user-id="{{ $assignedUser->id }}"
                data-user-email="{{ $assignedUser->email }}"
                data-user-type="{{ $assignedUser->type }}"
                data-user-full-name="{{ $assignedUser->full_name ?? 'N/A' }}"
                data-user-mobile-no="{{ $assignedUser->mobile_no ?? 'N/A' }}"
                data-user-age="{{ $assignedUser->age ?? 'N/A' }}"
                data-user-gender="{{ $assignedUser->gender ?? 'N/A' }}"
                data-user-blood-group="{{ $assignedUser->blood_group ?? 'N/A' }}"
                data-user-father-spouse="{{ $assignedUser->father_spouse_name ?? 'N/A' }}"
                data-user-full-address="{{ $assignedUser->full_address ?? 'N/A' }}"
                data-user-city="{{ $assignedUser->city ?? 'N/A' }}"
                data-user-state="{{ $assignedUser->state ?? 'N/A' }}"
                data-user-pin-code="{{ $assignedUser->pin_code ?? 'N/A' }}"
                data-user-alternate-no="{{ $assignedUser->alternate_no ?? 'N/A' }}"
                @if($currentAssignment)
                data-assignment-id="{{ $currentAssignment->id }}"
                data-assigned-date="{{ $currentAssignment->assigned_date->format('Y-m-d') }}"
                data-assigned-date-formatted="{{ $currentAssignment->assigned_date->format('M d, Y') }}"
                data-assignment-status="{{ $currentAssignment->status }}"
                @endif
                @endif>
                
                <!-- Card Header -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-800 font-bold text-sm">
                                    B{{ substr($bed->id, -3) }}
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-900">{{ $bed->bed_id }}</h3>
                                    <p class="text-xs text-gray-500">ID: {{ $bed->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            @php
                            $statusColors = [
                            'Active' => 'bg-green-100 text-green-800',
                            'Occupied' => 'bg-red-100 text-red-800',
                            'Maintenance' => 'bg-yellow-100 text-yellow-800'
                            ];
                            $statusColor = $statusColors[$bed->status] ?? $statusColors['Active'];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                <span class="w-2 h-2 rounded-full mr-1.5 
                                    @if($bed->status == 'Active') bg-green-500
                                    @elseif($bed->status == 'Occupied') bg-red-500
                                    @elseif($bed->status == 'Maintenance') bg-yellow-500 @endif
                                "></span>
                                {{ $bed->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4">
                    <!-- Bed Info -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Ward</p>
                            <p class="font-medium text-gray-900">
                                @if($bed->ward)
                                {{ $bed->ward->name }}
                                @if($bed->ward->floor)
                                (Floor {{ $bed->ward->floor }})
                                @endif
                                @else
                                Ward {{ $bed->ward_id }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Type</p>
                            @php
                            $typeColors = [
                            'General' => 'bg-gray-100 text-gray-800',
                            'Critical' => 'bg-red-100 text-red-800',
                            'Deluxe' => 'bg-purple-100 text-purple-800'
                            ];
                            $typeColor = $typeColors[$bed->type] ?? $typeColors['General'];
                            @endphp
                            <span class="inline-flex px-2 py-1 rounded text-xs font-medium {{ $typeColor }}">
                                {{ $bed->type }}
                            </span>
                        </div>
                    </div>

                    <!-- Patient Information -->
                    @if($assignedUser)
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center mb-2">
                            <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-800 font-medium text-sm">
                                {{ substr($assignedUser->full_name ?? $assignedUser->email ?? 'U', 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $assignedUser->full_name ?? $assignedUser->email ?? 'Unknown Patient' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    ID: {{ $assignedUser->id }}
                                    <span class="ml-2 inline-flex px-2 py-0.5 rounded text-xs font-medium 
                                            @if($assignedUser->type == 'ipd') bg-blue-100 text-blue-800
                                            @elseif($assignedUser->type == 'opd') bg-green-100 text-green-800
                                            @elseif($assignedUser->type == 'emergency') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                        {{ strtoupper($assignedUser->type ?? 'Unknown') }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Assignment Details -->
                        @if($currentAssignment)
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <p class="text-gray-500">Admitted</p>
                                <p class="font-medium">{{ $currentAssignment->assigned_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Status</p>
                                @if($currentAssignment->status == 'active')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    Discharged
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="mb-4 p-3 bg-gray-50 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 12H4"></path>
                        </svg>
                        <p class="text-sm text-gray-500">No patient assigned</p>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-2 pt-3 border-t border-gray-100">
                        <button class="view-details-btn text-blue-600 hover:text-blue-900 p-1.5 rounded hover:bg-blue-50 text-sm flex items-center"
                            onclick="showBedDetails(this)"
                            title="View Details">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View
                        </button>

                        @if($bed->status == 'Active' && !$assignedUser)
                        <button class="assign-bed-btn text-green-600 hover:text-green-900 p-1.5 rounded hover:bg-green-50 text-sm flex items-center"
                            onclick="openAssignModal('{{ $bed->id }}', '{{ $bed->bed_id }}', '{{ $bed->ward ? $bed->ward->name : 'Ward ' . $bed->ward_id }}')"
                            title="Assign Bed">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Assign
                        </button>
                        @endif

                        @if($assignedUser && $currentAssignment && $currentAssignment->status == 'active')
                        <button class="discharge-btn text-red-600 hover:text-red-900 p-1.5 rounded hover:bg-red-50 text-sm flex items-center"
                            onclick="dischargePatient('{{ $currentAssignment->id }}')"
                            title="Discharge Patient">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Discharge
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($beds->isEmpty())
        <div class="text-center py-12" id="emptyState">
            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No beds found</h3>
            <p class="mt-1 text-gray-500">Add new beds to get started.</p>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 rounded-b-lg mt-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-500 mb-2 sm:mb-0">
                Showing <span class="font-medium" id="visibleCount">{{ $beds->count() }}</span> of {{ $beds->count() }} beds
            </div>
            <div class="text-sm text-gray-500">
                Last updated: {{ now()->format('M d, Y h:i A') }}
            </div>
        </div>
    </div>
</div>

<!-- Bed Details Modal -->
<div id="bedDetailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>

        <!-- Modal container -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Bed Details</h3>
                    <p class="text-sm text-gray-500 mt-1">Detailed information about the bed</p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4" id="modalBody">
                <!-- Data will be loaded here via JavaScript -->
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Assign Bed Modal -->
<div id="assignBedModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeAssignModal()"></div>

        <!-- Modal container -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Assign Bed to Patient</h3>
                    <p class="text-sm text-gray-500 mt-1" id="assignModalSubtitle">Select a patient to assign to this bed</p>
                </div>
                <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-medium text-blue-900" id="selectedBedInfo">Bed Information</h4>
                            <p class="text-sm text-blue-700">Select a patient type and choose from available patients</p>
                        </div>
                    </div>
                </div>

                <!-- Patient Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Patient Type</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <button type="button" onclick="loadUsersByType('ipd')"
                            class="patient-type-btn p-4 border-2 border-blue-200 rounded-lg text-center hover:bg-blue-50 transition-colors"
                            data-type="ipd">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span class="font-medium text-gray-900">IPD Patients</span>
                                <span class="text-xs text-gray-500 mt-1">In-Patient Department</span>
                            </div>
                        </button>

                        <button type="button" onclick="loadUsersByType('opd')"
                            class="patient-type-btn p-4 border-2 border-green-200 rounded-lg text-center hover:bg-green-50 transition-colors"
                            data-type="opd">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">OPD Patients</span>
                                <span class="text-xs text-gray-500 mt-1">Out-Patient Department</span>
                            </div>
                        </button>

                        <button type="button" onclick="loadUsersByType('emergency')"
                            class="patient-type-btn p-4 border-2 border-red-200 rounded-lg text-center hover:bg-red-50 transition-colors"
                            data-type="emergency">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Emergency</span>
                                <span class="text-xs text-gray-500 mt-1">Emergency Cases</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Users List -->
                <div id="usersSection" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Patient</label>
                    <div class="relative mb-4">
                        <input type="text"
                            placeholder="Search patients..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full"
                            id="searchPatients">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden" style="max-height: 300px; overflow-y: auto;">
                        <div id="usersList" class="divide-y divide-gray-200">
                            <!-- Users will be loaded here -->
                        </div>
                        <div id="noUsersMessage" class="hidden p-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <p class="text-gray-500">No patients available for this type</p>
                        </div>
                    </div>
                </div>

                <!-- Assignment Date -->
                <div class="mt-6" id="assignmentDateSection" style="display: none;">
                    <label for="assigned_date" class="block text-sm font-medium text-gray-700 mb-2">Assignment Date</label>
                    <input type="date"
                        id="assigned_date"
                        name="assigned_date"
                        value="{{ date('Y-m-d') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <p class="text-xs text-gray-500 mt-1">Date when the patient will be admitted to this bed</p>
                </div>

                <!-- Loading State -->
                <div id="loadingUsers" class="hidden text-center py-8">
                    <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-blue-600 border-r-transparent"></div>
                    <p class="mt-2 text-gray-600">Loading patients...</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 space-x-3">
                <button onclick="closeAssignModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button onclick="submitAssignment()"
                    id="assignButton"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    Assign Bed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // Global variables
    let selectedBedId = null;
    let selectedUserId = null;
    let currentPatientType = null;

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Function to show bed details - IMPROVED VERSION
    function showBedDetails(button) {
        console.log('Opening bed details...');
        
        const card = button.closest('.card-item');
        if (!card) {
            console.error('Card not found!');
            return;
        }

        // Extract data from card's data attributes
        const bedId = card.getAttribute('data-bed-id');
        const bedNumber = card.getAttribute('data-bed-number');
        const bedStatus = card.getAttribute('data-status');
        const bedType = card.getAttribute('data-type');
        const wardId = card.getAttribute('data-ward-id');
        const wardName = card.getAttribute('data-ward-name');
        const wardFloor = card.getAttribute('data-ward-floor');
        
        // Check if bed has assigned user
        const hasUser = card.hasAttribute('data-user-id');
        const assignmentId = card.getAttribute('data-assignment-id');
        const assignedDate = card.getAttribute('data-assigned-date-formatted');

        const modal = document.getElementById('bedDetailsModal');
        const modalBody = document.getElementById('modalBody');
        const modalTitle = document.getElementById('modalTitle');

        if (!modal) {
            console.error('Modal not found!');
            return;
        }

        // Status badge styling
        let statusBadgeClass = 'bg-green-100 text-green-800';
        let statusDotClass = 'bg-green-500';
        if (bedStatus === 'Occupied') {
            statusBadgeClass = 'bg-red-100 text-red-800';
            statusDotClass = 'bg-red-500';
        } else if (bedStatus === 'Maintenance') {
            statusBadgeClass = 'bg-yellow-100 text-yellow-800';
            statusDotClass = 'bg-yellow-500';
        }

        // Type badge styling
        let typeBadgeClass = 'bg-gray-100 text-gray-800';
        if (bedType === 'Critical') {
            typeBadgeClass = 'bg-red-100 text-red-800';
        } else if (bedType === 'Deluxe') {
            typeBadgeClass = 'bg-purple-100 text-purple-800';
        }

        // Build ward info string
        let wardInfo = wardName;
        if (wardFloor) {
            wardInfo += ` (Floor ${wardFloor})`;
        }

        // Build patient info HTML
        let patientInfo = '';
        if (hasUser) {
            // Get patient data from data attributes
            const userId = card.getAttribute('data-user-id');
            const userEmail = card.getAttribute('data-user-email');
            const userType = card.getAttribute('data-user-type');
            const fullName = card.getAttribute('data-user-full-name');
            const phone = card.getAttribute('data-user-mobile-no');
            const age = card.getAttribute('data-user-age');
            const gender = card.getAttribute('data-user-gender');
            const bloodGroup = card.getAttribute('data-user-blood-group');
            const fatherSpouse = card.getAttribute('data-user-father-spouse');
            const address = card.getAttribute('data-user-full-address');
            const city = card.getAttribute('data-user-city');
            const state = card.getAttribute('data-user-state');
            const pinCode = card.getAttribute('data-user-pin-code');
            const alternateNo = card.getAttribute('data-user-alternate-no');

            // Determine badge class based on patient type
            let badgeClass = 'bg-gray-100 text-gray-800';
            if (userType === 'ipd') {
                badgeClass = 'bg-blue-100 text-blue-800';
            } else if (userType === 'opd') {
                badgeClass = 'bg-green-100 text-green-800';
            } else if (userType === 'emergency') {
                badgeClass = 'bg-red-100 text-red-800';
            }

            // Get patient initials
            const initials = fullName !== 'N/A' ? fullName.charAt(0).toUpperCase() : 
                           userEmail ? userEmail.charAt(0).toUpperCase() : 'U';

            patientInfo = `
            <div class="mb-6">
                <h4 class="font-medium text-gray-900 mb-3">Current Patient Details</h4>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-800 font-bold text-xl">
                            ${initials}
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-xl font-semibold text-gray-900 mb-1">${fullName}</div>
                            <div class="text-sm text-gray-600 mb-2">Email: ${userEmail}</div>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium ${badgeClass}">
                                ${userType ? userType.toUpperCase() : 'UNKNOWN'}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Admitted Date:</span>
                                <div class="text-sm font-semibold text-gray-900 mt-1">${assignedDate || 'N/A'}</div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Assignment Status:</span>
                                <div class="text-sm font-semibold text-green-700 mt-1">Active</div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Age/Gender:</span>
                                <div class="text-sm font-semibold text-gray-900 mt-1">${age} / ${gender}</div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Patient ID:</span>
                                <div class="text-sm font-semibold text-gray-900 mt-1">${userId}</div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Phone:</span>
                                <div class="text-sm font-semibold text-gray-900 mt-1">${phone}</div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Blood Group:</span>
                                <div class="text-sm font-semibold text-gray-900 mt-1">${bloodGroup}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Patient Information Section -->
                    <div class="border-t border-gray-200 pt-4">
                        <h5 class="font-medium text-gray-900 mb-3">Additional Information</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Father/Spouse Name:</span>
                                <div class="font-medium text-gray-900">${fatherSpouse}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Alternate Phone:</span>
                                <div class="font-medium text-gray-900">${alternateNo}</div>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-gray-600">Complete Address:</span>
                                <div class="font-medium text-gray-900">${address}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">City:</span>
                                <div class="font-medium text-gray-900">${city}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">State:</span>
                                <div class="font-medium text-gray-900">${state}</div>
                            </div>
                            <div>
                                <span class="text-gray-600">Pin Code:</span>
                                <div class="font-medium text-gray-900">${pinCode}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        } else {
            patientInfo = `
            <div class="mb-6">
                <h4 class="font-medium text-gray-900 mb-3">Current Patient</h4>
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 12H4"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">No patient currently assigned to this bed</p>
                    <p class="text-gray-500 text-sm mt-1">The bed is available for new patient assignment</p>
                    <div class="mt-4">
                        <button onclick="openAssignModal('${bedId}', '${bedNumber}', '${wardName}')" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                            Assign Patient
                        </button>
                    </div>
                </div>
            </div>
            `;
        }

        // Update modal content
        modalTitle.textContent = `Bed ${bedNumber} Details`;

        modalBody.innerHTML = `
        <div class="mb-6">
            <h4 class="font-medium text-gray-900 mb-3">Bed Information</h4>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-600">Bed ID:</span>
                        <div class="text-lg font-medium text-gray-900">${bedNumber}</div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Ward:</span>
                        <div class="text-lg font-medium text-gray-900">${wardInfo}</div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Status:</span>
                        <div class="text-lg font-medium">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${statusBadgeClass}">
                                <span class="w-2 h-2 rounded-full mr-1.5 ${statusDotClass}"></span>
                                ${bedStatus}
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Type:</span>
                        <div class="text-lg font-medium">
                            <span class="inline-flex px-2 py-1 rounded text-xs font-medium ${typeBadgeClass}">
                                ${bedType}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        ${patientInfo}
        
        <div class="pt-4 border-t border-gray-200">
            <h4 class="font-medium text-gray-900 mb-3">Bed Management</h4>
            <div class="space-y-2">
                <p class="text-sm text-gray-600">Bed ID in database: ${bedId}</p>
                <p class="text-sm text-gray-600">Current Status: ${bedStatus}</p>
                ${hasUser ? 
                  `<p class="text-sm text-gray-600">This bed is currently occupied by a patient.</p>
                   <div class="mt-3">
                       <button onclick="dischargePatient('${assignmentId}')" 
                               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                           Discharge Patient
                       </button>
                   </div>` : 
                  `<p class="text-sm text-gray-600">This bed is available for patient assignment.</p>
                   <div class="mt-3">
                       <button onclick="openAssignModal('${bedId}', '${bedNumber}', '${wardName}')" 
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                           Assign Patient
                       </button>
                   </div>`
                }
            </div>
        </div>
        `;

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        console.log('Bed details modal opened successfully');
    }

    // Function to open assign modal
    function openAssignModal(bedId, bedNumber, wardName) {
        console.log('Opening assign modal for bed:', bedId, bedNumber, wardName);

        selectedBedId = bedId;
        selectedUserId = null;
        currentPatientType = null;

        // Update modal info
        const bedInfoElement = document.getElementById('selectedBedInfo');
        if (bedInfoElement) {
            bedInfoElement.textContent = `Bed: ${bedNumber} | Ward: ${wardName}`;
        }

        // Reset form
        document.getElementById('usersSection').classList.add('hidden');
        document.getElementById('assignmentDateSection').style.display = 'none';
        document.getElementById('assignButton').disabled = true;
        document.getElementById('usersList').innerHTML = '';

        const searchPatients = document.getElementById('searchPatients');
        if (searchPatients) {
            searchPatients.value = '';
        }

        document.getElementById('noUsersMessage').classList.add('hidden');
        document.getElementById('loadingUsers').classList.add('hidden');

        // Reset patient type buttons
        document.querySelectorAll('.patient-type-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
        });

        // Show modal
        document.getElementById('assignBedModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        console.log('Assign modal opened');
    }

    // Function to close bed details modal
    function closeModal() {
        document.getElementById('bedDetailsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Function to close assign modal
    function closeAssignModal() {
        document.getElementById('assignBedModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        selectedBedId = null;
        selectedUserId = null;
        currentPatientType = null;
    }

  // Function to load users by type - COMPLETE FIXED VERSION
function loadUsersByType(type) {
    console.log('Loading users for type:', type);

    if (!selectedBedId) {
        alert('Please select a bed first!');
        return;
    }

    // Reset previous selections
    selectedUserId = null;
    currentPatientType = type;

    // Highlight selected type button
    document.querySelectorAll('.patient-type-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');

        if (btn.getAttribute('data-type') === type) {
            let borderClass = 'border-blue-500 bg-blue-50';

            if (type === 'opd') {
                borderClass = 'border-green-500 bg-green-50';
            } else if (type === 'emergency') {
                borderClass = 'border-red-500 bg-red-50';
            }

            btn.classList.add(...borderClass.split(' '));
        }
    });

    // Clear previous users
    document.getElementById('usersList').innerHTML = '';
    document.getElementById('assignmentDateSection').style.display = 'none';
    document.getElementById('assignButton').disabled = true;

    // Show loading state
    document.getElementById('usersSection').classList.add('hidden');
    document.getElementById('loadingUsers').classList.remove('hidden');
    document.getElementById('noUsersMessage').classList.add('hidden');

    // Clear search input
    const searchInput = document.getElementById('searchPatients');
    if (searchInput) {
        searchInput.value = '';
    }

    // Fetch users from server
    fetch(`/nurse/available-users/${type}`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            cache: 'no-cache' // Prevent caching
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('API Response for type', type, ':', data);

            // Hide loading state
            document.getElementById('loadingUsers').classList.add('hidden');

            if (!data.success) {
                throw new Error(data.message || 'Failed to load users');
            }

            if (!data.users || data.users.length === 0) {
                document.getElementById('noUsersMessage').classList.remove('hidden');
                document.getElementById('usersSection').classList.remove('hidden');
                return;
            }

            // Filter users by type on client side (double-check)
            const filteredUsers = data.users.filter(user => 
                user.type && user.type.toLowerCase() === type.toLowerCase()
            );

            if (filteredUsers.length === 0) {
                document.getElementById('noUsersMessage').classList.remove('hidden');
                document.getElementById('usersSection').classList.remove('hidden');
                return;
            }

            // Generate users list HTML
            let usersHtml = '';
            filteredUsers.forEach(user => {
                const initials = (user.full_name || user.email || 'U').charAt(0).toUpperCase();
                const typeColor = user.type === 'ipd' ? 'bg-blue-100 text-blue-800' :
                    user.type === 'opd' ? 'bg-green-100 text-green-800' :
                    user.type === 'emergency' ? 'bg-red-100 text-red-800' :
                    'bg-gray-100 text-gray-800';

                usersHtml += `
                <div class="user-item p-4 hover:bg-gray-50 cursor-pointer transition-colors"
                     data-user-id="${user.id}"
                     data-user-type="${user.type}"
                     onclick="selectUser(${user.id})">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-800 font-medium">
                            ${initials}
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-medium text-gray-900">${user.full_name || 'Unknown Patient'}</div>
                                    <div class="text-sm text-gray-500">ID: ${user.id} | ${user.email || 'No email'}</div>
                                </div>
                                <span class="inline-flex px-2 py-1 rounded text-xs font-medium ${typeColor}">
                                    ${(user.type || '').toUpperCase()}
                                </span>
                            </div>
                            <div class="mt-2 text-sm text-gray-600">
                                <div class="truncate">Phone: ${user.mobile_no || 'N/A'}</div>
                                <div class="truncate">${user.full_address || 'No address'}</div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });

            document.getElementById('usersList').innerHTML = usersHtml;
            document.getElementById('usersSection').classList.remove('hidden');

            // Add search functionality
            setupPatientSearch();

        })
        .catch(error => {
            console.error('Error fetching users:', error);
            document.getElementById('loadingUsers').classList.add('hidden');

            document.getElementById('usersList').innerHTML = `
            <div class="p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-red-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Error Loading Patients</h3>
                <p class="text-gray-600">Unable to load patient list. Please try again.</p>
                <p class="text-xs text-gray-500 mb-3">Error: ${error.message}</p>
                <button onclick="loadUsersByType('${type}')" class="mt-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Retry
                </button>
            </div>
            `;
            document.getElementById('usersSection').classList.remove('hidden');
        });
}

// Helper function to setup patient search
function setupPatientSearch() {
    const searchInput = document.getElementById('searchPatients');
    if (!searchInput) return;

    // Clear any existing event listeners
    const newSearchInput = searchInput.cloneNode(true);
    searchInput.parentNode.replaceChild(newSearchInput, searchInput);

    newSearchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;

        document.querySelectorAll('.user-item').forEach(item => {
            const userName = item.querySelector('.font-medium')?.textContent?.toLowerCase() || '';
            const userEmail = item.querySelector('.text-gray-500')?.textContent?.toLowerCase() || '';
            const userPhone = item.querySelectorAll('.text-gray-600 div')[0]?.textContent?.toLowerCase() || '';
            const userId = item.querySelector('.text-gray-500')?.textContent?.match(/ID:\s*(\d+)/i)?.[1] || '';

            if (userName.includes(searchTerm) ||
                userEmail.includes(searchTerm) ||
                userPhone.includes(searchTerm) ||
                userId.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no results message
        document.getElementById('noUsersMessage').classList.toggle('hidden', visibleCount > 0);
    });
}

// Function to select user
function selectUser(userId) {
    console.log('Selecting user:', userId);
    
    // Get the user type from the selected item
    const selectedItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
    if (!selectedItem) return;
    
    const userType = selectedItem.getAttribute('data-user-type');
    
    // Verify user type matches current selection
    if (userType && currentPatientType && userType.toLowerCase() !== currentPatientType.toLowerCase()) {
        alert('Error: Selected patient type does not match!');
        return;
    }
    
    selectedUserId = userId;

    // Remove selection from all users
    document.querySelectorAll('.user-item').forEach(item => {
        item.classList.remove('bg-blue-50');
        item.style.borderLeftWidth = '0';
    });

    // Highlight selected user
    if (selectedItem) {
        selectedItem.classList.add('bg-blue-50');
        selectedItem.style.borderLeftWidth = '4px';
        selectedItem.style.borderLeftColor = '#3b82f6';
    }

    // Show assignment date and enable assign button
    document.getElementById('assignmentDateSection').style.display = 'block';
    document.getElementById('assignButton').disabled = false;
}

   

    // Function to submit assignment
    function submitAssignment() {
        console.log('Submitting assignment...');

        if (!selectedBedId || !selectedUserId || !currentPatientType) {
            alert('Please select a patient type and patient');
            return;
        }

        const assignedDate = document.getElementById('assigned_date').value;
        if (!assignedDate) {
            alert('Please select an assignment date');
            return;
        }

        // Disable button and show loading
        const assignButton = document.getElementById('assignButton');
        const originalText = assignButton.innerHTML;
        assignButton.disabled = true;
        assignButton.innerHTML = '<span class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Assigning...</span>';

        // Send assignment request
        fetch('/nurse/assign-bed', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    bed_id: selectedBedId,
                    user_id: selectedUserId,
                    assigned_date: assignedDate
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Assignment response:', data);
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message || 'Error assigning bed');
                    assignButton.disabled = false;
                    assignButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error assigning bed. Please try again.');
                assignButton.disabled = false;
                assignButton.innerHTML = originalText;
            });
    }

    // Function to discharge patient
    function dischargePatient(assignmentId) {
        if (confirm('Are you sure you want to discharge this patient?')) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/nurse/bed-assignments/${assignmentId}/discharge`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Filter functions
    function filterItems() {
        const statusFilter = document.getElementById('statusFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const searchInput = document.getElementById('searchInput').value.toLowerCase();

        const cards = document.querySelectorAll('.card-item');
        let visibleCount = 0;

        cards.forEach(card => {
            const status = card.getAttribute('data-status');
            const type = card.getAttribute('data-type');
            const searchText = card.getAttribute('data-search');

            let showCard = true;

            if (statusFilter && status !== statusFilter) {
                showCard = false;
            }

            if (typeFilter && type !== typeFilter) {
                showCard = false;
            }

            if (searchInput && !searchText.includes(searchInput)) {
                showCard = false;
            }

            if (showCard) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('filterCount').textContent = visibleCount + ' beds found';
        document.getElementById('visibleCount').textContent = visibleCount;

        const emptyState = document.getElementById('emptyState');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    function resetFilters() {
        document.getElementById('statusFilter').value = '';
        document.getElementById('typeFilter').value = '';
        document.getElementById('searchInput').value = '';
        filterItems();
    }

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, initializing event listeners');

        // Initialize filter listeners
        const statusFilter = document.getElementById('statusFilter');
        const typeFilter = document.getElementById('typeFilter');
        const searchInput = document.getElementById('searchInput');

        if (statusFilter) {
            statusFilter.addEventListener('change', filterItems);
        }

        if (typeFilter) {
            typeFilter.addEventListener('change', filterItems);
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterItems);
        }

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeAssignModal();
            }
        });

        // Click outside to close modals
        document.querySelectorAll('.fixed.inset-0').forEach(backdrop => {
            backdrop.addEventListener('click', function(e) {
                if (e.target === this) {
                    const bedModal = document.getElementById('bedDetailsModal');
                    const assignModal = document.getElementById('assignBedModal');

                    if (!bedModal.classList.contains('hidden')) {
                        closeModal();
                    }
                    if (!assignModal.classList.contains('hidden')) {
                        closeAssignModal();
                    }
                }
            });
        });

        console.log('Event listeners initialized');
    });
</script>

<style>
    /* Animation for loading spinner */
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Card hover effects */
    .card-item {
        transition: all 0.2s ease;
    }

    .card-item:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Modal styles */
    #bedDetailsModal,
    #assignBedModal {
        z-index: 9999;
    }

    /* Ensure modal backdrop works */
    .fixed.inset-0 {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    /* User selection styling */
    .user-item.selected {
        background-color: #dbeafe;
        border-left: 4px solid #3b82f6;
    }

    /* Responsive grid */
    @media (max-width: 767px) {
        #bedCardsContainer {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 768px) and (max-width: 1023px) {
        #bedCardsContainer {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 1024px) {
        #bedCardsContainer {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endsection