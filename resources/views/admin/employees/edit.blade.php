@extends('layouts.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Employee</h1>

        <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="name-error">
                        @error('name') <p id="name-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="email-error">
                        @error('email') <p id="email-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $employee->phone) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" pattern="[0-9]{10,15}" aria-describedby="phone-error">
                        @error('phone') <p id="phone-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="date_of_birth-error">
                        @error('date_of_birth') <p id="date_of_birth-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                        <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="gender-error">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p id="gender-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hire Date</label>
                        <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="hire_date-error">
                        @error('hire_date') <p id="hire_date-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="employee_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee Code <span class="text-red-500">*</span></label>
                        <input type="text" name="employee_code" id="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="employee_code-error">
                        @error('employee_code') <p id="employee_code-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="password-error">
                        @error('password') <p id="password-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Image</label>
                        @if($employee->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $employee->image) }}" alt="Current Profile Image" class="w-20 h-20 object-cover rounded-full border border-gray-300">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="image-error">
                        @error('image') <p id="image-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Qualifications -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Qualifications</h2>
                <div id="qualifications-container">
                    @foreach($employee->qualifications as $index => $qualification)
                        <div class="qualification-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <input type="hidden" name="qualifications[{{ $index }}][id]" value="{{ $qualification->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Degree</label>
                                    <input type="text" name="qualifications[{{ $index }}][degree]" value="{{ old('qualifications.' . $index . '.degree', $qualification->degree) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="qualification-degree-{{ $index }}-error">
                                    @error('qualifications.' . $index . '.degree') <p id="qualification-degree-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution</label>
                                    <input type="text" name="qualifications[{{ $index }}][institution]" value="{{ old('qualifications.' . $index . '.institution', $qualification->institution) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="qualification-institution-{{ $index }}-error">
                                    @error('qualifications.' . $index . '.institution') <p id="qualification-institution-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year Completed</label>
                                    <input type="number" name="qualifications[{{ $index }}][year_completed]" min="1901" max="{{ date('Y') + 10 }}" value="{{ old('qualifications.' . $index . '.year_completed', $qualification->year_completed) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="qualification-year-completed-{{ $index }}-error">
                                    @error('qualifications.' . $index . '.year_completed') <p id="qualification-year-completed-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <button type="button" class="remove-qualification mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" {{ $loop->first ? 'style="display: none;"' : '' }} aria-label="Remove qualification">Remove</button>
                        </div>
                    @endforeach
                    <div class="qualification-template" style="display: none;">
                        <div class="qualification-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Degree *</label>
                                    <input type="text" name="qualifications[0][degree]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Institution *</label>
                                    <input type="text" name="qualifications[0][institution]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year Completed *</label>
                                    <input type="number" name="qualifications[0][year_completed]" min="1901" max="{{ date('Y') + 10 }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                            </div>
                            <button type="button" class="remove-qualification mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Remove qualification">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-qualification" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Add new qualification">Add Qualification</button>
            </div>

            <!-- Documents -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Documents</h2>
                <div id="documents-container">
                    @foreach($employee->documents as $index => $document)
                        <div class="document-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Document Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="documents[{{ $index }}][document_type]" value="{{ old('documents.' . $index . '.document_type', $document->document_type) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="e.g., Aadhar Card, Passport" required aria-describedby="document-type-{{ $index }}-error">
                                    @error('documents.' . $index . '.document_type') <p id="document-type-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Document</label>
                                    <input type="file" name="documents[{{ $index }}][document_file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="document-file-{{ $index }}-error">
                                    @if($document->document_path)
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Current Document: <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ basename($document->document_path) }}</a></p>
                                    @endif
                                    <input type="hidden" name="documents[{{ $index }}][existing_path]" value="{{ $document->document_path }}">
                                    @error('documents.' . $index . '.document_file') <p id="document-file-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <button type="button" class="remove-document mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" {{ $loop->first ? 'style="display: none;"' : '' }} aria-label="Remove document">Remove</button>
                        </div>
                    @endforeach
                    <div class="document-template" style="display: none;">
                        <div class="document-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Document Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="documents[0][document_type]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="e.g., Aadhar Card, Passport" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Document</label>
                                    <input type="file" name="documents[0][document_file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                            <button type="button" class="remove-document mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Remove document">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-document" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Add new document">Add Document</button>
            </div>

            <!-- Payroll -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Payroll Information</h2>
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="payroll_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salary</label>
                            <input type="number" step="0.01" min="0" name="payroll[salary]" id="payroll_salary" value="{{ old('payroll.salary', $employee->payroll->salary ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-salary-error">
                            @error('payroll.salary') <p id="payroll-salary-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payroll_bank_account" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Account</label>
                            <input type="text" name="payroll[bank_account]" id="payroll_bank_account" value="{{ old('payroll.bank_account', $employee->payroll->bank_account ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-bank-account-error">
                            @error('payroll.bank_account') <p id="payroll-bank-account-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payroll_bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                            <input type="text" name="payroll[bank_name]" id="payroll_bank_name" value="{{ old('payroll.bank_name', $employee->payroll->bank_name ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-bank-name-error">
                            @error('payroll.bank_name') <p id="payroll-bank-name-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payroll_ifsc_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IFSC Code</label>
                            <input type="text" name="payroll[ifsc_code]" id="payroll_ifsc_code" value="{{ old('payroll.ifsc_code', $employee->payroll->ifsc_code ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-ifsc-code-error">
                            @error('payroll.ifsc_code') <p id="payroll-ifsc-code-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payroll_upi_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">UPI Number</label>
                            <input type="text" name="payroll[upi_number]" id="payroll_upi_number" value="{{ old('payroll.upi_number', $employee->payroll->upi_number ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-upi-number-error">
                            @error('payroll.upi_number') <p id="payroll-upi-number-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payroll_pf_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PF Number</label>
                            <input type="text" name="payroll[pf_number]" id="payroll_pf_number" value="{{ old('payroll.pf_number', $employee->payroll->pf_number ?? '') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-pf-number-error">
                            @error('payroll.pf_number') <p id="payroll-pf-number-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="payroll_payment_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Frequency</label>
                            <select name="payroll[payment_frequency]" id="payroll_payment_frequency" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="payroll-payment-frequency-error">
                                <option value="">Select Frequency</option>
                                <option value="Monthly" {{ old('payroll.payment_frequency', $employee->payroll->payment_frequency ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="Weekly" {{ old('payroll.payment_frequency', $employee->payroll->payment_frequency ?? '') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="Bi-weekly" {{ old('payroll.payment_frequency', $employee->payroll->payment_frequency ?? '') == 'Bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                            </select>
                            @error('payroll.payment_frequency') <p id="payroll-payment-frequency-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Addresses</h2>
                <div id="addresses-container">
                    @foreach($employee->addresses as $index => $address)
                        <div class="address-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Type <span class="text-red-500">*</span></label>
                                    <select name="addresses[{{ $index }}][address_type]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="address-type-{{ $index }}-error">
                                        <option value="">Select Type</option>
                                        <option value="Home" {{ old('addresses.' . $index . '.address_type', $address->address_type) == 'Home' ? 'selected' : '' }}>Home</option>
                                        <option value="Work" {{ old('addresses.' . $index . '.address_type', $address->address_type) == 'Work' ? 'selected' : '' }}>Work</option>
                                        <option value="Other" {{ old('addresses.' . $index . '.address_type', $address->address_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('addresses.' . $index . '.address_type') <p id="address-type-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[{{ $index }}][street]" value="{{ old('addresses.' . $index . '.street', $address->street) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="address-street-{{ $index }}-error">
                                    @error('addresses.' . $index . '.street') <p id="address-street-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[{{ $index }}][city]" value="{{ old('addresses.' . $index . '.city', $address->city) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="address-city-{{ $index }}-error">
                                    @error('addresses.' . $index . '.city') <p id="address-city-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">State <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[{{ $index }}][state]" value="{{ old('addresses.' . $index . '.state', $address->state) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="address-state-{{ $index }}-error">
                                    @error('addresses.' . $index . '.state') <p id="address-state-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[{{ $index }}][country]" value="{{ old('addresses.' . $index . '.country', $address->country) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="address-country-{{ $index }}-error">
                                    @error('addresses.' . $index . '.country') <p id="address-country-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                                    <input type="text" name="addresses[{{ $index }}][postal_code]" value="{{ old('addresses.' . $index . '.postal_code', $address->postal_code) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="address-postal-code-{{ $index }}-error">
                                    @error('addresses.' . $index . '.postal_code') <p id="address-postal-code-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <button type="button" class="remove-address mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" {{ $loop->first ? 'style="display: none;"' : '' }} aria-label="Remove address">Remove</button>
                        </div>
                    @endforeach
                    <div class="address-template" style="display: none;">
                        <div class="address-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address Type <span class="text-red-500">*</span></label>
                                    <select name="addresses[0][address_type]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                        <option value="">Select Type</option>
                                        <option value="Home">Home</option>
                                        <option value="Work">Work</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[0][street]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[0][city]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">State <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[0][state]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country <span class="text-red-500">*</span></label>
                                    <input type="text" name="addresses[0][country]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                                    <input type="text" name="addresses[0][postal_code]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                            <button type="button" class="remove-address mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Remove address">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-address" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Add new address">Add Address</button>
            </div>

            <!-- Family Details -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Family Details</h2>
                <div id="family-details-container">
                    @foreach($employee->familyDetails as $index => $familyDetail)
                        <div class="family-detail-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <input type="hidden" name="family_details[{{ $index }}][id]" value="{{ $familyDetail->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="family_details[{{ $index }}][name]" value="{{ old('family_details.' . $index . '.name', $familyDetail->name) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="family-detail-name-{{ $index }}-error">
                                    @error('family_details.' . $index . '.name') <p id="family-detail-name-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Relationship <span class="text-red-500">*</span></label>
                                    <input type="text" name="family_details[{{ $index }}][relationship]" value="{{ old('family_details.' . $index . '.relationship', $familyDetail->relationship) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="family-detail-relationship-{{ $index }}-error">
                                    @error('family_details.' . $index . '.relationship') <p id="family-detail-relationship-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                                    <input type="date" name="family_details[{{ $index }}][date_of_birth]" value="{{ old('family_details.' . $index . '.date_of_birth', $familyDetail->date_of_birth) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="family-detail-dob-{{ $index }}-error">
                                    @error('family_details.' . $index . '.date_of_birth') <p id="family-detail-dob-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Number</label>
                                    <input type="tel" name="family_details[{{ $index }}][contact_number]" value="{{ old('family_details.' . $index . '.contact_number', $familyDetail->contact_number) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" pattern="[0-9]{10,15}" aria-describedby="family-detail-contact-{{ $index }}-error">
                                    @error('family_details.' . $index . '.contact_number') <p id="family-detail-contact-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <button type="button" class="remove-family-detail mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" {{ $loop->first ? 'style="display: none;"' : '' }} aria-label="Remove family detail">Remove</button>
                        </div>
                    @endforeach
                    <div class="family-detail-template" style="display: none;">
                        <div class="family-detail-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="family_details[0][name]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Relationship <span class="text-red-500">*</span></label>
                                    <input type="text" name="family_details[0][relationship]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                                    <input type="date" name="family_details[0][date_of_birth]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Number</label>
                                    <input type="tel" name="family_details[0][contact_number]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" pattern="[0-9]{10,15}">
                                </div>
                            </div>
                            <button type="button" class="remove-family-detail mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Remove family detail">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-family-detail" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Add new family member">Add Family Member</button>
            </div>

            <!-- Shifts -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Shifts</h2>
                <div id="shifts-container">
                    @foreach($employee->shifts as $index => $shift)
                        <div class="shift-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <input type="hidden" name="shifts[{{ $index }}][id]" value="{{ $shift->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shift Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="shifts[{{ $index }}][shift_name]" value="{{ old('shifts.' . $index . '.shift_name', $shift->shift_name) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="shift-name-{{ $index }}-error">
                                    @error('shifts.' . $index . '.shift_name') <p id="shift-name-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="shifts[{{ $index }}][start_time]" value="{{ old('shifts.' . $index . '.start_time', $shift->start_time) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="shift-start-time-{{ $index }}-error">
                                    @error('shifts.' . $index . '.start_time') <p id="shift-start-time-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="shifts[{{ $index }}][end_time]" value="{{ old('shifts.' . $index . '.end_time', $shift->end_time) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="shift-end-time-{{ $index }}-error">
                                    @error('shifts.' . $index . '.end_time') <p id="shift-end-time-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <button type="button" class="remove-shift mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" {{ $loop->first ? 'style="display: none;"' : '' }} aria-label="Remove shift">Remove</button>
                        </div>
                    @endforeach
                    <div class="shift-template" style="display: none;">
                        <div class="shift-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Shift Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="shifts[0][shift_name]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="shifts[0][start_time]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time <span class="text-red-500">*</span></label>
                                    <input type="time" name="shifts[0][end_time]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
                                </div>
                            </div>
                            <button type="button" class="remove-shift mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Remove shift">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-shift" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Add new shift">Add Shift</button>
            </div>

            <!-- Professions -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Professions</h2>
                <div id="professions-container">
                    @foreach($employee->professions as $index => $profession)
                        <div class="profession-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <input type="hidden" name="professions[{{ $index }}][id]" value="{{ $profession->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="professions[{{ $index }}][title]" value="{{ old('professions.' . $index . '.title', $profession->title) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required aria-describedby="profession-title-{{ $index }}-error">
                                    @error('professions.' . $index . '.title') <p id="profession-title-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                    <select name="professions[{{ $index }}][department_id]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" aria-describedby="profession-department-{{ $index }}-error">
                                        <option value="">Select Department</option>
                                        @foreach(\App\Models\Department::all() as $department)
                                            <option value="{{ $department->id }}" {{ old('professions.' . $index . '.department_id', $profession->department_id ?? '') == $department->id ? 'selected' : '' }}>{{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('professions.' . $index . '.department_id') <p id="profession-department-{{ $index }}-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <button type="button" class="remove-profession mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" {{ $loop->first ? 'style="display: none;"' : '' }} aria-label="Remove profession">Remove</button>
                        </div>
                    @endforeach
                    <div class="profession-template" style="display: none;">
                        <div class="profession-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="professions[0][title]" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" data-required="true">
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
                            <button type="button" class="remove-profession mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" aria-label="Remove profession">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-profession" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Add new profession">Add Profession</button>
            </div>

            <!-- Specialities (Updated with Image Support) -->
<!-- Specialities (Updated with Image Support) -->
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Specialities</h2>

    <div id="specialities-container">
        @forelse($employee->specialities as $index => $speciality)
            <div class="speciality-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                {{-- pivot id is NOT needed for sync() – we only need the speciality_id --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill <span class="text-red-500">*</span></label>
                        <select
                            name="specialities[{{ $index }}][speciality_id]"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white speciality-select"
                            required
                            onchange="updateSpecialityImage(this)"
                            data-image-container="speciality-image-{{ $index }}"
                        >
                            <option value="">Select Skill</option>
                            @foreach(\App\Models\Speciality::all() as $spec)
                                <option
                                    value="{{ $spec->id }}"
                                    data-image="{{ $spec->image ? asset('storage/'.$spec->image) : '' }}"
                                    {{ old("specialities.$index.speciality_id", $speciality->pivot->speciality_id) == $spec->id ? 'selected' : '' }}
                                >{{ $spec->skill }}</option>
                            @endforeach
                        </select>

                        <div id="speciality-image-{{ $index }}" class="mt-2">
                            @if($speciality->image)
                                <img src="{{ asset('storage/'.$speciality->image) }}" alt="Speciality Image"
                                     class="w-16 h-16 object-cover rounded">
                            @endif
                        </div>

                        @error("specialities.$index.speciality_id")
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proficiency Level</label>
                        <select name="specialities[{{ $index }}][proficiency_level]"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Level</option>
                            @foreach(['Beginner','Intermediate','Advanced','Expert'] as $lvl)
                                <option value="{{ $lvl }}"
                                    {{ old("specialities.$index.proficiency_level", $speciality->pivot->proficiency_level) == $lvl ? 'selected' : '' }}>
                                    {{ $lvl }}
                                </option>
                            @endforeach
                        </select>
                        @error("specialities.$index.proficiency_level")
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Years of Experience</label>
                        <input type="number" name="specialities[{{ $index }}][years_of_experience]" min="0"
                               value="{{ old('specialities.'.$index.'.years_of_experience', $speciality->pivot->years_of_experience) }}"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="e.g., 5">
                        @error("specialities.$index.years_of_experience")
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="button"
                        class="remove-speciality mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                        {{ $loop->first ? 'style=display:none' : '' }}>
                    Remove
                </button>
            </div>
        @empty
            <!-- no rows -->
        @endforelse

        <!-- TEMPLATE (hidden) -->
        <div class="speciality-template" style="display:none;">
            <div class="speciality-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill <span class="text-red-500">*</span></label>
                        <select name="specialities[0][speciality_id]"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white speciality-select"
                                required data-required="true"
                                onchange="updateSpecialityImage(this)"
                                data-image-container="speciality-image-TPL">
                            <option value="">Select Skill</option>
                            @foreach(\App\Models\Speciality::all() as $spec)
                                <option value="{{ $spec->id }}"
                                        data-image="{{ $spec->image ? asset('storage/'.$spec->image) : '' }}">
                                    {{ $spec->skill }}
                                </option>
                            @endforeach
                        </select>
                        <div id="speciality-image-TPL" class="mt-2"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proficiency Level</label>
                        <select name="specialities[0][proficiency_level]"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Level</option>
                            <option>Beginner</option><option>Intermediate</option><option>Advanced</option><option>Expert</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Years of Experience</label>
                        <input type="number" name="specialities[0][years_of_experience]" min="0"
                               class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
                <button type="button"
                        class="remove-speciality mt-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                    Remove
                </button>
            </div>
        </div>
    </div>

    <button type="button" id="add-speciality"
            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">
        Add Speciality
    </button>
</div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.employees.show', $employee) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200" aria-label="Cancel editing">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200" aria-label="Update employee details">Update Employee</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* --------------------------------------------------------------------- *
     *  Helper: XSS-safe sanitisation (only for text inputs)
     * --------------------------------------------------------------------- */
    const sanitizeInput = (value) => value.replace(/[<>"'&]/g, '');

    /* --------------------------------------------------------------------- *
     *  Update speciality image when the <select> changes
     * --------------------------------------------------------------------- */
    window.updateSpecialityImage = function (select) {
        const imageUrl    = select.options[select.selectedIndex]?.dataset.image || '';
        const containerId = select.dataset.imageContainer;
        const container   = document.getElementById(containerId);
        if (!container) return;

        container.innerHTML = '';
        if (imageUrl) {
            const img = document.createElement('img');
            img.src      = imageUrl;
            img.alt      = 'Speciality Image';
            img.className = 'w-16 h-16 object-cover rounded';
            container.appendChild(img);
        }
    };

    /* --------------------------------------------------------------------- *
     *  Generic re-indexing (runs on form submit)
     * --------------------------------------------------------------------- */
    const reindexItems = (containerId, itemClass, fieldPrefix) => {
        const items = document.querySelectorAll(`#${containerId} .${itemClass}`);
        items.forEach((item, index) => {
            item.querySelectorAll('input, select, textarea').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes(fieldPrefix)) {
                    const newName = name.replace(/\[\d+\]/g, `[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
    };

    /* --------------------------------------------------------------------- *
     *  Generic “Add” button handler
     * --------------------------------------------------------------------- */
    const setupAddItem = (containerId, buttonId, templateSelector, fieldPrefix, startIdx = 0) => {
        const container = document.getElementById(containerId);
        const addBtn    = document.getElementById(buttonId);
        const template  = document.querySelector(templateSelector);
        if (!container || !addBtn || !template) return;

        let index = parseInt(startIdx) || 0;

        addBtn.addEventListener('click', () => {
            const clone = template.cloneNode(true);
            clone.style.display = '';
            clone.classList.remove('hidden');

            /* ---- rename every field ---- */
            clone.querySelectorAll('input, select, textarea').forEach(el => {
                const oldName = el.getAttribute('name');
                if (oldName) {
                    el.setAttribute('name', oldName.replace(/\[\d+\]/, `[${index}]`));
                }

                /* reset values */
                if (el.type === 'file') el.value = '';
                else if (el.tagName === 'SELECT') el.selectedIndex = 0;
                else el.value = '';

                /* restore required flag from template */
                if (el.dataset.required === 'true') el.required = true;

                /* ---- speciality image container handling ---- */
                if (fieldPrefix === 'specialities' && el.classList.contains('speciality-select')) {
                    el.dataset.imageContainer = `speciality-image-${index}`;
                    const imgDiv = clone.querySelector(`[id^="speciality-image-"]`);
                    if (imgDiv) imgDiv.id = `speciality-image-${index}`;
                }

                /* XSS sanitisation (skip files, dates, times) */
                if (el.type !== 'file' && el.type !== 'date' && el.type !== 'time') {
                    el.addEventListener('input', () => {
                        el.value = sanitizeInput(el.value);
                    });
                }
            });

            /* show the remove button */
            const rmBtn = clone.querySelector(`.remove-${fieldPrefix}`);
            if (rmBtn) rmBtn.style.display = 'block';

            container.appendChild(clone);
            index++;
        });
    };

    /* --------------------------------------------------------------------- *
     *  Generic “Remove” button handler (delegated)
     * --------------------------------------------------------------------- */
    const setupRemoveItem = (btnClass, itemClass) => {
        document.addEventListener('click', e => {
            if (e.target.classList.contains(btnClass)) {
                e.target.closest(`.${itemClass}`).remove();
            }
        });
    };

    /* --------------------------------------------------------------------- *
     *  Initialise section counters (used by the generic add function)
     * --------------------------------------------------------------------- */
    const initSection = (id, count) => {
        const el = document.getElementById(id);
        if (el) el.dataset.index = count;
    };

    /* --------------------------------------------------------------------- *
     *  ==== 1. Initialise every dynamic section ==========================
     * --------------------------------------------------------------------- */
    initSection('qualifications-container', {{ $employee->qualifications->count() }});
    initSection('documents-container',       {{ $employee->documents->count() }});
    initSection('addresses-container',      {{ $employee->addresses->count() }});
    initSection('family-details-container', {{ $employee->familyDetails->count() }});
    initSection('shifts-container',         {{ $employee->shifts->count() }});
    initSection('professions-container',    {{ $employee->professions->count() }});
    initSection('specialities-container',   {{ $employee->specialities->count() }});

    /* --------------------------------------------------------------------- *
     *  ==== 2. Wire-up “Add” buttons =====================================
     * --------------------------------------------------------------------- */
    setupAddItem('qualifications-container', 'add-qualification', '.qualification-template .qualification-item', 'qualification', {{ $employee->qualifications->count() }});
    setupAddItem('documents-container',      'add-document',      '.document-template .document-item',          'document',      {{ $employee->documents->count() }});
    setupAddItem('addresses-container',      'add-address',       '.address-template .address-item',           'address',       {{ $employee->addresses->count() }});
    setupAddItem('family-details-container', 'add-family-detail', '.family-detail-template .family-detail-item','family-detail',{{ $employee->familyDetails->count() }});
    setupAddItem('shifts-container',         'add-shift',         '.shift-template .shift-item',               'shift',         {{ $employee->shifts->count() }});
    setupAddItem('professions-container',    'add-profession',    '.profession-template .profession-item',     'profession',    {{ $employee->professions->count() }});
    setupAddItem('specialities-container',   'add-speciality',    '.speciality-template .speciality-item',     'specialities',  {{ $employee->specialities->count() }});

    /* --------------------------------------------------------------------- *
     *  ==== 3. Wire-up “Remove” buttons ================================
     * --------------------------------------------------------------------- */
    setupRemoveItem('remove-qualification', 'qualification-item');
    setupRemoveItem('remove-document',      'document-item');
    setupRemoveItem('remove-address',       'address-item');
    setupRemoveItem('remove-family-detail', 'family-detail-item');
    setupRemoveItem('remove-shift',         'shift-item');
    setupRemoveItem('remove-profession',    'profession-item');
    setupRemoveItem('remove-speciality',    'speciality-item');

    /* --------------------------------------------------------------------- *
     *  ==== 4. Restore required flags on template fields ================
     * --------------------------------------------------------------------- */
    document.querySelectorAll(`
        .qualification-template input, .qualification-template select,
        .document-template input, .document-template select,
        .address-template input, .address-template select,
        .family-detail-template input, .family-detail-template select,
        .shift-template input, .shift-template select,
        .profession-template input, .profession-template select,
        .speciality-template input, .speciality-template select
    `).forEach(el => {
        if (el.hasAttribute('required')) {
            el.dataset.required = 'true';
            el.removeAttribute('required');
        }
    });

    /* --------------------------------------------------------------------- *
     *  ==== 5. Show images for already-loaded specialities ==============
     * --------------------------------------------------------------------- */
    document.querySelectorAll('.speciality-select').forEach(select => {
        if (select.value) updateSpecialityImage(select);
    });

    /* --------------------------------------------------------------------- *
     *  ==== 6. Form submit – re-index + clean empty specialities =======
     * --------------------------------------------------------------------- */
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        /* ---- re-index every section ---- */
        reindexItems('qualifications-container', 'qualification-item', 'qualifications');
        reindexItems('documents-container',       'document-item',       'documents');
        reindexItems('addresses-container',       'address-item',        'addresses');
        reindexItems('family-details-container',  'family-detail-item',  'family_details');
        reindexItems('shifts-container',          'shift-item',          'shifts');
        reindexItems('professions-container',     'profession-item',     'professions');
        reindexItems('specialities-container',    'speciality-item',     'specialities');

        /* ---- remove empty speciality rows (prevents “null speciality_id”) ---- */
        const specItems = document.querySelectorAll('#specialities-container .speciality-item');
        specItems.forEach(item => {
            const sel = item.querySelector('select[name*="[speciality_id]"]');
            if (!sel || !sel.value) item.remove();
        });

        /* ---- client-side required-field validation (nice UX) ---- */
        let hasErrors = false;
        form.querySelectorAll('input[required], select[required]').forEach(input => {
            if (!input.value.trim()) {
                hasErrors = true;
                input.classList.add('border-red-500');
                if (!input.parentNode.querySelector('.text-red-600')) {
                    const err = document.createElement('p');
                    err.className = 'mt-1 text-sm text-red-600';
                    err.textContent = 'This field is required';
                    input.parentNode.appendChild(err);
                }
            } else {
                input.classList.remove('border-red-500');
                const err = input.parentNode.querySelector('.text-red-600');
                if (err && !err.querySelector('p')) err.remove();
            }
        });

        if (hasErrors) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });

    /* --------------------------------------------------------------------- *
     *  ==== 7. Phone number formatting (max 10 digits) ==================
     * --------------------------------------------------------------------- */
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', e => {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 10) v = v.slice(0, 10);
            e.target.value = v;
        });
    });
});
</script>

@endsection