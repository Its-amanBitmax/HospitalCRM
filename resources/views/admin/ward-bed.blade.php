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
      <i class="fas fa-hospital text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Ward & Bed Management</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-bed text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalBeds">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Beds</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-circle-check text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="availableBeds">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Available Beds</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-user-injured text-3xl text-yellow-600 dark:text-yellow-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="occupiedBeds">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Occupied Beds</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-broom text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="maintenanceBeds">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Beds in Maintenance</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-hospital text-3xl text-purple-600 dark:text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activeWards">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Active Wards</div>
      </div>
    </div>
  </div>

  <!-- Ward Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-hospital text-blue-600 dark:text-blue-400"></i>
        Ward Details
      </h2>
      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition" id="openWardModalSection">
        <i class="fa fa-plus mr-2"></i>Add Ward
      </button>
    </div>
    <!-- Ward Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="wardNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter ward name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Floor</label>
        <input type="number" id="wardFloorFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter floor">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="wardStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All</option>
          <option>Active</option>
          <option>Maintenance</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearWardFilters">Clear Filters</button>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Ward ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Ward Name</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Floor</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Bed Limit</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">No. of Beds</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="wardTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- Bed Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-bed text-green-600 dark:text-green-400"></i>
        Bed Details
      </h2>
      <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition" id="openBedModalSection">
        <i class="fa fa-bed mr-2"></i>Add Bed
      </button>
    </div>
    <!-- Bed Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Ward</label>
        <select id="bedWardFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Wards</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Type</label>
        <select id="bedTypeFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Types</option>
          <option>General</option>
          <option>Critical</option>
          <option>Deluxe</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="bedStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Statuses</option>
          <option>Active</option>
          <option>Occupied</option>
          <option>Maintenance</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearBedFilters">Clear Filters</button>
      </div>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Bed ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Ward</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Type</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="bedTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

<!-- Ward Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="wardModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="wardModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i>
        Add New Ward
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeWardModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ward Name</label>
        <input type="text" id="wardName" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Ward Name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Floor</label>
        <input type="number" id="wardFloor" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Floor Number">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bed Limit</label>
        <input type="number" id="bedLimit" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Bed Limit">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
        <select id="wardStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option>Active</option>
          <option>Maintenance</option>
        </select>
      </div>
      <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="saveWard">Save Ward</button>
    </div>
  </div>
</div>

<!-- Bed Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="bedModal">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="bedModalContent">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-bed text-green-600 dark:text-green-400"></i>
        Add New Bed
      </h3>
      <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeBedModal">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Ward</label>
        <select id="bedWard" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200"></select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bed ID (Unique)</label>
        <input type="text" id="bedId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter unique bed number">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
        <select id="bedType" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option>General</option>
          <option>Critical</option>
          <option>Deluxe</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
        <select id="bedStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option>Active</option>
          <option>Occupied</option>
          <option>Maintenance</option>
        </select>
      </div>
      <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center" id="saveBed">
        <span id="saveBedText">Save Bed</span>
        <div id="saveBedLoader" class="hidden ml-2">
          <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </div>
      </button>
    </div>
  </div>
</div>



<script>
(function() {
if (window.wardBedScriptLoaded) return;
window.wardBedScriptLoaded = true;

var wards = [];
var beds = [];

var modalWard = document.getElementById("wardModal");
var modalBed = document.getElementById("bedModal");
var wardTable = document.getElementById("wardTable");
var bedTable = document.getElementById("bedTable");
var bedWardSelect = document.getElementById("bedWard");
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

document.getElementById("openWardModalSection").onclick = () => {
  modalWard.classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("wardModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("wardModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
};
document.getElementById("openBedModalSection").onclick = () => {
  if(wards.length === 0){ alert("Add a ward first!"); return; }
  bedWardSelect.innerHTML = wards.map(w => `<option value="${w.id}">${w.name}</option>`).join('');
  modalBed.classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("bedModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("bedModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
};

function closeWardModal() {
  document.getElementById("wardModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("wardModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => modalWard.classList.add("hidden"), 300);
}

function closeBedModal() {
  document.getElementById("bedModalContent").classList.remove("scale-100", "opacity-100");
  document.getElementById("bedModalContent").classList.add("scale-95", "opacity-0");
  setTimeout(() => modalBed.classList.add("hidden"), 300);
}

document.getElementById("closeWardModal").onclick = closeWardModal;
document.getElementById("closeBedModal").onclick = closeBedModal;

window.onclick = e => {
  if(e.target===modalWard) closeWardModal();
  if(e.target===modalBed) closeBedModal();
};

// Save Ward
document.getElementById("saveWard").onclick = () => {
  const name = document.getElementById("wardName").value.trim();
  const floor = document.getElementById("wardFloor").value;
  const limit = document.getElementById("bedLimit").value;
  const status = document.getElementById("wardStatus").value;
  if(!name || !floor || !limit){ alert("Please fill all fields!"); return; }

  fetch('/admin/ward-bed/store-ward', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ name, floor, bed_limit: limit, status })
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadWards();
    closeWardModal();
    document.querySelectorAll("#wardModal input, #wardModal select").forEach(i=>i.value="");
  })
  .catch(error => {
    console.error('Error:', error);
  });
};

// Save Bed
document.getElementById("saveBed").onclick = () => {
  const wardId = bedWardSelect.value;
  const bedId = document.getElementById("bedId").value.trim();
  const type = document.getElementById("bedType").value;
  const status = document.getElementById("bedStatus").value;
  if(!bedId){ alert("Enter bed ID!"); return; }

  // Show loader and disable button
  document.getElementById("saveBedLoader").classList.remove("hidden");
  document.getElementById("saveBedText").textContent = "Saving...";
  document.getElementById("saveBed").disabled = true;

  fetch('/admin/ward-bed/store-bed', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ ward_id: wardId, bed_id: bedId, type, status })
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadBeds().then(() => {
      loadWards().then(() => {
        closeBedModal();
        document.querySelectorAll("#bedModal input").forEach(i=>i.value="");
        // Hide loader and enable button
        document.getElementById("saveBedLoader").classList.add("hidden");
        document.getElementById("saveBedText").textContent = "Save Bed";
        document.getElementById("saveBed").disabled = false;
      });
    });
  })
  .catch(error => {
    console.error('Error:', error);
    // Hide loader and enable button
    document.getElementById("saveBedLoader").classList.add("hidden");
    document.getElementById("saveBedText").textContent = "Save Bed";
    document.getElementById("saveBed").disabled = false;
  });
};

// Load Functions
function loadWards() {
  return new Promise((resolve) => {
    showWardLoading();
    fetch('/admin/ward-bed/get-wards')
      .then(response => response.json())
      .then(data => {
        wards = data;
        renderWards();
        updateBedWardFilter();
        resolve();
      });
  });
}

function loadBeds() {
  return new Promise((resolve) => {
    showBedLoading();
    fetch('/admin/ward-bed/get-beds')
    .then(response => response.json())
    .then(data => {
      beds = data;
      renderBeds();
      resolve();
    });
  });
}

// Loading Functions
function showWardLoading() {
  wardTable.innerHTML = `
    <tr>
      <td colspan="8" class="text-center py-4">
        <div class="flex items-center justify-center">
          <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading Wards...
        </div>
      </td>
    </tr>
  `;
}

function showBedLoading() {
  bedTable.innerHTML = `
    <tr>
      <td colspan="6" class="text-center py-4">
        <div class="flex items-center justify-center">
          <svg class="animate-spin h-5 w-5 text-green-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Loading Beds...
        </div>
      </td>
    </tr>
  `;
}

