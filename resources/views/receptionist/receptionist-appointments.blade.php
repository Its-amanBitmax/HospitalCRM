@extends('layouts.receptionist')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">

    <!-- Heading Card -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 shadow-2xl rounded-2xl p-6 mb-8 flex items-center space-x-4">
        <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
            <i class="fas fa-calendar-alt text-white text-3xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-white">Appointments</h1>
            <p class="text-blue-100">Manage and view all appointment details</p>
        </div>
    </div>


    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Pending Appointments -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-amber-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-yellow-50 p-3 rounded-xl">
                        <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Pending Appointments</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $appointments->where('status', 'Pending')->count() }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-clock mr-1 text-yellow-500"></i>
                    <span>Awaiting confirmation</span>
                </div>
            </div>
        </div>

        <!-- Confirmed Appointments -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-50 p-3 rounded-xl">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-800">Confirmed</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Confirmed Appointments</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $appointments->where('status', 'Confirmed')->count() }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-calendar-check mr-1 text-green-500"></i>
                    <span>Ready to proceed</span>
                </div>
            </div>
        </div>

        <!-- Cancelled/Booked Appointments -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-rose-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-red-50 p-3 rounded-xl">
                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-100 text-red-800">Completed</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Cancelled / Booked</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $appointments->where('status', 'Cancelled')->count() }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-archive mr-1 text-red-500"></i>
                    <span>Finalized appointments</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200">
            <div class="flex items-center justify-between p-5">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-50 p-2 rounded-lg">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">All Appointments</h2>
                </div>
                <span class="text-sm text-gray-500">{{ $appointments->count() }} total appointments</span>
            </div>
        </div>
        @if($appointments->isEmpty())
        <div class="p-12 text-center">
            <div class="flex flex-col items-center justify-center text-gray-400">
                <i class="fas fa-calendar-times text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Appointments Found</h3>
                <p class="text-sm">There are currently no appointments scheduled.</p>
            </div>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Issue</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-semibold">{{ $appointment->appointment_code }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if(str_contains($appointment->appointment_time, '-'))
                                {{ $appointment->appointment_time }}
                            @else
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $appointment->doctor->name ?? 'Dr. Unknown' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($appointment->for_user_type === 'self')
                                {{ $appointment->user->full_name ?? 'N/A' }}
                            @else
                                {{ $appointment->relative->name ?? 'N/A' }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ Str::limit($appointment->issue, 30) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs border">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick='showAppointmentDetails(@json($appointment))'
                                class="text-blue-600 font-medium text-sm">
                                <i class="fa fa-eye mr-1"></i> View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

<!-- ========================= -->
<!--  APPOINTMENT DETAILS MODAL -->
<!-- ========================= -->

<div id="appointmentModal" class="fixed inset-0 bg-white/50 hidden items-center justify-center z-50">

    <div class="bg-white bg-white-800 rounded-2xl shadow-xl w-full max-w-lg mx-4 relative">

        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Appointment Details</h2>
            <button onclick="closeModal()" class="text-gray-500 text-2xl">&times;</button>
        </div>

        <div class="px-6 py-4 space-y-3" id="appointmentDetails"></div>

    </div>

</div>

<!-- ========================= -->
<!--       JAVASCRIPT         -->
<!-- ========================= -->

<script>

function showAppointmentDetails(app) {

    const modal = document.getElementById("appointmentModal");
    const detailsDiv = document.getElementById("appointmentDetails");

    let bookedByHtml = '';
    if (app.for_user_type === 'self') {
        const imageSrc = app.user?.image ? `/${app.user.image}` : '/image/default.png';
        bookedByHtml = `
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex items-center gap-3 mb-3">
                    <img src="${imageSrc}" alt="User Image" class="w-12 h-12 rounded-full object-cover border-2 border-gray-300">
                    <div>
                        <h3 class="font-semibold text-lg">${app.user?.full_name ?? 'User'}</h3>
                        <p class="text-sm text-gray-600">Booked By (Self)</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <p><strong>Age:</strong> ${app.user?.age ?? 'N/A'}</p>
                    <p><strong>Gender:</strong> ${app.user?.gender ?? 'N/A'}</p>
                    <p><strong>Mobile:</strong> ${app.user?.mobile_no ?? 'N/A'}</p>
                    <p><strong>Email:</strong> ${app.user?.email ?? 'N/A'}</p>
                    <p><strong>Blood Group:</strong> ${app.user?.blood_group ?? 'N/A'}</p>
                    <p><strong>Address:</strong> ${app.user?.full_address ?? 'N/A'}</p>
                </div>
            </div>
        `;
    } else {
        const imageSrc = app.relative?.image ? `/${app.relative.image}` : '/image/default.png';
        bookedByHtml = `
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex items-center gap-3 mb-3">
                    <img src="${imageSrc}" alt="Relative Image" class="w-12 h-12 rounded-full object-cover border-2 border-gray-300">
                    <div>
                        <h3 class="font-semibold text-lg">${app.relative?.name ?? 'Relative'}</h3>
                        <p class="text-sm text-gray-600">Booked For (${app.relative?.relation ?? '-'})</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <p><strong>Age:</strong> ${app.relative?.age ?? 'N/A'}</p>
                    <p><strong>Gender:</strong> ${app.relative?.gender ?? 'N/A'}</p>
                    <p><strong>Blood Group:</strong> ${app.relative?.blood_group ?? 'N/A'}</p>
                </div>
            </div>
        `;
    }

    detailsDiv.innerHTML = `
        <div class="space-y-4">
            <div class="bg-blue-50 p-3 rounded-lg">
                <p class="text-lg font-semibold text-blue-800"><strong>Appointment Code:</strong> ${app.appointment_code}</p>
            </div>
            ${bookedByHtml}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 p-3 rounded-lg">
                    <p><strong class="text-green-800">Doctor:</strong> ${app.doctor?.name ?? 'N/A'}</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <p><strong class="text-yellow-800">Date:</strong> ${app.appointment_date}</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <p><strong class="text-purple-800">Time:</strong> ${formatTime(app.appointment_time)}</p>
                </div>
                <div class="bg-red-50 p-3 rounded-lg">
                    <p><strong class="text-red-800">Status:</strong> ${app.status}</p>
                </div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p><strong>Issue:</strong> ${app.issue ?? '—'}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <p><strong>Description:</strong> ${app.description ?? '—'}</p>
            </div>
        </div>
    `;

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