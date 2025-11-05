@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <!-- Notification Area -->
    <div id="notification" class="fixed top-4 right-4 z-50 hidden bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            <span id="notificationMessage"></span>
        </div>
    </div>

    <!-- Topbar -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-door-open text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Rooms</h1>
        </div>
        <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="addRoomBtn">
                <i class="fas fa-plus mr-2"></i>Add Room
            </button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="assignRoomBtn">
                <i class="fas fa-user-plus mr-2"></i>Assign Room
            </button>
        </div>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-door-open text-3xl text-blue-600 dark:text-blue-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalRooms">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Rooms</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-check-circle text-3xl text-green-600 dark:text-green-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activeRooms">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Active Rooms</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-times-circle text-3xl text-red-600 dark:text-red-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white" id="inactiveRooms">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Inactive Rooms</div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
            <i class="fas fa-user-check text-3xl text-purple-600 dark:text-purple-400"></i>
            <div>
                <div class="text-2xl font-bold text-gray-800 dark:text-white" id="assignedRooms">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Assigned Rooms</div>
            </div>
        </div>
    </div>

    <!-- Rooms Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-door-open text-blue-600 dark:text-blue-400"></i>
                Room Details
            </h2>
        </div>
        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Room No</label>
                <input type="text" id="roomNoFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter room number">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Department</label>
                <select id="departmentFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
                    <option value="">All Departments</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                <select id="roomStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearRoomFilters">Clear Filters</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Room ID</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Room No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Department</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody id="roomTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
            </table>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="addRoomModal">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="addRoomModalContent">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
                    Add Room
                </h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeAddRoomModal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="addRoomForm" class="space-y-4">
                <div id="addRoomErrors" class="text-red-500 text-sm hidden"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Room Number</label>
                        <input type="text" id="addRoomNo" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select id="addRoomDepartment" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="addRoomStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Add Room</button>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="editRoomModal">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="editRoomModalContent">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
                    Edit Room
                </h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeEditRoomModal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="editRoomForm" class="space-y-4">
                <input type="hidden" id="editRoomId">
                <div id="editRoomErrors" class="text-red-500 text-sm hidden"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Room Number</label>
                        <input type="text" id="editRoomNo" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select id="editRoomDepartment" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                            <option value="">Select Department</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="editRoomStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Update Room</button>
            </form>
        </div>
    </div>

    <!-- Assign Room Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="assignRoomModal">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-2xl border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="assignRoomModalContent">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-user-plus text-blue-600 dark:text-blue-400"></i>
                    Assign Room to Department Employees
                </h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeAssignRoomModal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="assignRoomForm" class="space-y-4">
                <div id="assignRoomErrors" class="text-red-500 text-sm hidden"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Room</label>
                        <select id="assignRoomId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                            <option value="">Select Room</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                        <select id="assignDepartmentId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
                            <option value="">Select Department</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Employees from Department</label>
                    <div class="flex items-center space-x-2 mb-2">
                        <input type="checkbox" id="selectAllEmployees" class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700">
                        <label for="selectAllEmployees" class="text-sm text-gray-700 dark:text-gray-300">Select All</label>
                    </div>
                    <div id="employeeSelection" class="max-h-60 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md p-3 bg-gray-50 dark:bg-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Please select a department to load employees</p>
                    </div>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Assign Selected Employees to Room</button>
            </form>
        </div>
    </div>

    <!-- View Assignment Details Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="viewAssignmentModal">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-4xl border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="viewAssignmentModalContent">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-eye text-blue-600 dark:text-blue-400"></i>
                    Room Assignment Details
                </h3>
                <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeViewAssignmentModal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="space-y-4">
                <!-- Room Info -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Room Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Room ID:</span>
                            <span class="text-sm text-gray-800 dark:text-white ml-2" id="viewRoomId"></span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Room No:</span>
                            <span class="text-sm text-gray-800 dark:text-white ml-2" id="viewRoomNo"></span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Department:</span>
                            <span class="text-sm text-gray-800 dark:text-white ml-2" id="viewDepartment"></span>
                        </div>
                    </div>
                </div>

                <!-- Assignments Table -->
                <div>
                    <h4 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Assigned Employees</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse border border-gray-300 dark:border-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Employee Name</th>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Employee Code</th>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Profession</th>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Experience</th>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Assigned At</th>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
                                    <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody id="assignmentDetailsTable" class="text-gray-800 dark:text-gray-200">
                                <!-- Assignment details will be populated here -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noAssignmentsMessage" class="text-center py-4 text-gray-500 dark:text-gray-400 hidden">
                        No assignments found for this room.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

// resources/js/rooms.js
(function () {
    if (window.roomsScriptLoaded) return;
    window.roomsScriptLoaded = true;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let rooms = [];
    let departments = [];

    let employees = [];
    const notification = document.getElementById("notification");
    const notificationMessage = document.getElementById("notificationMessage");

    // Show Notification
    function showNotification(message, bgClass = "bg-green-500") {
        notificationMessage.textContent = message;
        notification.className = `fixed top-4 right-4 z-50 ${bgClass} text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300`;
        notification.classList.remove("hidden", "opacity-0");
        notification.classList.add("opacity-100");
        setTimeout(() => {
            notification.classList.remove("opacity-100");
            notification.classList.add("opacity-0");
            setTimeout(() => notification.classList.add("hidden"), 300);
        }, 3000);
    }

    // Handle Errors
    function handleError(error, message = "An error occurred. Please try again.") {
        showNotification(message, "bg-red-500");
        console.error('Error:', error);
    }

    // Check for Unsaved Changes
    function hasUnsavedChanges(formId) {
        try {
            const form = document.getElementById(formId);
            if (!form) return false; // No form means no unsaved changes
            return Array.from(form.elements).some(el => el && el.value !== el.defaultValue);
        } catch (e) {
            return false; // If anything goes wrong, assume no unsaved changes
        }
    }

    // Generic Modal Closing
    function closeModal(modalId, contentId, skipUnsavedCheck = false) {
        const formId = modalId.replace('Modal', 'Form');
        if (!skipUnsavedCheck && hasUnsavedChanges(formId) && !confirm("You have unsaved changes. Are you sure you want to close?")) return;
        const content = document.getElementById(contentId);
        content.classList.remove("scale-100", "opacity-100");
        content.classList.add("scale-95", "opacity-0");
        setTimeout(() => document.getElementById(modalId).classList.add("hidden"), 300);
    }

    // Load Departments
    function loadDepartments() {
        document.getElementById("addRoomDepartment").innerHTML = '<option value="">Loading...</option>';
        fetch('/admin/get-departments')
            .then(response => response.json())
            .then(data => {
                departments = data;
                populateDepartmentSelects();
            })
            .catch(error => handleError(error, "Failed to load departments"));
    }



    // Load Employees (not used directly, but kept for completeness)
    function loadEmployees() {
        fetch('/admin/get-employees')
            .then(response => response.json())
            .then(data => {
                employees = data;
            })
            .catch(error => handleError(error, "Failed to load employees"));
    }

    // Load Rooms
    function loadRooms() {
        showRoomLoading();
        fetch('/admin/get-rooms')
            .then(response => response.json())
            .then(data => {
                rooms = data;
                renderRooms();
                updateDashboard();
                populateRoomSelect();
            })
            .catch(error => handleError(error, "Failed to load rooms"));
    }

    // Show Loading State for Room Table
    function showRoomLoading() {
        document.getElementById("roomTable").innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading Rooms...
                    </div>
                </td>
            </tr>
        `;
    }

    // Render Rooms
    function renderRooms(filteredRooms = rooms) {
        const roomTable = document.getElementById("roomTable");
        roomTable.innerHTML = "";
        filteredRooms.forEach((r, i) => {
            const statusClass = r.status === "active" ? "text-green-500 dark:text-green-400" : "text-red-500 dark:text-red-400";
            const departmentName = r.department ? r.department.department_name : '-';
            const displayStatus = r.status.charAt(0).toUpperCase() + r.status.slice(1);

            roomTable.insertAdjacentHTML("beforeend", `
                <tr class="dark:bg-gray-800">
                    <td class="px-4 py-3">${i + 1}</td>
                    <td class="px-4 py-3">${r.room_id}</td>
                    <td class="px-4 py-3">${r.room_no}</td>
                    <td class="px-4 py-3">${departmentName}</td>
                    <td class="px-4 py-3 ${statusClass}">${displayStatus}</td>
                    <td class="px-4 py-3">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" onclick="editRoom(${r.id})"><i class="fas fa-edit"></i></button>
                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="viewAssignmentDetails(${r.id})"><i class="fas fa-eye"></i></button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteRoom(${r.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `);
        });
    }

    // Update Dashboard
    function updateDashboard() {
        document.getElementById("totalRooms").textContent = rooms.length;
        document.getElementById("activeRooms").textContent = rooms.filter(r => r.status === "active").length;
        document.getElementById("inactiveRooms").textContent = rooms.filter(r => r.status === "inactive").length;
        fetch('/admin/get-assigned-rooms')
            .then(response => response.json())
            .then(data => {
                document.getElementById("assignedRooms").textContent = data.assigned || 0;
            })
            .catch(error => handleError(error, "Failed to load assigned rooms"));
    }

    // Populate Department Selects
    function populateDepartmentSelects() {
        const selects = ['addRoomDepartment', 'editRoomDepartment', 'assignDepartmentId', 'departmentFilter'];
        selects.forEach(selectId => {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Select Department</option>';
            departments.forEach(d => {
                select.insertAdjacentHTML('beforeend', `<option value="${d.id}">${d.department_name}</option>`);
            });
        });
    }



    // Load Employees by Department
    function loadEmployeesByDepartment(departmentId) {
        const employeeSelection = document.getElementById('employeeSelection');
        employeeSelection.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-sm">Loading employees...</p>';

        fetch(`/admin/get-employees-by-department/${departmentId}`)
            .then(response => response.json())
            .then(data => {
                employeeSelection.innerHTML = '';
                if (data.length === 0) {
                    employeeSelection.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-sm">No employees found in this department</p>';
                    return;
                }
                data.forEach(employee => {
                    const checkboxDiv = document.createElement('div');
                    checkboxDiv.className = 'flex items-center space-x-2';
                    checkboxDiv.innerHTML = `
                        <input type="checkbox" id="emp_${employee.id}" value="${employee.id}" class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700">
                        <label for="emp_${employee.id}" class="text-sm text-gray-700 dark:text-gray-300">${employee.name} (${employee.employee_code})</label>
                    `;
                    employeeSelection.appendChild(checkboxDiv);
                });
            })
            .catch(error => {
                employeeSelection.innerHTML = '<p class="text-red-500 text-sm">Error loading employees</p>';
                handleError(error, "Failed to load employees");
            });
    }

    // Populate Room Select for Assignment
    function populateRoomSelect() {
        const select = document.getElementById('assignRoomId');
        select.innerHTML = '<option value="">Select Room</option>';
        rooms.filter(r => r.status === 'active').forEach(r => {
            select.insertAdjacentHTML('beforeend', `<option value="${r.id}">${r.room_no} (${r.room_id})</option>`);
        });
    }

    // Edit Room
    window.editRoom = function (id) {
        const room = rooms.find(r => r.id == id);
        if (!room) return;

        document.getElementById("editRoomId").value = room.id;
        document.getElementById("editRoomNo").value = room.room_no;
        document.getElementById("editRoomDepartment").value = room.department_id || '';
        document.getElementById("editRoomStatus").value = room.status;

        document.getElementById("editRoomModal").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("editRoomModalContent").classList.remove("scale-95", "opacity-0");
            document.getElementById("editRoomModalContent").classList.add("scale-100", "opacity-100");
        }, 10);
    };

    // Delete Room
    window.deleteRoom = function (id) {
        if (!confirm("Are you sure you want to delete this room?")) return;

        fetch(`/admin/delete-room/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(response => response.json())
            .then(data => {
                showNotification(data.message);
                loadRooms();
            })
            .catch(error => handleError(error, "Failed to delete room"));
    };

    // Add Room
    document.getElementById("addRoomBtn").addEventListener("click", () => {
        document.getElementById("addRoomErrors").classList.add("hidden");
        document.getElementById("addRoomModal").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("addRoomModalContent").classList.remove("scale-95", "opacity-0");
            document.getElementById("addRoomModalContent").classList.add("scale-100", "opacity-100");
        }, 10);
    });

    document.getElementById("addRoomForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const errorDiv = document.getElementById("addRoomErrors");
        errorDiv.classList.add("hidden");

        const formData = new FormData();
        formData.append('room_no', document.getElementById("addRoomNo").value);
        formData.append('department_id', document.getElementById("addRoomDepartment").value);
        formData.append('status', document.getElementById("addRoomStatus").value);

        fetch('/admin/store-room', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    errorDiv.textContent = Object.values(data.errors).flat().join(", ");
                    errorDiv.classList.remove("hidden");
                } else {
                    showNotification(data.message);
                    loadRooms();
                    document.getElementById("addRoomForm").reset();
                    closeModal("addRoomModal", "addRoomModalContent", true);
                }
            })
            .catch(error => handleError(error, "Failed to add room"));
    });

    // Update Room
    document.getElementById("editRoomForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const errorDiv = document.getElementById("editRoomErrors");
        errorDiv.classList.add("hidden");

        const id = document.getElementById("editRoomId").value;
        const formData = new FormData();
        formData.append('room_no', document.getElementById("editRoomNo").value);
        formData.append('department_id', document.getElementById("editRoomDepartment").value);
        formData.append('status', document.getElementById("editRoomStatus").value);

        fetch(`/admin/update-room/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    errorDiv.textContent = Object.values(data.errors).flat().join(", ");
                    errorDiv.classList.remove("hidden");
                } else {
                    showNotification(data.message);
                    loadRooms();
                    closeModal("editRoomModal", "editRoomModalContent");
                }
            })
            .catch(error => handleError(error, "Failed to update room"));
    });

    // Assign Room
    document.getElementById("assignRoomBtn").addEventListener("click", () => {
        document.getElementById("assignRoomErrors").classList.add("hidden");
        populateRoomSelect();
        document.getElementById("assignRoomModal").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("assignRoomModalContent").classList.remove("scale-95", "opacity-0");
            document.getElementById("assignRoomModalContent").classList.add("scale-100", "opacity-100");
        }, 10);
    });

    document.getElementById("assignDepartmentId").addEventListener("change", (e) => {
        const departmentId = e.target.value;
        if (departmentId) {
            loadEmployeesByDepartment(departmentId);
        } else {
            document.getElementById('employeeSelection').innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-sm">Please select a department to load employees</p>';
        }
    });

    document.getElementById("selectAllEmployees").addEventListener("change", (e) => {
        document.querySelectorAll('#employeeSelection input[type="checkbox"]').forEach(cb => {
            cb.checked = e.target.checked;
        });
    });

    document.getElementById("assignRoomForm").addEventListener("submit", (e) => {
        e.preventDefault();
        const errorDiv = document.getElementById("assignRoomErrors");
        errorDiv.classList.add("hidden");

        const roomId = document.getElementById("assignRoomId").value;
        const departmentId = document.getElementById("assignDepartmentId").value;
        const selectedEmployees = Array.from(document.querySelectorAll('#employeeSelection input[type="checkbox"]:checked')).map(cb => cb.value);

        if (!roomId) {
            errorDiv.textContent = "Please select a room";
            errorDiv.classList.remove("hidden");
            return;
        }
        if (!departmentId) {
            errorDiv.textContent = "Please select a department";
            errorDiv.classList.remove("hidden");
            return;
        }
        if (selectedEmployees.length === 0) {
            errorDiv.textContent = "Please select at least one employee";
            errorDiv.classList.remove("hidden");
            return;
        }

        const formData = new FormData();
        formData.append('room_id', roomId);
        formData.append('department_id', departmentId);
        selectedEmployees.forEach(empId => formData.append('employee_ids[]', empId));

        fetch('/admin/assign-room', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    errorDiv.textContent = Object.values(data.errors).flat().join(", ");
                    errorDiv.classList.remove("hidden");
                } else {
                    showNotification(data.message);
                    closeModal("assignRoomModal", "assignRoomModalContent");
                    document.getElementById("assignRoomForm").reset();
                }
            })
            .catch(error => handleError(error, "Failed to assign room"));
    });

    // View Assignment Details
    window.viewAssignmentDetails = function (id) {
        const room = rooms.find(r => r.id == id);
        if (!room) return;

        // Populate room info
        document.getElementById("viewRoomId").textContent = room.room_id;
        document.getElementById("viewRoomNo").textContent = room.room_no;
        document.getElementById("viewDepartment").textContent = room.department ? room.department.department_name : '-';

        // Load assignments
        fetch(`/admin/get-room-assignments/${id}`)
            .then(response => response.json())
            .then(data => {
                const table = document.getElementById("assignmentDetailsTable");
                table.innerHTML = "";
                if (data.length === 0) {
                    document.getElementById("noAssignmentsMessage").classList.remove("hidden");
                    return;
                }
                document.getElementById("noAssignmentsMessage").classList.add("hidden");
                data.forEach(assignment => {
                    const row = `
                        <tr>
                            <td class="px-4 py-3">${assignment.employee.name}</td>
                            <td class="px-4 py-3">${assignment.employee.employee_code}</td>
                            <td class="px-4 py-3">${assignment.employee.profession || '-'}</td>
                            <td class="px-4 py-3">${assignment.employee.experience || '-'}</td>
                            <td class="px-4 py-3">${new Date(assignment.assigned_at).toLocaleDateString()}</td>
                            <td class="px-4 py-3">${assignment.status || 'Active'}</td>
                            <td class="px-4 py-3">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" onclick="removeAssignedEmployee(${assignment.id})"><i class="fas fa-user-minus"></i></button>
                            </td>
                        </tr>
                    `;
                    table.insertAdjacentHTML("beforeend", row);
                });
            })
            .catch(error => handleError(error, "Failed to load assignment details"));

        // Show modal
        document.getElementById("viewAssignmentModal").classList.remove("hidden");
        setTimeout(() => {
            document.getElementById("viewAssignmentModalContent").classList.remove("scale-95", "opacity-0");
            document.getElementById("viewAssignmentModalContent").classList.add("scale-100", "opacity-100");
        }, 10);
    };

    // Remove Assigned Employee
    window.removeAssignedEmployee = function (assignmentId) {
        if (!confirm("Are you sure you want to remove this employee from the room?")) return;

        fetch(`/admin/remove-room-assignment/${assignmentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(response => response.json())
            .then(data => {
                showNotification(data.message);
                // Refresh the assignment details modal
                const roomId = rooms.find(r => r.room_assignments.some(a => a.id == assignmentId))?.id;
                if (roomId) {
                    viewAssignmentDetails(roomId);
                }
                // Refresh dashboard
                updateDashboard();
            })
            .catch(error => handleError(error, "Failed to remove employee"));
    };

    // Close Modals
    document.getElementById("closeAddRoomModal").onclick = () => closeModal("addRoomModal", "addRoomModalContent", true);
    document.getElementById("closeEditRoomModal").onclick = () => closeModal("editRoomModal", "editRoomModalContent");
    document.getElementById("closeAssignRoomModal").onclick = () => closeModal("assignRoomModal", "assignRoomModalContent", true);
    document.getElementById("closeViewAssignmentModal").onclick = () => closeModal("viewAssignmentModal", "viewAssignmentModalContent", true);

    window.onclick = e => {
        if (e.target === document.getElementById("addRoomModal")) closeModal("addRoomModal", "addRoomModalContent");
        if (e.target === document.getElementById("editRoomModal")) closeModal("editRoomModal", "editRoomModalContent");
        if (e.target === document.getElementById("assignRoomModal")) closeModal("assignRoomModal", "assignRoomModalContent");
        if (e.target === document.getElementById("viewAssignmentModal")) closeModal("viewAssignmentModal", "viewAssignmentModalContent");
    };

    // Filters
    let debounceTimeout;
    document.getElementById("roomNoFilter").addEventListener("input", () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(filterRooms, 300);
    });
    document.getElementById("departmentFilter").addEventListener("change", filterRooms);
    document.getElementById("roomStatusFilter").addEventListener("change", filterRooms);
    document.getElementById("clearRoomFilters").addEventListener("click", clearRoomFilters);

    function filterRooms() {
        const roomNoFilter = document.getElementById("roomNoFilter").value.toLowerCase();
        const departmentFilter = document.getElementById("departmentFilter").value;
        const statusFilter = document.getElementById("roomStatusFilter").value;

        const filteredRooms = rooms.filter(r => {
            const matchesRoomNo = r.room_no.toLowerCase().includes(roomNoFilter);
            const matchesDepartment = departmentFilter === "" || r.department_id == departmentFilter;
            const matchesStatus = statusFilter === "" || r.status === statusFilter;
            return matchesRoomNo && matchesDepartment && matchesStatus;
        });

        renderRooms(filteredRooms);
    }

    function clearRoomFilters() {
        document.getElementById("roomNoFilter").value = "";
        document.getElementById("departmentFilter").value = "";
        document.getElementById("roomStatusFilter").value = "";
        renderRooms();
    }

    // Load data on page load
    loadDepartments();
    loadEmployees();
    loadRooms();
})();

</script>

@endsection