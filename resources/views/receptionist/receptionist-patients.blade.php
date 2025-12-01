@extends('layouts.receptionist')

@section('content')
<div class="p-6 min-h-screen bg-gray-100">

<!-- Header Card -->
<div class="bg-white shadow rounded-lg p-5 mb-6 flex justify-between items-center">
    
    <!-- Heading -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Patients List</h1>
        <p class="text-gray-500 text-sm">All registered patients are listed below.</p>
    </div>

    <!-- Buttons -->
    <div class="flex gap-3">
        <!-- Register Patient -->
        <a href="{{ route('patients.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
            <i class="fas fa-user-plus mr-2"></i> Register Patient
        </a>

        <!-- All Patients -->
        <a href="{{ route('patients.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           + Add Patients
        </a>
    </div>

</div>



    <!-- Type-wise Count Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        @foreach($typeCounts as $type => $count)
        <div class="bg-white shadow rounded-lg p-5">
            <h2 class="text-gray-500 text-sm">{{ ucfirst($type) }} Patients</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $count }}</p>
        </div>
        @endforeach
    </div>

    <!-- Patients Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-200 text-gray-700 text-left text-sm">
                    <th class="px-4 py-3">User ID</th>
                    <th class="px-4 py-3">Username</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $patient->user_id ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $patient->username ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $patient->email ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $patient->mobile_no ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ ucfirst($patient->type ?? 'N/A') }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('visits.show', $patient->id) }}" class="text-blue-600 hover:text-blue-800">view</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">No patients found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
