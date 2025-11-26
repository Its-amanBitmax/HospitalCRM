@extends('layouts.layout')
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" />

@section('content')

<style>
    @media print {

        .sidebar,
        header,
        footer,
        .topbar,
        .notification,
        .grid.grid-cols-1.md\\:grid-cols-4,
        .flex.justify-between.items-center.bg-white.dark\\:bg-gray-800.p-4.rounded-lg.shadow.mb-6 {
            display: none !important;
        }

        body {
            margin: 0;
            padding: 20px;
        }

        .bg-white.dark\\:bg-gray-800.rounded-lg.shadow-lg.p-6 {
            box-shadow: none;
            border: none;
        }
    }

    #main-content {
        overflow-x: auto !important;
    }

    ::-webkit-scrollbar {
        display: none;
    }
</style>

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
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Opd Patients</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.patient-registration') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-user-plus mr-2"></i>Registration Form
            </a>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add Patients
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                Patient Details
            </h2>
        </div>

        <!-- Filters -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Name</label>
                <input type="text" id="userNameFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter user name">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Email</label>
                <input type="text" id="userEmailFilter" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" placeholder="Enter email">
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

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse min-w-max">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">S.No</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">User ID</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600 min-w-[350px]">Full Name</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Username</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Image</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Email</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Phone</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Type</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600">Status</th>
                        <th class="px-4 py-3 text-left text-gray-600 dark:text-gray-300 font-medium border-b border-gray-200 dark:border-gray-600 min-w-[350px]">Action</th>
                    </tr>
                </thead>
                <tbody id="userTable" class="text-gray-800 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach($users as $i => $u)
                    <tr class="dark:bg-gray-800">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ $u->user_id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $u->full_name }}</td>
                        <td class="px-4 py-3">{{ $u->username }}</td>
                        <td class="px-4 py-3">
                            @if($u->image)
                            <img src="{{ asset($u->image) }}" alt="User Image" class="w-10 h-10 rounded-full object-cover">
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $u->email ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $u->mobile_no ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $u->type }}</td>
                        <td class="px-4 py-3">{{ $u->status }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="{/admin/users/{{ $u->id }}}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm inline-block"><i class="fas fa-eye"></i></a>
                            <a href="/admin/users/{{ $u->id }}/edit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm ml-2 inline-block"><i class="fas fa-edit"></i></a>
                               <a href="{{ route('admin.receptions.visits', $u->id) }}" 
       class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm inline-flex items-center gap-2" 
       aria-label="View visits">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="4" width="16" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
       
    </a>
                            <form action="{{ route('admin.delete-registered-user', $u->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const nameFilter = document.getElementById('userNameFilter');
    const emailFilter = document.getElementById('userEmailFilter');
    const statusFilter = document.getElementById('userStatusFilter');
    const clearBtn = document.getElementById('clearUserFilters');
    const table = document.getElementById('userTable');

    function filterTable() {
        const nameValue = nameFilter.value.toLowerCase();
        const emailValue = emailFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();

        Array.from(table.rows).forEach(row => {
            const cells = row.cells;
            const name = cells[2].innerText.toLowerCase();
            const email = cells[5].innerText.toLowerCase();
            const status = cells[8].innerText.toLowerCase();

            if (
                name.includes(nameValue) &&
                email.includes(emailValue) &&
                status.includes(statusValue)
            ) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    nameFilter.addEventListener('input', filterTable);
    emailFilter.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);

    clearBtn.addEventListener('click', () => {
        nameFilter.value = '';
        emailFilter.value = '';
        statusFilter.value = '';
        filterTable();
    });
</script>

@endsection