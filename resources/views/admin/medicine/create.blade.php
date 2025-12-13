@extends('layouts.layout')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Add Medicine</h2>
        <p class="text-sm text-gray-500">Create new medicine for store</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST"
              action="{{ route('admin.medicine.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Store -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Store *</label>
                    <select name="store_id" required
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500">
                        <option value="">Select Store</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}">
                                {{ $store->store_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Medicine Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Medicine Name *</label>
                    <input type="text" name="medicine_name" required
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500">
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                    <input type="text" name="brand"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Batch -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Batch No</label>
                    <input type="text" name="batch_no"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Expiry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                    <input type="date" name="expiry_date"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Purchase Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Purchase Price</label>
                    <input type="number" step="0.01" name="purchase_price"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Sale Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sale Price *</label>
                    <input type="number" step="0.01" name="sale_price" required
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock"
                        class="mt-1 w-full rounded-lg border-gray-300">
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Medicine Image</label>
                    <input type="file" name="image"
                        class="mt-1 w-full text-sm">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                        class="mt-1 w-full rounded-lg border-gray-300">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    Save Medicine
                </button>
                <a href="{{ route('admin.medicine.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Back
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
