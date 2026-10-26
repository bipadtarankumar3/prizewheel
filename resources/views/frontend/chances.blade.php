<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      @if ($Camping->title_status == 'on')
      {{$Camping->title}}
      @else
      Prize Wheel
      @endif
    </title>

    @php
      $ogTitle = ($Camping->title_status == 'on' && !empty($Camping->title)) ? $Camping->title : 'Prize Wheel - Spin & Win!';
      $ogDesc = ($Camping->sub_title_status == 'on' && !empty($Camping->sub_title)) ? $Camping->sub_title : 'Spin the wheel now and win exciting prizes!';
      $rawLogo = !empty($user->logo) ? $user->logo : '';
      $ogImage = '';
      if (!empty($rawLogo)) {
          $ogImage = (filter_var($rawLogo, FILTER_VALIDATE_URL)) ? $rawLogo : url($rawLogo);
      }
      $ogUrl = url()->current();
    @endphp

    <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $ogUrl }}" />
    <meta property="og:title" content="{{ $ogTitle }}" />
    <meta property="og:description" content="{{ $ogDesc }}" />
    @if(!empty($ogImage))
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:image:secure_url" content="{{ $ogImage }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta property="og:image:alt" content="{{ $ogTitle }}" />
    @endif
    <meta property="og:site_name" content="Prize Wheel" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ $ogUrl }}" />
    <meta name="twitter:title" content="{{ $ogTitle }}" />
    <meta name="twitter:description" content="{{ $ogDesc }}" />
    @if(!empty($ogImage))
    <meta name="twitter:image" content="{{ $ogImage }}" />
    @endif

    <!-- jQuery & Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 

    <!-- Icons & Fonts -->
    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Winwheel & Animation Libraries -->
    <link rel="stylesheet" href="{{asset('frontend/spinner/wheel/main.css')}}?v={{filemtime(public_path('frontend/spinner/wheel/main.css'))}}" type="text/css" />
    <script type="text/javascript" src="{{asset('frontend/spinner/wheel/Winwheel.js')}}?v={{filemtime(public_path('frontend/spinner/wheel/Winwheel.js'))}}"></script>
    <script src="{{asset('frontend/spinner/wheel/TweenMax.min.js')}}?v={{filemtime(public_path('frontend/spinner/wheel/TweenMax.min.js'))}}"></script>
    <link rel='stylesheet' type='text/css' href='{{asset('frontend/spinner/wheel/rotation.css')}}?v={{filemtime(public_path('frontend/spinner/wheel/rotation.css'))}}' />	

    <link rel="stylesheet" href="{{asset('frontend/award/css/style.css')}}?v={{filemtime(public_path('frontend/award/css/style.css'))}}">
    <link rel="stylesheet" href="{{asset('frontend/spinner/style.css')}}?v={{filemtime(public_path('frontend/spinner/style.css'))}}">
    <link rel="stylesheet" href="{{asset('frontend/css/spinn_two/responsive.css')}}?v={{filemtime(public_path('frontend/css/spinn_two/responsive.css'))}}"> 
    <link rel="stylesheet" href="{{asset('frontend/css/spinn_two/my-style.css')}}?v={{filemtime(public_path('frontend/css/spinn_two/my-style.css'))}}">
    
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
      html, body {
        overflow-x: hidden !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
        height: auto !important;
      }

      body {
        font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        display: block !important;
      }

      body.default-bg {
        background-color: #faf5ea !important;
        background-image: 
          radial-gradient(rgba(217, 119, 6, 0.22) 1.4px, transparent 1.4px),
          linear-gradient(180deg, #fffdf8 0%, #faf3e0 45%, #f7ecd2 100%) !important;
        background-size: 26px 26px, 100% 100% !important;
        background-attachment: fixed !important;
      }

      /* Atom Particle Canvas & Glow Overlay */
      #atomCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
        filter: blur(4.5px);
        -webkit-filter: blur(4.5px);
        opacity: 0.78;
        transform: scale(1.03);
      }

      .bg-overlay {
        position: fixed;
        inset: 0;
        z-index: 0;
        background:
          radial-gradient(ellipse 70% 60% at 50% 15%, rgba(251, 191, 36, 0.18) 0%, transparent 70%),
          radial-gradient(ellipse 65% 55% at 20% 40%, rgba(245, 158, 11, 0.13) 0%, transparent 65%),
          radial-gradient(ellipse 60% 60% at 80% 65%, rgba(217, 119, 6, 0.11) 0%, transparent 65%),
          radial-gradient(ellipse 55% 50% at 50% 85%, rgba(253, 230, 138, 0.16) 0%, transparent 70%);
        pointer-events: none;
      }

      .main_page_wrapper {
        position: relative;
        z-index: 2;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 0;
        background: transparent;
      }

      /* Campaign Information Card */
      .campaign_hero_card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 25px 50px -15px rgba(15, 23, 42, 0.15), 0 0 1px 1px rgba(255, 255, 255, 0.8) inset;
        border-radius: 24px;
        padding: 22px 20px;
        max-width: 410px;
        margin: 0 auto;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .campaign_hero_card:hover {
        transform: translateY(-2px);
        box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.2), 0 0 1px 1px rgba(255, 255, 255, 0.9) inset;
      }

      /* Notice Banner */
      .notice_banner {
        display: flex;
        align-items: center;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 9999px;
        padding: 6px 14px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.06);
      }
      .notice_badge {
        background: #ef4444;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 9999px;
        margin-right: 10px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }
      .notice_scroll {
        overflow: hidden;
        white-space: nowrap;
        flex: 1;
      }
      .notice_scroll marquee {
        color: #b91c1c;
        font-weight: 600;
        font-size: 0.84rem;
        line-height: 1;
      }

      /* Brand Logo */
      .brand_logo_wrapper {
        text-align: center;
        margin-bottom: 16px;
      }
      .brand_logo_card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        padding: 10px 22px;
        border-radius: 18px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04), 0 0 0 1px rgba(15, 23, 42, 0.05);
      }
      .brand_logo_img {
        max-height: 60px;
        max-width: 170px;
        object-fit: contain;
      }

      /* Titles */
      .campaign_main_title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.02em;
        text-align: center;
      }
      .campaign_sub_title {
        font-size: 0.88rem;
        color: #64748b;
        margin-bottom: 20px;
        line-height: 1.45;
        text-align: center;
      }

      /* Meta Grid & Pills */
      .meta_cards_grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
      .meta_pill {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        border-radius: 14px;
        transition: all 0.2s ease;
      }
      .meta_pill:hover {
        background: #fff;
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
      }
      .meta_icon_circle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-right: 12px;
        flex-shrink: 0;
      }
      .meta_icon_validity {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
      }
      .meta_icon_spins {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
      }
      .meta_pill_content {
        display: flex;
        flex-direction: column;
        min-width: 0;
      }
      .meta_pill_label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 0.03em;
        line-height: 1.2;
      }
      .meta_pill_val {
        font-size: 0.86rem;
        font-weight: 700;
        color: #1e293b;
      }
      .meta_badge_number {
        color: #d97706;
        font-size: 0.98rem;
      }

      /* Wheel Interactive Box */
      .wheel_interactive_box {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin: 0 auto;
        text-align: center;
      }

      .the_wheel_wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 0 auto;
        position: relative;
      }

      div.the_wheel {
        position: relative !important;
        aspect-ratio: 1 / 1 !important;
        margin: 0 auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        filter: drop-shadow(0 25px 45px rgba(0, 0, 0, 0.28));
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      }
      div.the_wheel:hover {
        transform: scale(1.015);
      }

      #new_pin_div img {
        filter: drop-shadow(0 6px 14px rgba(0, 0, 0, 0.35));
      }

      /* CTA Spin Button */
      .wheel_cta_wrapper {
        text-align: center;
      }
      .spin_form_btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #fff !important;
        font-size: 1.12rem !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 14px 44px !important;
        border-radius: 9999px !important;
        border: none !important;
        box-shadow: 0 12px 25px -4px rgba(16, 185, 129, 0.5), 0 0 0 4px rgba(16, 185, 129, 0.15) !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
      }
      .spin_form_btn:not(:disabled) {
        animation: spinBtnPulse 2.4s infinite;
      }
      .spin_form_btn:hover:not(:disabled) {
        transform: translateY(-2px) scale(1.03) !important;
        box-shadow: 0 16px 32px -4px rgba(16, 185, 129, 0.65), 0 0 0 6px rgba(16, 185, 129, 0.22) !important;
      }
      .spin_form_btn:active:not(:disabled) {
        transform: translateY(1px) scale(0.98) !important;
      }
      .spin_form_btn:disabled {
        opacity: 0.65 !important;
        cursor: not-allowed !important;
        filter: grayscale(40%) !important;
        animation: none !important;
      }

      @keyframes spinBtnPulse {
        0%, 100% {
          box-shadow: 0 12px 25px -4px rgba(16, 185, 129, 0.5), 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        50% {
          box-shadow: 0 16px 35px -2px rgba(16, 185, 129, 0.7), 0 0 0 8px rgba(16, 185, 129, 0.28);
        }
      }

      /* Floating Share Button */
      .share_floating_bar {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1050;
      }
      .share_toggle_btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 9999px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
        cursor: pointer;
        transition: all 0.25s ease;
      }
      .share_toggle_btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px -4px rgba(15, 23, 42, 0.22);
      }
      .share_toggle_btn i {
        color: #3b82f6;
        font-size: 16px;
      }
      .share_options_menu {
        display: none;
        position: absolute;
        bottom: 100%;
        right: 0;
        margin-bottom: 12px;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 8px;
        box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.2);
        list-style: none;
      }
      .share_options_menu li { margin: 4px 0; }
      .share_options_menu a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        font-size: 18px;
        color: #ffffff !important;
        text-decoration: none;
        transition: transform 0.2s ease;
      }
      .share_options_menu a:hover { transform: scale(1.12); }
      .share_options_menu .wa_btn { background: #25d366; }
      .share_options_menu .fb_btn { background: #1877f2; }

      /* Background Blur when Modal is Open */
      body.modal-open .main_page_wrapper,
      body.modal-open #atomCanvas,
      body.modal-open .share_floating_bar {
        filter: blur(10px) brightness(0.92);
        -webkit-filter: blur(10px) brightness(0.92);
        transition: filter 0.35s ease, -webkit-filter 0.35s ease;
        pointer-events: none;
        user-select: none;
      }

      .modal-backdrop {
        background-color: rgba(15, 23, 42, 0.65) !important;
        backdrop-filter: blur(10px) saturate(130%) !important;
        -webkit-backdrop-filter: blur(10px) saturate(130%) !important;
      }
      .modal-backdrop.show {
        opacity: 1 !important;
      }

      /* Modals */
      .modal-dialog {
        z-index: 1060 !important;
      }
      .modal-content {
        border: none !important;
        border-radius: 28px !important;
        overflow: hidden !important;
        box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.4) !important;
        background: #ffffff !important;
      }
      #ReedemModal .modal-header,
      #FormModal .modal-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        padding: 20px 28px !important;
        border-bottom: none !important;
      }
      #ReedemModal .modal-title,
      #FormModal .modal-title {
        font-weight: 800 !important;
        font-size: 1.25rem !important;
        color: #ffffff !important;
      }
      .modal-header .close {
        color: #ffffff !important;
        opacity: 0.85 !important;
        text-shadow: none !important;
      }
      .modal-header .close:hover {
        opacity: 1 !important;
      }
      .modal-body {
        padding: 24px !important;
      }
      .FormModal .form-control {
        border-radius: 14px !important;
        border: 1.5px solid #e2e8f0 !important;
        padding: 12px 16px !important;
        height: auto !important;
        font-size: 0.95rem !important;
        color: #1e293b !important;
        transition: all 0.2s ease !important;
      }
      .FormModal .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
      }
      .FormModal label {
        font-size: 0.82rem !important;
        font-weight: 700 !important;
        color: #475569 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        margin-bottom: 6px !important;
      }
      .form_submit_button {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        color: #ffffff !important;
        font-weight: 800 !important;
        font-size: 1.05rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        border-radius: 9999px !important;
        padding: 14px 42px !important;
        border: none !important;
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.45) !important;
        transition: all 0.25s ease !important;
      }
      .form_submit_button:hover {
        transform: translateY(-2px) scale(1.02) !important;
        box-shadow: 0 14px 30px -4px rgba(37, 99, 235, 0.6) !important;
      }

      /* Celebration / Blast */
      .blast {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(15, 23, 42, 0.85) !important;
        backdrop-filter: blur(18px) !important;
        -webkit-backdrop-filter: blur(18px) !important;
        z-index: 99999 !important;
        opacity: 1 !important;
        display: none;
        align-items: center !important;
        justify-content: center !important;
        padding: 20px !important;
        margin: 0 !important;
      }
      .blast.show-blast, 
      .blast[style*="display: block"], 
      .blast[style*="display: flex"] {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        opacity: 1 !important;
      }
      .blast .content {
        margin: auto !important;
        background: #ffffff !important;
        opacity: 1 !important;
        border-radius: 32px !important;
        padding: 40px 32px !important;
        max-width: 440px !important;
        width: 92% !important;
        text-align: center !important;
        box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.3) inset !important;
        animation: modalPop 0.45s cubic-bezier(0.16, 1, 0.3, 1) !important;
        position: relative !important;
        z-index: 100000 !important;
      }
      @keyframes modalPop {
        0% { transform: scale(0.7) translateY(30px); opacity: 0; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
      }
      .blast .content .text h2 {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800 !important;
        font-size: 1.55rem !important;
        color: #0f172a !important;
        margin: 18px 0 8px 0 !important;
      }
      .blast .trophy_img {
        max-width: 120px !important;
        height: auto !important;
        filter: drop-shadow(0 15px 25px rgba(245, 158, 11, 0.45)) !important;
      }
      .blast .award_text {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800 !important;
        font-size: 1.55rem !important;
        color: #059669 !important;
        text-shadow: none !important;
        background: #ecfdf5 !important;
        border: 2px dashed #10b981 !important;
        border-radius: 20px !important;
        padding: 10px 24px !important;
        margin: 12px 0 20px 0 !important;
        display: inline-block !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15) !important;
      }
      .reedem-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #ffffff !important;
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800 !important;
        font-size: 1.15rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 14px 44px !important;
        border-radius: 9999px !important;
        border: none !important;
        box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.5) !important;
        transition: all 0.25s ease !important;
      }

      @media (max-width: 991.98px) {
        .main_page_wrapper {
          min-height: 100vh;
          display: block;
          padding: 12px 0 36px 0;
        }
        .spinner_col {
          margin-bottom: 24px !important;
          display: flex !important;
          flex-direction: column !important;
          align-items: center !important;
          justify-content: center !important;
          width: 100% !important;
        }
        div.the_wheel {
          width: min(86vw, 360px) !important;
          aspect-ratio: 1 / 1 !important;
          margin: 0 auto !important;
        }
      }
    </style>
