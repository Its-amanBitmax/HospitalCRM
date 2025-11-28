@extends('layouts.layout')

@section('title', 'Hospital Visits')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white bg-white-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-200 border-gray-700 hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 from-blue-900 to-blue-800 p-4 rounded-full">
                    <i class="fas fa-users text-blue-600 text-blue-300 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-gray-400 text-sm font-medium">Total Visits</p>
                    <p class="text-2xl font-bold text-gray-900 text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white bg-white-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-200 border-gray-700 hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 from-yellow-900 to-yellow-800 p-4 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-yellow-300 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-gray-400 text-sm font-medium">Scheduled</p>
                    <p class="text-2xl font-bold text-gray-900 text-white">{{ $stats['scheduled'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white bg-white-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-200 border-gray-700 hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-green-100 to-green-200 from-green-900 to-green-800 p-4 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-green-300 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-gray-400 text-sm font-medium">Completed</p>
                    <p class="text-2xl font-bold text-gray-900 text-white">{{ $stats['completed'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white bg-white-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-200 border-gray-700 hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="bg-gradient-to-br from-red-100 to-red-200 from-red-900 to-red-800 p-4 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-red-300 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-gray-400 text-sm font-medium">Emergency Visits</p>
                    <p class="text-2xl font-bold text-gray-900 text-white">{{ $stats['emergency'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white bg-white-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 text-white">Hospital Visits</h1>
                <p class="text-gray-600 text-gray-400 mt-1">Manage and track all hospital visits</p>
            </div>
            <a href="{{ route('admin.visits.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 shadow-lg transition duration-200">
                <i class="fas fa-plus"></i> Add New Visit
            </a>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white-50 bg-white-700 p-4 rounded-lg">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Visit Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1 flex items-center gap-2">
                        <i class="fas fa-list text-gray-500"></i> Visit Type
                    </label>
                    <select name="visit_type" class="w-full border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                        <option value="">All Types</option>
                        <option value="patient_visit" {{ request('visit_type') == 'patient_visit' ? 'selected' : '' }}>Patient Visit</option>
                        <option value="doctor_meeting" {{ request('visit_type') == 'doctor_meeting' ? 'selected' : '' }}>Doctor Meeting</option>
                        <option value="staff_meeting" {{ request('visit_type') == 'staff_meeting' ? 'selected' : '' }}>Staff Meeting</option>
                        <option value="delivery" {{ request('visit_type') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                        <option value="emergency" {{ request('visit_type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                        <option value="invite" {{ request('visit_type') == 'invite' ? 'selected' : '' }}>Invite</option>
                        <option value="vendor" {{ request('visit_type') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1 flex items-center gap-2">
                        <i class="fas fa-info-circle text-gray-500"></i> Status
                    </label>
                    <select name="status" class="w-full border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                        <option value="">All Status</option>
                        <option value="invited" {{ request('status') == 'invited' ? 'selected' : '' }}>Invited</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Waiting</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Dates -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-500"></i> Start Date
                    </label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-500"></i> End Date
                    </label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                </div>

                <!-- Search -->
                <div class="md:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1 flex items-center gap-2">
                        <i class="fas fa-search text-gray-500"></i> Search
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search visitor or patient" class="flex-1 border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                        <button class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.visits.index') }}" class="bg-white-500 hover:bg-white-600 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Cards View for Visits -->
       <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($visits as $visit)

        <div class="bg-white bg-white-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-200 border border-gray-200 border-gray-700 p-6">

            <!-- Top Section -->
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 text-white">
                        {{ $visit->visitor_name }}
                    </h3>
                    <p class="text-sm text-gray-500 text-gray-400 flex items-center gap-1">
                        <i class="fas fa-phone text-xs"></i> {{ $visit->visitor_contact }}
                    </p>
                </div>

                <!-- Visit Type Badge -->
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                    @if($visit->visit_type == 'patient_visit') bg-blue-100 text-blue-800
                    @elseif($visit->visit_type == 'doctor_meeting') bg-green-100 text-green-800
                    @elseif($visit->visit_type == 'staff_meeting') bg-purple-100 text-purple-800
                    @elseif($visit->visit_type == 'delivery') bg-yellow-100 text-yellow-800
                    @elseif($visit->visit_type == 'emergency') bg-red-100 text-red-800
                    @elseif($visit->visit_type == 'invite') bg-indigo-100 text-indigo-800
                    @else bg-white-100 text-gray-800
                    @endif">
                    {{ ucwords(str_replace('_', ' ', $visit->visit_type)) }}
                </span>
            </div>

            <!-- Divider -->
            <div class="my-4 border-t border-gray-200 border-gray-700"></div>

            <!-- Patient Section -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 text-gray-400">Patient</p>
                <p class="font-medium text-gray-800 text-gray-200 flex items-center gap-1">
                    @if($visit->patient)
                        <i class="fas fa-user-injured text-sm text-gray-400"></i>
                        {{ $visit->patient->name }} ({{ $visit->patient_mr_no }})
                    @else
                        <span class="text-gray-400">Not Applicable</span>
                    @endif
                </p>
            </div>

            <!-- Scheduled Section -->
            <div class="mb-3">
                <p class="text-xs text-gray-500 text-gray-400">Scheduled Time</p>
                <p class="font-medium text-gray-800 text-gray-200 flex items-center gap-1">
                    <i class="far fa-calendar-check text-sm text-gray-400"></i>
                    {{ $visit->scheduled_visit ? $visit->scheduled_visit->format('M d, Y • H:i') : 'N/A' }}
                </p>
            </div>

            <!-- Status Badge -->
            <div class="mt-4">
                <span class="px-3 py-1 text-xs font-semibold rounded-full
                    @if($visit->status == 'completed') bg-green-100 text-green-700
                    @elseif($visit->status == 'in_progress') bg-blue-100 text-blue-700
                    @elseif($visit->status == 'waiting') bg-yellow-100 text-yellow-800
                    @elseif($visit->status == 'scheduled') bg-white-100 text-gray-800
                    @elseif($visit->status == 'invited') bg-indigo-100 text-indigo-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucwords(str_replace('_', ' ', $visit->status)) }}
                </span>
            </div>

            <!-- Divider -->
            <div class="my-4 border-t border-gray-200 border-gray-700"></div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center">

                <a href="{{ route('admin.visits.show', $visit) }}"
                   class="text-cyan-600 hover:text-cyan-900 text-lg">
                    <i class="fas fa-eye"></i>
                </a>

                <a href="{{ route('admin.visits.edit', $visit) }}"
                   class="text-blue-600 hover:text-blue-900 text-lg">
                    <i class="fas fa-edit"></i>
                </a>

                @if($visit->status == 'scheduled' || $visit->status == 'waiting')
                    <form action="{{ route('admin.visits.check-in', $visit) }}" method="POST">
                        @csrf
                        <button class="text-green-600 hover:text-green-900 text-lg" title="Check In">
                            <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </form>
                @endif

                @if($visit->status == 'in_progress')
                    <form action="{{ route('admin.visits.check-out', $visit) }}" method="POST">
                        @csrf
                        <button class="text-orange-600 hover:text-orange-900 text-lg" title="Check Out">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                @endif

                @if($visit->visit_type == 'invite' && $visit->invite_status == 'pending')
                    <form action="{{ route('admin.visits.accept-invite', $visit) }}" method="POST">
                        @csrf
                        <button class="text-green-600 hover:text-green-900 text-lg">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.visits.decline-invite', $visit) }}" method="POST">
                        @csrf
                        <button class="text-red-600 hover:text-red-900 text-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.visits.destroy', $visit) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this visit?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-900 text-lg">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

            </div>

        </div>

    @empty
        <p class="text-center text-gray-500 text-gray-400 col-span-full py-8">
            No visits found
        </p>
    @endforelse
</div>


        <!-- Pagination -->
        @if($visits->hasPages())
            <div class="mt-6">
                {{ $visits->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Floating Action Button -->
    <a href="{{ route('admin.visits.create') }}" class="fixed bottom-6 right-6 bg-cyan-600 hover:bg-cyan-700 text-white p-4 rounded-full shadow-lg transition duration-200 z-10">
        <i class="fas fa-plus text-xl"></i>
    </a>
</div>
@endsection
