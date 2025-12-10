@extends('layouts.layout')

@section('title', 'Edit Ambulance')

@section('content')
<div class="container mx-auto px-2 py-6 max-w-4xl">

    {{-- ===== HEADER ===== --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-amber-500 via-orange-600 to-red-600 rounded-2xl shadow-2xl mb-8">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-orange-200 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-red-200 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 p-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2 flex items-center gap-3">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="fas fa-ambulance text-xl"></i>
                    </div>
                    Edit Ambulance
                </h1>
                <p class="text-orange-100">
                    Update ambulance details and driver assignment
                </p>
            </div>

            <a href="{{ route('admin.ambulances.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-orange-700
                      rounded-xl hover:bg-orange-50 font-semibold shadow-lg transition">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- ===== FORM CARD ===== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <form method="POST"
              action="{{ route('admin.ambulances.update', $ambulance->id) }}"
              class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Ambulance Number --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ambulance Number <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="ambulance_number"
                       value="{{ old('ambulance_number', $ambulance->ambulance_number) }}"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                       @error('ambulance_number') border-red-400 @enderror"
                       required>

                @error('ambulance_number')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Vehicle Type --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Vehicle Type <span class="text-red-500">*</span>
                </label>
                <select name="vehicle_type"
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('vehicle_type') border-red-400 @enderror"
                        required>
                    @php
                        $types = [
                            'Basic Life Support' => 'Basic Life Support (BLS)',
                            'Advanced Life Support' => 'Advanced Life Support (ALS)',
                            'Neonatal' => 'Neonatal / Pediatric',
                            'Mortuary' => 'Mortuary Van'
                        ];
                    @endphp

                    @foreach($types as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('vehicle_type', $ambulance->vehicle_type) === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                @error('vehicle_type')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status"
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    @php
                        $statuses = [
                            'available' => 'Available',
                            'in_use' => 'In Use',
                            'maintenance' => 'Maintenance',
                            'out_of_service' => 'Out of Service',
                        ];
                    @endphp

                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('status', $ambulance->status) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Driver --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Assign Driver <span class="text-gray-400">(Optional)</span>
                </label>
                <select name="driver_id"
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">No Driver</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}"
                            {{ old('driver_id', $ambulance->driver_id) == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }}
                        </option>
                    @endforeach
                </select>

                @error('driver_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-end gap-4 border-t pt-6">
                <a href="{{ route('admin.ambulances.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl
                               hover:from-orange-700 hover:to-red-700 shadow-lg font-semibold">
                    <i class="fas fa-save mr-2"></i>
                    Update Ambulance
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
