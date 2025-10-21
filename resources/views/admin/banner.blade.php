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
      <i class="fas fa-image text-2xl text-blue-600 dark:text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Banner Management</h1>
    </div>
  </div>

  <!-- Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-image text-3xl text-blue-600 dark:text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="totalBanners">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Total Banners</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-check-circle text-3xl text-green-600 dark:text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="activeBanners">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Active Banners</div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-times-circle text-3xl text-red-600 dark:text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-white" id="inactiveBanners">0</div>
        <div class="text-sm text-gray-600 dark:text-gray-400">Inactive Banners</div>
      </div>
    </div>
  </div>

  <!-- Banner Table -->
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fas fa-list text-blue-600 dark:text-blue-400"></i>
        Banner Details
      </h2>
      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition" id="openBannerModal">
        <i class="fa fa-plus mr-2"></i>Add Banner
      </button>
    </div>
    <!-- Banner Filters -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Title</label>
        <input type="text" id="bannerTitleFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter title">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Position</label>
        <select id="bannerPositionFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Positions</option>
          <option>Top</option>
          <option>Sidebar</option>
          <option>Bottom</option>
          <option>HomePage</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
        <select id="bannerStatusFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
          <option value="">All Statuses</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
    </div>
    <div>
      <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Banner ID</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Title</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Image URL</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Redirect URL</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Position</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Action</th>
          </tr>
        </thead>
        <tbody id="bannerTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- Banner Modal -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50" id="bannerModal">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-lg border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 opacity-0" id="bannerModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          <i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i>
          Add New Banner
        </h3>
        <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" id="closeBannerModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Banner ID</label>
          <input type="number" id="bannerId" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Banner ID">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
          <input type="text" id="bannerTitle" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Title">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image URL</label>
          <input type="text" id="bannerImageUrl" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Image URL">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Redirect URL</label>
          <input type="text" id="bannerRedirectUrl" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter Redirect URL">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position</label>
          <select id="bannerPosition" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option>Top</option>
            <option>Sidebar</option>
            <option>Bottom</option>
            <option>HomePage</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select id="bannerStatus" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200">
            <option>Active</option>
            <option>Inactive</option>
          </select>
        </div>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="saveBanner">Save Banner</button>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  if (window.bannerScriptLoaded) return;
  window.bannerScriptLoaded = true;

  var banners = [];
  var modalBanner = document.getElementById("bannerModal");
  var bannerTable = document.getElementById("bannerTable");
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

  // Open Modal
  document.getElementById("openBannerModal").onclick = () => {
    modalBanner.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("bannerModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("bannerModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  };

  // Close Modal
  function closeBannerModal() {
    document.getElementById("bannerModalContent").classList.remove("scale-100", "opacity-100");
    document.getElementById("bannerModalContent").classList.add("scale-95", "opacity-0");
    setTimeout(() => modalBanner.classList.add("hidden"), 300);
  }

  document.getElementById("closeBannerModal").onclick = closeBannerModal;

  window.onclick = e => {
    if (e.target === modalBanner) closeBannerModal();
  };

  // Save Banner
  document.getElementById("saveBanner").onclick = () => {
    const bannerId = document.getElementById("bannerId").value.trim();
    const title = document.getElementById("bannerTitle").value.trim();
    const imageUrl = document.getElementById("bannerImageUrl").value.trim();
    const redirectUrl = document.getElementById("bannerRedirectUrl").value.trim();
    const position = document.getElementById("bannerPosition").value;
    const status = document.getElementById("bannerStatus").value;
    if (!bannerId || !title || !imageUrl || !redirectUrl) {
      alert("Please fill all fields!");
      return;
    }

    fetch('/admin/banner/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ banner_id: bannerId, title, image_url: imageUrl, redirect_url: redirectUrl, position, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadBanners();
      closeBannerModal();
      document.querySelectorAll("#bannerModal input, #bannerModal select").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to save banner.");
    });
  };

  // Load Banners
  function loadBanners() {
    showBannerLoading();
    fetch('/admin/banner/get-banners')
      .then(response => response.json())
      .then(data => {
        banners = data;
        renderBanners();
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification("Failed to load banners.");
      });
  }

  // Loading Function
  function showBannerLoading() {
    bannerTable.innerHTML = `
      <tr>
        <td colspan="8" class="text-center py-4">
          <div class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading Banners...
          </div>
        </td>
      </tr>
    `;
  }

  // Render Banners
  function renderBanners() {
    bannerTable.innerHTML = "";
    banners.forEach((b, i) => {
      let statusClass = "text-green-500 dark:text-green-400";
      if (b.status === "Inactive") statusClass = "text-red-500 dark:text-red-400";
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${b.banner_id}</td>
        <td>${b.title}</td>
        <td><a href="${b.image_url}" target="_blank" class="text-blue-500 hover:underline">${b.image_url}</a></td>
        <td><a href="${b.redirect_url}" target="_blank" class="text-blue-500 hover:underline">${b.redirect_url}</a></td>
        <td>${b.position}</td>
        <td class="${statusClass}">${b.status}</td>
        <td>
          <button class="edit-banner bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${b.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-banner bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${b.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      bannerTable.appendChild(row);
    });

    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-banner").forEach(button => {
      button.addEventListener("click", () => editBanner(button.dataset.id));
    });
    document.querySelectorAll(".delete-banner").forEach(button => {
      button.addEventListener("click", () => deleteBanner(button.dataset.id));
    });

    updateDashboard();
  }

  function updateDashboard() {
    document.getElementById("totalBanners").textContent = banners.length;
    document.getElementById("activeBanners").textContent = banners.filter(b => b.status === "Active").length;
    document.getElementById("inactiveBanners").textContent = banners.filter(b => b.status === "Inactive").length;
  }

  // Edit Banner
  function editBanner(id) {
    const banner = banners.find(b => b.id == id);
    if (!banner) return;

    document.getElementById("bannerId").value = banner.banner_id;
    document.getElementById("bannerTitle").value = banner.title;
    document.getElementById("bannerImageUrl").value = banner.image_url;
    document.getElementById("bannerRedirectUrl").value = banner.redirect_url;
    document.getElementById("bannerPosition").value = banner.position;
    document.getElementById("bannerStatus").value = banner.status;

    document.getElementById("bannerModalContent").querySelector("h3").innerHTML = '<i class="fas fa-edit text-blue-600 dark:text-blue-400"></i> Edit Banner';
    document.getElementById("saveBanner").textContent = "Update Banner";
    document.getElementById("saveBanner").onclick = () => updateBanner(id);

    modalBanner.classList.remove("hidden");
    setTimeout(() => {
      document.getElementById("bannerModalContent").classList.remove("scale-95", "opacity-0");
      document.getElementById("bannerModalContent").classList.add("scale-100", "opacity-100");
    }, 10);
  }

  // Update Banner
  function updateBanner(id) {
    const bannerId = document.getElementById("bannerId").value.trim();
    const title = document.getElementById("bannerTitle").value.trim();
    const imageUrl = document.getElementById("bannerImageUrl").value.trim();
    const redirectUrl = document.getElementById("bannerRedirectUrl").value.trim();
    const position = document.getElementById("bannerPosition").value;
    const status = document.getElementById("bannerStatus").value;
    if (!bannerId || !title || !imageUrl || !redirectUrl) {
      alert("Please fill all fields!");
      return;
    }

    fetch(`/admin/banner/update/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ banner_id: bannerId, title, image_url: imageUrl, redirect_url: redirectUrl, position, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadBanners();
      closeBannerModal();
      document.querySelectorAll("#bannerModal input, #bannerModal select").forEach(i => i.value = "");
      document.getElementById("bannerModalContent").querySelector("h3").innerHTML = '<i class="fas fa-plus-circle text-blue-600 dark:text-blue-400"></i> Add New Banner';
      document.getElementById("saveBanner").textContent = "Save Banner";
      document.getElementById("saveBanner").onclick = () => saveBanner();
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to update banner.");
    });
  }

  // Save Banner (to reset the saveBanner button after editing)
  function saveBanner() {
    const bannerId = document.getElementById("bannerId").value.trim();
    const title = document.getElementById("bannerTitle").value.trim();
    const imageUrl = document.getElementById("bannerImageUrl").value.trim();
    const redirectUrl = document.getElementById("bannerRedirectUrl").value.trim();
    const position = document.getElementById("bannerPosition").value;
    const status = document.getElementById("bannerStatus").value;
    if (!bannerId || !title || !imageUrl || !redirectUrl) {
      alert("Please fill all fields!");
      return;
    }

    fetch('/admin/banner/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ banner_id: bannerId, title, image_url: imageUrl, redirect_url: redirectUrl, position, status })
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadBanners();
      closeBannerModal();
      document.querySelectorAll("#bannerModal input, #bannerModal select").forEach(i => i.value = "");
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to save banner.");
    });
  }

  // Delete Banner
  function deleteBanner(id) {
    if (!confirm("Are you sure you want to delete this banner?")) return;

    fetch(`/admin/banner/delete/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
    .then(response => response.json())
    .then(data => {
      showNotification(data.message);
      loadBanners();
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification("Failed to delete banner.");
    });
  }

  // Banner Filters
  document.getElementById("bannerTitleFilter").addEventListener('input', filterBanners);
  document.getElementById("bannerPositionFilter").addEventListener('change', filterBanners);
  document.getElementById("bannerStatusFilter").addEventListener('change', filterBanners);

  function filterBanners() {
    const titleFilter = document.getElementById("bannerTitleFilter").value.toLowerCase();
    const positionFilter = document.getElementById("bannerPositionFilter").value;
    const statusFilter = document.getElementById("bannerStatusFilter").value;
    const filteredBanners = banners.filter(b =>
      b.title.toLowerCase().includes(titleFilter) &&
      (!positionFilter || b.position === positionFilter) &&
      (!statusFilter || b.status === statusFilter)
    );
    bannerTable.innerHTML = "";
    filteredBanners.forEach((b, i) => {
      let statusClass = "text-green-500 dark:text-green-400";
      if (b.status === "Inactive") statusClass = "text-red-500 dark:text-red-400";
      const row = document.createElement("tr");
      row.classList.add("dark:bg-gray-800");
      row.innerHTML = `
        <td>${i + 1}</td>
        <td>${b.banner_id}</td>
        <td>${b.title}</td>
        <td><a href="${b.image_url}" target="_blank" class="text-blue-500 hover:underline">${b.image_url}</a></td>
        <td><a href="${b.redirect_url}" target="_blank" class="text-blue-500 hover:underline">${b.redirect_url}</a></td>
        <td>${b.position}</td>
        <td class="${statusClass}">${b.status}</td>
        <td>
          <button class="edit-banner bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${b.id}"><i class="fas fa-edit"></i></button>
          <button class="delete-banner bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2" data-id="${b.id}"><i class="fas fa-trash"></i></button>
        </td>
      `;
      bannerTable.appendChild(row);
    });

    // Re-attach event listeners
    document.querySelectorAll(".edit-banner").forEach(button => {
      button.addEventListener("click", () => editBanner(button.dataset.id));
    });
    document.querySelectorAll(".delete-banner").forEach(button => {
      button.addEventListener("click", () => deleteBanner(button.dataset.id));
    });
  }

  // Initial Load
  loadBanners();
})();
</script>

@endsection
