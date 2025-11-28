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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Appointments -->
    <div class="bg-white bg-white-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Appointments</p>
                <h2 class="text-2xl font-bold mt-1">{{ $totalAppointments }}</h2>
            </div>
            <div class="w-12 h-12 bg-blue-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-calendar-alt text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Confirmed Appointments -->
    <div class="bg-white bg-white-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Confirmed Appointments</p>
            <h2 class="text-2xl font-bold mt-1">{{ $confirmedAppointments }}</h2>
            </div>
            <div class="w-12 h-12 bg-green-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-calendar-check text-green-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Appointments -->
    <div class="bg-white bg-white-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pending Appointments</p>
                <h2 class="text-2xl font-bold mt-1">{{ $pendingAppointments }}</h2>
            </div>
            <div class="w-12 h-12 bg-yellow-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-clock text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Cancelled Appointments -->
    <div class="bg-white bg-white-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Cancelled Appointments</p>
                <h2 class="text-2xl font-bold mt-1">{{ $cancelledAppointments }}</h2>
            </div>
            <div class="w-12 h-12 bg-red-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-xmark text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Appointments Table -->
@php
    $recentAppointments = \App\Models\Appointment::with(['user', 'relative'])
        ->where('doctor_id', $doctorId)
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'desc')
        ->limit(5)
        ->get();
@endphp

<div class="bg-white bg-white-800 shadow-lg rounded-xl p-6 mt-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold">Recent Appointments</h3>
        <a href="{{ route('employee.doctor_appointments') }}" class="text-blue-500 text-sm hover:underline">View All</a>
    </div>

    <div class="overflow-x-auto">
        @if($recentAppointments->isEmpty())
            <div class="p-8 text-center">
                <i class="fas fa-calendar-times text-4xl text-gray-300 text-gray-600 mb-2"></i>
                <p class="text-gray-500 text-gray-400">No recent appointments</p>
            </div>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white-100 bg-white-700 text-sm">
                        <th class="p-3">Patient</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Time</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($recentAppointments as $app)
                        <tr class="border-b border-gray-700">
                            <td class="p-3">{{ $app->user->name ?? $app->relative->name ?? 'Patient' }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}</td>
                            <td class="p-3">{{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}</td>
                            <td class="p-3">
                                <span class="px-3 py-1 text-sm rounded
                                    @if($app->status == 'Confirmed') bg-green-500/20 text-green-600
                                    @elseif($app->status == 'Pending') bg-yellow-500/20 text-yellow-600
                                    @elseif($app->status == 'Cancelled') bg-red-500/20 text-red-600
                                    @else bg-white-500/20 text-gray-600
                                    @endif">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                <button class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
