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

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Confirmed</p>
            <p class="text-4xl font-bold mt-2">{{ $confirmed }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Cancelled</p>
            <p class="text-4xl font-bold mt-2">{{ $cancelled }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-6">
            <p class="text-sm text-gray-500">Total Consultations</p>
            <p class="text-4xl font-bold mt-2">{{ $total }}</p>
        </div>

    </div>


    <!-- UPCOMING CONSULTATIONS -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden mb-10">

        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-lg font-semibold">Upcoming Consultations (Next 3 Days)</h2>
        </div>

        <div class="overflow-x-auto">
            @if($upcoming->isEmpty())
                <div class="p-16 text-center text-gray-500">
                    No upcoming consultations
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Code</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Time</th>
                            <th class="px-6 py-3 text-left">Doctor</th>
                            <th class="px-6 py-3 text-left">Patient</th>
                            <th class="px-6 py-3 text-left">Subtype</th>
                            <th class="px-6 py-3 text-left">Issue</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @foreach($upcoming as $app)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-3 font-semibold">{{ $app->appointment_code }}</td>

                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}</td>

                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}</td>

                            <td class="px-6 py-3">
                                {{ $app->doctor->name ?? 'Dr. Unknown' }}<br>
                                <span class="text-xs text-gray-400">{{ $app->doctor->specialty ?? 'General' }}</span>
                            </td>

                            <td class="px-6 py-3">
                                @if($app->for_user_type === 'self')
                                    {{ $app->user->name ?? 'User' }} <span class="text-xs text-gray-400">(Self)</span>
                                @else
                                    {{ $app->relative->name ?? 'Relative' }}
                                    <span class="text-xs text-gray-400">({{ $app->relative->relation ?? '-' }})</span>
                                @endif
                            </td>

                            <td class="px-6 py-3">{{ $app->subtype ?? '—' }}</td>

                            <td class="px-6 py-3">{{ Str::limit($app->issue, 30) }}</td>

                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full border text-xs">
                                    {{ $app->status }}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-center">
                                <button onclick='showAppointmentDetails(@json($app))'
                                    class="text-purple-600 font-medium text-sm">
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



    <!-- ALL CONSULTATIONS -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden">

        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-lg font-semibold">All Video Consultations</h2>
        </div>

        <div class="overflow-x-auto">
            @if($consultations->isEmpty())
                <div class="p-16 text-center text-gray-500">
                    No consultations found
                </div>
            @else

            <table class="w-full">
                <thead class="bg-gray-50 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-left">Time</th>
                        <th class="px-6 py-3 text-left">Doctor</th>
                        <th class="px-6 py-3 text-left">Patient</th>
                        <th class="px-6 py-3 text-left">Subtype</th>
                        <th class="px-6 py-3 text-left">Issue</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach($consultations as $app)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-3 font-semibold">{{ $app->appointment_code }}</td>

                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}</td>

                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($app->appointment_time)->format('h:i A') }}</td>

                        <td class="px-6 py-3">
                            {{ $app->doctor->name ?? 'Dr. Unknown' }}<br>
                            <span class="text-xs text-gray-400">{{ $app->doctor->specialty ?? 'General' }}</span>
                        </td>

                        <td class="px-6 py-3">
                            @if($app->for_user_type === 'self')
                                {{ $app->user->name ?? 'User' }} <span class="text-xs text-gray-400">(Self)</span>
                            @else
                                {{ $app->relative->name ?? 'Relative' }}
                                <span class="text-xs text-gray-400">({{ $app->relative->relation ?? '-' }})</span>
                            @endif
                        </td>

                        <td class="px-6 py-3">{{ $app->subtype ?? '—' }}</td>

                        <td class="px-6 py-3">{{ Str::limit($app->issue, 30) }}</td>

                        <td class="px-6 py-3">
                            <span class="px-3 py-1 border rounded-full text-xs">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td class="px-6 py-3 text-center">
                            <button onclick='showAppointmentDetails(@json($app))'
                                class="text-purple-600 font-medium text-sm">
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


<!-- MODAL -->
<div id="appointmentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg shadow-xl mx-4 relative">

        <div class="flex justify-between items-center px-6 py-3 border-b">
            <h2 class="text-lg font-semibold">Consultation Details</h2>
            <button onclick="closeModal()" class="text-gray-500 text-2xl">&times;</button>
        </div>

        <div id="appointmentDetails" class="px-6 py-4 space-y-2"></div>

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


<!-- SCRIPT -->
<script>

function showAppointmentDetails(app) {

    const modal = document.getElementById("appointmentModal");
    const details = document.getElementById("appointmentDetails");

    const bookedBy =
        app.for_user_type === "self"
        ? `${app.user?.name ?? "User"} (Self)`
        : `${app.relative?.name ?? "Relative"} (${app.relative?.relation ?? "-"})`;

    details.innerHTML = `
        <p><strong>Code:</strong> ${app.appointment_code}</p>
        <p><strong>Patient:</strong> ${bookedBy}</p>
        <p><strong>Doctor:</strong> ${app.doctor?.name ?? "N/A"}</p>
        <p><strong>Date:</strong> ${app.appointment_date}</p>
        <p><strong>Time:</strong> ${formatTime(app.appointment_time)}</p>
        <p><strong>Subtype:</strong> ${app.subtype ?? "—"}</p>
        <p><strong>Issue:</strong> ${app.issue ?? "—"}</p>
        <p><strong>Description:</strong> ${app.description ?? "—"}</p>
        <p><strong>Status:</strong> ${app.status}</p>
    `;

    // Set form actions
    document.getElementById("acceptForm").action =
        `/admin/appointments/${app.appointment_id}/accept`;

    document.getElementById("rejectForm").action =
        `/admin/appointments/${app.appointment_id}/reject`;

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
    document.getElementById("appointmentModal").classList.add("hidden");
}

function formatTime(t) {
    const [h, m] = t.split(":");
    let hour = parseInt(h);
    const ampm = hour >= 12 ? "PM" : "AM";
    hour = hour % 12 || 12;
    return `${hour}:${m} ${ampm}`;
}

</script>

@endsection