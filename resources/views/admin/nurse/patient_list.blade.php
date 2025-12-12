@extends('layouts.layout')

@section('title', 'Patient List')

@section('content')
<div class="min-h-screen ">

    <!-- Success Message Toast -->
    @if(session('success'))
    <div id="successToast" class="fixed top-6 right-8 z-50 animate-slide-in">
        <div class="relative">
            <div class="bg-white rounded-xl shadow-2xl border-l-4 border-green-500 min-w-[320px] p-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ session('success') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Just now</p>
                    </div>
                    <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Patient Assignment</h1>
                        <p class="text-gray-600 mt-1">Manage patient records and nurse assignments</p>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex items-center gap-3">
                        <!-- <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Patient
                        </button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Patients</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $users->total() }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.913a8 8 0 01-13.67-3.913L3 21" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">IPD Patients</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ collect($users->items())->where('type', 'ipd')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">OPD Patients</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ collect($users->items())->where('type', 'opd')->count() }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">With Nurses</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ collect($users->items())->filter(fn($user) => $user->nurses->count() > 0)->count() }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Table Header with Search -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Patient Records</h2>
                        <p class="text-gray-600 text-sm mt-1">{{ count($users->items()) }} patients on this page</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text"
                                placeholder="Search patients..."
                                class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-full md:w-64"
                                id="searchInput">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <select id="filterType" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                            <option value="all">All Types</option>
                            <option value="ipd">IPD Only</option>
                            <option value="opd">OPD Only</option>
                            <option value="registered">Registered</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            @if(count($users->items()) > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Patient Details
                            </th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Contact
                            </th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nurses
                            </th>
                            <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="patientsTableBody">
                        @foreach($users->items() as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 patient-row" data-type="{{ $user->type }}">
                            <!-- Patient Details -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->full_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-medium text-gray-900">{{ $user->full_name }}</h4>

                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                                            <span>{{ $user->age ?? 'N/A' }} years</span>

                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact Info -->
                            <td class="py-4 px-6">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-700 truncate max-w-[180px]">{{ $user->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $user->mobile_no ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                <div class="space-y-2">
                                    @php
                                    $statusColors = [
                                    'ipd' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'opd' => 'bg-green-100 text-green-800 border-green-200',
                                    'registered' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'discharged' => 'bg-gray-100 text-gray-800 border-gray-200'
                                    ];
                                    $statusClass = $statusColors[$user->type] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusClass }}">
                                        {{ strtoupper($user->type ?? 'UNKNOWN') }}

                                    </span>

                                </div>
                            </td>

                            <!-- Assigned Nurses -->
                            <td class="py-4 px-6">
                                <div class="space-y-2">
                                    @forelse($user->nurses as $nurse)
                                    <div class="flex items-center gap-2 p-2  rounded-lg">
                                        <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-xs font-semibold">
                                            {{ strtoupper(substr($nurse->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $nurse->name }}</p>

                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-2">
                                        <p class="text-sm text-gray-400">No nurse assigned</p>
                                    </div>
                                    @endforelse
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <button onclick="openAssignModal({{ $user->id }}, '{{ $user->full_name }}')"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Assign
                                    </button>


                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span> to
                            <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span> of
                            <span class="font-medium">{{ $users->total() }}</span> patients
                        </p>
                    </div>
                    @if($users->hasPages())
                    <div class="flex items-center gap-2">
                        {{ $users->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="py-12 text-center">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium">No patients found</p>
                        <p class="text-gray-400 text-sm mt-1">Add patients to get started</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Assign Nurse Modal -->
<div id="assignModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Assign Nurse</h2>
                <button onclick="closeAssignModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 text-sm mt-1">Assign a nurse to <span id="patientName" class="font-medium text-gray-900"></span></p>
        </div>

        <!-- Modal Form -->
        <form id="assignForm" method="POST" action="{{ route('nurse.assign') }}" class="p-6">
            @csrf
            <input type="hidden" name="patient_id" id="patientId">

            <!-- Nurse Selection -->
            <div class="mb-6">
                <label for="nurse_id" class="block text-sm font-medium text-gray-700 mb-3">Select a Nurse</label>
                <div class="relative">
                    <select name="nurse_id" id="nurse_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none bg-white text-gray-700">
                        <option value="" disabled selected>Select a nurse from the list</option>
                        @foreach($nurses as $nurse)
                        <option value="{{ $nurse->id }}" class="py-2">
                            {{ $nurse->name }} (ID: {{ $nurse->id }})
                        </option>
                        @endforeach
                    </select>
                    <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAssignModal()"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                    Confirm Assignment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Functions
    function openAssignModal(patientId, patientName) {
        document.getElementById('patientId').value = patientId;
        document.getElementById('patientName').textContent = patientName;
        document.getElementById('assignModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('assignForm').reset();
    }

    // Search Functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.patient-row');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Filter by Type
    const filterType = document.getElementById('filterType');
    if (filterType) {
        filterType.addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.patient-row');

            rows.forEach(row => {
                if (filterValue === 'all') {
                    row.style.display = '';
                } else {
                    const type = row.dataset.type;
                    row.style.display = type === filterValue ? '' : 'none';
                }
            });
        });
    }

    // View Patient Details
    function viewPatientDetails(patientId) {
        // Redirect to patient details page or open details modal
        console.log('View patient details for ID:', patientId);
        // Example: window.location.href = `/patients/${patientId}`;
    }

    // Toast Functions
    function hideToast() {
        const toast = document.getElementById('successToast');
        if (toast) {
            toast.style.animation = 'slideOut 0.3s ease-in forwards';
            setTimeout(() => toast.remove(), 300);
        }
    }

    // Auto-hide success toast
    document.addEventListener('DOMContentLoaded', function() {
        const successToast = document.getElementById('successToast');
        if (successToast) {
            setTimeout(() => {
                successToast.style.animation = 'slideOut 0.3s ease-in forwards';
                setTimeout(() => successToast.remove(), 300);
            }, 4000);
        }
    });

    // Close modal on outside click
    document.getElementById('assignModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAssignModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('assignModal').classList.contains('hidden')) {
            closeAssignModal();
        }
    });
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
</style>
@endsection