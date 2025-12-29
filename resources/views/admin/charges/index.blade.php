@extends('layouts.layout')

@section('content')
<div class="min-h-screen">
    <div class="max-w-[960px]">
        {{-- Header with Glassmorphism Effect --}}
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-soft p-6 border border-white/20">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center mb-6 md:mb-0">
                        <div class="relative mr-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                           
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Charges</h1>
                            <p class="text-gray-600 mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Manage and track all doctor charges in one place
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('admin.charges.create') }}"
                        class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-2xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl flex items-center justify-center">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Charge
                    </a>
                </div>
            </div>
        </div>

        {{-- Floating Notifications --}}
        @if(session('success'))
        <div class="mb-6 animate-float-in">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 rounded-2xl shadow-lg border-l-4 border-emerald-300">
                <div class="flex items-center">
                    <div class="bg-white/20 p-2 rounded-xl mr-3 backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">{{ session('success') }}</p>
                        <p class="text-sm text-white/90 mt-1">Successfully processed</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()"
                        class="ml-4 text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 animate-float-in">
            <div class="bg-gradient-to-r from-red-500 to-rose-600 text-white p-4 rounded-2xl shadow-lg border-l-4 border-rose-300">
                <div class="flex items-center">
                    <div class="bg-white/20 p-2 rounded-xl mr-3 backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">{{ session('error') }}</p>
                        <p class="text-sm text-white/90 mt-1">Please check and try again</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()"
                        class="ml-4 text-white/80 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- Stats Cards with Hover Effects --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
            $stats = [
            [
            'title' => 'Total Charges',
            'value' => $charges->count(),
            'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'color' => 'from-blue-500 to-blue-600',
            'bgColor' => 'bg-blue-100',
            'trend' => '+12%'
            ],
            [
            'title' => 'Consultations',
            'value' => $charges->where('type', 'consultation')->count(),
            'icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z',
            'color' => 'from-purple-500 to-purple-600',
            'bgColor' => 'bg-purple-100',
            'trend' => '+5%'
            ],
            [
            'title' => 'Appointments',
            'value' => $charges->where('type', 'appointment')->count(),
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            'color' => 'from-green-500 to-emerald-600',
            'bgColor' => 'bg-green-100',
            'trend' => '+18%'
            ],
            [
            'title' => 'Tests',
            'value' => $charges->where('type', 'test')->count(),
            'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
            'color' => 'from-orange-500 to-amber-600',
            'bgColor' => 'bg-orange-100',
            'trend' => '+8%'
            ]
            ];
            @endphp

            @foreach($stats as $stat)
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r {{ $stat['color'] }} rounded-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                <div class="bg-white rounded-3xl shadow-soft p-6 border border-gray-100 hover:border-gray-200 transition-all duration-300 hover:shadow-lg relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stat['value'] }}</p>
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                <span class="text-xs font-medium text-green-600">{{ $stat['trend'] }}</span>
                                <span class="text-xs text-gray-500 ml-1">from last month</span>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="w-14 h-14 {{ $stat['bgColor'] }} rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br {{ $stat['color'] }} rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Main Table Card --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Table Header with Glass Effect --}}
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200/50">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-4 lg:mb-0">
                        <h3 class="text-xl font-bold text-gray-900">All Charges</h3>
                        <p class="text-sm text-gray-500 mt-1 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                            Showing {{ $charges->count() }} charge{{ $charges->count() !== 1 ? 's' : '' }} • Updated just now
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Search with Icon Animation --}}
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <input type="text" id="searchInput"
                                    class="pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full lg:w-72 transition-all duration-200 focus:bg-white"
                                    placeholder="Search charges...">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Filter with Dropdown --}}
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="relative">
                                <select id="filterType"
                                    class="appearance-none bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 pr-12 focus:ring-2 focus:ring-purple-500 focus:border-transparent w-full transition-all duration-200 focus:bg-white">
                                    <option value="">All Types</option>
                                    <option value="consultation">Consultation</option>
                                    <option value="appointment">Appointment</option>
                                    <option value="test">Test</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Doctor</span>
                                    <svg class="w-4 h-4 ml-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                @php
                                // Check if any charge has type data
                                $hasTypeData = false;
                                $hasNameData = false;

                                // Check first few records
                                foreach($charges->take(5) as $charge) {
                                if(!empty($charge->type)) $hasTypeData = true;
                                if(!empty($charge->name)) $hasNameData = true;
                                }
                                @endphp

                                @if($hasTypeData)
                                Type
                                @elseif($hasNameData)
                                Service Name
                                @else
                                Type/Service
                                @endif
                            </th>
                            <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($charges as $charge)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-white transition-all duration-200 group">
                            {{-- Doctor --}}
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                            Dr. {{ $charge->doctor->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                            ID: {{ $charge->doctor->employee_code ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Type --}}
                            <td class="px-8 py-5 whitespace-nowrap">
                                @if($charge->type || $charge->name)
                                @php
                                $typeConfig = [
                                'consultation' => ['color' => 'from-blue-500 to-blue-600', 'bg' => 'bg-blue-100', 'icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z'],
                                'appointment' => ['color' => 'from-green-500 to-emerald-600', 'bg' => 'bg-green-100', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                'test' => ['color' => 'from-purple-500 to-purple-600', 'bg' => 'bg-purple-100', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z']
                                ];

                                // Determine which config to use based on available data
                                if($charge->type && isset($typeConfig[$charge->type])) {
                                $config = $typeConfig[$charge->type];
                                $displayText = $charge->type;
                                $displayName = false;
                                } elseif($charge->name) {
                                // If no type but has name, use default config
                                $config = ['color' => 'from-gray-500 to-gray-600', 'bg' => 'bg-gray-100', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'];
                                $displayText = $charge->name;
                                $displayName = true;
                                } else {
                                // Fallback for type not in config
                                $config = ['color' => 'from-gray-500 to-gray-600', 'bg' => 'bg-gray-100', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'];
                                $displayText = $charge->type ?? 'N/A';
                                $displayName = false;
                                }
                                @endphp

                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $config['bg'] }} rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                        <div class="w-8 h-8 bg-gradient-to-br {{ $config['color'] }} rounded-md flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        @if($displayName)
                                        <span class="text-sm font-semibold text-gray-900">{{ $displayText }}</span>

                                        @else
                                        <span class="text-sm font-semibold text-gray-900 capitalize">{{ $displayText }}</span>
                                        @if($charge->sub_type)
                                        <div class="text-xs text-gray-500 mt-1">{{ $charge->sub_type }}</div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                @else
                                {{-- No type or name available --}}
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 opacity-50">
                                        <div class="w-8 h-8 bg-gradient-to-br from-gray-300 to-gray-400 rounded-md flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-400 italic">No type specified</span>
                                    </div>
                                </div>
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">₹</span>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-gray-900">₹{{ number_format($charge->charge, 2) }}</div>
                                        <div class="text-xs text-gray-500">Indian Rupee</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Description --}}
                            <td class="px-8 py-5">
                                <div class="max-w-xs">
                                    <p class="text-sm text-gray-900 line-clamp-2"
                                        data-tooltip="{{ $charge->description ?? 'No description' }}">
                                        {{ $charge->description ? (strlen($charge->description) > 60 ? substr($charge->description, 0, 60) . '...' : $charge->description) : 'No description' }}
                                    </p>
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $charge->created_at->format('d M, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $charge->created_at->format('h:i A') }}
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.charges.edit', $charge->id) }}"
                                        class="group relative p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                        title="Edit">
                                        <div class="absolute inset-0 bg-blue-500 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>                                
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.charges.destroy', $charge->id) }}" method="POST"
                                        class="inline" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        <button type="submit"
                                            class="group relative p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                            title="Delete">
                                            <div class="absolute inset-0 bg-red-500 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">No charges found</h3>
                                    <p class="text-gray-500 mb-6 max-w-md text-center">
                                        Start by adding your first doctor charge to track medical service fees.
                                    </p>
                                    <a href="{{ route('admin.charges.create') }}"
                                        class="group relative bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 flex items-center">
                                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Create First Charge
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($charges->hasPages())
            <div class="px-8 py-6 border-t border-gray-200 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-semibold">{{ $charges->firstItem() }}</span> to
                        <span class="font-semibold">{{ $charges->lastItem() }}</span> of
                        <span class="font-semibold">{{ $charges->total() }}</span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $charges->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>    
    </div>
</div>

{{-- JS for Enhanced Functionality --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality with debounce
        const searchInput = document.getElementById('searchInput');
        const filterType = document.getElementById('filterType');
        const tableRows = document.querySelectorAll('tbody tr');

        let searchTimeout;

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterValue = filterType.value.toLowerCase();

            let visibleCount = 0;

            tableRows.forEach(row => {
                if (row.cells.length === 0) return;

                const doctorName = row.cells[0]?.textContent?.toLowerCase() || '';
                const chargeType = row.cells[1]?.textContent?.toLowerCase() || '';
                const amount = row.cells[2]?.textContent?.toLowerCase() || '';
                const description = row.cells[3]?.textContent?.toLowerCase() || '';

                const matchesSearch = !searchTerm ||
                    doctorName.includes(searchTerm) ||
                    chargeType.includes(searchTerm) ||
                    amount.includes(searchTerm) ||
                    description.includes(searchTerm);

                const matchesFilter = !filterValue ||
                    chargeType.includes(filterValue);

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                    // Add animation
                    row.style.animation = 'fadeIn 0.3s ease';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update count
            const countElement = document.querySelector('.text-sm.text-gray-500.mt-1');
            if (countElement) {
                countElement.innerHTML = `
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                Showing ${visibleCount} charge${visibleCount !== 1 ? 's' : ''} • Updated just now
            `;
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterTable, 300);
            });
        }

        if (filterType) {
            filterType.addEventListener('change', filterTable);
        }

        // Tooltip for truncated descriptions
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', function(e) {
                const tooltip = document.createElement('div');
                tooltip.className = 'fixed z-50 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg shadow-lg max-w-xs';
                tooltip.textContent = this.dataset.tooltip;
                document.body.appendChild(tooltip);

                const rect = this.getBoundingClientRect();
                tooltip.style.left = `${rect.left + window.scrollX}px`;
                tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight - 10}px`;

                this._tooltip = tooltip;
            });

            element.addEventListener('mouseleave', function() {
                if (this._tooltip) {
                    this._tooltip.remove();
                }
            });
        });

        // Row click effect
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('a') && !e.target.closest('button') && !e.target.closest('form')) {
                    this.classList.toggle('bg-blue-50');
                }
            });
        });
    });

    // Delete confirmation with sweet alert style
    function confirmDelete(event) {
        event.preventDefault();
        const form = event.target.closest('form');

        if (confirm('Are you sure you want to delete this charge?\nThis action cannot be undone.')) {
            form.submit();
        }
        return false;
    }

    // Show details modal (placeholder)
    function showDetails(id) {
        alert(`Details for charge ID: ${id}\n\nThis would open a detailed modal with more information.`);
    }

    // Initialize animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.group').forEach((el) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });
</script>

<style>
    /* Custom Animations */
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

    @keyframes floatIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-float-in {
        animation: floatIn 0.4s ease-out;
    }

    /* Custom Shadows */
    .shadow-soft {
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08);
    }

    /* Line clamp for description */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Gradient borders */
    .hover-border-gradient {
        position: relative;
    }

    .hover-border-gradient::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: inherit;
        padding: 1px;
        background: linear-gradient(45deg, #3b82f6, #8b5cf6, #10b981);
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .hover-border-gradient:hover::before {
        opacity: 1;
    }

    /* Pagination styling */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin: 0 4px;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 10px;
        text-decoration: none;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        background: white;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .pagination li.active span {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border-color: transparent;
        box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
    }

    .pagination li a:hover:not(.disabled) {
        background: #f3f4f6;
        border-color: #d1d5db;
        transform: translateY(-1px);
    }

    .pagination li.disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endsection