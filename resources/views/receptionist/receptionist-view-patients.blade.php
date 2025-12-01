@extends('layouts.receptionist')

@section('content')
<div class="p-6 min-h-screen bg-gray-100">

    <!-- Header -->
  <div class="bg-white shadow rounded-lg p-5 mb-6 flex justify-between items-center">
    <div class="flex items-center gap-3">

        <!-- User Icon Using <i> Tag -->
        <i class="fa fa-user text-blue-700 text-3xl"></i>

        <div>
            <h1 class="text-2xl font-bold text-blue-800">Patient Details</h1>
            <p class="text-gray-500 text-sm">Viewing complete profile, visit history, and appointments.</p>
        </div>
    </div>

    <a href="{{ url()->previous() }}"
        class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition">
        ← Back
    </a>
</div>


    <!-- Patient Info -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Basic Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Full Name:</strong> {{ $user->full_name }}</div>
            <div><strong>Mobile No:</strong> {{ $user->mobile_no }}</div>
            <div><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</div>
            <div><strong>Age:</strong> {{ $user->age ?? 'N/A' }}</div>
            <div><strong>Gender:</strong> {{ ucfirst($user->gender) ?? 'N/A' }}</div>
            <div><strong>Blood Group:</strong> {{ $user->blood_group ?? 'N/A' }}</div>
            <div><strong>City:</strong> {{ $user->city ?? 'N/A' }}</div>
            <div><strong>State:</strong> {{ $user->state ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Visit History -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Visit History</h2>

        @if($visits->isEmpty())
        <p class="text-gray-500">No visits recorded for this patient.</p>
        @else
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-left text-sm">
                    <th class="px-4 py-2">Date of Visit</th>
                    <th class="px-4 py-2">Visit Type</th>
                    <th class="px-4 py-2">Department / Room</th>
                    <th class="px-4 py-2">Consultant</th>
                    <th class="px-4 py-2">Chief Complaint</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visits as $visit)
                <tr class="border-b">
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($visit->date_of_visit)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-2">{{ $visit->visit_type ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $visit->consultantAssignment->room->room_id ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $visit->consultantAssignment->employee->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $visit->chief_complaint ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Appointments -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Appointments</h2>

        @if($appointments->isEmpty())
        <p class="text-gray-500">No appointments scheduled for this patient.</p>
        @else
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-left text-sm">
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Time</th>
                    <th class="px-4 py-2">Doctor</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Issue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $appointment->appointment_date }}</td>
                    <td class="px-4 py-2">{{ $appointment->appointment_time }}</td>
                    <td class="px-4 py-2">{{ $appointment->doctor->full_name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ ucfirst($appointment->type) ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $appointment->issue ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection