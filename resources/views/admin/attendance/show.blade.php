@extends('layouts.layout')

@section('title', 'Employee Attendance History')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Attendance History</h1>
                <p class="text-gray-600 mt-1">{{ $employee->name }} ({{ $employee->employee_code }})</p>
                <p class="text-sm text-gray-500">{{ $employee->department->name ?? 'N/A' }}</p>
            </div>
            <a href="{{ route('admin.attendance.index') }}" class="bg-white-500 hover:bg-white-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Back to Attendance
            </a>
        </div>

        <!-- Attendance Records -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-white-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Working Hours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-white-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('M j, Y') }}
                            <span class="text-xs text-gray-500 block">{{ \Carbon\Carbon::parse($attendance->date)->format('l') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($attendance->status == 'present') bg-green-100 text-green-800
                                @elseif($attendance->status == 'absent') bg-red-100 text-red-800
                                @elseif($attendance->status == 'leave') bg-yellow-100 text-yellow-800
                                @elseif($attendance->status == 'late') bg-orange-100 text-orange-800
                                @elseif($attendance->status == 'half_day') bg-blue-100 text-blue-800
                                @elseif($attendance->status == 'holiday') bg-purple-100 text-purple-800
                                @elseif($attendance->status == 'week_off') bg-white-100 text-gray-800
                                @endif">
                                @if($attendance->status == 'present') Present (P)
                                @elseif($attendance->status == 'absent') Absent (A)
                                @elseif($attendance->status == 'leave') Leave (L)
                                @elseif($attendance->status == 'late') Late (LT)
                                @elseif($attendance->status == 'half_day') Half Day (HD)
                                @elseif($attendance->status == 'holiday') Holiday (H)
                                @elseif($attendance->status == 'week_off') Week Off (WO)
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($attendance->check_in && $attendance->check_out)
                                @php
                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                    $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                    $hours = $checkIn->diffInHours($checkOut);
                                    $minutes = $checkIn->diffInMinutes($checkOut) % 60;
                                @endphp
                                {{ $hours }}h {{ $minutes }}m
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $attendance->notes ?: '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No attendance records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($attendances->hasPages())
        <div class="mt-6">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
