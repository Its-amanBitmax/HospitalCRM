@extends('layouts.layout')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">

    <!-- Header -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
            Video Consultations
        </h1>
        <a href="{{ route('admin.appointments') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
           <i class="fa fa-arrow-left mr-2"></i>Back to Appointments
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cancelled</p>
                    <p class="text-4xl font-bold text-gray-800 dark:text-white mt-2">{{ $cancelled }}</p>
                </div>
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-2xl text-red-600 dark:text-red-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Consultations</p>
                    <p class="text-4xl font-bold text-gray-800 dark:text-white mt-2">{{ $total }}</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-video text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Consultations -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center">
                    <i class="fas fa-video text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Upcoming Video Consultations
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">(Next 3 Days)</p>
                </div>
            </div>
        </div>

        <!-- Table -->
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
                            <th class="px-6 py-3 text-left">Doctor</th>
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
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $app->doctor->name ?? 'Dr. Unknown' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $app->doctor->specialty ?? 'General' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($app->for_user_type === 'self')
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $app->user->name ?? 'User' }}</p>
                                        <p class="text-xs text-gray-500">Self</p>
                                    @else
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-medium">{{ $app->relative->name ?? 'Relative' }}</p>
                                        <p class="text-xs text-gray-500">{{ $app->relative->relation ?? '' }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $app->issue ? Str::limit($app->issue, 30) : '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($app->status == 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif($app->status == 'Confirmed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($app->status == 'Cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @endif
                                        border border-dashed">
                                        <i class="fas fa-circle text-[8px] mr-1"></i>
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center space-x-3">
                                    <button onclick='showAppointmentDetails(@json($app))'
                                        class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 text-sm font-medium">
                                        <i class="fa fa-eye mr-1"></i> View
                                    </button>
                                    <form action="{{ route('admin.appointments.destroy', $app->appointment_id) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this consultation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                            <i class="fa fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
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
<div id="appointmentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Consultation Details</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xl">&times;</button>
        </div>

        <div class="px-6 py-4 space-y-3" id="appointmentDetails"></div>

        <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <form id="acceptForm" method="POST" class="hidden">
                @csrf @method('PUT')
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg">Accept</button>
            </form>
            <form id="rejectForm" method="POST" class="hidden">
                @csrf @method('PUT')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg">Reject</button>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script>
function showAppointmentDetails(app) {
    const modal = document.getElementById('appointmentModal');
    const detailsDiv = document.getElementById('appointmentDetails');

    const bookedBy = app.for_user_type === 'self'
        ? `<strong>Booked By:</strong> ${app.user?.name ?? 'User'} (Self)`
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
            <p><strong>Status:</strong> <span class="font-semibold ${getStatusClass(app.status)}">${app.status}</span></p>
        </div>
    `;

    const acceptForm = document.getElementById('acceptForm');
    const rejectForm = document.getElementById('rejectForm');
    acceptForm.action = `/admin/appointments/${app.appointment_id}/accept`;
    rejectForm.action = `/admin/appointments/${app.appointment_id}/reject`;

    if (app.status === 'Pending') {
        acceptForm.classList.remove('hidden');
        rejectForm.classList.remove('hidden');
    } else {
        acceptForm.classList.add('hidden');
        rejectForm.classList.add('hidden');
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    document.getElementById('appointmentModal').classList.add('hidden');
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
