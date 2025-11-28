@extends('layouts.layout')

@section('content')

<div class="min-h-screen">

    <!-- Toast -->
    <div id="toast" class="hidden" 
     style="position: fixed; top: 80px;  right: 5px; 
            background-color: #16a34a; color: white; 
            padding: 0.5rem 1rem; border-radius: 0.5rem; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.2); z-index: 50; transition: all 0.3s ease;">
    <span id="toastMessage"></span>
</div>


    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-concierge-bell text-2xl text-blue-600 text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 text-white">Reception Management</h1>
        </div>
        <button id="addReceptionBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
            <i class="fa fa-plus"></i> Add Reception
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-users text-3xl text-blue-600 text-blue-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 text-white">{{ $totalReceptions }}</div>
                <div class="text-sm text-gray-600 text-gray-400">Total Receptions</div>
            </div>
        </div>
        <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-check-circle text-3xl text-green-600 text-green-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 text-white">{{ $activeReceptions }}</div>
                <div class="text-sm text-gray-600 text-gray-400">Active</div>
            </div>
        </div>
        <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-times-circle text-3xl text-red-600 text-red-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 text-white">{{ $inactiveReceptions }}</div>
                <div class="text-sm text-gray-600 text-gray-400">Inactive</div>
            </div>
        </div>
    </div>



    <!-- Filters -->
    <div class="mb-6 bg-white-50 bg-white-700 p-4 rounded-lg">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Status</label>
                <select name="status" onchange="this.form.submit()"
                    class="w-full border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                    <option value="">All</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Search Reception</label>
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by reception ID or employee"
                        class="flex-1 border border-gray-300 border-gray-600 rounded-lg px-3 py-2 bg-white bg-white-800">
                    <button class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.reception.index') }}"
                        class="bg-white-500 hover:bg-white-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Reception Table -->
    <div class="overflow-x-auto bg-white bg-white-800 rounded-lg shadow-md border border-gray-200 border-gray-700">
        <table class="min-w-full divide-y divide-gray-200 divide-gray-700">
            <thead class="bg-white-50 bg-white-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Reception ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Assigned Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white bg-white-800 divide-y divide-gray-200 divide-gray-700">
                @forelse($receptions as $rec)
                <tr class="hover:bg-white-50 hover:bg-white-700 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $rec->reception_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-white">{{ $rec->employee->name ?? 'Not Assigned' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $rec->status == 'active' ? 'bg-green-100 text-green-800 bg-green-800 text-green-200' : 'bg-red-100 text-red-800 bg-red-800 text-red-200' }}">
                            {{ ucfirst($rec->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center items-center gap-2">
                            <!-- View Button -->
                            <button type="button"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition flex items-center justify-center gap-1"
                                onclick="openViewModal('{{ $rec->id }}','{{ $rec->employee->name ?? '' }}','{{ $rec->status }}','{{ $rec->reception_id }}')">
                                <i class="fa-solid fa-eye"></i>
                            </button>


                            <!-- Assign Button -->
                            <button type="button"
                                class="assignBtn bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition flex items-center justify-center gap-1"
                                data-reception-id="{{ $rec->id }}"
                                data-reception-name="{{ $rec->reception_id }}"
                                data-assigned-employee-id="{{ $rec->assigned_employee ?? '' }}">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>

                            <!-- Edit Button -->
                            <button type="button"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition flex items-center justify-center"
                                onclick="openEditModal('{{ $rec->id }}','{{ $rec->reception_id }}','{{ $rec->assigned_employee ?? '' }}','{{ $rec->status }}')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.reception.destroy', $rec->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition flex items-center justify-center gap-1"
                                    onclick="return confirm('Are you sure you want to delete this reception?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 text-gray-400">No Receptions Found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 flex justify-center">{{ $receptions->links() }}</div>
</div>

<!-- Add Reception Modal -->
<div id="addReceptionModal" class="fixed inset-0 hidden z-50 bg-white bg-opacity-50 flex items-center justify-center">
    <div class="bg-white bg-white-900 p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-gray-100">Add Reception</h2>
        <form action="{{ route('admin.reception.store') }}" method="POST">
            @csrf
            <label class="block mb-2 text-gray-700 text-gray-300">Reception ID</label>
            <input type="text" name="reception_id" value="{{ $nextReceptionId }}" class="w-full border border-gray-300 border-gray-600 rounded px-3 py-2 mb-4" readonly>

            <label class="block mb-2 text-gray-700 text-gray-300">Status</label>
            <select name="status" class="w-full border border-gray-300 border-gray-600 rounded px-3 py-2 mb-4">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 hidden bg-white bg-opacity-50 flex items-center justify-center">
    <div class="bg-white bg-white-900 p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-gray-100">Reception Details</h2>
        <div id="viewModalData" class="text-gray-700 text-gray-300 space-y-2"></div>

        <form id="unassignForm" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 w-full text-center">
                Unassign Employee
            </button>
        </form>


        <button onclick="closeViewModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Close</button>
    </div>
</div>




<!-- Assign Modal -->
<!-- Assign Employee Modal -->
<div id="assignModal" class="fixed inset-0 bg-white bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl w-full max-w-md p-6 relative shadow-lg">
        <!-- Close button -->
        <button id="closeAssignModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

        <h2 id="assignModalTitle" class="text-2xl font-semibold mb-6 text-center">Assign Employee</h2>

        <form id="assignForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="employee_id" class="block text-gray-700 font-medium mb-2">
                    Select Receptionist
                </label>

                <select name="employee_id" id="employee_id"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Receptionist --</option>
                    @foreach($receptionists as $emp)
                    @if($emp->employee)
                    <option value="{{ $emp->employee->id }}">
                        {{ $emp->employee->name }} ({{ $emp->employee->employee_code }})
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" id="cancelAssignBtn" class="px-4 py-2 bg-white-300 text-gray-700 rounded hover:bg-white-400 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Assign</button>
            </div>
        </form>
    </div>
</div>



















<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 hidden bg-white bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white bg-white-900 p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 text-gray-800 text-gray-100">Edit Reception</h2>
        <form action="{{ route('admin.reception.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="editId">

            <label class="block mb-2 text-gray-700 text-gray-300">Reception ID</label>
            <input type="text" name="reception_id" id="editReceptionId" class="w-full border border-gray-300 border-gray-600 rounded px-3 py-2 mb-4">

            <label class="block mb-2 text-gray-700 text-gray-300">Assigned Employee</label>
            <select name="employee_id" id="editAssignedEmployee"
                class="w-full border border-gray-300 border-gray-600 rounded px-3 py-2 mb-4">
                <option value="">-- Select Employee --</option>

                @foreach($receptionists as $emp)
                @if($emp->employee)
                <option value="{{ $emp->employee->id }}">
                    {{ $emp->employee->name }} ({{ $emp->employee->employee_code }})
                </option>
                @endif
                @endforeach
            </select>



            <label class="block mb-2 text-gray-700 text-gray-300">Status</label>
            <select name="status" id="editStatus" class="w-full border border-gray-300 border-gray-600 rounded px-3 py-2 mb-4">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</div>


<script>
    // Add Modal
    const addBtn = document.getElementById('addReceptionBtn');
    const addModal = document.getElementById('addReceptionModal');
    addBtn.addEventListener('click', () => addModal.classList.remove('hidden'));

    function closeAddModal() {
        addModal.classList.add('hidden');
    }




    //view model 
   function openViewModal(id, assigned, status, reception_id) {
    document.getElementById('viewModalData').innerHTML = `
        <p><b>Reception ID:</b> ${reception_id}</p>
        <p><b>Assigned Employee:</b> ${assigned || 'Not Assigned'}</p>
        <p><b>Status:</b> ${status}</p>
    `;

    // Use primary key (numeric id) for form action
    const form = document.getElementById('unassignForm');
    form.action = `/admin/receptions/${id}/unassign`;

    document.getElementById('viewModal').classList.remove('hidden');
}






    //edit model 
    function openEditModal(id, reception_id, assignedEmployeeId, status) {
        document.getElementById('editId').value = id;
        document.getElementById('editReceptionId').value = reception_id;

        // Dynamically set the selected employee
        const select = document.getElementById('editAssignedEmployee');
        select.value = assignedEmployeeId || '';

        document.getElementById('editStatus').value = status;
        document.getElementById('editModal').classList.remove('hidden');
    }


    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }


    // Toast
    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }
    @if(session('success')) showToast("{{ session('success') }}");
    @endif
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('assignModal');
        const assignForm = document.getElementById('assignForm');
        const modalTitle = document.getElementById('assignModalTitle');
        const employeeSelect = document.getElementById('employee_id');

        // Open modal on all buttons with class assignBtn
        document.querySelectorAll('.assignBtn').forEach(button => {
            button.addEventListener('click', function() {
                const receptionId = this.dataset.receptionId;
                const receptionName = this.dataset.receptionName;
                const assignedEmployeeId = this.dataset.assignedEmployeeId;

                // Show modal
                modal.style.display = 'flex';

                // Set modal title
                modalTitle.textContent = `Assign Employee to ${receptionName}`;

                // Set form action dynamically (include admin prefix)
                assignForm.action = `/admin/receptions/${receptionId}/assign`;

                // Preselect assigned employee if exists
                if (assignedEmployeeId) {
                    employeeSelect.value = assignedEmployeeId;
                } else {
                    employeeSelect.value = ""; // no selection if none assigned
                }
            });
        });

        // Close modal buttons
        document.getElementById('closeAssignModal').onclick = () => modal.style.display = 'none';
        document.getElementById('cancelAssignBtn').onclick = () => modal.style.display = 'none';
    });
</script>




@endsection