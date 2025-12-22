@php
use App\Models\Admin;
$admin = Admin::first();
$logoUrl = $admin && $admin->logo ? asset('storage/' . $admin->logo) : asset('image/default-logo.png');
$companyName = $admin ? $admin->hospital_name : 'Hospital CRM';
$companyEmail = $admin ? $admin->company_email : 'Hospital CRM';
$companyContact = $admin ? $admin->company_contact : 'Hospital CRM';
$companyAddress = $admin ? $admin->company_address : 'Hospital CRM';
$companyWebsite = $admin ? $admin->company_website : 'Hospital CRM';

$moduleName = ucwords(str_replace('_', ' ', $transaction->module));
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $companyName }}</title>
    <style>
        /* A4 PAGE SETTINGS */
        @page {
            size: A4 portrait;
            margin: 0.5cm;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
        }
        
        /* INVOICE CONTAINER */
        .invoice-container {
            padding: 20px;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }
        
        /* HEADER */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .company-section {
            flex: 1;
        }
        
        .logo {
            height: 60px;
            margin-bottom: 10px;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: #000;
        }
        
        .invoice-title-section {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #000;
        }
        
        .invoice-number {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }
        
        /* TRANSACTION INFO */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 15px 0;
        }
        
        .info-box {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 13px;
            font-weight: bold;
            color: #000;
        }
        
        /* STATUS BADGES */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .credit { background: #28a745; color: white; }
        .debit { background: #dc3545; color: white; }
        .paid { background: #17a2b8; color: white; }
        .pending { background: #ffc107; color: #000; }
        .cash { background: #6c757d; color: white; }
        .upi { background: #20c997; color: white; }
        .card { background: #6610f2; color: white; }
        
        /* AMOUNT TABLE */
        .amount-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 1px solid #ddd;
        }
        
        .amount-table th {
            background: #f8f9fa;
            padding: 8px;
            text-align: left;
            border-bottom: 2px solid #000;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .amount-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        
        .total-row {
            background: #f8f9fa;
            font-weight: bold;
            border-top: 2px solid #000;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* FOOTER */
        .invoice-footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .footer-section h4 {
            font-size: 11px;
            margin: 0 0 5px 0;
            color: #000;
            font-weight: bold;
        }
        
        .footer-section p {
            margin: 0;
            line-height: 1.3;
        }
        
        /* PRINT CONTROLS - SCREEN ONLY */
        @media screen {
            body {
                background: #f5f5f5;
                padding: 20px 0;
            }
            
            .invoice-container {
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            
            .print-controls {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                z-index: 1000;
            }
            
            .print-btn {
                background: #007bff;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 3px;
                cursor: pointer;
                font-size: 12px;
            }
        }
        
        @media print {
            .print-controls {
                display: none;
            }

            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .invoice-container {
                page-break-inside: avoid;
                margin: 0;
                padding: 10px;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Force color printing for all elements */
            .badge {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Ensure badges print in color with borders */
            .badge.credit {
                background: #28a745 !important;
                color: white !important;
                border: 1px solid #28a745 !important;
                -webkit-print-color-adjust: exact !important;
            }

            .badge.debit {
                background: #dc3545 !important;
                color: white !important;
                border: 1px solid #dc3545 !important;
                -webkit-print-color-adjust: exact !important;
            }

            .badge.paid {
                background: #17a2b8 !important;
                color: white !important;
                border: 1px solid #17a2b8 !important;
                -webkit-print-color-adjust: exact !important;
            }

            .badge.pending {
                background: #ffc107 !important;
                color: #000 !important;
                border: 1px solid #ffc107 !important;
                -webkit-print-color-adjust: exact !important;
            }

            .badge.cash {
                background: #6c757d !important;
                color: white !important;
                border: 1px solid #6c757d !important;
                -webkit-print-color-adjust: exact !important;
            }

            .badge.upi {
                background: #20c997 !important;
                color: white !important;
                border: 1px solid #20c997 !important;
                -webkit-print-color-adjust: exact !important;
            }

            .badge.card {
                background: #6610f2 !important;
                color: white !important;
                border: 1px solid #6610f2 !important;
                -webkit-print-color-adjust: exact !important;
            }

            /* Prevent page breaks */
            .invoice-header,
            .info-grid,
            .amount-table,
            .invoice-footer {
                page-break-inside: avoid;
            }

            /* Adjust font sizes for better fit */
            body {
                font-size: 11px;
            }

            .company-name {
                font-size: 18px;
            }

            .invoice-title {
                font-size: 24px;
            }
        }
        
        /* UTILITIES */
        .mt-10 { margin-top: 10px; }
        .mb-10 { margin-bottom: 10px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<!-- Print Controls (Screen Only) -->
<div class="print-controls">
    <button class="print-btn" onclick="window.print()">Print Invoice</button>
</div>

<div class="invoice-container">
    <!-- Header -->
    <div class="invoice-header">
        <div class="company-section">
            <img src="{{ $logoUrl }}" alt="{{ $companyName }}" class="logo"
                 onerror="this.src='{{ asset('image/default-logo.png') }}'">
            <h1 class="company-name">{{ $companyName }}</h1>
            <p style="font-size: 12px; color: #333; margin: 5px 0 0 0; font-weight: normal;">
                  Contact : {{$companyContact }}
            </p>
              <p style="font-size: 12px; color: #333; margin: 5px 0 0 0; font-weight: normal;">
                  Email : {{$companyEmail }}
            </p>
            <p style="font-size: 11px; color: #333; margin: 5px 0 0 0;">
               Address : {{ $companyAddress }}
            </p>
        </div>
        
        <div class="invoice-title-section">
            <h2 class="invoice-title">INVOICE</h2>
            <p class="invoice-number">INV-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p style="font-size: 11px; margin: 5px 0 0 0;">
                Date: {{ ($transaction->transaction_date ?? $transaction->created_at)->format('d/m/Y') }}<br>
                Time: {{ ($transaction->transaction_date ?? $transaction->created_at)->format('h:i A') }}
            </p>
        </div>
    </div>
    
    <!-- Transaction Information -->
    <div class="info-grid">
        <div class="info-box">
            <div class="info-label">Transaction Type</div>
            <div class="info-value">
                <span class="badge {{ $transaction->transaction_type }}">
                    {{ strtoupper($transaction->transaction_type) }}
                </span>
            </div>
        </div>
        
        <div class="info-box">
            <div class="info-label">Payment Status</div>
            <div class="info-value">
                <span class="badge {{ $transaction->status }}">
                    {{ strtoupper($transaction->status) }}
                </span>
            </div>
        </div>
        
        <div class="info-box">
            <div class="info-label">Payment Mode</div>
            <div class="info-value">
                <span class="badge {{ $transaction->payment_mode }}">
                    {{ strtoupper($transaction->payment_mode) }}
                </span>
            </div>
        </div>
        
        <div class="info-box">
            <div class="info-label">Health</div>
            <div class="info-value">{{ $moduleName }}</div>
        </div>
    </div>
    
    <!-- Transaction Details -->
    <table class="amount-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="35%">Description</th>
                <th width="15%">Health</th>
                <th width="15%">Type</th>
                <th width="15%">Payment Mode</th>
                <th width="15%" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    {{ $moduleName }} Transaction<br>
                    <small style="color: #666; font-size: 10px;">
                        ID: {{ $transaction->transaction_id ?? 'N/A' }}
                    </small>
                </td>
                <td>{{ $moduleName }}</td>
                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                <td>{{ ucfirst($transaction->payment_mode) }}</td>
                <td class="text-right">₹{{ number_format($transaction->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <!-- Amount Summary -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="padding: 8px; text-align: right; font-weight: bold;">Subtotal:</td>
            <td style="padding: 8px; width: 100px; text-align: right; font-weight: bold;">
                ₹{{ number_format($transaction->amount, 2) }}
            </td>
        </tr>
        
        @if($transaction->tax)
        <tr>
            <td style="padding: 8px; text-align: right; font-weight: bold;">Tax:</td>
            <td style="padding: 8px; width: 100px; text-align: right; font-weight: bold;">
                ₹{{ number_format($transaction->tax, 2) }}
            </td>
        </tr>
        @endif
        
        @if($transaction->discount)
        <tr>
            <td style="padding: 8px; text-align: right; font-weight: bold;">Discount:</td>
            <td style="padding: 8px; width: 100px; text-align: right; font-weight: bold;">
                -₹{{ number_format($transaction->discount, 2) }}
            </td>
        </tr>
        @endif
        
        <tr style="background: #f8f9fa; border-top: 2px solid #000;">
            <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 14px;">TOTAL:</td>
            <td style="padding: 10px; text-align: right; font-weight: bold; font-size: 14px;">
                ₹{{ number_format($transaction->total_amount ?? $transaction->amount, 2) }}
            </td>
        </tr>
    </table>
    
    <!-- Status Note -->
    <div style="margin-top: 20px; padding: 10px; background: #f8f9fa; border-left: 4px solid #007bff;">
        <strong>Status:</strong> This transaction is marked as <strong>{{ strtoupper($transaction->status) }}</strong> 
        and was processed via <strong>{{ strtoupper($transaction->payment_mode) }}</strong>.
    </div>
    
    <!-- Footer -->
    <div class="invoice-footer">
        <div class="footer-grid">
            <div class="footer-section">
                <h4>Notes</h4>
                <p>
                    • Payment due within 30 days<br>
                    • Please quote invoice number<br>
                    • Contact for any queries
                </p>
            </div>
            
            <div class="footer-section">
                <h4>Contact</h4>
                <p>
                    {{ $companyName }}<br>
                    Email:{{ $companyEmail }}<br>
                    Phone:{{ $companyContact }}<br>
                    Website:{{ $companyWebsite }}
                </p>
            </div>
            
            <div class="footer-section">
                <h4>Invoice Details</h4>
                <p>
                    Invoice: INV-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}<br>
                    Generated: {{ now()->timezone('Asia/Kolkata')->format('d/m/Y H:i') }}<br>
                    Transaction: {{ $transaction->transaction_id ?? 'N/A' }}
                </p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 10px; padding-top: 10px; border-top: 1px solid #ddd;">
            <p style="font-size: 9px; color: #999; margin: 0;">
                This is a computer-generated invoice. No signature required.<br>
                Thank you for your business with {{ $companyName }}
            </p>
        </div>
    </div>
</div>

<script>
// Format currency numbers
document.addEventListener('DOMContentLoaded', function() {
    // Find all elements with ₹ symbol and format them
    const elements = document.querySelectorAll('td, .info-value, .footer-section p');
    elements.forEach(el => {
        const text = el.textContent;
        if (text.includes('₹')) {
            const matches = text.match(/₹(\d+(?:\.\d{2})?)/g);
            if (matches) {
                let newText = text;
                matches.forEach(match => {
                    const amount = match.replace('₹', '');
                    const num = parseFloat(amount);
                    if (!isNaN(num)) {
                        const formatted = '₹' + num.toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        newText = newText.replace(match, formatted);
                    }
                });
                el.textContent = newText;
            }
        }
    });
    
    // Auto print after 1 second (optional)
    // setTimeout(() => {
    //     window.print();
    // }, 1000);
});

// Handle print events
window.addEventListener('afterprint', function() {
    // You can add any post-print actions here
    console.log('Invoice printed successfully');
});
</script>

</body>
</html>