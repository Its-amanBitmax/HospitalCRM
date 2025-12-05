@extends('layouts.receptionist')

@section('content')

<div class="min-h-screen bg-gradient-to-br">

    <!-- Header with gradient -->
    <div class="  shadow-2xl rounded-2xl p-6 mb-8 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                <i class="fas fa-user-tie  text-4xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold ">Receptionist Dashboard</h1>
                <p class="text-blue-400">Welcome back! Here's your daily overview</p>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="text-right">
                <p class=" font-medium">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
                <p class="text-blue-400 text-sm">Last updated: {{ \Carbon\Carbon::now()->format('g:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Appointments -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-blue-50 p-3 rounded-xl">
                        <i class="fas fa-calendar-check text-blue-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-800">Total</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Appointments</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $totalAppointments }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-chart-line mr-1 text-green-500"></i>
                    <span>All time records</span>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-green-50 p-3 rounded-xl">
                        <i class="fas fa-clock text-green-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-800">Today</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Appointments</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $todayAppointments }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-calendar-day mr-1 text-blue-500"></i>
                    <span>{{ \Carbon\Carbon::now()->format('M d') }}</span>
                </div>
            </div>
        </div>

        <!-- Patient Visits -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-purple-50 p-3 rounded-xl">
                        <i class="fas fa-hospital-user text-purple-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 text-purple-800">Active</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Patient Visits</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $todayVisits }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-user-injured mr-1 text-purple-500"></i>
                    <span>Today's check-ins</span>
                </div>
            </div>
        </div>

        <!-- Reception Count -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-600"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-amber-50 p-3 rounded-xl">
                        <i class="fas fa-user-tie text-amber-600 text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-800">Team</span>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-1">Reception Staff</p>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $receptionCount }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <i class="fas fa-users mr-1 text-amber-500"></i>
                    <span>Available personnel</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Assigned Reception -->
        <div class="lg:col-span-1">
            <!-- Assigned Reception Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-red-500 to-rose-600 p-5">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-id-card-alt text-white text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Your Station</h2>
                    </div>
                </div>
                <div class="p-6">
                    @if($assignedReception)
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-red-100 to-rose-100 border-4 border-white shadow-lg mb-4">
                                <i class="fas fa-user-tie text-red-600 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $assignedReception->employee->name ?? 'N/A' }}</h3>
                            <p class="text-gray-500">Receptionist</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-red-100 p-2 rounded-lg">
                                        <i class="fas fa-id-badge text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Reception ID</p>
                                        <p class="font-semibold text-gray-800">{{ $assignedReception->reception_id }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-lg">
                                        <i class="fas fa-calendar-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Shift Today</p>
                                        <p class="font-semibold text-gray-800">9:00 AM - 5:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 border-4 border-white shadow-lg mb-4">
                                <i class="fas fa-exclamation-triangle text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">No Station Assigned</h3>
                            <p class="text-gray-500 mb-4">Please contact administration to get assigned to a reception station.</p>
                            <button class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-4 py-2 rounded-lg font-medium hover:shadow-lg transition-shadow">
                                <i class="fas fa-headset mr-2"></i> Contact Admin
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            
           
        </div>

        <!-- Right Column: Tables -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Appointments Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200">
                    <div class="flex items-center justify-between p-5">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-50 p-2 rounded-lg">
                                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Recent Appointments</h2>
                        </div>
                        <a href="{{route('receptionist.appointments')}}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                            View All <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Doctor</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentAppointments as $apt)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $apt->relative->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ $apt->doctor->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">Cardiology</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $apt->appointment_time }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = 'upcoming';
                                        $statusColor = 'bg-blue-100 text-blue-800';
                                    @endphp
                                    @if(\Carbon\Carbon::parse($apt->appointment_date)->isPast())
                                        @php $status = 'completed'; $statusColor = 'bg-green-100 text-green-800'; @endphp
                                    @elseif(\Carbon\Carbon::parse($apt->appointment_date)->isToday())
                                        @php $status = 'today'; $statusColor = 'bg-amber-100 text-amber-800'; @endphp
                                    @endif
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-calendar-times text-3xl mb-2"></i>
                                        <p class="text-sm">No appointments found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Patients Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200">
                    <div class="flex items-center justify-between p-5">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-50 p-2 rounded-lg">
                                <i class="fas fa-users text-green-600 text-xl"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Recent Patient Visits</h2>
                        </div>
                        <a href="{{route('receptionist.patients')}}" class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
                            View All <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Visit Details</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentPatients as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 flex items-center justify-center">
                                            <span class="font-semibold text-green-800">{{ substr($p->user->full_name ?? 'N/A', 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $p->user->full_name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500">Patient ID: #{{ $p->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ $p->user->mobile_no ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-envelope mr-1"></i> {{ $p->user->email ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($p->date_of_visit)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->visit_type ?? 'General Checkup' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-lg transition-colors">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-user-slash text-3xl mb-2"></i>
                                        <p class="text-sm">No patient visits found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   

</div>

@endsection