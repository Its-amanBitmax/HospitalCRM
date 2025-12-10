@extends('layouts.layout')

@section('title', 'Ambulance Management')

@section('content')
<div class="container mx-auto px-2 py-6">

    {{-- ===== HEADER ===== --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-red-600 via-rose-700 to-pink-800 rounded-2xl shadow-2xl mb-8">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-red-300 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-pink-300 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 p-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-3 flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <i class="fas fa-ambulance text-2xl"></i>
                        </div>
                        Ambulance Management
                    </h1>
                    <p class="text-red-100 text-lg">
                        Manage ambulances, drivers and availability
                    </p>
                </div>

                <a href="{{ route('admin.ambulances.create') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-white text-red-700 rounded-xl
                          hover:bg-red-50 transition font-semibold shadow-lg">
                    <i class="fas fa-plus-circle text-xl"></i>
                    Add New Ambulance
                </a>
            </div>
        </div>
    </div>

    {{-- ===== STATS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border">
            <p class="text-sm text-gray-600">Total Ambulances</p>
            <p class="text-4xl font-bold text-gray-900">{{ $totalAmbulances }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border">
            <p class="text-sm text-gray-600">Available</p>
            <p class="text-4xl font-bold text-green-600">{{ $availableAmbulances }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border">
            <p class="text-sm text-gray-600">In Use / Maintenance</p>
            <p class="text-4xl font-bold text-red-600">{{ $busyAmbulances }}</p>
        </div>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
        <div class="px-6 py-5 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-list text-red-600"></i>
                Ambulance List
            </h2>
            <span class="text-sm text-gray-600">
                {{ $ambulances->count() }} records
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                <tr>
                    <th class="px-4 py-4">#</th>
                    <th class="px-4 py-4">Ambulance No</th>
                    <th class="px-4 py-4">Type</th>
                    <th class="px-4 py-4">Driver</th>
                    <th class="px-4 py-4">Status</th>
                    <th class="px-4 py-4">Actions</th>
                </tr>
                </thead>

                <tbody class="divide-y">
                @forelse($ambulances as $i => $a)
                <tr class="hover:bg-red-50 transition">
                    <td class="px-4 py-4 font-semibold text-gray-700">{{ $i+1 }}</td>

                    <td class="px-4 py-4">
                        <span class="font-semibold text-gray-900">
                            {{ $a->ambulance_number }}
                        </span>
                    </td>

                    <td class="px-4 py-4 text-gray-700">
                        {{ $a->vehicle_type }}
                    </td>

                    <td class="px-4 py-4">
                        @if($a->driver)
                            <span class="text-gray-900 font-medium">
                                {{ $a->driver->name }}
                            </span>
                        @else
                            <span class="text-gray-400 italic">Not Assigned</span>
                        @endif
                    </td>

                    <td class="px-4 py-4">
                        @php
                            $colors = [
                                'available' => 'green',
                                'in_use' => 'yellow',
                                'maintenance' => 'orange',
                                'out_of_service' => 'red'
                            ];
                        @endphp
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                     bg-{{ $colors[$a->status] }}-100
                                     text-{{ $colors[$a->status] }}-800">
                            {{ strtoupper(str_replace('_',' ',$a->status)) }}
                        </span>
                    </td>

                    <td class="px-4 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.ambulances.edit',$a->id) }}"
                               class="px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg
                                      hover:bg-yellow-100 text-sm font-medium">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.ambulances.destroy',$a->id) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Delete this ambulance?')"
                                    class="px-4 py-2 bg-red-50 text-red-700 rounded-lg
                                           hover:bg-red-100 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-12 text-center text-gray-500">
                        No ambulances found
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="px-6 py-4 border-t bg-gray-50 text-sm text-gray-600">
            Last updated: {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>

</div>
@endsection
