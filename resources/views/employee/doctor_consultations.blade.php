@extends('layouts.doctor-dashboard')



@section('content')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .patient-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: bold;
    }

    .status-badge {
        transition: all 0.3s ease;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    .consultation-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .consultation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    .date-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
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

    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        transform: translateY(-1px);
    }
</style>

@php
use Illuminate\Support\Str;
use Carbon\Carbon;

function formatConsultationTime($time) {
if (!$time) return '—';

// Check if it's a time range (contains ' - ')
if (strpos($time, ' - ') !== false) {
$parts = explode(' - ', $time);
$start = trim($parts[0] ?? '');
$end = trim($parts[1] ?? '');

try {
$startFormatted = $start ? Carbon::parse($start)->format('h:i A') : '';
$endFormatted = $end ? Carbon::parse($end)->format('h:i A') : '';
return $endFormatted ? "$startFormatted - $endFormatted" : $startFormatted;
} catch (\Exception $e) {
return $time; // Return original if parsing fails
}
}

// Single time
try {
return Carbon::parse($time)->format('h:i A');
} catch (\Exception $e) {
return $time; // Return original if parsing fails
}
}

// Calculate today's consultations
$todayCount = \App\Models\Appointment::where('doctor_id', auth('doctor')->id())
->whereDate('appointment_date', Carbon::today())
->where('status', 'Confirmed')
->count();

// Calculate completion rate
$completionRate = $total > 0 ? round(($confirmed / $total) * 100, 1) : 0;
@endphp

