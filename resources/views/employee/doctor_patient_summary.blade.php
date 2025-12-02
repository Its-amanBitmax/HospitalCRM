@extends('layouts.doctor-dashboard')

@section('content')
<style>
    .tab-button {
        @apply px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-[1.02] shadow-sm;
    }
    
    .tab-button.active {
        @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg transform scale-[1.02];
    }
    
    .tab-content {
        @apply transition-all duration-300 ease-in-out;
    }
    
    .patient-card {
        @apply bg-gradient-to-br from-white to-gray-50 border border-gray-100 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300;
    }
    
    .info-badge {
        @apply px-3 py-1 rounded-full text-xs font-semibold;
    }
    
    .action-btn {
        @apply transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98];
    }
    
    .summary-section {
        @apply bg-gradient-to-br from-white to-gray-50 border border-gray-100 rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300;
    }
    
    .table-header {
        @apply bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200;
    }
    
    .table-row {
        @apply border-b border-gray-100 hover:bg-gradient-to-r from-blue-50/30 to-indigo-50/20 transition-all duration-200;
    }
</style>

<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white p-4 md:p-6">
    @if(session('success'))
    <div class="fixed top-4 right-4 z-50 animate-slideIn">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl shadow-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Topbar -->
    <div class="patient-card p-6 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 p-1">
                        @if($user->image)
                            <img src="{{ asset($user->image) }}" 
                                 alt="Patient" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white">
                        @else
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center">
                                <i class="fas fa-user text-3xl text-blue-600"></i>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                        <i class="fas fa-heartbeat text-white text-sm"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-3">
                        {{ $user->full_name }}
                        @if($user->gender)
                        <span class="text-sm px-3 py-1 rounded-full 
                            @if($user->gender == 'Male') bg-blue-100 text-blue-800 
                            @elseif($user->gender == 'Female') bg-pink-100 text-pink-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $user->gender }}
                        </span>
                        @endif
                    </h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        @if($user->age)
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 rounded-full text-sm">
                            <i class="fas fa-birthday-cake text-purple-600"></i>
                            {{ $user->age }} years
                        </span>
                        @endif
                        @if($user->blood_group)
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-red-100 to-red-200 text-red-800 rounded-full text-sm">
                            <i class="fas fa-tint text-red-600"></i>
                            Blood Group: {{ $user->blood_group }}
                        </span>
                        @endif
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-full text-sm">
                            <i class="fas fa-id-card text-green-600"></i>
                            ID: {{ $user->id_number ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('employee.doctor_patients') }}" 
                   class="group inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 font-medium shadow-sm hover:shadow-md">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Back to Patients</span>
                </a>
                <!-- <a href="{{ route('employee.users.checkups.create', $user->id) }}"
                   class="group inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                    <span>Add Checkup</span>
                </a> -->
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="patient-card p-6 mb-8">
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Patient Records</h2>
            <nav class="flex flex-wrap gap-3" aria-label="Tabs">
                <button onclick="showTab('summary')" id="summary-tab" 
                        class="tab-button flex items-center gap-3 bg-white border border-gray-200 text-gray-700 p-2 rounded-lg">
                    <i class="fas fa-clipboard-list text-lg"></i>
                    <span>Summary</span>
                </button>
                <button onclick="showTab('checkups')" id="checkups-tab" 
                        class="tab-button flex items-center gap-3 bg-white border border-gray-200 text-gray-700 p-2 rounded-lg">
                    <i class="fas fa-stethoscope text-lg"></i>
                    <span>Checkups ({{ $checkups->count() }})</span>
                </button>
                <button onclick="showTab('documents')" id="documents-tab" 
                        class="tab-button flex items-center gap-3 bg-white border border-gray-200 text-gray-700 p-2 rounded-lg">
                    <i class="fas fa-file-medical text-lg"></i>
                    <span>Documents ({{ $documents->count() }})</span>
                </button>
            </nav>
        </div>

        <!-- Summary Tab -->
        <div id="summary-content" class="tab-content space-y-8">
            <!-- Personal Information -->
            <div class="summary-section">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <i class="fas fa-user-circle text-blue-600"></i>
                        Personal Information
                    </h2>
                    <span class="text-sm text-gray-500">Updated: {{ $user->updated_at?->format('d M Y') ?? 'N/A' }}</span>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Contact Details -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-address-card text-indigo-600"></i>
                            Contact Details
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email Address</p>
                                    <p class="font-medium text-gray-900">{{ $user->email ?: 'Not provided' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone Number</p>
                                    <p class="font-medium text-gray-900">{{ $user->mobile_no ?: 'Not provided' }}</p>
                                </div>
                            </div>
                            
                            @if($user->alternate_no)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone-alt text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Alternate Phone</p>
                                    <p class="font-medium text-gray-900">{{ $user->alternate_no }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-green-600"></i>
                            Additional Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">Date of Birth</p>
                                <p class="font-medium text-gray-900">{{ $user->date_of_birth?->format('d M Y') ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">Emergency Contact</p>
                                <p class="font-medium text-gray-900">{{ $user->emergency_contact ?: 'N/A' }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">Father/Spouse</p>
                                <p class="font-medium text-gray-900">{{ $user->father_spouse_name ?: 'N/A' }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-gray-50 to-white p-4 rounded-xl border border-gray-100">
                                <p class="text-sm text-gray-500 mb-1">Registration Date</p>
                                <p class="font-medium text-gray-900">{{ $user->created_at?->format('d M Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-red-600"></i>
                        Address Information
                    </h3>
                    <div class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-xl border border-gray-100">
                        <p class="font-medium text-gray-900 mb-3">{{ $user->full_address ?: 'Address not provided' }}</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-city text-gray-400"></i>
                                <span class="text-gray-700">{{ $user->city ?: 'City not specified' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-landmark text-gray-400"></i>
                                <span class="text-gray-700">{{ $user->state ?: 'State not specified' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-mail-bulk text-gray-400"></i>
                                <span class="text-gray-700">{{ $user->pin_code ?: 'Pin code not specified' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Visits -->
            <div class="summary-section">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                        <i class="fas fa-history text-purple-600"></i>
                        Recent Visits
                    </h2>
                    <span class="text-sm text-gray-500">{{ $visits->count() }} total visits</span>
                </div>
                
                @if($visits->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($visits->take(2) as $visit)
                    <div class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 rounded-full text-sm font-medium">
                                        {{ $visit->visit_type }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $visit->date_of_visit?->format('d M Y') }}</span>
                                </div>
                                <h4 class="font-medium text-gray-900">{{ $visit->chief_complaint ?: 'No complaint mentioned' }}</h4>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-gray-500 mb-1">Referred By</p>
                                <p class="font-medium text-gray-900">{{ $visit->reception?->reception_id ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-gray-500 mb-1">Consultant</p>
                                <p class="font-medium text-gray-900">{{ $visit->consultantAssignment?->employee?->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">No visit history available</p>
                </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="summary-section">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-r from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-stethoscope text-blue-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $checkups->count() }}</p>
                            <p class="text-sm text-gray-500">Total Checkups</p>
                        </div>
                    </div>
                </div>
                
                <div class="summary-section">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-r from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-medical text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $documents->count() }}</p>
                            <p class="text-sm text-gray-500">Documents</p>
                        </div>
                    </div>
                </div>
                
                <div class="summary-section">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-r from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-history text-purple-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $visits->count() }}</p>
                            <p class="text-sm text-gray-500">Total Visits</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkups Tab -->
        <div id="checkups-content" class="tab-content hidden">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="fas fa-stethoscope text-blue-600"></i>
                    Medical Checkups
                    <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 rounded-full text-sm font-medium">
                        {{ $checkups->count() }} records
                    </span>
                </h2>
                <a href="{{ route('employee.users.checkups.create', $user->id) }}"
                   class="group inline-flex items-center gap-3 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                    <span>New Checkup</span>
                </a>
            </div>

            @if($checkups->count() > 0)
            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full">
                    <thead class="table-header">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Visit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Diagnosis</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Treatment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($checkups as $checkup)
                        <tr class="table-row hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/20">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-calendar-day text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $checkup->checkup_date?->format('d M Y') ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $checkup->created_at?->format('h:i A') ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($checkup->visit)
                                <div class="bg-gradient-to-r from-gray-50 to-white p-3 rounded-lg border border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ $checkup->visit->visit_type }}</p>
                                    <p class="text-xs text-gray-500">{{ $checkup->visit->date_of_visit?->format('d M Y') }}</p>
                                </div>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <p class="text-gray-900">{{ $checkup->diagnosis ?: '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <p class="text-gray-900">{{ $checkup->treatment ?: '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('employee.users.checkups.edit', [$user->id, $checkup->id]) }}" 
                                       class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 rounded-lg hover:from-blue-200 hover:to-blue-300 transition-all duration-200">
                                        <i class="fas fa-edit text-sm"></i>
                                        <span class="text-sm font-medium">Edit</span>
                                    </a>
                                    <form action="{{ route('employee.users.checkups.delete', [$user->id, $checkup->id]) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this checkup?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-100 to-red-200 text-red-700 rounded-lg hover:from-red-200 hover:to-red-300 transition-all duration-200">
                                            <i class="fas fa-trash text-sm"></i>
                                            <span class="text-sm font-medium">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-stethoscope text-blue-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No checkups yet</h3>
                <p class="text-gray-500 mb-6">Start by adding the patient's first medical checkup</p>
                <a href="{{ route('employee.users.checkups.create', $user->id) }}"
                   class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus"></i>
                    <span>Add First Checkup</span>
                </a>
            </div>
            @endif
        </div>

        <!-- Documents Tab -->
        <div id="documents-content" class="tab-content hidden">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="fas fa-file-medical text-green-600"></i>
                    Medical Documents
                    <span class="px-3 py-1 bg-gradient-to-r from-green-100 to-green-200 text-green-800 rounded-full text-sm font-medium">
                        {{ $documents->count() }} files
                    </span>
                </h2>
                <a href="{{ route('employee.users.documents.create', $user->id) }}" 
                   class="group inline-flex items-center gap-3 px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                    <span>Upload Document</span>
                </a>
            </div>

            @if($documents->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($documents as $document)
                <div class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-lg transition-all duration-300 group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-green-600 text-xl"></i>
                        </div>
                        <span class="text-xs text-gray-500">{{ $document->created_at?->format('d M Y') }}</span>
                    </div>
                    
                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-green-700 transition-colors">
                        {{ $document->document_type }}
                    </h3>
                    
                    <p class="text-sm text-gray-500 mb-4 truncate">
                        {{ basename($document->document_path) }}
                    </p>
                    
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <a href="/storage/{{ $document->document_path }}" 
                           target="_blank"
                           class="flex-1 action-btn inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-green-100 to-green-200 text-green-700 rounded-lg hover:from-green-200 hover:to-green-300 transition-all duration-200">
                            <i class="fas fa-eye"></i>
                           
                        </a>
                        <a href="/storage/{{ $document->document_path }}" 
                           download
                           class="flex-1 action-btn inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 rounded-lg hover:from-blue-200 hover:to-blue-300 transition-all duration-200">
                            <i class="fas fa-download"></i>
                            
                        </a>
                        <form action="{{ route('employee.users.documents.delete', [$user->id, $document->id]) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this document?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="action-btn inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-100 to-red-200 text-red-700 rounded-lg hover:from-red-200 hover:to-red-300 transition-all duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gradient-to-r from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-file-medical text-green-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No documents uploaded</h3>
                <p class="text-gray-500 mb-6">Upload medical documents like reports, prescriptions, etc.</p>
                <a href="{{ route('employee.users.documents.create', $user->id) }}"
                   class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-plus"></i>
                    <span>Upload First Document</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default tab to summary
        showTab('summary');
    });

    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'bg-blue-600', 'text-white');
            button.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-700');
        });

        // Show selected tab content
        const selectedContent = document.getElementById(tabName + '-content');
        if (selectedContent) {
            selectedContent.classList.remove('hidden');
        }

        // Add active class to selected tab button
        const selectedButton = document.getElementById(tabName + '-tab');
        if (selectedButton) {
            selectedButton.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-700');
            selectedButton.classList.add('active');
        }
    }

    // Auto-hide success message after 5 seconds
    setTimeout(() => {
        const successMessage = document.querySelector('[class*="bg-gradient-to-r from-green-500"]');
        if (successMessage) {
            successMessage.remove();
        }
    }, 5000);
</script>
@endsection