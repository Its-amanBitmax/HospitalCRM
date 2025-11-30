@extends('layouts.receptionist')

@section('content')
<div class="p-6 min-h-screen bg-gray-100">

    <!-- Heading Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Appointments</h1>
    </div>

    <!-- Summary Cards -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Pending</h2>
                    <p class="text-2xl font-bold">{{ $appointments->where('status', 'pending')->count() }}</p>
                </div>
                <i class="fas fa-hourglass-half text-3xl"></i>
            </div>

            <div class="bg-green-100 text-green-800 rounded-lg p-4 shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Confirmed</h2>
                    <p class="text-2xl font-bold">{{ $appointments->where('status', 'confirmed')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl"></i>
            </div>

            <div class="bg-red-100 text-red-800 rounded-lg p-4 shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Cancelled / Booked</h2>
                    <p class="text-2xl font-bold">{{ $appointments->whereIn('status', ['cancelled', 'booked'])->count() }}</p>
                </div>
                <i class="fas fa-times-circle text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Appointments Table Card -->
    <div class="bg-white rounded-lg shadow p-6">
        @if($appointments->isEmpty())
            <div class="p-4 rounded-lg shadow text-gray-500">
                No appointments found.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="{{ $appointment->doctor && $appointment->doctor->image 
                                             ? asset('storage/'.$appointment->doctor->image) 
                                             : asset('image/default.png') }}"
                                     alt="Doctor Image"
                                     class="w-10 h-10 rounded-full object-cover border">
                                <span>{{ $appointment->doctor->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</td>
                            <td class="px-6 py-4">{{ $appointment->type }}</td>
                            <td class="px-6 py-4 capitalize">{{ $appointment->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
