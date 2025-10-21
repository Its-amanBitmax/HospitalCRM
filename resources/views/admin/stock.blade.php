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
      <i class="fas fa-boxes text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Stock Management</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-box text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalItems">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Items</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-check-circle text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="availableItems">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Available Items</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-exclamation-triangle text-3xl text-yellow-600 dark:text-yellow-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="lowStockItems">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Low Stock Items</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-times-circle text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="outOfStockItems">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Out of Stock</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-truck text-3xl text-purple-600 dark:text-purple-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalSuppliers">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Suppliers</div>
      </div>
    </div>
  </div>

  <!-- Supplier Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-truck text-blue-600 dark:text-blue-400"></i>
        Supplier Details
      </h2>
      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition" id="openSupplierModalSection">
        <i class="fa fa-plus mr-2"></i>Add Supplier
      </button>
    </div>
    <!-- Supplier Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
        <input type="text" id="supplierNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter supplier name">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Contact Person</label>
        <input type="text" id="supplierContactFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter contact person">
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearSupplierFilters">Clear Filters</button>
      </div>
    </div>
    <div>
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Supplier ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Supplier Name</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Contact Person</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Phone</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Email</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">No. of Items</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="supplierTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- Item Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-box text-green-600 dark:text-green-400"></i>
        Item Details
      </h2>
      <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition" id="openItemModalSection">
        <i class="fa fa-box mr-2"></i>Add Item
      </button>
    </div>
    <!-- Item Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Supplier</label>
        <select id="itemSupplierFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Suppliers</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Category</label>
        <input type="text" id="itemCategoryFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter category">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="itemStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Statuses</option>
          <option>Available</option>
          <option>Out of Stock</option>
          <option>Discontinued</option>
        </select>
      </div>
      <div class="flex items-end">
        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition" id="clearItemFilters">Clear Filters</button>
      </div>
    </div>
    <div >
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Item ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Item Name</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Category</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Quantity</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Unit</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Reorder Level</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Price/Unit</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Total Price</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Supplier</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="itemTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- Supplier Modal -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="supplierModal">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="supplierModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i>
          Add New Supplier
        </h3>
        <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeSupplierModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Supplier Name</label>
          <input type="text" id="supplierName" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Supplier Name">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Person</label>
          <input type="text" id="contactPerson" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Contact Person">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
          <input type="text" id="supplierPhone" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Phone Number">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
          <input type="email" id="supplierEmail" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Email">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
          <textarea id="supplierAddress" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" rows="3" placeholder="Enter Address"></textarea>
        </div>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="saveSupplier">Save Supplier</button>
      </div>
    </div>
  </div>

  <!-- Item Modal -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="itemModal">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="itemModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <i class="fas fa-box text-green-600 dark:text-green-400"></i>
          Add New Item
        </h3>
        <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeItemModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Supplier</label>
          <select id="itemSupplier" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200"></select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Item Name</label>
          <input type="text" id="itemName" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Item Name">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
          <input type="text" id="itemCategory" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Category">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantity</label>
          <input type="number" id="itemQuantity" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Quantity">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Unit</label>
          <input type="text" id="itemUnit" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="e.g., Pieces, Boxes">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reorder Level</label>
          <input type="number" id="itemReorderLevel" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Reorder Level">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price per Unit</label>
          <input type="number" step="0.01" id="itemPricePerUnit" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Price per Unit">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="itemStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option>Available</option>
            <option>Out of Stock</option>
            <option>Discontinued</option>
          </select>
        </div>
      </div>
      <button class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg flex items-center justify-center" id="saveItem">
        <span id="saveItemText">Save Item</span>
        <div id="saveItemLoader" class="hidden ml-2">
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
  if (window.stockScriptLoaded) return;
  window.stockScriptLoaded = true;

  var suppliers = [];
  var items = [];

  var modalSupplier = document.getElementById("supplierModal");
  var modalItem = document.getElementById("itemModal");
  var supplierTable = document.getElementById("supplierTable");
  var itemTable = document.getElementById("itemTable");
  var itemSupplierSelect = document.getElementById("itemSupplier");
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

  // Open Modals
  document.getElementById("openSupplierModalSection").onclick = () => {
    modalSupplier.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("supplierModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("supplierModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  };

  document.getElementById("openItemModalSection").onclick = () => {
    if (suppliers.length === 0) {
      alert("Add a supplier first!");
      return;
    }
    itemSupplierSelect.innerHTML = suppliers.map(s => `<option value="${s.id}">${s.supplier_name}</option>`).join('');
    modalItem.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("itemModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("itemModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  };

  // Close Modals
  function closeSupplierModal() {
    document.getElementById("supplierModalContent").classList.remove("scale-100", "opacity-100");
    document.getElementById("supplierModalContent").classList.add("scale-95", "opacity-0");
    setTimeout(() => modalSupplier.classList.add("hidden"), 300);
  }

  function closeItemModal() {
    document.getElementById("itemModalContent").classList.remove("scale-100", "opacity-100");
    document.getElementById("itemModalContent").classList.add("scale-95", "opacity-0");
    setTimeout(() => modalItem.classList.add("hidden"), 300);
  }

  document.getElementById("closeSupplierModal").onclick = closeSupplierModal;
  document.getElementById("closeItemModal").onclick = closeItemModal;

  window.onclick = e => {
    if (e.target === modalSupplier) closeSupplierModal();
    if (e.target === modalItem) closeItemModal();
  };

  // Save Supplier
  document.getElementById("saveSupplier").onclick = () => {
    const supplierName = document.getElementById("supplierName").value.trim();
    const contactPerson = document.getElementById("contactPerson").value.trim();
    const phone = document.getElementById("supplierPhone").value.trim();
    const email = document.getElementById("supplierEmail").value.trim();
    const address = document.getElementById("supplierAddress").value.trim();
    if (!supplierName || !contactPerson || !phone || !email || !address) {
      alert("Please fill all fields!");
      return;
    }

    fetch('/admin/stock/store-supplier', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ supplier_name: supplierName, contact_person: contactPerson, phone, email, address })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadSuppliers();
      closeSupplierModal();
      document.querySelectorAll("#supplierModal input, #supplierModal textarea").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to save supplier.");
    });
  };

  // Save Item
  document.getElementById("saveItem").onclick = () => {
    const supplierId = itemSupplierSelect.value;
    const itemName = document.getElementById("itemName").value.trim();
    const category = document.getElementById("itemCategory").value.trim();
    const quantity = document.getElementById("itemQuantity").value;
    const unit = document.getElementById("itemUnit").value.trim();
    const reorderLevel = document.getElementById("itemReorderLevel").value;
    const pricePerUnit = document.getElementById("itemPricePerUnit").value;
    const status = document.getElementById("itemStatus").value;
    if (!itemName || !category || !quantity || !unit || !reorderLevel || !pricePerUnit) {
      alert("Please fill all fields!");
      return;
    }

    document.getElementById("saveItemLoader").classList.remove("hidden");
    document.getElementById("saveItemText").textContent = "Saving...";
    document.getElementById("saveItem").disabled = true;

    fetch('/admin/stock/store-item', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ supplier_id: supplierId, item_name: itemName, category, quantity, unit, reorder_level: reorderLevel, price_per_unit: pricePerUnit, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadItems().then(() => {
        loadSuppliers().then(() => {
          closeItemModal();
          document.querySelectorAll("#itemModal input, #itemModal select").forEach(i => i.value = "");
          document.getElementById("saveItemLoader").classList.add("hidden");
          document.getElementById("saveItemText").textContent = "Save Item";
          document.getElementById("saveItem").disabled = false;
        });
      });
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById("saveItemLoader").classList.add("hidden");
      document.getElementById("saveItemText").textContent = "Save Item";
      document.getElementById("saveItem").disabled = false;
      showNotification("Failed to save item.");
    });
  };

  // Load Functions
  function loadSuppliers() {
    return new Promise((resolve) => {
      showSupplierLoading();
      fetch('/admin/stock/get-suppliers')
        .then(response => response.json())
        .then(data => {
          suppliers = data;
          renderSuppliers();
          updateItemSupplierFilter();
          resolve();
        })
        .catch(error => {
          console.error('Error:', error);
          showNotification("Failed to load suppliers.");
          resolve();
        });
    });
  }

  function loadItems() {
    return new Promise((resolve) => {
      showItemLoading();
      fetch('/admin/stock/get-items')
        .then(response => response.json())
        .then(data => {
          items = data;
          renderItems();
          resolve();
        })
        .catch(error => {
          console.error('Error:', error);
          showNotification("Failed to load items.");
          resolve();
        });
    });
  }

  // Loading Functions
  function showSupplierLoading() {
    supplierTable.innerHTML = `
      <tr>
        <td colspan="8" class="text-center py-4">
          <div class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading Suppliers...
          </div>
        </td>
      </tr>
    `;
  }

  function showItemLoading() {
    itemTable.innerHTML = `
      <tr>
        <td colspan="12" class="text-center py-4">
          <div class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 text-green-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading Items...
          </div>
        </td>
      </tr>
    `;
  }

  // Render Functions
  function renderSuppliers() {
    supplierTable.innerHTML = "";
    suppliers.forEach((s, i) => {
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${s.supplier_id}</td>
        <td>${s.supplier_name}</td>
        <td>${s.contact_person}</td>
        <td>${s.phone}</td>
        <td>${s.email}</td>
        <td>${s.items_count}</td>
        <td>
          <button class="edit-supplier bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${s.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-supplier bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${s.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      supplierTable.appendChild(row);
    });

    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-supplier").forEach(button => {
      button.addEventListener("click", () => editSupplier(button.dataset.id));
    });
    document.querySelectorAll(".delete-supplier").forEach(button => {
      button.addEventListener("click", () => deleteSupplier(button.dataset.id));
    });

    updateDashboard();
  }

  function renderItems() {
    itemTable.innerHTML = "";
    items.forEach((i, index) => {
      const supplier = suppliers.find(s => s.id == i.supplier_id);
      let statusClass = "text-green-500 dark:text-green-400";
      if (i.status === "Out of Stock") statusClass = "text-red-500 dark:text-red-400";
      else if (i.status === "Discontinued") statusClass = "text-gray-500 dark:text-gray-400";
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      const totalPrice = (parseFloat(i.quantity) * parseFloat(i.price_per_unit)).toFixed(2);
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${i.item_id}</td>
        <td>${i.item_name}</td>
        <td>${i.category}</td>
        <td>${i.quantity}</td>
        <td>${i.unit}</td>
        <td>${i.reorder_level}</td>
        <td>₹${parseFloat(i.price_per_unit).toFixed(2)}</td>
        <td>₹${totalPrice}</td>
        <td>${supplier ? supplier.supplier_name : "-"}</td>
        <td class="${statusClass}">${i.status}</td>
        <td>
          <button class="edit-item bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${i.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-item bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${i.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      itemTable.appendChild(row);
    });

    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-item").forEach(button => {
      button.addEventListener("click", () => editItem(button.dataset.id));
    });
    document.querySelectorAll(".delete-item").forEach(button => {
      button.addEventListener("click", () => deleteItem(button.dataset.id));
    });

    updateDashboard();
  }

  function updateDashboard() {
    document.getElementById("totalItems").textContent = items.length;
    document.getElementById("availableItems").textContent = items.filter(i => i.status === "Available").length;
    document.getElementById("lowStockItems").textContent = items.filter(i => i.quantity <= i.reorder_level && i.status === "Available").length;
    document.getElementById("outOfStockItems").textContent = items.filter(i => i.status === "Out of Stock").length;
    document.getElementById("totalSuppliers").textContent = suppliers.length;
  }

  // Edit Supplier
  function editSupplier(id) {
    const supplier = suppliers.find(s => s.id == id);
    if (!supplier) return;

    document.getElementById("supplierName").value = supplier.supplier_name;
    document.getElementById("contactPerson").value = supplier.contact_person;
    document.getElementById("supplierPhone").value = supplier.phone;
    document.getElementById("supplierEmail").value = supplier.email;
    document.getElementById("supplierAddress").value = supplier.address;

    document.getElementById("supplierModalContent").querySelector("h3").innerHTML = '<i class="fas fa-edit text-blue-600 dark:text-blue-400"></i> Edit Supplier';
    document.getElementById("saveSupplier").textContent = "Update Supplier";
    document.getElementById("saveSupplier").onclick = () => updateSupplier(id);

    modalSupplier.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("supplierModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("supplierModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  }

  // Update Supplier
  function updateSupplier(id) {
    const supplierName = document.getElementById("supplierName").value.trim();
    const contactPerson = document.getElementById("contactPerson").value.trim();
    const phone = document.getElementById("supplierPhone").value.trim();
    const email = document.getElementById("supplierEmail").value.trim();
    const address = document.getElementById("supplierAddress").value.trim();
    if (!supplierName || !contactPerson || !phone || !email || !address) {
      alert("Please fill all fields!");
      return;
    }

    fetch(`/admin/stock/update-supplier/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ supplier_name: supplierName, contact_person: contactPerson, phone, email, address })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadSuppliers();
      closeSupplierModal();
      document.querySelectorAll("#supplierModal input, #supplierModal textarea").forEach(i => i.value = "");
      document.getElementById("supplierModalContent").querySelector("h3").innerHTML = '<i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i> Add New Supplier';
      document.getElementById("saveSupplier").textContent = "Save Supplier";
      document.getElementById("saveSupplier").onclick = () => saveSupplier();
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to update supplier.");
    });
  }

  // Save Supplier (to reset the saveSupplier button after editing)
  function saveSupplier() {
    const supplierName = document.getElementById("supplierName").value.trim();
    const contactPerson = document.getElementById("contactPerson").value.trim();
    const phone = document.getElementById("supplierPhone").value.trim();
    const email = document.getElementById("supplierEmail").value.trim();
    const address = document.getElementById("supplierAddress").value.trim();
    if (!supplierName || !contactPerson || !phone || !email || !address) {
      alert("Please fill all fields!");
      return;
    }

    fetch('/admin/stock/store-supplier', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ supplier_name: supplierName, contact_person: contactPerson, phone, email, address })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadSuppliers();
      closeSupplierModal();
      document.querySelectorAll("#supplierModal input, #supplierModal textarea").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to save supplier.");
    });
  }

  // Delete Supplier
  function deleteSupplier(id) {
    if (!confirm("Are you sure you want to delete this supplier?")) return;

    fetch(`/admin/stock/delete-supplier/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadSuppliers().then(() => loadItems());
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to delete supplier.");
    });
  }

  // Edit Item
  function editItem(id) {
    const item = items.find(i => i.id == id);
    if (!item) return;

    document.getElementById("itemSupplier").value = item.supplier_id;
    document.getElementById("itemName").value = item.item_name;
    document.getElementById("itemCategory").value = item.category;
    document.getElementById("itemQuantity").value = item.quantity;
    document.getElementById("itemUnit").value = item.unit;
    document.getElementById("itemReorderLevel").value = item.reorder_level;
    document.getElementById("itemPricePerUnit").value = item.price_per_unit;
    document.getElementById("itemStatus").value = item.status;

    document.getElementById("itemModalContent").querySelector("h3").innerHTML = '<i class="fas fa-edit text-green-600 dark:text-green-400"></i> Edit Item';
    document.getElementById("saveItem").textContent = "Update Item";
    document.getElementById("saveItem").onclick = () => updateItem(id);

    itemSupplierSelect.innerHTML = suppliers.map(s => `<option value="${s.id}" ${s.id == item.supplier_id ? 'selected' : ''}>${s.supplier_name}</option>`).join('');
    modalItem.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("itemModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("itemModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  }

  // Update Item
  function updateItem(id) {
    const supplierId = itemSupplierSelect.value;
    const itemName = document.getElementById("itemName").value.trim();
    const category = document.getElementById("itemCategory").value.trim();
    const quantity = document.getElementById("itemQuantity").value;
    const unit = document.getElementById("itemUnit").value.trim();
    const reorderLevel = document.getElementById("itemReorderLevel").value;
    const pricePerUnit = document.getElementById("itemPricePerUnit").value;
    const status = document.getElementById("itemStatus").value;
    if (!itemName || !category || !quantity || !unit || !reorderLevel || !pricePerUnit) {
      alert("Please fill all fields!");
      return;
    }

    document.getElementById("saveItemLoader").classList.remove("hidden");
    document.getElementById("saveItemText").textContent = "Updating...";
    document.getElementById("saveItem").disabled = true;

    fetch(`/admin/stock/update-item/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ supplier_id: supplierId, item_name: itemName, category, quantity, unit, reorder_level: reorderLevel, price_per_unit: pricePerUnit, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadItems().then(() => {
        loadSuppliers().then(() => {
          closeItemModal();
          document.querySelectorAll("#itemModal input, #itemModal select").forEach(i => i.value = "");
          document.getElementById("itemModalContent").querySelector("h3").innerHTML = '<i class="fas fa-box text-green-600 dark:text-green-400"></i> Add New Item';
          document.getElementById("saveItem").textContent = "Save Item";
          document.getElementById("saveItem").onclick = () => saveItem();
          document.getElementById("saveItemLoader").classList.add("hidden");
          document.getElementById("saveItemText").textContent = "Save Item";
          document.getElementById("saveItem").disabled = false;
        });
      });
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById("saveItemLoader").classList.add("hidden");
      document.getElementById("saveItemText").textContent = "Save Item";
      document.getElementById("saveItem").disabled = false;
      showNotification("Failed to update item.");
    });
  }

  // Save Item (to reset the saveItem button after editing)
  function saveItem() {
    const supplierId = itemSupplierSelect.value;
    const itemName = document.getElementById("itemName").value.trim();
    const category = document.getElementById("itemCategory").value.trim();
    const quantity = document.getElementById("itemQuantity").value;
    const unit = document.getElementById("itemUnit").value.trim();
    const reorderLevel = document.getElementById("itemReorderLevel").value;
    const pricePerUnit = document.getElementById("itemPricePerUnit").value;
    const status = document.getElementById("itemStatus").value;
    if (!itemName || !category || !quantity || !unit || !reorderLevel || !pricePerUnit) {
      alert("Please fill all fields!");
      return;
    }

    document.getElementById("saveItemLoader").classList.remove("hidden");
    document.getElementById("saveItemText").textContent = "Saving...";
    document.getElementById("saveItem").disabled = true;

    fetch('/admin/stock/store-item', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ supplier_id: supplierId, item_name: itemName, category, quantity, unit, reorder_level: reorderLevel, price_per_unit: pricePerUnit, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadItems().then(() => {
        loadSuppliers().then(() => {
          closeItemModal();
          document.querySelectorAll("#itemModal input, #itemModal select").forEach(i => i.value = "");
          document.getElementById("saveItemLoader").classList.add("hidden");
          document.getElementById("saveItemText").textContent = "Save Item";
          document.getElementById("saveItem").disabled = false;
        });
      });
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById("saveItemLoader").classList.add("hidden");
      document.getElementById("saveItemText").textContent = "Save Item";
      document.getElementById("saveItem").disabled = false;
      showNotification("Failed to save item.");
    });
  }

  // Delete Item
  function deleteItem(id) {
    if (!confirm("Are you sure you want to delete this item?")) return;

    fetch(`/admin/stock/delete-item/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadItems().then(() => loadSuppliers());
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to delete item.");
    });
  }

  // Update Item Supplier Filter
  function updateItemSupplierFilter() {
    const itemSupplierFilter = document.getElementById("itemSupplierFilter");
    itemSupplierFilter.innerHTML = '<option value="">All Suppliers</option>' + suppliers.map(s => `<option value="${s.id}">${s.supplier_name}</option>`).join('');
  }

  // Supplier Filters
  document.getElementById("supplierNameFilter").addEventListener('input', filterSuppliers);
  document.getElementById("supplierContactFilter").addEventListener('input', filterSuppliers);
  document.getElementById("clearSupplierFilters").onclick = () => {
    document.getElementById("supplierNameFilter").value = "";
    document.getElementById("supplierContactFilter").value = "";
    renderSuppliers();
  };

  function filterSuppliers() {
    const nameFilter = document.getElementById("supplierNameFilter").value.toLowerCase();
    const contactFilter = document.getElementById("supplierContactFilter").value.toLowerCase();
    const filteredSuppliers = suppliers.filter(s =>
      s.supplier_name.toLowerCase().includes(nameFilter) &&
      s.contact_person.toLowerCase().includes(contactFilter)
    );
    supplierTable.innerHTML = "";
    filteredSuppliers.forEach((s, i) => {
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${s.supplier_id}</td>
        <td>${s.supplier_name}</td>
        <td>${s.contact_person}</td>
        <td>${s.phone}</td>
        <td>${s.email}</td>
        <td>${s.items_count}</td>
        <td>
          <button class="edit-supplier bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${s.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-supplier bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${s.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      supplierTable.appendChild(row);
    });

    // Re-attach event listeners
    document.querySelectorAll(".edit-supplier").forEach(button => {
      button.addEventListener("click", () => editSupplier(button.dataset.id));
    });
    document.querySelectorAll(".delete-supplier").forEach(button => {
      button.addEventListener("click", () => deleteSupplier(button.dataset.id));
    });
  }

  // Item Filters
  document.getElementById("itemSupplierFilter").addEventListener('change', filterItems);
  document.getElementById("itemCategoryFilter").addEventListener('input', filterItems);
  document.getElementById("itemStatusFilter").addEventListener('change', filterItems);
  document.getElementById("clearItemFilters").onclick = () => {
    document.getElementById("itemSupplierFilter").value = "";
    document.getElementById("itemCategoryFilter").value = "";
    document.getElementById("itemStatusFilter").value = "";
    renderItems();
  };

  function filterItems() {
    const supplierFilter = document.getElementById("itemSupplierFilter").value;
    const categoryFilter = document.getElementById("itemCategoryFilter").value.toLowerCase();
    const statusFilter = document.getElementById("itemStatusFilter").value;
    const filteredItems = items.filter(i =>
      (!supplierFilter || i.supplier_id == supplierFilter) &&
      i.category.toLowerCase().includes(categoryFilter) &&
      (!statusFilter || i.status === statusFilter)
    );
    itemTable.innerHTML = "";
    filteredItems.forEach((i, index) => {
      const supplier = suppliers.find(s => s.id == i.supplier_id);
      let statusClass = "text-green-500 dark:text-green-400";
      if (i.status === "Out of Stock") statusClass = "text-red-500 dark:text-red-400";
      else if (i.status === "Discontinued") statusClass = "text-gray-500 dark:text-gray-400";
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      const totalPrice = (parseFloat(i.quantity) * parseFloat(i.price_per_unit)).toFixed(2);
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${i.item_id}</td>
        <td>${i.item_name}</td>
        <td>${i.category}</td>
        <td>${i.quantity}</td>
        <td>${i.unit}</td>
        <td>${i.reorder_level}</td>
        <td>₹${parseFloat(i.price_per_unit).toFixed(2)}</td>
        <td>₹${totalPrice}</td>
        <td>${supplier ? supplier.supplier_name : "-"}</td>
        <td class="${statusClass}">${i.status}</td>
        <td>
          <button class="edit-item bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${i.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-item bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${i.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      itemTable.appendChild(row);
    });

    // Re-attach event listeners
    document.querySelectorAll(".edit-item").forEach(button => {
      button.addEventListener("click", () => editItem(button.dataset.id));
    });
    document.querySelectorAll(".delete-item").forEach(button => {
      button.addEventListener("click", () => deleteItem(button.dataset.id));
    });
  }

  // Initial Load
  loadSuppliers().then(() => loadItems());
})();
</script>

@endsection