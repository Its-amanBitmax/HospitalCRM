@extends('layouts.layout')

@section('content')
<div class="min-h-screen p-6 bg-gray-50">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-lg shadow-sm mb-6">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                Task Schedule for Dr. {{ $employee->name }}
            </h1>
            <p class="text-gray-600 mt-1">Manage and view all scheduled tasks</p>
        </div>
        <a href="{{ route('schedules.create', $employee) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 flex items-center font-semibold">
           <i class="fas fa-plus mr-2"></i>Add New Task
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($schedules->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="mb-4">
                <i class="fas fa-calendar-times text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Tasks Found</h3>
            <p class="text-gray-500 mb-6">There are no scheduled tasks for this doctor yet.</p>
            <a href="{{ route('schedules.create', $employee) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 inline-flex items-center font-semibold">
                <i class="fas fa-plus mr-2"></i>Create First Task
            </a>
        </div>
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

        <!-- Tasks Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($grouped as $task)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-200 overflow-hidden border border-gray-200">

                    <!-- Card Header -->
                    <div class="p-4 border-b border-gray-100 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $task['task_type'] }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($task['task_type'])
                                    @case('Appointment') bg-blue-100 text-blue-800 @break
                                    @case('Consultation') bg-purple-100 text-purple-800 @break
                                    @case('OPD') bg-green-100 text-green-800 @break
                                    @case('IPD') bg-yellow-100 text-yellow-800 @break
                                    @case('Emergency') bg-red-100 text-red-800 @break
                                    @case('Room Duty') bg-orange-100 text-orange-800 @break
                                    @case('Other') bg-gray-100 text-gray-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $task['task_type'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-start text-gray-400 mr-2 w-4"></i>
                            <div>
                                <span class="text-gray-500">Start:</span>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($task['start_date'])->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-end text-gray-400 mr-2 w-4"></i>
                            <div>
                                <span class="text-gray-500">End:</span>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($task['end_date'])->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center text-sm">
                            <i class="fas fa-clock text-gray-400 mr-2 w-4"></i>
                            <div>
                                <span class="text-gray-500">Time:</span>
                                <span class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($task['start_time'])->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($task['end_time'])->format('g:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                        <a href="{{ route('schedules.edit', $task['id']) }}"
                           class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg text-sm transition duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>

                        <form action="{{ route('schedules.destroy', $task['id']) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this task?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition duration-200">
                                <i class="fas fa-trash mr-2"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
            