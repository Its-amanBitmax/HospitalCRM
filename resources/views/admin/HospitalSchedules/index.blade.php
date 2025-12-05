@extends('layouts.layout')

@section('content')
<div class="p-6">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-bold text-gray-800">Hospital Schedules</h1>
        <a href="{{ route('hospital.schedule.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Add New Schedule
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border">Start Date</th>
                    <th class="p-3 border">End Date</th>
                    <th class="p-3 border">Start Time</th>
                    <th class="p-3 border">End Time</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($schedules as $schedule)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ \Carbon\Carbon::parse($schedule->start_date)->format('d M Y') }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($schedule->end_date)->format('d M Y') }}</td>

                    <td class="p-3">{{ date('h:i A', strtotime($schedule->start_time)) }}</td>
                    <td class="p-3">{{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                                {{ $schedule->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('hospital.schedule.edit', $schedule->id) }}"
                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <form action="{{ route('hospital.schedule.delete', $schedule->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection