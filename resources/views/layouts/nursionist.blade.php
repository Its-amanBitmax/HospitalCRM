@php
use App\Models\Admin;

$admin = Admin::first();
$logoUrl = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/default-logo.png');
$companyName = $admin && $admin->hospital_name ? $admin->hospital_name : 'Hospital CRM';
$nurse = auth('nurse')->user();
$nurseName = $nurse->name ?? 'Nurse';
$nurseImage = $nurse->image ? asset('storage/' . $nurse->image) : 'https://ui-avatars.com/api/?name=' . urlencode($nurseName);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nurse Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <style>
        :root {
            --primary: #b9f5f8;
            --secondary: black;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen" x-data="{ sidebarOpen: true }">

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white shadow-lg min-h-screen transition-all duration-300 flex flex-col">

        {{-- Logo / Hospital Name --}}
        <div class="p-5 flex items-center justify-center border-b relative">
            <img src="{{ $logoUrl }}" 
                 :class="sidebarOpen ? 'h-10 rounded' : 'h-10 w-10 rounded'" 
                 class="transition-all duration-300"/>
            <!-- <h2 class="font-semibold text-lg absolute left-16" x-show="sidebarOpen" x-transition>
                {{ $companyName }}
            </h2> -->
        </div>

        {{-- Sidebar Menu --}}
        <ul class="flex-1 flex flex-col p-2 space-y-1">
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-user-injured w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Patient List</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-procedures w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Assign Beds</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-calendar-check w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Appointments</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-vials w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Tests / Samples</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-pills w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Medicine Delivery</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-file-medical w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Reports</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 rounded hover:bg-gray-100">
                    <i class="fas fa-ambulance w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen" x-transition>Emergency</span>
                </a>
            </li>
        </ul>

    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">

        {{-- Header --}}
        <header class="p-6 bg-[var(--secondary)] text-white flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <!-- Sidebar Toggle Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h2 class="font-semibold ml-2">Welcome {{ ucfirst($nurseName) }}</h2>
            </div>

            {{-- Profile Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <div class="flex items-center space-x-2 cursor-pointer" @click="open = !open">
                    <span>{{ $nurseName }}</span>
                    <img src="{{ $nurseImage }}" class="w-8 h-8 rounded-full object-cover"/>
                </div>

                <div x-show="open" @click.outside="open = false"
                     class="absolute right-0 mt-1 w-40 bg-white text-black rounded shadow-lg">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                    <form action="{{ route('employee.logout') }}" method="POST">
                        @csrf
                        <button class="block w-full text-left px-4 py-2 hover:bg-gray-100 border-t">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Body / Page Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
