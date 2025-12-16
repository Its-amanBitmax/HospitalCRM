@extends('layouts.layout')

@section('content')
<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Sales / Billing List</h2>

        <a href="{{ route('admin.sales.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
            + New Sale
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Sales Table -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border text-left">#</th>
                    <th class="px-4 py-3 border text-left">Invoice No</th>
                    <th class="px-4 py-3 border text-left">Store</th>
                    <th class="px-4 py-3 border text-left">Customer</th>
                    <th class="px-4 py-3 border text-right">Amount</th>
                    <th class="px-4 py-3 border text-center">Payment</th>
                    <th class="px-4 py-3 border text-center">Date</th>
                    <th class="px-4 py-3 border text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sales as $sale)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-2 border font-medium">
                            {{ $sale->invoice_no }}
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $sale->store->store_name ?? '-' }}
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $sale->customer_name ?? '-' }}
                        </td>

                        <td class="px-4 py-2 border text-right font-semibold">
                            ₹{{ number_format($sale->grand_total, 2) }}
                        </td>

                        <td class="px-4 py-2 border text-center">
                            <span class="px-2 py-1 rounded text-xs
                                {{ $sale->payment_method == 'cash' ? 'bg-green-100 text-green-700' :
                                   ($sale->payment_method == 'upi' ? 'bg-blue-100 text-blue-700' :
                                   'bg-purple-100 text-purple-700') }}">
                                {{ strtoupper($sale->payment_method) }}
                            </span>
                        </td>

                        <td class="px-4 py-2 border text-center">
                            {{ $sale->created_at->format('d-m-Y') }}
                        </td>

                        <td class="px-4 py-2 border text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.sales.edit', $sale->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>

                                <a href="{{ route('admin.sales.show', $sale->id) }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">
                                    View
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                            No sales found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
