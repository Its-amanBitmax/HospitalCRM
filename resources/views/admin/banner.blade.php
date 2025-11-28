@extends('layouts.layout')

@section('content')

<div class="min-h-screen">
  <!-- Toast Notification -->
  <div id="toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
      <i class="fas fa-check-circle text-xl"></i>
      <span id="toastMessage"></span>
    </div>
  </div>

  <!-- Topbar -->
  <div class="flex justify-between items-center bg-white bg-white-800 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center gap-3">
      <i class="fas fa-image text-2xl text-blue-600 text-blue-400"></i>
      <h1 class="text-xl font-semibold text-gray-800 text-white">Banner Management</h1>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-image text-3xl text-blue-600 text-blue-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="totalBanners">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Total Banners</div>
      </div>
    </div>
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-check-circle text-3xl text-green-600 text-green-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="activeBanners">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Active Banners</div>
      </div>
    </div>
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow flex items-center gap-3">
      <i class="fas fa-times-circle text-3xl text-red-600 text-red-400"></i>
      <div>
        <div class="text-2xl font-bold text-gray-800 text-white" id="inactiveBanners">0</div>
        <div class="text-sm text-gray-600 text-gray-400">Inactive Banners</div>
      </div>
    </div>
  </div>

  <!-- Banner Table -->
  <div class="bg-white bg-white-800 rounded-lg shadow-lg p-6 border border-gray-200 border-gray-700">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold text-gray-800 text-white flex items-center gap-2">
        <i class="fas fa-list text-blue-600 text-blue-400"></i>
        Banner Details
      </h2>
      <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition" id="openBannerModal">
        <i class="fa fa-plus mr-2"></i>Add Banner
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full table-auto border-collapse">
        <thead class="bg-white-100 bg-white-700">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">S.No</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Banner ID</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Title</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Image</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Redirect URL</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Position</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Status</th>
            <th class="px-4 py-3 text-left text-gray-600 text-gray-300 font-medium">Action</th>
          </tr>
        </thead>
        <tbody id="bannerTable" class="text-gray-800 text-gray-200 divide-y divide-gray-200 divide-gray-600"></tbody>
      </table>
    </div>
  </div>

  <!-- Banner Modal -->
  <div class="fixed inset-0 bg-white bg-opacity-50 flex items-center justify-center hidden z-50" id="bannerModal">
    <div class="bg-white bg-white-800 p-4 rounded-lg shadow-xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0" id="bannerModalContent">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800 text-white" id="modalTitle">Add New Banner</h3>
        <button class="text-gray-500 hover:text-gray-700 text-gray-400 hover:text-gray-200" id="closeBannerModal">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Banner ID</label>
          <input type="text" id="bannerId" class="w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm bg-white-100 bg-white-600 text-white cursor-not-allowed" placeholder="Auto-generated" readonly>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Title</label>
          <input type="text" id="bannerTitle" class="w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white" placeholder="Enter Title">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Redirect URL</label>
          <input type="text" id="bannerRedirectUrl" class="w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white" placeholder="Enter Redirect URL">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Position</label>
          <select id="bannerPosition" class="w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white">
            <option>Top</option>
            <option>Sidebar</option>
            <option>Bottom</option>
            <option>HomePage</option>
          </select>
        </div>

        <div class="col-span-2">
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Status</label>
          <select id="bannerStatus" class="w-full px-3 py-2 border border-gray-300 border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white-700 text-white">
            <option>Active</option>
            <option>Inactive</option>
          </select>
        </div>

        <div class="col-span-2">
          <label class="block text-sm font-medium text-gray-700 text-gray-300 mb-1">Banner Image</label>
          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md border-gray-300 border-gray-600">
            <div class="space-y-1 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div class="flex text-sm text-gray-600 text-gray-400">
                <label for="bannerImageFile" class="relative cursor-pointer bg-white bg-white-700 rounded-md font-medium text-blue-600 hover:text-blue-500">
                  <span>Upload a file</span>
                  <input id="bannerImageFile" name="banner_image" type="file" accept="image/*" class="sr-only">
                </label>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
            </div>
          </div>
          <div id="imagePreview" class="mt-3 hidden">
            <p class="text-xs text-gray-500 text-center mb-2">Current Image:</p>
            <img id="previewImg" class="h-32 w-full object-contain rounded mx-auto hidden" src="" alt="Preview">
            <a id="imagePath" class="text-center text-gray-600 text-gray-400 hidden" target="_blank"></a>
          </div>
        </div>
      </div>

      <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg" id="saveBanner">Save Banner</button>
    </div>
  </div>
</div>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fadeIn 0.4s ease-out;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.bannerScriptLoaded) return;
  window.bannerScriptLoaded = true;

  let banners = [];
  let editingId = null;

  const modal = document.getElementById("bannerModal");
  const table = document.getElementById("bannerTable");
  const toast = document.getElementById("toast");
  const toastMessage = document.getElementById("toastMessage");

  if (!modal || !table || !toast || !toastMessage) return;

  // Attach event listener once
  if (table) {
    table.addEventListener('click', handleTableClick);
  }

  // Toast
  function showToast(msg) {
    toastMessage.textContent = msg;
    toast.classList.remove("hidden");
    setTimeout(() => toast.classList.add("hidden"), 3000);
  }

  // Modal Open/Close
  const openBannerModalBtn = document.getElementById("openBannerModal");
  const closeBannerModalBtn = document.getElementById("closeBannerModal");
  const saveBannerBtn = document.getElementById("saveBanner");

  if (openBannerModalBtn) openBannerModalBtn.onclick = () => openModal();
  if (closeBannerModalBtn) closeBannerModalBtn.onclick = closeModal;
  window.onclick = e => { if (e.target === modal) closeModal(); };

  function openModal() {
    modal.classList.remove("hidden");
    setTimeout(() => {
      const content = document.getElementById("bannerModalContent");
      content.classList.remove("scale-95", "opacity-0");
      content.classList.add("scale-100", "opacity-100");
    }, 10);
    // Set auto-generated ID for new banners
    if (!editingId) {
      document.getElementById("bannerId").value = generateBannerId();
    }
  }

  function closeModal() {
    document.getElementById("bannerModalContent").classList.remove("scale-100", "opacity-100");
    document.getElementById("bannerModalContent").classList.add("scale-95", "opacity-0");
    setTimeout(() => {
      modal.classList.add("hidden");
      resetModal();
    }, 300);
  }

  function resetModal() {
    editingId = null;
    document.getElementById("modalTitle").textContent = "Add New Banner";
    document.getElementById("saveBanner").textContent = "Save Banner";
    document.querySelectorAll("#bannerModal input, #bannerModal select").forEach(i => i.value = "");
    document.getElementById("imagePreview").classList.add("hidden");
    document.getElementById("bannerImageFile").value = "";
  }

  // Image Preview (New File)
  const imageFileInput = document.getElementById("bannerImageFile");
  if (imageFileInput) {
    imageFileInput.addEventListener("change", function(e) {
      const file = e.target.files[0];
      const preview = document.getElementById("imagePreview");
      const img = document.getElementById("previewImg");

      if (file) {
        if (file.size > 2 * 1024 * 1024) {
          showToast("Image must be less than 2MB");
          this.value = "";
          return;
        }
        const reader = new FileReader();
        reader.onload = e => {
          img.src = e.target.result;
          preview.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
      }
    });
  }

  // Load Banners
  function loadBanners() {
    fetch('/admin/banner/get-banners')
      .then(res => res.json())
      .then(data => {
        banners = data;
        renderBanners();
      })
      .catch(() => showToast("Failed to load banners"));
  }

  // Delegated Click Handler
  function handleTableClick(e) {
    const target = e.target;

    if (target.matches('.edit-btn') || target.closest('.edit-btn')) {
      const btn = target.closest('.edit-btn');
      const id = btn ? btn.dataset.id : null;
      if (id) editBanner(id);
    }

    if (target.matches('.delete-btn') || target.closest('.delete-btn')) {
      const btn = target.closest('.delete-btn');
      const id = btn ? btn.dataset.id : null;
      if (id) deleteBanner(id);
    }
  }

  // Render Table
  function renderBanners() {
    if (!table) return;
    table.innerHTML = "";
    banners.forEach((b, i) => {
      const tr = document.createElement("tr");
      tr.className = "border-b border-gray-700";

      tr.innerHTML = `
        <td class="px-4 py-3">${i + 1}</td>
        <td class="px-4 py-3">${b.banner_id}</td>
        <td class="px-4 py-3">${b.title}</td>
        <td class="px-4 py-3">
          <img src="${b.image_url}" class="h-12 w-20 object-cover rounded" alt="banner">
        </td>
        <td class="px-4 py-3 truncate max-w-xs">
          <a href="${b.redirect_url}" target="_blank" class="text-blue-600 hover:underline">${b.redirect_url}</a>
        </td>
        <td class="px-4 py-3">${b.position}</td>
        <td class="px-4 py-3 ${b.status === 'Active' ? 'text-green-600' : 'text-red-600'}">${b.status}</td>
        <td class="px-4 py-3 space-x-1">
          <button class="edit-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm" data-id="${b.banner_id}">Edit</button>
          <button class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm" data-id="${b.banner_id}">Delete</button>
        </td>
      `;
      table.appendChild(tr);
    });
  }

  // Edit Banner
  function editBanner(id) {
    const b = banners.find(x => x.banner_id == id);
    if (!b) return;

    editingId = id;
    document.getElementById("modalTitle").textContent = "Edit Banner";
    document.getElementById("saveBanner").textContent = "Update Banner";
    document.getElementById("bannerId").value = b.banner_id;
    document.getElementById("bannerTitle").value = b.title;
    document.getElementById("bannerRedirectUrl").value = b.redirect_url;
    document.getElementById("bannerPosition").value = b.position;
    document.getElementById("bannerStatus").value = b.status;

    const img = document.getElementById("previewImg");
    const path = document.getElementById("imagePath");
    img.classList.remove("hidden");
    path.classList.add("hidden");
    img.src = b.image_url;
    img.onclick = () => window.open(b.image_url, '_blank');
    img.style.cursor = 'pointer';
    document.getElementById("imagePreview").classList.remove("hidden");

    openModal();
  }

  // Delete Banner
  function deleteBanner(id) {
    if (!confirm("Are you sure you want to delete this banner?")) return;

    fetch(`/admin/banner/delete/${id}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
      showToast(data.message || "Banner deleted!");
      loadBanners();
    })
    .catch(() => showToast("Delete failed"));
  }

  // Generate Banner ID
  function generateBannerId() {
    const existingIds = banners.map(b => b.banner_id);
    let nextId = 1;
    while (existingIds.includes(`BR${nextId.toString().padStart(3, '0')}`)) {
      nextId++;
    }
    return `BR${nextId.toString().padStart(3, '0')}`;
  }

  // Save / Update
  if (saveBannerBtn) saveBannerBtn.onclick = () => {
    const bannerId = editingId ? document.getElementById("bannerId").value.trim() : generateBannerId();
    const title = document.getElementById("bannerTitle").value.trim();
    const redirectUrl = document.getElementById("bannerRedirectUrl").value.trim();
    const position = document.getElementById("bannerPosition").value;
    const status = document.getElementById("bannerStatus").value;
    const file = document.getElementById("bannerImageFile").files[0];

    if (!title || !redirectUrl || (!file && !editingId)) {
      showToast("Please fill all required fields");
      return;
    }

    const formData = new FormData();
    formData.append('banner_id', bannerId);
    formData.append('title', title);
    formData.append('redirect_url', redirectUrl);
    formData.append('position', position);
    formData.append('status', status);
    if (file) formData.append('image', file);
    if (editingId) formData.append('_method', 'POST');

    const url = editingId ? `/admin/banner/update/${editingId}` : '/admin/banner/store';

    fetch(url, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: formData
    })
    .then(res => {
      if (!res.ok) throw new Error("Server error");
      return res.json();
    })
    .then(data => {
      showToast(data.message || (editingId ? "Updated!" : "Added!"));
      closeModal();
      loadBanners();
    })
    .catch(err => {
      console.error(err);
      showToast("Operation failed");
    });
  };

  // Initial Load
  loadBanners();
});
</script>

@endsection