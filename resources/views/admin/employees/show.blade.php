@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Employee Details</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fa fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.employees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fa fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Employee Details -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <!-- Basic Information -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee Code</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->employee_code }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y') : 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hire Date</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d M Y') : 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->professions->first()->department->name ?? $employee->department->name ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Image</label>
                    @if($employee->image)
                        <img src="{{ asset('storage/' . $employee->image) }}" alt="Profile Image" class="w-20 h-20 rounded-full object-cover">
                    @else
                        <p class="text-gray-900 dark:text-white">No image uploaded</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Specialities -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Specialities</h3>
            @if($employee->specialities->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->specialities as $speciality)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Speciality:</strong> {{ $speciality->skill }}</p>
                            <p><strong>Proficiency Level:</strong> {{ $speciality->pivot->proficiency_level }}</p>
                            <p><strong>Years of Experience:</strong> {{ $speciality->pivot->years_of_experience }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No specialities added</p>
            @endif
        </div>

        <!-- Qualifications -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Qualifications</h3>
            @if($employee->qualifications->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->qualifications as $qualification)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Degree:</strong> {{ $qualification->degree }}</p>
                            <p><strong>Institution:</strong> {{ $qualification->institution }}</p>
                            <p><strong>Year Completed:</strong> {{ $qualification->year_completed }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No qualifications added</p>
            @endif
        </div>

        <!-- Payroll -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Payroll Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->salary ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Frequency</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->payment_frequency ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Account</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->bank_account ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->bank_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IFSC Code</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->ifsc_code ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">UPI Number</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->upi_number ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PF Number</label>
                    <p class="text-gray-900 dark:text-white">{{ $employee->payroll->pf_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Addresses -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Addresses</h3>
            @if($employee->addresses->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->addresses as $address)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Type:</strong> {{ $address->address_type }}</p>
                            <p><strong>Street:</strong> {{ $address->street }}</p>
                            <p><strong>City:</strong> {{ $address->city }}</p>
                            <p><strong>State:</strong> {{ $address->state }}</p>
                            <p><strong>Country:</strong> {{ $address->country }}</p>
                            <p><strong>Postal Code:</strong> {{ $address->postal_code }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No addresses added</p>
            @endif
        </div>

        <!-- Family Details -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Family Details</h3>
            @if($employee->familyDetails->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->familyDetails as $family)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Name:</strong> {{ $family->name }}</p>
                            <p><strong>Relationship:</strong> {{ $family->relationship }}</p>
                            <p><strong>Date of Birth:</strong> {{ $family->date_of_birth ? \Carbon\Carbon::parse($family->date_of_birth)->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Contact Number:</strong> {{ $family->contact_number }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No family details added</p>
            @endif
        </div>

        <!-- Shifts -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Shifts</h3>
            @if($employee->shifts->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->shifts as $shift)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Shift Name:</strong> {{ $shift->shift_name }}</p>
                            <p><strong>Start Time:</strong> {{ $shift->start_time }}</p>
                            <p><strong>End Time:</strong> {{ $shift->end_time }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No shifts added</p>
            @endif
        </div>

        <!-- Professions -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Professions</h3>
            @if($employee->professions->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->professions as $profession)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Title:</strong> {{ $profession->title }}</p>
                            <p><strong>Department:</strong> {{ $profession->department->name ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No professions added</p>
            @endif
        </div>

        <!-- Documents -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Documents</h3>
            @if($employee->documents->count() > 0)
                <div class="space-y-2">
                    @foreach($employee->documents as $document)
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                            <p><strong>Type:</strong> {{ $document->document_type }}</p>
                            <p><strong>File:</strong> <a href="{{ asset('storage/' . $document->document_file) }}" target="_blank" class="text-blue-600 hover:underline">View Document</a></p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-900 dark:text-white">No documents added</p>
            @endif
        </div>
    </div>
</div>
@endsection
