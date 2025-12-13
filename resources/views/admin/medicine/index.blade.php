@extends('layouts.layout')
@section('content')
<div class="p-6">
<div class="flex justify-between mb-4">
<h2 class="text-xl font-semibold">Medicine List</h2>
<a href="{{ route('admin.medicine.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Medicine</a>
</div>


@if(session('success'))
<div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
@endif


<div class="overflow-x-auto bg-white shadow rounded">
<table class="min-w-full border">
<thead class="bg-gray-100">
<tr>
<th class="p-3 border">#</th>
<th class="p-3 border">Medicine</th>
<th class="p-3 border">Store</th>
<th class="p-3 border">Stock</th>
<th class="p-3 border">Price</th>
<th class="p-3 border">Status</th>
<th class="p-3 border">Action</th>
</tr>
</thead>
<tbody>
@foreach($medicines as $m)
<tr class="hover:bg-gray-50">
<td class="p-3 border">{{ $loop->iteration }}</td>
<td class="p-3 border font-medium">{{ $m->medicine_name }}</td>
<td class="p-3 border">{{ $m->store->store_name }}</td>
<td class="p-3 border">{{ $m->stock }}</td>
<td class="p-3 border">₹{{ $m->sale_price }}</td>
<td class="p-3 border">
<span class="px-2 py-1 text-xs rounded {{ $m->status ? 'bg-green-100 text-green-700' : 'bg-gray-200' }}">
{{ $m->status ? 'Active' : 'Inactive' }}
</span>
</td>
<td class="p-3 border">
<a href="{{ route('admin.medicine.edit',$m->id) }}" class="text-yellow-600">Edit</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection