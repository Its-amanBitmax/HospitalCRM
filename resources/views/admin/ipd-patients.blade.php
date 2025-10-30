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
      <i class="fas fa-procedures text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">IPD Patients</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-users text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalPatients">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total IPD Patients</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-check text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activePatients">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Active</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-times text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="inactivePatients">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Inactive</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-procedures text-3xl text-purple-600 dark:text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="ipdPatients">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">IPD</div>
      </div>
    </div>
  </div>

  <!-- Patients Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
        IPD Patient Details
      </h2>
    </div>
    <!-- Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="patientNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter patient name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Email</label>
        <input type="text" id="patientEmailFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter email">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Type</label>
        <select id="patientTypeFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All</option>
          <option>ipd</option>
          <option>opd</option>
          <option>registered</option>
          <option>discharged</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="patientStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All</option>
          <option>active</option>
          <option>inactive</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearPatientFilters">Clear Filters</button>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Patient ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Full Name</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Username</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Email</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Phone</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Bed Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600 w-48">Action</th>
          </tr>
        </thead>
        <tbody id="patientTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

<!-- View Patient Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="viewPatientModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="viewPatientModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
        Patient Details
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeViewPatientModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <div class="space-y-4" id="patientDetails">
      <!-- Patient details will be populated here -->
    </div>
  </div>
</div>

<!-- Bed Details Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="bedDetailsModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-2xl border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="bedDetailsModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-bed text-blue-600 dark:text-blue-400"></i>
        Bed Details
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeBedDetailsModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <div id="bedDetailsContent">
      <!-- Bed details will be populated here -->
    </div>
  </div>
</div>

<!-- Assign Bed Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="assignBedModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="assignBedModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
        Assign Bed
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeAssignBedModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="assignBedForm" class="space-y-4">
      <input type="hidden" id="assignBedUserId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Ward</label>
          <select id="assignBedWardId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option value="">Select Ward</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Bed</label>
          <select id="assignBedBedId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option value="">Select Bed</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assigned Date</label>
          <input type="date" id="assignBedDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Assign Bed</button>
    </form>
  </div>
</div>

<!-- Transfer Bed Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="transferBedModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="transferBedModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-exchange-alt text-yellow-600 dark:text-yellow-400"></i>
        Transfer Patient
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeTransferBedModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="transferBedForm" class="space-y-4">
      <input type="hidden" id="transferBedAssignmentId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select New Ward</label>
          <select id="transferBedWardId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option value="">Select Ward</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select New Bed</label>
          <select id="transferBedBedId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option value="">Select Bed</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Transfer Date</label>
          <input type="date" id="transferBedDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
      </div>
      <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Transfer Patient</button>
    </form>
  </div>
</div>

<!-- Edit Patient Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="editPatientModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="editPatientModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
        Edit Patient
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeEditPatientModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="editPatientForm" class="space-y-4">
      <input type="hidden" id="editPatientId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
          <input type="text" id="editPatientFullname" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
          <input type="text" id="editPatientUsername" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input type="email" id="editPatientEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
          <input type="text" id="editPatientPhone" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Age</label>
          <input type="number" id="editPatientAge" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" min="0" max="150">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
          <select id="editPatientGender" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option value="">Select Gender</option>
            <option>male</option>
            <option>female</option>
            <option>other</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
          <select id="editPatientType" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>ipd</option>
            <option>opd</option>
            <option>registered</option>
            <option>discharged</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="editPatientStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>active</option>
            <option>inactive</option>
          </select>
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
        <textarea id="editPatientAddress" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Update Patient</button>
    </form>
  </div>
</div>

