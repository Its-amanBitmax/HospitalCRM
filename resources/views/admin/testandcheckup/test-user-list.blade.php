@php
$layout = auth('laborist')->check() ? 'layouts.labornist' : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
<div class="container w-[960px]">
    <!-- Enhanced Header -->
    <div class="relative overflow-hidden bg-gradient-to-r from-cyan-30 via-cyan-30 to-cyan-30 rounded-2xl shadow-2xl mb-8">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-blue-300 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-300 rounded-full filter blur-3xl"></div>
        </div>
        <div class="relative z-10 p-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div>
                    <h1 class="text-4xl font-bold mb-3 flex items-center gap-4">
                        <div class="p-3  backdrop-blur-sm rounded-xl">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        Test Booked Users
                    </h1>
                    <p class=" text-lg">Manage and view all users who have booked tests</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden" style="max-width: 1100px !important;">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-list text-blue-600"></i>
                    </div>
                    Test Bookings
                    <span class="text-sm font-normal text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $users->count() }} users
                    </span>
                </h2>
            </div>
        </div>

        <!-- Table or Empty State -->
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full min-w-max" >
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-user text-gray-400"></i> User Details</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-info-circle text-gray-400"></i> User Status</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-flask text-gray-400"></i> Test Name</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-calendar text-gray-400"></i> Booking Date</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-clock text-gray-400"></i> Time</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-circle text-gray-400"></i> Status</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-tag text-gray-400"></i> Category</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-vial text-gray-400"></i> Sample</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-utensils text-gray-400"></i> Fasting</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-file-medical text-gray-400"></i> Report</div>
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><i class="fas fa-cogs text-gray-400"></i> Action</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            @if($user->testBook && $user->testBook->count() > 0)
                                @foreach($user->testBook as $index => $booking)
                                    <tr class="hover:bg-gray-50 transition">
                                        @if($index === 0)
                                            <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $user->testBook->count() }}">
                                                <div class="flex items-center">
                                                    @if($user->image && file_exists(public_path('storage/' . $user->image)))
                                                        <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-300"
                                                             src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->full_name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                                            {{ strtoupper(substr($user->full_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->full_name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->mobile_no }}</div>
                                                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $user->testBook->count() }}">
                                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                                    @if($user->status == 'active') bg-green-100 text-green-800
                                                    @elseif($user->status == 'inactive') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($user->status ?? 'unknown') }}
                                                </span>
                                            </td>
                                        @endif

                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $booking->test->test_name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $booking->start_time ?? '-' }} - {{ $booking->end_time ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($booking->status ?? 'unknown') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $booking->test->category ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($booking->test->sample_required ?? false)
                                                <span class="text-green-600 font-medium">Yes</span>
                                                @if($booking->test->sample_type)
                                                    <br><small class="text-gray-500">({{ $booking->test->sample_type }})</small>
                                                @endif
                                            @else
                                                <span class="text-red-600 font-medium">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            @if($booking->test->fasting_required ?? false)
                                                <span class="text-green-600 font-medium">Yes</span>
                                            @else
                                                <span class="text-red-600 font-medium">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @php
                                                $report = \App\Models\TestReport::where('user_id', $user->id)
                                                    ->where('file_name', 'like', '%'.$booking->test->test_name.'%')
                                                    ->first();
                                            @endphp
                                            @if($report)
                                                <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank"
                                                   class="text-blue-600 hover:text-blue-800 font-medium underline">
                                                    View Report
                                                </a>
                                            @else
                                                <button onclick="openUploadModal({{ $user->id }}, {{ $booking->id }}, '{{ addslashes($booking->test->test_name) }}')"
                                                        class="text-green-600 hover:text-green-800 font-medium">
                                                    Upload Report
                                                </button>
                                            @endif
                                        </td>
                                                <td class="px-6 py-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <select onchange="updateStatus(this)" data-booking-id="{{ $booking->id }}" data-old-status="{{ $booking->status }}" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                                    <option value="booked" {{ $booking->status == 'booked' ? 'selected' : '' }}>Booked</option>
                                                    <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Complete</option>
                                                </select>
                                                @if(!$report)

                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No test bookings found</h3>
                <p class="text-gray-500">There are currently no users who have booked any tests.</p>
            </div>
        @endif
    </div>
</div>

<!-- Upload Report Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-5" id="modalTitle">Upload Report</h3>
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="userId" name="user_id">
            <input type="hidden" id="bookingId" name="booking_id">
            <input type="hidden" id="testName" name="test_name">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Report File</label>
                <input type="file" name="report_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Doctor</label>
                <select name="doctor_id" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Choose Doctor</option>
                    @foreach(\App\Models\Employee::where('status', 'active')->get() as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Upload Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUploadModal(userId, bookingId, testName) {
        document.getElementById('userId').value = userId;
        document.getElementById('bookingId').value = bookingId;
        document.getElementById('testName').value = testName;
        document.getElementById('modalTitle').innerText = 'Upload Report for ' + testName;
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('uploadModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('uploadModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/admin/test/report/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Report uploaded successfully!');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Upload failed. Please try again.');
        });
    });

function changeStatus(bookingId, newStatus) {
    fetch('/admin/test/booking/status/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            booking_id: bookingId,
            status: newStatus
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('Status updated!');
            location.reload();
        }
    })
    .catch(err => console.error(err));
}
</script>
<script>
    function updateStatus(selectElement) {
        const bookingId = selectElement.dataset.bookingId;
        if (!bookingId) {
            alert('Invalid booking ID');
            return;
        }
        const newStatus = selectElement.value;
        const oldStatus = selectElement.dataset.oldStatus;

        // Agar same status select kiya to kuch mat karo
        if (newStatus === oldStatus) return;

        // Confirm dialog (optional – acha lagta hai)
        if (!confirm(`Are you sure you want to change status to "${newStatus}"?`)) {
            selectElement.value = oldStatus; // revert back
            return;
        }

        fetch("{{ route('admin.test.booking.status.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                "Accept": "application/json"
            },
            body: JSON.stringify({
                booking_id: bookingId,
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Status updated successfully!");
                
                // Update badge color automatically
                const badge = selectElement.closest('tr').querySelector('.status-badge');
                if (badge) {
                    badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    badge.className = 'px-3 py-1 inline-flex text-xs font-semibold rounded-full status-badge ' +
                        (newStatus === 'confirmed' ? 'bg-green-100 text-green-800' :
                         newStatus === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                         newStatus === 'cancelled' ? 'bg-red-100 text-red-800' :
                         newStatus === 'completed' ? 'bg-blue-100 text-blue-800' :
                         'bg-gray-100 text-gray-800');
                }

                // Update data-old-status so next time compare sahi ho
                selectElement.dataset.oldStatus = newStatus;
            } else {
                alert("Error: " + (data.message || "Something went wrong"));
                selectElement.value = oldStatus;
            }
        })
        .catch(err => {
            console.error(err);
            alert("Failed to update status. Check console.");
            selectElement.value = oldStatus;
        });
    }
</script>
@endsection