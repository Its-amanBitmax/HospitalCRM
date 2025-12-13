@extends('layouts.layout')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Edit Sale</h2>
        <p class="text-sm text-gray-500">
            Invoice No: <span class="font-medium">{{ $sale->invoice_no }}</span>
        </p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">

        <form method="POST" action="{{ route('admin.sales.update', $sale->id) }}">
            @csrf
            @method('PUT')

            <!-- Customer Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Customer Name
                    </label>
                    <input type="text" name="customer_name"
                        value="{{ $sale->customer_name }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Customer Phone
                    </label>
                    <input type="text" name="customer_phone"
                        value="{{ $sale->customer_phone }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500">
                </div>

            </div>

            <!-- Sale Items (READ ONLY) -->
            <div class="mb-6">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">
                    Sold Medicines (Read Only)
                </h4>

                <div class="overflow-x-auto border rounded">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">Medicine</th>
                                <th class="p-2 border">Qty</th>
                                <th class="p-2 border">Price</th>
                                <th class="p-2 border">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                                <tr>
                                    <td class="p-2 border">
                                        {{ $item->medicine->medicine_name }}
                                    </td>
                                    <td class="p-2 border text-center">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="p-2 border text-right">
                                        ₹{{ number_format($item->price,2) }}
                                    </td>
                                    <td class="p-2 border text-right">
                                        ₹{{ number_format($item->total,2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <div>
                    <label class="block text-sm font-medium">Sub Total</label>
                    <input type="number" readonly
                        value="{{ $sale->sub_total }}"
                        class="mt-1 w-full rounded-lg bg-gray-100 border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium">Discount</label>
                    <input type="number" name="discount"
                        value="{{ $sale->discount }}"
                        oninput="calculateTotal()"
                        id="discount"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium">Tax</label>
                    <input type="number" name="tax"
                        value="{{ $sale->tax }}"
                        oninput="calculateTotal()"
                        id="tax"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <div>
                    <label class="block text-sm font-medium">Grand Total</label>
                    <input type="number" readonly
                        id="grand_total"
                        value="{{ $sale->grand_total }}"
                        class="mt-1 w-full rounded-lg bg-gray-100 border-gray-300">
                </div>

            </div>

            <!-- Payment -->
            <div class="mb-6">
                <label class="block text-sm font-medium">Payment Method</label>
                <select name="payment_method"
                    class="mt-1 w-full md:w-1/3 rounded-lg border-gray-300">
                    <option value="cash" {{ $sale->payment_method=='cash'?'selected':'' }}>Cash</option>
                    <option value="upi" {{ $sale->payment_method=='upi'?'selected':'' }}>UPI</option>
                    <option value="card" {{ $sale->payment_method=='card'?'selected':'' }}>Card</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    Update Sale
                </button>

                <a href="{{ route('admin.sales.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Back
                </a>
            </div>

        </form>
    </div>
</div>

<script>
function calculateTotal() {
    let sub = {{ $sale->sub_total }};
    let discount = Number(document.getElementById('discount').value || 0);
    let tax = Number(document.getElementById('tax').value || 0);

    document.getElementById('grand_total').value = sub - discount + tax;
}
</script>
@endsection
