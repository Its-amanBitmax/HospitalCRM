@extends('layouts.doctor-dashboard')

@section('content')
<div id="visits-content" class="tab-content">

    <!-- PAGE HEADER -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-injured text-2xl text-blue-600 dark:text-blue-400"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Patient Visits</h2>
        </div>
    </div>

    <!-- FILTERS FORM -->
    <div class="bg-white shadow-lg rounded-xl p-5 mb-6 border border-gray-200">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Filters</h3>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Patient Name -->
            <div>
                <label class="text-sm font-medium text-gray-600 mb-1 block">Patient Name</label>
                <input type="text" name="patient_name" value="{{ request('patient_name') }}"
                       placeholder="Enter name..."
                       class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 bg-white text-black">
            </div>

            <!-- Visit Type -->
            <div>
                <label class="text-sm font-medium text-gray-600 mb-1 block">Visit Type</label>
                <select name="visit_type"
                        class="w-full px-4 py-2 border rounded-lg bg-white text-black focus:ring focus:ring-blue-300">
                    <option value="">All Visits</option>
                    <option value="OPD" {{ request('visit_type')=='OPD'?'selected':'' }}>OPD</option>
                    <option value="Emergency" {{ request('visit_type')=='Emergency'?'selected':'' }}>Emergency</option>
                    <option value="Checkup" {{ request('visit_type')=='Checkup'?'selected':'' }}>Checkup</option>
                </select>
            </div>

            <!-- Visit Date -->
            <div>
                <label class="text-sm font-medium text-gray-600 mb-1 block">Visit Date</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full px-4 py-2 border rounded-lg bg-white text-black focus:ring focus:ring-blue-300">
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Filter
                </button>
                <a href="{{ route('employee.doctor_patients') }}"
                   class="w-full px-4 py-2 text-center  text-white rounded-lg hover:bg-gray-700 transition" style="background-color: gray;">
                    Reset
                </a>
            </div>

        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">

        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">SR No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Patient Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Room</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Reception</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Visit Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Chief Complaint</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($patients as $index => $visit)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $visit->user->full_name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $visit->consultantAssignment?->room?->room_id ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $visit->reception?->reception_id ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $visit->visit_type ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $visit->chief_complaint ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $visit->date_of_visit?->format('Y-m-d') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium space-x-3">
                        <a href="{{ route('employee.users.checkups', $visit->user->id) }}"
                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-6 text-center text-gray-500">No visits found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>
@endsection
