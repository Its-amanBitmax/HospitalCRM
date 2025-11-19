@extends('layouts.doctor-dashboard')

@section('title', 'Doctor Dashboard')
@section('header-title', 'Doctor Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Total Patients -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Patients</p>
                <h2 class="text-2xl font-bold mt-1">152</h2>
            </div>
            <div class="w-12 h-12 bg-blue-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-users text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Today's Appointments -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Today's Appointments</p>
            <h2 class="text-2xl font-bold mt-1">18</h2>
            </div>
            <div class="w-12 h-12 bg-green-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-calendar-check text-green-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Reports -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pending Reports</p>
                <h2 class="text-2xl font-bold mt-1">07</h2>
            </div>
            <div class="w-12 h-12 bg-yellow-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-file-medical text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Cancelled Appointments -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Cancelled Appointments</p>
                <h2 class="text-2xl font-bold mt-1">02</h2>
            </div>
            <div class="w-12 h-12 bg-red-500/20 flex items-center justify-center rounded-full">
                <i class="fa-solid fa-xmark text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Appointments Table -->
<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 mt-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold">Recent Appointments</h3>
        <a href="#" class="text-blue-500 text-sm hover:underline">View All</a>
    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-sm">
                    <th class="p-3">Patient</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Time</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <tr class="border-b dark:border-gray-700">
                    <td class="p-3">Rahul Sharma</td>
                    <td class="p-3">19 Nov 2025</td>
                    <td class="p-3">11:00 AM</td>
                    <td class="p-3">
                        <span class="px-3 py-1 text-sm rounded bg-green-500/20 text-green-600">Completed</span>
                    </td>
                    <td class="p-3 text-center">
                        <button class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                            View
                        </button>
                    </td>
                </tr>

                <tr class="border-b dark:border-gray-700">
                    <td class="p-3">Aman Kumar</td>
                    <td class="p-3">19 Nov 2025</td>
                    <td class="p-3">12:45 PM</td>
                    <td class="p-3">
                        <span class="px-3 py-1 text-sm rounded bg-yellow-500/20 text-yellow-600">Pending</span>
                    </td>
                    <td class="p-3 text-center">
                        <button class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                            View
                        </button>
                    </td>
                </tr>

                <tr>
                    <td class="p-3">Reena Gupta</td>
                    <td class="p-3">19 Nov 2025</td>
                    <td class="p-3">02:30 PM</td>
                    <td class="p-3">
                        <span class="px-3 py-1 text-sm rounded bg-red-500/20 text-red-600">Cancelled</span>
                    </td>
                    <td class="p-3 text-center">
                        <button class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                            View
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>

@endsection
