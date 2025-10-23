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
      <i class="fas fa-users text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Registered Users</h1>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="addUserBtn">
      <i class="fas fa-plus mr-2"></i>Add User
    </button>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-users text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalUsers">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Users</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-check text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activeUsers">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Active Users</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-times text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="inactiveUsers">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Inactive Users</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-md text-3xl text-purple-600 dark:text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="registeredUsers">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Registered</div>
      </div>
    </div>
  </div>

  <!-- Users Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
        User Details
      </h2>
    </div>
    <!-- Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="userNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter user name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Email</label>
        <input type="text" id="userEmailFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter email">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Type</label>
        <select id="userTypeFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All</option>
          <option>ipd</option>
          <option>opd</option>
          <option>registered</option>
          <option>discharged</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="userStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All</option>
          <option>active</option>
          <option>inactive</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearUserFilters">Clear Filters</button>
      </div>
    </div>
    <div class="">
      <table class="w-full table-auto border-collapse overflow-x-auto">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">User ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Full Name</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Username</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Image</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Email</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Phone</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Type</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600 w-48">Action</th>
          </tr>
        </thead>
        <tbody id="userTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

<!-- View User Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="viewUserModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="viewUserModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
        User Details
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeViewUserModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <div class="space-y-4" id="userDetails">
      <!-- User details will be populated here -->
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="addUserModal">
  <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl w-full max-w-2xl max-h-screen overflow-y-auto border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="addUserModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
        Add New User
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeAddUserModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="addUserForm" class="space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
          <input type="text" id="addUserFullname" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
          <input type="text" id="addUserUsername" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input type="email" id="addUserEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
          <input type="text" id="addUserPhone" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
          <input type="password" id="addUserPassword" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Age</label>
          <input type="number" id="addUserAge" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" min="0" max="150">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
          <select id="addUserGender" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option value="">Select Gender</option>
            <option>male</option>
            <option>female</option>
            <option>other</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
          <select id="addUserType" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>ipd</option>
            <option>opd</option>
            <option>registered</option>
            <option>discharged</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="addUserStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>active</option>
            <option>inactive</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Registered Through</label>
          <select id="addUserRegisteredThrough" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>email_otp</option>
            <option>msg</option>
            <option>whatsapp</option>
            <option>google</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image</label>
          <input type="file" id="addUserImage" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" accept="image/*">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
        <textarea id="addUserAddress" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Add User</button>
    </form>
  </div>
</div>

<!-- Edit User Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="editUserModal">
  <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl w-full max-w-2xl max-h-screen overflow-y-auto border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="editUserModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
        Edit User
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeEditUserModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <form id="editUserForm" class="space-y-4">
      <input type="hidden" id="editUserId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
          <input type="text" id="editUserFullname" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
          <input type="text" id="editUserUsername" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input type="email" id="editUserEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
          <input type="text" id="editUserPhone" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Age</label>
          <input type="number" id="editUserAge" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" min="0" max="150">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
          <select id="editUserGender" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option value="">Select Gender</option>
            <option>male</option>
            <option>female</option>
            <option>other</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
          <select id="editUserType" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>ipd</option>
            <option>opd</option>
            <option>registered</option>
            <option>discharged</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="editUserStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" required>
            <option>active</option>
            <option>inactive</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image</label>
          <input type="file" id="editUserImage" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" accept="image/*">
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
        <textarea id="editUserAddress" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">Update User</button>
    </form>
  </div>
</div>

<script>
(function() {
if (window.registeredUsersScriptLoaded) return;
window.registeredUsersScriptLoaded = true;

var users = [];
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

// Load Users
function loadUsers() {
  showUserLoading();
  fetch('/admin/get-registered-users')
    .then(response => response.json())
    .then(data => {
      users = data;
      renderUsers();
      updateDashboard();
    });
}

// Loading Function
function showUserLoading() {
  document.getElementById("userTable").innerHTML = `
    <tr>
      <td colspan="10" class="text-center py-4">
        <div class="flex items-center justify-center">
          <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading Users...
        </div>
      </td>
    </tr>
  `;
}

// Render Users
function renderUsers(filteredUsers = users) {
  const userTable = document.getElementById("userTable");
  userTable.innerHTML = "";
  filteredUsers.forEach((u, i) => {
    const statusClass = u.status === "active" ? "text-green-500 dark:text-green-400" : "text-red-500 dark:text-red-400";
    const typeClass = u.type === "registered" ? "text-blue-500 dark:text-blue-400" : "text-gray-500 dark:text-gray-400";
    userTable.insertAdjacentHTML("beforeend", `
      <tr class="dark:bg-gray-800">
        <td class="px-4 py-3">${i + 1}</td>
        <td class="px-4 py-3">${u.user_id}</td>
        <td class="px-4 py-3">${u.fullname}</td>
        <td class="px-4 py-3">${u.username}</td>
        <td class="px-4 py-3">
          ${u.image ? `<img src="/${u.image}" alt="User Image" class="w-10 h-10 rounded-full object-cover">` : '<span class="text-gray-400">-</span>'}
        </td>
        <td class="px-4 py-3">${u.email || '-'}</td>
        <td class="px-4 py-3">${u.phone_no || '-'}</td>
        <td class="px-4 py-3 ${typeClass}">${u.type}</td>
        <td class="px-4 py-3 ${statusClass}">${u.status}</td>
        <td class="px-4 py-3">
          <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm" onclick="viewUser(${u.id})"><i class="fas fa-eye"></i></button>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="editUser(${u.id})"><i class="fas fa-edit"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteUser(${u.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
}

// Update Dashboard
function updateDashboard() {
  document.getElementById("totalUsers").textContent = users.length;
  document.getElementById("activeUsers").textContent = users.filter(u => u.status === "active").length;
  document.getElementById("inactiveUsers").textContent = users.filter(u => u.status === "inactive").length;
  document.getElementById("registeredUsers").textContent = users.filter(u => u.type === "registered").length;
}

// View User
function viewUser(id) {
  const user = users.find(u => u.id == id);
  if (!user) return;

  const details = document.getElementById("userDetails");
  details.innerHTML = `
    <div><strong>User ID:</strong> ${user.user_id}</div>
    <div><strong>Full Name:</strong> ${user.fullname}</div>
    <div><strong>Username:</strong> ${user.username}</div>
    <div><strong>Email:</strong> ${user.email || '-'}</div>
    <div><strong>Phone:</strong> ${user.phone_no || '-'}</div>
    <div><strong>Age:</strong> ${user.age || '-'}</div>
    <div><strong>Gender:</strong> ${user.gender || '-'}</div>
    <div><strong>Address:</strong> ${user.address || '-'}</div>
    <div><strong>Type:</strong> ${user.type}</div>
    <div><strong>Status:</strong> ${user.status}</div>
    <div><strong>Registered Through:</strong> ${user.registered_through || '-'}</div>
    <div><strong>Created At:</strong> ${new Date(user.created_at).toLocaleString()}</div>
  `;

  document.getElementById("viewUserModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("viewUserModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("viewUserModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Edit User
function editUser(id) {
  const user = users.find(u => u.id == id);
  if (!user) return;

  document.getElementById("editUserId").value = user.id;
  document.getElementById("editUserFullname").value = user.fullname;
  document.getElementById("editUserUsername").value = user.username;
  document.getElementById("editUserEmail").value = user.email || '';
  document.getElementById("editUserPhone").value = user.phone_no || '';
  document.getElementById("editUserAge").value = user.age || '';
  document.getElementById("editUserGender").value = user.gender || '';
  document.getElementById("editUserAddress").value = user.address || '';
  document.getElementById("editUserType").value = user.type;
  document.getElementById("editUserStatus").value = user.status;

  document.getElementById("editUserModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("editUserModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("editUserModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Update User
document.getElementById("editUserForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const id = document.getElementById("editUserId").value;
  const formData = new FormData();
  formData.append('fullname', document.getElementById("editUserFullname").value);
  formData.append('username', document.getElementById("editUserUsername").value);
  formData.append('email', document.getElementById("editUserEmail").value);
  formData.append('phone_no', document.getElementById("editUserPhone").value);
  formData.append('age', document.getElementById("editUserAge").value);
  formData.append('gender', document.getElementById("editUserGender").value);
  formData.append('address', document.getElementById("editUserAddress").value);
  formData.append('type', document.getElementById("editUserType").value);
  formData.append('status', document.getElementById("editUserStatus").value);
  const imageInput = document.getElementById("editUserImage");
  if (imageInput.files[0]) {
    formData.append('image', imageInput.files[0]);
  }

  fetch(`/admin/update-registered-user/${id}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadUsers();
    closeEditUserModal();
  })
  .catch(error => console.error('Error:', error));
});

// Delete User
function deleteUser(id) {
  if (!confirm("Are you sure you want to delete this user?")) return;

  fetch(`/admin/delete-registered-user/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadUsers();
  })
  .catch(error => console.error('Error:', error));
}

// Add User
function addUser() {
  document.getElementById("addUserModal").classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("addUserModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("addUserModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Add User Form Submission
document.getElementById("addUserForm").addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData();
  formData.append('fullname', document.getElementById("addUserFullname").value);
  formData.append('username', document.getElementById("addUserUsername").value);
  formData.append('email', document.getElementById("addUserEmail").value);
  formData.append('phone_no', document.getElementById("addUserPhone").value);
  formData.append('password', document.getElementById("addUserPassword").value);
  formData.append('age', document.getElementById("addUserAge").value);
  formData.append('gender', document.getElementById("addUserGender").value);
  formData.append('type', document.getElementById("addUserType").value);
  formData.append('status', document.getElementById("addUserStatus").value);
  formData.append('registered_through', document.getElementById("addUserRegisteredThrough").value);
  formData.append('address', document.getElementById("addUserAddress").value);
  const imageInput = document.getElementById("addUserImage");
  if (imageInput.files[0]) {
    formData.append('image', imageInput.files[0]);
  }

  fetch('/admin/add-registered-user', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadUsers();
    closeAddUserModal();
  })
  .catch(error => console.error('Error:', error));
});

// Close Modals
function closeViewUserModal() {
  document.getElementById("viewUserModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("viewUserModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("viewUserModal").classList.add("hidden"), 300);
}

function closeEditUserModal() {
  document.getElementById("editUserModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("editUserModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("editUserModal").classList.add("hidden"), 300);
}

function closeAddUserModal() {
  document.getElementById("addUserModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("addUserModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => document.getElementById("addUserModal").classList.add("hidden"), 300);
}

document.getElementById("closeViewUserModal").onclick = closeViewUserModal;
document.getElementById("closeEditUserModal").onclick = closeEditUserModal;
document.getElementById("closeAddUserModal").onclick = closeAddUserModal;
document.getElementById("addUserBtn").onclick = addUser;

window.onclick = e => {
  if (e.target === document.getElementById("viewUserModal")) closeViewUserModal();
  if (e.target === document.getElementById("editUserModal")) closeEditUserModal();
  if (e.target === document.getElementById("addUserModal")) closeAddUserModal();
};

// Filters
document.getElementById("userNameFilter").addEventListener("input", filterUsers);
document.getElementById("userEmailFilter").addEventListener("input", filterUsers);
document.getElementById("userTypeFilter").addEventListener("change", filterUsers);
document.getElementById("userStatusFilter").addEventListener("change", filterUsers);
document.getElementById("clearUserFilters").addEventListener("click", clearUserFilters);

function filterUsers() {
  const nameFilter = document.getElementById("userNameFilter").value.toLowerCase();
  const emailFilter = document.getElementById("userEmailFilter").value.toLowerCase();
  const typeFilter = document.getElementById("userTypeFilter").value;
  const statusFilter = document.getElementById("userStatusFilter").value;

  const filteredUsers = users.filter(u => {
    const matchesName = u.fullname.toLowerCase().includes(nameFilter);
    const matchesEmail = (u.email || '').toLowerCase().includes(emailFilter);
    const matchesType = typeFilter === "" || u.type === typeFilter;
    const matchesStatus = statusFilter === "" || u.status === statusFilter;
    return matchesName && matchesEmail && matchesType && matchesStatus;
  });

  renderUsers(filteredUsers);
}

function clearUserFilters() {
  document.getElementById("userNameFilter").value = "";
  document.getElementById("userEmailFilter").value = "";
  document.getElementById("userTypeFilter").value = "";
  document.getElementById("userStatusFilter").value = "";
  renderUsers();
}

// Load data on page load
loadUsers();

// Expose functions to global scope
window.viewUser = viewUser;
window.editUser = editUser;
window.deleteUser = deleteUser;
})();
</script>
@endsection
