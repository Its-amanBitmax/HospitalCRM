@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <!-- Error Notification -->
    @if($errors->any())
        <div id="error-toast" class="fixed top-4 right-4 z-50 max-w-md">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-start gap-3 animate-fade-in">
                <i class="fas fa-exclamation-triangle text-xl mt-0.5"></i>
                <div class="flex-1">
                    <div class="font-semibold mb-1">Validation Errors</div>
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-plus text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Add New Employee</h1>
        </div>
        <a href="{{ route('admin.employees.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fa fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Employee Code *</label>
                        <input type="text" name="employee_code" value="{{ old('employee_code') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('employee_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                        <select name="gender" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hire Date</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('hire_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department *</label>
                        <select name="department_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password *</label>
                        <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Specialities -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Specialities</h3>
                <div id="specialities-container">
                    <div class="speciality-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Speciality</label>
                            <select name="specialities[0][speciality_id]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Speciality</option>
                                @foreach($specialities as $speciality)
                                    <option value="{{ $speciality->id }}" {{ old('specialities.0.speciality_id') == $speciality->id ? 'selected' : '' }}>{{ $speciality->skill }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proficiency Level</label>
                            <select name="specialities[0][proficiency_level]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Level</option>
                                <option value="Beginner" {{ old('specialities.0.proficiency_level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="Intermediate" {{ old('specialities.0.proficiency_level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="Advanced" {{ old('specialities.0.proficiency_level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="Expert" {{ old('specialities.0.proficiency_level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Years of Experience</label>
                            <input type="number" name="specialities[0][years_of_experience]" min="0" value="{{ old('specialities.0.years_of_experience') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-speciality" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Speciality
                </button>
            </div>

            <!-- Qualifications -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Qualifications</h3>
                <div id="qualifications-container">
                    <div class="qualification-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Degree</label>
                            <input type="text" name="qualifications[0][degree]" value="{{ old('qualifications.0.degree') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Institution</label>
                            <input type="text" name="qualifications[0][institution]" value="{{ old('qualifications.0.institution') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year Completed</label>
                            <input type="number" name="qualifications[0][year_completed]" min="1900" max="{{ date('Y') + 10 }}" value="{{ old('qualifications.0.year_completed') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-qualification" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Qualification
                </button>
            </div>

            <!-- Payroll -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Payroll Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Salary</label>
                        <input type="number" name="payroll[salary]" step="0.01" min="0" value="{{ old('payroll.salary') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Frequency</label>
                        <select name="payroll[payment_frequency]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Frequency</option>
                            <option value="Monthly" {{ old('payroll.payment_frequency') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Weekly" {{ old('payroll.payment_frequency') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="Bi-weekly" {{ old('payroll.payment_frequency') == 'Bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Account</label>
                        <input type="text" name="payroll[bank_account]" value="{{ old('payroll.bank_account') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                        <input type="text" name="payroll[bank_name]" value="{{ old('payroll.bank_name') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">IFSC Code</label>
                        <input type="text" name="payroll[ifsc_code]" value="{{ old('payroll.ifsc_code') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">UPI Number</label>
                        <input type="text" name="payroll[upi_number]" value="{{ old('payroll.upi_number') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">PF Number</label>
                        <input type="text" name="payroll[pf_number]" value="{{ old('payroll.pf_number') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Addresses</h3>
                <div id="addresses-container">
                    <div class="address-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address Type</label>
                            <select name="addresses[0][address_type]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="Home" {{ old('addresses.0.address_type') == 'Home' ? 'selected' : '' }}>Home</option>
                                <option value="Work" {{ old('addresses.0.address_type') == 'Work' ? 'selected' : '' }}>Work</option>
                                <option value="Other" {{ old('addresses.0.address_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Street</label>
                            <input type="text" name="addresses[0][street]" value="{{ old('addresses.0.street') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                            <input type="text" name="addresses[0][city]" value="{{ old('addresses.0.city') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                            <input type="text" name="addresses[0][state]" value="{{ old('addresses.0.state') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                            <input type="text" name="addresses[0][country]" value="{{ old('addresses.0.country') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal Code</label>
                            <input type="text" name="addresses[0][postal_code]" value="{{ old('addresses.0.postal_code') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-address" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Address
                </button>
            </div>

            <!-- Family Details -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Family Details</h3>
                <div id="family-container">
                    <div class="family-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                            <input type="text" name="family_details[0][name]" value="{{ old('family_details.0.name') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Relationship</label>
                            <input type="text" name="family_details[0][relationship]" value="{{ old('family_details.0.relationship') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date of Birth</label>
                            <input type="date" name="family_details[0][date_of_birth]" value="{{ old('family_details.0.date_of_birth') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Number</label>
                            <input type="text" name="family_details[0][contact_number]" value="{{ old('family_details.0.contact_number') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-family" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Family Member
                </button>
            </div>

            <!-- Shifts -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Shifts</h3>
                <div id="shifts-container">
                    <div class="shift-item grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shift Name</label>
                            <select name="shifts[0][shift_name]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Shift</option>
                                <option value="Morning" {{ old('shifts.0.shift_name') == 'Morning' ? 'selected' : '' }}>Morning</option>
                                <option value="Afternoon" {{ old('shifts.0.shift_name') == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                                <option value="Night" {{ old('shifts.0.shift_name') == 'Night' ? 'selected' : '' }}>Night</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                            <input type="time" name="shifts[0][start_time]" value="{{ old('shifts.0.start_time') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                            <input type="time" name="shifts[0][end_time]" value="{{ old('shifts.0.end_time') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-shift" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Shift
                </button>
            </div>

            <!-- Professions -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Professions</h3>
                <div id="professions-container">
                    <div class="profession-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <select name="professions[0][title]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Profession</option>
                                <option value="Doctor" {{ old('professions.0.title') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="Nurse" {{ old('professions.0.title') == 'Nurse' ? 'selected' : '' }}>Nurse</option>
                                <option value="Technician" {{ old('professions.0.title') == 'Technician' ? 'selected' : '' }}>Technician</option>
                                <option value="Pharmacist" {{ old('professions.0.title') == 'Pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                <option value="Receptionist" {{ old('professions.0.title') == 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                                <option value="Manager" {{ old('professions.0.title') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Ward Boy" {{ old('professions.0.title') == 'Ward Boy' ? 'selected' : '' }}>Ward Boy</option>
                                <option value="Cleaner" {{ old('professions.0.title') == 'Cleaner' ? 'selected' : '' }}>Cleaner</option>
                                <option value="Security" {{ old('professions.0.title') == 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Accountant" {{ old('professions.0.title') == 'Accountant' ? 'selected' : '' }}>Accountant</option>
                                <option value="Laborist" {{ old('professions.0.title') == 'Laborist' ? 'selected' : '' }}>Laborist</option>
                                <option value="Other" {{ old('professions.0.title') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                            <select name="professions[0][department_id]" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('professions.0.department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-profession" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Profession
                </button>
            </div>

            <!-- Documents -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Documents</h3>
                <div id="documents-container">
                    <div class="document-item grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Document Type</label>
                            <input type="text" name="documents[0][document_type]" placeholder="e.g., ID Card, Certificate" value="{{ old('documents.0.document_type') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Document File</label>
                            <input type="file" name="documents[0][document_file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
                <button type="button" id="add-document" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fa fa-plus mr-2"></i>Add Document
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fa fa-save mr-2"></i>Create Employee
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Speciality
    let specialityIndex = 1;
    document.getElementById('add-speciality').addEventListener('click', function() {
        const container = document.getElementById('specialities-container');
        const newItem = container.querySelector('.speciality-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace('[0]', '[' + specialityIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        specialityIndex++;
    });

    // Add Qualification
    let qualificationIndex = 1;
    document.getElementById('add-qualification').addEventListener('click', function() {
        const container = document.getElementById('qualifications-container');
        const newItem = container.querySelector('.qualification-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + qualificationIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        qualificationIndex++;
    });

    // Add Address
    let addressIndex = 1;
    document.getElementById('add-address').addEventListener('click', function() {
        const container = document.getElementById('addresses-container');
        const newItem = container.querySelector('.address-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace('[0]', '[' + addressIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        addressIndex++;
    });

    // Add Family Member
    let familyIndex = 1;
    document.getElementById('add-family').addEventListener('click', function() {
        const container = document.getElementById('family-container');
        const newItem = container.querySelector('.family-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + familyIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        familyIndex++;
    });

    // Add Shift
    let shiftIndex = 1;
    document.getElementById('add-shift').addEventListener('click', function() {
        const container = document.getElementById('shifts-container');
        const newItem = container.querySelector('.shift-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + shiftIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        shiftIndex++;
    });

    // Add Profession
    let professionIndex = 1;
    document.getElementById('add-profession').addEventListener('click', function() {
        const container = document.getElementById('professions-container');
        const newItem = container.querySelector('.profession-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace('[0]', '[' + professionIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        professionIndex++;
    });

    // Add Document
    let documentIndex = 1;
    document.getElementById('add-document').addEventListener('click', function() {
        const container = document.getElementById('documents-container');
        const newItem = container.querySelector('.document-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + documentIndex + ']');
            input.value = '';
        });
        container.appendChild(newItem);
        documentIndex++;
    });
});
</script>
@endsection