// Render Functions
function renderWards(){
  wardTable.innerHTML = "";
  wards.forEach((w,i)=>{
    const statusClass = w.status === "Active" ? "text-green-500 dark:text-green-400" : "text-yellow-500 dark:text-yellow-400";
    wardTable.insertAdjacentHTML("beforeend",`
      <tr class="dark:bg-gray-800">
        <td>${i+1}</td>
        <td>${w.ward_id}</td>
        <td>${w.name}</td>
        <td>${w.floor}</td>
        <td>${w.bed_limit}</td>
        <td>${w.beds_count}</td>
        <td class="${statusClass}">${w.status}</td>
        <td>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" onclick="editWard(${w.id})"><i class="fas fa-edit"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteWard(${w.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
  updateDashboard();
}

function renderBeds(){
  bedTable.innerHTML = "";
  beds.forEach((b,i)=>{
    const ward = wards.find(w=>w.id==b.ward_id);
    let statusClass = "text-green-500 dark:text-green-400";
    if(b.status==="Occupied") statusClass = "text-yellow-500 dark:text-yellow-400";
    else if(b.status==="Maintenance") statusClass = "text-red-500 dark:text-red-400";
    bedTable.insertAdjacentHTML("beforeend",`
      <tr class="dark:bg-gray-800">
        <td>${i+1}</td>
        <td>${b.bed_id}</td>
        <td>${ward?ward.name:"-"}</td>
        <td>${b.type}</td>
        <td class="${statusClass}">${b.status}</td>
        <td>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" onclick="editBed(${b.id})"><i class="fas fa-edit"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteBed(${b.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
  updateDashboard();
}

function updateDashboard(){
  const totalBeds = wards.reduce((sum, w) => sum + (parseInt(w.beds_count) || 0), 0);
  document.getElementById("totalBeds").textContent = totalBeds;
  document.getElementById("availableBeds").textContent = beds.filter(b=>b.status==="Active").length;
  document.getElementById("occupiedBeds").textContent = beds.filter(b=>b.status==="Occupied").length;
  document.getElementById("maintenanceBeds").textContent = beds.filter(b=>b.status==="Maintenance").length;
  document.getElementById("activeWards").textContent = wards.filter(w=>w.status==="Active").length;
}

// Edit Ward
function editWard(id) {
  const ward = wards.find(w => w.id == id);
  if (!ward) return;

  document.getElementById("wardName").value = ward.name;
  document.getElementById("wardFloor").value = ward.floor;
  document.getElementById("bedLimit").value = ward.bed_limit;
  document.getElementById("wardStatus").value = ward.status;

  document.getElementById("wardModalContent").querySelector("h3").innerHTML = '<i class="fas fa-edit text-blue-600 dark:text-blue-400"></i> Edit Ward';
  document.getElementById("saveWard").textContent = "Update Ward";
  document.getElementById("saveWard").onclick = () => updateWard(id);

  modalWard.classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("wardModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("wardModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Update Ward
function updateWard(id) {
  const name = document.getElementById("wardName").value.trim();
  const floor = document.getElementById("wardFloor").value;
  const limit = document.getElementById("bedLimit").value;
  const status = document.getElementById("wardStatus").value;
  if (!name || !floor || !limit) { alert("Please fill all fields!"); return; }

  fetch(`/admin/ward-bed/update-ward/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ name, floor, bed_limit: limit, status })
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadWards();
    closeWardModal();
    resetWardModal();
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

// Delete Ward
function deleteWard(id) {
  if (!confirm("Are you sure you want to delete this ward?")) return;

  fetch(`/admin/ward-bed/delete-ward/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadWards();
    loadBeds(); // Reload beds as ward deletion might affect beds
  })
  .catch(error => console.error('Error:', error));
}

// Edit Bed
function editBed(id) {
  const bed = beds.find(b => b.id == id);
  if (!bed) return;

  bedWardSelect.innerHTML = wards.map(w => `<option value="${w.id}">${w.name}</option>`).join('');
  bedWardSelect.value = bed.ward_id;
  document.getElementById("bedId").value = bed.bed_id;
  document.getElementById("bedType").value = bed.type;
  document.getElementById("bedStatus").value = bed.status;

  document.getElementById("bedModalContent").querySelector("h3").innerHTML = '<i class="fas fa-bed text-green-600 dark:text-green-400"></i> Edit Bed';
  document.getElementById("saveBedText").textContent = "Update Bed";
  document.getElementById("saveBed").onclick = () => updateBed(id);

  modalBed.classList.remove("hidden");
  setTimeout(() => {
    document.getElementById("bedModalContent").classList.remove("scale-95", "opacity-0");
    document.getElementById("bedModalContent").classList.add("scale-100", "opacity-100");
  }, 10);
}

// Update Bed
function updateBed(id) {
  const wardId = bedWardSelect.value;
  const bedId = document.getElementById("bedId").value.trim();
  const type = document.getElementById("bedType").value;
  const status = document.getElementById("bedStatus").value;
  if (!bedId) { alert("Enter bed ID!"); return; }

  // Show loader
  document.getElementById("saveBedLoader").classList.remove("hidden");
  document.getElementById("saveBedText").textContent = "Updating...";
  document.getElementById("saveBed").disabled = true;

  fetch(`/admin/ward-bed/update-bed/${id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ ward_id: wardId, bed_id: bedId, type, status })
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadBeds();
    closeBedModal();
    resetBedModal();
    // Hide loader
    document.getElementById("saveBedLoader").classList.add("hidden");
    document.getElementById("saveBedText").textContent = "Save Bed";
    document.getElementById("saveBed").disabled = false;
  })
  .catch(error => {
    console.error('Error:', error);
    // Hide loader
    document.getElementById("saveBedLoader").classList.add("hidden");
    document.getElementById("saveBedText").textContent = "Save Bed";
    document.getElementById("saveBed").disabled = false;
  });
}

// Delete Bed
function deleteBed(id) {
  if (!confirm("Are you sure you want to delete this bed?")) return;

  fetch(`/admin/ward-bed/delete-bed/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadBeds();
    loadWards();
  })
  .catch(error => console.error('Error:', error));
}

// Reset Ward Modal
function resetWardModal() {
  document.getElementById("wardModalContent").querySelector("h3").innerHTML = '<i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i> Add New Ward';
  document.getElementById("saveWard").onclick = () => {
    const name = document.getElementById("wardName").value.trim();
    const floor = document.getElementById("wardFloor").value;
    const limit = document.getElementById("bedLimit").value;
    const status = document.getElementById("wardStatus").value;
    if (!name || !floor || !limit) { alert("Please fill all fields!"); return; }

    fetch('/admin/ward-bed/store-ward', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ name, floor, bed_limit: limit, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadWards();
      closeWardModal();
      document.querySelectorAll("#wardModal input, #wardModal select").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
    });
  };
}

// Reset Bed Modal
function resetBedModal() {
  document.getElementById("bedModalContent").querySelector("h3").innerHTML = '<i class="fas fa-bed text-green-600 dark:text-green-400"></i> Add New Bed';
  document.getElementById("saveBedText").textContent = "Save Bed";
  document.getElementById("saveBed").onclick = () => {
    const wardId = bedWardSelect.value;
    const bedId = document.getElementById("bedId").value.trim();
    const type = document.getElementById("bedType").value;
    const status = document.getElementById("bedStatus").value;
  if (!bedId) { alert("Enter bed ID!"); return; }

  // Show loader and disable button
  document.getElementById("saveBedLoader").classList.remove("hidden");
  document.getElementById("saveBedText").textContent = "Saving...";
  document.getElementById("saveBed").disabled = true;

  fetch('/admin/ward-bed/store-bed', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ ward_id: wardId, bed_id: bedId, type, status })
    })
    .then(response => response.json())
  .then(data => {
    showNotification(data.message);
    loadBeds();
    loadWards();
    closeBedModal();
    document.querySelectorAll("#bedModal input").forEach(i => i.value = "");
    // Hide loader
    document.getElementById("saveBedLoader").classList.add("hidden");
    document.getElementById("saveBedText").textContent = "Save Bed";
    document.getElementById("saveBed").disabled = false;
  })
  .catch(error => {
    console.error('Error:', error);
    // Hide loader
    document.getElementById("saveBedLoader").classList.add("hidden");
    document.getElementById("saveBedText").textContent = "Save Bed";
    document.getElementById("saveBed").disabled = false;
  });
  };
}

