@extends('layouts.layout')
@section('content')
<div class="max-w-4xl mx-auto p-6">


<h2 class="text-xl font-semibold mb-4">Add Inventory Entry</h2>


<div class="bg-white shadow rounded p-6">
<form method="POST" action="{{ route('admin.inventory.store') }}">
@csrf


<div class="grid grid-cols-1 md:grid-cols-2 gap-4">


<div>
<label class="block text-sm font-medium">Store</label>
<select name="store_id" required class="mt-1 w-full rounded border-gray-300">
<option value="">Select Store</option>
@foreach($stores as $store)
<option value="{{ $store->id }}">{{ $store->store_name }}</option>
@endforeach
</select>
</div>


<div>
<label class="block text-sm font-medium">Medicine</label>
<select name="medicine_id" required class="mt-1 w-full rounded border-gray-300">
<option value="">Select Medicine</option>
@foreach($medicines as $medicine)
<option value="{{ $medicine->id }}">
{{ $medicine->medicine_name }} (Stock: {{ $medicine->stock }})
</option>
@endforeach
</select>
</div>


<div>
<label class="block text-sm font-medium">Type</label>
<select name="type" required class="mt-1 w-full rounded border-gray-300">
<option value="IN">IN (Add Stock)</option>
<option value="OUT">OUT (Reduce Stock)</option>
<option value="ADJUST">ADJUST (Set Stock)</option>
</select>
</div>


<div>
<label class="block text-sm font-medium">Quantity</label>
<input type="number" name="quantity" required
class="mt-1 w-full rounded border-gray-300">
</div>


<div>
<label class="block text-sm font-medium">Reference</label>
<input type="text" name="reference"
class="mt-1 w-full rounded border-gray-300">
</div>


<div class="md:col-span-2">
<label class="block text-sm font-medium">Note</label>
<textarea name="note" rows="3"
class="mt-1 w-full rounded border-gray-300"></textarea>
</div>


</div>


<div class="mt-6 flex gap-3">
<button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
Save Entry
</button>
<a href="{{ route('admin.inventory.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
Back
</a>
</div>


</form>
</div>
</div>
@endsection