<script>
(function() {
if (window.ipdPatientsScriptLoaded) return;
window.ipdPatientsScriptLoaded = true;

var patients = [];
var notification = document.getElementById("notification");
var notificationMessage = document.getElementById("notificationMessage");

// Function to show notification
function showNotification(message) {
  notificationMessage.textContent = message;
  notification.classList.remove("hidden");
  notification.classList.add("opacity-100");
  setTimeout(() => {
    notification.classList.remove("opacity-100");
    notification.classList.add("opacity-0");
    setTimeout(() => notification.classList.add("hidden"), 300);
  }, 3000);
}

// Load Patients
function loadPatients() {
  showPatientLoading();
  fetch('/admin/get-registered-users')
    .then(response => response.json())
    .then(data => {
      patients = data.filter(p => p.type === 'ipd');
      // Load bed assignments for each patient
      const promises = patients.map(patient => {
        return fetch(`/admin/ward-bed/get-bed-assignments/${patient.id}`)
          .then(response => response.json())
          .then(assignments => {
            patient.bedAssignments = assignments;
            patient.activeBedAssignment = assignments.find(a => a.status === 'active');
            return patient;
          });
      });
      return Promise.all(promises);
    })
    .then(() => {
      renderPatients();
      updateDashboard();
    });
}

// Loading Function
function showPatientLoading() {
  document.getElementById("patientTable").innerHTML = `
    <tr>
      <td colspan="9" class="text-center py-4">
        <div class="flex items-center justify-center">
          <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading Patients...
        </div>
      </td>
    </tr>
  `;
}

// Render Patients
function renderPatients(filteredPatients = patients) {
  const patientTable = document.getElementById("patientTable");
  patientTable.innerHTML = "";
  filteredPatients.forEach((p, i) => {
    const statusClass = p.status === "active" ? "text-green-500 dark:text-green-400" : "text-red-500 dark:text-red-400";
    const bedStatus = p.activeBedAssignment ?
      `<span class="text-green-500 dark:text-green-400">Assigned (${p.activeBedAssignment.bed.bed_id})</span>` :
      `<span class="text-red-500 dark:text-red-400">Not Assigned</span>`;
    patientTable.insertAdjacentHTML("beforeend", `
      <tr class="dark:bg-gray-800">
        <td class="px-4 py-3">${i + 1}</td>
        <td class="px-4 py-3">${p.user_id}</td>
        <td class="px-4 py-3">${p.full_name}</td>
        <td class="px-4 py-3">${p.username}</td>
        <td class="px-4 py-3">${p.email || '-'}</td>
        <td class="px-4 py-3">${p.mobile_no || '-'}</td>
        <td class="px-4 py-3">${bedStatus}</td>
        <td class="px-4 py-3 ${statusClass}">${p.status}</td>
        <td class="px-4 py-3">
          <a href="/admin/users/${p.id}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm inline-block"><i class="fas fa-eye"></i></a>
          <a href="/admin/users/${p.id}/edit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm ml-2 inline-block"><i class="fas fa-edit"></i></a>
          <a href="/admin/users/${p.id}/visits" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm ml-2 inline-block"><i class="fas fa-calendar"></i></a>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="viewBedDetails(${p.id})"><i class="fas fa-bed"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteUser(${p.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
}

// Update Dashboard
function updateDashboard() {
  document.getElementById("totalPatients").textContent = patients.length;
  document.getElementById("activePatients").textContent = patients.filter(p => p.status === "active").length;
  document.getElementById("inactivePatients").textContent = patients.filter(p => p.status === "inactive").length;
  document.getElementById("ipdPatients").textContent = patients.filter(p => p.type === "ipd").length;
}

// View Patient
function viewPatient(id) {
  const patient = patients.find(p => p.id == id);
  if (!patient) return;

  const details = document.getElementById("patientDetails");
  details.innerHTML = `
    <div><strong>Patient ID:</strong> ${patient.user_id}</div>
    <div><strong>Full Name:</strong> ${patient.full_name}</div>
    <div><strong>Username:</strong> ${patient.username}</div>
    <div><strong>Email:</strong> ${patient.email || '-'}</div>
    <div><strong>Phone:</strong> ${patient.mobile_no || '-'}</div>
    <div><strong>Age:</strong> ${patient.age || '-'}</div>
    <div><strong>Gender:</strong> ${patient.gender || '-'}</div>
    <div><strong>Address:</strong> ${patient.address || '-'}</div>
    <div><strong>Type:</strong> ${patient.type}</div>
    <div><strong>Status:</strong> ${patient.status}</div>
    <div><strong>Registered Through:</strong> ${patient.registered_through || '-'}</div>
    <div><strong>Created At:</strong> ${new Date(patient.created_at).toLocaleString()}</div>
  `;

  document.getElementById("viewPatientModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("viewPatientModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("viewPatientModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Edit Patient
function editPatient(id) {
  const patient = patients.find(p => p.id == id);
  if (!patient) return;

  document.getElementById("editPatientId").value = patient.id;
  document.getElementById("editPatientFullname").value = patient.full_name || '';
  document.getElementById("editPatientUsername").value = patient.username || '';
  document.getElementById("editPatientEmail").value = patient.email || '';
  document.getElementById("editPatientPhone").value = patient.mobile_no || '';
  document.getElementById("editPatientAge").value = patient.age || '';
  document.getElementById("editPatientGender").value = patient.gender || '';
  document.getElementById("editPatientType").value = patient.type || '';
  document.getElementById("editPatientStatus").value = patient.status || '';
  document.getElementById("editPatientAddress").value = patient.address || '';

  document.getElementById("editPatientModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("editPatientModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("editPatientModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Update Patient
document.getElementById("editPatientForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const id = document.getElementById("editPatientId").value;
  const fullname = document.getElementById("editPatientFullname").value;
  const username = document.getElementById("editPatientUsername").value;
  const email = document.getElementById("editPatientEmail").value;
  const phone_no = document.getElementById("editPatientPhone").value;
  const age = document.getElementById("editPatientAge").value;
  const gender = document.getElementById("editPatientGender").value;
  const type = document.getElementById("editPatientType").value;
  const status = document.getElementById("editPatientStatus").value;
  const address = document.getElementById("editPatientAddress").value;

  fetch(`/admin/update-ipd-patient/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ fullname, username, email, phone_no, age, gender, address, type, status })
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadPatients();
    closeEditPatientModal();
  })
  .catch(error => console.error('Error:', error));
});

// Close Modals
function closeViewPatientModal() {
  document.getElementById("viewPatientModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("viewPatientModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("viewPatientModal").classList.add("hidden"), 300);
}

function closeEditPatientModal() {
  document.getElementById("editPatientModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("editPatientModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("editPatientModal").classList.add("hidden"), 300);
}

document.getElementById("closeViewPatientModal").onclick = closeViewPatientModal;
document.getElementById("closeEditPatientModal").onclick = closeEditPatientModal;

window.onclick = e => {
  if (e.target === document.getElementById("viewPatientModal")) closeViewPatientModal();
  if (e.target === document.getElementById("editPatientModal")) closeEditPatientModal();
};

// Filters
document.getElementById("patientNameFilter").addEventListener("input", filterPatients);
document.getElementById("patientEmailFilter").addEventListener("input", filterPatients);
document.getElementById("patientStatusFilter").addEventListener("change", filterPatients);
document.getElementById("clearPatientFilters").addEventListener("click", clearPatientFilters);

function filterPatients() {
  const nameFilter = document.getElementById("patientNameFilter").value.toLowerCase();
  const emailFilter = document.getElementById("patientEmailFilter").value.toLowerCase();
  const statusFilter = document.getElementById("patientStatusFilter").value;

  const filteredPatients = patients.filter(p => {
    const matchesName = p.full_name.toLowerCase().includes(nameFilter);
    const matchesEmail = (p.email || '').toLowerCase().includes(emailFilter);
    const matchesStatus = statusFilter === "" || p.status === statusFilter;
    return matchesName && matchesEmail && matchesStatus;
  });

  renderPatients(filteredPatients);
}

function clearPatientFilters() {
  document.getElementById("patientNameFilter").value = "";
  document.getElementById("patientEmailFilter").value = "";
  document.getElementById("patientStatusFilter").value = "";
  renderPatients();
}

// Create Visit
function createVisit(id) {
  window.location.href = `/admin/users/create-visit?patient_id=${id}`;
}

