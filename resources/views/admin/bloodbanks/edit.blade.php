@extends('layouts.layout')

@section('title', 'Edit Blood Entry')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-red-700">
            🩸 Edit Blood Entry
        </h1>

        <a href="{{ route('admin.bloodbanks.index') }}"
           class="px-5 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
            ← Back
        </a>
    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('admin.bloodbanks.update', $bloodBank->id) }}"
          class="bg-white shadow-lg rounded-xl p-6 space-y-4">
        @csrf
        @method('PUT')

        {{-- Donor Name --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Donor Name</label>
            <input type="text" name="donor_name" required
                   value="{{ old('donor_name', $bloodBank->donor_name) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Contact --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Contact</label>
            <input type="text" name="donor_contact" required
                   value="{{ old('donor_contact', $bloodBank->donor_contact) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Address --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Address</label>
            <textarea name="donor_address"
                      class="w-full border rounded px-3 py-2">{{ old('donor_address', $bloodBank->donor_address) }}</textarea>
        </div>

        {{-- Blood Group --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Blood Group</label>
            <select name="blood_group" required class="w-full border rounded px-3 py-2">
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                    <option value="{{ $bg }}"
                        {{ old('blood_group', $bloodBank->blood_group) == $bg ? 'selected' : '' }}>
                        {{ $bg }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Units --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Units</label>
            <input type="number" name="units" min="0" required
                   value="{{ old('units', $bloodBank->units) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-sm font-semibold mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="available" {{ $bloodBank->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="low" {{ $bloodBank->status == 'low' ? 'selected' : '' }}>Low</option>
                <option value="out_of_stock" {{ $bloodBank->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
            </select>
        </div>

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-4 pt-4 border-t">
            <a href="{{ route('admin.bloodbanks.index') }}"
               class="px-6 py-2 border rounded text-gray-700">
                Cancel
            </a>

            <button type="submit"
                    class="px-8 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
