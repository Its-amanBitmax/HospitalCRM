@extends('layouts.layout')

@section('title', 'Hospital Visit Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white bg-white-800 rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 text-white">Hospital Visit Details</h1>
                <div class="flex space-x-2">
                    @if($visit->invitation_code)
                        <a href="{{ route('admin.visits.invitation-pdf', $visit) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-download mr-2"></i>Download Invitation PDF
                        </a>
                    @endif
                    <a href="{{ route('admin.visits.edit', $visit) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.visits.index') }}" class="bg-white-500 hover:bg-white-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Visitor Information -->
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-cyan-600"></i>Visitor Information
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Name</label>
                            <p class="text-gray-900 text-white">{{ $visit->visitor_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Contact</label>
                            <p class="text-gray-900 text-white">{{ $visit->visitor_contact ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Email</label>
                            <p class="text-gray-900 text-white">{{ $visit->visitor_email ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Relation</label>
                            <p class="text-gray-900 text-white">{{ $visit->visitor_relation ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Contact Person Name</label>
                            <p class="text-gray-900 text-white">{{ $visit->contact_person_name ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Contact Person Phone</label>
                            <p class="text-gray-900 text-white">{{ $visit->contact_person_phone ?: 'N/A' }}</p>
                        </div>
                        @if($visit->invitation_code)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Invitation Code</label>
                            <p class="text-gray-900 text-white font-mono">{{ $visit->invitation_code }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Visit Details -->
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-calendar mr-2 text-cyan-600"></i>Visit Details
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Visit Type</label>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($visit->visit_type == 'patient_visit') bg-blue-100 text-blue-800
                                @elseif($visit->visit_type == 'doctor_meeting') bg-green-100 text-green-800
                                @elseif($visit->visit_type == 'staff_meeting') bg-purple-100 text-purple-800
                                @elseif($visit->visit_type == 'delivery') bg-yellow-100 text-yellow-800
                                @elseif($visit->visit_type == 'emergency') bg-red-100 text-red-800
                                @elseif($visit->visit_type == 'invite') bg-indigo-100 text-indigo-800
                                @else bg-white-100 text-gray-800
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $visit->visit_type)) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Status</label>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($visit->status == 'completed') bg-green-100 text-green-800
                                @elseif($visit->status == 'in_progress') bg-blue-100 text-blue-800
                                @elseif($visit->status == 'waiting') bg-yellow-100 text-yellow-800
                                @elseif($visit->status == 'scheduled') bg-white-100 text-gray-800
                                @elseif($visit->status == 'invited') bg-indigo-100 text-indigo-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $visit->status)) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Purpose</label>
                            <p class="text-gray-900 text-white">{{ $visit->purpose ?: 'N/A' }}</p>
                        </div>
                        @if($visit->invite_status != 'none')
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Invite Status</label>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($visit->invite_status == 'accepted') bg-green-100 text-green-800
                                @elseif($visit->invite_status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($visit->invite_status) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Timing Information -->
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-clock mr-2 text-cyan-600"></i>Timing Information
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Scheduled Visit</label>
                            <p class="text-gray-900 text-white">{{ $visit->scheduled_visit ? $visit->scheduled_visit->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Check In</label>
                            <p class="text-gray-900 text-white">{{ $visit->check_in ? $visit->check_in->format('M d, Y H:i') : 'Not checked in' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Check Out</label>
                            <p class="text-gray-900 text-white">{{ $visit->check_out ? $visit->check_out->format('M d, Y H:i') : 'Not checked out' }}</p>
                        </div>
                        @if($visit->invited_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Invited At</label>
                            <p class="text-gray-900 text-white">{{ $visit->invited_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Patient & Doctor Information -->
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-user-md mr-2 text-cyan-600"></i>Patient & Doctor
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Patient</label>
                            @if($visit->patient)
                                <p class="text-gray-900 text-white">{{ $visit->patient->name }}</p>
                                <p class="text-sm text-gray-600 text-gray-400">{{ $visit->patient_mr_no ?: 'No MR Number' }}</p>
                            @else
                                <p class="text-gray-500 text-gray-400">N/A</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Doctor</label>
                            @if($visit->doctor)
                                <p class="text-gray-900 text-white">{{ $visit->doctor->name }}</p>
                            @else
                                <p class="text-gray-500 text-gray-400">N/A</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Security & Compliance -->
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-cyan-600"></i>Security & Compliance
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">ID Proof Type</label>
                            <p class="text-gray-900 text-white">{{ $visit->id_proof_type ? ucwords(str_replace('_', ' ', $visit->id_proof_type)) : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">ID Proof Number</label>
                            <p class="text-gray-900 text-white">{{ $visit->id_proof_number ?: 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Badge Number</label>
                            <p class="text-gray-900 text-white">{{ $visit->badge_number ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($visit->notes)
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-sticky-note mr-2 text-cyan-600"></i>Notes
                    </h3>
                    <p class="text-gray-900 text-white whitespace-pre-wrap">{{ $visit->notes }}</p>
                </div>
                @endif

                <!-- Audit Information -->
                <div class="bg-white-50 bg-white-700 p-4 rounded-lg lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 text-white mb-4 flex items-center">
                        <i class="fas fa-history mr-2 text-cyan-600"></i>Audit Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Created By</label>
                            <p class="text-gray-900 text-white">{{ $visit->creator ? $visit->creator->name : 'System' }}</p>
                            <p class="text-sm text-gray-600 text-gray-400">{{ $visit->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        @if($visit->updater)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 text-gray-400">Last Updated By</label>
                            <p class="text-gray-900 text-white">{{ $visit->updater->name }}</p>
                            <p class="text-sm text-gray-600 text-gray-400">{{ $visit->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-center space-x-4">
                @if($visit->status == 'scheduled' || $visit->status == 'waiting')
                    <form action="{{ route('admin.visits.check-in', $visit) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Check In
                        </button>
                    </form>
                @endif
                @if($visit->status == 'in_progress')
                    <form action="{{ route('admin.visits.check-out', $visit) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>Check Out
                        </button>
                    </form>
                @endif
                @if($visit->visit_type == 'invite' && $visit->invite_status == 'pending')
                    <form action="{{ route('admin.visits.accept-invite', $visit) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-check mr-2"></i>Accept Invite
                        </button>
                    </form>
                    <form action="{{ route('admin.visits.decline-invite', $visit) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-times mr-2"></i>Decline Invite
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
