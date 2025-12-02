@extends('layouts.doctor-dashboard')

@section('title', 'Doctor Dashboard')
@section('header-title', 'Doctor Dashboard')

@section('content')
@php
    $doctorId = auth('doctor')->id();
    $totalAppointments = \App\Models\Appointment::where('doctor_id', $doctorId)->count();
    $confirmedAppointments = \App\Models\Appointment::where('doctor_id', $doctorId)->where('status', 'Confirmed')->count();
    $pendingAppointments = \App\Models\Appointment::where('doctor_id', $doctorId)->where('status', 'Pending')->count();
    $cancelledAppointments = \App\Models\Appointment::where('doctor_id', $doctorId)->where('status', 'Cancelled')->count();
@endphp

<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Welcome, Dr. {{ auth('doctor')->user()->name ?? 'Doctor' }}</h1>
                <p class="text-blue-100 opacity-90">Here's your daily overview and appointments summary</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                    <i class="fas fa-calendar-day mr-2"></i>
                    <span>{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Appointments -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl p-6 shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Appointments</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $totalAppointments }}</h2>
                    <p class="text-gray-400 text-xs mt-2">All time appointments</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center rounded-xl shadow-lg">
                    <i class="fa-solid fa-calendar-alt text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-600">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                    <span>Updated in real-time</span>
                </div>
            </div>
        </div>

        <!-- Confirmed Appointments -->
        <div class="bg-gradient-to-br from-white to-green-50 rounded-2xl p-6 shadow-lg border border-green-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Confirmed</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $confirmedAppointments }}</h2>
                    <p class="text-gray-400 text-xs mt-2">Scheduled appointments</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center rounded-xl shadow-lg">
                    <i class="fa-solid fa-calendar-check text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-green-100">
                <div class="flex items-center text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Ready for consultation</span>
                </div>
            </div>
        </div>

        <!-- Pending Appointments -->
        <div class="bg-gradient-to-br from-white to-amber-50 rounded-2xl p-6 shadow-lg border border-amber-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Pending</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $pendingAppointments }}</h2>
                    <p class="text-gray-400 text-xs mt-2">Awaiting confirmation</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-r from-amber-500 to-yellow-600 flex items-center justify-center rounded-xl shadow-lg">
                    <i class="fa-solid fa-clock text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-amber-100">
                <div class="flex items-center text-sm text-amber-600">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    <span>Requires attention</span>
                </div>
            </div>
        </div>

        <!-- Cancelled Appointments -->
        <div class="bg-gradient-to-br from-white to-red-50 rounded-2xl p-6 shadow-lg border border-red-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Cancelled</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $cancelledAppointments }}</h2>
                    <p class="text-gray-400 text-xs mt-2">Cancelled appointments</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-r from-red-500 to-rose-600 flex items-center justify-center rounded-xl shadow-lg">
                    <i class="fa-solid fa-xmark text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-red-100">
                <div class="flex items-center text-sm text-red-600">
                    <i class="fas fa-times-circle mr-1"></i>
                    <span>Requires follow-up</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments Section -->
    @php
        $recentAppointments = \App\Models\Appointment::with(['user', 'relative'])
            ->where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->limit(5)
            ->get();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Appointments Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                    <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Recent Appointments</h3>
                            <p class="text-gray-500 text-sm">Latest appointment activities</p>
                        </div>
                    </div>
                    <a href="{{ route('employee.doctor_appointments') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2.5 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View All
                    </a>
                </div>

                @if($recentAppointments->isEmpty())
                    <div class="text-center py-12">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">No Recent Appointments</h4>
                        <p class="text-gray-500 max-w-md mx-auto">You don't have any recent appointments scheduled.</p>
                        <a href="{{ route('employee.doctor_appointments') }}" 
                           class="inline-flex items-center mt-4 text-blue-600 hover:text-blue-700 font-medium">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Check upcoming appointments
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentAppointments as $app)
                            <div class="group bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                                                <i class="fas fa-user-md text-white text-lg"></i>
                                            </div>
                                            @if($app->status == 'Confirmed')
                                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                                                {{ $app->user->name ?? $app->relative->name ?? 'Patient' }}
                                            </h4>
                                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mt-1">
                                                <span class="inline-flex items-center">
                                                    <i class="fas fa-calendar mr-2 text-blue-500"></i>
                                                    {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                                                </span>
                                                <span class="inline-flex items-center">
                                                    <i class="fas fa-clock mr-2 text-green-500"></i>
                                                    {{ $app->appointment_time }}
                                                </span>
                                                @if($app->relative)
                                                    <span class="inline-flex items-center">
                                                        <i class="fas fa-users mr-2 text-purple-500"></i>
                                                        {{ $app->relative->relation }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full border
                                            @if($app->status == 'Confirmed') 
                                                bg-green-50 text-green-700 border-green-200
                                            @elseif($app->status == 'Pending') 
                                                bg-amber-50 text-amber-700 border-amber-200
                                            @elseif($app->status == 'Cancelled') 
                                                bg-red-50 text-red-700 border-red-200
                                            @else 
                                                bg-gray-50 text-gray-700 border-gray-200
                                            @endif">
                                            <i class="fas
                                                @if($app->status == 'Confirmed') fa-check-circle
                                                @elseif($app->status == 'Pending') fa-clock
                                                @elseif($app->status == 'Cancelled') fa-times-circle
                                                @else fa-question-circle
                                                @endif mr-1.5"></i>
                                            {{ $app->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Stats & Actions -->
        <div class="space-y-6">
            <!-- Today's Schedule -->
            @php
                $todayAppointments = \App\Models\Appointment::where('doctor_id', $doctorId)
                    ->whereDate('appointment_date', now()->toDateString())
                    ->where('status', 'Confirmed')
                    ->count();
            @endphp
            
            <div class="bg-gradient-to-br from-white to-indigo-50 rounded-2xl shadow-xl p-6 border border-indigo-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Today's Schedule</h3>
                    <i class="fas fa-calendar-day text-indigo-500 text-xl"></i>
                </div>
                <div class="text-center py-4">
                    <div class="text-4xl font-bold text-indigo-600 mb-2">{{ $todayAppointments }}</div>
                    <p class="text-gray-600">Confirmed appointments today</p>
                </div>
                <a href="{{ route('employee.doctor_appointments', ['date' => now()->toDateString()]) }}" 
                   class="block w-full mt-4 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-center py-2.5 rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 font-medium">
                    View Today's Schedule
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('employee.doctor_appointments') }}" 
                       class="flex items-center justify-between p-3 rounded-lg bg-blue-50 hover:bg-blue-100 border border-blue-100 transition-colors group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <span class="font-medium text-gray-700 group-hover:text-blue-600">Manage Appointments</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500"></i>
                    </a>
                    
                    <a href="{{route('employee.doctor_patients')}}" 
                       class="flex items-center justify-between p-3 rounded-lg bg-green-50 hover:bg-green-100 border border-green-100 transition-colors group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-medical text-white"></i>
                            </div>
                            <span class="font-medium text-gray-700 group-hover:text-green-600">Patient Records</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-500"></i>
                    </a>
                    
                   
                </div>
            </div>

           
        </div>
    </div>
</div>

@endsection