// View Bed Details
function viewBedDetails(userId) {
  const patient = patients.find(p => p.id == userId);
  if (!patient) return;

  const content = document.getElementById("bedDetailsContent");

  if (patient.bedAssignments && patient.bedAssignments.length > 0) {
    let html = `
      <div class="mb-4">
        <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Bed Assignment History</h4>
        <div class="space-y-3">
    `;

    patient.bedAssignments.forEach(assignment => {
      const statusClass = assignment.status === 'active' ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400';
      html += `
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <strong>Bed ID:</strong> ${assignment.bed.bed_id}
            </div>
            <div>
              <strong>Ward:</strong> ${assignment.bed.ward ? assignment.bed.ward.name : 'N/A'}
            </div>
            <div>
              <strong>Status:</strong> <span class="${statusClass}">${assignment.status}</span>
            </div>
            <div>
              <strong>Assigned Date:</strong> ${new Date(assignment.assigned_date).toLocaleDateString()}
            </div>
            <div>
              <strong>Discharge Date:</strong> ${assignment.discharge_date ? new Date(assignment.discharge_date).toLocaleDateString() : 'N/A'}
            </div>
            <div>
              ${assignment.status === 'active' ?
                `<button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" onclick="dischargePatient(${assignment.id})">Discharge</button>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="transferPatient(${assignment.id})">Transfer</button>` :
                `<button class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm" disabled>Discharged</button>`
              }
            </div>
          </div>
        </div>
      `;
    });

    html += `
        </div>
      </div>
    `;

    if (!patient.activeBedAssignment) {
      html += `
        <div class="flex justify-end">
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg" onclick="assignBed(${userId})">Assign New Bed</button>
        </div>
      `;
    }

    content.innerHTML = html;
  } else {
    content.innerHTML = `
      <div class="text-center py-8">
        <i class="fas fa-bed text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
        <p class="text-gray-600 dark:text-gray-400 mb-4">No bed assigned to this patient yet.</p>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg" onclick="assignBed(${userId})">Assign Bed</button>
      </div>
    `;
  }

  document.getElementById("bedDetailsModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("bedDetailsModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("bedDetailsModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Assign Bed
function assignBed(userId) {
  closeBedDetailsModal();
  document.getElementById("assignBedUserId").value = userId;
  document.getElementById("assignBedDate").value = new Date().toISOString().split('T')[0];

  // Load wards
  fetch('/admin/ward-bed/get-wards')
    .then(response => response.json())
    .then(wards => {
      const wardSelect = document.getElementById("assignBedWardId");
      wardSelect.innerHTML = '<option value="">Select Ward</option>';
      wards.forEach(ward => {
        wardSelect.insertAdjacentHTML("beforeend", `<option value="${ward.id}">${ward.name} (Floor ${ward.floor})</option>`);
      });
    });

  document.getElementById("assignBedModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("assignBedModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("assignBedModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Discharge Patient
function dischargePatient(assignmentId) {
  if (confirm('Are you sure you want to discharge this patient from the bed?')) {
    fetch(`/admin/ward-bed/update-bed-assignment/${assignmentId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        discharge_date: new Date().toISOString().split('T')[0]
      })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadPatients();
      closeBedDetailsModal();
    })
    .catch(error => console.error('Error:', error));
  }
}

