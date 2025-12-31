<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $labornist->name }} - Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* ===== HEADER ===== */
        .profile-header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #00bcd4;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .profile-image,
        .profile-info {
            display: table-cell;
            vertical-align: middle;
        }

        .profile-image {
            width: 120px;
            text-align: center;
        }

        .profile-image img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #00bcd4;
            object-fit: cover;
        }

        .profile-info h1 {
            margin: 0;
            font-size: 22px;
            color: #00bcd4;
        }

        .profile-info p {
            margin: 3px 0;
            color: #555;
        }

        /* ===== SECTION ===== */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section h2 {
            font-size: 15px;
            color: #00bcd4;
            border-bottom: 1px solid #00bcd4;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }

        /* ===== INFO GRID ===== */
        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label,
        .info-value {
            display: table-cell;
            padding: 5px 8px;
            vertical-align: top;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
            color: #555;
        }

        /* ===== BOX ITEMS ===== */
        .box {
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        /* ===== PAYROLL ===== */
        .payroll-table {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .payroll-row {
            display: table-row;
        }

        .payroll-cell {
            display: table-cell;
            border: 1px solid #ddd;
            padding: 6px;
        }

        .payroll-header {
            font-weight: bold;
            background: #f5f5f5;
            width: 200px;
        }

        @media print {
            body {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>

{{-- ===== PROFILE HEADER ===== --}}
<div class="profile-header">
    <div class="profile-image">
        @php
            $imagePath = $labornist->image && Storage::disk('public')->exists($labornist->image)
                        ? storage_path('app/public/' . $labornist->image)
                        : public_path('images/user-placeholder.png');
        @endphp
        <img src="{{ $imagePath }}">
    </div>

    <div class="profile-info">
        <h1>{{ $labornist->name }}</h1>
        <p><strong>Employee Code:</strong> {{ $labornist->employee_code }}</p>
        <p><strong>Department:</strong> {{ optional($labornist->department)->name ?? 'Lab Department' }}</p>
        <p><strong>Hire Date:</strong> {{ $labornist->hire_date ? $labornist->hire_date->format('M Y') : 'N/A' }}</p>
    </div>
</div>

{{-- ===== PERSONAL INFO ===== --}}
<div class="section">
    <h2>Personal Information</h2>
    <div class="info-grid">
        @if($labornist->email)
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $labornist->email }}</div>
        </div>
        @endif

        @if($labornist->phone)
        <div class="info-row">
            <div class="info-label">Phone</div>
            <div class="info-value">{{ $labornist->phone }}</div>
        </div>
        @endif

        @if($labornist->date_of_birth)
        <div class="info-row">
            <div class="info-label">Date of Birth</div>
            <div class="info-value">
                {{ \Carbon\Carbon::parse($labornist->date_of_birth)->format('d M Y') }}
                ({{ \Carbon\Carbon::parse($labornist->date_of_birth)->age }} Years)
            </div>
        </div>
        @endif

        @if($labornist->gender)
        <div class="info-row">
            <div class="info-label">Gender</div>
            <div class="info-value">{{ ucfirst($labornist->gender) }}</div>
        </div>
        @endif
    </div>
</div>

{{-- ===== QUALIFICATIONS ===== --}}
@if($labornist->qualifications && count($labornist->qualifications))
<div class="section">
    <h2>Educational Qualifications</h2>
    @foreach($labornist->qualifications as $q)
        <div class="box">
            <strong>{{ $q->degree }}</strong> – {{ $q->institution }} <br>
            @if($q->specialization) Specialization: {{ $q->specialization }} <br> @endif
            @if($q->year) Year: {{ $q->year }} @endif
        </div>
    @endforeach
</div>
@endif

{{-- ===== ADDRESSES ===== --}}
@if($labornist->addresses && count($labornist->addresses))
<div class="section">
    <h2>Address Information</h2>
    @foreach($labornist->addresses as $address)
        <div class="box">
            <strong>{{ ucfirst($address->address_type ?? 'Primary') }} Address</strong><br>
            {{ $address->street }}<br>
            {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}<br>
            {{ $address->country }}
        </div>
    @endforeach
</div>
@endif

{{-- ===== PAYROLL ===== --}}
@if($labornist->payroll)
<div class="section">
    <h2>Payroll Information</h2>
    <div class="payroll-table">
        <div class="payroll-row">
            <div class="payroll-cell payroll-header">Basic Salary</div>
            <div class="payroll-cell">{{ number_format($labornist->payroll->salary, 2) }}</div>
        </div>
        <div class="payroll-row">
            <div class="payroll-cell payroll-header">Bank Name</div>
            <div class="payroll-cell">{{ $labornist->payroll->bank_name ?? 'N/A' }}</div>
        </div>
        <div class="payroll-row">
            <div class="payroll-cell payroll-header">Account Number</div>
            <div class="payroll-cell">{{ $labornist->payroll->bank_account ?? 'N/A' }}</div>
        </div>

        <div class="payroll-row">
            <div class="payroll-cell payroll-header">IFSC Code</div>
            <div class="payroll-cell">{{ $labornist->payroll->ifsc_code ?? 'N/A' }}</div>
        </div>

         <div class="payroll-row">
            <div class="payroll-cell payroll-header">UPI No.</div>
            <div class="payroll-cell">{{ $labornist->payroll->upi_number ?? 'N/A' }}</div>
        </div>
         <div class="payroll-row">
            <div class="payroll-cell payroll-header">PF No.</div>
            <div class="payroll-cell">{{ $labornist->payroll->pf_number ?? 'N/A' }}</div>
        </div>
    </div>
</div>
@endif

<p style="text-align:center;font-size:10px;color:#777;">
    Generated on {{ now()->format('d M Y, h:i A') }}
</p>

</body>
</html>
