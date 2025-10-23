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
      <i class="fas fa-building text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Departments</h1>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="addDepartmentBtn">
      <i class="fas fa-plus mr-2"></i>Add Department
    </button>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-building text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalDepartments">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Departments</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-check-circle text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activeDepartments">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Active Departments</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-times-circle text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="inactiveDepartments">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Inactive Departments</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-clock text-3xl text-purple-600 dark:text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="recentDepartments">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Recent (This Month)</div>
      </div>
    </div>
  </div>

  <!-- Departments Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-building text-blue-600 dark:text-blue-400"></i>
        Department Details
      </h2>
    </div>
    <!-- Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="departmentNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter department name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Code</label>
        <input type="text" id="departmentCodeFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter department code">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="departmentStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearDepartmentFilters">Clear Filters</button>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Department ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Name</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Code</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Image</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Description</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="departmentTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

<!-- Add Department Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="addDepartmentModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="addDepartmentModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
        Add Department
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeAddDepartmentModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="addDepartmentForm" class="space-y-4" enctype="multipart/form-data">
      <input type="hidden" id="addDepartmentId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department Name</label>
          <input type="text" id="addDepartmentName" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department Code</label>
          <input type="text" id="addDepartmentCode" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="addDepartmentStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image</label>
          <input type="file" id="addDepartmentImage" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
        <textarea id="addDepartmentDescription" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter department description"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Add Department</button>
    </form>
  </div>
</div>

<!-- Edit Department Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="editDepartmentModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="editDepartmentModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
        Edit Department
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeEditDepartmentModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="editDepartmentForm" class="space-y-4" enctype="multipart/form-data">
      <input type="hidden" id="editDepartmentId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department ID</label>
          <input type="text" id="editDepartmentIdInput" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" readonly required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department Name</label>
          <input type="text" id="editDepartmentName" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department Code</label>
          <input type="text" id="editDepartmentCode" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="editDepartmentStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image</label>
        <input type="file" id="editDepartmentImage" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
        <textarea id="editDepartmentDescription" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter department description"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Update Department</button>
    </form>
  </div>
</div>

<script>
(function() {
if (window.departmentsScriptLoaded) return;
window.departmentsScriptLoaded = true;

var departments = [];
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

// Load Departments
function loadDepartments() {
  showDepartmentLoading();
  fetch('/admin/get-departments')
    .then(response => response.json())
    .then(data => {
      departments = data;
      renderDepartments();
      updateDashboard();
    });
}

// Loading Function
function showDepartmentLoading() {
  document.getElementById("departmentTable").innerHTML = `
    <tr>
      <td colspan="8" class="text-center py-4">
        <div class="flex items-center justify-center">
          <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading Departments...
        </div>
      </td>
    </tr>
  `;
}

// Render Departments
function renderDepartments(filteredDepartments = departments) {
  const departmentTable = document.getElementById("departmentTable");
  departmentTable.innerHTML = "";
  filteredDepartments.forEach((d, i) => {
    const statusClass = d.status === "Active" ? "text-green-500 dark:text-green-400" : "text-red-500 dark:text-red-400";
    const imageHtml = d.image_url ? `<img src="${d.image_url}" alt="${d.department_name}" class="w-12 h-12 object-cover rounded">` : '-';
    departmentTable.insertAdjacentHTML("beforeend", `
      <tr class="dark:bg-gray-800">
        <td class="px-4 py-3">${i + 1}</td>
        <td class="px-4 py-3">${d.department_id}</td>
        <td class="px-4 py-3">${d.department_name}</td>
        <td class="px-4 py-3">${d.department_code}</td>
        <td class="px-4 py-3">${imageHtml}</td>
        <td class="px-4 py-3">${d.description || '-'}</td>
        <td class="px-4 py-3 ${statusClass}">${d.status}</td>
        <td class="px-4 py-3">
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" onclick="editDepartment(${d.id})"><i class="fas fa-edit"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteDepartment(${d.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
}

// Update Dashboard
function updateDashboard() {
  document.getElementById("totalDepartments").textContent = departments.length;
  document.getElementById("activeDepartments").textContent = departments.filter(d => d.status === "Active").length;
  document.getElementById("inactiveDepartments").textContent = departments.filter(d => d.status === "Inactive").length;
  const currentMonth = new Date().getMonth();
  const currentYear = new Date().getFullYear();
  document.getElementById("recentDepartments").textContent = departments.filter(d => {
    const createdDate = new Date(d.created_at);
    return createdDate.getMonth() === currentMonth && createdDate.getFullYear() === currentYear;
  }).length;
}

// Edit Department
function editDepartment(id) {
  const department = departments.find(d => d.id == id);
  if (!department) return;

  document.getElementById("editDepartmentId").value = department.id;
  document.getElementById("editDepartmentIdInput").value = department.department_id;
  document.getElementById("editDepartmentName").value = department.department_name;
  document.getElementById("editDepartmentCode").value = department.department_code;
  document.getElementById("editDepartmentDescription").value = department.description || '';
  document.getElementById("editDepartmentStatus").value = department.status;

  document.getElementById("editDepartmentModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("editDepartmentModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("editDepartmentModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Update Department
document.getElementById("editDepartmentForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const idInput = document.getElementById("editDepartmentId");
  const idInput2 = document.getElementById("editDepartmentIdInput");
  const nameInput = document.getElementById("editDepartmentName");
  const codeInput = document.getElementById("editDepartmentCode");
  const descInput = document.getElementById("editDepartmentDescription");
  const statusInput = document.getElementById("editDepartmentStatus");
  const imageInput = document.getElementById("editDepartmentImage");
  if (!idInput || !idInput2 || !nameInput || !codeInput || !descInput || !statusInput || !imageInput) {
    console.error('One or more form elements not found');
    return;
  }
  const id = idInput.value;
  const formData = new FormData();
  formData.append('department_id', idInput2.value);
  formData.append('department_name', nameInput.value);
  formData.append('department_code', codeInput.value);
  formData.append('description', descInput.value);
  formData.append('status', statusInput.value);
  const imageFile = imageInput.files[0];
  if (imageFile) {
    formData.append('image', imageFile);
  }

  fetch(`/admin/update-department/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'X-HTTP-Method-Override': 'PUT'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.errors) {
      alert('Validation errors: ' + Object.values(data.errors).flat().join(', '));
    } else {
      showNotification(data.message);
      loadDepartments();
      closeEditDepartmentModal();
    }
  })
  .catch(error => console.error('Error:', error));
});

// Delete Department
function deleteDepartment(id) {
  if (!confirm("Are you sure you want to delete this department?")) return;

  fetch(`/admin/delete-department/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadDepartments();
  })
  .catch(error => console.error('Error:', error));
}

// Add Department
document.getElementById("addDepartmentBtn").addEventListener("click", () => {
  document.getElementById("addDepartmentModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("addDepartmentModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("addDepartmentModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
});

document.getElementById("addDepartmentForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const nameInput = document.getElementById("addDepartmentName");
  const codeInput = document.getElementById("addDepartmentCode");
  const descInput = document.getElementById("addDepartmentDescription");
  const statusInput = document.getElementById("addDepartmentStatus");
  const imageInput = document.getElementById("addDepartmentImage");
  const idInput = document.getElementById("addDepartmentId");
  if (!nameInput || !codeInput || !descInput || !statusInput || !imageInput || !idInput) {
    console.error('One or more form elements not found');
    return;
  }
  // Generate unique department ID
  const departmentId = 'DT' + Date.now();
  idInput.value = departmentId;

  const formData = new FormData();
  formData.append('department_id', departmentId);
  formData.append('department_name', nameInput.value);
  formData.append('department_code', codeInput.value);
  formData.append('description', descInput.value);
  formData.append('status', statusInput.value);
  const imageFile = imageInput.files[0];
  if (imageFile) {
    formData.append('image', imageFile);
  }

  fetch('/admin/store-department', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.errors) {
      alert('Validation errors: ' + Object.values(data.errors).flat().join(', '));
    } else {
      showNotification(data.message);
      loadDepartments();
      closeAddDepartmentModal();
      document.getElementById("addDepartmentForm").reset();
    }
  })
  .catch(error => console.error('Error:', error));
});

// Close Modals
function closeAddDepartmentModal() {
  document.getElementById("addDepartmentModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("addDepartmentModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("addDepartmentModal").classList.add("hidden"), 300);
}

function closeEditDepartmentModal() {
  document.getElementById("editDepartmentModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("editDepartmentModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("editDepartmentModal").classList.add("hidden"), 300);
}

document.getElementById("closeAddDepartmentModal").onclick = closeAddDepartmentModal;
document.getElementById("closeEditDepartmentModal").onclick = closeEditDepartmentModal;

window.onclick = e => {
  if (e.target === document.getElementById("addDepartmentModal")) closeAddDepartmentModal();
  if (e.target === document.getElementById("editDepartmentModal")) closeEditDepartmentModal();
};

// Filters
document.getElementById("departmentNameFilter").addEventListener("input", filterDepartments);
document.getElementById("departmentCodeFilter").addEventListener("input", filterDepartments);
document.getElementById("departmentStatusFilter").addEventListener("change", filterDepartments);
document.getElementById("clearDepartmentFilters").addEventListener("click", clearDepartmentFilters);

function filterDepartments() {
  const nameFilter = document.getElementById("departmentNameFilter").value.toLowerCase();
  const codeFilter = document.getElementById("departmentCodeFilter").value.toLowerCase();
  const statusFilter = document.getElementById("departmentStatusFilter").value;

  const filteredDepartments = departments.filter(d => {
    const matchesName = d.department_name.toLowerCase().includes(nameFilter);
    const matchesCode = d.department_code.toLowerCase().includes(codeFilter);
    const matchesStatus = statusFilter === "" || d.status === statusFilter;
    return matchesName && matchesCode && matchesStatus;
  });

  renderDepartments(filteredDepartments);
}

function clearDepartmentFilters() {
  document.getElementById("departmentNameFilter").value = "";
  document.getElementById("departmentCodeFilter").value = "";
  document.getElementById("departmentStatusFilter").value = "";
  renderDepartments();
}

// Load data on page load
loadDepartments();

// Expose functions to global scope
window.editDepartment = editDepartment;
window.deleteDepartment = deleteDepartment;
})();
</script>
@endsection
