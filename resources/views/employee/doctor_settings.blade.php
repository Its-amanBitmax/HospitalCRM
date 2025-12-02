@extends('layouts.doctor-dashboard')

@section('title', 'My Profile')
@section('header-title', 'My Profile')

@section('content')
<style>
    .profile-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }
    
    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }
    
    .detail-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    
    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    
    .detail-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 20px;
    }
    
    .specialty-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        background: white;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .profile-avatar {
        width: 160px;
        height: 160px;
        border: 6px solid white;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
    
    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }
    
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .action-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        position: relative;
        overflow: hidden;
    }
    
    .activity-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    .activity-item:hover {
        transform: translateX(5px);
        border-left-color: #667eea;
        background: linear-gradient(90deg, #f8fafc, #ffffff);
    }
    
    .info-label {
        color: #6b7280;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .info-value {
        color: #111827;
        font-size: 15px;
        font-weight: 600;
    }
    
    .detail-item {
        border-bottom: 1px solid #f3f4f6;
        padding: 16px 0;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .qualification-item {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
    }
    
    .skill-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    
    .proficiency-badge {
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .proficiency-beginner {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .proficiency-intermediate {
        background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
        color: #1e40af;
    }
    
    .proficiency-advanced {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    
    .emergency-contact {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border: 1px solid #fbbf24;
        border-radius: 12px;
        padding: 16px;
    }
    
    .salary-card {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid #10b981;
        border-radius: 12px;
        padding: 16px;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fadeInUp {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .combined-details-card {
        grid-column: 1 / -1;
    }
    
    .document-item {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
    }
</style>

@php
use Carbon\Carbon;
use Illuminate\Support\Str;

$employee = auth('doctor')->user();

// Get employee relationships
$employeeId = $employee->id;

// Get qualifications from separate table
$qualifications = \App\Models\Qualification::where('employee_id', $employeeId)->get();

// Get skills/specialities from separate table



// Get addresses
$addresses = \App\Models\Address::where('employee_id', $employeeId)->get();

// Get documents
$documents = \App\Models\Document::where('employee_id', $employeeId)->get();

// Get salary details
$salaryDetails = \App\Models\Payroll::where('employee_id', $employeeId)->first();

// Get working schedule
$workingSchedules = \App\Models\Schedule::where('employee_id', $employeeId)
    ->whereDate('end_date', '>=', Carbon::today())
    ->orderBy('start_date')
    ->get();

// Get appointments count
$totalAppointments = \App\Models\Appointment::where('doctor_id', $employeeId)->count();
$todayAppointments = \App\Models\Appointment::where('doctor_id', $employeeId)
    ->whereDate('appointment_date', Carbon::today())
    ->count();

// Get unique patients count
$totalPatients = \App\Models\Appointment::where('doctor_id', $employeeId)
    ->distinct('booked_by_user_id')
    ->count();

// Get recent appointments
$recentAppointments = \App\Models\Appointment::with(['user', 'relative'])
    ->where('doctor_id', $employeeId)
    ->orderBy('appointment_date', 'desc')
    ->orderBy('appointment_time', 'desc')
    ->limit(5)
    ->get();

// Employee data
$fullName = $employee->full_name ?? $employee->name ?? 'N/A';
$email = $employee->email ?? 'Not provided';
$phone = $employee->phone ?? 'Not provided';
$image = $employee->image;
$employeeCode = $employee->employee_code ?? 'EMP-'.$employeeId;
$dateOfBirth = $employee->date_of_birth ?? null;
$gender = $employee->gender ?? 'Not specified';
$hireDate = $employee->hire_date ?? null;
$status = $employee->status ?? 'Active';
$departmentName = optional($employee->department)->department_name ?? 'Not assigned';
@endphp

<div class="min-h-screen">

    <!-- Header -->
    <div class="mb-8 animate-fadeInUp">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Professional Profile</h1>
                <p class="text-gray-600">View and manage your medical practice information</p>
            </div>

            <a href="{{route('employee.profile.settings')}}"
               class="group inline-flex items-center gap-3 px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <i class="fas fa-edit group-hover:rotate-12 transition-transform"></i>
                <span>Edit Profile</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Profile -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Header Card -->
            <div class="profile-card rounded-2xl shadow-xl border p-8 animate-fadeInUp">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <!-- Profile Image -->
                    <div class="relative">
                        <div class="profile-avatar rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600">
                            @if($image)
                                <img src="{{ Storage::url($image) }}"
                                     alt="{{ $fullName }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white text-5xl font-bold">
                                    {{ strtoupper(substr($fullName, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="absolute bottom-3 right-3 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full border-3 border-white flex items-center justify-center shadow-lg">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                            <div>
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                                    Dr. {{ $fullName }}
                                </h2>
                                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-4">
                                    <!--  -->
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 rounded-full text-sm font-medium shadow-sm">
                                        <i class="fas fa-id-badge"></i>
                                        ID: {{ $employeeCode }}
                                    </span>
                                </div>
                            </div>
                            <span class="status-badge inline-flex items-center gap-2 mt-4 md:mt-0 
                                @if($status == 'Active') bg-gradient-to-r from-green-500 to-emerald-600 text-white
                                @elseif($status == 'Inactive') bg-gradient-to-r from-red-500 to-pink-600 text-white
                                @else bg-gradient-to-r from-yellow-500 to-orange-600 text-white @endif">
                                <i class="fas fa-circle animate-pulse"></i>
                                {{ $status }}
                            </span>
                        </div>

                        <!-- Contact Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-envelope text-blue-600"></i>
                                <div class="text-left">
                                    <p class="info-label">Email</p>
                                    <p class="info-value">{{ $email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-phone text-green-600"></i>
                                <div class="text-left">
                                    <p class="info-label">Phone</p>
                                    <p class="info-value">{{ $phone }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bio/Department -->
                        <div class="bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Department</h3>
                                    <p class="text-gray-700">{{ $departmentName }}</p>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Hire Date</h3>
                                    <p class="text-gray-700">
                                        @if($hireDate)
                                            {{ Carbon::parse($hireDate)->format('d M Y') }}
                                        @else
                                            Not provided
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combined Personal Details & Working Schedule Card -->
            <div class="detail-card combined-details-card">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Personal Details -->
                    <div class="p-6 border-r border-gray-100">
                        <div class="detail-card-header mb-4">
                            <h3 class="text-lg font-bold flex items-center gap-2">
                                <i class="fas fa-user"></i>
                                Personal Details
                            </h3>
                        </div>
                        <div class="space-y-4">
                            <div class="detail-item">
                                <p class="info-label">Date of Birth</p>
                                <p class="info-value">
                                    @if($dateOfBirth)
                                        {{ Carbon::parse($dateOfBirth)->format('d M Y') }}
                                        ({{ Carbon::parse($dateOfBirth)->age }} years)
                                    @else
                                        Not provided
                                    @endif
                                </p>
                            </div>
                            
                            <div class="detail-item">
                                <p class="info-label">Gender</p>
                                <p class="info-value">{{ $gender }}</p>
                            </div>
                            
                            <!-- Address -->
                            @if($addresses->count() > 0)
                                @foreach($addresses as $address)
                                <div class="detail-item">
                                    <p class="info-label">{{ ucfirst($address->address_type) }} Address</p>
                                    <p class="info-value">{{ $address->street }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->postal_code }}
                                    </p>
                                </div>
                                @endforeach
                            @else
                            <div class="detail-item">
                                <p class="info-label">Address</p>
                                <p class="info-value">Not provided</p>
                            </div>
                            @endif
                            
                            <div class="detail-item">
                                <p class="info-label">Joined On</p>
                                <p class="info-value">
                                    @if($employee->created_at)
                                        {{ $employee->created_at->format('d M Y') }}
                                    @else
                                        Not available
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Working Schedule -->
                    <div class="p-6">
                        <div class="detail-card-header mb-4">
                            <h3 class="text-lg font-bold flex items-center gap-2">
                                <i class="fas fa-clock"></i>
                                Working Schedule
                            </h3>
                        </div>
                        <div class="space-y-4">
                            @if($workingSchedules->count() > 0)
                                @foreach($workingSchedules as $schedule)
                                <div class="detail-item">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="info-label">{{ ucfirst($schedule->task_type) }} Schedule</p>
                                            <p class="info-value">
                                                {{ Carbon::parse($schedule->start_date)->format('d M Y') }} 
                                                to 
                                                {{ Carbon::parse($schedule->end_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                            {{ Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ Carbon::parse($schedule->end_time)->format('h:i A') }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="text-center py-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500">No schedule assigned</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat-card rounded-xl border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="info-label mb-1">Total Patients</p>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalPatients }}</p>
                            <p class="text-xs text-gray-500">Unique patients</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-injured text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card rounded-xl border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="info-label mb-1">Total Appointments</p>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalAppointments }}</p>
                            <p class="text-xs text-gray-500">Today: {{ $todayAppointments }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-r from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card rounded-xl border p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="info-label mb-1">Experience</p>
                            <p class="text-3xl font-bold text-gray-900 mb-1">
                              
                            </p>
                            <p class="text-xs text-gray-500">Years</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-r from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-award text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

           

            <!-- Salary Details Card -->
            @if($salaryDetails)
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <i class="fas fa-money-bill-wave"></i>
                        Salary Details
                    </h3>
                </div>
                <div class="p-6">
                    <div class="salary-card">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-4">Bank Information</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Bank Name:</span>
                                        <span class="font-semibold">{{ $salaryDetails->bank_name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Account Number:</span>
                                        <span class="font-semibold font-mono">{{ $salaryDetails->bank_account ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">IFSC Code:</span>
                                        <span class="font-semibold font-mono">{{ $salaryDetails->ifsc_code ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">UPI Number:</span>
                                        <span class="font-semibold">{{ $salaryDetails->upi_number ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-4">Salary Information</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Monthly Salary:</span>
                                        <span class="font-semibold text-green-600">
                                            ₹{{ number_format($salaryDetails->salary, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">PF Number:</span>
                                        <span class="font-semibold">{{ $salaryDetails->pf_number ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Payment Frequency:</span>
                                        <span class="font-semibold">{{ $salaryDetails->payment_frequency ?? 'Monthly' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="action-card p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('employee.doctor_appointments') }}" 
                       class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <span>My Appointments</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="{{ route('employee.doctor_patients') }}" 
                       class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-injured"></i>
                            </div>
                            <span>My Patients</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="{{route('employee.report')}}" 
                       class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <span>Patient Reports</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="{{route('employee.profile.settings')}}" 
                       class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-cog"></i>
                            </div>
                            <span>Edit Profile</span>
                        </div>
                        <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Appointments -->
            <div class="bg-white rounded-xl shadow-lg border p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Recent Appointments</h3>
                    <span class="text-sm text-blue-600 font-medium">{{ $todayAppointments }} today</span>
                </div>
                <div class="space-y-3">
                    @forelse($recentAppointments as $appointment)
                    <div class="activity-item p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-md text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            @if($appointment->for_user_type == 'relative' && $appointment->relative)
                                                {{ optional($appointment->relative)->name ?? 'Relative' }}
                                            @else
                                                {{ optional($appointment->user)->full_name ?? 'Patient' }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ optional($appointment->user)->phone ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @if($appointment->status == 'Confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status == 'Pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $appointment->status }}
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <p class="text-xs text-gray-600">
                                        <i class="far fa-calendar mr-1"></i>
                                        {{ Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                        •
                                        {{ $appointment->appointment_time }}
                                    </p>
                                    @if($appointment->issue)
                                    <p class="text-xs text-gray-600 mt-1">
                                        <i class="far fa-comment mr-1"></i>
                                        {{ Str::limit($appointment->issue, 40) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-500">No recent appointments</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Contact Support -->
            <!-- <div class="bg-white rounded-xl shadow-lg border p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Support & Help</h3>
                <div class="space-y-3">
                    <a href="#" class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                        <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                        <div>
                            <p class="font-medium text-gray-900">Help Center</p>
                            <p class="text-xs text-gray-500">Get assistance</p>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                        <i class="fas fa-phone-alt text-green-600 text-xl"></i>
                        <div>
                            <p class="font-medium text-gray-900">Support Hotline</p>
                            <p class="text-xs text-gray-500">1800-123-4567</p>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                        <i class="fas fa-envelope text-purple-600 text-xl"></i>
                        <div>
                            <p class="font-medium text-gray-900">Email Support</p>
                            <p class="text-xs text-gray-500">support@hospital.com</p>
                        </div>
                    </a>
                </div>
            </div> -->
            
<div class="detail-card" >
                    <div class="detail-card-header">
                        <h3 class="text-lg font-bold flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            Documents
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($documents->count() > 0)
                            @foreach($documents as $document)
                                <div class="document-item">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $document->document_type }}</h4>
                                            <p class="text-sm text-gray-600">
                                                Uploaded: {{ Carbon::parse($document->uploaded_at)->format('d M Y') }}
                                            </p>
                                        </div>
                                        <a href="{{ Storage::url($document->document_path) }}" 
                                           target="_blank"
                                           class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                                            <i class="fas fa-eye mr-2"></i>View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-file-alt text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500">No documents uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>





<!-- Qualifications Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h3 class="text-lg font-bold flex items-center gap-2">
                            <i class="fas fa-graduation-cap"></i>
                            Qualifications
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($qualifications->count() > 0)
                            @foreach($qualifications as $qualification)
                                <div class="qualification-item">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $qualification->degree ?? 'Degree' }}</h4>
                                            <p class="text-sm text-gray-600">{{ $qualification->institution ?? 'Institution' }}</p>
                                        </div>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                            {{ $qualification->year_completed ?? 'Year' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-graduation-cap text-gray-400 text-xl"></i>
                                </div>
                                <p class="text-gray-500">No qualifications added</p>
                            </div>
                        @endif
                    </div>
                </div>


        </div>
    </div>
</div>

@endsection