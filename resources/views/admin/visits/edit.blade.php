@extends('layouts.layout')

@section('title', 'Edit Hospital Visit')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 ">Edit Hospital Visit</h1>
            <a href="{{ route('admin.visits.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>

        <form action="{{ route('admin.visits.update', $visit) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Visitor Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Visitor Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Visitor Name *</label>
                        <input type="text" name="visitor_name" value="{{ old('visitor_name', $visit->visitor_name) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('visitor_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                        <input type="text" name="visitor_contact" value="{{ old('visitor_contact', $visit->visitor_contact) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('visitor_contact')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="visitor_email" value="{{ old('visitor_email', $visit->visitor_email) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('visitor_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Relation to Patient</label>
                        <input type="text" name="visitor_relation" value="{{ old('visitor_relation', $visit->visitor_relation) }}" placeholder="e.g., Father, Wife, Brother"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('visitor_relation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person Name</label>
                        <input type="text" name="contact_person_name" value="{{ old('contact_person_name', $visit->contact_person_name) }}" placeholder="Emergency contact person"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('contact_person_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person Phone</label>
                        <input type="text" name="contact_person_phone" value="{{ old('contact_person_phone', $visit->contact_person_phone) }}" placeholder="Emergency contact number"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('contact_person_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Visit Details -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Visit Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Visit Type *</label>
                        <select name="visit_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="">Select Visit Type</option>
                            <option value="patient_visit" {{ old('visit_type', $visit->visit_type) == 'patient_visit' ? 'selected' : '' }}>Patient Visit</option>
                            <option value="doctor_meeting" {{ old('visit_type', $visit->visit_type) == 'doctor_meeting' ? 'selected' : '' }}>Doctor Meeting</option>
                            <option value="staff_meeting" {{ old('visit_type', $visit->visit_type) == 'staff_meeting' ? 'selected' : '' }}>Staff Meeting</option>
                            <option value="delivery" {{ old('visit_type', $visit->visit_type) == 'delivery' ? 'selected' : '' }}>Delivery</option>
                            <option value="emergency" {{ old('visit_type', $visit->visit_type) == 'emergency' ? 'selected' : '' }}>Emergency</option>
                            <option value="invite" {{ old('visit_type', $visit->visit_type) == 'invite' ? 'selected' : '' }}>Invite</option>
                            <option value="vendor" {{ old('visit_type', $visit->visit_type) == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        </select>
                        @error('visit_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                        <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="invited" {{ old('status', $visit->status) == 'invited' ? 'selected' : '' }}>Invited</option>
                            <option value="scheduled" {{ old('status', $visit->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="waiting" {{ old('status', $visit->status) == 'waiting' ? 'selected' : '' }}>Waiting</option>
                            <option value="in_progress" {{ old('status', $visit->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $visit->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $visit->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Scheduled Visit</label>
                        <input type="datetime-local" name="scheduled_visit" value="{{ old('scheduled_visit', $visit->scheduled_visit ? $visit->scheduled_visit->format('Y-m-d\TH:i') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('scheduled_visit')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Check In</label>
                        <input type="datetime-local" name="check_in" value="{{ old('check_in', $visit->check_in ? $visit->check_in->format('Y-m-d\TH:i') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('check_in')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Check Out</label>
                        <input type="datetime-local" name="check_out" value="{{ old('check_out', $visit->check_out ? $visit->check_out->format('Y-m-d\TH:i') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('check_out')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Invite Status</label>
                        <select name="invite_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="none" {{ old('invite_status', $visit->invite_status) == 'none' ? 'selected' : '' }}>None</option>
                            <option value="pending" {{ old('invite_status', $visit->invite_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ old('invite_status', $visit->invite_status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="declined" {{ old('invite_status', $visit->invite_status) == 'declined' ? 'selected' : '' }}>Declined</option>
                        </select>
                        @error('invite_status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                        <input type="text" name="purpose" value="{{ old('purpose', $visit->purpose) }}" placeholder="Brief purpose of visit"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('purpose')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">{{ old('notes', $visit->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Patient/Doctor Links -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Patient & Doctor Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                        <select name="patient_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="">Select Patient (Optional)</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $visit->patient_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->mr_no ?? 'No MR' }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patient MR No</label>
                        <input type="text" name="patient_mr_no" value="{{ old('patient_mr_no', $visit->patient_mr_no) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('patient_mr_no')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                        <select name="doctor_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="">Select Doctor (Optional)</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $visit->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Security & Compliance -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Security & Compliance</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Proof Type</label>
                        <select name="id_proof_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                            <option value="">Select ID Type</option>
                            <option value="aadhar" {{ old('id_proof_type', $visit->id_proof_type) == 'aadhar' ? 'selected' : '' }}>Aadhar Card</option>
                            <option value="pan" {{ old('id_proof_type', $visit->id_proof_type) == 'pan' ? 'selected' : '' }}>PAN Card</option>
                            <option value="driving_license" {{ old('id_proof_type', $visit->id_proof_type) == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                            <option value="passport" {{ old('id_proof_type', $visit->id_proof_type) == 'passport' ? 'selected' : '' }}>Passport</option>
                            <option value="other" {{ old('id_proof_type', $visit->id_proof_type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('id_proof_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Proof Number</label>
                        <input type="text" name="id_proof_number" value="{{ old('id_proof_number', $visit->id_proof_number) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('id_proof_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badge Number</label>
                        <input type="text" name="badge_number" value="{{ old('badge_number', $visit->badge_number) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
                        @error('badge_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.visits.index') }}" class="bg-white-500 hover:bg-white-600 text-white px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Update Visit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
