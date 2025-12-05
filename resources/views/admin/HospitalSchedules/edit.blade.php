@extends('layouts.layout')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Hospital Schedule</h1>

    {{-- Form Errors --}}
    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('hospital.schedule.update', $schedule->id) }}" method="POST"
        class="bg-white p-6 shadow-lg rounded-lg grid grid-cols-1 md:grid-cols-2 gap-5">

        @csrf

        <div>
            <label class="block font-medium">Start Date</label>
            <input type="date" name="start_date" value="{{ $schedule->start_date ? $schedule->start_date->format('Y-m-d') : '' }}" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <div>
            <label class="block font-medium">End Date</label>
            <input type="date" name="end_date" value="{{ $schedule->end_date ? $schedule->end_date->format('Y-m-d') : '' }}" class="w-full mt-1 p-3 border rounded-lg">
        </div>

        <div>
            <label class="block font-medium">Start Time</label>
            <select name="start_time" class="w-full mt-1 p-3 border rounded-lg">
                @for ($hour = 0; $hour < 24; $hour++)
                    @php
                    $time24=sprintf("%02d:00", $hour);
                    $time12=date("h:i A", strtotime($time24));
                    $storedTime24=date("H:i", strtotime($schedule->start_time));
                    @endphp
                    <option value="{{ $time24 }}"
                        {{ $storedTime24 == $time24 ? 'selected' : '' }}>
                        {{ $time12 }}
                    </option>
                    @endfor
            </select>
        </div>

        <div>
            <label class="block font-medium">End Time</label>
            <select name="end_time" class="w-full mt-1 p-3 border rounded-lg">
                @for ($hour = 0; $hour < 24; $hour++)
                    @php
                    $time24=sprintf("%02d:00", $hour);
                    $time12=date("h:i A", strtotime($time24));
                    @endphp
                    <option value="{{ $time24 }}"
                    {{ $schedule->end_time == $time24 ? 'selected' : '' }}>
                    {{ $time12 }}
                    </option>
                    @endfor
            </select>
        </div>

        <div>
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full mt-1 p-3 border rounded-lg">
                <option value="active" {{ $schedule->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $schedule->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="col-span-2">
            <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Schedule
            </button>
        </div>

    </form>

</div>
@endsection