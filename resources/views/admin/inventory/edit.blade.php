@extends('layouts.layout')
@section('content')
<div class="max-w-4xl mx-auto p-6">


<h2 class="text-xl font-semibold mb-4">Edit Inventory Entry</h2>


<div class="bg-white shadow rounded p-6">
<form method="POST" action="{{ route('admin.inventory.update', $inventory->id) }}">
@csrf
@method('PUT')


<div class="grid grid-cols-1 md:grid-cols-2 gap-4">


<div>
<label class="block text-sm font-medium">Store</label>
<select name="store_id" class="mt-1 w-full rounded border-gray-300">
@foreach($stores as $store)
<option value="{{ $store->id }}"
{{ $inventory->store_id == $store->id ? 'selected' : '' }}>
{{ $store->store_name }}
</option>
@endforeach
</select>
</div>


<div>
<label class="block text-sm font-medium">Medicine</label>
<select name="medicine_id" class="mt-1 w-full rounded border-gray-300">
@foreach($medicines as $medicine)
<option value="{{ $medicine->id }}"
{{ $inventory->medicine_id == $medicine->id ? 'selected' : '' }}>
{{ $medicine->medicine_name }}
</option>
@endforeach
</select>
</div>


<div>
<label class="block text-sm font-medium">Type</label>
<select name="type" class="mt-1 w-full rounded border-gray-300">
<option value="IN" {{ $inventory->type=='IN'?'selected':'' }}>IN</option>
<option value="OUT" {{ $inventory->type=='OUT'?'selected':'