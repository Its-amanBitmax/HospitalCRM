@extends('layouts.layout')

@section('title', 'Blood Bank')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-red-700 flex items-center gap-2">
            🩸 Blood Bank Management
        </h1>

        <a href="{{ route('admin.bloodbanks.create') }}"
           class="bg-red-600 text-white px-6 py-3 rounded-xl shadow hover:bg-red-700">
            + Add Blood Entry
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-red-100 text-red-800 text-sm uppercase">
            <tr>
                <th class="px-4 py-3">#</th>
                <th>Donor Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y text-sm">
            @forelse($bloods as $i => $blood)
                <tr class="hover:bg-red-50">
                    <td class="px-4 py-3 font-semibold">{{ $i+1 }}</td>

                    <td class="font-medium text-gray-900">
                        {{ $blood->donor_name }}
                    </td>

                    <td>{{ $blood->donor_contact }}</td>

                    <td class="text-gray-600">
                        {{ $blood->donor_address ?? '—' }}
                    </td>

                    <td class="font-semibold">
                        {{ $blood->blood_group }}
                    </td>

                    <td>{{ $blood->units }}</td>

                    <td>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $blood->status === 'available' ? 'bg-green-100 text-green-800' :
                           ($blood->status === 'low' ? 'bg-yellow-100 text-yellow-800' :
                           'bg-red-100 text-red-800') }}">
                        {{ strtoupper(str_replace('_',' ', $blood->status)) }}
                        </span>
                    </td>

                    <td class="flex gap-2">
                        <a href="{{ route('admin.bloodbanks.edit', $blood->id) }}"
                           class="px-3 py-1 text-indigo-700 bg-indigo-50 rounded hover:bg-indigo-100">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.bloodbanks.destroy', $blood->id) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                onclick="return confirm('Delete this blood record?')"
                                class="px-3 py-1 text-red-700 bg-red-50 rounded hover:bg-red-100">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                        No blood records found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
