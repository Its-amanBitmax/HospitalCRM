@extends('layouts.doctor-dashboard')
<style>
    #appointmentModal {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        overflow-y: auto;
    }
</style>

@php
    $hideFooter = true;
@endphp

@section('content')
<!-- Main Content -->
<div class="p-6 flex-1">

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Confirmed -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Confirmed</p>
                        <p class="text-4xl font-bold text-gray-800 dark:text-white mt-2">{{ $confirmed }}</p>
                    </div>
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-4xl font-bold text-gray-800 dark:text-white mt-2">{{ $pending }}</p>
                    </div>
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Appointments</p>
                        <p class="text-4xl font-bold text-gray-800 dark:text-white mt-2">{{ $total }}</p>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                                My Appointments
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">(Next 3 Days)</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                @if($upcoming->isEmpty())
                    <div class="p-16 text-center">
                        <i class="fas fa-calendar-times text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">No upcoming appointments</p>
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-700/30">
                                <th class="px-6 py-3 text-left">Code</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Time</th>
                                <th class="px-6 py-3 text-left">Patient</th>
                                <th class="px-6 py-3 text-left">Issue</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($upcoming as $app)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                     <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-gray-200">
                {{ $app->appointment_code }}
            </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar-day text-blue-500 text-xs"></i>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-clock text-yellow-500 text-xs"></i>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-bold shadow">
                                                {{ substr($app->user->name ?? $app->relative->name ?? 'P', 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $app->user->name ?? $app->relative->name ?? 'Patient' }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $app->for_user_type === 'self' ? 'Self' : 'Relative' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $app->issue ? Str::limit($app->issue, 30) : '—' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            @if($app->status == 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($app->status == 'Confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @elseif($app->status == 'Cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @endif
                                            border border-dashed">
                                            <i class="fas fa-circle text-[8px] mr-1"></i>
                                            {{ $app->status }}
                                        </span>
                                    </td>
<td class="px-6 py-4 text-center space-x-3">
    <button onclick='showAppointmentDetails(@json($app))'
        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
        <i class="fa fa-eye mr-1"></i> View
    </button>
</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Footer -->
            @if(!$upcoming->isEmpty())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between text-sm">
                    <p class="text-gray-600 dark:text-gray-400">
                        Showing {{ $upcoming->count() }} upcoming appointment(s)
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->

<div id="appointmentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative">

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Appointment Details</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl">&times;</button>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 space-y-3" id="appointmentDetails">
            <!-- Filled dynamically -->
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <button onclick="closeModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-medium px-4 py-2 rounded-lg">Close</button>
        </div>
    </div>
</div>

<script>
function showAppointmentDetails(app) {
    const modal = document.getElementById('appointmentModal');
    const detailsDiv = document.getElementById('appointmentDetails');

    const bookedBy = app.for_user_type === 'self'
        ? `<strong>Booked By:</strong> ${app.user?.name ?? 'User'} (Self)`
        : `<strong>Booked For:</strong> ${app.relative?.name ?? 'Relative'} (${app.relative?.relation ?? '-'})`;

    detailsDiv.innerHTML = `
        <div class="space-y-2 text-gray-700 dark:text-gray-300">
            <p><strong>Appointment Code:</strong> ${app.appointment_code}</p>
            <p>${bookedBy}</p>
            <p><strong>Doctor:</strong> ${app.doctor?.name ?? 'N/A'}</p>
            <p><strong>Date:</strong> ${app.appointment_date}</p>
            <p><strong>Time:</strong> ${formatTime(app.appointment_time)}</p>
            <p><strong>Issue:</strong> ${app.issue ?? '—'}</p>
            <p><strong>Description:</strong> ${app.description ?? '—'}</p>
            <p><strong>Status:</strong>
                <span class="font-semibold ${getStatusClass(app.status)}">${app.status}</span>
            </p>
        </div>
    `;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('appointmentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function getStatusClass(status) {
    switch (status) {
        case 'Confirmed': return 'text-green-600 dark:text-green-400';
        case 'Pending': return 'text-yellow-600 dark:text-yellow-400';
        case 'Cancelled': return 'text-red-600 dark:text-red-400';
        default: return 'text-gray-600 dark:text-gray-300';
    }
}

function formatTime(timeStr) {
    const [hour, minute] = timeStr.split(':');
    const h = parseInt(hour);
    const suffix = h >= 12 ? 'PM' : 'AM';
    const formattedHour = ((h + 11) % 12 + 1);
    return `${formattedHour}:${minute} ${suffix}`;
}
</script>


@endsection
