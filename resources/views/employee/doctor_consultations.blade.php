@extends('layouts.doctor-dashboard')
<style>
    #consultationModal {
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

<div class="p-6 flex-1">

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <!-- Confirmed -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Confirmed Consultations</p>
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending Consultations</p>
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Consultations</p>
                    <p class="text-4xl font-bold text-gray-800 dark:text-white mt-2">{{ $total }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-stethoscope text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================ -->
    <!--       UPCOMING CONSULTATIONS    -->
    <!-- ================================ -->

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-10">

        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Upcoming Consultations
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">(Next 3 Days)</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            @if($upcoming->isEmpty())
                <div class="p-16 text-center">
                    <i class="fas fa-calendar-times text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">No upcoming consultations</p>
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
                            @include('consultation_list_row')
                        @endforeach

                    </tbody>
                </table>

            @endif
        </div>

    </div>

    <!-- ================================ -->
    <!--         ALL CONSULTATIONS        -->
    <!-- ================================ -->

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        All Consultations
                    </h2>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            @if($allConsultations->isEmpty())
                <div class="p-16 text-center">
                    <i class="fas fa-folder-open text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">No consultation records found</p>
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

                        @foreach($allConsultations as $app)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                            <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ $app->appointment_code }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                        {{ substr($app->user->full_name ?? $app->relative->name ?? 'NA', 0, 2) }}
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $app->user->full_name ?? $app->relative->name ?? 'Unknown' }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            {{ $app->for_user_type === 'self' ? 'Self' : 'Relative' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $app->issue ? \Illuminate\Support\Str::limit($app->issue, 30) : '—' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($app->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($app->status == 'Confirmed') bg-green-100 text-green-800
                                    @elseif($app->status == 'Cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $app->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button onclick='showConsultationDetails(@json($app))'
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


<!-- Modal -->
<div id="consultationModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative">

        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Consultation Details</h2>
            <button onclick="closeConsultationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl">&times;</button>
        </div>

        <div class="px-6 py-4 space-y-3" id="consultationDetails"></div>

        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <button onclick="closeConsultationModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-medium px-4 py-2 rounded-lg">Close</button>
            <form id="acceptConsultationForm" method="POST" style="display: none;">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg">Accept</button>
            </form>
            <form id="rejectConsultationForm" method="POST" style="display: none;">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg">Reject</button>
            </form>
        </div>

    </div>
</div>

<script>
function showConsultationDetails(app) {
    const modal = document.getElementById('consultationModal');
    const detailsDiv = document.getElementById('consultationDetails');

    const bookedBy = app.for_user_type === 'self'
        ? `<strong>Booked By:</strong> ${app.user?.full_name ?? 'User'} (Self)`
        : `<strong>Booked For:</strong> ${app.relative?.name ?? 'Relative'} (${app.relative?.relation ?? '-'})`;

    detailsDiv.innerHTML = `
        <div class="space-y-2 text-gray-700 dark:text-gray-300">
            <p><strong>Consultation Code:</strong> ${app.appointment_code}</p>
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

    // Set form actions and visibility for accept/reject based on status
    const acceptForm = document.getElementById('acceptConsultationForm');
    const rejectForm = document.getElementById('rejectConsultationForm');

    if (app.status === 'Pending') {
        acceptForm.style.display = 'inline-block';
        rejectForm.style.display = 'inline-block';

        acceptForm.action = `/employee/appointments/${app.appointment_id}/accept`;
        rejectForm.action = `/employee/appointments/${app.appointment_id}/reject`;
    } else {
        acceptForm.style.display = 'none';
        rejectForm.style.display = 'none';
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeConsultationModal() {
    const modal = document.getElementById('consultationModal');
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
