@extends('layouts.layout')

@section('title', 'Add Ambulance')

@section('content')
<div class="container mx-auto px-2 py-6 max-w-4xl">

    {{-- ===== HEADER ===== --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-red-600 via-rose-700 to-pink-800 rounded-2xl shadow-2xl mb-8">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-red-300 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-pink-300 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 p-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2 flex items-center gap-3">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="fas fa-ambulance text-xl"></i>
                    </div>
                    Add New Ambulance
                </h1>
                <p class="text-red-100">Create a new ambulance record</p>
            </div>

            <a href="{{ route('admin.ambulances.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-red-700
                      rounded-xl hover:bg-red-50 font-semibold shadow-lg transition">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- ===== FORM CARD ===== --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <form method="POST" action="{{ route('admin.ambulances.store') }}" class="p-8 space-y-6">
            @csrf

            {{-- Ambulance Number --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ambulance Number <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="ambulance_number"
                       value="{{ old('ambulance_number') }}"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500
                              @error('ambulance_number') border-red-400 @enderror"
                       placeholder="e.g. UP-32-AB-1234"
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
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500
                               @error('vehicle_type') border-red-400 @enderror"
                        required>
                    <option value="">Select Type</option>
                    <option value="Basic Life Support" {{ old('vehicle_type') == 'Basic Life Support' ? 'selected' : '' }}>
                        Basic Life Support (BLS)
                    </option>
                    <option value="Advanced Life Support" {{ old('vehicle_type') == 'Advanced Life Support' ? 'selected' : '' }}>
                        Advanced Life Support (ALS)
                    </option>
                    <option value="Neonatal" {{ old('vehicle_type') == 'Neonatal' ? 'selected' : '' }}>
                        Neonatal / Pediatric
                    </option>
                    <option value="Mortuary" {{ old('vehicle_type') == 'Mortuary' ? 'selected' : '' }}>
                        Mortuary Van
                    </option>
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
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="out_of_service" {{ old('status') == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                </select>
            </div>

            {{-- Driver --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Assign Driver <span class="text-gray-400">(Optional)</span>
                </label>
                <select name="driver_id"
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">No Driver</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}"
                        {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-end gap-4 border-t pt-6">
                <a href="{{ route('admin.ambulances.index') }}"
                   class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>

                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-xl
                               hover:from-red-700 hover:to-pink-700 shadow-lg font-semibold">
                    <i class="fas fa-save mr-2"></i>
                    Save Ambulance
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
