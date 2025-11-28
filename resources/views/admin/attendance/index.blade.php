    @extends('layouts.layout')

@section('title', 'Employee Attendance')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Employee Attendance</h1>
                <p class="text-gray-600 mt-1">Today's Date: {{ $today->format('F j, Y') }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.attendance.report') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-chart-bar mr-2"></i>View Report
                </a>
                <button onclick="bulkMarkAttendance()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-check-circle mr-2"></i>Bulk Mark
                </button>
               

                <a href="{{ route('admin.attendance.monthly-view') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-calendar mr-2"></i>Monthly View
                </a>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-white-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" class="rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($employees as $employee)
                    <tr class="hover:bg-white-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="employee-checkbox rounded" value="{{ $employee->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($employee->image)
                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->name }}">
                                @else
                                <div class="h-10 w-10 rounded-full bg-white-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">{{ substr($employee->name, 0, 1) }}</span>
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $employee->employee_code }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $employee->department->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $attendance = $todayAttendances->get($employee->id) @endphp
                            @if($attendance)
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
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-white-100 text-gray-800">
                                    Not Marked
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->check_in ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $attendance->check_out ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button type="button" onclick="markAttendance({{ $employee->id }}, '{{ addslashes($employee->name) }}')" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i> Mark
                                </button>
                                <a href="{{ route('admin.attendance.show', $employee->id) }}" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i> History
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
<div id="attendanceModal" class="fixed inset-0 bg-white-900 bg-opacity-80 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-6 border w-full max-w-lg shadow-xl rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Mark Attendance</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="modalForm">
                @csrf
                <input type="hidden" id="modalEmployeeId" name="employee_id">

                <div class="mb-5">
                    <label for="modalStatus" class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-user-check mr-2 text-blue-500"></i>Attendance Status
                    </label>
                    <select id="modalStatus" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" required>
                        <option value="">Select Status</option>
                        <option value="present">✅ Present (P) - Staff hospital me duty par hai</option>
                        <option value="absent">❌ Absent (A) - Staff nahi aaya aur leave apply nahi kiya</option>
                        <option value="leave">📅 Leave (L) - Approved leave par</option>
                        <option value="late">⏰ Late (LT) - Duty me aaya but late check-in</option>
                        <option value="half_day">⏳ Half Day (HD) - Sirf half shift attended</option>
                        <option value="holiday">🏖️ Holiday (H) - Official off day</option>
                        <option value="week_off">🏠 Week Off (WO) - Weekly off</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="modalCheckIn" class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-clock mr-2 text-green-500"></i>Check In Time
                        </label>
                        <input type="time" id="modalCheckIn" name="check_in" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200">
                    </div>
                    <div>
                        <label for="modalCheckOut" class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>Check Out Time
                        </label>
                        <input type="time" id="modalCheckOut" name="check_out" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="modalNotes" class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-sticky-note mr-2 text-yellow-500"></i>Additional Notes
                    </label>
                    <textarea id="modalNotes" name="notes" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200 resize-none" placeholder="Enter any additional notes..."></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal()" class="bg-white-100 hover:bg-white-200 text-gray-700 px-6 py-2.5 rounded-lg transition duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg transition duration-200 font-medium shadow-md">
                        <i class="fas fa-save mr-2"></i>Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.employee-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

function markAttendance(employeeId, employeeName) {
    document.getElementById('modalTitle').textContent = `Mark Attendance for ${employeeName}`;
    document.getElementById('modalEmployeeId').value = employeeId;
    document.getElementById('attendanceModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('attendanceModal').classList.add('hidden');
    document.getElementById('modalForm').reset();
}

document.getElementById('modalForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ route("admin.attendance.mark") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            showToast(data.message, 'success');
            location.reload();
        } else if (data.error) {
            showToast(data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while marking attendance.', 'error');
    });
});

function bulkMarkAttendance() {
    const selectedEmployees = Array.from(document.querySelectorAll('.employee-checkbox:checked')).map(cb => cb.value);

    if (selectedEmployees.length === 0) {
        showToast('Please select employees to mark attendance.', 'error');
        return;
    }

    const status = prompt('Enter status for selected employees (present/absent/leave/late/half_day/holiday/week_off):');

    if (!status || !['present', 'absent', 'leave', 'late', 'half_day', 'holiday', 'week_off'].includes(status)) {
        showToast('Invalid status. Please enter a valid status.', 'error');
        return;
    }

    const attendances = selectedEmployees.map(employeeId => ({
        employee_id: employeeId,
        status: status
    }));

    fetch('{{ route("admin.attendance.bulk-mark") }}', {
        method: 'POST',
        body: JSON.stringify({ attendances }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            showToast(data.message, 'success');
            location.reload();
        } else if (data.error) {
            showToast(data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while marking bulk attendance.', 'error');
    });
}
</script>
@endsection
