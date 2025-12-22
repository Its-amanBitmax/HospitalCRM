@extends('layouts.layout')

@section('title', 'Add Transaction')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Add Transaction</h1>
                <p class="text-gray-600 mt-1">Record new financial transactions for your hospital management system</p>
            </div>
            <a href="{{ route('admin.transctions.index') }}" 
               class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Transactions
            </a>
        </div>
        <div class="mt-6 border-b border-gray-200"></div>
    </div>

    <!-- Main Form Card -->
    <div class="max-w-6xl mx-auto">
        <!-- Card with gradient border -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-1 shadow-lg">
            <div class="bg-white rounded-xl p-6 md:p-8">
                {{-- Errors --}}
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('admin.transctions.store') }}" method="POST" id="transactionForm">
                    @csrf

                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Module Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Module
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <select name="module" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white"
                                        required>
                                    <option value="" disabled selected>Select a module</option>
                                    <option value="patients" class="py-2">Patients</option>
                                    <option value="pharmacy" class="py-2">Pharmacy</option>
                                    <option value="doctors" class="py-2">Doctors</option>
                                    <option value="nurses" class="py-2">Nurses</option>
                                    <option value="blood_bank" class="py-2">Blood Bank</option>
                                    <option value="employee" class="py-2">Employee</option>
                                    <option value="services" class="py-2">Services</option>
                                    <option value="lab" class="py-2">Lab</option>
                                    <option value="reception" class="py-2">Reception</option>
                                    <option value="accountant" class="py-2">Accountant</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Select the department where this transaction occurred</p>
                        </div>

                        <!-- Amount Input -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Amount
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₹</span>
                                </div>
                                <input type="number" 
                                       step="0.01" 
                                       name="amount"
                                       class="pl-8 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                       placeholder="0.00"
                                       required>
                            </div>
                            <p class="text-xs text-gray-500">Enter the transaction amount in INR</p>
                        </div>

                        <!-- Transaction Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    Transaction Type
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="transaction_type" value="credit" class="sr-only peer" required>
                                    <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-green-300">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-medium text-gray-900">Credit</div>
                                                <div class="text-sm text-gray-500">Income</div>
                                            </div>
                                            <div class="w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:border-green-500 peer-checked:bg-green-500 transition-all"></div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="transaction_type" value="debit" class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-red-300">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-medium text-gray-900">Debit</div>
                                                <div class="text-sm text-gray-500">Expense</div>
                                            </div>
                                            <div class="w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:border-red-500 peer-checked:bg-red-500 transition-all"></div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Mode -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Payment Mode
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <select name="payment_mode" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white"
                                        required>
                                    <option value="" disabled selected>Select payment method</option>
                                    <option value="cash" class="py-2">Cash</option>
                                    <option value="upi" class="py-2">UPI</option>
                                    <option value="card" class="py-2">Card</option>
                                    <option value="online" class="py-2">Online</option>
                                    <option value="cheque" class="py-2">Cheque</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Status
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <select name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white"
                                        required>
                                    <option value="" disabled selected>Select transaction status</option>
                                    <option value="paid" class="py-2">Paid</option>
                                    <option value="pending" class="py-2">Pending</option>
                                    <option value="cancelled" class="py-2">Cancelled</option>
                                    <option value="refunded" class="py-2">Refunded</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Transaction Date
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input type="date" 
                                   name="transaction_date"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                   value="{{ date('Y-m-d') }}" 
                                   required>
                            <p class="text-xs text-gray-500">Date when the transaction occurred</p>
                        </div>
                    </div>

                    <!-- Remarks Section -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Remarks (Optional)
                            </span>
                        </label>
                        <div class="relative">
                            <textarea name="remarks" 
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                      placeholder="Add any additional notes about this transaction..."></textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                <span id="charCount">0</span>/500
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <p>Fields marked with <span class="text-red-500">*</span> are required</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.transctions.index') }}"
                               class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Transaction
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
            <h3 class="font-medium text-gray-900 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Quick Tips
            </h3>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-0.5">✓</span>
                    <span>Use specific remarks for better tracking and reporting</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-0.5">✓</span>
                    <span>Double-check amounts before submission</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-0.5">✓</span>
                    <span>Select correct transaction type (Credit for income, Debit for expenses)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-500 mt-0.5">✓</span>
                    <span>Update status immediately if payment conditions change</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Character counter for remarks
    document.addEventListener('DOMContentLoaded', function() {
        const remarksTextarea = document.querySelector('textarea[name="remarks"]');
        const charCount = document.getElementById('charCount');
        
        remarksTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
            
            if (this.value.length > 500) {
                charCount.classList.add('text-red-500');
                charCount.classList.remove('text-gray-400');
            } else {
                charCount.classList.remove('text-red-500');
                charCount.classList.add('text-gray-400');
            }
        });

        // Form validation enhancement
        const form = document.getElementById('transactionForm');
        form.addEventListener('submit', function(e) {
            const amount = document.querySelector('input[name="amount"]');
            if (parseFloat(amount.value) <= 0) {
                e.preventDefault();
                alert('Amount must be greater than 0');
                amount.focus();
                return false;
            }
        });

        // Date formatting
        const dateInput = document.querySelector('input[name="transaction_date"]');
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            if (selectedDate > today) {
                alert('Transaction date cannot be in the future');
                this.value = today.toISOString().split('T')[0];
            }
        });
    });
</script>
@endpush

<style>
    /* Custom scrollbar for select dropdowns */
    select::-webkit-scrollbar {
        width: 8px;
    }
    
    select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Focus styles */
    input:focus, textarea:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Smooth transitions */
    input, textarea, select, button {
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection