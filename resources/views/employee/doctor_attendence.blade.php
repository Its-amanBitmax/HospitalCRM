@extends('layouts.doctor-dashboard')

@section('content')
<div class="p-4 md:p-6 bg-gradient-to-br from-gray-50 to-white min-h-screen">

    <!-- Notification Toast -->
    <div id="notificationToast" class="hidden fixed top-6 right-6 z-50">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-4 animate-slide-in">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span id="toastMessage" class="font-medium"></span>
        </div>
    </div>

    <!-- Header Section -->
    <div class="mb-8">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-xl p-6 text-white mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="relative">
                        <img src="{{ $doctor->image ? asset('storage/' . $doctor->image) : asset('images/default-profile.png') }}"
                            alt="Profile"
                            class="w-16 h-16 rounded-full object-cover border-4 border-white/30 shadow-lg">
                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $doctor->name }}</h1>
                        <p class="text-blue-100 flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            ID: {{ $doctor->employee_code }} • <span class="ml-2">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="flex items-center space-x-4 bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $totalPresent ?? 0 }}</div>
                        <div class="text-sm text-blue-100">Present Days</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Time Display -->
            <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Current Time</div>
                        <div id="liveClock" class="text-2xl font-bold text-gray-800">--:-- --</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500 mb-1">Status</div>
                        <div class="text-lg font-semibold {{ isset($attendance) && $attendance->check_in ? 'text-green-600' : 'text-amber-600' }}">
                            {{ isset($attendance) && $attendance->check_in 
    ? ($attendance->check_out ? 'Off Duty' : 'On Duty') 
    : 'Off Duty' 
}}

                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                @php
                $clockInDisabled = isset($attendance) && $attendance->check_in;
                $clockOutDisabled = !isset($attendance) || ($attendance && $attendance->check_out);
                @endphp

                <!-- Clock In Button -->
                <button id="clockInBtn"
                    class="flex-1 min-w-[140px] bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 
                           text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl 
                           transition-all duration-300 flex items-center justify-center space-x-3
                           {{ $clockInDisabled ? 'opacity-50 cursor-not-allowed grayscale' : 'hover:scale-[1.02]' }}"
                    {{ $clockInDisabled ? 'disabled' : '' }}>
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="font-bold">Clock In</div>
                        <div class="text-xs opacity-90">{{ $clockInDisabled ? 'Already marked' : 'Start your shift' }}</div>
                    </div>
                </button>

                <!-- Clock Out Button -->
                <button id="clockOutBtn"
                    class="flex-1 min-w-[140px] bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 
                           text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl 
                           transition-all duration-300 flex items-center justify-center space-x-3
                           {{ $clockOutDisabled ? 'opacity-50 cursor-not-allowed grayscale' : 'hover:scale-[1.02]' }}"
                    {{ $clockOutDisabled ? 'disabled' : '' }}>
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="font-bold">Clock Out</div>
                        <div class="text-xs opacity-90">{{ $clockOutDisabled ? 'Not available' : 'End your shift' }}</div>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Column: Today's Attendance -->
        <div class="lg:col-span-2">
            <!-- Today's Attendance Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Today's Attendance
                    </h3>
                    <span class="text-sm font-medium px-3 py-1 rounded-full bg-blue-50 text-blue-700">
                        {{ \Carbon\Carbon::today()->format('d M Y') }}
                    </span>
                </div>

                @php
                function formatTime($time) {
                return $time ? \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A') : '--:--';
                }

                $statusConfig = match($attendance->status ?? '') {
                'present' => ['color' => 'bg-gradient-to-r from-green-500 to-emerald-600', 'icon' => 'check-circle', 'text' => 'Present'],
                'late' => ['color' => 'bg-gradient-to-r from-amber-500 to-yellow-600', 'icon' => 'clock', 'text' => 'Late'],
                'half_day' => ['color' => 'bg-gradient-to-r from-blue-500 to-indigo-600', 'icon' => 'minus-circle', 'text' => 'Half Day'],
                default => ['color' => 'bg-gradient-to-r from-gray-400 to-gray-500', 'icon' => 'x-circle', 'text' => 'Not Marked']
                };
                @endphp

                <!-- Status Card -->
                <div class="relative overflow-hidden rounded-xl p-6 mb-6 text-white {{ $statusConfig['color'] }}">
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm opacity-90 mb-2">STATUS</div>
                                <div class="text-3xl font-bold">{{ $statusConfig['text'] }}</div>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($statusConfig['icon'] === 'check-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @elseif($statusConfig['icon'] === 'clock')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @elseif($statusConfig['icon'] === 'minus-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    @endif
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time Cards -->
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Clock In Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-700">Clock In</span>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-800 mb-2">{{ formatTime($attendance->check_in ?? null) }}</div>
                        @if($attendance && $attendance->check_in)
                        <div class="text-sm text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Marked successfully
                        </div>
                        @else
                        <div class="text-sm text-gray-500">Waiting for clock in...</div>
                        @endif
                    </div>

                    <!-- Clock Out Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-rose-100 rounded-lg">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-700">Clock Out</span>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-800 mb-2">{{ formatTime($attendance->check_out ?? null) }}</div>
                        @if($attendance && $attendance->check_out)
                        <div class="text-sm text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Shift completed
                        </div>
                        @elseif($attendance && $attendance->check_in)
                        <div class="text-sm text-blue-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            On duty - Ready to clock out
                        </div>
                        @else
                        <div class="text-sm text-gray-500">Not available</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Attendance History -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center mb-4 sm:mb-0">
                            <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            Attendance History
                        </h3>

                        <!-- Filter Tabs -->
                        <div class="flex bg-gray-100 p-1 rounded-lg">
                            <a href="{{ route('doctor.attendence', ['filter' => 'today']) }}"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200
                                      {{ ($filter ?? '')=='today' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                Today
                            </a>
                            <a href="{{ route('doctor.attendence', ['filter' => 'weekly']) }}"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200
                                      {{ ($filter ?? '')=='weekly' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                This Week
                            </a>
                            <a href="{{ route('doctor.attendence', ['filter' => 'monthly']) }}"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200
                                      {{ ($filter ?? '')=='monthly' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                                This Month
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Clock In</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Clock Out</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($history as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->date)->format('l') }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                    $statusBadge = match($item->status) {
                                    'present' => ['class' => 'bg-green-100 text-green-800', 'icon' => '✓'],
                                    'late' => ['class' => 'bg-amber-100 text-amber-800', 'icon' => '⏰'],
                                    'half_day' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => '½'],
                                    'absent' => ['class' => 'bg-rose-100 text-rose-800', 'icon' => '✕'],
                                    default => ['class' => 'bg-gray-100 text-gray-800', 'icon' => '?']
                                    };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadge['class'] }}">
                                        {{ $statusBadge['icon'] }}
                                        <span class="ml-1">{{ ucfirst($item->status) }}</span>
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900">{{ formatTime($item->check_in) }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900">{{ formatTime($item->check_out) }}</div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 text-lg mb-2">No attendance records</p>
                                        <p class="text-gray-400 text-sm">Your attendance history will appear here</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($history->count() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div>
                            Showing <span class="font-semibold">{{ $history->count() }}</span> records
                        </div>
                        <div>
                            Total Present Days:
                            <span class="font-semibold text-green-600 ml-1">
                                {{ $history->where('status', 'present')->count() }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Stats & Filters -->
        <div class="space-y-6">
            <!-- Attendance Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                    </div>
                    Attendance Summary
                </h3>

                <!-- Stats Grid -->
                <div class="space-y-4">
                    @php
                    $total = $history->count();
                    $present = $history->where('status', 'present')->count();
                    $halfDay = $history->where('status', 'half_day')->count();
                    $absent = $history->where('status', 'absent')->count();
                    @endphp

                    <!-- Present -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Present</span>
                            <span class="font-semibold">{{ $present }}</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full transition-all duration-500"
                                style="width: {{ $total > 0 ? ($present/$total)*100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Half Day -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Half Day</span>
                            <span class="font-semibold">{{ $halfDay }}</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full transition-all duration-500"
                                style="width: {{ $total > 0 ? ($halfDay/$total)*100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Absent -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Absent</span>
                            <span class="font-semibold">{{ $absent }}</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-rose-400 to-pink-500 rounded-full transition-all duration-500"
                                style="width: {{ $total > 0 ? ($absent/$total)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="mt-6 p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ $present }}</div>
                            <div class="text-xs text-gray-500">Present</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ $halfDay }}</div>
                            <div class="text-xs text-gray-500">Half Days</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">{{ $total }}</div>
                            <div class="text-xs text-gray-500">Total Days</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Insights -->
            <!-- <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl border border-indigo-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Quick Insights
                </h3>

                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-green-100 rounded-lg mt-1">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Attendance Rate</p>
                            <p class="text-sm text-gray-600">{{ $total > 0 ? round((($present + $halfDay/2)/$total)*100, 1) : 0 }}% overall</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-blue-100 rounded-lg mt-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Average Hours</p>
                            <p class="text-sm text-gray-600">{{ $averageHours ?? '--' }} hours per day</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-amber-100 rounded-lg mt-1">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Current Streak</p>
                            <p class="text-sm text-gray-600">{{ $currentStreak ?? '0' }} consecutive days</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Update live clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('liveClock').textContent = timeString;
        }

        updateClock();
        setInterval(updateClock, 1000);

        // Toast notification
        const notificationToast = document.getElementById('notificationToast');
        const toastMessage = document.getElementById('toastMessage');

        const showToast = (message, type = 'success') => {
            toastMessage.textContent = message;

            // Update toast color based on type
            const toast = notificationToast.querySelector('div');
            if (type === 'success') {
                toast.className = 'bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-4 animate-slide-in';
            } else {
                toast.className = 'bg-gradient-to-r from-rose-500 to-pink-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-4 animate-slide-in';
            }

            notificationToast.classList.remove('hidden');

            setTimeout(() => {
                notificationToast.classList.add('animate-slide-out');
                setTimeout(() => {
                    notificationToast.classList.add('hidden');
                    notificationToast.classList.remove('animate-slide-out');
                }, 300);
            }, 3000);
        };

        // Attendance marking
        const markAttendance = async (type) => {
            const button = type === 'clock_in' ? document.getElementById('clockInBtn') : document.getElementById('clockOutBtn');
            const originalContent = button.innerHTML;
            const buttonText = type === 'clock_in' ? 'Clocking In...' : 'Clocking Out...';

            // Show loading state
            button.innerHTML = `
            <div class="p-2 bg-white/20 rounded-lg">
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
            <div class="text-left">
                <div class="font-bold">${buttonText}</div>
                <div class="text-xs opacity-90">Processing...</div>
            </div>
        `;
            button.disabled = true;

            try {
                const response = await fetch("{{ route('doctor.attendance.mark') }}", {
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
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showToast(data.message || 'Something went wrong!', 'error');
                    button.innerHTML = originalContent;
                    button.disabled = false;
                }
            } catch (error) {
                showToast("Network error! Please check your connection.", 'error');
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        };

        // Event listeners
        document.getElementById('clockInBtn')?.addEventListener('click', () => markAttendance('clock_in'));
        document.getElementById('clockOutBtn')?.addEventListener('click', () => markAttendance('clock_out'));

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe cards for animation
        document.querySelectorAll('.bg-white').forEach(card => {
            observer.observe(card);
        });
    });
</script>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }

    .animate-slide-out {
        animation: slideOut 0.3s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Smooth transitions */
    * {
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }
</style>
@endsection