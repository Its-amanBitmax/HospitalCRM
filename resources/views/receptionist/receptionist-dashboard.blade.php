@extends('layouts.receptionist')

@section('content')
<div class="p-6 min-h-screen bg-gray-100">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Receptionist Dashboard</h1>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-5">
            <h2 class="text-gray-500 text-sm">Total Appointments</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalAppointments }}</p>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <h2 class="text-gray-500 text-sm">Today's Appointments</h2>
            <p class="text-3xl font-bold text-green-600">{{ $todayAppointments }}</p>
        </div>

        <div class="bg-white shadow rounded-lg p-5">
            <h2 class="text-gray-500 text-sm">Today's Patient Visits</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $todayVisits }}</p>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-3">Recent Appointments</h2>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-left text-sm">
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Doctor</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Time</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentAppointments as $apt)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $apt->relative->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $apt->doctor->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-2">{{ $apt->appointment_time }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                            No recent appointments.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Patients -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-3">Recent Patients</h2>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-left text-sm">
                        <th class="px-4 py-3">Patient Name</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Date of Visit</th>
                        <th class="px-4 py-3">Visited For</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentPatients as $p)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $p->user->full_name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $p->user->mobile_no ?? 'N/A' }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($p->date_of_visit)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-2">{{ $p->visit_type ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                            No patient visits found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <!-- Receptionist List (TABLE VIEW) -->
    <h2 class="text-xl font-bold text-gray-800 mb-3">Receptionists</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-200 text-gray-700 text-left text-sm">
                    <th class="px-4 py-3">Reception ID</th>
                    <th class="px-4 py-3">Assigned Employee</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created At</th>
                </tr>
            </thead>

            <tbody>
                @forelse($receptions as $reception)
                <tr class="border-b">
                    <td class="px-4 py-2 font-semibold">{{ $reception->reception_id ?? 'N/A' }}</td>
                    <td class="px-4 py-2">
                        {{ $reception->assigned_employee ?? 'Not Assigned' }}
                    </td>

                    <td class="px-4 py-2">{{ ucfirst($reception->status) ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $reception->created_at->format('d M, Y') ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                        No receptionists found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</div>
@endsection