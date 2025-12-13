@extends('layouts.layout')
@section('content')
<div class="p-6">
<div class="flex justify-between mb-4">
<h2 class="text-xl font-semibold">Inventory Logs</h2>
<a href="{{ route('admin.inventory.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Entry</a>
</div>


<div class="bg-white shadow rounded overflow-x-auto">
<table class="min-w-full border">
<thead class="bg-gray-100">
<tr>
<th class="p-3 border">Date</th>
<th class="p-3 border">Store</th>
<th class="p-3 border">Medicine</th>
<th class="p-3 border">Type</th>
<th class="p-3 border">Qty</th>
<th class="p-3 border">Stock</th>
<th class="p-3 border">Reference</th>
</tr>
</thead>
<tbody>
@foreach($inventories as $inv)
<tr class="hover:bg-gray-50">
<td class="p-3 border">{{ $inv->created_at->format('d-m-Y') }}</td>
<td class="p-3 border">{{ $inv->store->store_name }}</td>
<td class="p-3 border">{{ $inv->medicine->medicine_name }}</td>
<td class="p-3 border">
<span class="px-2 py-1 text-xs rounded
{{ $inv->type=='IN' ? 'bg-green-100 text-green-700' : ($inv->type=='OUT' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
{{ $inv->type }}
</span>
</td>
<td class="p-3 border">{{ $inv->quantity }}</td>
<td class="p-3 border">{{ $inv->stock_before }} → {{ $inv->stock_after }}</td>
<td class="p-3 border">{{ $inv->reference ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection