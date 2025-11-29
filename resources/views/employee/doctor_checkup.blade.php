@extends('layouts.doctor-dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-4">

    <!-- ===========================
            TOP BAR
    ============================ -->
    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-user-md text-2xl text-blue-600 dark:text-blue-400"></i>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                Checkups for: {{ $user->full_name }}
            </h1>
        </div>
        <div>
            <a href="#"
                class="inline-block px-4 py-2 text-white rounded   dark:text-gray-200 dark:hover:bg-gray-600 transition duration-200" style="background-color: gray;">
                Back to All Visits
            </a>
        </div>
    </div>

    <!-- ===========================
            FILTER FORM
    ============================ -->
    <div style="background-color: #f9fafb; color: #111; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.5rem; margin-bottom: 1.5rem; padding: 1rem; overflow: hidden;">
        <form method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                    style="display: block; width: 100%; border-radius: 0.375rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05); padding: 10px;">
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                    style="display: block; width: 100%; border-radius: 0.375rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05); padding: 10px;">
            </div>
            <div>
                <button type="submit"
                    style="padding: 0.5rem 1rem; background-color: #2563eb; color: #fff; border-radius: 0.375rem; border: none; cursor: pointer; transition: background-color 0.2s;">
                    Filter
                </button>
                <a href="{{ url()->current() }}"
                    style="margin-left: 0.5rem; padding: 0.5rem 1rem; background-color: gray; color: #fff; border-radius: 0.375rem; text-decoration: none; transition: background-color 0.2s;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===========================
            PATIENT CHECKUPS TABLE
    ============================ -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-3 border-b bg-gray-50 dark:bg-gray-700 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Patient Checkups</h2>
            <a href="{{ route('employee.users.checkups.create', $user->id) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200 shadow-md hover:shadow-lg flex items-center gap-1">
                <i class="fas fa-plus"></i> Add New Checkup
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-left">
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-300">Sr No</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-300">Checkup Date</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-300">Visit Date</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-300">Diagnosis</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 dark:text-gray-300">Treatment</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($checkups as $checkup)
                    @php
                    $fromDate = request('from_date') ? \Carbon\Carbon::parse(request('from_date')) : null;
                    $toDate = request('to_date') ? \Carbon\Carbon::parse(request('to_date')) : null;
                    $checkupDate = $checkup->checkup_date ? \Carbon\Carbon::parse($checkup->checkup_date) : null;
                    @endphp

                    @if(!$checkupDate ||
                    (!$fromDate || $checkupDate->gte($fromDate)) &&
                    (!$toDate || $checkupDate->lte($toDate))
                    )
                    <tr class="border-b dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ $checkupDate?->format('d-m-Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ $checkup->visit?->date_of_visit?->format('d-m-Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ $checkup->diagnosis ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            {{ $checkup->treatment ?? '-' }}
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                            No checkups found for this user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection