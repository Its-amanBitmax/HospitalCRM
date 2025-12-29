@php
$layout = auth('accountant')->check() ? 'layouts.accountant' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Expense</h1>
                    <p class="text-gray-600 mt-1">Update the expense details below</p>
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

        <!-- Main Content Area -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column - Form -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
                    <form action="{{ route('admin.expensis.update', $expense->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

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
                                    <input type="date" name="date" value="{{ $expense->date->format('Y-m-d') }}" 
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
                                    <input type="text" name="reason" value="{{ $expense->reason }}" 
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
                                            class="w-full pl-10 pr-10 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all duration-300 appearance-none">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $expense->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
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
                                    <input type="number" name="amount" step="0.01" value="{{ $expense->amount }}" 
                                           placeholder="0.00"
                                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 focus:bg-white transition-all duration-300"
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 text-sm">INR</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 ml-5">Enter amount in Indian Rupees (₹)</p>
                        </div>

                        <!-- Original Info -->
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Original Information</span>
                            </div>
                            <div class="flex flex-wrap gap-4 text-sm">
                                <div class="flex items-center">
                                    <span class="text-gray-500">Added By:</span>
                                    <span class="font-medium text-gray-800 ml-2">{{ $expense->added_by }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500">UID:</span>
                                    <span class="font-medium text-gray-800 ml-2">{{ $expense->uid }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-500">Created:</span>
                                    <span class="font-medium text-gray-800 ml-2">{{ $expense->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-6">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit" 
                                        class="flex-1 flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Expense
                                </button>
                                
                                <a href="{{ route('admin.expensis.index') }}" 
                                   class="flex-1 flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Info & Danger Zone -->
            <div class="lg:w-96">
                <div class="sticky top-6 space-y-6">
                    <!-- Expense Info -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Editing Expense Details</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Make sure all required fields are filled properly</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Changes will be logged in the system</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5 mr-3 flex-shrink-0"></div>
                                <span class="text-sm text-blue-700">Original information is preserved for audit trail</span>
                            </li>
                        </ul>
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
                            <button type="button" onclick="resetForm()" 
                                    class="flex items-center justify-center w-full px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Form
                            </button>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 border border-red-100">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-red-800">Danger Zone</h3>
                        </div>
                        <p class="text-sm text-red-700 mb-4">Once you delete this expense, there is no going back. Please be certain.</p>
                        <form action="{{ route('admin.expensis.destroy', $expense->id) }}" method="POST" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Expense
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this expense? This action cannot be undone.');
}

function resetForm() {
    const form = document.querySelector('form');
    if (form) {
        form.reset();
        // Set date back to original value
        const dateInput = form.querySelector('input[name="date"]');
        if (dateInput) {
            dateInput.value = "{{ $expense->date->format('Y-m-d') }}";
        }
        
        // Set amount back to original value
        const amountInput = form.querySelector('input[name="amount"]');
        if (amountInput) {
            amountInput.value = "{{ $expense->amount }}";
        }
        
        // Set reason back to original value
        const reasonInput = form.querySelector('input[name="reason"]');
        if (reasonInput) {
            reasonInput.value = "{{ $expense->reason }}";
        }
        
        // Set department back to original value
        const departmentSelect = form.querySelector('select[name="department_id"]');
        if (departmentSelect) {
            departmentSelect.value = "{{ $expense->department_id }}";
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
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