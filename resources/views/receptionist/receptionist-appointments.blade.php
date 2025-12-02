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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img src="{{ $appointment->doctor && $appointment->doctor->image
             ? Storage::url($appointment->doctor->image)
             : asset('image/default.png') }}"
                                        alt="Doctor Image"
                                        class="h-10 w-10 rounded-full object-cover border-2 border-gray-200">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $appointment->doctor->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">Doctor</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</div>
                            <div class="text-xs text-gray-500">to {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900 font-medium">{{ $appointment->type }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $status = $appointment->status;
                            $statusColor = 'bg-gray-100 text-gray-800';
                            if($status == 'pending') $statusColor = 'bg-yellow-100 text-yellow-800';
                            elseif($status == 'confirmed') $statusColor = 'bg-green-100 text-green-800';
                            elseif($status == 'cancelled') $statusColor = 'bg-red-100 text-red-800';
                            elseif($status == 'booked') $statusColor = 'bg-blue-100 text-blue-800';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection