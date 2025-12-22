@php
$layout = auth('nurse')->check() ? 'layouts.nursionist' : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'Nurse Tasks Dashboard')

@section('content')
<div class="min-h-screen ">

    <!-- Debug Panel (Remove after fixing) -->
    <!-- <div id="debugPanel" class="fixed bottom-4 right-4 z-50 bg-red-100 border border-red-300 rounded-lg p-3 shadow-lg hidden">
        <div class="flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium text-red-700">Debug Panel</span>
        </div>
        <div id="debugInfo" class="text-xs text-red-600 space-y-1"></div>
    </div> -->

    <!-- Test Button -->
    <!-- <button id="testModalBtn" class="fixed bottom-4 left-4 z-50 px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
        Test Modal
    </button> -->

    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Nurse Tasks Dashboard</h1>
                    <p class="text-gray-600 mt-2">Manage and monitor all nursing assignments and schedules</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <!-- Quick Stats -->
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full font-medium text-sm">
                            {{ $tasks->total() ?? 0 }} Total Tasks
                        </span>
                        @if(collect($tasks->items())->where('status', 'pending')->count() > 0)
                        <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full font-medium text-sm">
                            {{ collect($tasks->items())->where('status', 'pending')->count() }} Pending
                        </span>
                        @endif
                    </div>
                    <!-- Edit Button -->
                    @php
                    $admin = auth('admin')->check();
                    $doctor = auth('doctor')->check();
                    @endphp

                    @if($admin || $doctor)
                    <!-- New Task Button -->
                    <a href="{{ route('admin.nurse.task') }}"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-sm hover:shadow flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Task
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Tasks</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $tasks->total() }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pending</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ collect($tasks->items())->where('status', 'pending')->count() }}</p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">In Progress</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ collect($tasks->items())->where('status', 'in-progress')->count() }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Completed</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ collect($tasks->items())->where('status', 'completed')->count() }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Table Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Table Header with Filters -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">All Tasks</h2>
                    <p class="text-gray-600 text-sm mt-1">{{ count($tasks->items()) }} tasks on this page</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text"
                            placeholder="Search tasks..."
                            class="pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-full md:w-64"
                            id="searchInput">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Status Filter -->
                    <select id="statusFilter" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Task Details
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Department
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Location
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Timeline
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="tasksTableBody">
                    @forelse($tasks->items() as $task)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 task-row" data-status="{{ $task->status }}">
                        <!-- Task Details Column -->
                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">

                                            @if($task->doctor)
                                            <span class="text-xs px-2 py-1 bg-blue-50 text-blue-700 rounded">Dr. {{ explode(' ', $task->doctor->name)[0] }}</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                                            @if($task->nurse)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>{{ $task->nurse->name }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($task->notes)
                                <div class="text-sm text-gray-600 bg-gray-50 p-2 rounded border border-gray-100">
                                    {{ Str::limit($task->notes, 20) }}
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Department Column -->
                        <td class="py-4 px-6">
                            @if($task->department)
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="text-sm font-medium">{{ $task->department->name }}</span>
                            </div>
                            @else
                            <span class="text-gray-400 text-sm">No Department</span>
                            @endif
                        </td>

                        <!-- Location Column -->
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                @if($task->room)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-sm text-gray-900">Room {{ $task->room->room_no }}</span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <!-- Timeline Column -->
                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <div class="text-sm">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>



                        <td class="py-4 px-6">
                            <div class="space-y-2">
                                <div class="text-sm">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">{{ $task->start_time }}</span>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">{{ $task->end_time }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>



                        <!-- Status Column -->
                        <td class="py-4 px-6">
                            @php
                            $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'in-progress' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'completed' => 'bg-green-100 text-green-800 border-green-200'
                            ];
                            $statusClass = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                @switch($task->status)
                                @case('pending') Pending @break
                                @case('in-progress') In Progress @break
                                @case('completed') Completed @break
                                @default {{ ucfirst($task->status) }}
                                @endswitch
                            </span>
                        </td>

                        <!-- Actions Column -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <!-- View Button - FIXED -->
                                <button onclick="openTaskModal(
                                    {{ $task->id }},
                                    '{{ addslashes($task->department ? $task->department->name : '') }}',
                                    '{{ addslashes($task->room ? $task->room->room_no : '') }}',
                                    '{{ addslashes($task->nurse ? $task->nurse->name : '') }}',
                                    '{{ addslashes($task->doctor ? $task->doctor->name : '') }}',
                                    '{{ addslashes($task->notes) }}',
                                    '{{ $task->start_date }}',
                                    '{{ $task->end_date }}',
                                    '{{ $task->status }}'
                                )"
                                    class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors duration-200"
                                    title="View Details"
                                    data-task-id="{{ $task->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                @if(auth('nurse')->check())
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
                                @endif

                                <!-- Edit Button -->
                                @php
                                $admin = auth('admin')->check();
                                $doctor = auth('doctor')->check();
                                @endphp

                                @if($admin || $doctor)

                                <!-- Edit Button -->
                                <a href="{{ route('nurse.task.edit', $task->id) }}"
                                    class="p-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg transition-colors duration-200"
                                    title="Edit Task">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('nurse.task.delete', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors duration-200"
                                        title="Delete Task">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-500 font-medium">No tasks found</p>
                                    <p class="text-gray-400 text-sm mt-1">Create your first task to get started</p>
                                </div>
                                <a href="{{ route('admin.nurse.task') }}"
                                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create First Task
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tasks->hasPages())
        <div class="p-6 border-t border-gray-200 bg-gray-50">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-medium">{{ $tasks->firstItem() ?? 0 }}</span> to
                        <span class="font-medium">{{ $tasks->lastItem() ?? 0 }}</span> of
                        <span class="font-medium">{{ $tasks->total() }}</span> tasks
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Task Details Modal -->
<div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Task Details</h2>
                    <p class="text-gray-600 text-sm mt-1">Task #<span id="modalId">-</span></p>
                </div>
                <button onclick="closeTaskModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
            <div class="space-y-4">
                <!-- Basic Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 font-medium mb-1">Department</p>
                        <p id="modalDepartment" class="text-gray-800 font-medium">-</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 font-medium mb-1">Room</p>
                        <p id="modalRoom" class="text-gray-800 font-medium">-</p>
                    </div>
                </div>

                <!-- Assignments -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-xs text-blue-600 font-medium mb-1">Assigned Nurse</p>
                        <p id="modalNurse" class="text-blue-800 font-medium">-</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-xs text-green-600 font-medium mb-1">Doctor</p>
                        <p id="modalDoctor" class="text-green-800 font-medium">-</p>
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 font-medium mb-1">Start Date</p>
                        <p id="modalStart" class="text-gray-800 font-medium">-</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 font-medium mb-1">End Date</p>
                        <p id="modalEnd" class="text-gray-800 font-medium">-</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-500 font-medium mb-1">Status</p>
                    <p id="modalStatus" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">-</p>
                </div>

                <!-- Notes -->
                <div>
                    <p class="text-xs text-gray-500 font-medium mb-2">Notes</p>
                    <div id="modalNotes" class="bg-gray-50 p-4 rounded-lg text-gray-700 min-h-[80px] whitespace-pre-wrap">-</div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 border-t border-gray-200">
            <div class="flex justify-end">
                <button onclick="closeTaskModal()"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Debug function to show what's happening
    function showDebug(message) {
        console.log('DEBUG:', message);
        const debugPanel = document.getElementById('debugPanel');
        const debugInfo = document.getElementById('debugInfo');

        if (debugPanel && debugInfo) {
            debugPanel.classList.remove('hidden');
            const timestamp = new Date().toLocaleTimeString();
            debugInfo.innerHTML = `<div>${timestamp}: ${message}</div>` + debugInfo.innerHTML;
        }
    }

    // Test function to check if modal works
    function testModal() {
        showDebug('Test modal function called');
        openTaskModal(
            999,
            'Emergency Department',
            'ICU-101',
            'Nurse Smith',
            'Dr. Johnson',
            'This is a test note to verify the modal is working properly.',
            '2024-01-15',
            '2024-01-20',
            'pending'
        );
    }

    // Modal Functions
    function openTaskModal(id, department, room, nurse, doctor, notes, start, end, status) {
        showDebug(`Opening modal for task ID: ${id}`);

        try {
            // Set modal content with fallbacks
            document.getElementById('modalId').textContent = id || 'N/A';
            document.getElementById('modalDepartment').textContent = department || 'Not assigned';
            document.getElementById('modalRoom').textContent = room ? `Room ${room}` : 'Not assigned';
            document.getElementById('modalNurse').textContent = nurse || 'Not assigned';
            document.getElementById('modalDoctor').textContent = doctor || 'Not assigned';
            document.getElementById('modalNotes').textContent = notes || 'No notes provided';

            // Format dates properly with error handling
            try {
                const startDate = new Date(start);
                const endDate = new Date(end);

                document.getElementById('modalStart').textContent = startDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                document.getElementById('modalEnd').textContent = endDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } catch (dateError) {
                showDebug('Date formatting error: ' + dateError);
                document.getElementById('modalStart').textContent = start || 'Invalid date';
                document.getElementById('modalEnd').textContent = end || 'Invalid date';
            }

            // Set status with color
            const statusEl = document.getElementById('modalStatus');
            if (statusEl) {
                const statusText = status ? status.replace('-', ' ') : 'Not set';
                statusEl.textContent = statusText;
                statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium';

                const statusColors = {
                    'pending': 'bg-yellow-100 text-yellow-800',
                    'in-progress': 'bg-blue-100 text-blue-800',
                    'completed': 'bg-green-100 text-green-800'
                };
                statusEl.className += ' ' + (statusColors[status] || 'bg-gray-100 text-gray-800');
            }

            // Show modal
            const modal = document.getElementById('taskModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                showDebug('Modal shown successfully');
            } else {
                showDebug('ERROR: Modal element not found');
            }
        } catch (error) {
            showDebug('ERROR in openTaskModal: ' + error.message);
            console.error('Modal Error:', error);
        }
    }

    function closeTaskModal() {
        showDebug('Closing modal');
        const modal = document.getElementById('taskModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        showDebug('Page loaded successfully');

        // Test button
        const testBtn = document.getElementById('testModalBtn');
        if (testBtn) {
            testBtn.addEventListener('click', testModal);
        }

        // Search Functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('.task-row');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        }

        // Status Filter
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function(e) {
                const filterValue = e.target.value;
                const rows = document.querySelectorAll('.task-row');

                rows.forEach(row => {
                    if (filterValue === 'all') {
                        row.style.display = '';
                    } else {
                        const status = row.dataset.status;
                        row.style.display = status === filterValue ? '' : 'none';
                    }
                });
            });
        }

        // Close modal on outside click
        const modal = document.getElementById('taskModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTaskModal();
                }
            });
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('taskModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeTaskModal();
                }
            }
        });

        // Add click listeners to all view buttons
        const viewButtons = document.querySelectorAll('button[onclick*="openTaskModal"]');
        viewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                showDebug('View button clicked for task: ' + this.dataset.taskId);
            });
        });
    });

    // Check if modal exists
    window.onload = function() {
        if (!document.getElementById('taskModal')) {
            showDebug('ERROR: Modal element not found in DOM');
        } else {
            showDebug('Modal element found in DOM');
        }

        // Test if functions are accessible
        if (typeof openTaskModal === 'undefined') {
            showDebug('ERROR: openTaskModal function not defined');
        }
        if (typeof closeTaskModal === 'undefined') {
            showDebug('ERROR: closeTaskModal function not defined');
        }
    };
</script>

<style>
    /* Animation for modal */
    #taskModal {
        transition: opacity 0.3s ease;
    }

    #taskModal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    #taskModal.flex {
        opacity: 1;
        pointer-events: all;
    }

    /* Debug panel styles */
    #debugPanel {
        max-width: 300px;
        max-height: 200px;
        overflow-y: auto;
        font-family: monospace;
    }

    #debugInfo {
        font-size: 10px;
        line-height: 1.2;
    }
</style>
@endsection