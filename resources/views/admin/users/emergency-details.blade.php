<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emergency Details - {{ $user->full_name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen bg-gray-100 py-8">
  <div class="max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          @if($user->image)
          <img src="{{ asset($user->image) }}" alt="Patient Image" class="w-16 h-16 rounded-full object-cover border-4 border-gray-200">
          @else
          <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center">
            <i class="fas fa-user text-2xl text-gray-600"></i>
          </div>
          @endif
          <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $user->full_name }}</h1>
            <p class="text-gray-600">Emergency Details</p>
          </div>
        </div>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i class="fas fa-print"></i> Print
        </button>
      </div>
    </div>

    <!-- Patient Information -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Patient Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
        <div><span class="font-medium text-gray-700">Full Name:</span> <span class="text-gray-900">{{ $user->full_name }}</span></div>
        <div><span class="font-medium text-gray-700">Email:</span> <span class="text-gray-900">{{ $user->email ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Phone:</span> <span class="text-gray-900">{{ $user->mobile_no ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Alternate No:</span> <span class="text-gray-900">{{ $user->alternate_no ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Date of Birth:</span> <span class="text-gray-900">{{ $user->date_of_birth?->format('d-m-Y') ?? '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Age:</span> <span class="text-gray-900">{{ $user->age ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Gender:</span> <span class="text-gray-900">{{ $user->gender ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Blood Group:</span> <span class="text-gray-900">{{ $user->blood_group ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Father/Spouse:</span> <span class="text-gray-900">{{ $user->father_spouse_name ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Emergency Contact:</span> <span class="text-gray-900">{{ $user->emergency_contact ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">ID Proof:</span> <span class="text-gray-900">{{ $user->id_proof_type ?: '-' }} {{ $user->id_number ? '('.$user->id_number.')' : '' }}</span></div>
        <div><span class="font-medium text-gray-700">Patient Type:</span> <span class="text-gray-900">{{ ucfirst($user->type) }}</span></div>
        <div><span class="font-medium text-gray-700">Registration Date:</span> <span class="text-gray-900">{{ $user->created_at?->format('d-m-Y') ?? '-' }}</span></div>
      </div>
    </div>

    <!-- Address Information -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Address Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><span class="font-medium text-gray-700">Full Address:</span> <span class="text-gray-900">{{ $user->full_address ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">City:</span> <span class="text-gray-900">{{ $user->city ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">State:</span> <span class="text-gray-900">{{ $user->state ?: '-' }}</span></div>
        <div><span class="font-medium text-gray-700">Pin Code:</span> <span class="text-gray-900">{{ $user->pin_code ?: '-' }}</span></div>
      </div>
    </div>

    <!-- Emergency Verifications -->
    <div class="bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Emergency Verifications</h2>
      @if($verifications->count() > 0)
      <div class="space-y-4">
        @foreach($verifications as $verification)
        <div class="border border-gray-200 rounded-lg p-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><span class="font-medium text-gray-700">Verification Type:</span> <span class="text-gray-900">{{ ucfirst($verification->verification_type) }}</span></div>
            <div><span class="font-medium text-gray-700">Created Date:</span> <span class="text-gray-900">{{ $verification->created_at?->format('d-m-Y H:i') ?? '-' }}</span></div>

            @if($verification->verification_type === 'family')
            <div><span class="font-medium text-gray-700">Family Member Name:</span> <span class="text-gray-900">{{ $verification->family_name ?: '-' }}</span></div>
            <div><span class="font-medium text-gray-700">Relation:</span> <span class="text-gray-900">{{ $verification->family_relation ?: '-' }}</span></div>
            @else
            <div><span class="font-medium text-gray-700">Police Station:</span> <span class="text-gray-900">{{ $verification->police_station ?: '-' }}</span></div>
            <div><span class="font-medium text-gray-700">Police Address:</span> <span class="text-gray-900">{{ $verification->police_address ?: '-' }}</span></div>
            <div><span class="font-medium text-gray-700">Verification Status:</span>
              <span class="text-gray-900 {{ $verification->police_verified ? 'text-green-600' : 'text-red-600' }}">
                {{ $verification->police_verified ? 'Verified' : 'Not Verified' }}
              </span>
            </div>
            @endif
          </div>
        </div>
        @endforeach
      </div>
      @else
      <p class="text-gray-500 text-center py-8">No emergency verifications found for this patient.</p>
      @endif
    </div>
  </div>
</div>

<style>
  @media print {
    .no-print { display: none !important; }
    body { background: white !important; }
  }
</style>
</body>
</html>
