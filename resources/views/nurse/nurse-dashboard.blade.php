@extends('layouts.nursionist')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $employee->name }}! 👋</h1>
            <p class="text-gray-600 mt-1">Here's your duty schedule and assigned tasks</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <span class="absolute -top-1 -right-1 h-3 w-3 bg-green-400 rounded-full border-2 border-white"></span>
                @if($employee->image)
                <img src="{{ Storage::url($employee->image) }}"
                    alt="{{ $employee->name }}"
                    class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm">
                @else
                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-lg shadow-sm">
                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Current Task Status -->
    @if($currentTask)
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2 bg-white/20 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Currently Working On</h3>
                        <p class="text-blue-100">You're currently assigned to a task</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-white/10 p-4 rounded-xl">
                        <p class="text-sm text-blue-100">Assigned Room</p>
                        <p class="text-lg font-semibold mt-1">{{ $currentTask->room->room_no ?? 'Not Specified' }}</p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-xl">
                        <p class="text-sm text-blue-100">Department</p>
                        <p class="text-lg font-semibold mt-1">{{ $currentTask->department->name ?? 'Not Specified' }}</p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-xl">
                        <p class="text-sm text-blue-100">Supervising Doctor</p>
                        <p class="text-lg font-semibold mt-1">{{ $currentTask->doctor->name ?? 'Not Assigned' }}</p>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <span class="px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold">ON DUTY</span>
                <p class="text-blue-100 mt-2 text-sm">Started: {{ \Carbon\Carbon::parse($currentTask->start_date)->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

        <!-- Today's Tasks -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-3 py-1 bg-blue-100 text-blue-700 rounded-full">{{ $todayTasks->count() }} Active</span>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-2">Today's Tasks</h3>
            <p class="text-3xl font-bold text-gray-900 mb-4">{{ $todayTasks->count() }}</p>
            <div class="text-sm text-gray-500">Tasks for today</div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="bg-gradient-to-br from-white to-green-50 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-2">Upcoming</h3>
            <p class="text-3xl font-bold text-gray-900 mb-4">{{ $upcomingTasks->count() }}</p>
            <div class="text-sm text-gray-500">Next 7 days schedule</div>
        </div>

        <!-- In-Progress Tasks -->
        <div class="bg-gradient-to-br from-white to-blue-100 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 bg-blue-200 rounded-xl">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-2">In Progress</h3>
            <p class="text-3xl font-bold text-gray-900 mb-4">{{ $inProgressTasks->count() }}</p>
            <div class="text-sm text-gray-500">Currently ongoing tasks</div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 bg-purple-100 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-2">Completed</h3>
            <p class="text-3xl font-bold text-gray-900 mb-4">{{ $completedTasks->count() }}</p>
            <div class="text-sm text-gray-500">Completed tasks</div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-gradient-to-br from-white to-orange-50 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="p-3 bg-orange-100 rounded-xl">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pending</h3>
            <p class="text-3xl font-bold text-gray-900 mb-4">{{ $pendingTasks->count() }}</p>
            <div class="text-sm text-gray-500">Awaiting start</div>
        </div>

    </div>


    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card with Professions -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex flex-col items-center mb-6">
                <div class="relative mb-4">
                    @if($employee->image)
                    <img src="{{ Storage::url($employee->image) }}"
                        alt="{{ $employee->name }}"
                        class="h-24 w-24 rounded-full object-cover border-1 border-black shadow-lg">
                    @else
                    <div class="h-24 w-24 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-3xl shadow-lg">
                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                    </div>
                    @endif
                </div>

                <h2 class="text-xl font-bold text-gray-900">{{ $employee->name }}</h2>
                <p class="text-gray-500 text-sm mt-1">
                    @if($employee->professions->isNotEmpty())
                    {{ $employee->professions->first()->title }}

                    @if($employee->professions->count() > 1)
                    + {{ $employee->professions->count() - 1 }} more
                    @endif
                    @else
                    Registered Nurse
                    @endif
                </p>
                <span class="mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                    <span class="h-2 w-2 bg-green-500 rounded-full inline-block mr-1"></span>
                    Active
                </span>
            </div>

            <!-- Personal Information -->
            <div class="space-y-4 mb-6">
                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="font-medium text-gray-900">{{ $employee->email }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Phone Number</p>
                        <p class="font-medium text-gray-900">{{ $employee->phone ?? 'Not provided' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="font-medium text-gray-900">{{ $employee->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Specializations Section -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Specializations</h3>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                        {{ $specialities->count() }} Specialties
                    </span>
                </div>

                @if($specialities->count() > 0)
                <div class="space-y-3">
                    @foreach($specialities as $spec)
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-blue-50/80 to-indigo-50/80 rounded-lg border border-blue-100 hover:shadow-sm transition-shadow duration-300">
                        <div class="p-2 bg-white rounded-lg shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $spec->skill }}</h4>
                            <p class="text-sm text-gray-500 mt-1">Medical Specialty</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <p class="text-gray-500 text-sm">No specializations assigned yet</p>
                </div>
                @endif
            </div>

            <!-- Edit Profile Button -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Complete Profile
                </button>
            </div>
        </div>


        <!-- Tasks Schedule Section - Update the form section -->
        <div class="bg-gradient-to-br from-white to-indigo-50 rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-indigo-100 rounded-xl">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Task Schedule</h3>
                        <p class="text-sm text-gray-500">{{ $tasks->count() }} total assignments</p>
                    </div>
                </div>
                <a href="{{ route('nurse.tasks') }}" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg font-medium hover:bg-indigo-100 transition-colors duration-200 flex items-center gap-2 text-sm">
                    View All Tasks
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($tasks->count() > 0)
            <div class="space-y-4">
                @foreach($tasks->take(5) as $task)
                <div class="group p-4 bg-white rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h4 class="font-semibold text-gray-900">
                                    @if($task->room)
                                    Room {{ $task->room->room_no ?? 'N/A' }}
                                    @if($task->department)
                                    <span class="text-gray-500 text-sm font-normal"> - {{ $task->department->name }}</span>
                                    @endif
                                    @else
                                    General Task
                                    @endif
                                </h4>

                                @if($task->status == 'completed')
                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Completed</span>
                                @elseif($task->status == 'in-progress')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">In Progress</span>
                                @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Pending</span>
                                @endif
                            </div>

                            @if($task->notes)
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($task->notes, 100) }}</p>
                            @endif

                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($task->start_date)->format('M d') }}
                                    @if($task->end_date)
                                    - {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                                    @endif
                                </div>

                                @if($task->doctor)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Dr. {{ $task->doctor->name ?? 'N/A' }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($task->status == 'pending')
                            <form action="{{ route('nurse.task.update.status', $task->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="in-progress">
                                <button type="submit"
                                    class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors">
                                    Start Task
                                </button>
                            </form>
                            @elseif($task->status == 'in-progress')
                            <form action="{{ route('nurse.task.update.status', $task->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button type="submit"
                                    class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full hover:bg-green-200 transition-colors">
                                    Mark Complete
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700 mb-2">No Task Assignments</h4>
                <p class="text-gray-500 max-w-md mx-auto mb-6">You don't have any task assignments scheduled yet.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Professions Section -->
    <!-- <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Your Specializations</h3>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">{{ $employee->professions->count() }} Specialties</span>
        </div>

        @if($employee->professions->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($employee->professions as $profession)
            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:shadow-sm transition-shadow duration-300">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg shadow-sm">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900">{{ $profession->title }}</h4>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-500">No specializations assigned yet</p>
        </div>
        @endif
    </div> -->

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('nurse.tasks') }}" class="p-4 bg-blue-50 rounded-xl border border-blue-100 hover:bg-blue-100 transition-colors duration-200 group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">View All Tasks</span>
                </div>
            </a>

            <a href="#" class="p-4 bg-green-50 rounded-xl border border-green-100 hover:bg-green-100 transition-colors duration-200 group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Calendar</span>
                </div>
            </a>

            <a href="#" class="p-4 bg-purple-50 rounded-xl border border-purple-100 hover:bg-purple-100 transition-colors duration-200 group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.67 3.913a8 8 0 01-13.67-3.913L3 21" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Patients</span>
                </div>
            </a>

            <a href="#" class="p-4 bg-orange-50 rounded-xl border border-orange-100 hover:bg-orange-100 transition-colors duration-200 group">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white rounded-lg">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Settings</span>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div id="successMessage" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('success') }}
    </div>
</div>
<script>
    setTimeout(() => {
        document.getElementById('successMessage').style.display = 'none';
    }, 3000);
</script>
@endif

@if(session('error'))
<div id="errorMessage" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('error') }}
    </div>
</div>
<script>
    setTimeout(() => {
        document.getElementById('errorMessage').style.display = 'none';
    }, 3000);
</script>
@endif

@endsection