@extends('layouts.doctor-dashboard')



@section('content')
<style>
    .patient-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: bold;
    }

    .visit-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .visit-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        transform: translateY(-1px);
    }

    .visit-type-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 100;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }
</style>

<div class="min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Patient Visits Management</h1>
                <p class="text-gray-600">Track and manage all patient visits and consultations</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md">
                    <i class="fas fa-user-injured mr-2"></i>
                    <span>{{ $patients->count() }} visits</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Visits</p>
                    <p class="text-3xl font-bold">{{ $patients->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <i class="fas fa-hospital-user text-xl"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-white/20">
                <div class="text-xs text-blue-200">All patient visits</div>
            </div>
        </div>

        @php
        $opdCount = $patients->where('visit_type', 'OPD')->count();
        $emergencyCount = $patients->where('visit_type', 'Emergency')->count();
        $checkupCount = $patients->where('visit_type', 'Checkup')->count();
        @endphp

        <!-- <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">OPD Visits</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $opdCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-blue-600 font-medium">
                Outpatient Department
            </div>
        </div> -->

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Emergency</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $emergencyCount }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ambulance text-red-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-red-600 font-medium">
                Emergency Cases
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Checkups</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $checkupCount }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-stethoscope text-green-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-green-600 font-medium">
                Regular Checkups
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <!-- Header with Filters -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-b">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Patient Visits List</h2>
                    <p class="text-sm text-gray-600 mt-1">Manage and track all patient visits</p>
                </div>
                <div class="text-sm text-gray-500">
                    Showing {{ $patients->count() }} visits
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="px-6 py-5 border-b bg-gray-50">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Patient Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="patient_name" value="{{ request('patient_name') }}"
                                placeholder="Search patient..."
                                class="pl-10 w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>

                    <!-- Visit Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visit Type</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-hospital text-gray-400"></i>
                            </div>
                            <select name="visit_type"
                                class="pl-10 w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
                                <option value="">All Visit Types</option>
                                <option value="OPD" {{ request('visit_type') == 'OPD' ? 'selected' : '' }}>OPD</option>
                                <option value="Emergency" {{ request('visit_type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                <option value="Checkup" {{ request('visit_type') == 'Checkup' ? 'selected' : '' }}>Checkup</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Visit Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Visit Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="pl-10 w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                            <i class="fas fa-filter mr-2"></i>
                            Apply Filters
                        </button>
                        <a href="{{ route('employee.doctor_patients') }}"
                            class="w-full px-4 py-2.5 text-center bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                            <i class="fas fa-redo mr-2"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Visits List -->
        <div class="p-6">
            @if($patients->isEmpty())
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-user-slash text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No visits found</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    @if(request()->anyFilled(['patient_name', 'visit_type', 'date']))
                    No visits match your search criteria. Try adjusting your filters.
                    @else
                    No patient visits have been recorded yet.
                    @endif
                </p>
                @if(request()->anyFilled(['patient_name', 'visit_type', 'date']))
                <a href="{{ route('employee.doctor_patients') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                    <i class="fas fa-eye"></i>
                    View All Visits
                </a>
                @endif
            </div>
            @else
            <!-- Desktop View (Cards) -->
            <div class="space-y-4 hidden md:block">
                @foreach($patients as $index => $visit)
                <div class="visit-card bg-white rounded-xl border p-5">
                    <div class="flex items-start justify-between gap-4">
                        <!-- Patient Info -->
                        <div class="flex items-start gap-4">
                            <div class="relative">
                                <div class="w-16 h-16 patient-avatar rounded-xl flex items-center justify-center text-lg shadow-md">
                                    {{ substr($visit->user->full_name ?? 'NA', 0, 2) }}
                                </div>
                                @if($visit->visit_type == 'Emergency')
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                    <i class="fas fa-exclamation text-xs text-white"></i>
                                </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <h3 class="font-semibold text-gray-900 text-lg">
                                        {{ $visit->user->full_name ?? 'Unknown' }}
                                    </h3>
                                    <span class="visit-type-badge 
                                                @if($visit->visit_type == 'Emergency') bg-red-100 text-red-800 border border-red-200
                                                @elseif($visit->visit_type == 'OPD') bg-blue-100 text-blue-800 border border-blue-200
                                                @elseif($visit->visit_type == 'Checkup') bg-green-100 text-green-800 border border-green-200
                                                @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                        <i class="fas 
                                                    @if($visit->visit_type == 'Emergency') fa-ambulance
                                                    @elseif($visit->visit_type == 'OPD') fa-clipboard-list
                                                    @elseif($visit->visit_type == 'Checkup') fa-stethoscope
                                                    @endif mr-1"></i>
                                        {{ $visit->visit_type ?? 'General' }}
                                    </span>
                                    @if($visit->date_of_visit)
                                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                        <i class="fas fa-calendar-day mr-1 text-blue-500"></i>
                                        {{ $visit->date_of_visit->format('d M Y') }}
                                    </span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-door-closed text-blue-500"></i>
                                        <span>Room:
                                            <strong>
                                                {{ $visit->consultantAssignment?->room?->room_id 
            ? substr($visit->consultantAssignment->room->room_id, 0, 10) . '…'
            : '-' 
        }}
                                            </strong>
                                        </span>

                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-md text-purple-500"></i>
                                        <span>Reception: <strong>{{ $visit->reception?->reception_id ?? '-' }}</strong></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-file-medical text-green-500"></i>
                                        <span class="truncate">Chief Complaint:
                                            <strong>{{ $visit->chief_complaint ? Str::limit($visit->chief_complaint, 30) : '-' }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col items-end gap-3">
                            <div class="text-sm text-gray-500">
                                Visit #{{ $index + 1 }}
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('employee.users.summary', $visit->user->id) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Mobile View (Table) -->
            <div class="overflow-x-auto md:hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($patients as $index => $visit)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 patient-avatar rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ substr($visit->user->full_name ?? 'NA', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $visit->user->full_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $visit->date_of_visit?->format('d M Y') ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="visit-type-badge 
                                        @if($visit->visit_type == 'Emergency') bg-red-100 text-red-800
                                        @elseif($visit->visit_type == 'OPD') bg-blue-100 text-blue-800
                                        @elseif($visit->visit_type == 'Checkup') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                    {{ $visit->visit_type ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('employee.users.summary', $visit->user->id) }}"
                                    class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Sidebar Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Visit Types Distribution -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Visit Types Distribution</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">OPD Visits</span>
                        <span class="text-sm font-semibold text-blue-600">{{ $opdCount }} ({{ $patients->count() > 0 ? round(($opdCount/$patients->count())*100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $patients->count() > 0 ? ($opdCount/$patients->count())*100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Emergency</span>
                        <span class="text-sm font-semibold text-red-600">{{ $emergencyCount }} ({{ $patients->count() > 0 ? round(($emergencyCount/$patients->count())*100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $patients->count() > 0 ? ($emergencyCount/$patients->count())*100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600">Checkups</span>
                        <span class="text-sm font-semibold text-green-600">{{ $checkupCount }} ({{ $patients->count() > 0 ? round(($checkupCount/$patients->count())*100, 1) : 0 }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $patients->count() > 0 ? ($checkupCount/$patients->count())*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <!-- <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <span>New Visit Note</span>
                    </div>
                    <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </a> -->
                <!-- <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-prescription"></i>
                        </div>
                        <span>Write Prescription</span>
                    </div>
                    <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </a> -->
                <a href="{{route('employee.report')}}" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span>View Reports</span>
                    </div>
                    <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-3">
                @foreach($patients->take(3) as $activity)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user-injured text-blue-600 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $activity->user->full_name }} visited
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $activity->visit_type }} • {{ $activity->date_of_visit?->format('M d') }}
                        </p>
                    </div>
                    <span class="text-xs font-medium 
                        @if($activity->visit_type == 'Emergency') text-red-600
                        @elseif($activity->visit_type == 'OPD') text-blue-600
                        @else text-green-600 @endif">
                        {{ $activity->visit_type }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection