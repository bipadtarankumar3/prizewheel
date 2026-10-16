<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ Auth::user()->name ?? 'Store' }} - Print QR Standee | PrizeWheel</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="{{asset('adminAssets/css/style.min.css')}}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

  <!-- Core Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <style>
    :root {
      --primary: #ff6b00;
      --primary-dark: #ea580c;
      --success: #10b981;
      --success-dark: #059669;
      --slate-900: #0f172a;
      --slate-800: #1e293b;
      --slate-700: #334155;
      --slate-500: #64748b;
      --border: #e2e8f0;
      --bg-page: #f8fafc;
    }

    * {
      box-sizing: border-box;
      -webkit-font-smoothing: antialiased;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-page);
      background-image: 
        radial-gradient(rgba(148, 163, 184, 0.2) 1px, transparent 1px),
        linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
      background-size: 24px 24px, 100% 100%;
      background-attachment: fixed;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      color: var(--slate-900);
      overflow-x: hidden;
    }

    /* Studio Top Navbar - Crisp White Glassmorphism */
    .studio-topbar {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
      box-shadow: 0 4px 20px -5px rgba(15, 23, 42, 0.05);
      padding: 12px 24px;
      transition: all 0.3s ease;
    }

    .studio-brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      padding: 6px 14px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 700;
      color: var(--slate-800);
    }

    .pulse-dot {
      width: 8px;
      height: 8px;
      background: #10b981;
      border-radius: 50%;
      box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
      animation: pulseGreen 2s infinite;
    }

    @keyframes pulseGreen {
      0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
      70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
      100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Buttons */
    .btn-studio {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      cursor: pointer;
      text-decoration: none;
      border: none;
    }

    .btn-studio:hover {
      transform: translateY(-2px);
    }

    .btn-studio:active {
      transform: translateY(0);
    }

    .btn-studio-back {
      background: #ffffff;
      color: var(--slate-700);
      border: 1px solid var(--border);
      box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
    }

    .btn-studio-back:hover {
      background: #f8fafc;
      color: var(--slate-900);
      border-color: #cbd5e1;
    }

    .btn-studio-print {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    }

    .btn-studio-print:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.45);
      color: #ffffff;
    }

    .btn-studio-download {
      background: linear-gradient(135deg, #ff7a00 0%, #ea580c 100%);
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(255, 122, 0, 0.3);
    }

    .btn-studio-download:hover {
      background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
      box-shadow: 0 6px 20px rgba(255, 122, 0, 0.45);
      color: #ffffff;
    }

    .btn-studio-ghost {
      background: #ffffff;
      color: var(--slate-700);
      border: 1px solid var(--border);
    }

    .btn-studio-ghost:hover {
      background: #f1f5f9;
      color: var(--slate-900);
    }

    /* Main Showcase Canvas */
    .studio-canvas {
      padding: 40px 16px 60px;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Standee Physical Mockup Card */
    .standee-mockup-wrapper {
      position: relative;
      margin: 0 auto;
      max-width: 400px;
      width: 100%;
    }

    /* Warm Ambient Lighting Under Standee */
    .standee-glow {
      position: absolute;
      top: 25%;
      left: 50%;
      transform: translate(-50%, 0);
      width: 85%;
      height: 60%;
      background: radial-gradient(circle, rgba(255, 183, 3, 0.2) 0%, rgba(255, 107, 0, 0.08) 50%, transparent 80%);
      filter: blur(40px);
      z-index: 1;
      pointer-events: none;
    }

    /* The Standee Box */
    .standee-card {
      position: relative;
      z-index: 2;
      width: 100%;
      aspect-ratio: 600 / 1243;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 
        0 25px 50px -12px rgba(15, 23, 42, 0.18),
        0 8px 20px -6px rgba(15, 23, 42, 0.1),
        0 0 0 1px rgba(15, 23, 42, 0.08);
      background: #ffffff;
      transform: translateZ(0);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .standee-card:hover {
      transform: translateY(-4px);
      box-shadow: 
        0 35px 65px -15px rgba(15, 23, 42, 0.22),
        0 12px 25px -6px rgba(15, 23, 42, 0.12),
        0 0 0 1px rgba(15, 23, 42, 0.12);
    }

    /* Standee Graphic Background */
    .standee-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      z-index: 1;
    }

    /* Acrylic Glass Reflection Effect */
    .standee-glass-shine {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 40%;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0.06) 40%, transparent 70%);
      pointer-events: none;
      z-index: 10;
    }

    /* Slot 1: Store Logo */
    .standee-logo-slot {
      position: absolute;
      top: 31%;
      left: 50%;
      transform: translateX(-50%);
      width: 62%;
      height: 14.5%;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 5;
    }

    .standee-logo-img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.12));
    }

    .standee-logo-placeholder {
      background: #ffffff;
      padding: 10px 18px;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      font-weight: 800;
      font-size: 15px;
      color: #0f172a;
      text-align: center;
      border: 1px solid #e2e8f0;
      max-width: 90%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* Slot 2: QR Code */
    .standee-qr-slot {
      position: absolute;
      top: 48.5%;
      left: 50%;
      transform: translateX(-50%);
      width: 56%;
      max-width: 230px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 5;
    }

    .standee-qr-frame {
      background: #ffffff;
      padding: 7px;
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.14);
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .standee-qr-frame svg,
    .standee-qr-frame img {
      width: 100% !important;
      height: auto !important;
      display: block;
      border-radius: 6px;
    }

    /* Acrylic Pedestal Stand Base */
    .standee-acrylic-base {
      position: relative;
      z-index: 3;
      margin: -6px auto 0;
      width: 82%;
      height: 16px;
      background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 70%, #cbd5e1 100%);
      border-radius: 0 0 14px 14px;
      border: 1px solid #cbd5e1;
      border-top: none;
      box-shadow: 
        0 14px 25px -4px rgba(15, 23, 42, 0.14),
        inset 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    /* Side / Info Panels - Bright & Modern */
    .studio-panel {
      background: #ffffff;
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 26px;
      box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.05);
    }

    .studio-panel-title {
      font-size: 17px;
      font-weight: 800;
      color: var(--slate-900);
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .spec-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      padding: 14px 16px;
      background: #f8fafc;
      border: 1px solid #edf2f7;
      border-radius: 14px;
      margin-bottom: 12px;
      transition: all 0.2s ease;
    }

    .spec-item:hover {
      background: #f1f5f9;
      border-color: #e2e8f0;
      transform: translateX(2px);
    }

    .spec-icon {
      width: 38px;
      height: 38px;
      border-radius: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .spec-icon-blue { background: #eff6ff; color: #2563eb; }
    .spec-icon-amber { background: #fffbeb; color: #d97706; }
    .spec-icon-green { background: #ecfdf5; color: #059669; }

    .spec-content h6 {
      margin: 0 0 3px;
      font-size: 13.5px;
      font-weight: 700;
      color: var(--slate-900);
    }

    .spec-content p {
      margin: 0;
      font-size: 12.5px;
      color: var(--slate-500);
      line-height: 1.45;
    }

    .link-box {
      background: #f8fafc;
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 10px 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      margin-top: 10px;
    }

    .link-text {
      font-family: monospace;
      font-size: 12.5px;
      color: #0284c7;
      font-weight: 600;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* Print Specific Optimization - Guaranteed 1-Page Fit across A4, Letter, and Mobile */
    @page {
      size: portrait;
      margin: 0;
    }

    @media print {
      html, body {
        width: 100% !important;
        height: 100% !important;
        min-height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
        background: #ffffff !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      .no-print,
      .studio-topbar,
      .studio-panel,
      .standee-acrylic-base,
      .standee-glass-shine,
      .standee-glow,
      .standee-quick-actions,
      header,
      footer {
        display: none !important;
      }

      .studio-canvas {
        padding: 0 !important;
        margin: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100vw !important;
        max-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-sizing: border-box !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        page-break-after: avoid !important;
        break-after: avoid !important;
      }

      .studio-canvas > .row {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
      }

      .studio-canvas .col-12 {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
      }

      .standee-mockup-wrapper {
        max-width: 100% !important;
        width: 100% !important;
        height: 100% !important;
        margin: 0 auto !important;
        padding: 10mm 15mm !important;
        box-sizing: border-box !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }

      .standee-card {
        box-shadow: none !important;
        border: none !important;
        border-radius: 4px !important;
        overflow: hidden !important;
        margin: auto !important;
        width: min(118mm, 80vw) !important;
        max-height: min(244mm, 90vh) !important;
        aspect-ratio: 600 / 1243 !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        page-break-after: avoid !important;
        break-after: avoid !important;
      }

      .standee-qr-slot {
        max-width: none !important;
        width: 56% !important;
      }
    }

    /* Responsive Mobile Queries */
    @media (max-width: 991.98px) {
      .studio-topbar {
        padding: 10px 14px;
      }

      .studio-canvas {
        padding: 20px 12px 40px;
      }

      .standee-mockup-wrapper {
        max-width: 320px;
      }

      .btn-studio {
        padding: 8px 14px;
        font-size: 13px;
      }
    }

    @media (max-width: 575.98px) {
      .studio-topbar {
        padding: 10px 12px;
      }

      .studio-topbar-actions {
        width: auto;
        display: flex;
        align-items: center;
        gap: 6px;
      }

      .studio-canvas {
        padding: 16px 10px 40px;
      }

      .standee-mockup-wrapper {
        max-width: min(300px, 86vw);
      }

      .btn-studio {
        padding: 8px 12px;
        font-size: 12.5px;
      }

      .studio-panel {
        padding: 20px 16px;
      }
    }
  </style>
</head>

<body>

  @php
    $wheelUrl = str_replace('/public', '', URL::to("u/".(Auth::user()->name_url ?? 'store')));
  @endphp

  <!-- Studio Topbar Controls (Hidden on Print) -->
  <header class="studio-topbar no-print">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
      
      <!-- Left: Back & Breadcrumb -->
      <div class="d-flex align-items-center gap-2">
        <a href="{{ URL::to('admin/dashboard') }}" class="btn-studio btn-studio-back">
          <i class="fa-solid fa-arrow-left"></i>
          <span class="d-none d-sm-inline">Dashboard</span>
        </a>

        <div class="studio-brand-badge d-none d-md-inline-flex">
          <span class="pulse-dot"></span>
          <span>{{ Auth::user()->name ?? 'Store Standee' }}</span>
        </div>
      </div>

      <!-- Right: Action Bar -->
      <div class="d-flex align-items-center gap-2 studio-topbar-actions">
        <!-- Quick Print Action in Topbar -->
        

        <!-- Direct Customer Wheel Test -->
        <a href="{{ $wheelUrl }}" target="_blank" class="btn-studio btn-studio-ghost py-2 px-3" style="font-size: 13px;" title="Test your live prize wheel in customer view">
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
          <span class="d-none d-md-inline">Test Wheel</span>
        </a>
      </div>

    </div>
  </header>

  <!-- Studio Canvas -->
  <main class="studio-canvas">
    <div class="row align-items-center g-4 justify-content-center">
      
      <!-- Left Column: Realistic Standee Mockup -->
      <div class="col-12 col-lg-6 d-flex flex-column align-items-center">
        
        <div class="standee-mockup-wrapper">
          <!-- Background Glow Effect -->
          <div class="standee-glow"></div>

          <!-- Standee Graphic Card -->
          <div class="standee-card" id="qr_box">
            <!-- Full Bleed Standee Artwork -->
            <img src="{{ asset('frontend/images/qr.jpg') }}" class="standee-bg" alt="Prize Wheel Standee Graphic" />

            <!-- Acrylic Sheen Reflection -->
            <div class="standee-glass-shine"></div>

            <!-- Slot 1: Store Logo -->
            <div class="standee-logo-slot">
              @if(!empty(Auth::user()->logo))
                <img src="{{ Auth::user()->logo }}" alt="{{ Auth::user()->name ?? 'Store Logo' }}" class="standee-logo-img" />
              @else
                <div class="standee-logo-placeholder">
                  {{ Auth::user()->name ?? 'Prize Wheel' }}
                </div>
              @endif
            </div>

            <!-- Slot 2: High Resolution QR Code -->
            <div class="standee-qr-slot">
              <div class="standee-qr-frame">
                {!! QrCode::size(240)->margin(0)->generate($wheelUrl) !!}
              </div>
            </div>
          </div>

          <!-- Physical Stand Pedestal Base -->
          <div class="standee-acrylic-base no-print"></div>
        </div>

        <!-- Quick Primary Action Buttons (Immediately accessible under standee on mobile & desktop) -->
        <div class="standee-quick-actions no-print mt-3 w-100" style="max-width: 380px;">
          <div class="row g-2 justify-content-center">
            <div class="col-6">
              <button type="button" onclick="window.print()" class="btn-studio btn-studio-print w-100 py-2.5" style="font-size: 13.5px;" title="Print this standee on A4 or Letter paper">
                <i class="fa-solid fa-print"></i> <span>Print Standee</span>
              </button>
            </div>
            <div class="col-6">
              <button type="button" onclick="downloadStandeeImage()" class="btn-studio btn-studio-download w-100 py-2.5" style="font-size: 13.5px;" title="Download high resolution poster as PNG image">
                <i class="fa-solid fa-cloud-arrow-down"></i> <span>Download PNG</span>
              </button>
            </div>
          </div>
        </div>

        <p class="text-muted text-center mt-2 mb-0 no-print" style="font-size: 12.5px;">
          <i class="fa-solid fa-circle-check me-1 text-success"></i> 
          Proportionally locked for single-page A4, Letter, and Acrylic table standees.
        </p>

      </div>

      <!-- Right Column: Standee Specifications & Recommendations (Hidden on Print) -->
      <div class="col-12 col-lg-5 no-print">
        <div class="studio-panel">
          
          <div class="studio-panel-title">
            <i class="fa-solid fa-sliders text-primary"></i>
            <span>Display & Print Guide</span>
          </div>

          <div class="spec-item">
            <div class="spec-icon spec-icon-amber">
              <i class="fa-solid fa-expand"></i>
            </div>
            <div class="spec-content">
              <h6>Recommended Display Format</h6>
              <p>Ideal for <strong>A4 (8.3" × 11.7")</strong> or <strong>A5 (5.8" × 8.3")</strong> acrylic T-stand, wooden menu holder, or counter display.</p>
            </div>
          </div>

          <div class="spec-item">
            <div class="spec-icon spec-icon-blue">
              <i class="fa-solid fa-print"></i>
            </div>
            <div class="spec-content">
              <h6>Paper Recommendation</h6>
              <p>Print on <strong>250–300 GSM Glossy Cardstock</strong> or photo paper for vibrant, photo-lab quality colors.</p>
            </div>
          </div>

          <div class="spec-item">
            <div class="spec-icon spec-icon-green">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="spec-content">
              <h6>Strategic Placement</h6>
              <p>Place on reception counters, billing desks, or dining tables to drive customer engagement and lead captures.</p>
            </div>
          </div>

          <!-- Live Wheel URL Bar -->
          <div class="mt-4">
            <label class="text-muted fw-bold d-block mb-1" style="font-size: 11.5px; letter-spacing: 0.5px; text-transform: uppercase;">
              Direct Wheel Link:
            </label>
            <div class="link-box">
              <span class="link-text" id="liveWheelUrlText">{{ $wheelUrl }}</span>
              <button type="button" onclick="copyWheelUrl()" class="btn btn-sm btn-outline-secondary rounded-2 px-2.5 py-1" style="font-size: 11.5px;">
                <i class="fa-regular fa-copy me-1"></i> Copy
              </button>
            </div>
          </div>

          <!-- Secondary Action Buttons -->
          <!-- <div class="row g-2 mt-4">
            <div class="col-6">
              <button type="button" onclick="window.print()" class="btn-studio btn-studio-print w-100 py-2.5" style="font-size: 13.5px;" title="Print this standee on A4 or Letter paper">
                <i class="fa-solid fa-print"></i> <span>Print Standee</span>
              </button>
            </div>
            <div class="col-6">
              <button type="button" onclick="downloadStandeeImage()" class="btn-studio btn-studio-download w-100 py-2.5" style="font-size: 13.5px;" title="Download high resolution poster as PNG image">
                <i class="fa-solid fa-cloud-arrow-down"></i> <span>Download PNG</span>
              </button>
            </div>
          </div> -->

        </div>
      </div>

    </div>
  </main>

  <script>
    // Copy Live Wheel URL
    function copyWheelUrl() {
      var url = "{{ $wheelUrl }}";
      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(function() {
          toastr.success("Wheel link copied to clipboard!");
        });
      } else {
        var tempInput = document.createElement("input");
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        toastr.success("Wheel link copied to clipboard!");
      }
    }

    // High Resolution PNG Downloader using HTML2Canvas
    function downloadStandeeImage() {
      var element = document.getElementById("qr_box");
      var btns = document.querySelectorAll(".btn-studio-download");
      var originalHtmls = [];

      btns.forEach(function(btn) {
        originalHtmls.push(btn.innerHTML);
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Exporting...</span>';
        btn.style.pointerEvents = 'none';
      });

      // Temporarily hide shine overlay during high-res canvas render
      var shine = element.querySelector('.standee-glass-shine');
      if (shine) shine.style.display = 'none';

      html2canvas(element, {
        scale: 3, // 3x Ultra-sharp 300DPI export
        useCORS: true,
        allowTaint: true,
        backgroundColor: '#ffffff',
        logging: false
      }).then(function(canvas) {
        if (shine) shine.style.display = 'block';

        var link = document.createElement("a");
        var storeName = "{{ Str::slug(Auth::user()->name ?? 'prize-wheel') }}";
        link.download = storeName + "-qr-standee.png";
        link.href = canvas.toDataURL("image/png");
        link.click();

        btns.forEach(function(btn, idx) {
          btn.innerHTML = originalHtmls[idx];
          btn.style.pointerEvents = 'auto';
        });
        toastr.success("High-resolution PNG downloaded!");
      }).catch(function(err) {
        if (shine) shine.style.display = 'block';
        console.error(err);
        btns.forEach(function(btn, idx) {
          btn.innerHTML = originalHtmls[idx];
          btn.style.pointerEvents = 'auto';
        });
        toastr.error("Export failed. Please use the Print button instead.");
      });
    }
  </script>

</body>
</html>
