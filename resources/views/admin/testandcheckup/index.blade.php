@extends('layouts.layout')

@section('content')
<div class="min-h-screen " style="width: 90%;">
    <div class="container mx-auto px-2 py-6">

        <!-- Enhanced Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-2xl mb-8">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-blue-300 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-300 rounded-full filter blur-3xl"></div>
            </div>
            <div class="relative z-10 p-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-3 flex items-center gap-4">
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                                <i class="fas fa-flask text-white text-2xl"></i>
                            </div>
                            Tests & Checkups Management
                        </h1>
                        <p class="text-blue-100 text-lg">Manage and organize all laboratory tests and medical checkups</p>
                    </div>
                    <a href="{{ route('admin.testcheckup.create') }}"
                        class="group inline-flex items-center gap-3 px-8 py-4 bg-white text-blue-700 rounded-xl hover:bg-blue-50 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-plus-circle text-xl"></i>
                        <span class="text-lg">Add New Test</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Tests Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Tests</p>
                        <p class="text-4xl font-bold text-gray-900">{{ $totalTests }}</p>
                        <p class="text-xs text-gray-500 mt-2">All available tests in system</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl">
                        <i class="fas fa-vial text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                        <span>Total laboratory tests</span>
                    </div>
                </div>
            </div>

            <!-- Active Tests Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Active Tests</p>
                        <p class="text-4xl font-bold text-green-600">{{ $activeTests }}</p>
                        <p class="text-xs text-gray-500 mt-2">Currently available for patients</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-green-100 to-green-50 rounded-2xl">
                        <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-bolt text-green-500 mr-2"></i>
                        <span>Ready for booking</span>
                    </div>
                </div>
            </div>

            <!-- Inactive Tests Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Inactive Tests</p>
                        <p class="text-4xl font-bold text-red-600">{{ $inactiveTests }}</p>
                        <p class="text-xs text-gray-500 mt-2">Temporarily unavailable</p>
                    </div>
                    <div class="p-4 bg-gradient-to-br from-red-100 to-red-50 rounded-2xl">
                        <i class="fas fa-pause-circle text-red-600 text-3xl"></i>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock text-red-500 mr-2"></i>
                        <span>Currently not available</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-filter text-blue-600"></i>
                        </div>
                        Search & Filter Tests
                    </h2>
                    @if(request()->hasAny(['search', 'category', 'status', 'fasting_required']))
                    <a href="{{route('admin.test.checkup')}}"
                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                        <i class="fas fa-times"></i>
                        Clear All Filters
                    </a>
                    @endif
                </div>
            </div>

            <form method="GET" action="{{route('admin.test.checkup')}}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Search Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-search mr-2 text-gray-400"></i>
                            Search Tests
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search test name, sample type..."
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tags mr-2 text-gray-400"></i>
                            Category
                        </label>
                        <select name="category"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-circle mr-2 text-gray-400"></i>
                            Status
                        </label>
                        <select name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }} class="text-green-600">Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }} class="text-red-600">Inactive</option>
                        </select>
                    </div>

                    <!-- Fasting Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-utensils mr-2 text-gray-400"></i>
                            Fasting Required
                        </label>
                        <select name="fasting_required"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400">
                            <option value="">All Types</option>
                            <option value="yes" {{ request('fasting_required') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ request('fasting_required') == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters Tags -->
                @if(request()->hasAny(['search', 'category', 'status', 'fasting_required']))
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Active Filters:</h3>
                    <div class="flex flex-wrap gap-2">
                        @if(request('search'))
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-search mr-1.5"></i>
                            Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if(request('category'))
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-tag mr-1.5"></i>
                            Category: {{ request('category') }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="ml-2 text-green-600 hover:text-green-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if(request('status'))
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium {{ request('status') == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas fa-circle mr-1.5 {{ request('status') == 'active' ? 'text-green-500' : 'text-red-500' }}"></i>
                            Status: {{ ucfirst(request('status')) }}
                            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="ml-2 {{ request('status') == 'active' ? 'text-green-600 hover:text-green-800' : 'text-red-600 hover:text-red-800' }}">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if(request('fasting_required'))
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-utensils mr-1.5"></i>
                            Fasting: {{ ucfirst(request('fasting_required')) }}
                            <a href="{{ request()->fullUrlWithQuery(['fasting_required' => null]) }}" class="ml-2 text-orange-600 hover:text-orange-800">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
                    <div class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        <span>Found {{ $tests->count() }} test(s)</span>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{route('admin.test.checkup')}}"
                            class="group inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 hover:shadow-md">
                            <i class="fas fa-redo"></i>
                            Reset
                        </a>
                        <button type="submit"
                            class="group inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-filter"></i>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden" style="width: 100%;">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-list text-blue-600"></i>
                        </div>
                        All Tests
                        <span class="text-sm font-normal text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                            {{ $tests->count() }} items
                        </span>
                    </h2>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Sorted by:</span>
                        <span class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Latest Added</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    #
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-flask text-gray-400"></i>
                                    Test Name
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tag text-gray-400"></i>
                                    Category
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-vial text-gray-400"></i>
                                    Sample Type
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-utensils text-gray-400"></i>
                                    Fasting
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-circle text-gray-400"></i>
                                    Status
                                </div>
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cog text-gray-400"></i>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tests as $index => $test)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/30 transition-all duration-200 group">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-lg text-sm font-semibold text-gray-700 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">
                                        {{ $test->test_name }}
                                    </div>
                                    @if($test->description)
                                    <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">
                                        {{ Str::limit($test->description, 50) }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-50 to-emerald-50 text-emerald-800 border border-green-100">
                                    <i class="fas fa-tag mr-1.5 text-green-500"></i>
                                    {{ $test->category }}
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-vial text-gray-400"></i>
                                    <span class="text-sm text-gray-700">{{ $test->sample_type ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                @if($test->fasting_required)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-orange-50 to-amber-50 text-amber-800 border border-orange-100">
                                    <i class="fas fa-utensils mr-1.5 text-orange-500"></i>
                                    Required
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-50 to-emerald-50 text-emerald-800 border border-green-100">
                                    <i class="fas fa-check-circle mr-1.5 text-green-500"></i>
                                    Not Required
                                </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                @if($test->status == 'active')
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-50 to-emerald-50 text-emerald-800 border border-green-100 shadow-sm">
                                    <i class="fas fa-circle text-green-500 mr-1.5 animate-pulse"></i>
                                    Active
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gradient-to-r from-red-50 to-rose-50 text-rose-800 border border-red-100 shadow-sm">
                                    <i class="fas fa-circle text-red-500 mr-1.5"></i>
                                    Inactive
                                </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.test.checkup.edit', $test->id) }}"
                                        class="group/edit inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-yellow-50 to-amber-50 text-amber-700 rounded-lg hover:from-yellow-100 hover:to-amber-100 transition-all duration-200 border border-yellow-100 hover:shadow-md">
                                        <i class="fas fa-edit group-hover/edit:rotate-12 transition-transform"></i>
                                        <span class="text-sm font-medium">Edit</span>
                                    </a>
                                    <form action="{{ route('admin.testandcheckup.destroy', $test->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this test? This action cannot be undone.')"
                                            class="group/delete inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-50 to-rose-50 text-rose-700 rounded-lg hover:from-red-100 hover:to-rose-100 transition-all duration-200 border border-red-100 hover:shadow-md">
                                            <i class="fas fa-trash group-hover/delete:shake transition-transform"></i>
                                            <span class="text-sm font-medium">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-4 bg-gradient-to-r from-gray-100 to-gray-50 rounded-2xl mb-4">
                                        <i class="fas fa-flask text-gray-300 text-5xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No tests found</h3>
                                    <p class="text-gray-600 mb-6">Try adjusting your filters or add a new test.</p>
                                    <a href="{{ route('admin.testcheckup.create') }}"
                                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                        <i class="fas fa-plus"></i>
                                        Add Your First Test
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            @if($tests->count() > 0)
            <div class="px-6 py-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        Showing {{ $tests->count() }} of {{ $totalTests }} total tests
                    </div>
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock text-gray-400 mr-1"></i>
                        Last updated: {{ now()->format('d M Y, h:i A') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-2px);
        }

        75% {
            transform: translateX(2px);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .group-hover\/delete\:shake:hover i {
        animation: shake 0.5s ease-in-out;
    }

    .group-hover\/edit\:rotate-12:hover i {
        transform: rotate(12deg);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to table rows
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
            row.classList.add('animate-fade-in');
        });

        // Auto-focus search input when filter section is expanded
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput && window.location.search.includes('search=')) {
            searchInput.focus();
        }

        // Add tooltips for action buttons
        const editButtons = document.querySelectorAll('.group\\/edit');
        editButtons.forEach(btn => {
            btn.setAttribute('title', 'Edit this test');
        });

        const deleteButtons = document.querySelectorAll('.group\\/delete');
        deleteButtons.forEach(btn => {
            btn.setAttribute('title', 'Delete this test');
        });
    });
</script>
@endpush

@endsection