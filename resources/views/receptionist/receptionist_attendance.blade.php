@extends('layouts.receptionist')

@section('content')
<div class="">

    <!-- SUCCESS/ERROR MESSAGE TOAST -->
    <div id="messageToast" class="hidden fixed top-6 right-6 z-50 animate-slide-in">
        <div class="relative">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 border-green-500 min-w-[320px] p-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p id="toastMessage" class="text-sm font-medium text-gray-900"></p>
                        <p class="text-xs text-gray-500 mt-1">Just now</p>
                    </div>
                    <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- HEADER WITH GLASSMORPHISM -->
    <div class="relative mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-3xl blur-3xl"></div>
        <div class="relative bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-xl overflow-hidden">
            <div class="p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                    <!-- PROFILE SECTION -->
                    <!-- PROFILE SECTION -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full opacity-20 blur-md"></div>
                            <img src="{{ $employee->image ? asset('storage/' . $employee->image) : asset('images/default-profile.png') }}"
                                alt="Profile"
                                class="relative w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
                            <div class="absolute bottom-2 right-2 w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $employee->name }}</h1>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                    Receptionist
                                </span>
                                <!-- Employee Code Display -->
                                <span class="text-sm font-medium text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                                    @if($employee->employee_code)
                                    Code: {{ $employee->employee_code }}
                                    @else
                                    ID: {{ $employee->id }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- ATTENDANCE BUTTONS -->
                    @php
                    $clockInDisabled = isset($attendance) && $attendance->check_in;
                    $clockOutDisabled = !isset($attendance) || ($attendance && $attendance->check_out);
                    $onDuty = isset($attendance) && $attendance->check_in && !$attendance->check_out;
                    @endphp

                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <button
                            id="clockInBtn"
                            class="group relative px-8 py-4 rounded-xl text-white font-semibold shadow-lg transition-all duration-300 overflow-hidden {{ $clockInDisabled ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:shadow-xl hover:-translate-y-0.5' }}"
                            {{ $clockInDisabled ? 'disabled' : '' }}>
                            <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                            <div class="relative flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Clock In</span>
                            </div>
                        </button>

                        <button
                            id="clockOutBtn"
                            class="group relative px-8 py-4 rounded-xl text-white font-semibold shadow-lg transition-all duration-300 overflow-hidden {{ $clockOutDisabled ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 hover:shadow-xl hover:-translate-y-0.5' }}"
                            {{ $clockOutDisabled ? 'disabled' : '' }}>
                            <div class="absolute inset-0 bg-white/20 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                            <div class="relative flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Clock Out</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- CURRENT STATUS BADGE -->
                @if($onDuty)
                <div class="mt-6 inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-green-100 to-emerald-50 border border-green-200">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse mr-2"></div>
                    <span class="text-sm font-medium text-green-800">Currently on duty • Started at {{ formatTime($attendance->check_in ?? null) }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Attendance Period</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if($filter === 'today')
                        Today's attendance
                        @elseif($filter === 'weekly')
                        This week ({{ $weekRange }})
                        @elseif($filter === 'monthly')
                        {{ $monthName }}
                        @endif
                    </p>
                </div>

                <div class="flex space-x-2">
                    <a href="?filter=today"
                        class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ $filter === 'today' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Today
                    </a>
                    <a href="?filter=weekly"
                        class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ $filter === 'weekly' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        This Week
                    </a>
                    <a href="?filter=monthly"
                        class="px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ $filter === 'monthly' ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        This Month
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- TODAY'S ATTENDANCE STATUS CARD -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Today's Attendance Status</h3>
                        <p class="text-gray-600 mt-1">{{ \Carbon\Carbon::today('Asia/Kolkata')->format('l, d F Y') }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ statusClass($attendance->status ?? 'absent') }}">
                        {{ ucfirst($attendance->status ?? 'Not Marked') }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Clock In Status -->
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-lg bg-green-100">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Clock In Time</p>
                                <p class="text-xl font-bold text-gray-900">{{ formatTime($attendance->check_in ?? null) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($attendance && $attendance->check_in)
                                    <span class="text-green-600 font-medium">✓ Checked In</span>
                                    @else
                                    <span class="text-gray-500">Waiting for clock in</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Clock Out Status -->
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-lg bg-red-100">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Clock Out Time</p>
                                <p class="text-xl font-bold text-gray-900">{{ formatTime($attendance->check_out ?? null) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($attendance && $attendance->check_out)
                                    <span class="text-green-600 font-medium">✓ Shift Completed</span>
                                    @else
                                    <span class="text-gray-500">Not clocked out</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Duty Status -->
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-lg bg-purple-100">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Current Duty</p>
                                <p class="text-xl font-bold text-gray-900">{{ $onDuty ? 'On Duty' : 'Off Duty' }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($onDuty)
                                    <span class="text-green-600 font-medium">● Active</span>
                                    @else
                                    <span class="text-gray-500">● Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 rounded-lg bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Quick Actions</p>
                                <div class="flex space-x-2 mt-2">
                                    @if(!$clockInDisabled)
                                    <button id="clockInBtnSmall" class="text-xs px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">Clock In</button>
                                    @endif
                                    @if(!$clockOutDisabled)
                                    <button id="clockOutBtnSmall" class="text-xs px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">Clock Out</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTICS CARDS -->
    @if($filter !== 'today')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Days Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg border border-blue-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-700 font-medium">Total Days</p>
                    <h3 class="text-3xl font-bold text-blue-900 mt-2">{{ $totalDays }}</h3>
                </div>
                <div class="p-3 rounded-xl bg-white/50">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Present Days Card -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl shadow-lg border border-green-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-700 font-medium">Present Days</p>
                    <h3 class="text-3xl font-bold text-green-900 mt-2">{{ $presentDays }}</h3>
                </div>
                <div class="p-3 rounded-xl bg-white/50">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Late Days Card -->
        <div class="bg-gradient-to-br from-yellow-50 to-amber-100 rounded-2xl shadow-lg border border-yellow-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-700 font-medium">Late Days</p>
                    <h3 class="text-3xl font-bold text-yellow-900 mt-2">{{ $lateDays }}</h3>
                </div>
                <div class="p-3 rounded-xl bg-white/50">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Attendance Percentage Card -->
        <div class="bg-gradient-to-br from-purple-50 to-indigo-100 rounded-2xl shadow-lg border border-purple-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-700 font-medium">Attendance</p>
                    <h3 class="text-3xl font-bold text-purple-900 mt-2">{{ $attendancePercentage }}%</h3>
                </div>
                <div class="relative">
                    <div class="w-16 h-16">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <path d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none"
                                stroke="#E2E8F0"
                                stroke-width="3"
                                stroke-dasharray="100, 100" />
                            <path d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none"
                                stroke="#7C3AED"
                                stroke-width="3"
                                stroke-dasharray="{{ $attendancePercentage }}, 100" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADDITIONAL STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Absent Days -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-xl bg-red-50">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Absent Days</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $absentDays }}</h3>
                </div>
            </div>
        </div>

        <!-- Half Days -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-xl bg-orange-50">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Half Days</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $halfDays }}</h3>
                </div>
            </div>
        </div>

        <!-- Average Hours -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center space-x-4">
                <div class="p-3 rounded-xl bg-indigo-50">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Avg. Hours/Day</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $averageHours }} hrs</h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- HISTORY SECTION -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 lg:p-8 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div>
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900">Attendance Records</h3>
                    <p class="text-gray-600 mt-2">
                        @if($filter === 'today')
                        Today's attendance record
                        @elseif($filter === 'weekly')
                        This week's attendance ({{ $weekRange }})
                        @elseif($filter === 'monthly')
                        {{ $monthName }} attendance
                        @endif
                    </p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text"
                            placeholder="Search by date..."
                            class="pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-300 w-64"
                            id="searchInput">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span>Present</span>
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <span>Late</span>
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span>Absent</span>
                    </div>
                </div>
            </div>
        </div>

        @if($history->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full" id="attendanceTable">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-100 cursor-pointer sortable" data-sort="date">
                            <div class="flex items-center space-x-2">
                                <span>Date</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-100">Day</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-100">Status</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-100">Clock In</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-100">Clock Out</th>
                        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-gray-100 cursor-pointer sortable" data-sort="duration">
                            <div class="flex items-center space-x-2">
                                <span>Duration</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($history as $item)
                    @php
                    $duration = '--';
                    if ($item->check_in && $item->check_out) {
                    $start = \Carbon\Carbon::createFromFormat('H:i:s', $item->check_in);
                    $end = \Carbon\Carbon::createFromFormat('H:i:s', $item->check_out);
                    $diff = $end->diff($start);
                    $duration = sprintf('%dh %02dm', $diff->h, $diff->i);
                    }
                    @endphp
                    <tr class="transition-colors duration-200 hover:bg-gray-50/80 attendance-row">
                        <td class="py-5 px-6 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</div>
                        </td>
                        <td class="py-5 px-6 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->date)->format('l') }}</div>
                        </td>
                        <td class="py-5 px-6 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ statusClass($item->status) }} border">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="py-5 px-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ formatTime($item->check_in) }}</div>
                        </td>
                        <td class="py-5 px-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ formatTime($item->check_out) }}</div>
                        </td>
                        <td class="py-5 px-6 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $duration }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- SUMMARY -->
        <div class="p-6 border-t border-gray-100 bg-gray-50/50">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Total Records</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $history->count() }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Working Days</p>
                    <p class="text-lg font-semibold text-green-600">{{ $presentDays + $lateDays + $halfDays }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Absent Days</p>
                    <p class="text-lg font-semibold text-red-600">{{ $absentDays }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Attendance Rate</p>
                    <p class="text-lg font-semibold text-blue-600">{{ $attendancePercentage }}%</p>
                </div>
            </div>
        </div>
        @else
        <div class="py-16 text-center">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 font-medium">No attendance records found</p>
                    <p class="text-gray-400 text-sm mt-1">No records available for the selected period</p>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Main clock in/out buttons
        const clockInBtn = document.getElementById("clockInBtn");
        const clockOutBtn = document.getElementById("clockOutBtn");

        // Small clock in/out buttons
        const clockInBtnSmall = document.getElementById("clockInBtnSmall");
        const clockOutBtnSmall = document.getElementById("clockOutBtnSmall");

        const messageToast = document.getElementById("messageToast");
        const toastMessage = document.getElementById("toastMessage");

        const showToast = (message, type = 'success') => {
            toastMessage.innerText = message;
            messageToast.className = `fixed top-6 right-6 z-50 animate-slide-in`;

            const icon = messageToast.querySelector('svg');
            const border = messageToast.querySelector('.border-l-4');

            if (type === 'success') {
                icon.innerHTML = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>';
                icon.classList.remove('text-red-600');
                icon.classList.add('text-green-600');
                border.classList.remove('border-red-500');
                border.classList.add('border-green-500');
                messageToast.querySelector('.bg-green-100').classList.replace('bg-green-100', 'bg-green-100');
            } else {
                icon.innerHTML = '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
                icon.classList.remove('text-green-600');
                icon.classList.add('text-red-600');
                border.classList.remove('border-green-500');
                border.classList.add('border-red-500');
                messageToast.querySelector('.bg-green-100').classList.replace('bg-green-100', 'bg-red-100');
            }

            messageToast.classList.remove('hidden');

            setTimeout(() => {
                messageToast.classList.add('animate-slide-out');
                setTimeout(() => {
                    messageToast.classList.add('hidden');
                    messageToast.classList.remove('animate-slide-out');
                }, 300);
            }, 4000);
        };

        const hideToast = () => {
            messageToast.classList.add('animate-slide-out');
            setTimeout(() => {
                messageToast.classList.add('hidden');
                messageToast.classList.remove('animate-slide-out');
            }, 300);
        };

        const markAttendance = async (type) => {
            const button = type === 'clock_in' ? clockInBtn : clockOutBtn;
            const originalText = button.innerHTML;

            // Add loading animation
            button.innerHTML = `
            <div class="relative flex items-center space-x-2">
                <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Processing...</span>
            </div>
        `;
            button.disabled = true;

            try {
                const response = await fetch("{{ route('receptionist.attendance.mark') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        type
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Error!', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            } catch (error) {
                showToast("Network error!", 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        };

        // Event listeners for main buttons
        if (clockInBtn) clockInBtn.addEventListener("click", () => markAttendance("clock_in"));
        if (clockOutBtn) clockOutBtn.addEventListener("click", () => markAttendance("clock_out"));

        // Event listeners for small buttons
        if (clockInBtnSmall) clockInBtnSmall.addEventListener("click", () => markAttendance("clock_in"));
        if (clockOutBtnSmall) clockOutBtnSmall.addEventListener("click", () => markAttendance("clock_out"));

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const attendanceRows = document.querySelectorAll('.attendance-row');

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();

                attendanceRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        // Sort functionality
        const sortableHeaders = document.querySelectorAll('.sortable');

        sortableHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const sortBy = header.dataset.sort;
                const tbody = document.querySelector('#attendanceTable tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                rows.sort((a, b) => {
                    const aValue = a.querySelector(`td:nth-child(${getColumnIndex(sortBy)})`).textContent;
                    const bValue = b.querySelector(`td:nth-child(${getColumnIndex(sortBy)})`).textContent;

                    if (sortBy === 'date') {
                        return new Date(aValue) - new Date(bValue);
                    } else if (sortBy === 'duration') {
                        return parseDuration(aValue) - parseDuration(bValue);
                    }

                    return aValue.localeCompare(bValue);
                });

                // Clear and re-append sorted rows
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            });
        });

        function getColumnIndex(sortBy) {
            switch (sortBy) {
                case 'date':
                    return 1;
                case 'duration':
                    return 6;
                default:
                    return 1;
            }
        }

        function parseDuration(duration) {
            if (duration === '--') return 0;
            const [hours, minutes] = duration.split(' ')[0].replace('h', '').split(' ')[1].replace('m', '').split(' ');
            return parseInt(hours) * 60 + parseInt(minutes || 0);
        }
    });
</script>

<!-- Include helper functions at the bottom -->
@php
function formatTime($time) {
return $time ? \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A') : '-- : --';
}

function statusClass($status) {
return match($status) {
'present' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200 text-green-800',
'late' => 'bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-200 text-yellow-800',
'half_day' => 'bg-gradient-to-r from-orange-50 to-amber-50 border-orange-200 text-orange-800',
'absent' => 'bg-gradient-to-r from-red-50 to-pink-50 border-red-200 text-red-800',
default => 'bg-gradient-to-r from-gray-50 to-gray-100 border-gray-200 text-gray-800'
};
}
@endphp

<!-- Styles -->
<style>
    .sortable:hover {
        background-color: #f9fafb;
        cursor: pointer;
    }

    .attendance-row:hover {
        transform: translateX(4px);
        transition: transform 0.2s ease;
    }
</style>
@endsection