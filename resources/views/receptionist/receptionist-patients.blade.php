@extends('layouts.receptionist')

@section('content')
<div class=" md:p-6 min-h-screen" style="">

    <!-- Header Card -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

        <!-- Heading -->
        <div>
            <div class="flex items-center gap-3 mb-1">
                <i class="fa fa-users text-blue-700 text-3xl"></i>
                <h1 class="text-3xl font-bold text-blue-800">Patients</h1>
            </div>

            <p class="text-gray-600 text-sm">Manage and view all registered patients below.</p>
        </div>


        <!-- Buttons -->
        <div class="flex flex-wrap gap-3">
            <!-- Register Patient -->
            <a href="{{ route('admin.patient-registration') }}"
                class="bg-green-600 text-white px-5 py-3 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg transition-all duration-200 flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Register Patient
            </a>

            <!-- All Patients -->
            <a href="{{ route('patients.create') }}"
                class="bg-blue-600 text-white px-5 py-3 rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Patient
            </a>
        </div>

    </div>

    <!-- Type-wise Count Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($typeCounts as $type => $count)
        <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-gray-600 text-sm font-medium uppercase tracking-wide">{{ ucfirst($type) }} Patients</h2>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $count }}</p>
                </div>
                <div class="text-blue-500">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('receptionist.patients') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Username, Email, or Phone..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
            <div class="flex-shrink-0">
                <select name="type" class="px-4 py-3 border border-gray-300  rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" style="width: 300px;">
                    <option value="">All Types</option>
                    @foreach($typeCounts as $type => $count)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-search "></i>
            </button>
            <a href="{{ route('receptionist.patients') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200 flex items-center justify-center">
                <i class="fas fa-times"></i>
            </a>
        </form>
    </div>

    <!-- Patients Table -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $patient->user_id ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->username ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $patient->mobile_no ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $patient->image ? asset($patient->image) : asset('image/default.png') }}"
                                class="w-12 h-12 rounded-full object-cover border">
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($patient->type == 'opd') bg-green-100 text-green-800
                                @elseif($patient->type == 'ipd') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($patient->type ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium space-x-3 flex items-center">

                            <!-- Visit History -->
                            <a href="{{ route('visits.show', $patient->id) }}"
                                class="text-blue-600 hover:text-blue-900 transition-colors duration-200 inline-flex items-center mx-2">
                                <i class="fas fa-notes-medical text-lg"></i>
                            </a>

                            <!-- View Profile -->
                            <a href="{{ route('visits.view', $patient->id) }}"
                                class="text-blue-600 hover:text-blue-900 transition-colors duration-200 inline-flex items-center mx-2">
                                <i class="fas fa-eye text-lg"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('patients.edit', $patient->id) }}"
                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200 inline-flex items-center mx-2">
                                <i class="fas fa-edit text-lg"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('patients.delete', $patient->id) }}" method="GET"
                                onsubmit="return confirm('Are you sure you want to delete this patient?');" class="inline mx-2">
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                    <i class="fas fa-trash text-lg"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                            <p class="text-lg">No patients found.</p>
                            <p class="text-sm">Try adjusting your search criteria.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection