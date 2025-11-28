@extends('layouts.doctor-dashboard')

@section('content')
<!-- Visits Tab -->
<div id="visits-content" class="tab-content ">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 text-white">Patient Visits</h2>
    </div>

    <!-- 🔍 FILTER SECTION -->
    <form method="GET" action="{{ route('employee.doctor_patients') }}" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Patient Name -->
            <input type="text" name="patient_name" value="{{ request('patient_name') }}"
                placeholder="Search Patient Name"
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 bg-white-700 text-white">

            <!-- Visit Type -->
            <select name="visit_type"
                class="w-full px-4 py-2 border rounded-lg bg-white-700 text-white">
                <option value="">All Visit Types</option>
                <option value="OPD" {{ request('visit_type')=='OPD'?'selected':'' }}>OPD</option>
                <option value="Emergency" {{ request('visit_type')=='Emergency'?'selected':'' }}>Emergency</option>
            </select>

            <!-- Date -->
            <input type="date" name="date" value="{{ request('date') }}"
                class="w-full px-4 py-2 border rounded-lg bg-white-700 text-white">

            <!-- Submit -->
            <button
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>

        </div>
    </form>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white bg-white-800 border border-gray-200 border-gray-700">
            <thead class="bg-white-50 bg-white-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Patient Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Room</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Reception</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Visit Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Chief Complaint</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Date of Visit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white bg-white-800 divide-y divide-gray-200 divide-gray-700">
                @forelse($patients as $visit)
                <tr class="hover:[background-color:#daf6f6] hover:bg-white-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->user->full_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->consultantAssignment?->room?->room_id ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->reception?->reception_id ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $visit->visit_type ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 text-white">{{ $visit->chief_complaint ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">
                        {{ $visit->date_of_visit?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                        <!-- Actions (optional) -->
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 text-gray-400">No visits found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
