@php
use App\Models\Admin;

$admin = Admin::first();
$logoUrl = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/default-logo.png');
$companyName = $admin && $admin->hospital_name ? $admin->hospital_name : 'Hospital CRM';

$accountant = auth('accountant')->user();
$accountantName = $accountant->name ?? 'Accountant';
$accountantImage = $accountant->image
    ? asset('storage/' . $accountant->image)
    : 'https://ui-avatars.com/api/?name=' . urlencode($accountantName);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accountant Dashboard</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --primary: #b9f5f8;
            --secondary: black;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex" x-data="{ sidebarOpen: true }">

    <!-- ================= SIDEBAR ================= -->
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-16'"
        class="bg-white shadow-lg h-screen fixed left-0 top-0 transition-all duration-300 flex flex-col overflow-y-auto">

        <!-- Logo -->
        <div class="p-5 flex items-center justify-center border-b">
            <img src="{{ $logoUrl }}"
                 :class="sidebarOpen ? 'h-10 rounded' : 'h-10 w-10 rounded'"
                 class="transition-all duration-300">
        </div>

        <!-- Menu -->
        <ul class="flex-1 flex flex-col p-2 space-y-1 mt-3">

            <li>
                <a href="{{ route('account.dashboard') }}"
                   class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-chart-line w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.transctions.index')}}"
                   class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-money-bill-wave w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Transactions</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.invoice.index')}}"
                   class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-file-invoice w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Invoices</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.expensis.index')}}"
                   class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-receipt w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Expenses</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.account.report')}}"
                   class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-file-alt w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Reports</span>
                </a>
            </li>

            <li>
                <a href="{{route('account.profile')}}"
                   class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-user-circle w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Profile</span>
                </a>
            </li>

        </ul>
    </aside>

    <!-- ================= MAIN ================= -->
    <div class="flex-1 flex flex-col"
         :style="sidebarOpen ? 'margin-left:16rem' : 'margin-left:4rem'">

        <!-- Header -->
        <header
            class="p-6 bg-[var(--secondary)] text-white flex justify-between items-center fixed top-0 right-0 z-20 transition-all duration-300"
            :style="sidebarOpen ? 'left:16rem' : 'left:4rem'">

            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h2 class="font-semibold ml-2">
                    Welcome {{ ucfirst($accountantName) }}
                </h2>
            </div>

            <!-- Profile -->
            <div class="relative" x-data="{ open:false }">
                <div class="flex items-center space-x-2 cursor-pointer" @click="open = !open">
                    <span>{{ $accountantName }}</span>
                    <img src="{{ $accountantImage }}"
                         class="w-8 h-8 rounded-full object-cover">
                </div>

                <div x-show="open"
                     @click.outside="open=false"
                     class="absolute right-0 mt-1 w-48 bg-white text-black shadow-lg rounded-md">

                    <a href="{{route('account.edit.profile')}}"
                       class="flex items-center px-4 py-3 text-sm hover:bg-gray-100">
                        <i class="fas fa-cog mr-3 text-gray-500"></i>
                        Settings
                    </a>

                    <form action="{{ route('employee.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6 mt-24 h-[calc(100vh-96px)] overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
