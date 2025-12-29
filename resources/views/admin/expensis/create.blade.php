@php
$layout = auth('accountant')->check() ? 'layouts.accountant' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add New Expense</h1>
                    <p class="text-gray-600 mt-1">Record a new expense in the system</p>
                </div>
            </div>
            
            <a href="{{ route('admin.expensis.index') }}" 
               class="flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium text-gray-700">Back to Expenses</span>
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="flex mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl p-4">
            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="text-red-800 font-medium mb-1">Please correct the following errors:</h3>
                <ul class="text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="flex items-center">
                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Main Form Card -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column - Form -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                    <form action="{{ route('admin.expensis.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Date Field -->
                        <div class="space-y-3">
                            <div class="flex items-center mb-3">
                                <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full mr-3"></div>
                                <label class="text-sm font-semibold text-gray-800">
                                    Expense Date <span class="text-red-500">*</span>
                                </label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" name="date" value="{{ old('date') }}" 
                                           class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-300"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Reason Field -->
                        <div class="space-y-3">
                            <div class="flex items-center mb-3">
                                <div class="w-2 h-8 bg-gradient-to-b from-green-500 to-emerald-500 rounded-full mr-3"></div>
                                <label class="text-sm font-semibold text-gray-800">
                                    Reason for Expense <span class="text-red-500">*</span>
                                </label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="reason" value="{{ old('reason') }}" 
                                           placeholder="Office supplies, Client meeting, Equipment purchase" 
                                           class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition-all duration-300"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Department Field -->
                        <div class="space-y-3">
                            <div class="flex items-center mb-3">
                                <div class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full mr-3"></div>
                                <label class="text-sm font-semibold text-gray-800">
                                    Department
                                </label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <select name="department_id"
                                            class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-300">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Amount Field -->
                        <div class="space-y-3">
                            <div class="flex items-center mb-3">
                                <div class="w-2 h-8 bg-gradient-to-b from-amber-500 to-orange-500 rounded-full mr-3"></div>
                                <label class="text-sm font-semibold text-gray-800">
                                    Amount <span class="text-red-500">*</span>
                                </label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-lg font-medium">₹</span>
                                    </div>
                                    <input type="number" name="amount" step="0.01" value="{{ old('amount') }}" 
                                           placeholder="0.00"
                                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white transition-all duration-300"
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 text-sm mr-5">INR</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 ml-5">Enter amount in Indian Rupees (₹)</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" 
                                    class="w-full flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Save Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Tips & Info -->
            <div class="lg:w-96">
                <div class="sticky top-6 space-y-6">
                    <!-- Form Tips -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-start mb-4">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Tips for accurate expense recording</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Be specific with the reason to help with future categorization</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Use consistent department names for better reporting</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Double-check the amount before submitting</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Submit expenses promptly for timely processing</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Required Fields Note -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-gray-800">Required Information</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <span class="text-xs font-medium bg-red-100 text-red-800 px-2 py-1 rounded mr-2">*</span>
                                <span class="text-sm text-gray-600">Expense Date</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs font-medium bg-red-100 text-red-800 px-2 py-1 rounded mr-2">*</span>
                                <span class="text-sm text-gray-600">Reason for Expense</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs font-medium bg-red-100 text-red-800 px-2 py-1 rounded mr-2">*</span>
                                <span class="text-sm text-gray-600">Amount</span>
                            </div>
                            <div class="pt-3 mt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-500">Department field is optional but recommended for better tracking.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-green-800">Quick Actions</h3>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('admin.expensis.index') }}" 
                               class="flex items-center justify-center w-full px-4 py-2.5 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View All Expenses
                            </a>
                            <button type="button" onclick="window.location.reload()" 
                                    class="flex items-center justify-center w-full px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Note -->
        <div class="mt-6 flex items-center justify-center">
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>All submitted expenses will be reviewed and processed within 3-5 business days.</span>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default date to today
    const dateInput = document.querySelector('input[name="date"]');
    if (dateInput && !dateInput.value) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        dateInput.value = `${yyyy}-${mm}-${dd}`;
    }

    // Add amount formatting
    const amountInput = document.querySelector('input[name="amount"]');
    if (amountInput) {
        amountInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    }

    // Form validation styling
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredInputs = form.querySelectorAll('[required]');
            let hasEmpty = false;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500', 'bg-red-50');
                    hasEmpty = true;
                } else {
                    input.classList.remove('border-red-500', 'bg-red-50');
                }
            });
            
            if (hasEmpty) {
                e.preventDefault();
                // Scroll to first error
                const firstError = form.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }
});
</script>
@endsection