// Transfer Patient
function transferPatient(assignmentId) {
  closeBedDetailsModal();
  document.getElementById("transferBedAssignmentId").value = assignmentId;
  document.getElementById("transferBedDate").value = new Date().toISOString().split('T')[0];

  // Load wards
  fetch('/admin/ward-bed/get-wards')
    .then(response => response.json())
    .then(wards => {
      const wardSelect = document.getElementById("transferBedWardId");
      wardSelect.innerHTML = '<option value="">Select Ward</option>';
      wards.forEach(ward => {
        wardSelect.insertAdjacentHTML("beforeend", `<option value="${ward.id}">${ward.name} (Floor ${ward.floor})</option>`);
      });
    });

  document.getElementById("transferBedModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("transferBedModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("transferBedModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Delete Patient
function deletePatient(id) {
  if (confirm('Are you sure you want to delete this patient? This action cannot be undone.')) {
    fetch(`/admin/delete-patient/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadPatients();
    })
    .catch(error => console.error('Error:', error));
  }
}

// Close Bed Details Modal
function closeBedDetailsModal() {
  document.getElementById("bedDetailsModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("bedDetailsModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("bedDetailsModal").classList.add("hidden"), 300);
}

// Close Assign Bed Modal
function closeAssignBedModal() {
  document.getElementById("assignBedModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("assignBedModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("assignBedModal").classList.add("hidden"), 300);
}

// Close Transfer Bed Modal
function closeTransferBedModal() {
  document.getElementById("transferBedModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("transferBedModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("transferBedModal").classList.add("hidden"), 300);
}

// Ward change handler for assign bed
document.getElementById("assignBedWardId").addEventListener("change", function() {
  const wardId = this.value;
  const bedSelect = document.getElementById("assignBedBedId");
  bedSelect.innerHTML = '<option value="">Select Bed</option>';

  if (wardId) {
    fetch('/admin/ward-bed/get-beds')
      .then(response => response.json())
      .then(beds => {
        beds.filter(bed => bed.ward_id == wardId && bed.status === 'Active').forEach(bed => {
          bedSelect.insertAdjacentHTML("beforeend", `<option value="${bed.id}">${bed.bed_id} (${bed.type})</option>`);
        });
      });
  }
});

// Ward change handler for transfer bed
document.getElementById("transferBedWardId").addEventListener("change", function() {
  const wardId = this.value;
  const bedSelect = document.getElementById("transferBedBedId");
  bedSelect.innerHTML = '<option value="">Select Bed</option>';

  if (wardId) {
    fetch('/admin/ward-bed/get-beds')
      .then(response => response.json())
      .then(beds => {
        beds.filter(bed => bed.ward_id == wardId && bed.status === 'Active').forEach(bed => {
          bedSelect.insertAdjacentHTML("beforeend", `<option value="${bed.id}">${bed.bed_id} (${bed.type})</option>`);
        });
      });
  }
});

// Assign bed form submission
document.getElementById("assignBedForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const formData = new FormData(this);
  const data = {
    user_id: document.getElementById("assignBedUserId").value,
    bed_id: document.getElementById("assignBedBedId").value,
    assigned_date: document.getElementById("assignBedDate").value,
  };

  fetch('/admin/ward-bed/assign-bed', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      showNotification(data.error, 'error');
    } else {
      showNotification(data.message);
      loadPatients();
      closeAssignBedModal();
    }
  })
  .catch(error => console.error('Error:', error));
});

// Transfer bed form submission
document.getElementById("transferBedForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const assignmentId = document.getElementById("transferBedAssignmentId").value;
  const data = {
    bed_id: document.getElementById("transferBedBedId").value,
    assigned_date: document.getElementById("transferBedDate").value,
  };

  fetch(`/admin/ward-bed/transfer-bed/${assignmentId}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      showNotification(data.error, 'error');
    } else {
      showNotification(data.message);
      loadPatients();
      closeTransferBedModal();
    }
  })
  .catch(error => console.error('Error:', error));
});

// Modal close handlers
document.getElementById("closeBedDetailsModal").onclick = closeBedDetailsModal;
document.getElementById("closeAssignBedModal").onclick = closeAssignBedModal;
document.getElementById("closeTransferBedModal").onclick = closeTransferBedModal;

window.onclick = e => {
  if (e.target === document.getElementById("viewPatientModal")) closeViewPatientModal();
  if (e.target === document.getElementById("editPatientModal")) closeEditPatientModal();
  if (e.target === document.getElementById("bedDetailsModal")) closeBedDetailsModal();
  if (e.target === document.getElementById("assignBedModal")) closeAssignBedModal();
  if (e.target === document.getElementById("transferBedModal")) closeTransferBedModal();
};

// Load data on page load
loadPatients();

// Expose functions to global scope
window.viewPatient = viewPatient;
window.editPatient = editPatient;
window.createVisit = createVisit;
window.deletePatient = deletePatient;
window.viewBedDetails = viewBedDetails;
window.assignBed = assignBed;
window.dischargePatient = dischargePatient;
window.transferPatient = transferPatient;
})();
</script>
@endsection
