@extends('layouts.doctor-dashboard')

@section('title', 'Patient Reports')
@section('header-title', 'Patient Reports Management')

@section('content')
<style>
    .report-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .report-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    .document-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .patient-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: bold;
    }

    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        transform: translateY(-1px);
    }

    /* Tab Styles */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    .tab-button {
        padding: 10px 20px;
        border: none;
        background: none;
        cursor: pointer;
        font-weight: 500;
        color: #6b7280;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .tab-button:hover {
        color: #4f46e5;
        background-color: #f3f4f6;
    }

    .tab-button.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
        background-color: #f0f9ff;
    }

    .tabs-container {
        border-bottom: 1px solid #e5e7eb;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
    
    // Group reports by document type
    $allReports = $reports;
    $labReports = $reports->where('document_type', 'Lab Report');
    $prescriptionReports = $reports->where('document_type', 'Prescription');
    $scanReports = $reports->whereIn('document_type', ['X-Ray', 'CT Scan', 'MRI', 'Ultrasound']);
    $otherReports = $reports->whereNotIn('document_type', ['Lab Report', 'Prescription', 'X-Ray', 'CT Scan', 'MRI', 'Ultrasound']);
    
    // Document types for filters
    $documentTypes = $reports->pluck('document_type')->unique()->sort();
@endphp

<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white p-4 md:p-6">

    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Patient Reports & Documents</h1>
                <p class="text-gray-600">Manage and access all patient medical reports and documents</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('employee.doctor_patients') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg">
                    <i class="fas fa-arrow-left"></i>
                    Back to Patients
                </a>
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-lg shadow-md">
                    <i class="fas fa-file-alt mr-2"></i>
                    <span>{{ $reports->count() }} documents</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Documents</p>
                    <p class="text-3xl font-bold">{{ $reports->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-white/20">
                <div class="text-xs text-blue-200">All patient documents</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Lab Reports</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $labReports->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-vial text-blue-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-blue-600 font-medium">
                Test results
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Prescriptions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $prescriptionReports->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-prescription text-green-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-green-600 font-medium">
                Medication orders
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Today's Uploads</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $reports->where('created_at', '>=', Carbon::today())->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cloud-upload-alt text-purple-600 text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-purple-600 font-medium">
                {{ Carbon::today()->format('d M Y') }}
            </div>
        </div>
    </div>

    <!-- Main Content with Tabs -->
    <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <div class="flex overflow-x-auto">
                <button class="tab-button active" data-tab="all">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-list"></i>
                        All Documents
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">
                            {{ $allReports->count() }}
                        </span>
                    </span>
                </button>
                <button class="tab-button" data-tab="lab">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-vial"></i>
                        Lab Reports
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full">
                            {{ $labReports->count() }}
                        </span>
                    </span>
                </button>
                <button class="tab-button" data-tab="prescriptions">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-prescription"></i>
                        Prescriptions
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">
                            {{ $prescriptionReports->count() }}
                        </span>
                    </span>
                </button>
                <button class="tab-button" data-tab="scans">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-x-ray"></i>
                        Scans & Imaging
                        <span class="bg-purple-100 text-purple-800 text-xs px-2 py-0.5 rounded-full">
                            {{ $scanReports->count() }}
                        </span>
                    </span>
                </button>
                <button class="tab-button" data-tab="other">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-file-medical"></i>
                        Medical Documents
                        <span class="bg-gray-100 text-gray-800 text-xs px-2 py-0.5 rounded-full">
                            {{ $otherReports->count() }}
                        </span>
                    </span>
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">
            <!-- All Documents Tab Content (Active by default) -->
            <div id="all-tab" class="tab-content active">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">All Patient Documents</h2>
                            <p class="text-sm text-gray-600 mt-1">View all medical documents for your patients</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <input type="text" id="searchAll" 
                                       placeholder="Search documents..."
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- All Documents List -->
                @if($allReports->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-file-alt text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No documents found</h3>
                        <p class="text-gray-500">There are no medical reports or documents available for your patients yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($allReports as $report)
                            <div class="report-card bg-white rounded-xl border p-5">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <!-- Document Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="relative">
                                            <div class="w-16 h-16 rounded-xl flex items-center justify-center 
                                                @if($report->document_type == 'Lab Report') bg-blue-100 text-blue-600
                                                @elseif($report->document_type == 'Prescription') bg-green-100 text-green-600
                                                @elseif(in_array($report->document_type, ['X-Ray', 'CT Scan', 'MRI', 'Ultrasound'])) bg-purple-100 text-purple-600
                                                @else bg-gray-100 text-gray-600 @endif">
                                                <i class="text-2xl 
                                                    @if($report->document_type == 'Lab Report') fas fa-vial
                                                    @elseif($report->document_type == 'Prescription') fas fa-prescription
                                                    @elseif(in_array($report->document_type, ['X-Ray', 'CT Scan', 'MRI', 'Ultrasound'])) fas fa-x-ray
                                                    @else fas fa-file-medical @endif"></i>
                                            </div>
                                            @if($report->created_at->isToday())
                                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-star text-xs text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                                <h3 class="font-semibold text-gray-900 text-lg">
                                                    {{ optional($report->user)->full_name ?? 'Unknown Patient' }}
                                                </h3>
                                                <span class="document-badge 
                                                    @if($report->document_type == 'Lab Report') bg-blue-50 text-blue-800 border border-blue-200
                                                    @elseif($report->document_type == 'Prescription') bg-green-50 text-green-800 border border-green-200
                                                    @elseif(in_array($report->document_type, ['X-Ray', 'CT Scan', 'MRI', 'Ultrasound'])) bg-purple-50 text-purple-800 border border-purple-200
                                                    @else bg-gray-50 text-gray-800 border border-gray-200 @endif">
                                                    <i class="fas 
                                                        @if($report->document_type == 'Lab Report') fa-vial
                                                        @elseif($report->document_type == 'Prescription') fa-prescription
                                                        @elseif(in_array($report->document_type, ['X-Ray', 'CT Scan', 'MRI', 'Ultrasound'])) fa-x-ray
                                                        @else fa-file-medical @endif mr-1"></i>
                                                    {{ $report->document_type }}
                                                </span>
                                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ $report->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-file-alt text-blue-500"></i>
                                                    <span class="truncate">
                                                        <strong>File:</strong> {{ basename($report->document_path) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-clock text-green-500"></i>
                                                    <span>Time: <strong>{{ $report->created_at->format('h:i A') }}</strong></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-md text-purple-500"></i>
                                                    <span>Uploaded by: <strong>{{ auth('doctor')->user()->name ?? 'System' }}</strong></span>
                                                </div>
                                            </div>
                                            
                                            @if($report->notes)
                                                <div class="mt-3 pt-3 border-t border-gray-100">
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fas fa-sticky-note text-yellow-500 mr-1"></i>
                                                        <strong>Notes:</strong> {{ Str::limit($report->notes, 100) }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end gap-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               download
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-download"></i>
                                                Download
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('employee.users.documents.delete', [$report->user_id, $report->id]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($report->document_type) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Lab Reports Tab Content -->
            <div id="lab-tab" class="tab-content">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Lab Reports</h2>
                            <p class="text-sm text-gray-600 mt-1">Laboratory test results and analysis</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            Showing {{ $labReports->count() }} lab reports
                        </div>
                    </div>
                </div>
                
                <!-- Lab Reports List -->
                @if($labReports->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-vial text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No lab reports found</h3>
                        <p class="text-gray-500">No laboratory test results are available for your patients yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($labReports as $report)
                            <div class="report-card bg-white rounded-xl border p-5">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <!-- Document Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="relative">
                                            <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-blue-100 text-blue-600">
                                                <i class="fas fa-vial text-2xl"></i>
                                            </div>
                                            @if($report->created_at->isToday())
                                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-star text-xs text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                                <h3 class="font-semibold text-gray-900 text-lg">
                                                    {{ optional($report->user)->full_name ?? 'Unknown Patient' }}
                                                </h3>
                                                <span class="document-badge bg-blue-50 text-blue-800 border border-blue-200">
                                                    <i class="fas fa-vial mr-1"></i>
                                                    Lab Report
                                                </span>
                                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ $report->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-file-alt text-blue-500"></i>
                                                    <span class="truncate">
                                                        <strong>File:</strong> {{ basename($report->document_path) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-clock text-green-500"></i>
                                                    <span>Time: <strong>{{ $report->created_at->format('h:i A') }}</strong></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-md text-purple-500"></i>
                                                    <span>Uploaded by: <strong>{{ auth('doctor')->user()->name ?? 'System' }}</strong></span>
                                                </div>
                                            </div>
                                            
                                            @if($report->notes)
                                                <div class="mt-3 pt-3 border-t border-gray-100">
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fas fa-sticky-note text-yellow-500 mr-1"></i>
                                                        <strong>Notes:</strong> {{ Str::limit($report->notes, 100) }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end gap-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               download
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-download"></i>
                                                Download
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('employee.users.documents.delete', [$report->user_id, $report->id]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirmDelete(event, 'Lab Report')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Prescriptions Tab Content -->
            <div id="prescriptions-tab" class="tab-content">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Prescriptions</h2>
                            <p class="text-sm text-gray-600 mt-1">Medication orders and prescriptions</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            Showing {{ $prescriptionReports->count() }} prescriptions
                        </div>
                    </div>
                </div>
                
                <!-- Prescriptions List -->
                @if($prescriptionReports->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-prescription text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No prescriptions found</h3>
                        <p class="text-gray-500">No medication prescriptions are available for your patients yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($prescriptionReports as $report)
                            <div class="report-card bg-white rounded-xl border p-5">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <!-- Document Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="relative">
                                            <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-green-100 text-green-600">
                                                <i class="fas fa-prescription text-2xl"></i>
                                            </div>
                                            @if($report->created_at->isToday())
                                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-star text-xs text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                                <h3 class="font-semibold text-gray-900 text-lg">
                                                    {{ optional($report->user)->full_name ?? 'Unknown Patient' }}
                                                </h3>
                                                <span class="document-badge bg-green-50 text-green-800 border border-green-200">
                                                    <i class="fas fa-prescription mr-1"></i>
                                                    Prescription
                                                </span>
                                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ $report->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-file-alt text-blue-500"></i>
                                                    <span class="truncate">
                                                        <strong>File:</strong> {{ basename($report->document_path) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-clock text-green-500"></i>
                                                    <span>Time: <strong>{{ $report->created_at->format('h:i A') }}</strong></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-md text-purple-500"></i>
                                                    <span>Uploaded by: <strong>{{ auth('doctor')->user()->name ?? 'System' }}</strong></span>
                                                </div>
                                            </div>
                                            
                                            @if($report->notes)
                                                <div class="mt-3 pt-3 border-t border-gray-100">
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fas fa-sticky-note text-yellow-500 mr-1"></i>
                                                        <strong>Notes:</strong> {{ Str::limit($report->notes, 100) }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end gap-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               download
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-download"></i>
                                                Download
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('employee.users.documents.delete', [$report->user_id, $report->id]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirmDelete(event, 'Prescription')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Scans Tab Content -->
            <div id="scans-tab" class="tab-content">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Scans & Imaging</h2>
                            <p class="text-sm text-gray-600 mt-1">X-Ray, CT Scan, MRI and Ultrasound reports</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            Showing {{ $scanReports->count() }} scans
                        </div>
                    </div>
                </div>
                
                <!-- Scans List -->
                @if($scanReports->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-x-ray text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No scan reports found</h3>
                        <p class="text-gray-500">No imaging or scan reports are available for your patients yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($scanReports as $report)
                            <div class="report-card bg-white rounded-xl border p-5">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <!-- Document Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="relative">
                                            <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-purple-100 text-purple-600">
                                                <i class="fas fa-x-ray text-2xl"></i>
                                            </div>
                                            @if($report->created_at->isToday())
                                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-star text-xs text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                                <h3 class="font-semibold text-gray-900 text-lg">
                                                    {{ optional($report->user)->full_name ?? 'Unknown Patient' }}
                                                </h3>
                                                <span class="document-badge bg-purple-50 text-purple-800 border border-purple-200">
                                                    <i class="fas fa-x-ray mr-1"></i>
                                                    {{ $report->document_type }}
                                                </span>
                                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ $report->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-file-alt text-blue-500"></i>
                                                    <span class="truncate">
                                                        <strong>File:</strong> {{ basename($report->document_path) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-clock text-green-500"></i>
                                                    <span>Time: <strong>{{ $report->created_at->format('h:i A') }}</strong></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-md text-purple-500"></i>
                                                    <span>Uploaded by: <strong>{{ auth('doctor')->user()->name ?? 'System' }}</strong></span>
                                                </div>
                                            </div>
                                            
                                            @if($report->notes)
                                                <div class="mt-3 pt-3 border-t border-gray-100">
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fas fa-sticky-note text-yellow-500 mr-1"></i>
                                                        <strong>Notes:</strong> {{ Str::limit($report->notes, 100) }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end gap-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               download
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-download"></i>
                                                Download
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('employee.users.documents.delete', [$report->user_id, $report->id]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($report->document_type) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Other Documents Tab Content -->
            <div id="other-tab" class="tab-content">
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Medical Documents</h2>
                            <p class="text-sm text-gray-600 mt-1">Additional medical documents and reports</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            Showing {{ $otherReports->count() }} Medical documents
                        </div>
                    </div>
                </div>
                
                <!-- Other Documents List -->
                @if($otherReports->isEmpty())
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-file-medical text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No other documents found</h3>
                        <p class="text-gray-500">No additional medical documents are available for your patients yet.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($otherReports as $report)
                            <div class="report-card bg-white rounded-xl border p-5">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <!-- Document Info -->
                                    <div class="flex items-start gap-4 flex-1">
                                        <div class="relative">
                                            <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-gray-100 text-gray-600">
                                                <i class="fas fa-file-medical text-2xl"></i>
                                            </div>
                                            @if($report->created_at->isToday())
                                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-star text-xs text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                                <h3 class="font-semibold text-gray-900 text-lg">
                                                    {{ optional($report->user)->full_name ?? 'Unknown Patient' }}
                                                </h3>
                                                <span class="document-badge bg-gray-50 text-gray-800 border border-gray-200">
                                                    <i class="fas fa-file-medical mr-1"></i>
                                                    {{ $report->document_type }}
                                                </span>
                                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    {{ $report->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-file-alt text-blue-500"></i>
                                                    <span class="truncate">
                                                        <strong>File:</strong> {{ basename($report->document_path) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-clock text-green-500"></i>
                                                    <span>Time: <strong>{{ $report->created_at->format('h:i A') }}</strong></span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-md text-purple-500"></i>
                                                    <span>Uploaded by: <strong>{{ auth('doctor')->user()->name ?? 'System' }}</strong></span>
                                                </div>
                                            </div>
                                            
                                            @if($report->notes)
                                                <div class="mt-3 pt-3 border-t border-gray-100">
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fas fa-sticky-note text-yellow-500 mr-1"></i>
                                                        <strong>Notes:</strong> {{ Str::limit($report->notes, 100) }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end gap-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                            
                                            <a href="{{ asset('storage/' . $report->document_path) }}" 
                                               download
                                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-download"></i>
                                                Download
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('employee.users.documents.delete', [$report->user_id, $report->id]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($report->document_type) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 text-sm font-medium shadow-md hover:shadow-lg">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Document Types Distribution -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-blue-500"></i>
                Document Types Distribution
            </h3>
            <div class="space-y-4">
                @foreach($documentTypes->take(5) as $type)
                @php
                    $count = $reports->where('document_type', $type)->count();
                    $percentage = $reports->count() > 0 ? round(($count/$reports->count())*100, 1) : 0;
                @endphp
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm text-gray-600 truncate">{{ $type }}</span>
                        <span class="text-sm font-semibold text-blue-600">{{ $count }} ({{ $percentage }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full bg-blue-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        <!-- <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </h3>
            <div class="space-y-3">
                <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-upload"></i>
                        </div>
                        <span>Upload New Document</span>
                    </div>
                    <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-print"></i>
                        </div>
                        <span>Print Reports</span>
                    </div>
                    <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#" class="flex items-center justify-between p-3 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-200 group">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <span>Share Documents</span>
                    </div>
                    <i class="fas fa-chevron-right opacity-70 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div> -->

        <!-- Recent Uploads -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-history text-purple-500"></i>
                Recent Uploads
            </h3>
            <div class="space-y-3">
                @foreach($reports->take(3) as $recent)
                <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ optional($recent->user)->full_name ?? 'Patient' }}
                        </p>
                        <p class="text-xs text-gray-500 flex items-center gap-2 mt-1">
                            <span class="truncate">{{ $recent->document_type }}</span>
                            <span>•</span>
                            <span>{{ $recent->created_at->format('h:i A') }}</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Tab Switching Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Get all tab buttons and content areas
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        // Function to switch tabs
        function switchTab(tabId) {
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });
            
            // Show the selected tab content
            const activeContent = document.getElementById(`${tabId}-tab`);
            if (activeContent) {
                activeContent.classList.add('active');
            }
            
            // Add active class to clicked tab button
            const activeButton = document.querySelector(`.tab-button[data-tab="${tabId}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }
            
            // Save active tab to localStorage
            localStorage.setItem('activeReportTab', tabId);
        }
        
        // Add click event to all tab buttons
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                switchTab(tabId);
            });
        });
        
        // Check if there's a saved active tab
        const savedTab = localStorage.getItem('activeReportTab');
        if (savedTab) {
            switchTab(savedTab);
        }
        
        // Search functionality for All tab
        const searchInput = document.getElementById('searchAll');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const cards = document.querySelectorAll('#all-tab .report-card');
                
                cards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });
    
    // Delete confirmation function
    function confirmDelete(event, documentType) {
        if (!confirm(`Are you sure you want to delete this ${documentType}? This action cannot be undone.`)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>

@endsection