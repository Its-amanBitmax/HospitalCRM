@extends('layouts.receptionist')

@section('content')
<div class="min-h-screen">
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-lg mb-8 border border-gray-200">
        <div class="flex items-center gap-4">
            <i class="fas fa-calendar-alt text-3xl text-blue-600"></i>
            <h1 class="text-2xl font-bold text-gray-800">Patient Visits - {{ $user->full_name }}</h1>
        </div>
        <div class="flex gap-4">
            <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-900 px-5 py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Visits Table -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Patient Visits</h2>
            <a href="{{ route('visits.create', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg flex items-center gap-2 transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus"></i> Add Visit
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <i class="fas fa-stethoscope mr-2"></i>Visit Type
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2"></i>Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <i class="fas fa-notes-medical mr-2"></i>Chief Complaint
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <i class="fas fa-user-md mr-2"></i>Referred By
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <i class="fas fa-building mr-2"></i>Department/Consultant
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <i class="fas fa-cogs mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($visits as $visit)
                    <tr class="hover:bg-gray-50 transition duration-150 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visit->visit_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visit->date_of_visit?->format('d-m-Y') ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">{{ $visit->chief_complaint ?: '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $visit->reception?->reception_id ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-xs">
                            <span class="block truncate">
                                {{ $visit->consultantAssignment?->room?->room_id ?? '-' }} —
                                {{ $visit->consultantAssignment?->employee?->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-3">
                            <a href="{{ route('visits.edit', [$user->id, $visit->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg flex items-center gap-1 transition duration-200">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('visits.delete', [$user->id, $visit->id]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this visit?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg flex items-center gap-1 transition duration-200">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>No visits found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
