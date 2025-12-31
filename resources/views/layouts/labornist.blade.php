@php
use App\Models\Admin;

$admin = Admin::first();
$logoUrl = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/default-logo.png');
$companyName = $admin && $admin->hospital_name ? $admin->hospital_name : 'Hospital CRM';

$laborist = auth('laborist')->user();
$laboristName = $laborist ? ($laborist->name ?? 'Laborist') : 'Laborist';
$laboristImage = $laborist && $laborist->image
    ? asset('storage/' . $laborist->image)
    : 'https://ui-avatars.com/api/?name=' . urlencode($laboristName);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laborist Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root {
            --primary: #b9f5f8;
            --secondary: black;
        }
    </style>
</head>

<body  style="background-color: #f3fcfc;">

<div class="flex" x-data="{ sidebarOpen: true }">

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-16'"
        class="bg-[#f3fcfc;] shadow-lg h-screen fixed left-0 top-0 transition-all duration-300 flex flex-col overflow-y-auto">

        {{-- Logo --}}
        <div class="p-5 flex items-center justify-center border-b">
            <img src="{{ $logoUrl }}"
                 :class="sidebarOpen ? 'h-10 rounded' : 'h-10 w-10 rounded'"
                 class="transition-all duration-300">
        </div>

        {{-- Menu --}}
        <ul class="flex-1 flex flex-col p-2 space-y-1 mt-3">

            <li>
                <a href="{{route('laborist.dashboard')}}" class="flex items-center p-2 rounded hover:bg-[#f3fcfc;]">
                    <i class="fas fa-chart-line w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.test.checkup')}}" class="flex items-center p-2 rounded hover:bg-[#f3fcfc;]">
                    <i class="fas fa-vials w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen">Test Checkups</span>
                </a>
            </li>

            <li>
                <a href="{{route('admin.testbookuser.list')}}" class="flex items-center p-2 rounded hover:bg-[#f3fcfc;]">
                    <i class="fas fa-file-medical-alt w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen">Test Book Users</span>
                </a>
            </li>

           

            <li>
                <a href="{{route('laborist.view.profile')}}" class="flex items-center p-2 rounded hover:bg-[#f3fcfc;]">
                    <i class="fas fa-user-circle w-6 text-center"></i>
                    <span class="ml-2" x-show="sidebarOpen">Profile</span>
                </a>
            </li>

        </ul>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col"
         :style="sidebarOpen ? 'margin-left:16rem' : 'margin-left:4rem'">

        {{-- Header --}}
        <header
            class="p-6 bg-[#daf6f6;]  flex justify-between items-center fixed top-0 right-0 z-20 transition-all duration-300"
            :style="sidebarOpen ? 'left:16rem' : 'left:4rem' ">

            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h2 class="font-semibold">Welcome {{ ucfirst($laboristName) }}</h2>
            </div>

            {{-- Profile --}}
            <div class="relative" x-data="{ open: false }">
                <div class="flex items-center space-x-2 cursor-pointer" @click="open = !open">
                    <span>{{ $laboristName }}</span>
                    <img src="{{ $laboristImage }}" class="w-8 h-8 rounded-full object-cover">
                </div>

                <div x-show="open"
                     @click.outside="open = false"
                     class="absolute right-0 mt-1 w-48 bg-white text-black shadow-lg ">

                    <a href="{{route('laborist.profile.edit')}}"
                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-[#f3fcfc;]">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>

                    <form action="{{ route('employee.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-[#f3fcfc;]">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>

                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="p-6 mt-24 h-[calc(100vh-96px)] overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