<div class="min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Consultations Management</h1>
                <p class="text-gray-600">Manage patient consultations and medical appointments</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md">
                    <i class="fas fa-calendar-day mr-2"></i>
                    <span>{{ $todayCount }} consultations today</span>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    {{ now()->format('h:i A') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Consultations</p>
                    <p class="text-3xl font-bold">{{ $total }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <i class="fas fa-stethoscope text-xl"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-white/20">
                <div class="text-xs text-blue-200">All time records</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Confirmed</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $confirmed }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-green-600 font-medium">
                {{ $completionRate }}% completion rate
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Pending</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $pending }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $total > 0 ? ($pending/$total)*100 : 0 }}%"></div>
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-yellow-600 font-medium">
                Awaiting confirmation
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Upcoming</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $upcoming->count() }}</p>
                    <div class="text-sm text-gray-500 mt-2">Next 3 days</div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-purple-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-purple-600 font-medium">
                Scheduled appointments
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Consultations List -->
        <div class="lg:col-span-2">
            <!-- Tabs -->
            <div class="bg-white rounded-xl shadow-sm border mb-6 overflow-hidden">
                <div class="border-b">
                    <div class="flex">
                        <button id="upcomingTab" class="flex-1 py-4 px-6 text-center font-medium text-blue-600 border-b-2 border-blue-600 bg-blue-50">
                            <i class="fas fa-clock mr-2"></i>
                            Upcoming Consultations
                            <span class="ml-2 bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">
                                {{ $upcoming->count() }}
                            </span>
                        </button>
                        <button id="allTab" class="flex-1 py-4 px-6 text-center font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-list mr-2"></i>
                            All Consultations
                            <span class="ml-2 bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded-full">
                                {{ $total }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Upcoming Consultations Section -->
                <div id="upcomingSection" class="p-6">
                    @if($upcoming->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No upcoming consultations</h3>
                        <p class="text-gray-500 max-w-md mx-auto">You don't have any consultations scheduled for the next few days.</p>
                    </div>
                    @else
                    <div class="space-y-4">
                        @foreach($upcoming->take(5) as $app)
                        <div class="consultation-card bg-white rounded-xl border p-5">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <!-- Patient Info -->
                                <div class="flex items-start gap-4">
                                    <div class="relative">
                                        <div class="w-16 h-16 patient-avatar rounded-xl flex items-center justify-center text-lg shadow-md">
                                            {{ substr($app->user->full_name ?? $app->relative->name ?? 'NA', 0, 2) }}
                                        </div>
                                        @if($app->status == 'Pending')
                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                            <i class="fas fa-exclamation text-xs text-white"></i>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-3 mb-2">
                                            <h3 class="font-semibold text-gray-900 text-lg">
                                                {{ $app->user->full_name ?? $app->relative->name ?? 'Unknown' }}
                                            </h3>
                                            <span class="date-badge shadow-sm">
                                                <i class="fas fa-calendar-day mr-1"></i>
                                                {{ Carbon::parse($app->appointment_date)->format('d M') }}
                                            </span>
                                            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                                {{ $app->for_user_type === 'self' ? 'Self' : $app->relative->relation ?? 'Relative' }}
                                            </span>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            <span class="inline-flex items-center gap-2 bg-blue-50 px-3 py-1 rounded-lg">
                                                <i class="fas fa-clock text-blue-500"></i>
                                                {{ formatConsultationTime($app->appointment_time) }}
                                            </span>
                                            <span class="inline-flex items-center gap-2 bg-gray-50 px-3 py-1 rounded-lg">
                                                <i class="fas fa-barcode text-gray-500"></i>
                                                {{ $app->appointment_code }}
                                            </span>
                                            @if($app->issue)
                                            <span class="inline-flex items-center gap-2 bg-green-50 px-3 py-1 rounded-lg">
                                                <i class="fas fa-stethoscope text-green-500"></i>
                                                {{ Str::limit($app->issue, 25) }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex flex-col items-end gap-3">
                                    <span class="status-badge shadow-sm
                                        @if($app->status == 'Pending') bg-yellow-50 text-yellow-800 border border-yellow-200
                                        @elseif($app->status == 'Confirmed') bg-green-50 text-green-800 border border-green-200
                                        @elseif($app->status == 'Cancelled') bg-red-50 text-red-800 border border-red-200
                                        @endif">
                                        <i class="fas 
                                            @if($app->status == 'Pending') fa-clock
                                            @elseif($app->status == 'Confirmed') fa-check-circle
                                            @elseif($app->status == 'Cancelled') fa-times-circle
                                            @endif mr-1"></i>
                                        {{ $app->status }}
                                    </span>

                                    <div class="flex items-center gap-2">
                                        <button onclick='showConsultationDetails(@json($app))'
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        @if($app->status == 'Pending')
                                        <form method="POST" action="{{ route('employee.appointments.accept', $app->appointment_id) }}" class="inline">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to accept this consultation?')"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-check"></i>
                                                Accept
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('employee.appointments.reject', $app->appointment_id) }}" class="inline">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to reject this consultation?')"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-times"></i>
                                                Reject
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> 
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- All Consultations Section -->
                <div id="allSection" class="p-6 hidden">
                    @if($allConsultations->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No consultation records</h3>
                        <p class="text-gray-500 max-w-md mx-auto">There are no consultation records in the system yet.</p>
                    </div>
                    @else
                    <!-- Filters -->
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button class="filter-btn px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg text-sm font-medium">
                                All ({{ $allConsultations->count() }})
                            </button>
                            <button class="filter-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Confirmed ({{ $confirmed }})
                            </button>
                            <button class="filter-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Pending ({{ $pending }})
                            </button>
                            <button class="filter-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                                Cancelled ({{ $cancelled ?? 0 }})
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Filter by date">
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search by patient name...">
                        </div>
                    </div>

                    <!-- All Consultations List -->
                    <div class="space-y-4">
                        @foreach($allConsultations as $app)
                        <div class="consultation-card bg-white rounded-xl border p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 patient-avatar rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ substr($app->user->full_name ?? $app->relative->name ?? 'NA', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="font-semibold text-gray-900">{{ $app->user->full_name ?? $app->relative->name ?? 'Unknown' }}</h4>
                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                                {{ $app->for_user_type === 'self' ? 'Self' : $app->relative->relation ?? 'Relative' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-gray-600">
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-calendar-day mr-2 text-blue-500"></i>
                                                {{ Carbon::parse($app->appointment_date)->format('d M Y') }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-clock mr-2 text-green-500"></i>
                                                {{ formatConsultationTime($app->appointment_time) }}
                                            </span>
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-barcode mr-2 text-gray-500"></i>
                                                {{ $app->appointment_code }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-3">
                                    <span class="status-badge
                                        @if($app->status == 'Pending') bg-yellow-50 text-yellow-800 border border-yellow-200
                                        @elseif($app->status == 'Confirmed') bg-green-50 text-green-800 border border-green-200
                                        @elseif($app->status == 'Cancelled') bg-red-50 text-red-800 border border-red-200
                                        @endif">
                                        <i class="fas 
                                            @if($app->status == 'Pending') fa-clock
                                            @elseif($app->status == 'Confirmed') fa-check-circle
                                            @elseif($app->status == 'Cancelled') fa-times-circle
                                            @endif mr-1"></i>
                                        {{ $app->status }}

                                    </span>
                                    <button onclick='showConsultationDetails(@json($app))'
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <!-- <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <span>Today's Schedule</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-prescription"></i>
                            </div>
                            <span>Write Prescription</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <span>Patient History</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>  -->

            <!-- Consultation Stats -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Consultation Stats</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-gray-600">Completion Rate</span>
                            <span class="text-sm font-semibold text-green-600">{{ $completionRate }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ $todayCount }}</p>
                            <p class="text-xs text-gray-600">Today</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $confirmed }}</p>
                            <p class="text-xs text-gray-600">Confirmed</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-3">
                    @foreach($upcoming->take(3) as $activity)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600 text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $activity->user->full_name ?? $activity->relative->name }} consultation
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ Carbon::parse($activity->appointment_date)->format('M d') }} •
                                {{ formatConsultationTime($activity->appointment_time) }}
                            </p>
                        </div>
                        <span class="text-xs font-medium 
                            @if($activity->status == 'Confirmed') text-green-600
                            @elseif($activity->status == 'Pending') text-yellow-600
                            @else text-red-600 @endif">
                            {{ $activity->status }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Consultation Details -->
<div id="consultationModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg animate-slideUp overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-stethoscope text-xl"></i>
                    <h2 class="text-xl font-bold">Consultation Details</h2>
                </div>
                <button onclick="closeConsultationModal()" class="text-white hover:text-gray-200 text-2xl transition-colors">&times;</button>
            </div>
        </div>

        <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto" id="consultationDetails"></div>

        <div class="px-6 py-4 bg-gray-50 border-t flex justify-end gap-3" id="consultationActions">
            <!-- Actions will be inserted here -->
        </div>
    </div>
</div>

<script>
    // JavaScript version of formatConsultationTime function
    function formatConsultationTime(timeStr) {
        if (!timeStr) return '—';

        // Check if it's a time range (contains ' - ')
        if (timeStr.includes(' - ')) {
            const parts = timeStr.split(' - ');
            const start = parts[0]?.trim();
            const end = parts[1]?.trim();

            if (start && end) {
                return formatTime(start) + ' - ' + formatTime(end);
            } else if (start) {
                return formatTime(start);
            }
            return timeStr;
        }

        // Single time
        return formatTime(timeStr);
    }

    function formatTime(timeStr) {
        if (!timeStr) return '—';

        try {
            // Parse time string like "05:00 AM" or "14:30"
            const [time, period] = timeStr.split(' ');
            const [hours, minutes] = time.split(':');

            let hour24 = parseInt(hours);
            let periodStr = '';

            if (period) {
                // 12-hour format
                if (period.toUpperCase() === 'PM' && hour24 !== 12) {
                    hour24 += 12;
                } else if (period.toUpperCase() === 'AM' && hour24 === 12) {
                    hour24 = 0;
                }
                periodStr = ' ' + period.toUpperCase();
            }

            // Format to 12-hour with AM/PM
            const hour12 = hour24 === 0 ? 12 : hour24 > 12 ? hour24 - 12 : hour24;
            const ampm = hour24 >= 12 ? 'PM' : 'AM';

            return `${hour12}:${minutes} ${ampm}`;
        } catch (e) {
            return timeStr; // Return original if parsing fails
        }
    }

    // Tab functionality
    document.getElementById('upcomingTab').addEventListener('click', function() {
        document.getElementById('upcomingSection').classList.remove('hidden');
        document.getElementById('allSection').classList.add('hidden');
        this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600', 'bg-blue-50');
        document.getElementById('allTab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600', 'bg-blue-50');
        document.getElementById('allTab').classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
    });

    document.getElementById('allTab').addEventListener('click', function() {
        document.getElementById('allSection').classList.remove('hidden');
        document.getElementById('upcomingSection').classList.add('hidden');
        this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600', 'bg-blue-50');
        document.getElementById('upcomingTab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600', 'bg-blue-50');
        document.getElementById('upcomingTab').classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
    });

    function showConsultationDetails(app) {
        console.log('showConsultationDetails called with:', app);
        const modal = document.getElementById('consultationModal');
        const detailsDiv = document.getElementById('consultationDetails');
        const actionsDiv = document.getElementById('consultationActions');

        if (!modal) {
            console.error('Modal element not found');
            return;
        }

        const bookedBy = app.for_user_type === 'self' ?
            `Booked by themselves` :
            `Booked for ${app.relative?.name} (${app.relative?.relation ?? 'Relative'})`;

        detailsDiv.innerHTML = `
            <div class="space-y-6">
                <!-- Header Info -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold text-blue-800 text-lg">${app.appointment_code}</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            ${app.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                              app.status === 'Confirmed' ? 'bg-green-100 text-green-800' : 
                              'bg-red-100 text-red-800'}">
                            <i class="fas ${app.status === 'Pending' ? 'fa-clock' : 
                                         app.status === 'Confirmed' ? 'fa-check-circle' : 
                                         'fa-times-circle'} mr-1"></i>
                            ${app.status}
                        </span>
                    </div>
                    <div class="text-sm text-blue-600">
                        <i class="far fa-calendar mr-1"></i> 
                        ${new Date(app.appointment_date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                    </div>
                </div>

                <!-- Patient Information -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3 text-lg">Patient Information</h3>
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-sm">
                            ${(app.user?.full_name || app.relative?.name || 'NA').substring(0, 2)}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-lg">${app.user?.full_name || app.relative?.name || 'Unknown'}</p>
                            <p class="text-gray-600">
                                <i class="fas fa-user-tag mr-1"></i>
                                ${bookedBy}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Consultation Details -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Time Slot</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>
                            ${formatConsultationTime(app.appointment_time)}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Consultation Type</p>
                        <p class="font-semibold text-gray-900">
                            <i class="fas fa-stethoscope mr-2 text-blue-500"></i>
                            ${app.for_user_type === 'self' ? 'Self Consultation' : 'Relative Consultation'}
                        </p>
                    </div>
                </div>

                <!-- Medical Information -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3 text-lg">Medical Details</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Primary Issue</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900">${app.issue || 'Not specified'}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Description</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900">${app.description || 'No additional description provided'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Set action buttons
        let actionsHTML = `
            <button onclick="closeConsultationModal()" 
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                Close
            </button>
        `;

        if (app.status === 'Pending') {
            actionsHTML += `
                <form method="POST" action="/employee/appointments/${app.appointment_id}/accept" class="inline">
                    @csrf @method('PUT')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to accept this consultation?')"
                            class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-lg transition-all duration-200">
                        Accept Consultation
                    </button>
                </form>
                <form method="POST" action="/employee/appointments/${app.appointment_id}/reject" class="inline">
                    @csrf @method('PUT')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to reject this consultation?')"
                            class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-medium rounded-lg transition-all duration-200">
                        Reject Consultation
                    </button>
                </form>
            `;
        }

        actionsDiv.innerHTML = actionsHTML;

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeConsultationModal() {
        const modal = document.getElementById('consultationModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeConsultationModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('consultationModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeConsultationModal();
        }
    });
</script>

@endsection