// Load data on page load
loadWards();
loadBeds();

// Ward Filters
document.getElementById("wardNameFilter").addEventListener("input", filterWards);
document.getElementById("wardFloorFilter").addEventListener("input", filterWards);
document.getElementById("wardStatusFilter").addEventListener("change", filterWards);
document.getElementById("clearWardFilters").addEventListener("click", clearWardFilters);

// Bed Filters
document.getElementById("bedWardFilter").addEventListener("change", filterBeds);
document.getElementById("bedTypeFilter").addEventListener("change", filterBeds);
document.getElementById("bedStatusFilter").addEventListener("change", filterBeds);
document.getElementById("clearBedFilters").addEventListener("click", clearBedFilters);

// Filter Functions
function filterWards() {
  const nameFilter = document.getElementById("wardNameFilter").value.toLowerCase();
  const floorFilter = document.getElementById("wardFloorFilter").value;
  const statusFilter = document.getElementById("wardStatusFilter").value;

  const filteredWards = wards.filter(w => {
    const matchesName = w.name.toLowerCase().includes(nameFilter);
    const matchesFloor = floorFilter === "" || w.floor == floorFilter;
    const matchesStatus = statusFilter === "" || w.status === statusFilter;
    return matchesName && matchesFloor && matchesStatus;
  });

  renderFilteredWards(filteredWards);
}

function filterBeds() {
  const wardFilter = document.getElementById("bedWardFilter").value;
  const typeFilter = document.getElementById("bedTypeFilter").value;
  const statusFilter = document.getElementById("bedStatusFilter").value;

  const filteredBeds = beds.filter(b => {
    const ward = wards.find(w => w.id == b.ward_id);
    const matchesWard = wardFilter === "" || (ward && ward.id == wardFilter);
    const matchesType = typeFilter === "" || b.type === typeFilter;
    const matchesStatus = statusFilter === "" || b.status === statusFilter;
    return matchesWard && matchesType && matchesStatus;
  });

  renderFilteredBeds(filteredBeds);
}

function clearWardFilters() {
  document.getElementById("wardNameFilter").value = "";
  document.getElementById("wardFloorFilter").value = "";
  document.getElementById("wardStatusFilter").value = "";
  renderWards();
}

function clearBedFilters() {
  document.getElementById("bedWardFilter").value = "";
  document.getElementById("bedTypeFilter").value = "";
  document.getElementById("bedStatusFilter").value = "";
  renderBeds();
}

// Render Filtered Functions
function renderFilteredWards(filteredWards) {
  wardTable.innerHTML = "";
  filteredWards.forEach((w, i) => {
    const statusClass = w.status === "Active" ? "text-green-500 dark:text-green-400" : "text-yellow-500 dark:text-yellow-400";
    wardTable.insertAdjacentHTML("beforeend", `
      <tr class="dark:bg-gray-800">
        <td>${i + 1}</td>
        <td>${w.ward_id}</td>
        <td>${w.name}</td>
        <td>${w.floor}</td>
        <td>${w.bed_limit}</td>
        <td>${w.beds_count}</td>
        <td class="${statusClass}">${w.status}</td>
        <td>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" onclick="editWard(${w.id})"><i class="fas fa-edit"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteWard(${w.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
}

function renderFilteredBeds(filteredBeds) {
  bedTable.innerHTML = "";
  filteredBeds.forEach((b, i) => {
    const ward = wards.find(w => w.id == b.ward_id);
    let statusClass = "text-green-500 dark:text-green-400";
    if (b.status === "Occupied") statusClass = "text-yellow-500 dark:text-yellow-400";
    else if (b.status === "Maintenance") statusClass = "text-red-500 dark:text-red-400";
    bedTable.insertAdjacentHTML("beforeend", `
      <tr class="dark:bg-gray-800">
        <td>${i + 1}</td>
        <td>${b.bed_id}</td>
        <td>${ward ? ward.name : "-"}</td>
        <td>${b.type}</td>
        <td class="${statusClass}">${b.status}</td>
        <td>
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" onclick="editBed(${b.id})"><i class="fas fa-edit"></i></button>
          <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" onclick="deleteBed(${b.id})"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
    `);
  });
}

// Update bedWardFilter when wards are loaded
function updateBedWardFilter() {
  const bedWardFilter = document.getElementById("bedWardFilter");
  bedWardFilter.innerHTML = '<option value="">All Wards</option>' + wards.map(w => `<option value="${w.id}">${w.name}</option>`).join('');
}

// Expose functions to global scope for onclick handlers
window.editWard = editWard;
window.deleteWard = deleteWard;
window.editBed = editBed;
window.deleteBed = deleteBed;
})();
</script>
</body>
</html>
@endsection
