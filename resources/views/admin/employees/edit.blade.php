@extends('layouts.layout')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen">
    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <i class="fas fa-check-circle text-xl"></i>
            <span id="toastMessage"></span>
        </div>
    </div>

    <!-- Error Notification -->
    <div id="errorToast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <i class="fas fa-exclamation-circle text-xl"></i>
            <span id="errorToastMessage"></span>
        </div>
    </div>

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-edit text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Employee</h1>
        </div>
        <a href="{{ route('admin.employees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fa fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                        <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee Code *</label>
                        <input type="text" name="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('employee_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Leave blank to keep current password">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Confirm new password">
                        @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hire Date</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('hire_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="Active" {{ old('status', $employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Image</label>
                        @if($employee->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $employee->image) }}" alt="Current Image" class="h-20 w-20 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Specialities -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Specialities</h3>
                <div id="specialities-container">
                    @foreach($employee->specialities as $index => $speciality)
                    <div class="speciality-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Speciality</label>
                            <select name="specialities[{{ $index }}][speciality_id]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Speciality</option>
                                @foreach($specialities as $spec)
                                    <option value="{{ $spec->id }}" {{ $speciality->id == $spec->id ? 'selected' : '' }}>{{ $spec->skill }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proficiency Level</label>
                            <select name="specialities[{{ $index }}][proficiency_level]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Level</option>
                                <option value="Beginner" {{ $speciality->pivot->proficiency_level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="Intermediate" {{ $speciality->pivot->proficiency_level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="Advanced" {{ $speciality->pivot->proficiency_level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="Expert" {{ $speciality->pivot->proficiency_level == 'Expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Years of Experience</label>
                            <input type="number" name="specialities[{{ $index }}][years_of_experience]" value="{{ $speciality->pivot->years_of_experience }}" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-speciality" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Speciality
                </button>
            </div>

            <!-- Qualifications -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Qualifications</h3>
                <div id="qualifications-container">
                    @foreach($employee->qualifications as $index => $qualification)
                    <div class="qualification-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Degree</label>
                            <input type="text" name="qualifications[{{ $index }}][id]" value="{{ $qualification->id }}" hidden>
                            <input type="text" name="qualifications[{{ $index }}][degree]" value="{{ old('qualifications.' . $index . '.degree', $qualification->degree) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Institution</label>
                            <input type="text" name="qualifications[{{ $index }}][institution]" value="{{ old('qualifications.' . $index . '.institution', $qualification->institution) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year Completed</label>
                            <input type="number" name="qualifications[{{ $index }}][year_completed]" value="{{ old('qualifications.' . $index . '.year_completed', $qualification->year_completed) }}" min="1900" max="{{ date('Y') + 10 }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-qualification" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Qualification
                </button>
            </div>

            <!-- Payroll -->
            @if($employee->payroll)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Payroll Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary</label>
                        <input type="number" name="payroll[salary]" value="{{ old('payroll.salary', $employee->payroll->salary) }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Frequency</label>
                        <select name="payroll[payment_frequency]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Frequency</option>
                            <option value="Monthly" {{ old('payroll.payment_frequency', $employee->payroll->payment_frequency) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Weekly" {{ old('payroll.payment_frequency', $employee->payroll->payment_frequency) == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="Bi-weekly" {{ old('payroll.payment_frequency', $employee->payroll->payment_frequency) == 'Bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Account</label>
                        <input type="text" name="payroll[bank_account]" value="{{ old('payroll.bank_account', $employee->payroll->bank_account) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                        <input type="text" name="payroll[bank_name]" value="{{ old('payroll.bank_name', $employee->payroll->bank_name) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IFSC Code</label>
                        <input type="text" name="payroll[ifsc_code]" value="{{ old('payroll.ifsc_code', $employee->payroll->ifsc_code) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">UPI Number</label>
                        <input type="text" name="payroll[upi_number]" value="{{ old('payroll.upi_number', $employee->payroll->upi_number) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PF Number</label>
                        <input type="text" name="payroll[pf_number]" value="{{ old('payroll.pf_number', $employee->payroll->pf_number) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            </div>
            @endif

            <!-- Addresses -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Addresses</h3>
                <div id="addresses-container">
                    @foreach($employee->addresses as $index => $address)
                    <div class="address-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address Type</label>
                            <select name="addresses[{{ $index }}][address_type]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="Home" {{ $address->address_type == 'Home' ? 'selected' : '' }}>Home</option>
                                <option value="Work" {{ $address->address_type == 'Work' ? 'selected' : '' }}>Work</option>
                                <option value="Other" {{ $address->address_type == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Street</label>
                            <input type="text" name="addresses[{{ $index }}][street]" value="{{ old('addresses.' . $index . '.street', $address->street) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                            <input type="text" name="addresses[{{ $index }}][city]" value="{{ old('addresses.' . $index . '.city', $address->city) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                            <input type="text" name="addresses[{{ $index }}][state]" value="{{ old('addresses.' . $index . '.state', $address->state) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                            <input type="text" name="addresses[{{ $index }}][country]" value="{{ old('addresses.' . $index . '.country', $address->country) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal Code</label>
                            <input type="text" name="addresses[{{ $index }}][postal_code]" value="{{ old('addresses.' . $index . '.postal_code', $address->postal_code) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-address" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Address
                </button>
            </div>

            <!-- Family Details -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Family Details</h3>
                <div id="family-container">
                    @foreach($employee->familyDetails as $index => $family)
                    <div class="family-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="hidden" name="family_details[{{ $index }}][id]" value="{{ $family->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                            <input type="text" name="family_details[{{ $index }}][name]" value="{{ old('family_details.' . $index . '.name', $family->name) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Relationship</label>
                            <input type="text" name="family_details[{{ $index }}][relationship]" value="{{ old('family_details.' . $index . '.relationship', $family->relationship) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                            <input type="date" name="family_details[{{ $index }}][date_of_birth]" value="{{ old('family_details.' . $index . '.date_of_birth', $family->date_of_birth ? $family->date_of_birth->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Number</label>
                            <input type="text" name="family_details[{{ $index }}][contact_number]" value="{{ old('family_details.' . $index . '.contact_number', $family->contact_number) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-family" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Family Member
                </button>
            </div>

            <!-- Shifts -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Shifts</h3>
                <div id="shifts-container">
                    @foreach($employee->shifts as $index => $shift)
                    <div class="shift-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <input type="hidden" name="shifts[{{ $index }}][id]" value="{{ $shift->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shift Name</label>
                            <select name="shifts[{{ $index }}][shift_name]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Shift</option>
                                <option value="Morning" {{ old('shifts.' . $index . '.shift_name', $shift->shift_name) == 'Morning' ? 'selected' : '' }}>Morning</option>
                                <option value="Afternoon" {{ old('shifts.' . $index . '.shift_name', $shift->shift_name) == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                                <option value="Night" {{ old('shifts.' . $index . '.shift_name', $shift->shift_name) == 'Night' ? 'selected' : '' }}>Night</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                            <input type="time" name="shifts[{{ $index }}][start_time]" value="{{ old('shifts.' . $index . '.start_time', $shift->start_time ? \Carbon\Carbon::parse($shift->start_time)->format('H:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                            <input type="time" name="shifts[{{ $index }}][end_time]" value="{{ old('shifts.' . $index . '.end_time', $shift->end_time ? \Carbon\Carbon::parse($shift->end_time)->format('H:i') : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-shift" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Shift
                </button>
            </div>

            <!-- Professions -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Professions</h3>
                <div id="professions-container">
                    @foreach($employee->professions as $index => $profession)
                    <div class="profession-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="hidden" name="professions[{{ $index }}][id]" value="{{ $profession->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="professions[{{ $index }}][title]" value="{{ old('professions.' . $index . '.title', $profession->title) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                            <select name="professions[{{ $index }}][department_id]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $profession->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-profession" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Profession
                </button>
            </div>

            <!-- Documents -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Documents</h3>
                <div id="documents-container">
                    @foreach($employee->documents as $index => $document)
                    <div class="document-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Document Type</label>
                            <input type="text" name="documents[{{ $index }}][document_type]" value="{{ $document->document_type }}" placeholder="e.g., ID Card, Certificate" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current File</label>
                            <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($document->document_path) }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-document" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Document
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fa fa-save mr-2"></i>Update Employee
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let specialityIndex = {{ count($employee->specialities) }};
    let qualificationIndex = {{ count($employee->qualifications) }};
    let addressIndex = {{ count($employee->addresses) }};
    let familyIndex = {{ count($employee->familyDetails) }};
    let shiftIndex = {{ count($employee->shifts) }};
    let professionIndex = {{ count($employee->professions) }};
    let documentIndex = {{ count($employee->documents) }};

    // Add Speciality
    document.getElementById('add-speciality').addEventListener('click', function() {
        const container = document.getElementById('specialities-container');
        const newItem = container.querySelector('.speciality-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + specialityIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        specialityIndex++;
    });

    // Add Qualification
    document.getElementById('add-qualification').addEventListener('click', function() {
        const container = document.getElementById('qualifications-container');
        const newItem = container.querySelector('.qualification-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + qualificationIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        qualificationIndex++;
    });

    // Add Address
    document.getElementById('add-address').addEventListener('click', function() {
        const container = document.getElementById('addresses-container');
        const newItem = container.querySelector('.address-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + addressIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        addressIndex++;
    });

    // Add Family Member
    document.getElementById('add-family').addEventListener('click', function() {
        const container = document.getElementById('family-container');
        const newItem = container.querySelector('.family-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + familyIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        familyIndex++;
    });

    // Add Shift
    document.getElementById('add-shift').addEventListener('click', function() {
        const container = document.getElementById('shifts-container');
        const newItem = container.querySelector('.shift-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + shiftIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        shiftIndex++;
    });

    // Add Profession
    document.getElementById('add-profession').addEventListener('click', function() {
        const container = document.getElementById('professions-container');
        const newItem = container.querySelector('.profession-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + professionIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        professionIndex++;
    });

    // Add Document
    document.getElementById('add-document').addEventListener('click', function() {
        const container = document.getElementById('documents-container');
        const newItem = container.querySelector('.document-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, '[' + documentIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        documentIndex++;
    });

    // Handle form submission with AJAX
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        // CSRF token is already in the form as hidden input

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast('Employee updated successfully!');
                setTimeout(() => {
                    window.location.href = '{{ route("admin.employees.index") }}';
                }, 2000);
            } else {
                showErrorToast(data.message || 'Failed to update employee.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorToast('An error occurred. Please try again.');
        });
    });

    function showToast(message) {
        const toast = document.getElementById('toast');
        document.getElementById('toastMessage').textContent = message;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

    function showErrorToast(message) {
        const toast = document.getElementById('errorToast');
        document.getElementById('errorToastMessage').textContent = message;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }
});
</script>
@endsection
