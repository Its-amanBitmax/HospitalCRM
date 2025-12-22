@php
use App\Models\Admin;

$admin = Admin::first();
$logoUrl = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/default-logo.png');
$companyName = $admin && $admin->hospital_name ? $admin->hospital_name : 'Hospital CRM';
$pharmacist = auth('pharmacist')->user();
$pharmacistName = $pharmacist->name ?? 'Pharmacist';
$pharmacistImage = $pharmacist->image ? asset('storage/' . $pharmacist->image) : 'https://ui-avatars.com/api/?name=' . urlencode($pharmacistName);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pharmacist Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
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

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="bg-white shadow-lg h-screen fixed left-0 top-0 transition-all duration-300 flex flex-col overflow-y-auto">

            {{-- Logo --}}
            <div class="p-5 flex items-center justify-center border-b relative">
                <img src="{{ $logoUrl }}"
                    :class="sidebarOpen ? 'h-10 rounded' : 'h-10 w-10 rounded'"
                    class="transition-all duration-300" />
            </div>

            {{-- Sidebar Menu --}}
            <ul class="flex-1 flex flex-col p-2 space-y-1 mt-3">

                <!-- Dashboard -->
                <li>
                    <a href="{{route('pharmacist.dashboard')}}" class="flex items-center p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-chart-line w-6 text-center"></i>
                        <span class="ml-2" x-show="sidebarOpen" x-transition>Dashboard</span>
                    </a>
                </li>

                <!-- Stores -->
                <li>
                    <a href="{{ route('admin.store.index') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-store w-6 text-center"></i>
                        <span class="ml-2" x-show="sidebarOpen" x-transition>Stores</span>
                    </a>
                </li>

                <!-- Medicines -->
                <li>
                    <a href="{{ route('admin.medicine.index') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-capsules w-6 text-center"></i>
                        <span class="ml-2" x-show="sidebarOpen" x-transition>Medicines</span>
                    </a>
                </li>

                <!-- Inventory -->
                <li>
                    <a href="{{ route('admin.inventory.index') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-warehouse w-6 text-center"></i>
                        <span class="ml-2" x-show="sidebarOpen" x-transition>Inventory</span>
                    </a>
                </li>

                <!-- Sales & Billing -->
                <li>
                    <a href="{{ route('admin.sales.index') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-file-invoice-dollar w-6 text-center"></i>
                        <span class="ml-2" x-show="sidebarOpen" x-transition>Sales & Billing</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('pharmacist.profile')}}" class="flex items-center p-2 rounded hover:bg-gray-100">
                        <i class="fas fa-user-circle "></i>
                        <span class="ml-2" x-show="sidebarOpen" x-transition>Profile</span>
                    </a>
                </li>

            </ul>


        </aside>

        {{-- Main Body --}}
        <div class="flex-1 flex flex-col"
            :style="sidebarOpen ? 'margin-left:16rem' : 'margin-left:4rem'">

            {{-- Header --}}
            <header
                class="p-6 bg-[var(--secondary)] text-white flex justify-between items-center fixed top-0 right-0 z-20 transition-all duration-300"
                :style="sidebarOpen ? 'left:16rem' : 'left:4rem'">

                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h2 class="font-semibold ml-2">Welcome {{ ucfirst($pharmacistName) }}</h2>
                </div>

                {{-- Profile --}}
                <div class="relative" x-data="{ open: false }">
                    <div class="flex items-center space-x-2 cursor-pointer" @click="open = !open">
                        <span>{{ $pharmacistName }}</span>
                        <img src="{{ $pharmacistImage }}" class="w-8 h-8 rounded-full object-cover" />
                    </div>

                    <div x-show="open"
                        @click.outside="open = false"
                        class="absolute right-0 mt-1 w-48 bg-white text-black  shadow-lg rounded-md">
                     

                        <a href="{{route('pharmacist.edit.profile')}}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                            Settings
                        </a>

                        <form action="{{ route('employee.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="p-6 mt-24 h-[calc(100vh-96px)] overflow-y-auto">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>