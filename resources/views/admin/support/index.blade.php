@extends('adminLayouts.home')
@section('content')

<div class="container-fluid px-2 px-sm-3 px-md-4 py-3">

  @php
    $storeUrl = str_replace('/public', '', url('u/' . ($user->name_url ?: $user->id)));
    $adminPhone = !empty($adminContact->phone) ? $adminContact->phone : '9304717260';
    $cleanAdminPhone = preg_replace('/[^0-9]/', '', $adminPhone);
    if (strlen($cleanAdminPhone) == 10) {
        $cleanAdminPhone = '91' . $cleanAdminPhone;
    }
    $adminEmail = !empty($adminContact->email) ? $adminContact->email : 'digitalvyapariofficial@gmail.com';
    $adminName = !empty($adminContact->name) ? $adminContact->name : 'PrizeWheel Team';

    // Pre-fill WhatsApp message text for account renewal
    $defaultWaMessage = "Hello " . $adminName . ",\n\nI want to renew my account subscription for PrizeWheel.\n\nStore Details:\n• Store Name: " . $user->name . "\n• Store URL: " . $storeUrl . "\n• Account Email: " . $user->email . "\n• Current Status: " . ($isExpired ? 'Expired' : ($daysRemaining <= 1 ? 'Expires in 1 day' : $daysRemaining . ' days remaining')) . "\n\nPlease share the available subscription renewal plans, pricing, and payment QR code.\n\nThank you!";
    $encodedWaUrl = "https://wa.me/" . $cleanAdminPhone . "?text=" . rawurlencode($defaultWaMessage);

    // Pre-fill Mailto URL
    $mailSubject = "PrizeWheel Account Subscription Renewal - " . $user->name;
    $mailBody = "Hello Support Team,\n\nI would like to inquire about renewing my PrizeWheel account subscription.\n\nStore Name: " . $user->name . "\nEmail: " . $user->email . "\nUsername: " . $user->name_url . "\n\nPlease contact me with subscription options.\n\nThank you,\n" . $user->name;
    $mailtoUrl = "mailto:" . $adminEmail . "?subject=" . rawurlencode($mailSubject) . "&body=" . rawurlencode($mailBody);
  @endphp

  <!-- Custom Styles for Support Page -->
  <style>
    /* Support Hero Card */
    .support-hero-card {
      background: linear-gradient(135deg, #0b132b 0%, #1c2541 55%, #1e293b 100%);
      border-radius: 18px;
      color: #ffffff;
      padding: clamp(18px, 3.5vw, 32px);
      position: relative;
      overflow: hidden;
      box-shadow: 0 16px 36px -10px rgba(11, 19, 43, 0.35);
      border: 1px solid rgba(255, 255, 255, 0.08);
      margin-bottom: clamp(16px, 2.5vw, 24px);
    }

    .support-hero-card::after {
      content: "";
      position: absolute;
      top: -30%;
      right: -10%;
      width: clamp(260px, 40vw, 420px);
      height: clamp(260px, 40vw, 420px);
      background: radial-gradient(circle, rgba(255, 107, 0, 0.22) 0%, rgba(255, 107, 0, 0) 70%);
      border-radius: 50%;
      pointer-events: none;
    }

    .support-pill-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 12px;
      border-radius: 9999px;
      font-size: clamp(10.5px, 2vw, 11.5px);
      font-weight: 700;
      letter-spacing: 0.3px;
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      background: rgba(255, 255, 255, 0.08);
      color: #f8fafc;
      white-space: nowrap;
    }

    .support-pill-tag.orange {
      background: rgba(255, 107, 0, 0.2);
      color: #ffedd5;
      border-color: rgba(255, 107, 0, 0.4);
    }

    .support-pill-tag.green {
      background: rgba(16, 185, 129, 0.2);
      color: #a7f3d0;
      border-color: rgba(16, 185, 129, 0.4);
    }

    .support-hero-title {
      font-size: clamp(19px, 3.2vw, 25px);
      font-weight: 800;
      letter-spacing: -0.02em;
      line-height: 1.25;
      margin-bottom: 8px;
    }

    .support-hero-desc {
      font-size: clamp(13px, 2vw, 14px);
      line-height: 1.55;
      color: rgba(255, 255, 255, 0.72);
      margin-bottom: 0;
    }

    .support-hero-btn-wrap {
      display: flex;
      align-items: center;
      gap: 14px;
      flex-wrap: wrap;
    }

    .support-hero-btn {
      padding: 12px 22px;
      font-weight: 700;
      font-size: 14px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
      text-decoration: none;
      transition: all 0.2s ease;
      white-space: nowrap;
    }

    .support-hero-btn-wa {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      color: #ffffff !important;
      border: none;
      box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
    }

    .support-hero-btn-wa:hover {
      background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
      color: #ffffff !important;
      transform: translateY(-1px);
    }

    .support-hero-btn-call {
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #ffffff !important;
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    }

    .support-hero-btn-call:hover {
      background: rgba(255, 255, 255, 0.25);
      color: #ffffff !important;
      transform: translateY(-1px);
    }

    /* Subscription Status Card */
    .renewal-highlight-box {
      border-radius: 18px;
      padding: clamp(18px, 3vw, 26px);
      background: #ffffff;
      border: 1px solid #e2e8f0;
      box-shadow: 0 6px 20px -4px rgba(15, 23, 42, 0.06);
      margin-bottom: clamp(18px, 2.5vw, 25px);
      position: relative;
      overflow: hidden;
    }

    .renewal-banner-expired {
      background: linear-gradient(135deg, #fff5f5 0%, #fee2e2 100%);
      border: 1.5px solid #fca5a5;
    }

    .renewal-banner-urgent {
      background: linear-gradient(135deg, #fffdf5 0%, #fef3c7 100%);
      border: 1.5px solid #fcd34d;
    }

    .renewal-banner-active {
      background: linear-gradient(135deg, #f7fdf9 0%, #dcfce7 100%);
      border: 1.5px solid #86efac;
    }

    .status-pulse-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      display: inline-block;
      animation: pulseAnim 1.8s infinite;
      flex-shrink: 0;
    }

    @keyframes pulseAnim {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
      70% { transform: scale(1.15); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    .dot-expired { background: #ef4444; }
    .dot-warning { background: #f59e0b; }
    .dot-active { background: #10b981; }

    .store-meta-chip-list {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 14px;
    }

    .store-meta-chip {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(0, 0, 0, 0.08);
      padding: 6px 14px;
      border-radius: 9999px;
      font-size: clamp(11.5px, 2vw, 12.5px);
      color: #1e293b;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
      max-width: 100%;
    }

    .store-meta-chip .chip-label {
      font-weight: 700;
      color: #475569;
    }

    .store-meta-chip .chip-val {
      font-weight: 600;
      color: #0f172a;
      word-break: break-all;
    }

    .store-meta-chip .chip-link {
      font-weight: 700;
      color: #ff6b00;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .store-meta-chip .chip-link:hover {
      text-decoration: underline;
      color: #ea580c;
    }

    .renewal-expiry-card {
      padding: clamp(14px, 2.5vw, 18px);
      border-radius: 14px;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      border: 1.5px dashed rgba(220, 38, 38, 0.35);
      text-align: left;
    }

    .renewal-banner-active .renewal-expiry-card {
      border-color: rgba(34, 197, 94, 0.45);
    }

    .renewal-banner-urgent .renewal-expiry-card {
      border-color: rgba(245, 158, 11, 0.45);
    }

    .renewal-expiry-label {
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      color: #64748b;
      margin-bottom: 4px;
    }

    .renewal-expiry-value {
      font-size: clamp(20px, 3.5vw, 24px);
      font-weight: 800;
      color: #0f172a;
      line-height: 1.2;
      margin-bottom: 4px;
    }

    .renewal-expiry-note {
      font-size: 12px;
      color: #64748b;
      line-height: 1.4;
    }

    /* Channel Cards */
    .support-channel-card {
      background: #ffffff;
      border-radius: 18px;
      border: 1px solid #e2e8f0;
      padding: clamp(18px, 3vw, 24px);
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      box-shadow: 0 4px 14px -3px rgba(15, 23, 42, 0.05);
    }

    .support-channel-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 30px -8px rgba(15, 23, 42, 0.12);
      border-color: #cbd5e1;
    }

    .support-channel-card.card-whatsapp {
      border-top: 4px solid #22c55e;
    }

    .support-channel-card.card-phone {
      border-top: 4px solid #2563eb;
    }

    .support-channel-card.card-email {
      border-top: 4px solid #ff6b00;
    }

    .channel-icon-wrap {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      margin-bottom: 14px;
      flex-shrink: 0;
    }

    .channel-icon-wrap.whatsapp {
      background: #dcfce7;
      color: #16a34a;
    }

    .channel-icon-wrap.phone {
      background: #dbeafe;
      color: #2563eb;
    }

    .channel-icon-wrap.email {
      background: #ffedd5;
      color: #ea580c;
    }

    .channel-title {
      font-size: clamp(16px, 2.5vw, 18px);
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 6px;
    }

    .channel-desc {
      font-size: 13px;
      line-height: 1.5;
      color: #64748b;
      margin-bottom: 14px;
    }

    .channel-info-box {
      padding: 12px 14px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      margin-bottom: 16px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .channel-info-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;
      flex-wrap: wrap;
    }

    .channel-info-row .info-label {
      font-size: 12px;
      color: #64748b;
      font-weight: 500;
    }

    .channel-info-row .info-value {
      font-size: 13px;
      font-weight: 700;
      color: #0f172a;
      word-break: break-all;
    }

    .info-email-link {
      color: #ff6b00 !important;
      text-decoration: none;
    }

    .info-email-link:hover {
      text-decoration: underline;
    }

    .support-btn-channel {
      width: 100%;
      min-height: 44px;
      padding: 11px 18px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 13.5px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
      text-align: center;
    }

    .support-btn-whatsapp {
      background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
      color: #ffffff !important;
      box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
    }

    .support-btn-whatsapp:hover {
      background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
      box-shadow: 0 6px 20px rgba(34, 197, 94, 0.45);
      color: #ffffff !important;
    }

    .support-btn-phone {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      color: #ffffff !important;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .support-btn-phone:hover {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
      color: #ffffff !important;
    }

    .support-btn-email {
      background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%);
      color: #ffffff !important;
      box-shadow: 0 4px 14px rgba(255, 107, 0, 0.3);
    }

    .support-btn-email:hover {
      background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
      box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
      color: #ffffff !important;
    }

    /* Steps & How It Works */
    .step-card-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      padding: clamp(14px, 2.5vw, 18px);
      height: 100%;
      transition: all 0.2s ease;
    }

    .step-card-item:hover {
      background: #ffffff;
      border-color: #cbd5e1;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
    }

    .step-badge-num {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: #fff7ed;
      color: #ff6b00;
      font-weight: 800;
      font-size: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      border: 1.5px solid #ffedd5;
    }

    .step-card-text {
      flex: 1;
      min-width: 0;
    }

    .perk-mini-box {
      background: #ffffff;
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      padding: clamp(12px, 2vw, 16px);
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
      height: 100%;
      transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .perk-mini-box:hover {
      transform: translateY(-2px);
      border-color: #cbd5e1;
    }

    .perk-mini-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      flex-shrink: 0;
    }

    /* FAQ accordion custom styling */
    .support-accordion .accordion-item {
      border: 1px solid #e2e8f0;
      border-radius: 14px !important;
      margin-bottom: 12px;
      overflow: hidden;
      background: #ffffff;
      box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
    }

    .support-accordion .accordion-button {
      font-weight: 700;
      font-size: clamp(13.5px, 2.5vw, 15px);
      color: #0f172a;
      background: #ffffff;
      padding: clamp(14px, 2.5vw, 18px) clamp(16px, 3vw, 22px);
      box-shadow: none;
    }

    .support-accordion .accordion-button:not(.collapsed) {
      background: #f8fafc;
      color: #ff6b00;
    }

    .support-accordion .accordion-body {
      padding: clamp(14px, 2.5vw, 18px) clamp(16px, 3vw, 22px) clamp(16px, 3vw, 22px);
      font-size: 13.5px;
      color: #475569;
      line-height: 1.65;
      background: #ffffff;
      border-top: 1px solid #f1f5f9;
    }

    /* Responsive Media Queries */
    @media (min-width: 992px) {
      .channel-desc {
        min-height: 60px;
      }
    }

    @media (max-width: 991.98px) {
      .renewal-expiry-card {
        margin-top: 8px;
      }
    }

    @media (max-width: 767.98px) {
      .support-hero-btn-wrap {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
      }

      .support-hero-btn-wrap .support-hero-btn {
        width: 100%;
        text-align: center;
      }
    }

    @media (max-width: 575.98px) {
      .store-meta-chip {
        width: 100%;
        justify-content: flex-start;
      }
      
      .support-pill-tag {
        font-size: 10.5px;
        padding: 4px 9px;
      }
    }
  </style>

  <!-- ==========================================================
       HERO HEADER: Welcome to Support & Renewal Hub
       ========================================================== -->
  <div class="support-hero-card">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div style="max-width: 720px;">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <span class="support-pill-tag orange">
            <i class="ti ti-lifebuoy"></i> Official Support Desk
          </span>
          <span class="support-pill-tag green">
            <i class="ti ti-brand-whatsapp"></i> WhatsApp Live Assistance
          </span>
          <span class="support-pill-tag">
            <i class="ti ti-clock"></i> Mon – Sat: 9:30 AM – 7:30 PM IST
          </span>
        </div>
        <h2 class="support-hero-title text-white">
          Need Help or Account Renewal? We've Got You Covered! 👋
        </h2>
        <p class="support-hero-desc">
          Connect directly with our dedicated PrizeWheel operations team. Renew your store subscription, get campaign setup guidance, request QR stands, or report any technical inquiries with quick resolution.
        </p>
      </div>

      <div class="support-hero-btn-wrap">
        <a href="{{ $encodedWaUrl }}" target="_blank" class="support-hero-btn support-hero-btn-wa">
          <i class="ti ti-brand-whatsapp fs-5"></i> Renew on WhatsApp
        </a>
        <a href="tel:{{ $adminPhone }}" class="support-hero-btn support-hero-btn-call">
          <i class="ti ti-phone-call fs-5"></i> Call Helpline
        </a>
      </div>
    </div>
  </div>

  <!-- ==========================================================
       SUBSCRIPTION STATUS & QUICK RENEWAL BANNER
       ========================================================== -->
  <div class="renewal-highlight-box @if($isExpired) renewal-banner-expired @elseif($daysRemaining <= 1) renewal-banner-urgent @else renewal-banner-active @endif" id="renewal-status">
    <div class="row align-items-center g-3 g-lg-4">
      
      <div class="col-lg-7 col-xl-8">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          @if($isExpired)
            <span class="status-pulse-dot dot-expired"></span>
            <span class="badge bg-danger text-white px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
              SUBSCRIPTION EXPIRED
            </span>
          @elseif($daysRemaining <= 1)
            <span class="status-pulse-dot dot-warning"></span>
            <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
              EXPIRING IN 1 DAY
            </span>
          @else
            <span class="status-pulse-dot dot-active"></span>
            <span class="badge bg-success text-white px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;">
              SUBSCRIPTION ACTIVE
            </span>
          @endif
          <span class="text-muted fs-2">• Current Account Details</span>
        </div>

        <h3 class="fw-bold text-dark mb-2" style="font-size: clamp(18px, 3.2vw, 23px);">
          Store: {{ $user->name }}
          <span class="text-muted fw-normal fs-3 ms-1">({{ $user->name_url ?: 'id-'.$user->id }})</span>
        </h3>

        <p class="mb-3" style="color: #334155 !important; font-size: 14px; line-height: 1.55;">
          @if($isExpired)
            <strong class="text-danger">Your account access has expired!</strong> Customer spin wheels and promotional campaigns are currently inactive. Renew now to resume collecting customer leads instantly without losing any data.
          @elseif($daysRemaining <= 1)
            <strong class="text-dark">Only 1 day left before account access expires!</strong> Renew your plan now to prevent any downtime for your store's in-store customers and lead campaigns.
          @else
            Your account is currently active with <strong>{{ $daysRemaining }} days remaining</strong> (Valid until <strong>{{ !empty($user->expiry_date) ? date('d M Y', strtotime($user->expiry_date)) : 'Ongoing' }}</strong>). You can extend your subscription at any time.
          @endif
        </p>

        <!-- Quick Store Info Badges / Chips -->
        <div class="store-meta-chip-list">
          <div class="store-meta-chip">
            <i class="ti ti-mail text-primary fs-4"></i>
            <span class="chip-label">Email:</span>
            <span class="chip-val">{{ $user->email }}</span>
          </div>

          @if(!empty($user->phone))
            <div class="store-meta-chip">
              <i class="ti ti-phone text-success fs-4"></i>
              <span class="chip-label">Phone:</span>
              <span class="chip-val">+91 {{ $user->phone }}</span>
            </div>
          @endif

          <div class="store-meta-chip">
            <i class="ti ti-link text-warning fs-4"></i>
            <span class="chip-label">Live Wheel:</span>
            <a href="{{ $storeUrl }}" target="_blank" class="chip-link">
              Open Wheel <i class="ti ti-arrow-up-right"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="col-lg-5 col-xl-4">
        <div class="renewal-expiry-card mb-3">
          <div class="renewal-expiry-label">Account Expiry Date</div>
          <div class="renewal-expiry-value">
            {{ !empty($user->expiry_date) ? date('d M Y', strtotime($user->expiry_date)) : '1-Day Free Trial' }}
          </div>
          <div class="renewal-expiry-note">
            All stored leads, prize slices, and wheel settings are permanently saved.
          </div>
        </div>

        <div class="d-flex flex-column gap-2">
          <a href="{{ $encodedWaUrl }}" target="_blank" class="support-btn-channel support-btn-whatsapp shadow-sm">
            <i class="ti ti-brand-whatsapp fs-5"></i> Renew Instantly via WhatsApp
          </a>
          <a href="tel:{{ $adminPhone }}" class="support-btn-channel support-btn-phone shadow-sm">
            <i class="ti ti-phone-call fs-5"></i> Speak with Renewal Specialist
          </a>
        </div>
      </div>

    </div>
  </div>

  <!-- ==========================================================
       CONTACT CHANNELS: WhatsApp, Helpline & Email Desk
       ========================================================== -->
  <div class="row g-3 g-md-4 mb-4">

    <!-- Channel 1: WhatsApp -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="support-channel-card card-whatsapp">
        <div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="channel-icon-wrap whatsapp">
              <i class="ti ti-brand-whatsapp"></i>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-bold fs-2">
              ⚡ Fastest Response
            </span>
          </div>
          <h4 class="channel-title">WhatsApp Support Desk</h4>
          <p class="channel-desc">
            Quickest channel for account renewal activation, UPI payment confirmations, screenshot sharing, and fast onboarding queries.
          </p>

          <div class="channel-info-box">
            <div class="channel-info-row">
              <span class="info-label">Helpline Number:</span>
              <strong class="info-value">+91 {{ $adminPhone }}</strong>
            </div>
            <div class="channel-info-row">
              <span class="info-label">Response Speed:</span>
              <span class="badge bg-success text-white rounded-pill fs-1 px-2 py-0.5">Within 5-15 mins</span>
            </div>
          </div>
        </div>

        <div>
          <a href="{{ $encodedWaUrl }}" target="_blank" class="support-btn-channel support-btn-whatsapp">
            <i class="ti ti-brand-whatsapp fs-4"></i> Chat on WhatsApp
          </a>
        </div>
      </div>
    </div>

    <!-- Channel 2: Phone Helpline -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="support-channel-card card-phone">
        <div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="channel-icon-wrap phone">
              <i class="ti ti-phone-call"></i>
            </div>
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1 fw-bold fs-2">
              📞 Voice Support
            </span>
          </div>
          <h4 class="channel-title">Direct Call Helpline</h4>
          <p class="channel-desc">
            Speak directly with an operations executive for urgent subscription renewal, wheel troubleshooting, or campaign strategy.
          </p>

          <div class="channel-info-box">
            <div class="channel-info-row">
              <span class="info-label">Direct Line:</span>
              <strong class="info-value">+91 {{ $adminPhone }}</strong>
            </div>
            <div class="channel-info-row">
              <span class="info-label">Available Hours:</span>
              <span class="text-dark fw-bold fs-2">9:30 AM – 7:30 PM IST</span>
            </div>
          </div>
        </div>

        <div>
          <a href="tel:{{ $adminPhone }}" class="support-btn-channel support-btn-phone">
            <i class="ti ti-phone-call fs-4"></i> Call +91 {{ $adminPhone }}
          </a>
        </div>
      </div>
    </div>

    <!-- Channel 3: Email Desk -->
    <div class="col-12 col-md-12 col-lg-4">
      <div class="support-channel-card card-email">
        <div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="channel-icon-wrap email">
              <i class="ti ti-mail"></i>
            </div>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2.5 py-1 fw-bold fs-2">
              ✉️ Official Email
            </span>
          </div>
          <h4 class="channel-title">Email Help Desk</h4>
          <p class="channel-desc">
            Ideal for requesting official GST tax invoices, formal enterprise customization, bulk multi-store licensing, and account records.
          </p>

          <div class="channel-info-box">
            <div class="channel-info-row">
              <span class="info-label">Email Address:</span>
              <a href="mailto:{{ $adminEmail }}" class="info-value info-email-link" title="{{ $adminEmail }}">{{ $adminEmail }}</a>
            </div>
            <div class="channel-info-row">
              <span class="info-label">Typical Response:</span>
              <span class="text-dark fw-bold fs-2">Within 2–4 hours</span>
            </div>
          </div>
        </div>

        <div>
          <a href="{{ $mailtoUrl }}" class="support-btn-channel support-btn-email">
            <i class="ti ti-mail fs-4"></i> Compose Support Email
          </a>
        </div>
      </div>
    </div>

  </div>

  <!-- ==========================================================
       HOW RENEWAL WORKS & WHAT'S INCLUDED
       ========================================================== -->
  <div class="card mb-4 border-0 shadow-sm" style="border-radius: 18px; overflow: hidden;">
    <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div>
        <h5 class="fw-bold text-dark mb-0 fs-4">How Subscription Renewal Works 🚀</h5>
        <p class="text-muted fs-2 mb-0">Easy 3-step renewal process with immediate activation</p>
      </div>
      <a href="{{ $encodedWaUrl }}" target="_blank" class="btn btn-sm btn-outline-success fw-bold d-inline-flex align-items-center gap-1.5 px-3 py-2" style="border-radius: 10px; font-size: 13px;">
        <i class="ti ti-brand-whatsapp fs-4"></i> Chat for Pricing &amp; Plans
      </a>
    </div>

    <div class="card-body p-3 p-md-4">
      <div class="row g-3 g-md-4 mb-4">
        
        <!-- Step 1 -->
        <div class="col-12 col-md-4">
          <div class="step-card-item">
            <div class="step-badge-num">1</div>
            <div class="step-card-text">
              <h6 class="fw-bold text-dark mb-1 fs-3">Select Your Renewal Duration</h6>
              <p class="text-muted fs-2 mb-0" style="line-height: 1.5;">
                Choose between 1 Month, 3 Months, 6 Months, or Annual store access based on your promotional event roadmap.
              </p>
            </div>
          </div>
        </div>

        <!-- Step 2 -->
        <div class="col-12 col-md-4">
          <div class="step-card-item">
            <div class="step-badge-num">2</div>
            <div class="step-card-text">
              <h6 class="fw-bold text-dark mb-1 fs-3">Instant UPI / QR Payment</h6>
              <p class="text-muted fs-2 mb-0" style="line-height: 1.5;">
                Our support desk shares an instant UPI payment QR or bank link over WhatsApp. Pay conveniently using any UPI app (GPay, PhonePe, Paytm).
              </p>
            </div>
          </div>
        </div>

        <!-- Step 3 -->
        <div class="col-12 col-md-4">
          <div class="step-card-item">
            <div class="step-badge-num">3</div>
            <div class="step-card-text">
              <h6 class="fw-bold text-dark mb-1 fs-3">Immediate 5-Min Activation</h6>
              <p class="text-muted fs-2 mb-0" style="line-height: 1.5;">
                Your account is extended right away with zero downtime. All campaigns, wheel prizes, QR stands, and leads stay exactly in place.
              </p>
            </div>
          </div>
        </div>

      </div>

      <hr style="border-color: #f1f5f9;" class="my-4">

      <!-- Included Features in Every Renewal -->
      <h6 class="fw-bold text-dark mb-3 fs-3">
        <i class="ti ti-circle-check text-success me-1"></i> What You Get with Your PrizeWheel Renewal:
      </h6>

      <div class="row g-2.5 g-md-3">
        
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="perk-mini-box">
            <div class="perk-mini-icon" style="background: #ecfdf5; color: #059669;">
              <i class="ti ti-disc"></i>
            </div>
            <div>
              <strong class="d-block text-dark fs-3 mb-0.5">Unlimited Customer Spins</strong>
              <span class="text-muted fs-2">No caps or hidden restrictions on customer spins during events.</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="perk-mini-box">
            <div class="perk-mini-icon" style="background: #eff6ff; color: #2563eb;">
              <i class="ti ti-users"></i>
            </div>
            <div>
              <strong class="d-block text-dark fs-3 mb-0.5">Full Customer Lead Capture</strong>
              <span class="text-muted fs-2">Collect names, WhatsApp numbers, emails, bill slips, and custom fields.</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="perk-mini-box">
            <div class="perk-mini-icon" style="background: #fdf2f8; color: #db2777;">
              <i class="ti ti-shield-check"></i>
            </div>
            <div>
              <strong class="d-block text-dark fs-3 mb-0.5">Anti-Cheat &amp; IP Protection</strong>
              <span class="text-muted fs-2">Prevent duplicate spins and fraud with automated device &amp; IP filters.</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="perk-mini-box">
            <div class="perk-mini-icon" style="background: #fff7ed; color: #ea580c;">
              <i class="ti ti-adjustments"></i>
            </div>
            <div>
              <strong class="d-block text-dark fs-3 mb-0.5">Chances &amp; Skip Algorithms</strong>
              <span class="text-muted fs-2">Full control over prize stock odds or guaranteed winning probabilities.</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="perk-mini-box">
            <div class="perk-mini-icon" style="background: #f5f3ff; color: #7c3aed;">
              <i class="ti ti-qrcode"></i>
            </div>
            <div>
              <strong class="d-block text-dark fs-3 mb-0.5">Printable Store QR Stands</strong>
              <span class="text-muted fs-2">Download ready-to-print branded tabletop QR stands for customer tables.</span>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
          <div class="perk-mini-box">
            <div class="perk-mini-icon" style="background: #f0fdf4; color: #16a34a;">
              <i class="ti ti-file-spreadsheet"></i>
            </div>
            <div>
              <strong class="d-block text-dark fs-3 mb-0.5">Excel &amp; PDF Lead Exports</strong>
              <span class="text-muted fs-2">Export customer inquiries anytime for SMS marketing &amp; WhatsApp CRM.</span>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- ==========================================================
       FREQUENTLY ASKED QUESTIONS
       ========================================================== -->
  <div class="row g-4 mb-4">
    
    <!-- Frequently Asked Questions Accordion -->
    <div class="col-12">
      <div class="card border-0 shadow-sm" style="border-radius: 18px;">
        <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="d-flex align-items-center gap-2">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #fff7ed; color: #ff6b00; display: flex; align-items: center; justify-content: center;">
              <i class="ti ti-help fs-5"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-0 fs-3">Frequently Asked Questions</h5>
              <span class="text-muted fs-2">Quick answers about renewals, settings, and campaigns</span>
            </div>
          </div>
          <a href="{{ $encodedWaUrl }}" target="_blank" class="btn btn-sm btn-outline-success fw-bold d-inline-flex align-items-center gap-1.5 px-3 py-2" style="border-radius: 10px; font-size: 13px;">
            <i class="ti ti-brand-whatsapp fs-4"></i> Still have questions? Ask on WhatsApp
          </a>
        </div>

        <div class="card-body p-3 p-md-4">
          <div class="accordion support-accordion" id="supportFaqAccordion">
            
            <!-- FAQ 1 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="faqHeading1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                  1. How fast is my account renewed after payment?
                </button>
              </h2>
              <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#supportFaqAccordion">
                <div class="accordion-body">
                  <strong>Instant activation!</strong> Once you share your payment screenshot on our WhatsApp desk, our operations team extends your expiry within <strong>5 to 10 minutes</strong>. You will receive an immediate confirmation message.
                </div>
              </div>
            </div>

            <!-- FAQ 2 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="faqHeading2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                  2. Will I lose my wheel prizes, QR stands, or collected leads if I expire?
                </button>
              </h2>
              <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#supportFaqAccordion">
                <div class="accordion-body">
                  <strong>No, absolutely not!</strong> All your campaigns, spinner prizes, custom branding, and customer lead records are permanently preserved in our secure database. As soon as you renew, your wheel becomes immediately accessible to customers without needing any reconfiguration.
                </div>
              </div>
            </div>

            <!-- FAQ 3 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="faqHeading3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                  3. What is the difference between Skip Mode and Chances Mode?
                </button>
              </h2>
              <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#supportFaqAccordion">
                <div class="accordion-body">
                  In <strong>Skip Mode</strong>, any slice marked as "Skip" is guaranteed never to be awarded, and only available items with quantity are won. In <strong>Chances Mode</strong>, customers win prizes based on the probability / chance number you set for each slice (higher chance = more frequent wins; 0 chances = never won). You can switch modes anytime via the header dropdown.
                </div>
              </div>
            </div>

            <!-- FAQ 4 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="faqHeading4">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                  4. How can I download and print our store counter QR stand?
                </button>
              </h2>
              <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#supportFaqAccordion">
                <div class="accordion-body">
                  Click on your profile avatar at the top right and select <strong>"Download QR Stand"</strong>, or open the campaign menu. You can print the generated high-resolution stand card on standard A4 or acrylic tabletop stands for your store checkout counter.
                </div>
              </div>
            </div>

            <!-- FAQ 5 -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="faqHeading5">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                  5. How do I export customer leads data into Excel or PDF?
                </button>
              </h2>
              <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#supportFaqAccordion">
                <div class="accordion-body">
                  Go to <strong>"Spinner Enquiry"</strong> from your sidebar navigation, click on your active campaign, and use the <strong>"Export to Excel"</strong> or <strong>"Download PDF"</strong> buttons at the top of the table to download all customer details.
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

</div>

@endsection
