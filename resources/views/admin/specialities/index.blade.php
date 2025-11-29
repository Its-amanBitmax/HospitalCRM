@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-500 text-black px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
            <i class="fas fa-check-circle text-xl"></i>
            <span id="toastMessage"></span>
        </div>
    </div>

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-stethoscope text-2xl text-blue-600 text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 text-black">Specialities Management</h1>
        </div>
        <a href="{{ route('admin.specialities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            <i class="fa fa-plus mr-2"></i>Add Speciality
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-stethoscope text-3xl text-blue-600 text-blue-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 text-black">{{ $specialities->count() }}</div>
                <div class="text-sm text-gray-600 text-gray-400">Total Specialities</div>
            </div>
        </div>
        <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-clock text-3xl text-green-600 text-green-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 text-black">{{ $specialities->where('created_at', '>=', now()->startOfDay())->count() }}</div>
                <div class="text-sm text-gray-600 text-gray-400">Added Today</div>
            </div>
        </div>
    </div>

    <!-- Specialities Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($specialities as $speciality)
            <div class="bg-white bg-white-800 shadow-md rounded-lg overflow-hidden border border-gray-200  flex flex-col h-full">

                <!-- Card Header -->
                <div class="p-4 border-b border-gray-200 border-gray-700">
                    <div class="text-center mt-3">
                        <!-- Speciality Image or Icon -->
                        @if($speciality->image)
                            <img
                                src="{{ asset('storage/' . $speciality->image) }}"
                                alt="{{ $speciality->skill }}"
                                class="w-24 h-24 object-cover rounded-full border-2 border-gray-300 border-gray-600 mx-auto mb-2"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div class="hidden w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-2 text-black text-2xl font-bold">
                                {{ strtoupper(substr($speciality->skill, 0, 1)) }}
                            </div>
                        @else
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-2 text-black text-2xl font-bold">
                                {{ strtoupper(substr($speciality->skill, 0, 1)) }}
                            </div>
                        @endif

                        <!-- Skill Name -->
                        <h3 class="text-lg font-semibold text-gray-900 text-black mt-2">
                            {{ $speciality->skill }}
                        </h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 space-y-2 flex-1">
                    <p class="text-sm text-gray-600 text-gray-400">
                        <strong>Added:</strong> {{ $speciality->created_at ? $speciality->created_at->format('M d, Y') : 'N/A' }}
                    </p>
                </div>

                <!-- Card Footer (Actions) -->
                <div class="p-4 bg-white-50 bg-white-900 flex justify-between space-x-2 border-t border-gray-200 border-gray-700 mt-auto">
                 
                    <a href="{{ route('admin.specialities.edit', $speciality) }}"
                       class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-3 rounded text-sm text-center transition">
                       Edit
                    </a>
                    <form action="{{ route('admin.specialities.destroy', $speciality) }}"
                          method="POST"
                          class="flex-1"
                          onsubmit="return confirm('Are you sure you want to delete {{ addslashes($speciality->skill) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 text-gray-400 text-lg">No specialities found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        @if(method_exists($specialities, 'links'))
            {{ $specialities->links() }}
        @endif
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.4s ease-out; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = '{{ session('success') }}';
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        @endif
    });
</script>
@endsection
