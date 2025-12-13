@extends('layouts.nursionist')
@section('title', 'Today Appointments')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Today Confirmed Appointments</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Patient</th>
                <th class="px-4 py-2">Doctor</th>
                <th class="px-4 py-2">Time</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        {{ $appointment->user->full_name ?? '-' }}
                    </td>   
                    <td class="px-4 py-2">
                        {{ $appointment->doctor->name ?? '-' }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $appointment->appointment_time }}
                    </td>
                    <td class="px-4 py-2">
                        <span class="text-green-600 font-semibold">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">
                        No confirmed appointments today
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
