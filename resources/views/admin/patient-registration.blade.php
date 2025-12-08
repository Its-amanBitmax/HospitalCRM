<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patient Registration - {{ $admin->hospital_name ?? 'Hospital' }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #0d9488;
      --primary-light: #ccfbf1;
      --text: #1f2937;
      --text-light: #4b5563;
      --border: #e5e7eb;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    @page { size: A4; margin: 0; }

    @media print {
      body, html { 
        margin: 0; 
        padding: 0; 
        height: 100%; 
        background: white;
      }
      .no-print, .action-bar { display: none !important; }
      .page-frame {
        box-shadow: none !important;
        margin: 0 !important;
        border-radius: 0 !important;
      }
      .container { 
        width: 210mm !important; 
        height: 297mm !important; 
        padding: 15mm 12mm !important; 
        box-shadow: none; 
        border-radius: 0; 
        margin: 0 auto;
        background: white;
      }
      input, textarea { 
        border: 1px dotted #666 !important; 
        background: white !important; 
        font-size: 12px !important;
      }
      .section h2::after { display: none; }
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f1f5f9;
      color: var(--text);
      font-size: 12.5px;
      line-height: 1.5;
      padding: 0;
    }

    /* PAGE FRAME – to simulate real printed page look */
    .page-frame {
      width: 210mm;
      height: 297mm;
      margin: 20px auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 0 1px #e5e7eb, 0 4px 18px rgba(0,0,0,0.12);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      width: 190mm;
      height: 277mm;
      background: white;
      border-radius: 8px;
      padding: 15px 18px;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Header */
    .header {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 10px; padding-bottom: 8px;
      border-bottom: 1.5px solid var(--primary-light);
    }

    .logo {
      width: 75px; height: 75px;
      background: white; border: 2.8px solid var(--primary);
      border-radius: 50%; display: flex; align-items: center;
      justify-content: center; font-weight: 700; font-size: 11.5px;
      color: var(--primary); box-shadow: 0 2px 6px rgba(13,148,136,0.2);
    }

    .hospital-info {
      text-align: right; font-size: 10.8px; color: var(--text-light);
    }

    .hospital-info h1 {
      font-size: 16.5px; font-weight: 700; color: var(--primary); margin: 0;
      line-height: 1.2;
    }

    .form-title {
      text-align: center; font-size: 16px; font-weight: 700;
      color: var(--primary); margin: 8px 0 3px; text-transform: uppercase;
    }

    .form-subtitle {
      text-align: center; font-size: 10.5px; color: var(--text-light);
      margin-bottom: 10px; font-style: italic;
    }

    .section { margin: 9px 0; }

    .section h2 {
      font-size: 13px; font-weight: 600; color: var(--primary);
      margin-bottom: 5px; padding-bottom: 2px;
      border-bottom: 1.5px solid var(--primary-light);
      position: relative;
    }

    .section h2::after {
      content: ''; position: absolute; bottom: -1.5px; left: 0;
      width: 36px; height: 2px; background: var(--primary);
    }

    .form-row {
      display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 6px;
      align-items: center;
    }

    .form-group { flex: 1; min-width: 180px; }

    .form-group label {
      display: block; font-weight: 500; color: var(--text);
      margin-bottom: 2px; font-size: 11.8px;
    }

    input[type="text"], textarea {
      width: 100%; padding: 10.5px 7px; border: 1.3px solid var(--border);
      border-radius: 4px; font-size: 12px; background: #fff;
      transition: border 0.2s;
    }

    input:focus, textarea:focus {
      outline: none; border-color: var(--primary);
      background: #f0fdfa;
    }

    textarea { resize: none; height: 36px; }

    .radio-group {
      display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
    }

    .radio-item {
      display: flex; align-items: center; gap: 4px;
      font-size: 12px; color: var(--text);
    }

    .radio-item input[type="radio"] {
      accent-color: var(--primary); width: 25px; height: 25px;
    }

    .age-group { display: flex; align-items: center; gap: 4px; }
    .age-group input { width: 58px; }
    .age-group span { font-size: 12px; color: var(--text-light); }

    .declaration {
      background: #f0fdfa; border-left: 3px solid var(--primary);
      padding: 7px 9px; margin: 10px 0 8px 0;
      border-radius: 0 5px 5px 0; font-size: 10.8px;
      line-height: 1.45; page-break-inside: avoid;
    }

    .signature-row {
      display: flex; justify-content: space-between;
      margin: 10px 0 8px 0; gap: 10px;
      page-break-inside: avoid;
    }

    .sig-box { flex: 1; text-align: center; }
    .sig-label { font-weight: 500; font-size: 11.5px; margin-bottom: 5px; }
    .sig-line { border-bottom: 1.2px solid #1f2937; width: 72%; margin: 0 auto; padding-top: 14px; }

    /* Action Bar - RIGHT SIDE */
    .action-bar {
      position: fixed;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      display: flex;
      flex-direction: column;
      gap: 8px;
      z-index: 1000;
      background: white;
      padding: 8px 10px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn {
      padding: 6px 10px;
      font-size: 11.5px;
      font-weight: 600;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.2s;
      color: white;
    }

    .btn-primary { background: var(--primary); }
    .btn-secondary { background: #64748b; }
    .btn-back { background: #e11d48; }

    .btn:hover { opacity: 0.9; transform: translateY(-1px); }
  </style>
</head>
<body>

<!-- Right-side Action Bar -->
<div class="action-bar no-print">
  <button class="btn btn-back" onclick="goBack()">Back</button>
  <button class="btn btn-primary" onclick="window.print()">Print</button>
  <button class="btn btn-secondary" onclick="downloadPDF()">PDF</button>
</div>

<div class="page-frame">
  <div class="container" id="form-content">
    <div>
      <div class="header">
        <div class="logo">
        @if(optional($admin)->logo)
    <img src="{{ asset('storage/' . $admin->logo) }}"
         alt="Logo"
         style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
@else
    CCH
@endif

        </div>
        <div class="hospital-info">
    <h1>{{ $admin->hospital_name ?? 'Hospital Name' }}</h1>
    <p>{{ $admin->company_address ?? 'Address' }}</p>
    <p>Phone: {{ $admin->company_contact ?? 'Phone' }} | Email: {{ $admin->company_email ?? 'Email' }}</p>
</div>

      </div>

      <div class="form-title">PATIENT REGISTRATION FORM</div>
      <div class="form-subtitle">All fields required</div>

      <div class="section">
        <h2>Personal Information</h2>
        <div class="form-row">
          <div class="form-group"><label>Patient Name</label><input type="text"></div>
          <div class="form-group"><label>Age</label><input type="text"></div>
          <div class="form-group"><label>Blood Group</label><input type="text"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Gender</label>
            <div class="radio-group">
              <div class="radio-item"><input type="radio" name="gender"><label>Male</label></div>
              <div class="radio-item"><input type="radio" name="gender"><label>Female</label></div>
              <div class="radio-item"><input type="radio" name="gender"><label>Other</label></div>
            </div>
          </div>
          <div class="form-group"><label>Father / Spouse</label><input type="text"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Mobile No</label><input type="text"></div>
          <div class="form-group"><label>Alternate No</label><input type="text"></div>
        </div>
      </div>

      <div class="section">
        <h2>Address Details</h2>
        <div class="form-row">
          <div class="form-group"><label>Full Address</label><input type="text"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>City</label><input type="text"></div>
          <div class="form-group"><label>State</label><input type="text"></div>
          <div class="form-group"><label>PIN</label><input type="text"></div>
        </div>
      </div>

      <div class="section">
        <h2>Visit Details</h2>
        <div class="form-row">
          <div class="form-group"><label>Visit Type</label>
            <div class="radio-group">
              <div class="radio-item"><input type="radio" name="visit"><label>OPD</label></div>
              <div class="radio-item"><input type="radio" name="visit"><label>Emergency</label></div>
              <div class="radio-item"><input type="radio" name="visit"><label>Appointment</label></div>
            </div>
          </div>
          <div class="form-group"><label>Date</label><input type="text"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Chief Complaint</label><textarea></textarea></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Referred By</label><input type="text"></div>
          <div class="form-group"><label>Department</label><input type="text"></div>
        </div>
      </div>

      <div class="section">
        <h2>ID Proof</h2>
        <div class="form-row">
          <div class="form-group"><label>Type</label><input type="text"></div>
          <div class="form-group"><label>Number</label><input type="text"></div>
        </div>
      </div>

      <div class="declaration">
        <strong>Declaration:</strong> I declare all information is correct. I authorize {{ $admin->hospital_name ?? 'Hospital' }} to use my details for treatment and records.
      </div>
    </div>

    <div class="signature-row">
      <div class="sig-box"><div class="sig-label">Date</div><div class="sig-line"></div></div>
      <div class="sig-box"><div class="sig-label">Patient / Guardian</div><div class="sig-line"></div></div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
  function downloadPDF() {
    const element = document.getElementById('form-content');
    if (!element) {
      alert('Form content not found. Please try again.');
      return;
    }

    const actionBar = document.querySelector('.action-bar');
    if (actionBar) {
      actionBar.style.display = 'none';
    }

    const opt = {
      margin: [5, 5, 5, 5], // Add small margins for better printing
      filename: 'Patient_Registration_{{ $admin->hospital_name ?? 'Hospital' }}.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff',
        allowTaint: true,
        letterRendering: true
      },
      jsPDF: {
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait',
        compress: true
      }
    };

    html2pdf().set(opt).from(element).save().then(() => {
      if (actionBar) {
        actionBar.style.display = 'flex';
      }
      console.log('PDF downloaded successfully');
    }).catch((error) => {
      console.error('PDF generation failed:', error);
      alert('Failed to generate PDF. Please try again.');
      if (actionBar) {
        actionBar.style.display = 'flex';
      }
    });
  }

  function goBack() {
    window.history.back();
  }
</script>
</body>
</html>