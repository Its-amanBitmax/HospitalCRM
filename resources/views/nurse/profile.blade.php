@extends('layouts.nursionist')

@section('content')
<div class="px-4 py-6">
    <!-- Header with Profile Summary -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-6">
            <!-- Profile Image -->
            <div class="relative mb-4 md:mb-0">
                <div class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                    {{ strtoupper(substr($nurse->name, 0, 1)) }}
                </div>
                @if($nurse->status === 'Active')
                <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
                @endif
            </div>

            <!-- Profile Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-2xl font-bold text-gray-800">{{ $nurse->name }}</h1>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-id-badge mr-1"></i> {{ $nurse->employee_code ?? 'N/A' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $nurse->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        <i class="fas fa-circle mr-1 text-xs"></i> {{ $nurse->status }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-building mr-1"></i> {{ $nurse->department->name ?? 'N/A' }}
                    </span>
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">
                            @if($nurse->payroll)
                            ₹{{ number_format($nurse->payroll->salary) }}
                            @else
                            N/A
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">Monthly Salary</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $nurse->familyDetails->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Family Members</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $nurse->qualifications->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Qualifications</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $nurse->shifts->count() ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Active Shifts</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Profile Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Contact & Personal Info -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-5 border-b bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-lg">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center">
                        <i class="fas fa-address-card mr-2 text-blue-600"></i> Contact & Personal Information
                    </h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-envelope text-blue-500"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Email</div>
                                    <div class="font-medium text-gray-800">{{ $nurse->email }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-green-500"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Phone</div>
                                    <div class="font-medium text-gray-800">{{ $nurse->phone ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-birthday-cake text-purple-500"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Date of Birth</div>
                                    <div class="font-medium text-gray-800">{{ $nurse->date_of_birth ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-pink-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-venus-mars text-pink-500"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Gender</div>
                                    <div class="font-medium text-gray-800">{{ $nurse->gender ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-alt text-orange-500"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Hire Date</div>
                                    <div class="font-medium text-gray-800">{{ $nurse->hire_date ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-teal-50 flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-teal-500"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Employee Since</div>
                                    <div class="font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($nurse->created_at)->format('d M, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-5 border-b bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-lg">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i> Address Information
                    </h3>
                </div>
                <div class="p-5">
                    @if($nurse->addresses && $nurse->addresses->count() > 0)
                        <div class="space-y-4">
                            @foreach($nurse->addresses as $address)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-2">
                                        <i class="fas fa-home text-red-500 text-sm"></i>
                                    </div>
                                    <h4 class="font-medium text-gray-800">{{ ucfirst($address->address_type) }} Address</h4>
                                </div>
                                <div class="space-y-2">
                                    @if($address->street)
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-road text-gray-400 w-5"></i>
                                        <span class="ml-2 text-sm">{{ $address->street }}</span>
                                    </div>
                                    @endif
                                    @if($address->city || $address->state || $address->country)
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-city text-gray-400 w-5"></i>
                                        <span class="ml-2 text-sm">
                                            {{ implode(', ', array_filter([$address->city, $address->state, $address->country])) }}
                                        </span>
                                    </div>
                                    @endif
                                    @if($address->postal_code)
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-mail-bulk text-gray-400 w-5"></i>
                                        <span class="ml-2 text-sm">PIN: {{ $address->postal_code }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-map-marked-alt text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No address found</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Qualifications -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-5 border-b bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-t-lg">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center justify-between">
                        <span><i class="fas fa-graduation-cap mr-2 text-indigo-600"></i> Qualifications</span>
                        @if($nurse->qualifications->count() > 0)
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-3 py-1 rounded-full">
                            {{ $nurse->qualifications->count() }}
                        </span>
                        @endif
                    </h3>
                </div>
                <div class="p-5">
                    @if($nurse->qualifications && $nurse->qualifications->count() > 0)
                        <div class="space-y-3">
                            @foreach($nurse->qualifications as $qualification)
                            <div class="border-l-4 border-indigo-500 pl-4 py-3 hover:bg-indigo-50 rounded-r">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="font-medium text-gray-800">{{ $qualification->degree ?? 'Qualification' }}</h5>
                                        @if($qualification->institution)
                                        <p class="text-sm text-gray-600 mt-1">{{ $qualification->institution }}</p>
                                        @endif
                                    </div>
                                    @if($qualification->year)
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                        {{ $qualification->year }}
                                    </span>
                                    @endif
                                </div>
                                @if($qualification->grade || $qualification->field_of_study)
                                <div class="flex items-center mt-2 space-x-3">
                                    @if($qualification->grade)
                                    <span class="inline-flex items-center text-xs text-gray-600">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i> Grade: {{ $qualification->grade }}
                                    </span>
                                    @endif
                                    @if($qualification->field_of_study)
                                    <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                        {{ $qualification->field_of_study }}
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-graduation-cap text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No qualifications found</p>
                        </div>
                    @endif
                </div>
            </div>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profession -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-5 border-b bg-gradient-to-r from-orange-50 to-orange-100 rounded-t-lg">
                        <h3 class="font-bold text-gray-800 text-lg flex items-center">
                            <i class="fas fa-briefcase mr-2 text-orange-600"></i> Profession
                        </h3>
                    </div>
                    <div class="p-5">
                        @if($nurse->professions && $nurse->professions->count() > 0)
                            <div class="space-y-2">
                                @foreach($nurse->professions as $profession)
                                <div class="bg-orange-50 rounded-lg p-3">
                                    <div class="font-medium text-gray-800">{{ $profession->title }}</div>
                                    @if($profession->department)
                                    <div class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-building mr-1"></i> {{ $profession->department->name }}
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i class="fas fa-user-md text-gray-300 text-2xl mb-2"></i>
                                <p class="text-gray-500 text-sm">No profession details</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-5 border-b bg-gradient-to-r from-teal-50 to-teal-100 rounded-t-lg">
                        <h3 class="font-bold text-gray-800 text-lg flex items-center justify-between">
                            <span><i class="fas fa-file-alt mr-2 text-teal-600"></i> Documents</span>
                            @if($nurse->documents->count() > 0)
                            <span class="bg-teal-100 text-teal-800 text-xs px-2 py-1 rounded-full">
                                {{ $nurse->documents->count() }}
                            </span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-5">
                        @if($nurse->documents && $nurse->documents->count() > 0)
                            <div class="space-y-2">
                                @foreach($nurse->documents as $document)
                                <div class="flex items-center justify-between p-2 hover:bg-teal-50 rounded">
                                    <div class="flex items-center">
                                        @php
                                            $extension = pathinfo($document->document_path, PATHINFO_EXTENSION);
                                            $icon = 'fa-file text-gray-500';
                                            if($extension === 'pdf') $icon = 'fa-file-pdf text-red-500';
                                            elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'fa-file-image text-green-500';
                                            elseif(in_array($extension, ['doc', 'docx'])) $icon = 'fa-file-word text-blue-500';
                                        @endphp
                                        <i class="fas {{ $icon }} mr-3"></i>
                                        <div>
                                            <div class="text-sm font-medium text-gray-800">{{ $document->document_type }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($document->uploaded_at)->format('d M, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    @if($document->document_path)
                                    <a href="{{ asset('storage/' . $document->document_path) }}" 
                                       target="_blank"
                                       class="text-teal-600 hover:text-teal-800 text-sm">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i class="fas fa-file-alt text-gray-300 text-2xl mb-2"></i>
                                <p class="text-gray-500 text-sm">No documents found</p>
                            </div>
                        @endif
                    </div>
                </div>
               
            </div>

        </div>
        

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Financial Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-5 border-b bg-gradient-to-r from-green-50 to-green-100 rounded-t-lg">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center">
                        <i class="fas fa-wallet mr-2 text-green-600"></i> Financial Information
                    </h3>
                </div>
                <div class="p-5">
                    @if($nurse->payroll)
                        <div class="space-y-4">
                            <!-- Salary Highlight -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border border-green-100">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="text-sm text-gray-600">Monthly Salary</div>
                                        <div class="text-2xl font-bold text-green-700">₹{{ number_format($nurse->payroll->salary, 2) }}</div>
                                    </div>
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                        {{ $nurse->payroll->payment_frequency ?? 'Monthly' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Details -->
                            <div class="space-y-3">
                                <h4 class="font-medium text-gray-800 flex items-center">
                                    <i class="fas fa-university mr-2 text-blue-500"></i> Bank Details
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="text-xs text-gray-500">Bank Name</div>
                                        <div class="font-medium">{{ $nurse->payroll->bank_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="text-xs text-gray-500">Account Number</div>
                                        <div class="font-medium">{{ $nurse->payroll->bank_account ?? 'N/A' }}</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="text-xs text-gray-500">IFSC Code</div>
                                        <div class="font-medium">{{ $nurse->payroll->ifsc_code ?? 'N/A' }}</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="text-xs text-gray-500">UPI Number</div>
                                        <div class="font-medium">{{ $nurse->payroll->upi_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Details -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm text-gray-600 mb-2">Additional Information</div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-id-card text-gray-500 mr-2"></i>
                                    <span class="text-sm">PF Number: {{ $nurse->payroll->pf_number ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-wallet text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">No salary details found</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Family & Shifts -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Family Details -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-5 border-b bg-gradient-to-r from-pink-50 to-pink-100 rounded-t-lg">
                        <h3 class="font-bold text-gray-800 text-lg flex items-center justify-between">
                            <span><i class="fas fa-users mr-2 text-pink-600"></i> Family Details</span>
                            @if($nurse->familyDetails->count() > 0)
                            <span class="bg-pink-100 text-pink-800 text-xs px-3 py-1 rounded-full">
                                {{ $nurse->familyDetails->count() }} Members
                            </span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-5">
                        @if($nurse->familyDetails && $nurse->familyDetails->count() > 0)
                            <div class="space-y-3">
                                @foreach($nurse->familyDetails as $member)
                                <div class="flex items-center justify-between p-3 hover:bg-pink-50 rounded-lg border border-gray-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-pink-500"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $member->name }}</div>
                                            <div class="text-sm text-gray-600">{{ ucfirst($member->relationship) }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($member->contact_number)
                                        <div class="text-sm font-medium text-gray-800">{{ $member->contact_number }}</div>
                                        @endif
                                        @if($member->date_of_birth)
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($member->date_of_birth)->format('d M, Y') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i class="fas fa-users text-gray-300 text-3xl mb-2"></i>
                                <p class="text-gray-500">No family details found</p>
                            </div>
                        @endif
                    </div>


                    
                </div>
                

                <!-- Shifts -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-5 border-b bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-t-lg">
                        <h3 class="font-bold text-gray-800 text-lg flex items-center justify-between">
                            <span><i class="fas fa-clock mr-2 text-yellow-600"></i> Shift Details</span>
                            @if($nurse->shifts->count() > 0)
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">
                                {{ $nurse->shifts->count() }}
                            </span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-5">
                        @if($nurse->shifts && $nurse->shifts->count() > 0)
                            <div class="space-y-3">
                                @foreach($nurse->shifts as $shift)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-clock text-yellow-500"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $shift->shift_name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    Assigned: {{ \Carbon\Carbon::parse($shift->created_at)->format('d M, Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            @if($shift->shift_name === 'Morning') bg-blue-100 text-blue-800
                                            @elseif($shift->shift_name === 'Evening') bg-orange-100 text-orange-800
                                            @elseif($shift->shift_name === 'Night') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $shift->shift_name }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-gray-50 rounded p-3">
                                            <div class="text-xs text-gray-500">Start Time</div>
                                            <div class="font-medium">
                                                @if($shift->start_time && $shift->start_time != '00:00:00')
                                                    {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                                @else
                                                    Not Set
                                                @endif
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 rounded p-3">
                                            <div class="text-xs text-gray-500">End Time</div>
                                            <div class="font-medium">
                                                @if($shift->end_time && $shift->end_time != '00:00:00')
                                                    {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                                @else
                                                    Not Set
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i class="fas fa-clock text-gray-300 text-3xl mb-2"></i>
                                <p class="text-gray-500">No shift details found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

           
        </div>
    </div>
</div>
@endsection