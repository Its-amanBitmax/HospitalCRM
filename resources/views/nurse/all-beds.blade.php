@extends('layouts.nursionist')
@section('title', 'All Beds Management')

@section('content')
<div class="container mx-auto px-4 py-6">
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

    <!-- View Toggle and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
            <!-- View Toggle -->
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">View:</span>
                <div class="inline-flex rounded-lg border border-gray-200 p-1">
                    <button id="cardViewBtn" class="p-2 rounded-md bg-blue-100 text-blue-600" title="Card View">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button id="tableViewBtn" class="p-2 rounded-md hover:bg-gray-100 text-gray-600" title="Table View">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-3">
                <div class="relative">
                    <input type="text" 
                           placeholder="Search beds..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64"
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
                
                <button onclick="resetFilters()" class="text-sm text-gray-600 hover:text-gray-800 flex items-center justify-center md:justify-start">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </button>
            </div>
        </div>
        
        <!-- Filter Results Count -->
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500" id="filterCount">
                    {{ $beds->count() }} beds found
                </span>
                <span class="text-xs text-gray-400" id="currentView">Card View</span>
            </div>
        </div>
    </div>

    <!-- Card View -->
    <div id="cardView" class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            @foreach($beds as $bed)
            <div class="card-item border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200"
                 data-status="{{ $bed->status }}" 
                 data-type="{{ $bed->type }}"
                 data-search="{{ strtolower($bed->bed_id . ' ' . $bed->ward_id . ' ' . ($bed->bedAssignments->isNotEmpty() ? ($bed->bedAssignments->first()->user->full_name ?? '') : '')) }}">
                
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
                            <p class="font-medium text-gray-900">Ward {{ $bed->ward_id }}</p>
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
                    @if($bed->bedAssignments->isNotEmpty())
                        @php 
                            $assignment = $bed->bedAssignments->first();
                            $user = $assignment->user;
                        @endphp
                        @if($user)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center mb-2">
                                <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-800 font-medium text-sm">
                                    {{ substr($user->full_name ?? $user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $user->full_name ?? $user->name ?? 'Unknown Patient' }}
                                    </p>
                                    <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                </div>
                            </div>
                            
                            <!-- Assignment Details -->
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <p class="text-gray-500">Admitted</p>
                                    <p class="font-medium">{{ $assignment->assigned_date }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Status</p>
                                    @if($assignment->status == 'active')
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
                        </div>
                        @else
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 12H4"></path>
                            </svg>
                            <p class="text-sm text-gray-500">User not found</p>
                        </div>
                        @endif
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
                        <button class="text-blue-600 hover:text-blue-900 p-1.5 rounded hover:bg-blue-50 text-sm flex items-center"
                                onclick="showBedDetails({{ $bed->id }})"
                                title="View Details">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View
                        </button>
                        
                        @if($bed->status == 'Active' && (!$bed->bedAssignments->isNotEmpty() || $bed->bedAssignments->first()->status == 'discharged'))
                            <button class="text-green-600 hover:text-green-900 p-1.5 rounded hover:bg-green-50 text-sm flex items-center"
                                    onclick="assignBed({{ $bed->id }})"
                                    title="Assign Bed">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Assign
                            </button>
                        @endif
                        
                        @if($bed->bedAssignments->isNotEmpty() && $bed->bedAssignments->first()->status == 'active')
                            <button class="text-red-600 hover:text-red-900 p-1.5 rounded hover:bg-red-50 text-sm flex items-center"
                                    onclick="dischargePatient({{ $bed->id }}, {{ $bed->bedAssignments->first()->id }})"
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
        
        <!-- Card View Empty State -->
        @if($beds->isEmpty())
        <div class="text-center py-12" id="cardEmptyState">
            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No beds found</h3>
            <p class="mt-1 text-gray-500">Add new beds to get started.</p>
        </div>
        @endif
    </div>

    <!-- Table View (Hidden by default) -->
    <div id="tableView" class="bg-white shadow-lg rounded-xl overflow-hidden hidden">
        <!-- Horizontal Scroll Container - Only for Table -->
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200" style="min-width: 1200px;">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap sticky left-0 bg-gray-50 z-10">
                            Bed Details
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Ward
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Type
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Patient Info
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Assigned Date
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Discharge Date
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap">
                            Assignment Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider whitespace-nowrap sticky right-0 bg-gray-50 z-10">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($beds as $bed)
                    <tr class="table-row hover:bg-gray-50 transition-colors duration-150"
                        data-status="{{ $bed->status }}" 
                        data-type="{{ $bed->type }}"
                        data-search="{{ strtolower($bed->bed_id . ' ' . $bed->ward_id . ' ' . ($bed->bedAssignments->isNotEmpty() ? ($bed->bedAssignments->first()->user->full_name ?? '') : '')) }}">
                        
                        <!-- Bed Details (Sticky Column) -->
                        <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white z-10">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-800 font-bold text-sm">
                                    B{{ substr($bed->id, -3) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $bed->bed_id }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $bed->id }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Ward -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Ward {{ $bed->ward_id }}</div>
                        </td>
                        
                        <!-- Type -->
                        <td class="px-4 py-3 whitespace-nowrap">
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
                        </td>
                        
                        <!-- Status -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Active' => 'bg-green-100 text-green-800',
                                    'Occupied' => 'bg-red-100 text-red-800',
                                    'Maintenance' => 'bg-yellow-100 text-yellow-800'
                                ];
                                $statusColor = $statusColors[$bed->status] ?? $statusColors['Active'];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $statusColor }}">
                                <span class="w-2 h-2 rounded-full mr-1.5 
                                    @if($bed->status == 'Active') bg-green-500
                                    @elseif($bed->status == 'Occupied') bg-red-500
                                    @elseif($bed->status == 'Maintenance') bg-yellow-500 @endif
                                "></span>
                                {{ $bed->status }}
                            </span>
                        </td>
                        
                        <!-- Patient Information -->
                        <td class="px-4 py-3">
                            @if($bed->bedAssignments->isNotEmpty())
                                @php 
                                    $assignment = $bed->bedAssignments->first();
                                    $user = $assignment->user;
                                @endphp
                                @if($user)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-7 w-7 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-800 font-medium text-xs">
                                        {{ substr($user->full_name ?? $user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm font-medium text-gray-900 truncate" style="max-width: 150px;">
                                            {{ $user->full_name ?? $user->name ?? 'Unknown Patient' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            ID: {{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="text-sm text-gray-500 italic">User not found</div>
                                @endif
                            @else
                                <div class="text-sm text-gray-500 italic">Not assigned</div>
                            @endif
                        </td>
                        
                        <!-- Assigned Date -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($bed->bedAssignments->isNotEmpty())
                                @php $assignment = $bed->bedAssignments->first(); @endphp
                                <div class="text-sm text-gray-900">{{ $assignment->assigned_date }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($assignment->assigned_date)
                                        {{ \Carbon\Carbon::parse($assignment->assigned_date)->diffForHumans() }}
                                    @endif
                                </div>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        
                        <!-- Discharge Date -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($bed->bedAssignments->isNotEmpty())
                                @php $assignment = $bed->bedAssignments->first(); @endphp
                                @if($assignment->discharge_date)
                                    <div class="text-sm text-gray-900">{{ $assignment->discharge_date }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($assignment->discharge_date)->diffForHumans() }}
                                    </div>
                                @else
                                    <span class="text-xs text-yellow-600 italic">Not discharged</span>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        
                        <!-- Assignment Status -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($bed->bedAssignments->isNotEmpty())
                                @php $assignment = $bed->bedAssignments->first(); @endphp
                                @if($assignment->status == 'active')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                                @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    Discharged
                                </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    Unassigned
                                </span>
                            @endif
                        </td>
                        
                        <!-- Actions (Sticky Column) -->
                        <td class="px-4 py-3 whitespace-nowrap sticky right-0 bg-white z-10">
                            <div class="flex space-x-1">
                                <button class="text-blue-600 hover:text-blue-900 p-1.5 rounded hover:bg-blue-50"
                                        onclick="showBedDetails({{ $bed->id }})"
                                        title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                
                                @if($bed->status == 'Active' && (!$bed->bedAssignments->isNotEmpty() || $bed->bedAssignments->first()->status == 'discharged'))
                                    <button class="text-green-600 hover:text-green-900 p-1.5 rounded hover:bg-green-50"
                                            onclick="assignBed({{ $bed->id }})"
                                            title="Assign Bed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                @endif
                                
                                @if($bed->bedAssignments->isNotEmpty() && $bed->bedAssignments->first()->status == 'active')
                                    <button class="text-red-600 hover:text-red-900 p-1.5 rounded hover:bg-red-50"
                                            onclick="dischargePatient({{ $bed->id }}, {{ $bed->bedAssignments->first()->id }})"
                                            title="Discharge Patient">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Table View Empty State -->
            @if($beds->isEmpty())
            <div class="text-center py-12" id="tableEmptyState">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No beds found</h3>
                <p class="mt-1 text-gray-500">Add new beds to get started.</p>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Footer -->
    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 rounded-b-lg mt-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-gray-500 mb-2 sm:mb-0">
                Showing <span class="font-medium">{{ $beds->count() }}</span> beds
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
            <!-- Modal header -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Bed Details</h3>
                    <button type="button" 
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                            onclick="closeModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal body -->
            <div class="px-6 py-4">
                <div id="modalLoading" class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
                    <p class="mt-4 text-gray-500">Loading bed details...</p>
                </div>
                
                <div id="modalContent" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column - Bed Information -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Bed Information</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs text-gray-500">Bed ID</label>
                                    <p class="text-sm font-medium text-gray-900" id="modalBedId"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Database ID</label>
                                    <p class="text-sm text-gray-700" id="modalBedDbId"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Ward</label>
                                    <p class="text-sm text-gray-700" id="modalWardId"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Type</label>
                                    <p class="text-sm text-gray-700" id="modalBedType"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Status</label>
                                    <p class="text-sm" id="modalBedStatus"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Created At</label>
                                    <p class="text-sm text-gray-700" id="modalCreatedAt"></p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Last Updated</label>
                                    <p class="text-sm text-gray-700" id="modalUpdatedAt"></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column - Patient Information -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Patient & Assignment Details</h4>
                            <div id="modalPatientInfo">
                                <!-- Patient info will be populated here -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Additional Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500">Total Assignments</p>
                                <p class="text-lg font-semibold text-gray-900" id="modalTotalAssignments">0</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500">Current Status Duration</p>
                                <p class="text-sm text-gray-700" id="modalStatusDuration">-</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500">Bed Availability</p>
                                <p class="text-sm font-medium" id="modalAvailability"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            onclick="closeModal()">
                        Close
                    </button>
                    <button type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            id="modalAssignBtn"
                            onclick="assignBedFromModal()">
                        Assign Bed
                    </button>
                    <button type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hidden"
                            id="modalDischargeBtn"
                            onclick="dischargeFromModal()">
                        Discharge Patient
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for View Toggle, Filtering and Modal -->
<script>
let currentView = 'card'; // 'card' or 'table'
let currentBedId = null;

function switchView(view) {
    const cardView = document.getElementById('cardView');
    const tableView = document.getElementById('tableView');
    const cardBtn = document.getElementById('cardViewBtn');
    const tableBtn = document.getElementById('tableViewBtn');
    const viewIndicator = document.getElementById('currentView');
    
    if (view === 'card') {
        cardView.classList.remove('hidden');
        tableView.classList.add('hidden');
        cardBtn.classList.add('bg-blue-100', 'text-blue-600');
        cardBtn.classList.remove('hover:bg-gray-100', 'text-gray-600');
        tableBtn.classList.remove('bg-blue-100', 'text-blue-600');
        tableBtn.classList.add('hover:bg-gray-100', 'text-gray-600');
        viewIndicator.textContent = 'Card View';
        currentView = 'card';
    } else {
        cardView.classList.add('hidden');
        tableView.classList.remove('hidden');
        tableBtn.classList.add('bg-blue-100', 'text-blue-600');
        tableBtn.classList.remove('hover:bg-gray-100', 'text-gray-600');
        cardBtn.classList.remove('bg-blue-100', 'text-blue-600');
        cardBtn.classList.add('hover:bg-gray-100', 'text-gray-600');
        viewIndicator.textContent = 'Table View';
        currentView = 'table';
    }
    
    // Re-apply filters after switching view
    filterItems();
}

function filterItems() {
    const statusFilter = document.getElementById('statusFilter').value;
    const typeFilter = document.getElementById('typeFilter').value;
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    
    let visibleCount = 0;
    
    if (currentView === 'card') {
        const cards = document.querySelectorAll('.card-item');
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
    } else {
        const rows = document.querySelectorAll('.table-row');
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const type = row.getAttribute('data-type');
            const searchText = row.getAttribute('data-search');
            
            let showRow = true;
            
            if (statusFilter && status !== statusFilter) {
                showRow = false;
            }
            
            if (typeFilter && type !== typeFilter) {
                showRow = false;
            }
            
            if (searchInput && !searchText.includes(searchInput)) {
                showRow = false;
            }
            
            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Update filter count
    document.getElementById('filterCount').textContent = visibleCount + ' beds found';
    
    // Show/hide empty states
    updateEmptyStates(visibleCount);
}

function updateEmptyStates(visibleCount) {
    const cardEmptyState = document.getElementById('cardEmptyState');
    const tableEmptyState = document.getElementById('tableEmptyState');
    
    if (cardEmptyState) {
        cardEmptyState.style.display = visibleCount === 0 && currentView === 'card' ? 'block' : 'none';
    }
    if (tableEmptyState) {
        tableEmptyState.style.display = visibleCount === 0 && currentView === 'table' ? 'block' : 'none';
    }
}

function resetFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('typeFilter').value = '';
    document.getElementById('searchInput').value = '';
    filterItems();
}

// Modal Functions
function showBedDetails(bedId) {
    currentBedId = bedId;
    
    // Show modal and loading state
    const modal = document.getElementById('bedDetailsModal');
    const loading = document.getElementById('modalLoading');
    const content = document.getElementById('modalContent');
    
    modal.classList.remove('hidden');
    loading.classList.remove('hidden');
    content.classList.add('hidden');
    document.body.style.overflow = 'hidden';
    
    // Fetch bed details via AJAX
    fetch(`/beds/${bedId}/details`)
        .then(response => response.json())
        .then(data => {
            // Hide loading, show content
            loading.classList.add('hidden');
            content.classList.remove('hidden');
            
            // Set modal title
            document.getElementById('modalTitle').textContent = `Bed Details: ${data.bed.bed_id}`;
            
            // Populate bed information
            document.getElementById('modalBedId').textContent = data.bed.bed_id;
            document.getElementById('modalBedDbId').textContent = data.bed.id;
            document.getElementById('modalWardId').textContent = `Ward ${data.bed.ward_id}`;
            document.getElementById('modalBedType').textContent = data.bed.type;
            
            // Set status with color
            const statusColors = {
                'Active': 'text-green-600 bg-green-100 px-2 py-1 rounded text-sm inline-block',
                'Occupied': 'text-red-600 bg-red-100 px-2 py-1 rounded text-sm inline-block',
                'Maintenance': 'text-yellow-600 bg-yellow-100 px-2 py-1 rounded text-sm inline-block'
            };
            const statusElement = document.getElementById('modalBedStatus');
            statusElement.className = statusColors[data.bed.status] || 'text-gray-600 bg-gray-100 px-2 py-1 rounded text-sm inline-block';
            statusElement.textContent = data.bed.status;
            
            // Set dates
            document.getElementById('modalCreatedAt').textContent = formatDate(data.bed.created_at);
            document.getElementById('modalUpdatedAt').textContent = formatDate(data.bed.updated_at);
            
            // Populate patient information
            const patientInfoDiv = document.getElementById('modalPatientInfo');
            if (data.assignment) {
                const assignment = data.assignment;
                const user = assignment.user;
                
                let patientHtml = `
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-800 font-medium">
                                ${(user?.full_name || user?.name || 'U').charAt(0)}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">${user?.full_name || user?.name || 'Unknown Patient'}</p>
                                <p class="text-xs text-gray-500">Patient ID: ${user?.id || 'N/A'}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500">Assigned Date</label>
                                <p class="text-sm text-gray-700">${assignment.assigned_date}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Discharge Date</label>
                                <p class="text-sm ${assignment.discharge_date ? 'text-gray-700' : 'text-yellow-600'}">
                                    ${assignment.discharge_date || 'Not discharged'}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Assignment Status</label>
                                <span class="text-xs ${assignment.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} px-2 py-1 rounded">
                                    ${assignment.status}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
                patientInfoDiv.innerHTML = patientHtml;
                
                // Show discharge button if bed is occupied
                if (data.bed.status === 'Occupied' && assignment.status === 'active') {
                    document.getElementById('modalDischargeBtn').classList.remove('hidden');
                    document.getElementById('modalDischargeBtn').setAttribute('data-assignment-id', assignment.id);
                    document.getElementById('modalAssignBtn').classList.add('hidden');
                } else {
                    document.getElementById('modalDischargeBtn').classList.add('hidden');
                    document.getElementById('modalAssignBtn').classList.remove('hidden');
                }
                
                document.getElementById('modalTotalAssignments').textContent = data.total_assignments || 1;
            } else {
                patientInfoDiv.innerHTML = `
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 12H4"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No patient assigned to this bed</p>
                    </div>
                `;
                document.getElementById('modalDischargeBtn').classList.add('hidden');
                document.getElementById('modalAssignBtn').classList.remove('hidden');
                document.getElementById('modalTotalAssignments').textContent = '0';
            }
            
            // Set availability status
            const availabilityElement = document.getElementById('modalAvailability');
            if (data.bed.status === 'Active') {
                availabilityElement.textContent = 'Available for assignment';
                availabilityElement.className = 'text-sm font-medium text-green-600';
            } else if (data.bed.status === 'Occupied') {
                availabilityElement.textContent = 'Currently occupied';
                availabilityElement.className = 'text-sm font-medium text-red-600';
            } else {
                availabilityElement.textContent = 'Under maintenance';
                availabilityElement.className = 'text-sm font-medium text-yellow-600';
            }
        })
        .catch(error => {
            console.error('Error fetching bed details:', error);
            loading.innerHTML = `
                <div class="text-center py-4">
                    <svg class="w-12 h-12 mx-auto text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-red-600">Failed to load bed details. Please try again.</p>
                </div>
            `;
        });
}

function closeModal() {
    document.getElementById('bedDetailsModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentBedId = null;
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function assignBed(bedId) {
    window.location.href = `/beds/${bedId}/assign`;
}

function assignBedFromModal() {
    if (currentBedId) {
        window.location.href = `/beds/${currentBedId}/assign`;
    }
}

function dischargePatient(bedId, assignmentId) {
    if(confirm('Are you sure you want to discharge this patient?')) {
        window.location.href = `/bed-assignments/${assignmentId}/discharge`;
    }
}

function dischargeFromModal() {
    const assignmentId = document.getElementById('modalDischargeBtn').getAttribute('data-assignment-id');
    if (assignmentId && confirm('Are you sure you want to discharge this patient?')) {
        window.location.href = `/bed-assignments/${assignmentId}/discharge`;
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set up event listeners
    document.getElementById('cardViewBtn').addEventListener('click', () => switchView('card'));
    document.getElementById('tableViewBtn').addEventListener('click', () => switchView('table'));
    document.getElementById('statusFilter').addEventListener('change', filterItems);
    document.getElementById('typeFilter').addEventListener('change', filterItems);
    document.getElementById('searchInput').addEventListener('input', filterItems);
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    
    // Initialize with card view
    switchView('card');
});
</script>

<style>
/* Main container */
.container {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
}

/* Smooth animations */
.card-item, .table-row {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card grid responsive */
.grid {
    display: grid;
    gap: 1rem;
}

/* Table specific horizontal scrolling */
#tableView .overflow-x-auto {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    max-width: 100%;
}

/* Custom scrollbar for table only */
#tableView .overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

#tableView .overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

#tableView .overflow-x-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

#tableView .overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Sticky columns for table */
.sticky {
    position: sticky;
}

.sticky.left-0 {
    left: 0;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    background: white;
}

.sticky.right-0 {
    right: 0;
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    background: white;
}

/* Ensure sticky columns have proper z-index */
.sticky.z-10 {
    z-index: 10;
}

/* Table styling */
#tableView table {
    width: 100%;
    min-width: 1200px;
}

/* Ensure table cells align with card width */
.table-row td {
    padding: 12px 16px;
}

/* Modal styles */
#bedDetailsModal {
    z-index: 9999;
}

/* Responsive grid for cards */
@media (max-width: 767px) {
    .grid {
        grid-template-columns: 1fr;
    }
    
    #tableView table {
        min-width: 800px;
    }
    
    .table-row td {
        padding: 8px 12px;
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    #tableView table {
        min-width: 1000px;
    }
}

@media (min-width: 1024px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    #tableView table {
        min-width: 1200px;
    }
}

/* Ensure card and table content have similar spacing */
.card-item .p-4 {
    padding: 1rem;
}

.table-row .px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

/* Responsive adjustments for better alignment */
@media (max-width: 768px) {
    .px-4 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    .text-sm {
        font-size: 0.875rem;
    }
    
    .text-xs {
        font-size: 0.75rem;
    }
}

/* Card hover effect */
.card-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    transition: all 0.2s ease;
}

/* Table row hover effect */
.table-row:hover {
    background-color: #f9fafb;
}

/* Fix for modal backdrop */
.fixed.inset-0 {
    z-index: 40;
}
</style>
@endsection