@extends('layouts.layout')

@section('content')
<div class="min-h-screen">

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 text-white">
                Task Schedule for Dr. {{ $employee->name }}
            </h1>
        </div>
        <a href="{{ route('schedules.create', $employee) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
           <i class="fa fa-plus mr-2"></i>Add Task
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

@if($schedules->isEmpty())
    <p class="text-gray-500 text-gray-400 text-center mt-10 text-lg">
        No tasks found for this doctor.
    </p>
@else
    @php
        // Group tasks by timing and type (so ranges appear as one)
        $grouped = $schedules
            ->groupBy(fn($item) => $item->start_time . '|' . $item->end_time . '|' . $item->task_type)
            ->map(function($group) {
                return [
                    'start_date' => $group->min('start_date'),
                    'end_date'   => $group->max('end_date'),
                    'start_time' => $group->first()->start_time,
                    'end_time'   => $group->first()->end_time,
                    'task_type'  => $group->first()->task_type,
                    'id'         => $group->first()->id,
                ];
            });
    @endphp

    <!-- Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($grouped as $task)
            <div class="bg-white bg-white-800 rounded-lg shadow-md overflow-hidden border border-gray-200 border-gray-700 hover:shadow-lg transition">

                <!-- Card Header -->
                <div class="p-4 border-b border-gray-100 border-gray-700 flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-700 text-gray-300">
                        {{ $task['task_type'] }}
                    </span>
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                        @switch($task['task_type'])
                            @case('Appointment') bg-blue-100 text-blue-800 bg-blue-900 text-blue-100 @break
                            @case('consultation') bg-purple-100 text-purple-800 bg-purple-900 text-purple-100 @break
                            @case('OPD') bg-green-100 text-green-800 bg-green-900 text-green-100 @break
                            @case('IPD') bg-yellow-100 text-yellow-800 bg-yellow-900 text-yellow-100 @break
                            @case('Emergency') bg-red-100 text-red-800 bg-red-900 text-red-100 @break
                            @case('Room Duty') bg-orange-100 text-orange-800 bg-orange-900 text-orange-100 @break
                            @case('Other') bg-white-100 text-gray-800 bg-white-900 text-gray-100 @break
                            @default bg-white-100 text-gray-800 bg-white-900 text-gray-100
                        @endswitch
                        {{ strtoupper($task['task_type']) }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="p-4 space-y-2">
                    <p class="text-sm text-gray-600 text-gray-400">
                        <strong>Start Date:</strong>
                        <span class="text-gray-800 text-gray-200">
                            {{ \Carbon\Carbon::parse($task['start_date'])->format('d M Y') }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-600 text-gray-400">
                        <strong>End Date:</strong>
                        <span class="text-gray-800 text-gray-200">
                            {{ \Carbon\Carbon::parse($task['end_date'])->format('d M Y') }}
                        </span>
                    </p>

                    <p class="text-sm text-gray-600 text-gray-400">
                        <strong>Time:</strong>
                        <span class="text-gray-800 text-gray-200">
                            {{ \Carbon\Carbon::parse($task['start_time'])->format('h:i A') }}
                            —
                            {{ \Carbon\Carbon::parse($task['end_time'])->format('h:i A') }}
                        </span>
                    </p>
                </div>

                <!-- Card Footer -->
                <div class="p-4 bg-white-50 bg-white-900 border-t border-gray-100 border-gray-700 flex justify-between items-center space-x-2">
                    <a href="{{ route('schedules.edit', $task['id']) }}"
                       class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold px-3 py-1 rounded text-sm shadow-sm transition focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <i class="fa fa-edit mr-1"></i> Edit
                    </a>

                    <form action="{{ route('schedules.destroy', $task['id']) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this task range?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold px-3 py-1 rounded text-sm shadow-sm transition focus:outline-none focus:ring-2 focus:ring-red-400">
                            <i class="fa fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
</div>
@endsection
            