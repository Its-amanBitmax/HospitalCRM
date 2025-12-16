@extends('layouts.layout')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Edit Medicine</h2>
        <p class="text-sm text-gray-500">Update medicine details</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST"
              action="{{ route('admin.medicine.update', $medicine->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Store -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Store *</label>
                    <select name="store_id"
                        class="mt-1 w-full rounded-lg border-gray-300">
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}"
                                {{ $medicine->store_id == $store->id ? 'selected' : '' }}>
                                {{ $store->store_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Medicine Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Medicine Name *</label>
                    <input type="text" name="medicine_name" required
                        value="{{ $medicine->medicine_name }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                    <input type="text" name="brand"
                        value="{{ $medicine->brand }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category"
                        value="{{ $medicine->category }}"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Batch -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Batch No</label>
                    <input type="text" name="batch_no"
