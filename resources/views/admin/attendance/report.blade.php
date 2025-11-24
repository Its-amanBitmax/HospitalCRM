@extends('layouts.layout')

@section('title', 'Attendance Report')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Attendance Report</h1>
                <p class="text-gray-600 mt-1">From {{ \Carbon\Carbon::parse($startDate)->format('M j, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('M j, Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="exportToExcel()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Attendance
                </a>
            </div>
        </div>


        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-green-100 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-green-800">Present</div>
                        <div class="text-2xl font-bold text-green-900">{{ $summary['present'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-red-800">Absent</div>
                        <div class="text-2xl font-bold text-red-900">{{ $summary['absent'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-alt text-yellow-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-yellow-800">Leave</div>
                        <div class="text-2xl font-bold text-yellow-900">{{ $summary['leave'] }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-blue-100 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-blue-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-blue-800">Late</div>
                        <div class="text-2xl font-bold text-blue-900">{{ $summary['late'] }}</div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Filter Section -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Attendance Report</h3>
            <form id="filterForm" action="{{ route('admin.attendance.report') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>Start Date
                    </label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" required>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-green-500"></i>End Date
                    </label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" required>
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building mr-2 text-purple-500"></i>Department
                    </label>
                    <select id="department_id" name="department_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-badge mr-2 text-indigo-500"></i>Employee ID
                    </label>
                    <input type="text" id="employee_id" name="employee_id" value="{{ request('employee_id') }}" placeholder="Enter Employee ID" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                </div>

                <div>
                    <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-teal-500"></i>Employee Name
                    </label>
                    <input type="text" id="employee_name" name="employee_name" value="{{ request('employee_name') }}" placeholder="Enter Employee Name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-check mr-2 text-orange-500"></i>Status
                    </label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200">
                        <option value="">All Status</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                        <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                        <option value="holiday" {{ request('status') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                        <option value="week_off" {{ request('status') == 'week_off' ? 'selected' : '' }}>Week Off</option>
                    </select>
                </div>

                <div class="md:col-span-3 lg:col-span-6 flex justify-end space-x-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium shadow-md">
                        <i class="fas fa-search mr-2"></i>Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Attendance Records -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $attendance->employee->name }}</div>
                            <div class="text-sm text-gray-500">{{ $attendance->employee->employee_code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->employee->department->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($attendance->status == 'present') bg-green-100 text-green-800
                                @elseif($attendance->status == 'absent') bg-red-100 text-red-800
                                @elseif($attendance->status == 'leave') bg-yellow-100 text-yellow-800
                                @elseif($attendance->status == 'late') bg-orange-100 text-orange-800
                                @elseif($attendance->status == 'half_day') bg-blue-100 text-blue-800
                                @elseif($attendance->status == 'holiday') bg-purple-100 text-purple-800
                                @elseif($attendance->status == 'week_off') bg-gray-100 text-gray-800
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
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $attendance->notes ?: '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No attendance records found for the selected period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    const url = new URL(window.location);
    url.searchParams.set('export', 'excel');
    window.open(url.toString(), '_blank');
}
</script>
@endsection
