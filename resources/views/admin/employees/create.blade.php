@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Add New Employee</h1>

        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @csrf

            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('date_of_birth') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                        <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hire Date</label>
                        <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('hire_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Qualifications -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Qualifications</h2>
                <div id="qualifications-container">
                    <div class="qualification-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Degree *</label>
                                <input type="text" name="qualifications[0][degree]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution *</label>
                                <input type="text" name="qualifications[0][institution]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year *</label>
                                    <input type="number" name="qualifications[0][year_completed]" min="1900" max="{{ date('Y') + 10 }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                                </div>
                        </div>
                        <button type="button" class="remove-qualification mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-qualification" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Qualification</button>
            </div>

            <!-- Documents -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Documents</h2>
                <div id="documents-container">
                    <div class="document-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Document Name</label>
                                    <input type="text" name="documents[0][document_type]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="e.g., Aadhar Card, Passport">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Document</label>
                                <input type="file" name="documents[0][document_file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <button type="button" class="remove-document mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-document" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Document</button>
            </div>

            <!-- Payroll -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Payroll Information</h2>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="payroll_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salary</label>
                            <input type="number" step="0.01" name="payroll[salary]" id="payroll_salary" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="payroll_bank_account" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Account</label>
                            <input type="text" name="payroll[bank_account]" id="payroll_bank_account" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="payroll_bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                            <input type="text" name="payroll[bank_name]" id="payroll_bank_name" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="payroll_ifsc_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IFSC Code</label>
                            <input type="text" name="payroll[ifsc_code]" id="payroll_ifsc_code" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="payroll_upi_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">UPI Number</label>
                            <input type="text" name="payroll[upi_number]" id="payroll_upi_number" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="payroll_pf_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PF Number</label>
                            <input type="text" name="payroll[pf_number]" id="payroll_pf_number" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="payroll_payment_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Frequency</label>
                            <select name="payroll[payment_frequency]" id="payroll_payment_frequency" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select Frequency</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Bi-weekly">Bi-weekly</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Addresses</h2>
                <div id="addresses-container">
                    <div class="address-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Type *</label>
                                <select name="addresses[0][address_type]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                                    <option value="">Select Type</option>
                                    <option value="Home">Home</option>
                                    <option value="Work">Work</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street *</label>
                                <input type="text" name="addresses[0][street]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City *</label>
                                <input type="text" name="addresses[0][city]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">State *</label>
                                <input type="text" name="addresses[0][state]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country *</label>
                                <input type="text" name="addresses[0][country]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                                <input type="text" name="addresses[0][postal_code]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <button type="button" class="remove-address mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-address" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Address</button>
            </div>

            <!-- Family Details -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Family Details</h2>
                <div id="family-details-container">
                    <div class="family-detail-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name *</label>
                                <input type="text" name="family_details[0][name]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Relationship *</label>
                                <input type="text" name="family_details[0][relationship]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                                <input type="date" name="family_details[0][date_of_birth]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Number</label>
                                <input type="text" name="family_details[0][contact_number]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <button type="button" class="remove-family-detail mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-family-detail" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Family Member</button>
            </div>

            <!-- Shifts -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Shifts</h2>
                <div id="shifts-container">
                    <div class="shift-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shift Name *</label>
                                <input type="text" name="shifts[0][shift_name]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time *</label>
                                <input type="time" name="shifts[0][start_time]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time *</label>
                                <input type="time" name="shifts[0][end_time]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                        </div>
                        <button type="button" class="remove-shift mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-shift" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Shift</button>
            </div>

            <!-- Professions -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Professions</h2>
                <div id="professions-container">
                    <div class="profession-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                                <input type="text" name="professions[0][title]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <select name="professions[0][department_id]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Select Department</option>
                                    @foreach(\App\Models\Department::all() as $department)
                                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <button type="button" class="remove-profession mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-profession" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Profession</button>
            </div>

            <!-- Expertise -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Expertise</h2>
                <div id="expertise-container">
                    <div class="expertise-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill *</label>
                                <input type="text" name="expertise[0][skill]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proficiency Level *</label>
                                <select name="expertise[0][proficiency_level]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                                    <option value="">Select Level</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Years of Experience</label>
                                <input type="number" name="expertise[0][years_of_experience]" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <button type="button" class="remove-expertise mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" style="display: none;">Remove</button>
                    </div>
                </div>
                <button type="button" id="add-expertise" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Expertise</button>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <a href="{{ route('admin.employees.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Employee</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Qualifications
    let qualificationIndex = 1;
    document.getElementById('add-qualification').addEventListener('click', function() {
        const container = document.getElementById('qualifications-container');
        const newItem = container.querySelector('.qualification-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + qualificationIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-qualification').style.display = 'block';
        container.appendChild(newItem);
        qualificationIndex++;
    });

    // Documents
    let documentIndex = 1;
    document.getElementById('add-document').addEventListener('click', function() {
        const container = document.getElementById('documents-container');
        const newItem = container.querySelector('.document-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + documentIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-document').style.display = 'block';
        container.appendChild(newItem);
        documentIndex++;
    });

    // Addresses
    let addressIndex = 1;
    document.getElementById('add-address').addEventListener('click', function() {
        const container = document.getElementById('addresses-container');
        const newItem = container.querySelector('.address-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace('[0]', '[' + addressIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-address').style.display = 'block';
        container.appendChild(newItem);
        addressIndex++;
    });

    // Family Details
    let familyDetailIndex = 1;
    document.getElementById('add-family-detail').addEventListener('click', function() {
        const container = document.getElementById('family-details-container');
        const newItem = container.querySelector('.family-detail-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + familyDetailIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-family-detail').style.display = 'block';
        container.appendChild(newItem);
        familyDetailIndex++;
    });

    // Shifts
    let shiftIndex = 1;
    document.getElementById('add-shift').addEventListener('click', function() {
        const container = document.getElementById('shifts-container');
        const newItem = container.querySelector('.shift-item').cloneNode(true);
        newItem.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('[0]', '[' + shiftIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-shift').style.display = 'block';
        container.appendChild(newItem);
        shiftIndex++;
    });

    // Professions
    let professionIndex = 1;
    document.getElementById('add-profession').addEventListener('click', function() {
        const container = document.getElementById('professions-container');
        const newItem = container.querySelector('.profession-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace('[0]', '[' + professionIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-profession').style.display = 'block';
        container.appendChild(newItem);
        professionIndex++;
    });

    // Expertise
    let expertiseIndex = 1;
    document.getElementById('add-expertise').addEventListener('click', function() {
        const container = document.getElementById('expertise-container');
        const newItem = container.querySelector('.expertise-item').cloneNode(true);
        newItem.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace('[0]', '[' + expertiseIndex + ']');
            input.value = '';
        });
        newItem.querySelector('.remove-expertise').style.display = 'block';
        container.appendChild(newItem);
        expertiseIndex++;
    });

    // Remove functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-qualification')) {
            e.target.closest('.qualification-item').remove();
        }
        if (e.target.classList.contains('remove-document')) {
            e.target.closest('.document-item').remove();
        }
        if (e.target.classList.contains('remove-address')) {
            e.target.closest('.address-item').remove();
        }
        if (e.target.classList.contains('remove-family-detail')) {
            e.target.closest('.family-detail-item').remove();
        }
        if (e.target.classList.contains('remove-shift')) {
            e.target.closest('.shift-item').remove();
        }
        if (e.target.classList.contains('remove-profession')) {
            e.target.closest('.profession-item').remove();
        }
        if (e.target.classList.contains('remove-expertise')) {
            e.target.closest('.expertise-item').remove();
        }
    });
});
</script>
@endsection
