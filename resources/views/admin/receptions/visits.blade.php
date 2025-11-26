@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-calendar-alt text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Patient Visits - {{ $user->full_name }}</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ url()->previous() }}" class="bg-gray-200 hover:bg-gray-300 text-gray-900 px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Visits Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Patient Visits</h2>
            <a href="{{ route('admin.users.visits.create', $user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-plus"></i> Add Visit
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Visit Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Chief Complaint</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Referred By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department/Consultant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($visits as $visit)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->visit_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->date_of_visit?->format('d-m-Y') ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $visit->chief_complaint ?: '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->referred_by ?: '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $visit->department_consultant ?: '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                            <a href="{{ route('admin.users.visits.edit', [$user->id, $visit->id]) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.users.visits.destroy', [$user->id, $visit->id]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this visit?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No visits found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection