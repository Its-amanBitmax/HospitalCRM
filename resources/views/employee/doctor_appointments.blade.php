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
use Illuminate\Support\Str;
use Carbon\Carbon;

// SAFE helper for time range
function displayTimeRange($time)
{
    if (!$time) return '—';

    $parts = explode(' - ', $time);
    $start = trim($parts[0] ?? '');
    $end   = trim($parts[1] ?? '');

    $startF = $start ? Carbon::parse($start)->format('h:i A') : '';
    $endF   = $end ? Carbon::parse($end)->format('h:i A') : '';

    return $endF ? "$startF - $endF" : $startF;
}
@endphp

@section('content')

<div class="p-6 flex-1">

    <!-- ================================ -->
    <!--             STAT CARDS           -->
    <!-- ================================ -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Confirmed -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Confirmed</p>
                    <p class="text-4xl font-bold mt-2">{{ $confirmed }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-4xl font-bold mt-2">{{ $pending }}</p>
                </div>
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- Total -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Appointments</p>
                    <p class="text-4xl font-bold mt-2">{{ $total }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- ================================ -->
    <!--       UPCOMING APPOINTMENTS      -->
    <!-- ================================ -->

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden mb-10">

        <div class="bg-gray-50 px-6 py-4 border-b">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Upcoming Appointments</h2>
                    <p class="text-xs text-gray-500">(Next 3 Days)</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            @if($upcoming->isEmpty())
            <div class="p-16 text-center">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No upcoming appointments</p>
            </div>
            @else

            <table class="w-full">
                <thead>
                    <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Time</th>
                        <th class="px-6 py-3 text-left">Patient</th>
                        <th class="px-6 py-3 text-left">Issue</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach($upcoming->take(3) as $app)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 text-sm font-semibold">
                            {{ $app->appointment_code }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ Carbon::parse($app->appointment_date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ displayTimeRange($app->appointment_time) }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                    {{ substr($app->user->full_name ?? $app->relative->name ?? 'NA', 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium">
                                        {{ $app->user->full_name ?? $app->relative->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $app->for_user_type === 'self' ? 'Self' : 'Relative' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $app->issue ? Str::limit($app->issue, 30) : '—' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($app->status == 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($app->status == 'Confirmed') bg-green-100 text-green-800
                                @elseif($app->status == 'Cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button onclick='showAppointmentDetails(@json($app))'
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fa fa-eye mr-1"></i> View
                            </button>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>

            @endif
        </div>

    </div>

    <!-- ================================ -->
    <!--         ALL APPOINTMENTS         -->
    <!-- ================================ -->

    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mt-10">

        <div class="bg-gray-50 px-6 py-4 border-b">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list text-purple-600"></i>
                </div>
                <h2 class="text-lg font-semibold">All Appointments</h2>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($allAppointments->isEmpty())
            <div class="p-16 text-center">
                <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No appointment records found</p>
            </div>
            @else

            <table class="w-full">
                <thead>
                    <tr class="text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Time</th>
                        <th class="px-6 py-3 text-left">Patient</th>
                        <th class="px-6 py-3 text-left">Issue</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach($allAppointments as $app)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 text-sm font-semibold">
                            {{ $app->appointment_code }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ Carbon::parse($app->appointment_date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ displayTimeRange($app->appointment_time) }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                    {{ substr($app->user->full_name ?? $app->relative->name ?? 'NA', 0, 2) }}
                                </div>

                                <div>
                                    <p class="text-sm font-medium">
                                        {{ $app->user->full_name ?? $app->relative->name ?? 'Unknown' }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ $app->for_user_type === 'self' ? 'Self' : 'Relative' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ $app->issue ? Str::limit($app->issue, 30) : '—' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($app->status == 'Pending') bg-yellow-100 text-yellow-800
                                @elseif($app->status == 'Confirmed') bg-green-100 text-green-800
                                @elseif($app->status == 'Cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button onclick='showAppointmentDetails(@json($app))'
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fa fa-eye mr-1"></i> View
                            </button>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>

            @endif

        </div>
    </div>

</div>

<!-- ================================ -->
<!--           MODAL SECTION          -->
<!-- ================================ -->

<div id="appointmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative">

        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Appointment Details</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>

        <div class="px-6 py-4 space-y-3" id="appointmentDetails"></div>

        <div class="flex justify-end gap-3 px-6 py-4 border-t">
            <button onclick="closeModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg">Close</button>

            <form id="acceptForm" method="POST" style="display: none;">
                @csrf @method('PUT')
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg">Accept</button>
            </form>

            <form id="rejectForm" method="POST" style="display: none;">
                @csrf @method('PUT')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg">Reject</button>
            </form>
        </div>

    </div>
</div>

<script>
    function showAppointmentDetails(app) {
        const modal = document.getElementById('appointmentModal');
        const detailsDiv = document.getElementById('appointmentDetails');

        let timeDisplay = app.appointment_time;
        if (timeDisplay.includes('-')) {
            // keep "05:00 AM - 05:30 AM" original format
        }

        detailsDiv.innerHTML = `
            <div class="space-y-2 text-gray-700">
                <p><strong>Appointment Code:</strong> ${app.appointment_code}</p>
                <p><strong>Date:</strong> ${app.appointment_date}</p>
                <p><strong>Time:</strong> ${timeDisplay}</p>
                <p><strong>Issue:</strong> ${app.issue ?? '—'}</p>
                <p><strong>Description:</strong> ${app.description ?? '—'}</p>
                <p><strong>Status:</strong> ${app.status}</p>
            </div>
        `;

        document.getElementById('acceptForm').style.display = app.status === 'Pending' ? 'inline-block' : 'none';
        document.getElementById('rejectForm').style.display = app.status === 'Pending' ? 'inline-block' : 'none';

        if (app.status === 'Pending') {
            acceptForm.action = `/employee/appointments/${app.appointment_id}/accept`;
            rejectForm.action = `/employee/appointments/${app.appointment_id}/reject`;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        document.getElementById('appointmentModal').classList.add('hidden');
    }
</script>

@endsection
