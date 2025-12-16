@extends('layouts.nursionist')
@section('title', "Today's Appointments")

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Today's Confirmed Appointments</h1>
                <div class="flex flex-wrap items-center gap-3 text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ \Carbon\Carbon::today()->format('l, F j, Y') }}</span>
                    </div>
                    <span class="hidden md:inline">•</span>
                    <span class="bg-green-100 text-green-800 px-3 py-1.5 rounded-lg text-sm font-semibold">
                        <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $appointments->count() }} Confirmed Appointment(s)
                    </span>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Last Updated: {{ now()->format('h:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($appointments->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 md:p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">No Appointments Today</h3>
                <p class="text-gray-600 mb-6">There are no confirmed appointments scheduled for today.</p>
                <div class="text-sm text-gray-500 bg-gray-50 px-4 py-3 rounded-lg inline-block">
                    All appointments are either pending or cancelled
                </div>
            </div>
        </div>
    @else
        <!-- Helper functions for time calculation -->
        @php
            // Improved function to check if appointment is upcoming
            function getAppointmentTimeStatus($timeRange) {
                try {
                    // Handle time range like "05:00 AM - 05:30 AM"
                    if (strpos($timeRange, '-') !== false) {
                        $parts = explode('-', $timeRange);
                        $startTime = trim($parts[0]);
                        $endTime = trim($parts[1]);
                    } else {
                        $startTime = $timeRange;
                        $endTime = $timeRange;
                    }
                    
                    // Parse start time
                    $startTimeOnly = str_replace([' AM', ' PM'], '', $startTime);
                    list($startHours, $startMinutes) = explode(':', $startTimeOnly);
                    
                    $startHours = intval($startHours);
                    $startMinutes = intval($startMinutes);
                    
                    // Convert to 24-hour format for start time
                    if (strpos($startTime, 'PM') !== false && $startHours < 12) {
                        $startHours += 12;
                    }
                    if (strpos($startTime, 'AM') !== false && $startHours == 12) {
                        $startHours = 0;
                    }
                    
                    // Parse end time
                    $endTimeOnly = str_replace([' AM', ' PM'], '', $endTime);
                    list($endHours, $endMinutes) = explode(':', $endTimeOnly);
                    
                    $endHours = intval($endHours);
                    $endMinutes = intval($endMinutes);
                    
                    // Convert to 24-hour format for end time
                    if (strpos($endTime, 'PM') !== false && $endHours < 12) {
                        $endHours += 12;
                    }
                    if (strpos($endTime, 'AM') !== false && $endHours == 12) {
                        $endHours = 0;
                    }
                    
                    // Create time objects
                    $now = \Carbon\Carbon::now();
                    $appointmentStart = \Carbon\Carbon::today()->setTime($startHours, $startMinutes, 0);
                    $appointmentEnd = \Carbon\Carbon::today()->setTime($endHours, $endMinutes, 0);
                    
                    // Determine status
                    if ($now->lessThan($appointmentStart)) {
                        return [
                            'status' => 'upcoming',
                            'label' => 'Upcoming',
                            'color' => 'green',
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                        ];
                    } elseif ($now->between($appointmentStart, $appointmentEnd)) {
                        return [
                            'status' => 'in_progress',
                            'label' => 'In Progress',
                            'color' => 'yellow',
                            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                        ];
                    } else {
                        return [
                            'status' => 'time_passed',
                            'label' => 'Time Passed',
                            'color' => 'gray',
                            'icon' => 'M5 13l4 4L19 7'
                        ];
                    }
                } catch (\Exception $e) {
                    return [
                        'status' => 'unknown',
                        'label' => 'Unknown',
                        'color' => 'gray',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ];
                }
            }
            
            // Calculate statistics
            $upcomingCount = 0;
            $inProgressCount = 0;
            $timePassedCount = 0;
            
            foreach($appointments as $appointment) {
                $timeStatus = getAppointmentTimeStatus($appointment->appointment_time);
                switch($timeStatus['status']) {
                    case 'upcoming':
                        $upcomingCount++;
                        break;
                    case 'in_progress':
                        $inProgressCount++;
                        break;
                    case 'time_passed':
                        $timePassedCount++;
                        break;
                }
            }
        @endphp

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-600">Total Confirmed</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $appointments->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-600">Upcoming</div>
                        <div class="text-2xl font-bold text-green-700">{{ $upcomingCount }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-600">In Progress</div>
                        <div class="text-2xl font-bold text-yellow-700">{{ $inProgressCount }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-600">Time Passed</div>
                        <div class="text-2xl font-bold text-gray-700">{{ $timePassedCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2 sm:mb-0">Appointment Details</h2>
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">{{ $appointments->count() }}</span> appointment(s) found
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Patient Details
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Doctor & Department
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Appointment Time
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Time Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($appointments as $appointment)
                            @php
                                $timeStatus = getAppointmentTimeStatus($appointment->appointment_time);
                                $statusColors = [
                                    'upcoming' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500'],
                                    'in_progress' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-500'],
                                    'time_passed' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500'],
                                    'unknown' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500']
                                ];
                                $colors = $statusColors[$timeStatus['status']];
                            @endphp
                            
                            <tr class="hover:bg-blue-50 transition-colors duration-150 group">
                                <!-- Patient Column -->
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow transition-shadow">
                                            <span class="text-blue-800 font-bold text-lg">
                                                @if($appointment->for_user_type == 'self' && $appointment->user && $appointment->user->full_name)
                                                    {{ strtoupper(substr($appointment->user->full_name, 0, 1)) }}
                                                @elseif($appointment->for_user_type == 'relative' && $appointment->relative)
                                                    {{ strtoupper(substr($appointment->relative->name, 0, 1)) }}
                                                @else
                                                    P
                                                @endif
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                @if($appointment->for_user_type == 'self')
                                                    {{ $appointment->user->full_name ?? 'N/A' }}
                                                @elseif($appointment->for_user_type == 'relative' && $appointment->relative)
                                                    {{ $appointment->relative->name ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                @if($appointment->for_user_type == 'self')
                                                    <div class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        Self Appointment
                                                    </div>
                                                @elseif($appointment->for_user_type == 'relative')
                                                    <div class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        Relative of {{ $appointment->user->full_name ?? 'N/A' }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                ID: {{ $appointment->for_user_type == 'self' ? ($appointment->user->id ?? 'N/A') : ($appointment->relative_id ?? 'N/A') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Doctor Column -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $appointment->doctor->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        @if($appointment->doctor && $appointment->doctor->department)
                                            <div class="flex items-center">
                                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $appointment->doctor->department->department_name ?? 'General' }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Dr. ID: {{ $appointment->doctor->employee_code ?? 'N/A' }}
                                    </div>
                                </td>

                                <!-- Time Column -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ $appointment->appointment_time }}
                                    </div>
                                    <div class="text-xs text-gray-600 mt-1 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }}
                                    </div>
                                </td>

                                <!-- Time Status Column -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $colors['bg'] }} {{ $colors['text'] }}">
                                            <span class="w-2 h-2 rounded-full {{ $colors['dot'] }} mr-2"></span>
                                            {{ $timeStatus['label'] }}
                                        </span>
                                        
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Table Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-600">
                    <div class="mb-2 sm:mb-0">
                        <span class="font-medium">{{ $appointments->count() }}</span> confirmed appointment(s) for today
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center mr-4">
                            <span class="w-3 h-3 rounded-full bg-green-500 mr-1.5"></span>
                            <span class="text-xs">Upcoming</span>
                        </div>
                        <div class="flex items-center mr-4">
                            <span class="w-3 h-3 rounded-full bg-yellow-500 mr-1.5"></span>
                            <span class="text-xs">In Progress</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-gray-500 mr-1.5"></span>
                            <span class="text-xs">Time Passed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    tr {
        border-bottom: 1px solid #e5e7eb;
    }
    
    tr:last-child {
        border-bottom: 0;
    }
    
    .hover\:bg-blue-50:hover {
        background-color: #eff6ff;
    }
    
    @media (max-width: 640px) {
        table {
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        th, td {
            min-width: 200px;
        }
        
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endsection