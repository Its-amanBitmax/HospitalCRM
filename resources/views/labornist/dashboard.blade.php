 @extends('layouts.labornist')

@section('content')
<div class="min-h-screen ">

    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-2xl shadow-lg">
                    <i class="fas fa-flask text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-cyan-900">Lab Dashboard</h1>
                    <p class="text-cyan-700 mt-1 flex items-center gap-2">
                        Welcome back, <span class="font-semibold">{{ $laborist->name }}</span>
                        <span class="text-xs bg-gradient-to-r from-cyan-100 to-teal-100 text-cyan-800 px-3 py-1.5 rounded-full border border-cyan-200">
                            <i class="fas fa-id-badge mr-1.5"></i>{{ $laborist->employee_code }}
                        </span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-sm text-cyan-600 font-medium">Today's Activity</p>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg shadow-sm border border-cyan-100">
                            <i class="fas fa-file-medical text-cyan-600 text-sm"></i>
                            <span class="font-bold text-cyan-900">{{ $todayReportsCount }}</span>
                            <span class="text-xs text-cyan-600">Reports</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg shadow-sm border border-teal-100">
                            <i class="fas fa-calendar-check text-teal-600 text-sm"></i>
                            <span class="font-bold text-teal-900">{{ $todayBookingsCount }}</span>
                            <span class="text-xs text-teal-600">Bookings</span>
                        </span>
                    </div>
                </div>
                
                <div class="relative">
                    <!-- <button class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm border border-cyan-100 text-cyan-700 hover:text-cyan-900 hover:border-cyan-200 hover:shadow-md transition-all duration-300">
                        <i class="fas fa-bell text-lg"></i>
                        @if($pendingBookings > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse border border-white shadow">
                                {{ $pendingBookings }}
                            </span>
                        @endif
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Available Tests Card --}}
        <div class="group relative overflow-hidden bg-white rounded-2xl shadow-lg border border-cyan-100 p-6 hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-gradient-to-br from-cyan-100 to-teal-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-50 to-teal-50 flex items-center justify-center">
                            <i class="fas fa-vial text-cyan-600"></i>
                        </div>
                        <p class="text-sm font-medium text-cyan-700">Available Tests</p>
                    </div>
                    <p class="text-3xl font-bold text-cyan-900 mb-2 stat-number">{{ $testCheckupsCount }}</p>
                    <p class="text-xs text-cyan-600 flex items-center gap-1.5">
                        <i class="fas fa-circle text-[8px] text-emerald-500"></i>
                        <span>All active test types</span>
                    </p>
                </div>
                <div class="text-cyan-400 opacity-20 group-hover:opacity-30 transition-opacity duration-500">
                    <i class="fas fa-vial text-4xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Bookings Card --}}
        <div class="group relative overflow-hidden bg-white rounded-2xl shadow-lg border border-teal-100 p-6 hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-gradient-to-br from-teal-100 to-emerald-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-50 to-emerald-50 flex items-center justify-center">
                            <i class="fas fa-calendar-check text-teal-600"></i>
                        </div>
                        <p class="text-sm font-medium text-teal-700">Total Bookings</p>
                    </div>
                    <p class="text-3xl font-bold text-teal-900 mb-2 stat-number">{{ $testBookingsCount }}</p>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1 bg-teal-50 text-teal-800 px-2.5 py-1 rounded-lg text-xs font-medium border border-teal-100">
                            <i class="fas fa-calendar-day text-xs"></i>
                            {{ $todayBookingsCount }} today
                        </span>
                    </div>
                </div>
                <div class="text-teal-400 opacity-20 group-hover:opacity-30 transition-opacity duration-500">
                    <i class="fas fa-calendar-alt text-4xl"></i>
                </div>
            </div>
        </div>

        {{-- Reports Generated Card --}}
        <div class="group relative overflow-hidden bg-white rounded-2xl shadow-lg border border-blue-100 p-6 hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-50 to-cyan-50 flex items-center justify-center">
                            <i class="fas fa-file-medical-alt text-blue-600"></i>
                        </div>
                        <p class="text-sm font-medium text-blue-700">Reports Generated</p>
                    </div>
                    <p class="text-3xl font-bold text-blue-900 mb-2 stat-number">{{ $testReportsCount }}</p>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-800 px-2.5 py-1 rounded-lg text-xs font-medium border border-blue-100">
                            <i class="fas fa-bolt text-xs"></i>
                            {{ $todayReportsCount }} today
                        </span>
                    </div>
                </div>
                <div class="text-blue-400 opacity-20 group-hover:opacity-30 transition-opacity duration-500">
                    <i class="fas fa-file-medical text-4xl"></i>
                </div>
            </div>
        </div>

        {{-- Active Patients Card --}}
        <div class="group relative overflow-hidden bg-white rounded-2xl shadow-lg border border-cyan-100 p-6 hover:shadow-xl transition-all duration-500 hover:-translate-y-1">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-gradient-to-br from-cyan-100 to-teal-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-50 to-teal-50 flex items-center justify-center">
                            <i class="fas fa-user-injured text-cyan-600"></i>
                        </div>
                        <p class="text-sm font-medium text-cyan-700">Active Patients</p>
                    </div>
                    <p class="text-3xl font-bold text-cyan-900 mb-2">{{ $activePatientsCount }}</p>
                    <p class="text-xs text-cyan-600 flex items-center gap-1.5">
                        <i class="fas fa-users text-xs"></i>
                        <span>Unique patients served</span>
                    </p>
                </div>
                <div class="text-cyan-400 opacity-20 group-hover:opacity-30 transition-opacity duration-500">
                    <i class="fas fa-users text-4xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Left Column: Recent Reports --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Recent Reports --}}
            <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-cyan-900 flex items-center gap-2">
                            <span class="p-2 bg-gradient-to-br from-cyan-50 to-teal-50 rounded-lg">
                                <i class="fas fa-file-medical text-cyan-600"></i>
                            </span>
                            Recent Test Reports
                        </h3>
                        <p class="text-sm text-cyan-600 mt-1 ml-12">Latest generated reports from your lab</p>
                    </div>
                    <a href="#" class="inline-flex items-center gap-2 text-sm text-cyan-700 hover:text-cyan-900 font-medium px-4 py-2 rounded-lg hover:bg-cyan-50 transition-all duration-300">
                        View All
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                
                @if($recentReports->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentReports as $report)
                        <div class="group relative overflow-hidden bg-gradient-to-r from-cyan-50/50 to-white border border-cyan-100 rounded-xl p-4 hover:border-cyan-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-100 to-cyan-200 flex items-center justify-center group-hover:from-cyan-200 group-hover:to-teal-200 transition-all duration-300">
                                            <i class="fas fa-file-pdf text-cyan-600"></i>
                                        </div>
                                        @if($report->doctor_status == 'approved')
                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-full flex items-center justify-center text-xs border border-white shadow">
                                            <i class="fas fa-check text-xs"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-cyan-900 group-hover:text-cyan-800">{{ Str::limit($report->file_name, 40) }}</p>
                                        <div class="flex items-center gap-3 mt-1.5">
                                            <span class="inline-flex items-center gap-1.5 text-xs text-cyan-700">
                                                <i class="fas fa-user-injured text-xs"></i>
                                                {{ optional($report->user)->full_name ?? 'N/A' }}
                                            </span>
                                            @if($report->doctor)
                                            <span class="inline-flex items-center gap-1.5 text-xs text-teal-700">
                                                <i class="fas fa-user-md text-xs"></i>
                                                {{ optional($report->doctor)->full_name }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @php
                                        $statusColor = $report->user_status == 'active' 
                                            ? 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-800 border border-emerald-200' 
                                            : 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border border-amber-200';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        {{ ucfirst($report->user_status) }}
                                    </span>
                                    <p class="text-xs text-cyan-600 mt-2">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $report->created_at ? $report->created_at->format('h:i A') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-cyan-100 to-teal-100 flex items-center justify-center">
                            <i class="fas fa-file-medical text-2xl text-cyan-500"></i>
                        </div>
                        <p class="text-cyan-700 font-medium">No reports generated yet</p>
                        <p class="text-sm text-cyan-600 mt-2">Start by creating your first test report</p>
                    </div>
                @endif
                
                {{-- Stats Bar --}}
                <div class="mt-8 pt-6 border-t border-cyan-100">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-3 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl border border-cyan-200">
                            <p class="text-2xl font-bold text-cyan-700">{{ $todayReportsCount }}</p>
                            <p class="text-sm text-cyan-600 font-medium">Today</p>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border border-teal-200">
                            <p class="text-2xl font-bold text-teal-700">{{ $testReportsCount }}</p>
                            <p class="text-sm text-teal-600 font-medium">Total</p>
                        </div>
                        <div class="text-center p-3 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl border border-blue-200">
                            @php
                                $avgDaily = $testReportsCount > 0 ? round($testReportsCount / 30, 1) : 0;
                            @endphp
                            <p class="text-2xl font-bold text-blue-700">{{ $avgDaily }}</p>
                            <p class="text-sm text-blue-600 font-medium">Avg/Day</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Weekly Activity Chart --}}
            <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-cyan-900 flex items-center gap-2">
                            <span class="p-2 bg-gradient-to-br from-cyan-50 to-teal-50 rounded-lg">
                                <i class="fas fa-chart-line text-cyan-600"></i>
                            </span>
                            Weekly Activity
                        </h3>
                        <p class="text-sm text-cyan-600 mt-1 ml-12">Reports generated this week</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-gradient-to-r from-cyan-500 to-teal-500"></span>
                        <span class="text-sm text-cyan-700 font-medium">Reports</span>
                    </div>
                </div>
                
                <div class="h-64">
                    @if($weeklyData->count() > 0)
                        <div class="w-full h-full">
                            <div class="flex items-end justify-between h-48 px-4">
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <div class="flex flex-col items-center">
                                    @php
                                        $count = $weeklyData[$day]->count ?? 0;
                                        $maxCount = max($weeklyData->max('count'), 1);
                                        $height = ($count / $maxCount) * 100;
                                    @endphp
                                    <div class="relative w-12">
                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-cyan-500 to-teal-400 rounded-t-lg transition-all duration-700 hover:from-cyan-600 hover:to-teal-500 cursor-pointer"
                                             style="height: {{ $height }}%"
                                             title="{{ $count }} reports">
                                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 text-sm font-bold text-cyan-800 bg-white px-2 py-1 rounded-lg shadow-sm border border-cyan-100">
                                                {{ $count }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-12 text-sm text-cyan-700 font-medium">{{ substr($day, 0, 3) }}</p>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-8 flex items-center justify-center gap-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-gradient-to-r from-cyan-500 to-teal-500"></div>
                                    <span class="text-sm text-cyan-700">Current Week</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 rounded-full bg-gradient-to-r from-cyan-300 to-teal-300"></div>
                                    <span class="text-sm text-cyan-700">Average</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full flex flex-col items-center justify-center">
                            <div class="w-20 h-20 mb-4 rounded-full bg-gradient-to-br from-cyan-100 to-teal-100 flex items-center justify-center">
                                <i class="fas fa-chart-bar text-2xl text-cyan-500"></i>
                            </div>
                            <p class="text-cyan-700 font-medium">No weekly data available</p>
                            <p class="text-sm text-cyan-600 mt-2">Data will appear after reports are generated</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Profile Card --}}
            <div class="bg-gradient-to-br from-cyan-50 to-teal-50 rounded-2xl shadow-lg border border-cyan-200 p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-4">
                        @if($laborist->image)
                            <img src="{{ asset('storage/' . $laborist->image) }}" alt="Profile Image" 
                                 class="w-24 h-24 rounded-2xl mx-auto border-2 shadow-lg object-cover">
                        @else
                            <div class="w-24 h-24 rounded-2xl mx-auto bg-gradient-to-br from-cyan-500 to-teal-500 flex items-center justify-center border-4 border-white shadow-lg">
                                <i class="fas fa-user text-white text-3xl"></i>
                            </div>
                        @endif
                      
                    </div>
                    
                    <h3 class="text-xl font-bold text-cyan-900 mb-1">{{ $laborist->name }}</h3>
                    <p class="text-sm text-cyan-700 mb-3">
                        <i class="fas fa-id-badge mr-1.5"></i>{{ $laborist->employee_code }}
                    </p>
                    
                    <div class="flex flex-wrap items-center justify-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg text-xs text-cyan-700 font-medium border border-cyan-100 shadow-sm">
                            <i class="fas fa-building text-xs"></i>
                            {{ optional($laborist->department)->name ?? 'Lab Department' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg text-xs text-teal-700 font-medium border border-teal-100 shadow-sm">
                            <i class="fas fa-calendar text-xs"></i>
                            {{ $laborist->hire_date ? $laborist->hire_date->format('M Y') : 'N/A' }}
                        </span>
                    </div>
                    
                    <div class="w-full bg-white/50 rounded-xl p-3 border border-cyan-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-cyan-700">{{ $testCheckupsCount }}</p>
                                <p class="text-xs text-cyan-600">Tests</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-teal-700">{{ $testReportsCount }}</p>
                                <p class="text-xs text-teal-600">Reports</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Today's Bookings --}}
            <div class="bg-white rounded-2xl shadow-lg border border-teal-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-teal-900 flex items-center gap-2">
                            <span class="p-2 bg-gradient-to-br from-teal-50 to-emerald-50 rounded-lg">
                                <i class="fas fa-calendar-check text-teal-600"></i>
                            </span>
                            Today's Bookings
                        </h3>
                        <p class="text-sm text-teal-600 mt-1 ml-12">Appointments scheduled</p>
                    </div>
                    <span class="px-3 py-1.5 bg-gradient-to-r from-teal-100 to-emerald-100 text-teal-800 rounded-lg text-sm font-medium border border-teal-200">
                        {{ $recentBookings->count() }}
                    </span>
                </div>

                @if($recentBookings->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentBookings as $booking)
                        <div class="group p-3 bg-gradient-to-r from-teal-50/50 to-white border border-teal-100 rounded-xl hover:border-teal-200 hover:shadow-sm transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center group-hover:from-teal-200 group-hover:to-cyan-200 transition-all duration-300">
                                        <i class="fas fa-calendar-check text-teal-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-teal-900 text-sm">
                                            {{ optional($booking->test)->test_name ?? 'Test' }}
                                        </p>
                                        <p class="text-xs text-teal-700 flex items-center gap-1.5 mt-1">
                                            <i class="fas fa-user text-xs"></i>
                                            {{ optional($booking->user)->full_name ?? 'Patient' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-cyan-900">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                    </p>
                                    @php
                                        $bookingStatusColor = [
                                            'pending' => 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-800 border border-amber-200',
                                            'booked' => 'bg-gradient-to-r from-cyan-50 to-blue-50 text-cyan-800 border border-cyan-200',
                                            'completed' => 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-800 border border-emerald-200',
                                            'cancelled' => 'bg-gradient-to-r from-red-50 to-pink-50 text-red-800 border border-red-200',
                                        ][$booking->status] ?? 'bg-gradient-to-r from-gray-50 to-gray-100 text-gray-800 border border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium {{ $bookingStatusColor }} mt-1.5">
                                        <i class="fas fa-circle text-[6px]"></i>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gradient-to-br from-teal-100 to-cyan-100 flex items-center justify-center">
                            <i class="fas fa-calendar-times text-xl text-teal-500"></i>
                        </div>
                        <p class="text-teal-700 font-medium">No bookings scheduled</p>
                        <p class="text-sm text-teal-600 mt-2">Check back later for updates</p>
                    </div>
                @endif

                @if($pendingBookings > 0)
                <div class="mt-4 p-3 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-amber-100 to-yellow-100 border border-amber-200 flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-circle text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-amber-900">
                                {{ $pendingBookings }} pending bookings
                            </p>
                            <p class="text-xs text-amber-700">Require your attention</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <!-- <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl shadow-lg border border-cyan-200 p-6">
                <h3 class="text-xl font-bold text-cyan-900 mb-6">Quick Actions</h3>
                
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="group relative overflow-hidden bg-white border border-cyan-200 rounded-xl p-4 text-center hover:border-cyan-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-gradient-to-br from-cyan-50 to-teal-50 flex items-center justify-center group-hover:from-cyan-100 group-hover:to-teal-100 transition-all duration-300">
                            <i class="fas fa-calendar-plus text-cyan-600 text-xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="font-semibold text-cyan-900 text-sm">View Bookings</p>
                        <p class="text-xs text-cyan-600 mt-1">Manage appointments</p>
                    </a>
                    
                    <a href="#" class="group relative overflow-hidden bg-white border border-teal-200 rounded-xl p-4 text-center hover:border-teal-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-gradient-to-br from-teal-50 to-emerald-50 flex items-center justify-center group-hover:from-teal-100 group-hover:to-emerald-100 transition-all duration-300">
                            <i class="fas fa-file-medical text-teal-600 text-xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="font-semibold text-teal-900 text-sm">Generate Report</p>
                        <p class="text-xs text-teal-600 mt-1">Create new report</p>
                    </a>
                    
                    <a href="#" class="group relative overflow-hidden bg-white border border-blue-200 rounded-xl p-4 text-center hover:border-blue-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 flex items-center justify-center group-hover:from-blue-100 group-hover:to-cyan-100 transition-all duration-300">
                            <i class="fas fa-vial text-blue-600 text-xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="font-semibold text-blue-900 text-sm">View Tests</p>
                        <p class="text-xs text-blue-600 mt-1">Available tests</p>
                    </a>
                    
                    <a href="#" class="group relative overflow-hidden bg-white border border-cyan-200 rounded-xl p-4 text-center hover:border-cyan-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-gradient-to-br from-cyan-50 to-teal-50 flex items-center justify-center group-hover:from-cyan-100 group-hover:to-teal-100 transition-all duration-300">
                            <i class="fas fa-user-cog text-cyan-600 text-xl group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <p class="font-semibold text-cyan-900 text-sm">Profile</p>
                        <p class="text-xs text-cyan-600 mt-1">Update settings</p>
                    </a>
                </div>
            </div> -->
        </div>
    </div>

    {{-- Footer --}}
    <div class="mt-8 pt-6 border-t border-cyan-100">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-cyan-600">
                <i class="fas fa-info-circle"></i>
                <span>Last updated: {{ now()->format('F j, Y \a\t h:i A') }}</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-cyan-600">
                    <i class="fas fa-shield-alt mr-1"></i>Secure & Encrypted
                </span>
                <span class="text-xs text-teal-600">
                    <i class="fas fa-sync-alt mr-1"></i>Real-time Updates
                </span>
            </div>
        </div>
    </div>

</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes pulse-soft {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .animate-pulse-soft {
        animation: pulse-soft 2s ease-in-out infinite;
    }
    
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f0f9ff;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #22d3ee, #0ea5e9);
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #06b6d4, #0284c7);
    }
    
    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Custom animations */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .glow {
        box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);
    }
    
    .glow:hover {
        box-shadow: 0 0 30px rgba(6, 182, 212, 0.5);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth card hover effects
        const cards = document.querySelectorAll('.hover\\:-translate-y-1');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
        
        // Animate chart bars on hover
        const chartBars = document.querySelectorAll('[title*="reports"]');
        chartBars.forEach(bar => {
            bar.addEventListener('mouseenter', function() {
                this.style.transform = 'scaleY(1.1)';
                this.style.transformOrigin = 'bottom';
            });
            
            bar.addEventListener('mouseleave', function() {
                this.style.transform = 'scaleY(1)';
            });
        });
        
        // Real-time clock update
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit'
            });
            const dateString = now.toLocaleDateString('en-US', { 
                weekday: 'long',
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            });
            
            const clockElements = document.querySelectorAll('.text-cyan-600');
            clockElements.forEach(el => {
                if (el.textContent.includes('Last updated:')) {
                    el.innerHTML = `<i class="fas fa-info-circle"></i> Last updated: ${dateString} at ${timeString}`;
                }
            });
        }
        
        // Update every second
        setInterval(updateClock, 1000);
        updateClock();
        
        // Add loading animation to stats
        const statsNumbers = document.querySelectorAll('.stat-number');
        statsNumbers.forEach((number, index) => {
            const target = parseInt(number.textContent.replace(/,/g, ''));
            let current = 0;
            const increment = target / 50;
            const duration = 1500; // 1.5 seconds
            
            const startTime = Date.now();
            
            function animateNumber() {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function for smooth animation
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                current = target * easeOutQuart;
                
                if (progress < 1) {
                    number.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(animateNumber);
                } else {
                    number.textContent = target.toLocaleString();
                }
            }
            
            // Start animation with a slight delay for each card
            setTimeout(animateNumber, index * 100);
        });
        
        // Add click effect to quick action buttons
        const actionButtons = document.querySelectorAll('.rounded-xl.text-center');
        actionButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(6, 182, 212, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    top: ${y}px;
                    left: ${x}px;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection