@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Employee Details</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.employees.edit', $employee) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back to List</a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <!-- Basic Information -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Name:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->name }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Email:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->email }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Phone:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Date of Birth:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Gender:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->gender ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Hire Date:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Qualifications -->
            @if($employee->qualifications->count() > 0)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Qualifications</h2>
                <div class="space-y-4">
                    @foreach($employee->qualifications as $qualification)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Degree:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $qualification->degree }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Institution:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $qualification->institution }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Year Completed:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $qualification->year_completed ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Documents -->
            @if($employee->documents->count() > 0)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Documents</h2>
                <div class="space-y-4">
                    @foreach($employee->documents as $document)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Type:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $document->document_type }}</p>
                                </div>
                                <div class="flex items-center">
                                    @if($document->document_path)
                                        <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">View Document</a>
                                    @else
                                        <span class="text-gray-500">No file uploaded</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Payroll -->
            @if($employee->payroll)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Payroll Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Salary:</strong>
                        <p class="text-gray-900 dark:text-white">${{ number_format($employee->payroll->salary, 2) }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Bank Account:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->payroll->bank_account ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">PF Number:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->payroll->pf_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Payment Frequency:</strong>
                        <p class="text-gray-900 dark:text-white">{{ $employee->payroll->payment_frequency ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Addresses -->
            @if($employee->addresses->count() > 0)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Addresses</h2>
                <div class="space-y-4">
                    @foreach($employee->addresses as $address)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="mb-2">
                                <strong class="text-gray-700 dark:text-gray-300">{{ ucfirst($address->address_type) }} Address:</strong>
                            </div>
                            <p class="text-gray-900 dark:text-white">{{ $address->street }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $address->country }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Family Details -->
            @if($employee->familyDetails->count() > 0)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Family Details</h2>
                <div class="space-y-4">
                    @foreach($employee->familyDetails as $family)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Name:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $family->name }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Relationship:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $family->relationship }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Date of Birth:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $family->date_of_birth ? \Carbon\Carbon::parse($family->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Contact:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $family->contact_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Shifts -->
            @if($employee->shifts->count() > 0)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Shifts</h2>
                <div class="space-y-4">
                    @foreach($employee->shifts as $shift)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Shift Name:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $shift->shift_name }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Start Time:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $shift->start_time }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">End Time:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $shift->end_time }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Professions -->
            @if($employee->professions->count() > 0)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Professions</h2>
                <div class="space-y-4">
                    @foreach($employee->professions as $profession)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Title:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $profession->title }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Department:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $profession->department ? $profession->department->department_name : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Expertise -->
            @if($employee->expertise->count() > 0)
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Expertise</h2>
                <div class="space-y-4">
                    @foreach($employee->expertise as $expertise)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Skill:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $expertise->skill }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Proficiency:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $expertise->proficiency_level }}</p>
                                </div>
                                <div>
                                    <strong class="text-gray-700 dark:text-gray-300">Years of Experience:</strong>
                                    <p class="text-gray-900 dark:text-white">{{ $expertise->years_of_experience ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
