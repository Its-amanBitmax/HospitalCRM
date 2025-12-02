@extends('layouts.doctor-dashboard')

@section('title', 'Appointments')
@section('header-title', 'Appointments Management')

@section('content')
<style>
    .filter-btn-active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
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

    .appointment-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .appointment-card:hover {
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

    .modal-backdrop {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        animation: slideUp 0.3s ease-out;
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
</style>

@php
use Illuminate\Support\Str;
use Carbon\Carbon;

function displayTimeRange($time) {
    if (!$time) return '—';
    $parts = explode(' - ', $time);
    $start = trim($parts[0] ?? '');
    $end   = trim($parts[1] ?? '');
    $startF = $start ? Carbon::parse($start)->format('h:i A') : '';
    $endF   = $end ? Carbon::parse($end)->format('h:i A') : '';
    return $endF ? "$startF - $endF" : $startF;
}

$statuses = ['All', 'Pending', 'Confirmed', 'Cancelled'];
$currentStatus = request('status', 'All');
$today = Carbon::today()->format('Y-m-d');
$todayCount = \App\Models\Appointment::where('doctor_id', auth('doctor')->id())
    ->whereDate('appointment_date', $today)
    ->count();
@endphp

<div class="min-h-screen ">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Appointments Management</h1>
                <p class="text-gray-600">Manage and track all patient appointments</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-calendar-day mr-2"></i>
                    <span>{{ $todayCount }} today</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $confirmed }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pending }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Upcoming</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $upcoming->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Appointments List -->
        <div class="lg:col-span-2">
            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border mb-6">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Appointments</h2>
                    
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($statuses as $status)
                            <a href="{{ request()->fullUrlWithQuery(['status' => $status == 'All' ? null : $status]) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                               {{ $currentStatus == $status ? 
                                  'filter-btn-active' : 
                                  'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $status }}
                                @if($status == 'All')
                                    <span class="ml-1 text-xs">({{ $total }})</span>
                                @elseif($status == 'Pending')
                                    <span class="ml-1 text-xs">({{ $pending }})</span>
                                @elseif($status == 'Confirmed')
                                    <span class="ml-1 text-xs">({{ $confirmed }})</span>
                                @elseif($status == 'Cancelled')
                                    <span class="ml-1 text-xs">({{ $cancelled ?? 0 }})</span>
                                @endif
                            </a>
                        @endforeach
                    </div>

                    <!-- Date Filter -->
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                            <div class="flex gap-2">
                                <input type="date" 
                                       value="{{ request('date') }}" 
                                       onchange="window.location.href = '{{ request()->fullUrlWithQuery(['date' => '__DATE__']) }}'.replace('__DATE__', this.value)"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        @if(request('date') || request('status') != 'All')
                            <a href="{{ route('employee.doctor_appointments') }}"
                               class="self-end px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-medium transition-colors">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Appointments List -->
                <div class="p-4">
                    @if($allAppointments->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto w-20 h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No appointments found</h3>
                            <p class="text-gray-500 mb-4">
                                @if(request('status') != 'All')
                                    No {{ strtolower(request('status')) }} appointments
                                @elseif(request('date'))
                                    No appointments on selected date
                                @else
                                    No appointments scheduled yet
                                @endif
                            </p>
                            @if(request('status') != 'All' || request('date'))
                                <a href="{{ route('employee.doctor_appointments') }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                                    <i class="fas fa-calendar-alt"></i>
                                    View All Appointments
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($allAppointments as $app)
                                <div class="appointment-card bg-white rounded-xl border p-4">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                        <!-- Left Section: Patient Info -->
                                        <div class="flex items-start gap-4">
                                            <div class="relative">
                                                <div class="w-16 h-16 patient-avatar rounded-xl flex items-center justify-center text-lg">
                                                    {{ substr($app->user->full_name ?? $app->relative->name ?? 'NA', 0, 2) }}
                                                </div>
                                                @if($app->status == 'Pending')
                                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-500 rounded-full border-2 border-white flex items-center justify-center">
                                                        <i class="fas fa-clock text-xs text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                                    <h3 class="font-semibold text-gray-900">
                                                        {{ $app->user->full_name ?? $app->relative->name ?? 'Unknown' }}
                                                    </h3>
                                                    <span class="date-badge">
                                                        {{ Carbon::parse($app->appointment_date)->format('d M') }}
                                                    </span>
                                                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                        {{ $app->for_user_type === 'self' ? 'Self' : $app->relative->relation ?? 'Relative' }}
                                                    </span>
                                                </div>
                                                
                                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                                    <span class="inline-flex items-center gap-1">
                                                        <i class="fas fa-clock text-blue-500"></i>
                                                        {{ displayTimeRange($app->appointment_time) }}
                                                    </span>
                                                    <span class="inline-flex items-center gap-1">
                                                        <i class="fas fa-barcode text-gray-500"></i>
                                                        {{ $app->appointment_code }}
                                                    </span>
                                                    @if($app->issue)
                                                        <span class="inline-flex items-center gap-1">
                                                            <i class="fas fa-stethoscope text-green-500"></i>
                                                            {{ Str::limit($app->issue, 30) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Section: Status & Actions -->
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
                                                    @endif"></i>
                                                {{ $app->status }}
                                            </span>
                                            
                                            <div class="flex items-center gap-2">
                                                <button onclick='showAppointmentDetails(@json($app))'
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium">
                                                    <i class="fas fa-eye"></i>
                                                    View Details
                                                </button>
                                                
                                                @if($app->status == 'Pending')
                                                    <form method="POST" action="{{ route('employee.appointments.accept', $app->appointment_id) }}" class="inline">
                                                        @csrf @method('PUT')
                                                        <button type="submit" 
                                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium">
                                                            <i class="fas fa-check"></i>
                                                            Accept
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" action="{{ route('employee.appointments.reject', $app->appointment_id) }}" class="inline">
                                                        @csrf @method('PUT')
                                                        <button type="submit" 
                                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium">
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
                        
                        <!-- Pagination -->
                        @if($allAppointments->hasPages())
                            <div class="mt-6">
                                {{ $allAppointments->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="p-4 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Upcoming (Next 3 Days)</h3>
                        <span class="text-sm text-blue-600 font-medium">{{ $upcoming->count() }}</span>
                    </div>
                </div>
                
                <div class="p-4">
                    @if($upcoming->isEmpty())
                        <div class="text-center py-6">
                            <i class="fas fa-calendar-plus text-3xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500 text-sm">No upcoming appointments</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($upcoming->take(5) as $upcomingApp)
                                <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                                                {{ substr($upcomingApp->user->full_name ?? $upcomingApp->relative->name ?? 'NA', 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $upcomingApp->user->full_name ?? $upcomingApp->relative->name }}
                                            </p>
                                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                                <span>{{ Carbon::parse($upcomingApp->appointment_date)->format('d M') }}</span>
                                                <span>•</span>
                                                <span>{{ displayTimeRange($upcomingApp->appointment_time) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span>Today's Appointments</span>
                        <span class="font-bold">{{ $todayCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Confirmation Rate</span>
                        <span class="font-bold">{{ $total > 0 ? round(($confirmed/$total)*100, 1) : 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Pending Rate</span>
                        <span class="font-bold">{{ $total > 0 ? round(($pending/$total)*100, 1) : 0 }}%</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('employee.doctor_appointments') }}?date={{ $today }}"
                           class="p-3 bg-blue-50 hover:bg-blue-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-calendar-day text-blue-600 text-lg mb-1"></i>
                            <p class="text-sm font-medium text-gray-900">Today's</p>
                        </a>
                        
                        <a href="{{ route('employee.doctor_appointments') }}?status=Confirmed"
                           class="p-3 bg-green-50 hover:bg-green-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-check-circle text-green-600 text-lg mb-1"></i>
                            <p class="text-sm font-medium text-gray-900">Confirmed</p>
                        </a>
                        
                        <a href="{{ route('employee.doctor_appointments') }}?status=Pending"
                           class="p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-clock text-yellow-600 text-lg mb-1"></i>
                            <p class="text-sm font-medium text-gray-900">Pending</p>
                        </a>
                        
                        <a href="{{ route('employee.doctor_appointments') }}?status=Cancelled"
                           class="p-3 bg-red-50 hover:bg-red-100 rounded-lg text-center transition-colors">
                            <i class="fas fa-times-circle text-red-600 text-lg mb-1"></i>
                            <p class="text-sm font-medium text-gray-900">Cancelled</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Appointment Details -->
<div id="appointmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    <div class="modal-content relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-auto">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 text-white rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-alt text-xl"></i>
                        <h2 class="text-xl font-bold">Appointment Details</h2>
                    </div>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 text-2xl">&times;</button>
                </div>
            </div>
            
            <div class="p-6 space-y-6" id="appointmentDetails"></div>
            
            <div class="px-6 py-4 bg-gray-50 border-t rounded-b-2xl flex justify-end gap-3">
                <button onclick="closeModal()" 
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showAppointmentDetails(app) {
        const modal = document.getElementById('appointmentModal');
        const detailsDiv = document.getElementById('appointmentDetails');
        
        let timeDisplay = app.appointment_time;
        if (timeDisplay && timeDisplay.includes('-')) {
            // Format time if needed
        }

        detailsDiv.innerHTML = `
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Appointment Code</label>
                        <p class="font-semibold text-gray-900 text-lg">${app.appointment_code}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            ${app.status === 'Pending' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 
                              app.status === 'Confirmed' ? 'bg-green-100 text-green-800 border border-green-200' : 
                              'bg-red-100 text-red-800 border border-red-200'}">
                            <i class="fas ${app.status === 'Pending' ? 'fa-clock' : 
                                         app.status === 'Confirmed' ? 'fa-check-circle' : 
                                         'fa-times-circle'} mr-2"></i>
                            ${app.status}
                        </span>
                    </div>
                </div>
                
                <!-- Date & Time -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date</label>
                        <p class="font-semibold text-gray-900">${app.appointment_date}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Time Slot</label>
                        <p class="font-semibold text-gray-900">${timeDisplay}</p>
                    </div>
                </div>
                
                <!-- Patient Information -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-3">Patient Information</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold">
                            ${(app.user?.full_name || app.relative?.name || 'NA').substring(0, 2)}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">${app.user?.full_name || app.relative?.name || 'Unknown'}</p>
                            <p class="text-sm text-gray-600">${app.for_user_type === 'self' ? 'Self' : app.relative?.relation || 'Relative'}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Medical Details -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Medical Details</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Primary Issue</label>
                            <p class="text-gray-900">${app.issue || 'Not specified'}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                            <p class="text-gray-900">${app.description || 'No additional description provided'}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('appointmentModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>

@endsection