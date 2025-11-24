@extends('layouts.layout')

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

<div class="p-6 flex-1">

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border p-6">
            <p class="text-sm text-gray-500">Confirmed</p>
            <p class="text-4xl font-bold mt-2">{{ $confirmed }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border p-6">
            <p class="text-sm text-gray-500">Cancelled</p>
            <p class="text-4xl font-bold mt-2">{{ $cancelled }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border p-6">
            <p class="text-sm text-gray-500">Total Today</p>
            <p class="text-4xl font-bold mt-2">{{ $total }}</p>
        </div>

    </div>


    <!-- UPCOMING APPOINTMENTS -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border overflow-hidden mb-12">

        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-lg font-semibold">Upcoming Appointments (Next 3 Days)</h2>
        </div>

        <div class="overflow-x-auto">

            @if($upcoming->isEmpty())
                <div class="p-16 text-center text-gray-500">
                    No upcoming appointments.
                </div>
            @else

            <table class="w-full">
                <thead class="bg-gray-50 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Time</th>
                        <th class="px-6 py-3 text-left">Doctor</th>
                        <th class="px-6 py-3 text-left">Issue</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($upcoming as $app)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-3 font-semibold">{{ $app->appointment_code }}</td>

                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}
                        </td>

                        <td class="px-6 py-3">
                            {{ $app->doctor->name ?? 'Dr. Unknown' }}
                        </td>

                        <td class="px-6 py-3">
                            {{ Str::limit($app->issue, 30) }}
                        </td>

                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs border">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td class="px-6 py-3 text-center space-x-2">

                            <button onclick='showAppointmentDetails(@json($app))'
                                class="text-blue-600 font-medium text-sm">
                                <i class="fa fa-eye mr-1"></i> View
                            </button>

                            <form action="{{ route('admin.appointments.destroy', $app->appointment_id) }}"
                                method="POST" class="inline"
                                onsubmit="return confirm('Delete this appointment?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 text-sm">
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



    <!-- OFFLINE APPOINTMENTS -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow border overflow-hidden">

        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-lg font-semibold">All Offline Appointments</h2>
        </div>

        <div class="overflow-x-auto">

            @if($offline->isEmpty())
                <div class="p-16 text-center text-gray-500">
                    No offline appointments found.
                </div>
            @else

            <table class="w-full">
                <thead class="bg-gray-50 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Time</th>
                        <th class="px-6 py-3 text-left">Doctor</th>
                        <th class="px-6 py-3 text-left">Issue</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($offline as $app)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-3 font-semibold">{{ $app->appointment_code }}</td>

                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}
                        </td>

                        <td class="px-6 py-3">
                            {{ $app->doctor->name ?? 'Dr. Unknown' }}
                        </td>

                        <td class="px-6 py-3">
                            {{ Str::limit($app->issue, 30) }}
                        </td>

                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs border">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td class="px-6 py-3 text-center space-x-2">

                            <button onclick='showAppointmentDetails(@json($app))'
                                class="text-blue-600 font-medium text-sm">
                                <i class="fa fa-eye mr-1"></i> View
                            </button>

                            <form action="{{ route('admin.appointments.destroy', $app->appointment_id) }}"
                                method="POST" class="inline"
                                onsubmit="return confirm('Delete this appointment?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 text-sm">
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


<!-- ========================= -->
<!--  APPOINTMENT DETAILS MODAL -->
<!-- ========================= -->

<div id="appointmentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative">

        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Appointment Details</h2>
            <button onclick="closeModal()" class="text-gray-500 text-2xl">&times;</button>
        </div>

        <div class="px-6 py-4 space-y-3" id="appointmentDetails"></div>

        <div class="px-6 py-4 border-t flex justify-end gap-3">

            <form id="acceptForm" method="POST" class="hidden">
                @csrf @method('PUT')
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg">Accept</button>
            </form>

            <form id="rejectForm" method="POST" class="hidden">
                @csrf @method('PUT')
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg">Reject</button>
            </form>

        </div>

    </div>

</div>


<!-- ========================= -->
<!--       JAVASCRIPT         -->
<!-- ========================= -->

<script>

function showAppointmentDetails(app) {

    const modal = document.getElementById("appointmentModal");
    const detailsDiv = document.getElementById("appointmentDetails");

    const bookedBy = 
        app.for_user_type === 'self'
        ? `<strong>Booked By:</strong> ${app.user?.name ?? 'User'}`
        : `<strong>Booked For:</strong> ${app.relative?.name ?? 'Relative'} (${app.relative?.relation ?? '-'})`;

    detailsDiv.innerHTML = `
        <p><strong>Code:</strong> ${app.appointment_code}</p>
        <p>${bookedBy}</p>
        <p><strong>Doctor:</strong> ${app.doctor?.name ?? 'N/A'}</p>
        <p><strong>Date:</strong> ${app.appointment_date}</p>
        <p><strong>Time:</strong> ${formatTime(app.appointment_time)}</p>
        <p><strong>Issue:</strong> ${app.issue ?? '—'}</p>
        <p><strong>Description:</strong> ${app.description ?? '—'}</p>
        <p><strong>Status:</strong> ${app.status}</p>
    `;

    document.getElementById("acceptForm").action = `/admin/appointments/${app.appointment_id}/accept`;
    document.getElementById("rejectForm").action = `/admin/appointments/${app.appointment_id}/reject`;

    if (app.status === "Pending") {
        acceptForm.classList.remove("hidden");
        rejectForm.classList.remove("hidden");
    } else {
        acceptForm.classList.add("hidden");
        rejectForm.classList.add("hidden");
    }

    modal.classList.remove("hidden");
    modal.classList.add("flex");
}

function closeModal() {
    const modal = document.getElementById("appointmentModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}

function formatTime(timeStr) {
    const [hour, minute] = timeStr.split(":");
    let h = parseInt(hour);
    const suffix = h >= 12 ? "PM" : "AM";
    h = h % 12 || 12;
    return `${h}:${minute} ${suffix}`;
}

</script>

@endsection