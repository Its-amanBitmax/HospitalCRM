@extends('layouts.layout')
@section('content')

<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Sales Billing (POS)</h2>

    <form method="POST" action="{{ route('admin.sales.store') }}">
        @csrf

        <!-- Store & Customer -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

            <!-- Store -->
            <select name="store_id" required class="rounded border-gray-300">
                <option value="">Select Store</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}">
                        {{ $store->store_name }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="customer_name"
                   placeholder="Customer Name"
                   class="rounded border-gray-300">

            <input type="text" name="customer_phone"
                   placeholder="Customer Phone"
                   class="rounded border-gray-300">
        </div>

        <!-- 🔥 MEDICINE ITEMS TABLE -->
        <div class="bg-white shadow rounded overflow-x-auto mb-6">
            <table class="min-w-full border" id="items-table">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Medicine</th>
                        <th class="p-2 border">Qty</th>
                        <th class="p-2 border">Price</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody id="items-body"></tbody>
            </table>
        </div>

        <button type="button"
            onclick="addRow()"
            class="bg-blue-600 text-white px-4 py-2 rounded mb-4">
            + Add Medicine
        </button>

        <!-- Totals -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <input type="number" name="sub_total" id="sub_total"
                   placeholder="Sub Total" readonly
                   class="rounded border-gray-300">

            <input type="number" name="discount" id="discount"
                   placeholder="Discount"
                   oninput="calculateTotal()"
                   class="rounded border-gray-300">

            <input type="number" name="tax" id="tax"
                   placeholder="Tax"
                   oninput="calculateTotal()"
                   class="rounded border-gray-300">

            <input type="number" name="grand_total" id="grand_total"
                   placeholder="Grand Total" readonly
                   class="rounded border-gray-300">
        </div>

        <select name="payment_method"
                class="mt-4 rounded border-gray-300">
            <option value="cash">Cash</option>
            <option value="upi">UPI</option>
            <option value="card">Card</option>
        </select>

        <button class="mt-6 bg-green-600 text-white px-6 py-2 rounded">
            Complete Sale
        </button>
    </form>

    <!-- 🔽 PREVIOUS SALES ITEMS LIST -->
    @if(isset($sales) && $sales->count())
    <div class="mt-10">
        <h3 class="text-lg font-semibold mb-3">Recent Sales</h3>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Invoice</th>
                        <th class="p-2 border">Customer</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border">{{ $sale->invoice_no }}</td>
                        <td class="p-2 border">{{ $sale->customer_name ?? '-' }}</td>
                        <td class="p-2 border">₹{{ $sale->grand_total }}</td>
                        <td class="p-2 border">{{ $sale->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<script>
let medicines = @json($medicines);

function addRow() {
    let row = `
    <tr>
        <td class="border p-2">
            <select name="items[][medicine_id]"
                onchange="setPrice(this)"
                class="rounded border-gray-300">
                <option value="">Select</option>
                ${medicines.map(m =>
                    `<option value="${m.id}" data-price="${m.sale_price}">
                        ${m.medicine_name}
                    </option>`).join('')}
            </select>
        </td>
        <td class="border p-2">
            <input type="number" value="1"
                name="items[][quantity]"
                oninput="rowTotal(this)"
                class="w-20 rounded border-gray-300">
        </td>
        <td class="border p-2">
            <input type="number"
                name="items[][price]"
                readonly
                class="w-24 rounded border-gray-300">
        </td>
        <td class="border p-2">
            <input type="number"
                name="items[][total]"
                readonly
                class="w-24 rounded border-gray-300">
        </td>
        <td class="border p-2">
            <button type="button"
                onclick="this.closest('tr').remove();calculateTotal()"
                class="text-red-600">X</button>
        </td>
    </tr>`;
    document.getElementById('items-body')
        .insertAdjacentHTML('beforeend', row);
}

function setPrice(el) {
    let price = el.selectedOptions[0].dataset.price;
    let row = el.closest('tr');
    row.querySelector('[name="items[][price]"]').value = price;
    rowTotal(row.querySelector('[name="items[][quantity]"]'));
}

function rowTotal(el) {
    let row = el.closest('tr');
    let qty = el.value;
    let price = row.querySelector('[name="items[][price]"]').value;
    row.querySelector('[name="items[][total]"]').value = qty * price;
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('[name="items[][total]"]')
        .forEach(i => total += Number(i.value || 0));

    document.getElementById('sub_total').value = total;
    let discount = Number(document.getElementById('discount').value || 0);
    let tax = Number(document.getElementById('tax').value || 0);
    document.getElementById('grand_total').value = total - discount + tax;
}
</script>

@endsection
