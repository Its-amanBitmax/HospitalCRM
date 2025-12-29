@extends('layouts.accountant')

@section('content')
<div class="min-h-screen">
    <div class="max-w-[950px]">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm">
            <!-- Header with gradient -->
            <div class="h-40 bg-gradient-to-r from-cyan-200 to-cyan-300 rounded-t-xl relative">
                <div class="absolute bottom-4 left-6">
                    <div class="flex items-end">
                        <div class="relative">
                            @if($accountant->image)
                            <img src="{{ asset('storage/' . $accountant->image) }}"
                                alt="{{ $accountant->name }}"
                                class="h-32 w-32 rounded-full border-2 shadow-lg object-cover">
                            @else
                            <div class="h-32 w-32 rounded-full border-4 border-white bg-cyan-100 shadow-lg flex items-center justify-center">
                                <span class="text-4xl font-bold text-cyan-600">
                                    {{ substr($accountant->name, 0, 1) }}
                                </span>
                            </div>
                            @endif

                        </div>
                        <div class="ml-6 mb-4">
                            <h1 class="text-2xl font-bold text-black">{{ $accountant->name }}</h1>
                            <p class="text-black text-opacity-90 mt-1">{{ $accountant->email }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-black text-sm">
                                    {{ $accountant->employee_code }}
                                </span>
                                <span class="px-3 py-1 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-black text-sm">
                                    {{ $accountant->department->department_name ?? 'Accountant' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute top-4 right-4">
                    <a href="#"
                        class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-cyan-600 font-medium rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="pt-24 px-6 pb-6">
                <!-- Stats Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                   

                    <div class="bg-cyan-50 rounded-lg p-4 border border-cyan-100">
                        <div class="flex items-center">
                            <div class="p-2 bg-cyan-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-cyan-700">Monthly Salary</p>
                                <p class="text-lg font-bold text-gray-900">
                                    ₹{{ number_format($accountant->payroll->salary ?? 0, 0) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-cyan-50 rounded-lg p-4 border border-cyan-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-2 bg-cyan-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-cyan-700">Status</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $accountant->status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Info Column -->
                    <div class="space-y-6">
                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Personal Information
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Phone</span>
                                    <span class="font-medium text-gray-900">{{ $accountant->phone ?? 'Not provided' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Date of Birth</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $accountant->date_of_birth ? \Carbon\Carbon::parse($accountant->date_of_birth)->format('d M, Y') : 'Not provided' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Gender</span>
                                    <span class="font-medium text-gray-900">{{ $accountant->gender ?? 'Not provided' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Joining Date</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $accountant->hire_date ? \Carbon\Carbon::parse($accountant->hire_date)->format('d M, Y') : 'Not provided' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        @if($accountant->addresses->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Address Information
                            </h3>
                            <div class="space-y-3">
                                @foreach($accountant->addresses as $address)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-900 capitalize">{{ $address->address_type }} Address</h4>
                                        <span class="text-xs px-2 py-1 bg-cyan-100 text-cyan-800 rounded-full">
                                            {{ $address->address_type }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $address->street }}</p>
                                    <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }}</p>
                                    <p class="text-sm text-gray-600">{{ $address->country }} - {{ $address->postal_code }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Qualifications -->
                        @if($accountant->qualifications->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                                Qualifications
                            </h3>
                            <div class="space-y-3">
                                @foreach($accountant->qualifications as $qualification)
                                <div class="border-l-4 border-cyan-400 pl-4 py-2">
                                    <h4 class="font-medium text-gray-900">{{ $qualification->degree }}</h4>
                                    <p class="text-sm text-gray-600">{{ $qualification->institution }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Completed: {{ $qualification->year_completed }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Professional Info Column -->
                    <div class="space-y-6">
                        <!-- Bank Details -->
                        @if($accountant->payroll)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Bank & Payment Details
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-5">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Bank Name</span>
                                        <span class="font-medium text-gray-900">{{ $accountant->payroll->bank_name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Account Number</span>
                                        <span class="font-medium text-gray-900 font-mono">{{ $accountant->payroll->bank_account }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">IFSC Code</span>
                                        <span class="font-medium text-gray-900 font-mono">{{ $accountant->payroll->ifsc_code }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Payment Frequency</span>
                                        <span class="font-medium text-gray-900">{{ $accountant->payroll->payment_frequency }}</span>
                                    </div>
                                    @if($accountant->payroll->upi_number)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">UPI ID</span>
                                        <span class="font-medium text-gray-900">{{ $accountant->payroll->upi_number }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact Information
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div class="p-2 bg-cyan-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="font-medium text-gray-900">{{ $accountant->email }}</p>
                                    </div>
                                </div>

                                @if($accountant->phone)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div class="p-2 bg-cyan-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Phone</p>
                                        <p class="font-medium text-gray-900">{{ $accountant->phone }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($accountant->emergency_contact)
                                <div class="flex items-center p-3 bg-red-50 rounded-lg">
                                    <div class="p-2 bg-red-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Emergency Contact</p>
                                        <p class="font-medium text-gray-900">{{ $accountant->emergency_contact }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Documents -->
                        @if($accountant->documents->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Documents ({{ $accountant->documents->count() }})
                            </h3>
                            <div class="space-y-2">
                                @foreach($accountant->documents as $document)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="flex items-center">
                                        <div class="p-2 bg-cyan-100 rounded-lg mr-3">
                                            <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $document->document_type }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($document->uploaded_at)->format('d M, Y') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $document->document_path) }}"
                                        target="_blank"
                                        class="text-cyan-600 hover:text-cyan-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <g fill="none" stroke="#affaf2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                                <path d="M3 13c3.6-8 14.4-8 18 0" />
                                                <path fill="#affaf2" d="M12 17a3 3 0 1 1 0-6a3 3 0 0 1 0 6" />
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Family Details -->
                @if($accountant->familyDetails->isNotEmpty())
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 640 512">
                            <path fill="#5fefdf" d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4" />
                        </svg>
                        Family Details
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relation</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($accountant->familyDetails as $family)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $family->name }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded bg-cyan-100 text-cyan-800 capitalize">
                                            {{ $family->relationship }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $family->date_of_birth ? \Carbon\Carbon::parse($family->date_of_birth)->format('d M, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $family->contact_number ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Last updated: {{ now()->format('d M, Y h:i A') }}
                    </div>
                    <div class="flex gap-3">
                        <button class="text-cyan-600 hover:text-cyan-800 text-sm font-medium">
                            Print Profile
                        </button>
                        <button class="text-cyan-600 hover:text-cyan-800 text-sm font-medium">
                            Share Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-card {
        transition: all 0.2s ease;
    }

    .profile-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect to main card
        const card = document.querySelector('.bg-white.rounded-xl');
        card.classList.add('profile-card');

        // Simple fade in animation
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';

        setTimeout(() => {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    });
</script>
@endsection