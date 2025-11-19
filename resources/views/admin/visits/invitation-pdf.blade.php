<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Visit Invitation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 15px;
            background-color: white;
            color: #333;
            font-size: 12px;
            line-height: 1.3;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
            background: white;
        }
        .header {
            background: white;
            color: black;
            padding: 15px;
            border-bottom: 2px solid #667eea;
        }
        .logo-section {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .hospital-info {
            text-align: right;
            color: black;
        }
        .hospital-name {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 5px 0;
            color: black;
        }
        .hospital-details {
            font-size: 10px;
            color: #666;
            line-height: 1.2;
        }
        .invitation-title {
            font-size: 16px;
            margin: 5px 0;
            font-weight: 300;
        }
        .invitation-code {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
        }
        .content {
            padding: 15px;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 8px;
            border-bottom: 1px solid #667eea;
            padding-bottom: 3px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            color: #666;
            padding: 4px 0;
            font-size: 11px;
        }
        .info-value {
            display: table-cell;
            padding: 4px 0;
            color: #333;
            font-size: 11px;
        }
        .purpose-section {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #667eea;
            margin: 5px 0;
        }
        .purpose-text {
            font-style: italic;
            color: #555;
            margin: 0;
            font-size: 11px;
        }
        .footer {
            background: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            clear: both;
        }
        .footer-text {
            margin: 0;
            font-size: 11px;
        }
        .qr-code {
            text-align: center;
            margin: 10px 0;
        }
        .qr-placeholder {
            display: inline-block;
            width: 60px;
            height: 60px;
            background: #e9ecef;
            border: 1px dashed #dee2e6;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 9px;
        }
        .important-notes {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
        }
        .notes-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 5px;
            font-size: 11px;
        }
        .notes-list {
            margin: 0;
            padding-left: 15px;
            color: #856404;
            font-size: 10px;
        }
        .notes-list li {
            margin-bottom: 3px;
        }
        .two-column {
            display: flex;
            gap: 15px;
        }
        .column {
            flex: 1;
        }
        .compact-section {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                @if($admin && $admin->logo)
                    <img src="{{ public_path('storage/' . $admin->logo) }}" alt="Hospital Logo" class="logo">
                @else
                    <img src="{{ public_path('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}" alt="Hospital Logo" class="logo">
                @endif
                <div class="hospital-info">
                    <h1 class="hospital-name">{{ $admin->hospital_name ?? 'Hospital Name' }}</h1>
                    <div class="hospital-details">
                        @if($admin && $admin->email)
                            Email: {{ $admin->email }}<br>
                        @endif
                        @if($admin && $admin->phone)
                            Phone: {{ $admin->phone }}<br>
                        @endif
                        @if($admin && $admin->website)
                            Website: {{ $admin->website }}<br>
                        @endif
                        @if($admin && $admin->address)
                            Address: {{ $admin->address }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="invitation-code">
                Code: {{ $visit->invitation_code }}
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Visitor Information -->
            <div class="section">
                <h2 class="section-title">Visitor Information</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Visitor Name:</div>
                        <div class="info-value">{{ $visit->visitor_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Contact Number:</div>
                        <div class="info-value">{{ $visit->visitor_contact ?: 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $visit->visitor_email ?: 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Relation to Patient:</div>
                        <div class="info-value">{{ $visit->visitor_relation ?: 'N/A' }}</div>
                    </div>
                    @if($visit->contact_person_name)
                    <div class="info-row">
                        <div class="info-label">Contact Person:</div>
                        <div class="info-value">{{ $visit->contact_person_name }}</div>
                    </div>
                    @endif
                    @if($visit->contact_person_phone)
                    <div class="info-row">
                        <div class="info-label">Contact Person Phone:</div>
                        <div class="info-value">{{ $visit->contact_person_phone }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Visit Details -->
            <div class="section">
                <h2 class="section-title">Visit Details</h2>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Visit Type:</div>
                        <div class="info-value">{{ ucwords(str_replace('_', ' ', $visit->visit_type)) }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Scheduled Date & Time:</div>
                        <div class="info-value">{{ $visit->scheduled_visit ? $visit->scheduled_visit->format('F d, Y \a\t H:i') : 'Not Scheduled' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status:</div>
                        <div class="info-value">{{ ucwords(str_replace('_', ' ', $visit->status)) }}</div>
                    </div>
                    @if($visit->patient)
                    <div class="info-row">
                        <div class="info-label">Patient:</div>
                        <div class="info-value">{{ $visit->patient->name }} ({{ $visit->patient_mr_no ?: 'No MR' }})</div>
                    </div>
                    @endif
                    @if($visit->doctor)
                    <div class="info-row">
                        <div class="info-label">Doctor:</div>
                        <div class="info-value">{{ $visit->doctor->name }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Purpose -->
            @if($visit->purpose)
            <div class="section">
                <h2 class="section-title">Purpose of Visit</h2>
                <div class="purpose-section">
                    <p class="purpose-text">{{ $visit->purpose }}</p>
                </div>
            </div>
            @endif

        

            <!-- Important Notes -->
            <div class="important-notes">
                <h3 class="notes-title">Important Notes:</h3>
                <ul class="notes-list">
                    <li>Please arrive 15 minutes before your scheduled visit time</li>
                    <li>Bring a valid government-issued ID for verification</li>
                    <li>Follow all hospital safety protocols and guidelines</li>
                    <li>Parking information will be provided at the security desk</li>
                    <li>For any changes or cancellations, contact the hospital administration</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                This invitation is valid only for the specified date and time.
                Please keep this document safe and present it when requested.
            </p>
            <p class="footer-text" style="margin-top: 10px;">
                Generated on {{ now()->format('F d, Y \a\t H:i') }}
            </p>
        </div>
    </div>
</body>
</html>
