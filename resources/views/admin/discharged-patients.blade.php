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
      <i class="fas fa-user-times text-2xl text-red-600 dark:text-red-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Discharged Patients</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-users text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalPatients">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Discharged Patients</div>
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
      <i class="fas fa-user-md text-3xl text-purple-600 dark:text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="dischargedPatients">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Discharged</div>
      </div>
    </div>
  </div>

  <!-- Patients Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
        Discharged Patient Details
      </h2>
    </div>
    <!-- Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="patientNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter patient name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Email</label>
        <input type="text" id="patientEmailFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter email">
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
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
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
if (window.dischargedPatientsScriptLoaded) return;
window.dischargedPatientsScriptLoaded = true;

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
  fetch('/admin/get-discharged-patients')
    .then(response => response.json())
    .then(data => {
      patients = data;
      renderPatients();
      updateDashboard();
    });
}

// Loading Function
function showPatientLoading() {
  document.getElementById("patientTable").innerHTML = `
    <tr>
      <td colspan="8" class="text-center py-4">
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
    patientTable.insertAdjacentHTML("beforeend", `
      <tr class="dark:bg-gray-800">
        <td class="px-4 py-3">${i + 1}</td>
        <td class="px-4 py-3">${p.user_id}</td>
        <td class="px-4 py-3">${p.fullname}</td>
        <td class="px-4 py-3">${p.username}</td>
        <td class="px-4 py-3">${p.email || '-'}</td>
        <td class="px-4 py-3">${p.phone_no || '-'}</td>
        <td class="px-4 py-3 ${statusClass}">${p.status}</td>
        <td class="px-4 py-3">
          <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm" onclick="viewPatient(${p.id})"><i class="fas fa-eye"></i></button>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="editPatient(${p.id})"><i class="fas fa-edit"></i></button>
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
  document.getElementById("dischargedPatients").textContent = patients.filter(p => p.type === "discharged").length;
}

// View Patient
function viewPatient(id) {
  const patient = patients.find(p => p.id == id);
  if (!patient) return;

  const details = document.getElementById("patientDetails");
  details.innerHTML = `
    <div><strong>Patient ID:</strong> ${patient.user_id}</div>
    <div><strong>Full Name:</strong> ${patient.fullname}</div>
    <div><strong>Username:</strong> ${patient.username}</div>
    <div><strong>Email:</strong> ${patient.email || '-'}</div>
    <div><strong>Phone:</strong> ${patient.phone_no || '-'}</div>
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
  document.getElementById("editPatientFullname").value = patient.fullname || '';
  document.getElementById("editPatientUsername").value = patient.username || '';
  document.getElementById("editPatientEmail").value = patient.email || '';
  document.getElementById("editPatientPhone").value = patient.phone_no || '';
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

  fetch(`/admin/update-discharged-patient/${id}`, {
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
    const matchesName = p.fullname.toLowerCase().includes(nameFilter);
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

// Load data on page load
loadPatients();

// Expose functions to global scope
window.viewPatient = viewPatient;
window.editPatient = editPatient;
})();
</script>
@endsection
