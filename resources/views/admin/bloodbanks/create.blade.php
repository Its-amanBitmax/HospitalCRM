@extends('layouts.layout')

@section('content')
<div class="max-w-3xl mx-auto py-6">

<h1 class="text-2xl font-bold mb-6 text-red-700">Add Blood Entry</h1>

<form method="POST" action="{{ route('admin.bloodbanks.store') }}"
      class="bg-white p-6 rounded-lg shadow space-y-4">
@csrf

<input name="donor_name" required placeholder="Donor Name"
       class="w-full border px-3 py-2 rounded">

<input name="donor_contact" required placeholder="Contact"
       class="w-full border px-3 py-2 rounded">

<textarea name="donor_address"
          placeholder="Address"
          class="w-full border px-3 py-2 rounded"></textarea>

<select name="blood_group" required class="w-full border px-3 py-2 rounded">
<option value="">Blood Group</option>
@foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
<option>{{ $bg }}</option>
@endforeach
</select>

<input type="number" name="units" required min="1"
       placeholder="Units"
       class="w-full border px-3 py-2 rounded">

<select name="status" class="w-full border px-3 py-2 rounded">
<option value="available">Available</option>
<option value="low">Low</option>
<option value="out_of_stock">Out of Stock</option>
</select>

<button class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">
Save
</button>

</form>
</div>
@endsection
