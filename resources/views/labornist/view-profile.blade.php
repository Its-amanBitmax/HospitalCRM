@extends('layouts.labornist')

@section('content')
<div class="min-h-screen ">

    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-2xl shadow-lg">
                    <i class="fas fa-user-md text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-cyan-900">My Profile</h1>
                    <p class="text-cyan-700 mt-1">Complete professional profile details</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('laborist.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-cyan-700 hover:text-cyan-900 font-medium px-4 py-2 rounded-lg hover:bg-cyan-50 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <a href="{{route('laborist.profile.edit')}}" class="inline-flex items-center gap-2 text-sm bg-gradient-to-r from-cyan-500 to-teal-500 text-white font-medium px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>

    {{-- Main Profile Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Left Column: Profile Card & Personal Info --}}
        <div class="space-y-6">
            {{-- Profile Card --}}
            <div class="bg-gradient-to-br from-cyan-50 to-teal-50 rounded-2xl shadow-lg border border-cyan-200 p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-4">
                        @if($labornist->image)
                        <img src="{{ asset('storage/' . $labornist->image) }}" alt="Profile Image"
                            class="w-32 h-32 rounded-2xl mx-auto border-4 border-white shadow-lg object-cover">
                        @else
                        <div class="w-32 h-32 rounded-2xl mx-auto bg-gradient-to-br from-cyan-500 to-teal-500 flex items-center justify-center border-4 border-white shadow-lg">
                            <i class="fas fa-user text-white text-4xl"></i>
                        </div>
                        @endif

                    </div>

                    <h2 class="text-2xl font-bold text-cyan-900 mb-1">{{ $labornist->name }}</h2>
                    <p class="text-sm text-cyan-700 mb-2">
                        <i class="fas fa-id-badge mr-1.5"></i>{{ $labornist->employee_code }}
                    </p>

                    <div class="inline-flex items-center gap-1.5 bg-gradient-to-r from-cyan-100 to-teal-100 text-cyan-800 px-4 py-2 rounded-full text-sm font-medium border border-cyan-200 mb-4">
                        <i class="fas fa-flask"></i>
                        <span>Laborist</span>
                    </div>

                    <div class="flex flex-wrap items-center justify-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg text-xs text-cyan-700 font-medium border border-cyan-100 shadow-sm">
                            <i class="fas fa-building text-xs"></i>
                            {{ optional($labornist->department)->name ?? 'Lab Department' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-lg text-xs text-teal-700 font-medium border border-teal-100 shadow-sm">
                            <i class="fas fa-calendar text-xs"></i>
                            Joined {{ $labornist->hire_date ? $labornist->hire_date->format('M Y') : 'N/A' }}
                        </span>
                    </div>


                </div>
            </div>

            {{-- Contact Information --}}
            <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 p-6">
                <h3 class="text-xl font-bold text-cyan-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-address-card text-cyan-600"></i>
                    Contact Information
                </h3>

                <div class="space-y-4">
                    @if($labornist->email)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-cyan-50 flex items-center justify-center">
                            <i class="fas fa-envelope text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-cyan-600">Email</p>
                            <p class="font-medium text-cyan-900">{{ $labornist->email }}</p>
                        </div>
                    </div>
                    @endif

                    @if($labornist->phone)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-teal-50 flex items-center justify-center">
                            <i class="fas fa-phone text-teal-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-teal-600">Phone</p>
                            <p class="font-medium text-teal-900">{{ $labornist->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($labornist->date_of_birth)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-birthday-cake text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600">Date of Birth</p>
                            <p class="font-medium text-blue-900">{{ \Carbon\Carbon::parse($labornist->date_of_birth)->format('d M, Y') }}</p>
                            <p class="text-xs text-blue-400">Age: {{ \Carbon\Carbon::parse($labornist->date_of_birth)->age }} years</p>
                        </div>
                    </div>
                    @endif

                    @if($labornist->gender)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                            <i class="fas fa-venus-mars text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-purple-600">Gender</p>
                            <p class="font-medium text-purple-900">{{ ucfirst($labornist->gender) }}</p>
                        </div>
                    </div>
                    @endif


                </div>
            </div>

        </div>

        {{-- Middle Column: Professional Information --}}
        <div class="space-y-6">
            {{-- Qualifications --}}
            @if(isset($labornist->qualifications) && count($labornist->qualifications) > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-cyan-100 p-6">
                <h3 class="text-xl font-bold text-cyan-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-cyan-600"></i>
                    Educational Qualifications
                </h3>

                <div class="space-y-4">
                    @foreach($labornist->qualifications as $qualification)
                    <div class="group p-4 bg-gradient-to-r from-cyan-50/50 to-white border border-cyan-100 rounded-xl hover:border-cyan-200 hover:shadow-sm transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-100 to-cyan-200 flex items-center justify-center group-hover:from-cyan-200 group-hover:to-teal-200 transition-all duration-300">
                                <i class="fas fa-certificate text-cyan-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-cyan-900">{{ $qualification->degree ?? 'Qualification' }}</h4>
                                    @if($qualification->year)
                                    <span class="px-2 py-1 bg-cyan-100 text-cyan-800 rounded-full text-xs font-medium">
                                        {{ $qualification->year }}
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-cyan-700">{{ $qualification->institution ?? 'N/A' }}</p>
                                @if($qualification->specialization)
                                <p class="text-sm text-cyan-600">Specialization: {{ $qualification->specialization }}</p>
                                @endif
                                @if($qualification->grade)
                                <p class="text-sm text-cyan-600">Grade: {{ $qualification->grade }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Department Information --}}
            @if($labornist->department)
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-6">
                <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-sitemap text-blue-600"></i>
                    Department Information
                </h3>

                <div class="p-4 bg-gradient-to-r from-blue-50/50 to-white border border-blue-100 rounded-xl">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <i class="fas fa-flask text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-blue-900">{{ $labornist->department->name }}</h4>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <p class="text-xs text-blue-600">Department Code</p>
                                    <p class="font-medium text-blue-900">{{ $labornist->department->department_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600">Status</p>
                                    <p class="font-medium text-blue-900">{{ $labornist->department->status ?? 'Active' }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            @endif

            {{-- Address Information --}}
            @if(isset($labornist->addresses) && count($labornist->addresses) > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-teal-100 p-6">
                <h3 class="text-xl font-bold text-teal-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-teal-600"></i>
                    Address Details
                </h3>

                <div class="space-y-4">
                    @foreach($labornist->addresses as $address)
                    <div class="p-3 bg-gradient-to-r from-teal-50/50 to-white border border-teal-100 rounded-xl">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-teal-50 flex items-center justify-center">
                                <i class="fas fa-home text-teal-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-medium text-teal-900">{{ ucfirst($address->address_type ?? 'Primary') }} Address</p>
                                    @if(isset($address->is_default) && $address->is_default)
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                                        Default
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-teal-700">{{ $address->address_type ?? 'N/A' }}</p>
                                @if($address->street)
                                <p class="text-sm text-teal-700">{{ $address->street }}</p>
                                @endif
                                <p class="text-sm text-teal-700">
                                    @if($address->city){{ $address->city }},@endif
                                    @if($address->state){{ $address->state }}@endif
                                    @if($address->postal_code)- {{ $address->postal_code }}@endif
                                </p>
                                @if($address->country)
                                <p class="text-sm text-teal-700">{{ $address->country }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Documents & Family --}}
        <div class="space-y-6">
            {{-- Documents --}}
            @if(isset($labornist->documents) && count($labornist->documents) > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-purple-100 p-6">
                <h3 class="text-xl font-bold text-purple-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-file-alt text-purple-600"></i>
                    Documents
                </h3>

                <div class="space-y-3">
                    @foreach($labornist->documents as $document)
                    <div class="group p-3 bg-gradient-to-r from-purple-50/50 to-white border border-purple-100 rounded-xl hover:border-purple-200 hover:shadow-sm transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                                    @php
                                    $ext = isset($document->file_path) ? pathinfo($document->file_path, PATHINFO_EXTENSION) : '';
                                    $icon = match($ext) {
                                    'pdf' => 'fa-file-pdf',
                                    'doc', 'docx' => 'fa-file-word',
                                    'xls', 'xlsx' => 'fa-file-excel',
                                    'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
                                    default => 'fa-file'
                                    };
                                    @endphp
                                    <i class="fas {{ $icon }} text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-purple-900 text-sm">{{ $document->document_name ?? 'Document' }}</p>
                                    <p class="text-xs text-purple-600">{{ ucfirst($document->document_type ?? 'Document') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                    {{ strtoupper($ext) ?: 'FILE' }}
                                </span>
                                @if(isset($document->verified_at) && $document->verified_at)
                                <p class="text-xs text-emerald-600 mt-1">
                                    <i class="fas fa-check-circle"></i> Verified
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Family Details --}}
            @if(isset($labornist->familyDetails) && count($labornist->familyDetails) > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-pink-100 p-6">
                <h3 class="text-xl font-bold text-pink-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-pink-600"></i>
                    Family Details
                </h3>

                <div class="space-y-4">
                    @foreach($labornist->familyDetails as $family)
                    <div class="group p-3 bg-gradient-to-r from-pink-50/50 to-white border border-pink-100 rounded-xl hover:border-pink-200 hover:shadow-sm transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center">
                                    @php
                                    $icon = match($family->relationship) {
                                    'Spouse' => 'fa-heart',
                                    'Father', 'Mother' => 'fa-user-tie',
                                    'Son', 'Daughter' => 'fa-child',
                                    'Brother', 'Sister' => 'fa-user-friends',
                                    default => 'fa-user'
                                    };
                                    @endphp
                                    <i class="fas {{ $icon }} text-pink-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-pink-900">{{ $family->name ?? 'Family Member' }}</p>
                                    <p class="text-xs text-pink-700">{{ ucfirst($family->relationship ?? 'Relative') }}</p>
                                    @if($family->date_of_birth)
                                    <p class="text-xs text-pink-600">{{ \Carbon\Carbon::parse($family->date_of_birth)->format('d M, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                @if($family->contact_number)
                                <p class="text-sm text-pink-800">{{ $family->contact_number }}</p>
                                @endif
                                @if($family->occupation)
                                <p class="text-xs text-pink-600">{{ $family->occupation }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Payroll Information --}}
            @if($labornist->payroll)
            <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 p-6">
                <h3 class="text-xl font-bold text-emerald-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-emerald-600"></i>
                    Payroll Information
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-3 rounded-xl border border-emerald-100">
                            <p class="text-xs text-emerald-600">Basic Salary</p>
                            <p class="text-xl font-bold text-emerald-900">
                                ₹{{ number_format($labornist->payroll->salary ?? 0, 2) }}
                            </p>
                        </div>

                    </div>

                    <div class="p-3 bg-gradient-to-r from-emerald-50/50 to-white border border-emerald-100 rounded-xl">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm text-emerald-700">Total Salary</p>
                            <p class="text-lg font-bold text-emerald-900">
                                ₹{{ number_format(($labornist->payroll->salary ?? 0)) }}
                            </p>
                        </div>

                        @if(isset($labornist->payroll->bank_name) && $labornist->payroll->bank_name)
                        <div class="mt-3 pt-3 border-t border-emerald-100">
                            <p class="text-xs text-emerald-600 font-medium mb-1">Bank Details</p>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-xs text-emerald-600">Bank</p>
                                    <p class="text-sm text-emerald-900">{{ $labornist->payroll->bank_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-600">Account No.</p>
                                    <p class="text-sm text-emerald-900">{{ $labornist->payroll->bank_account ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-600">IFSC Code</p>
                                    <p class="text-sm text-emerald-900">{{ $labornist->payroll->ifsc_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-600">UPI No.</p>
                                    <p class="text-sm text-emerald-900">{{ $labornist->payroll->upi_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-emerald-600">PF No.</p>
                                    <p class="text-sm text-emerald-900">{{ $labornist->payroll->pf_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions Footer --}}
    <div class="mt-8 pt-6 border-t border-cyan-100">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-cyan-600">
                <i class="fas fa-info-circle"></i>
                <span>Profile last updated: {{ $labornist->updated_at->format('F j, Y \a\t h:i A') }}</span>
            </div>
            <div class="flex items-center gap-4">
                <button onclick="window.print()" class="inline-flex items-center gap-2 text-sm text-cyan-700 hover:text-cyan-900 font-medium px-4 py-2 rounded-lg hover:bg-cyan-50 transition-all duration-300">
                    <i class="fas fa-print"></i> Print Profile
                </button>
                <a href="{{ route('laborist.profile.pdf') }}" class="inline-flex items-center gap-2 text-sm bg-gradient-to-r from-cyan-500 to-teal-500 text-white font-medium px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

</div>

<style>
    .profile-section {
        scroll-margin-top: 20px;
    }

    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    .print-only {
        display: none;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        body {
            background: white !important;
        }

        .rounded-2xl {
            border-radius: 0 !important;
            box-shadow: none !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.rounded-2xl');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in');
        });



        // Print functionality
        const printButton = document.querySelector('[onclick*="print"]');
        if (printButton) {
            printButton.addEventListener('click', function() {
                // Add print-specific styles
                const style = document.createElement('style');
                style.textContent = `
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        .min-h-screen, .min-h-screen * {
                            visibility: visible;
                        }
                        .min-h-screen {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                        }
                    }
                `;
                document.head.appendChild(style);

                // Trigger print
                window.print();

                // Remove style after print
                setTimeout(() => {
                    document.head.removeChild(style);
                }, 100);
            });
        }
    });
</script>
@endsection