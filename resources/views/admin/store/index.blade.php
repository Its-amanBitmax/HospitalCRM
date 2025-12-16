@extends('layouts.layout')

@section('content')
<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Store List</h2>
        <a href="{{ route('admin.store.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
            + Add Store
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left border">#</th>
                    <th class="px-4 py-3 text-left border">Store Name</th>
                    <th class="px-4 py-3 text-left border">Owner</th>
                    <th class="px-4 py-3 text-left border">Phone</th>
                    <th class="px-4 py-3 text-left border">License</th>
                    <th class="px-4 py-3 text-left border">Status</th>
                    <th class="px-4 py-3 text-center border">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($stores as $store)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 border font-medium">
                            {{ $store->store_name }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ $store->owner_name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ $store->phone ?? '-' }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ $store->license_no ?? '-' }}
                        </td>
                        <td class="px-4 py-3 border">
                            @if($store->status)
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 border text-center">
    <div class="flex justify-center gap-2">

        <!-- Edit -->
        <a href="{{ route('admin.store.edit', $store->id) }}"
           class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
            Edit
        </a>

        <!-- Delete -->
        <form action="{{ route('admin.store.destroy', $store->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this store?');">
            @csrf
            @method('DELETE')

            <button type="submit"
                class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                Delete
            </button>
        </form>

    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            No stores found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
