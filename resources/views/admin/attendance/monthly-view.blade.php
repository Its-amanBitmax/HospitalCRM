@extends('layouts.layout')

@section('title', 'Monthly Attendance View')

@section('content')
<div class="container  px-4 py-8" style="width:75%;">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Monthly Attendance View</h1>
                <p class="text-gray-600 mt-1">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.attendance.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Attendance
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white-50 rounded-lg p-6 mb-6">
            <form action="{{ route('admin.attendance.monthly-view') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>Month
                    </label>
                    <input type="month" id="month" name="month" value="{{ $month }}" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" required>
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building mr-2 text-purple-500"></i>Department
                    </label>
                    <select id="department_id" name="department_id" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium shadow-md">
                        <i class="fas fa-search mr-2"></i>Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Monthly Attendance Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-white-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-white-50 z-10 border-r border-gray-300">
                            Employee
                        </th>
                        @foreach($dates as $date)
                        <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[60px]">
                            {{ \Carbon\Carbon::parse($date)->format('d') }}<br>
                            <span class="text-xs">{{ \Carbon\Carbon::parse($date)->format('D') }}</span>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    @foreach($employees as $employee)
                    <tr class="hover:bg-white-50">
                        <td class="px-4 py-4 whitespace-nowrap sticky left-0 bg-white border-r border-gray-300 z-10">
                            <div class="flex items-center">
                                @if($employee->image)
                                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->name }}">
                                @else
                                <div class="h-8 w-8 rounded-full bg-white-300 flex items-center justify-center">
                                    <span class="text-xs font-medium text-gray-700">{{ substr($employee->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $employee->employee_code }}</div>
                                </div>
                            </div>
                        </td>
                        @foreach($dates as $date)
                        <td class="px-2 py-4 text-center border-l border-gray-200">
                            @php
                                $attendance = $employee->attendances->where('date', $date)->first();
                            @endphp
                            @if($attendance)
                                <div class="relative group">
                                    <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-semibold rounded-full cursor-pointer
                                        @if($attendance->status == 'present') bg-green-100 text-green-800
                                        @elseif($attendance->status == 'absent') bg-red-100 text-red-800
                                        @elseif($attendance->status == 'leave') bg-yellow-100 text-yellow-800
                                        @elseif($attendance->status == 'late') bg-orange-100 text-orange-800
                                        @elseif($attendance->status == 'half_day') bg-blue-100 text-blue-800
                                        @elseif($attendance->status == 'holiday') bg-purple-100 text-purple-800
                                        @elseif($attendance->status == 'week_off') bg-white-100 text-gray-800
                                        @endif">
                                        @if($attendance->status == 'present') P
                                        @elseif($attendance->status == 'absent') A
                                        @elseif($attendance->status == 'leave') L
                                        @elseif($attendance->status == 'late') LT
                                        @elseif($attendance->status == 'half_day') HD
                                        @elseif($attendance->status == 'holiday') H
                                        @elseif($attendance->status == 'week_off') WO
                                        @endif
                                    </span>
                                    <!-- Tooltip -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-white-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-20 whitespace-nowrap">
                                        <div class="font-semibold">{{ ucfirst(str_replace('_', ' ', $attendance->status)) }}</div>
                                        @if($attendance->check_in)
                                        <div>Check In: {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}</div>
                                        @endif
                                        @if($attendance->check_out)
                                        <div>Check Out: {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}</div>
                                        @endif
                                        @if($attendance->notes)
                                        <div>Notes: {{ $attendance->notes }}</div>
                                        @endif
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-semibold rounded-full bg-white-50 text-gray-400">
                                    -
                                </span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($employees->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500">No employees found for the selected criteria.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .sticky {
        position: sticky;
    }
    .z-10 {
        z-index: 10;
    }
    .z-20 {
        z-index: 20;
    }
</style>
@endsection
