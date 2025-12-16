@extends('layouts.layout')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Edit Store</h2>
        <p class="text-sm text-gray-500">Update pharmacy / medical store details</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg p-6">

        <form method="POST" action="{{ route('admin.store.update', $store->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Store Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Store Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="store_name" required
                        value="{{ $store->store_name }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Owner Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Owner Name
                    </label>
                    <input type="text" name="owner_name"
                        value="{{ $store->owner_name }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Phone
                    </label>
                    <input type="text" name="phone"
                        value="{{ $store->phone }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input type="email" name="email"
                        value="{{ $store->email }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- License -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        License No
                    </label>
                    <input type="text" name="license_no"
                        value="{{ $store->license_no }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- GST -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        GST No
                    </label>
                    <input type="text" name="gst_no"
                        value="{{ $store->gst_no }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Address
                    </label>
                    <textarea name="address" rows="3"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ $store->address }}</textarea>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Status
                    </label>
                    <select name="status"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="1" {{ $store->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$store->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium">
                    Update Store
                </button>

                <a href="{{ route('admin.store.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm font-medium">
                    Back
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
