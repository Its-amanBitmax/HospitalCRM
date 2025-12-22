@php
$layout = auth('pharmacist')->check() ? 'layouts.pharmacist' : 'layouts.layout';
@endphp

@extends($layout)
@section('content')

<div class="">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Sales Billing (POS)</h2>
            <p class="text-gray-600">Create new sales invoice</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Message from Controller -->
        @if(session('error'))
        <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.sales.store') }}"
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" id="sale-form">
            @csrf

            <!-- Store & Customer Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                    <i class="fas fa-store mr-2 text-blue-500"></i>Store & Customer Details
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Store -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Store <span class="text-red-500">*</span>
                        </label>
                        <select name="store_id" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 bg-white">
                            <option value="" disabled selected>Select Store</option>
                            @foreach($stores as $store)
                            <option value="{{ $store->id }}">
                                {{ $store->store_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Customer Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Customer Name
                        </label>
                        <input type="text" name="customer_name"
                            placeholder="Enter customer name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                    </div>

                    <!-- Customer Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Customer Phone
                        </label>
                        <input type="text" name="customer_phone"
                            placeholder="Enter phone number"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Medicine Items Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">
                        <i class="fas fa-pills mr-2 text-green-500"></i>Medicine Items
                    </h3>
                    <button type="button"
                        onclick="addRow()"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg flex items-center gap-2 transition duration-200 shadow-sm hover:shadow font-medium">
                        <i class="fas fa-plus"></i>
                        Add Medicine
                    </button>
                </div>

                <!-- Items Table -->
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200" id="items-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Medicine</th>
                                <th class="px-4 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Quantity</th>
                                <th class="px-4 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-4 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-body" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>

                    <!-- Empty State -->
                    <div id="empty-state" class="py-16 text-center">
                        <div class="mx-auto w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-pills text-gray-400 text-2xl"></i>
                        </div>
                        <h4 class="text-gray-500 font-medium mb-2 text-lg">No items added</h4>
                        <p class="text-gray-400 mb-6">Click "Add Medicine" button to start adding items</p>
                    </div>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                    <i class="fas fa-calculator mr-2 text-purple-500"></i>Totals
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sub Total</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"></span>
                            <input type="number" name="sub_total" id="sub_total"
                                readonly
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"></span>
                            <input type="number" name="discount" id="discount"
                                placeholder="0.00"
                                value="0"
                                oninput="calculateTotal()"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tax</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"></span>
                            <input type="number" name="tax" id="tax"
                                placeholder="0.00"
                                value="0"
                                oninput="calculateTotal()"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grand Total</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg"></span>
                            <input type="number" name="grand_total" id="grand_total"
                                readonly
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 bg-blue-50 text-blue-700 font-bold text-lg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment & Submit -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="w-full md:w-auto">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Method <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_method" required
                            class="w-full md:w-56 px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 bg-white">
                            <option value="cash">💵 Cash</option>
                            <option value="upi">📱 UPI</option>
                            <option value="card">💳 Card</option>
                            <option value="credit">📋 Credit</option>
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <button type="button"
                            onclick="clearForm()"
                            class="px-6 py-3 rounded-lg font-medium border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 flex items-center gap-2">
                            <i class="fas fa-redo"></i>
                            Clear
                        </button>

                        <button type="submit"
                            onclick="return validateForm()"
                            class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold flex items-center justify-center gap-3 transition duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                            <i class="fas fa-check-circle text-lg"></i>
                            Complete Sale
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let medicines = @json($medicines);
    let rowIndex = 0;

    function addRow() {

        let row = `
    <tr class="hover:bg-gray-50 transition duration-200">
        <td class="px-4 py-3">
            <select name="items[${rowIndex}][medicine_id]"
                onchange="setPrice(this, ${rowIndex})"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white">
                <option value="">Select Medicine</option>
                ${medicines.map(m =>
                    `<option value="${m.id}" data-price="${m.sale_price}">
                        ${m.medicine_name} - ₹${m.sale_price}
                    </option>`
                ).join('')}
            </select>
        </td>

        <td class="px-4 py-3">
            <input type="number"
                name="items[${rowIndex}][quantity]"
                value="1"
                min="1"
                oninput="rowTotal(${rowIndex})"
                class="w-full px-4 py-3 rounded-lg border border-gray-300">
        </td>

        <td class="px-4 py-3">
            <input type="number"
                name="items[${rowIndex}][price]"
                readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-50">
        </td>

        <td class="px-4 py-3">
            <input type="number"
                name="items[${rowIndex}][total]"
                readonly
                class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-green-50">
        </td>

        <td class="px-4 py-3">
            <button type="button"
                onclick="removeRow(this)"
                class="text-red-600">
                Delete
            </button>
        </td>
    </tr>
    `;

        document.getElementById('items-body')
            .insertAdjacentHTML('beforeend', row);

        document.getElementById('empty-state').style.display = 'none';
        rowIndex++;
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
        calculateTotal();

        if (document.querySelectorAll('#items-body tr').length === 0) {
            document.getElementById('empty-state').style.display = 'block';
        }
    }

    function setPrice(select, index) {
        let price = select.selectedOptions[0].dataset.price || 0;
        document.querySelector(`[name="items[${index}][price]"]`).value = price;
        rowTotal(index);
    }

    function rowTotal(index) {
        let qty = parseFloat(
            document.querySelector(`[name="items[${index}][quantity]"]`).value
        ) || 0;

        let price = parseFloat(
            document.querySelector(`[name="items[${index}][price]"]`).value
        ) || 0;

        document.querySelector(`[name="items[${index}][total]"]`)
            .value = (qty * price).toFixed(2);

        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('[name$="[total]"]').forEach(i => {
            total += parseFloat(i.value) || 0;
        });

        let discount = parseFloat(document.getElementById('discount').value) || 0;
        let tax = parseFloat(document.getElementById('tax').value) || 0;

        document.getElementById('sub_total').value = total.toFixed(2);
        document.getElementById('grand_total').value = (total - discount + tax).toFixed(2);
    }

    function validateForm() {
        let rows = document.querySelectorAll('#items-body tr');
        if (rows.length === 0) {
            alert('Please add at least one medicine.');
            return false;
        }
        return true;
    }

    function clearForm() {
        document.getElementById('items-body').innerHTML = '';
        document.getElementById('empty-state').style.display = 'block';
        document.getElementById('sub_total').value = '';
        document.getElementById('discount').value = 0;
        document.getElementById('tax').value = 0;
        document.getElementById('grand_total').value = '';
        rowIndex = 0;
    }
</script>


<!-- Add Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Improved input and select styling */
    input,
    select {
        padding: 0.75rem 1rem !important;
        font-size: 1rem;
        line-height: 1.5;
    }

    /* Remove spinner buttons from number inputs */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Better focus states */
    input:focus,
    select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Table row hover effect */
    tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Custom scrollbar for select dropdowns */
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5em;
        padding-right: 2.5rem !important;
    }
</style>

@endsection