</head>
<body 
  @if($user->default_background == 'color') style="background:{{$user->background_color}}" 
  @elseif($user->default_background == 'image' && !empty($user->background_image)) style="background:url('{{$user->background_image}}');background-repeat: no-repeat;background-size: cover;background-position: top;min-height: 100vh;" 
  @else class="default-bg"
  @endif >

  <!-- Component: Atom Particles Background Canvas -->
  @include('frontend.components.atom-canvas')

  <!-- Main Layout Wrapper -->
  <div class="main_page_wrapper">
    <div class="container py-3" id="cn_wheel_main_div">
      <div class="row align-items-center justify-content-center">
        <!-- Left Column: Campaign Hero Card Component -->
        <div class="col-xl-4 col-lg-5 col-md-10 col-12 text_col mb-4 mb-lg-0 order-2 order-lg-1">
          @include('frontend.components.campaign-card')
        </div>

        <!-- Right Column: Canvas Wheel (Chances Mode) Component -->
        <div class="col-xl-8 col-lg-7 col-12 spinner_col text-center order-1 order-lg-2">
          @include('frontend.components.wheel-chances')
        </div>
      </div>
    </div>
  </div>

  <!-- Component: Modern Floating Share Button -->
  @include('frontend.components.floating-share')

  <!-- Component: Winner Celebration Blast Overlay -->
  @include('frontend.components.blast-celebration')

  <!-- Component: Audio Sound Effects -->
  @include('frontend.components.audio-elements')

  <!-- Component: Redeem Modal -->
  @include('frontend.components.redeem-modal')

  <!-- Component: Form Details Modal -->
  @include('frontend.components.form-modal')

  <!-- Component: Promotional Popup Modal -->
  @include('frontend.components.popup-alert')

  <!-- Component: Preloader -->
  @include('frontend.components.preloader')

  <!-- SweetAlert & Award Scripts -->
  <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
  <script src="{{asset('frontend/award/js/blast.js')}}"></script>

  <!-- Chances Mode Wheel Script -->
  <script>
    var playing = false;

    function numOnly(selector) {
      const numericValue = selector.value.replace(/[^0-9]/g, '');
      $('.form_submit_button').attr('disabled','disabled');
      if (numericValue.length !== 10) {
        const errorMessageSpan = document.getElementById("phone_error");
        if (errorMessageSpan) errorMessageSpan.textContent = 'Enter Valid 10 Digit Number';
        selector.value = numericValue;
      } else {
        const errorMessageSpan = document.getElementById("phone_error");
        if (errorMessageSpan) errorMessageSpan.textContent = '';
        selector.value = numericValue;
        $('.form_submit_button').removeAttr('disabled');
      }
      var wpInput = document.getElementById('whatsapp_number');
      if (wpInput) {
        wpInput.value = numericValue;
      }
    }

    const spinFormTiming = "{{ $spin_form_timing ?? 'after_spin' }}";
    // Server-side source of truth: if no pending form record for this IP, clear stale sessionStorage
    @php $serverPreSpinId2 = $preSpinFormRecord ? $preSpinFormRecord->id : null; @endphp
    const serverPreSpinFormId2 = {{ $serverPreSpinId2 ? $serverPreSpinId2 : 'null' }};
    if (!serverPreSpinFormId2) {
      sessionStorage.removeItem('preSpinFormId_{{ $user->id }}');
      sessionStorage.removeItem('preSpinName_{{ $user->id }}');
      sessionStorage.removeItem('spin_completed_{{ $user->id }}');
    }
    let preSpinFormId = serverPreSpinFormId2 ? String(serverPreSpinFormId2) : (sessionStorage.getItem('preSpinFormId_{{ $user->id }}') || null);
    let submittedUserName = sessionStorage.getItem('preSpinName_{{ $user->id }}') || '';

    function openPreSpinModal() {
      $('#formModalTitle').html('<i class="fas fa-user-edit mr-2 text-primary"></i> Enter Details to Spin & Win');
      $('.winner-header-info').hide();
      $('.prespin-header-info').show();
      $('.take_screen_button').hide();
      $('#screenshot-preview-card').hide();
      $('.form_submit_button').show().html('<i class="fas fa-play-circle mr-1"></i> Submit & Spin Wheel');
      $('#FormModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
      });
    }

    $(document).ready(function() {
      @php
        $isLimitFinished2 = ($SpinnerFormAccessCount !== 'NO_LIMIT' && ($user->spin_whell_round - $SpinnerFormAccessCount) <= 0);
      @endphp
      const isLimitFinished2 = {{ $isLimitFinished2 ? 'true' : 'false' }};
      const hasCompletedSession2 = sessionStorage.getItem('spin_completed_{{ $user->id }}') === 'true';

      if (spinFormTiming === 'before_spin' && !preSpinFormId && !isLimitFinished2 && !hasCompletedSession2) {
        setTimeout(function() {
          openPreSpinModal();
        }, 400);
      }
    });

    function startActualSpin() {
      executeSpinRound();
    }

    function executeSpinRound() {
      $(".spin_form_btn").attr('disabled', 'disabled');

      $.ajax({
        url: "{{URL::to('u/spinner_round_check')}}",
        type: 'post',
        data: {
          user_id: '{{$user->id}}',
          campaign_id: '{{$Camping->id}}',
        },
        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
          $('.spin_time_count').html(data.total_count);
          if (data.status == false) {
            swal({
              title: "Oh! Sorry",
              text: "<h2>"+data.message+"</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a></p>",
              html: true,
              type: "error",
              confirmButtonText: "Ok"
            });

            document.getElementById('error').play();
            playing = true;
            $(".spin_form_btn").removeAttr('disabled');
            return;
          } else {
            try {
              document.getElementById('circleSound').play();
            } catch(e){}
            playing = true;

            $.ajax({
              url: "{{URL::to('form_submit')}}",
              type: 'POST',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              data: {
                campaign_id: "{{$campaign_id}}",
                name: $('#name').val() || submittedUserName,
                mobile: $('#phone').val(),
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                if (response.success && response.data) {
                  window.currentServerPrize = response.data;
                  calculatePrize(response.data.segment_number, response.data.degree, response.data.after_angle);
                } else {
                  if (playing == true) {
                    try { document.getElementById('circleSound').pause(); } catch(e){}
                    playing = false;
                  }
                  swal("Notice", response.message || "No prize available for selection.", "info");
                  $(".spin_form_btn").removeAttr('disabled');
                  wheelSpinning = false;
                }
              },
              error: function(xhr, status, error) {
                if (playing == true) {
                  try { document.getElementById('circleSound').pause(); } catch(e){}
                  playing = false;
                }
                swal("Error", "Could not connect to server. Please try again.", "error");
                $(".spin_form_btn").removeAttr('disabled');
                wheelSpinning = false;
              }
            });

            swal.close();
          }
          $('.confirm').removeAttr('disabled');
        },
        error: function(err) {
          $('.confirm').removeAttr('disabled');
          $(".spin_form_btn").removeAttr('disabled');
        }
      });
    }

    function submit_from() {
      if (spinFormTiming === 'before_spin' && !preSpinFormId) {
        openPreSpinModal();
        return;
      }

      swal({
        title: "Best Of Luck",
        text: "If you click on 'Yes' button it will reduce your spin limit",
        type: "success",
        showCancelButton: true,
        confirmButtonColor: 'green',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm){
          $('.confirm').attr('disabled','disabled');
          executeSpinRound();
        } else {
          swal("Cancelled", "Your spin wheel is cancelled :)", "error");
        }
      });
    }

    // Winwheel instance creation
    var theWheel = new Winwheel({
      'numSegments'  : {{$spinn_count}},
      'responsive'   : true,
      'outerRadius'  : 212,
      'textFontSize' : 17,
      'segments'     : <?php echo $spinner_data_json;?>,
      'animation' : {
        'type'     : 'spinToStop',
        'duration' : {{$Camping->spinner_time}},
        'spins'    : 8,
        'callbackFinished' : alertPrize
      }
    });

    var wheelSpinning = false;

    function alertPrize(indicatedSegment) {
      if (playing == true) {
        try { document.getElementById('circleSound').pause(); } catch(e){}
        playing = false;
      }

      function isDisqualifiedPrize(seg) {
        if (!seg) return true;
        if (seg.skip && (seg.skip.toString().trim().toLowerCase() === 'yes' || seg.skip.toString().trim() === '1')) return true;
        if (seg.price !== undefined && seg.price !== null && Number(seg.price) <= 0) return true;
        if (seg.chances !== undefined && seg.chances !== null && Number(seg.chances) <= 0) return true;
        return false;
      }

      let finalPrize = null;

      // 1. Authoritative server chosen prize (strictly validated)
      if (window.currentServerPrize && window.currentServerPrize.segment_number && theWheel.segments && theWheel.segments[window.currentServerPrize.segment_number]) {
        let sp = theWheel.segments[window.currentServerPrize.segment_number];
        if (!isDisqualifiedPrize(sp)) {
          finalPrize = sp;
        }
      }

      // 2. Check indicated segment from Winwheel
      if (!finalPrize && indicatedSegment && !isDisqualifiedPrize(indicatedSegment)) {
        finalPrize = indicatedSegment;
      }

      // 3. Fallback: find first eligible slice
      if (!finalPrize && theWheel.segments) {
        for (let i = 1; i < theWheel.segments.length; i++) {
          let seg = theWheel.segments[i];
          if (seg && !isDisqualifiedPrize(seg)) {
            finalPrize = seg;
            break;
          }
        }
      }

      if (!finalPrize) {
        swal("Notice", "No winning prizes currently available.", "info");
        $(".spin_form_btn").removeAttr('disabled');
        wheelSpinning = false;
        return;
      }

      try {
        let ownSound = document.getElementById('own');
        if (ownSound) ownSound.play().catch(function(e){ console.log('Audio error:', e); });
      } catch(e){}

      blast_fun();
      $('.award_text').html(finalPrize.text);
      $('#blast').addClass('show-blast').fadeIn(300);

      let pImg = '';
      if (finalPrize && finalPrize.image && typeof finalPrize.image === 'string' && finalPrize.image.trim() !== '') {
        pImg = finalPrize.image.trim();
      } else if (window.currentServerPrize && window.currentServerPrize.image && typeof window.currentServerPrize.image === 'string' && window.currentServerPrize.image.trim() !== '') {
        pImg = window.currentServerPrize.image.trim();
      }

      function resolveSafeImageUrl(url) {
        if (!url || typeof url !== 'string') return '';
        url = url.trim();
        if (!url) return '';
        if (url.startsWith('http://') || url.startsWith('https://')) {
          try {
            let parsed = new URL(url);
            if (parsed.hostname !== window.location.hostname) {
              return "{{ URL::to('image-proxy') }}?url=" + encodeURIComponent(url);
            }
          } catch(e) {
            return "{{ URL::to('image-proxy') }}?url=" + encodeURIComponent(url);
          }
        }
        return url;
      }

      let safeImg = resolveSafeImageUrl(pImg);

      if (safeImg !== '') {
        $('.spinner_image_show').attr('src', safeImg).css('display', 'inline-block');
        $('.trophy_img').css('display', 'none');
        $('.spinner_image').attr('src', safeImg).css('display', 'inline-block');
      } else {
        $('.trophy_img').attr('src', "{{asset('frontend/spinner/wheel/trophy.png')}}").css('display', 'inline-block');
        $('.spinner_image_show').css('display', 'none');
        $('.spinner_image').attr('src', "{{asset('frontend/spinner/wheel/trophy.png')}}").css('display', 'inline-block');
      }

      let prizeId = finalPrize.id || (window.currentServerPrize ? window.currentServerPrize.id : '');
      let prizeName = finalPrize.text || (window.currentServerPrize ? window.currentServerPrize.name : '');
      let prizeVal = finalPrize.price !== undefined ? finalPrize.price : (window.currentServerPrize ? window.currentServerPrize.price : 0);

      $('#spinner_id').val(prizeId);
      $('#spinner_name').val(prizeName);
      $('.spinner_name_text').html(prizeName);
      $('#spinner_value').val(prizeVal);

      // Auto capture screenshot
      setTimeout(function() {
        captureScreenshot('blast', 'screenshot-input', null, false);
      }, 600);

      setTimeout(() => {
        $('#confetti-canvas').hide();
      }, 2000);

      $(".spin_form_btn").removeAttr('disabled');
      wheelSpinning = false;
    }

    function calculatePrize(segmentNumber, degree, after_angle) {
      $(".spin_form_btn").attr('disabled', 'disabled');
      wheelSpinning = true;
      let stopAt = 0;

      if (segmentNumber && theWheel.segments && theWheel.segments[segmentNumber]) {
        let seg = theWheel.segments[segmentNumber];
        let startAngle = seg.startAngle;
        let endAngle = seg.endAngle;
        let segSpan = endAngle - startAngle;
        let centerAngle = startAngle + (segSpan / 2);
        let jitter = (Math.random() - 0.5) * (segSpan * 0.3);
        stopAt = Math.round(centerAngle + jitter);
      } else if (segmentNumber && typeof theWheel.getRandomForSegment === 'function') {
        stopAt = theWheel.getRandomForSegment(segmentNumber);
      } else if (after_angle) {
        let lessBound = (after_angle - degree) + 5;
        stopAt = Math.floor(Math.random() * (after_angle - lessBound - 4)) + lessBound + 2;
      }

      if (stopAt) {
        theWheel.animation.stopAngle = stopAt;
      }
      theWheel.startAnimation();
    }

    var proceedingToForm = false;

    function open_form_modal(){
      proceedingToForm = true;
      $('#ReedemModal').one('hidden.bs.modal', function(){
        $('#formModalTitle').html('<i class="fas fa-trophy mr-2 text-warning"></i> Claim Your Prize — Enter Details');
        $('.winner-header-info').show();
        $('.prespin-header-info').hide();
        $('.take_screen_button').show();
        $('#screenshot-preview-card').show();
        $('.form_submit_button').show().html('Submit');
        $('#FormModal').modal('show');
        setTimeout(function(){ proceedingToForm = false; }, 400);

        if (window.cachedWinningScreenshot) {
          applyScreenshot(window.cachedWinningScreenshot, 'screenshot-input', null, false);
        } else {
          captureScreenshot('blast', 'screenshot-input', null, false);
        }
      }).modal('hide');
    }

    $("#spinner_form").on('submit', function(e) {
      e.preventDefault();
      var phone = $('#phone').val();
      if (!$('#whatsapp_number').val()) {
        $('#whatsapp_number').val(phone);
      }

      if (!$('#screenshot-input').val() && window.cachedWinningScreenshot) {
        $('#screenshot-input').val(window.cachedWinningScreenshot);
      }

      var isPreSpin = (spinFormTiming === 'before_spin' && !preSpinFormId);
      var actionurl = isPreSpin ? "{{URL::to('u/spinner_form_before_spin')}}" : e.currentTarget.action;

      $('.form_submit_button').attr('disabled','disabled');
      $('#preloader').show();

      $.ajax({
        url: actionurl,
        type: 'post',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          $('.form_submit_button').removeAttr('disabled');
          $('#preloader').hide();

          if (isPreSpin && (data.status == 1 || data.message == 'PreSpinFormSubmitted')) {
            preSpinFormId = data.form_id;
            submittedUserName = data.name || $('#name').val();
            sessionStorage.setItem('preSpinFormId_{{ $user->id }}', preSpinFormId);
            sessionStorage.setItem('preSpinName_{{ $user->id }}', submittedUserName);

            proceedingToForm = false;
            $('#FormModal').modal('hide');

            setTimeout(function() {
              startActualSpin();
            }, 400);
            return;
          }

          if (data.message == 'Inserted') {
            swal({
              title: "Success",
              text: "<h4>Thank You For Submit Us Details</h4><span>Our Team Will be Contact You Soon </span> <p style='margin:7px'><b>Helpline Number </b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a></p>", 
              html: true,
              type: "success",
              confirmButtonText: "Ok",
              confirmButtonColor: "#DD6B55",
            }, function(isConfirm) {
              if (isConfirm) {
                sessionStorage.removeItem('preSpinFormId_{{ $user->id }}');
                sessionStorage.removeItem('preSpinName_{{ $user->id }}');
                location.reload(true);
              }
            });
          } else if(data.message == 'AlreadyInserted'){
            swal({
              title: "Error!",
              text: "<h2>Already Submitted</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a>",
              html: true,
              type: "error",
              confirmButtonText: "Cool"
            });
          } else {
            swal({
              title: "Notice",
              text: (data && data.message) ? data.message : "Submission could not be completed. Please try again.",
              type: "error",
              confirmButtonText: "Ok"
            });
          }
        },
        error: function(xhr, status, error) {
          $('.form_submit_button').removeAttr('disabled');
          $('#preloader').hide();
          swal({
            title: "Error!",
            text: "Something went wrong while submitting your details. Please try again.",
            type: "error",
            confirmButtonText: "Ok"
          });
        }
      });
    });

    function check_user_spinner_submit(){
      if (spinFormTiming === 'before_spin') {
        $('#preloader').show();
        $('.reedem-btn').attr('disabled', 'disabled');

        var formId = preSpinFormId || sessionStorage.getItem('preSpinFormId_{{ $user->id }}') || '';
        var spinnerId = (window.currentServerPrize && window.currentServerPrize.id) ? window.currentServerPrize.id : $('#spinner_id').val();

        $.ajax({
          url: "{{URL::to('u/spinner_form_update_prize')}}",
          type: 'POST',
          data: {
            form_id: formId,
            spinner_id: spinnerId,
            campaign_id: '{{$Camping->id}}',
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            $('#preloader').hide();
            $('.reedem-btn').removeAttr('disabled');
            if (data.status == 1 || data.message == 'PrizeUpdated') {
              $('#blast').removeClass('show-blast').fadeOut(250);
              swal({
                title: "Prize Claimed!",
                text: "<h4>Congratulations " + (submittedUserName || '') + "!</h4><p>Your prize <b>" + (data.prize_name || '') + "</b> has been confirmed!</p><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a></p>",
                html: true,
                type: "success",
                confirmButtonText: "Ok",
                confirmButtonColor: "#10b981"
              }, function(isConfirm) {
                sessionStorage.removeItem('preSpinFormId_{{ $user->id }}');
                sessionStorage.removeItem('preSpinName_{{ $user->id }}');
                sessionStorage.setItem('spin_completed_{{ $user->id }}', 'true');
                location.reload(true);
              });
            } else {
              swal("Error", data.message || "Failed to update prize", "error");
            }
          },
          error: function(err) {
            $('#preloader').hide();
            $('.reedem-btn').removeAttr('disabled');
            swal("Error", "Something went wrong updating prize. Please try again.", "error");
          }
        });
        return;
      }

      proceedingToForm = true;
      $('#blast').removeClass('show-blast').fadeOut(250, function(){
        $('#formModalTitle').html('<i class="fas fa-trophy mr-2 text-warning"></i> Claim Your Prize — Enter Details');
        $('.winner-header-info').show();
        $('.prespin-header-info').hide();
        $('.form_submit_button').html('Submit');
        $('#FormModal').modal('show');
        setTimeout(function(){ proceedingToForm = false; }, 400);

        if (window.cachedWinningScreenshot) {
          applyScreenshot(window.cachedWinningScreenshot, 'screenshot-input', null, false);
        } else {
          captureScreenshot('blast', 'screenshot-input', null, false);
        }
      });
    }

    $('#FormModal').on('hidden.bs.modal', function () {
      if (!proceedingToForm && !$('#FormModal').hasClass('show') && !$('.FormModal').hasClass('show') && !$('#FormModal').is(':visible')) {
        $('#blast').addClass('show-blast').fadeIn(200);
      }
    });

    jQuery(".sticky_share_btn").click(function () {
      jQuery(".listing").fadeToggle(600);
    });
    jQuery(".form_take_screenshot").click(function () {
      $('#FormModal').modal('hide');
      $('#ReedemModal').modal('hide');
    });

    window.cachedWinningScreenshot = null;

    function captureScreenshot(elementId, inputId, callback, isManual) {
      var isUserClick = (isManual === true);
      var blastEl = document.getElementById('blast');
      var wasHidden = false;
      var savedStyles = {};

      if (elementId === 'blast' || !elementId) {
        if (blastEl && ($(blastEl).is(':hidden') || window.getComputedStyle(blastEl).display === 'none' || blastEl.offsetHeight === 0)) {
          wasHidden = true;
          savedStyles = {
            display: blastEl.style.display,
            visibility: blastEl.style.visibility,
            position: blastEl.style.position,
            left: blastEl.style.left,
            top: blastEl.style.top,
            zIndex: blastEl.style.zIndex,
            opacity: blastEl.style.opacity
          };
          blastEl.style.setProperty('display', 'flex', 'important');
          blastEl.style.setProperty('visibility', 'visible', 'important');
          blastEl.style.setProperty('position', 'fixed', 'important');
          blastEl.style.setProperty('left', '0px', 'important');
          blastEl.style.setProperty('top', '0px', 'important');
          blastEl.style.setProperty('z-index', '-9999', 'important');
          blastEl.style.setProperty('opacity', '1', 'important');
        }
      }

      var targetElement = (blastEl && blastEl.querySelector('.content')) ? blastEl.querySelector('.content') : document.getElementById(elementId);
      if (!targetElement) {
        targetElement = document.querySelector('#FormModal .modal-content') || document.body;
      }

      function restoreStyles() {
        if (wasHidden && blastEl) {
          blastEl.style.display = savedStyles.display || 'none';
          blastEl.style.visibility = savedStyles.visibility || '';
          blastEl.style.position = savedStyles.position || '';
          blastEl.style.left = savedStyles.left || '';
          blastEl.style.top = savedStyles.top || '';
          blastEl.style.zIndex = savedStyles.zIndex || '';
          blastEl.style.opacity = savedStyles.opacity || '';
        }
      }

      html2canvas(targetElement, {
        useCORS: true,
        allowTaint: true,
        scale: 2,
        backgroundColor: '#ffffff',
        logging: false
      }).then(function(canvas) {
        restoreStyles();
        var imageData = canvas.toDataURL("image/png");

        if (!imageData || imageData === "data:," || imageData.length < 200 || !imageData.startsWith('data:image/')) {
          var fallbackTarget = document.querySelector('#FormModal .modal-content');
          if (fallbackTarget) {
            html2canvas(fallbackTarget, { scale: 1.5, useCORS: true, allowTaint: true }).then(function(fbCanvas) {
              var fbData = fbCanvas.toDataURL("image/png");
              applyScreenshot(fbData, inputId, callback, isUserClick);
            }).catch(function(err) {
              console.error("Fallback screenshot error:", err);
            });
            return;
          }
        }

        applyScreenshot(imageData, inputId, callback, isUserClick);
      }).catch(function(error) {
        restoreStyles();
        console.error("Error capturing the screenshot:", error);
        var fallbackTarget = document.querySelector('#FormModal .modal-content');
        if (fallbackTarget) {
          html2canvas(fallbackTarget, { scale: 1.5, useCORS: true, allowTaint: true }).then(function(fbCanvas) {
            var fbData = fbCanvas.toDataURL("image/png");
            applyScreenshot(fbData, inputId, callback, isUserClick);
          }).catch(function(err) {
            console.error("Fallback screenshot error:", err);
          });
        }
      });
    }

    function applyScreenshot(imageData, inputId, callback, isUserClick) {
      if (!imageData || !imageData.startsWith('data:image/')) return;

      window.cachedWinningScreenshot = imageData;
      var inputElement = document.getElementById(inputId || 'screenshot-input');
      if (inputElement) {
        inputElement.value = imageData;
      }

      $('#screenshot-preview-img').attr('src', imageData);
      $('#screenshot-preview-card').fadeIn(200);

      $('.take_screen_button').html('<i class="fas fa-camera mr-1"></i> Retake Screenshot');
      $('.form_submit_button').show();

      if (callback && typeof callback === "function") {
        callback(imageData);
      } else if (isUserClick) {
        if (typeof swal === 'function') {
          swal({
            title: "Screenshot Captured!",
            text: "Your winning proof has been attached. Please click Submit to claim your prize.",
            type: "success",
            confirmButtonText: "Ok",
            confirmButtonColor: "#10b981"
          });
        } else {
          alert("Screenshot captured successfully! Please click the 'Submit' button.");
        }
      }
    }
  </script>
</body>
</html>
