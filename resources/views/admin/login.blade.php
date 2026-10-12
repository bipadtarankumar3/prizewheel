<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>PrizeWheel | Digital Spin Wheel & Multi-Platform Engagement Hub</title>
  <meta name="description" content="Digital Spin Wheel, Reviews & Rewards Hub. Boost 5-star Google Reviews and engage customers with gamified prize wheels." />
  <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/spinner/wheel/trophy.png') }}" />
  
  <!-- Modern Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  
  <!-- Toastr Notification CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  
  <!-- Confetti JS for Celebrations -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <style>
    :root {
      --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --font-heading: 'Space Grotesk', var(--font-main);
      
      /* Vibrant Orange Color Theme */
      --primary: #ff6b00;
      --primary-hover: #ea580c;
      --primary-gradient: linear-gradient(135deg, #ff6b00 0%, #ff8c3a 50%, #f97316 100%);
      --primary-glow: rgba(255, 107, 0, 0.3);
      --primary-light: #fff7ed;
      --primary-border: rgba(255, 107, 0, 0.2);
      
      /* Light / White background palette */
      --bg-page: #f4f6fb;
      --text-dark: #0f172a;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --card-bg: #ffffff;
      
      --radius-xl: 0px;
      --radius-lg: 18px;
      --radius-md: 12px;
      --radius-sm: 8px;
      
      --shadow-card: 0 4px 24px rgba(15, 23, 42, 0.07);
      --shadow-auth: 0 20px 50px -10px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(15, 23, 42, 0.04);
      --shadow-floating: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--font-main);
      background-color: #f8fafc;
      background-image: radial-gradient(rgba(148, 163, 184, 0.4) 1.2px, transparent 1.2px);
      background-size: 26px 26px;
      color: var(--text-dark);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
    }

    /* === ATOM PARTICLE CANVAS === */
    #atomCanvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2;
      pointer-events: none;
    }

    /* Subtle radiant warmth behind showcase */
    .bg-overlay {
      position: fixed;
      inset: 0;
      z-index: 1;
      background:
        radial-gradient(ellipse 65% 55% at 25% 30%, rgba(255, 107, 0, 0.08) 0%, transparent 65%),
        radial-gradient(ellipse 55% 55% at 65% 70%, rgba(99, 102, 241, 0.06) 0%, transparent 60%);
      pointer-events: none;
    }

    .vertical-guide-line { display: none; }

    /* Top & Bottom Floating Badges (anchored in showcase) */
    .top-float-badge {
      position: absolute;
      top: 24px;
      left: 32px;
      z-index: 20;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border: 1px solid #e2e8f0;
      padding: 7px 16px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 600;
      color: #0f172a;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
      transition: all 0.25s ease;
    }

    .top-float-badge:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.1);
    }

    .pulse-dot {
      width: 8px;
      height: 8px;
      background-color: #10b981;
      border-radius: 50%;
      box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
      animation: pulseGreen 2s infinite;
    }

    @keyframes pulseGreen {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .bottom-float-badge {
      position: absolute;
      bottom: 24px;
      left: 32px;
      z-index: 20;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(12px);
      border: 1px solid #e2e8f0;
      padding: 9px 18px;
      border-radius: 9999px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
      font-size: 13px;
      font-weight: 600;
      color: #0f172a;
      cursor: default;
    }

    .bottom-float-badge .icon-wrap {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: var(--primary-light);
      color: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
    }

    .bottom-float-badge .badge-text-group {
      display: flex;
      flex-direction: column;
      line-height: 1.25;
    }

    .bottom-float-badge .badge-sub {
      font-size: 11px;
      font-weight: 500;
      color: #64748b;
    }

    /* =========================================================
       FULL-HEIGHT SPLIT LAYOUT: 60% showcase | divider | 40% auth
       ========================================================= */
    .app-viewport {
      position: relative;
      z-index: 5;
      min-height: 100vh;
      display: flex;
      align-items: stretch;
      width: 100%;
      padding: 0;
      margin: 0;
      max-width: 100%;
    }

    /* Desktop: side-by-side, full height */
    .split-grid {
      display: flex;
      flex-direction: row;
      width: 100%;
      min-height: 100vh;
      align-items: stretch;
    }

    /* LEFT 60% — Showcase with atom bg */
    .split-left {
      flex: 0 0 60%;
      width: 60%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 36px;
      position: relative;
      background: transparent;
      z-index: 4;
    }

    /* Vertical Divider */
    .split-divider {
      flex: 0 0 1px;
      width: 1px;
      background: linear-gradient(180deg,
        transparent 0%,
        #e2e8f0 10%,
        #fed7aa 40%,
        #ff6b00 50%,
        #fed7aa 60%,
        #e2e8f0 90%,
        transparent 100%
      );
      position: relative;
      z-index: 10;
      align-self: stretch;
    }

    /* RIGHT 40% — Auth card */
    .split-right {
      flex: 0 0 40%;
      width: 40%;
      min-width: 380px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 36px;
      background: #ffffff;
      position: relative;
      z-index: 10;
      box-shadow: -8px 0 32px rgba(15, 23, 42, 0.04);
    }

    /* On mobile: stack vertically */
    @media (max-width: 1023px) {
      .split-grid {
        flex-direction: column;
      }
      .split-left {
        display: none !important;
      }
      .split-divider {
        display: none !important;
      }
      .split-right {
        flex: 1;
        width: 100%;
        min-height: 100vh;
        padding: 32px 20px;
      }
      .top-float-badge,
      .bottom-float-badge {
        display: none !important;
      }
    }

    /* =========================================================
       LEFT SIDE: SHOWCASE — no card wrapper, just centered content
       ========================================================= */
    .showcase-card {
      background: transparent;
      border-radius: 0;
      box-shadow: none;
      border: none;
      position: relative;
      overflow: visible;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      max-width: 720px;
      margin: 0 auto;
    }

    /* No top strip on transparent card */
    .showcase-card::before {
      display: none;
    }

    /* Carousel Structure */
    .carousel-wrapper {
      width: 100%;
      position: relative;
      overflow: hidden;
    }

    .carousel-track {
      display: flex;
      transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
      width: 300%;
    }

    .carousel-slide {
      width: 33.333333%;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 2px 4px;
    }

    /* Pill Badges in Carousel Header */
    .feature-pill-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: var(--primary);
      background: var(--primary-light);
      border: 1px solid var(--primary-border);
      margin-bottom: 20px;
    }

    /* Phone Mockup Frame */
    .phone-mockup-wrapper {
      position: relative;
      width: 100%;
      max-width: 320px;
      margin: 0 auto 20px;
    }

    .phone-mockup {
      width: 100%;
      height: 540px;
      background: #0f172a;
      border-radius: 48px;
      padding: 11px;
      box-shadow: 
        0 28px 70px -15px rgba(15, 23, 42, 0.35),
        0 0 0 1px rgba(255, 255, 255, 0.15) inset,
        0 0 0 4px #1e293b;
      position: relative;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    /* Dynamic Island */
    .phone-island {
      position: absolute;
      top: 17px;
      left: 50%;
      transform: translateX(-50%);
      width: 86px;
      height: 22px;
      background: #000000;
      border-radius: 20px;
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding-right: 12px;
    }

    .phone-lens {
      width: 7.5px;
      height: 7.5px;
      background: #1e293b;
      border-radius: 50%;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .phone-screen {
      width: 100%;
      height: 100%;
      background: #ffffff;
      border-radius: 38px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .phone-status-bar {
      height: 36px;
      padding: 6px 16px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 11px;
      font-weight: 700;
      color: #0f172a;
      z-index: 8;
    }

    .status-icons {
      display: flex;
      gap: 5px;
      align-items: center;
      font-size: 10px;
    }

    /* SLIDE 1: INTERACTIVE WHEEL SCREEN */
    .wheel-screen-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 4px 10px 12px;
      background: radial-gradient(circle at 50% 30%, #fff7ed 0%, #ffffff 80%);
      position: relative;
    }

    .wheel-sub-badge {
      font-size: 10px;
      font-weight: 700;
      color: var(--primary);
      background: #ffedd5;
      padding: 3px 10px;
      border-radius: 20px;
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .wheel-title-small {
      font-size: 14px;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 6px;
    }

    .wheel-canvas-container {
      position: relative;
      width: 236px;
      height: 236px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Wheel Pointer Arrow Pin */
    .wheel-pointer-pin {
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      width: 28px;
      height: 30px;
      z-index: 15;
      filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.25));
    }

    .wheel-pointer-pin svg {
      width: 100%;
      height: 100%;
      fill: var(--primary);
    }

    /* Rotating Wheel Disc */
    .wheel-disc {
      width: 226px;
      height: 226px;
      border-radius: 50%;
      position: relative;
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.16), 0 0 0 6px #ffffff, 0 0 0 8px #fed7aa;
      transition: transform 4s cubic-bezier(0.17, 0.97, 0.38, 1);
      cursor: pointer;
    }

    .wheel-disc svg {
      width: 100%;
      height: 100%;
      display: block;
    }

    /* Center Spin Button */
    .wheel-center-knob {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 60px;
      height: 60px;
      background: radial-gradient(circle, #ffffff 40%, #fff7ed 100%);
      border-radius: 50%;
      border: 3px solid var(--primary);
      box-shadow: 0 4px 15px var(--primary-glow);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 12;
      transition: transform 0.15s ease;
    }

    .wheel-center-knob:active {
      transform: translate(-50%, -50%) scale(0.92);
    }

    .wheel-center-knob span {
      font-size: 11px;
      font-weight: 800;
      color: var(--primary);
      letter-spacing: 0.5px;
      line-height: 1;
    }

    .wheel-center-knob i {
      font-size: 9px;
      color: var(--primary);
      margin-top: 2px;
    }

    .wheel-result-banner {
      margin-top: 8px;
      font-size: 11px;
      font-weight: 700;
      color: #059669;
      background: #ecfdf5;
      border: 1px dashed #10b981;
      padding: 4px 12px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    /* =========================================================
       SLIDE 2: SUBMIT HIS DETAILS (LEAD CAPTURE FORM)
       ========================================================= */
    .lead-form-screen {
      flex: 1;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      padding: 6px 14px 12px;
      text-align: left;
      overflow-y: auto;
    }

    .lead-form-header {
      text-align: center;
      margin-bottom: 8px;
    }

    .lead-form-header .mini-gift-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 9.5px;
      font-weight: 700;
      color: var(--primary);
      background: var(--primary-light);
      padding: 3px 8px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
    }

    .lead-form-header h4 {
      font-size: 13px;
      font-weight: 800;
      color: #0f172a;
      line-height: 1.2;
    }

    .lead-form-header p {
      font-size: 10px;
      color: #64748b;
      margin-top: 2px;
    }

    .mock-field-group {
      margin-bottom: 8px;
    }

    .mock-field-label {
      font-size: 10px;
      font-weight: 700;
      color: #334155;
      display: block;
      margin-bottom: 3px;
    }

    .mock-input-box {
      height: 34px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 0 10px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 11px;
      color: #0f172a;
      font-weight: 500;
    }

    .mock-input-box i {
      font-size: 11px;
      color: #94a3b8;
    }

    .mock-submit-btn {
      width: 100%;
      height: 38px;
      background: var(--primary-gradient);
      border: none;
      border-radius: 9999px;
      color: #ffffff;
      font-size: 11.5px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      box-shadow: 0 4px 12px var(--primary-glow);
      margin-top: 6px;
      cursor: pointer;
    }

    .mock-trust-note {
      text-align: center;
      font-size: 9px;
      color: #64748b;
      margin-top: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 4px;
    }

    /* SLIDE 3: SMART NFC & QR CODE STANDS */
    .rewards-screen-content {
      flex: 1;
      background: #f8fafc;
      padding: 10px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      justify-content: center;
    }

    .reward-voucher-box {
      background: #ffffff;
      border-radius: 14px;
      padding: 10px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
      text-align: center;
    }

    .voucher-discount {
      font-size: 19px;
      font-weight: 800;
      color: var(--primary);
      font-family: var(--font-heading);
    }

    .voucher-title {
      font-size: 10.5px;
      font-weight: 700;
      color: #1e293b;
      margin: 2px 0 6px;
    }

    .qr-stand-mini {
      width: 60px;
      height: 60px;
      margin: 4px auto;
      background: #ffffff;
      padding: 4px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
    }

    .qr-stand-mini img {
      width: 100%;
      height: 100%;
      display: block;
    }

    /* Floating Badges pinned to phone sides */
    .side-float-badge {
      position: absolute;
      background: #ffffff;
      padding: 7px 12px;
      border-radius: 12px;
      box-shadow: var(--shadow-floating);
      border: 1px solid rgba(226, 232, 240, 0.95);
      display: flex;
      align-items: center;
      gap: 8px;
      z-index: 12;
      animation: floatBadge 3.5s ease-in-out infinite alternate;
      cursor: default;
    }

    .side-float-left {
      top: 34%;
      left: -44px;
    }

    .side-float-right {
      top: 54%;
      right: -38px;
      animation-delay: 1.8s;
    }

    @keyframes floatBadge {
      0% { transform: translateY(0px); }
      100% { transform: translateY(-6px); }
    }

    .badge-icon-sq {
      width: 26px;
      height: 26px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
    }

    .badge-icon-orange {
      background: #ffedd5;
      color: var(--primary);
    }

    .badge-icon-yellow {
      background: #fef3c7;
      color: #d97706;
    }

    .badge-content-text {
      display: flex;
      flex-direction: column;
      text-align: left;
    }

    .badge-title-txt {
      font-size: 11px;
      font-weight: 700;
      color: #0f172a;
      line-height: 1.2;
    }

    .badge-sub-txt {
      font-size: 9px;
      font-weight: 500;
      color: #64748b;
    }

    /* Slide Content Details below Phone */
    .slide-headline {
      font-family: var(--font-heading);
      font-size: clamp(19px, 2.2vw, 22px);
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 6px;
      letter-spacing: -0.3px;
    }

    .slide-desc {
      font-size: 13px;
      color: #64748b;
      line-height: 1.5;
      max-width: 440px;
      margin: 0 auto 14px;
    }

    .feature-tags-row {
      display: flex;
      flex-wrap: wrap;
      gap: 7px;
      justify-content: center;
      margin-bottom: 14px;
    }

    .feature-tag-chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 9999px;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      font-size: 11px;
      font-weight: 600;
      color: #475569;
    }

    .feature-tag-chip i {
      font-size: 10px;
    }

    /* Carousel Nav Footer */
    .carousel-nav-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid #f1f5f9;
    }

    .trust-avatar-group {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .avatar-stack {
      display: flex;
      align-items: center;
    }

    .avatar-circle {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      border: 2px solid #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 9px;
      font-weight: 800;
      color: #ffffff;
      margin-left: -6px;
    }

    .avatar-circle:first-child { margin-left: 0; }
    .avatar-1 { background: #ff6b00; }
    .avatar-2 { background: #2563eb; }
    .avatar-3 { background: #059669; }
    .avatar-4 { background: #7c3aed; }

    .trust-text {
      font-size: 11.5px;
      font-weight: 600;
      color: #64748b;
    }

    .trust-text strong {
      color: #0f172a;
    }

    .carousel-pagination-controls {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .carousel-indicators {
      display: flex;
      gap: 5px;
      align-items: center;
    }

    .indicator-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #cbd5e1;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .indicator-dot.active {
      width: 22px;
      border-radius: 9999px;
      background: var(--primary);
    }

    .carousel-arrows {
      display: flex;
      gap: 6px;
    }

    .carousel-arrow-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 1px solid #e2e8f0;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      color: #64748b;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .carousel-arrow-btn:hover {
      background: #fff7ed;
      border-color: #fed7aa;
      color: var(--primary);
      transform: scale(1.08);
      box-shadow: 0 4px 12px rgba(255, 107, 0, 0.15);
    }

    /* =========================================================
       RIGHT SIDE: CLEAN WHITE AUTH PANEL (40%)
       ========================================================= */
    .auth-card-container {
      width: 100%;
      max-width: 440px;
      margin: 0 auto;
      position: relative;
    }

    .auth-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: var(--shadow-auth);
      border: 1px solid #f1f5f9;
      padding: 32px 30px 28px;
      position: relative;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .auth-card:hover {
      transform: translateY(-1px);
      box-shadow: 0 24px 60px -10px rgba(15, 23, 42, 0.15), 0 0 0 1px rgba(15, 23, 42, 0.05);
    }

    /* Orange accent top highlight line */
    .auth-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3.5px;
      background: var(--primary-gradient);
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }

    /* Brand Logo */
    .brand-header-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      margin-bottom: 18px;
    }

    .brand-logo-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 12px;
      text-decoration: none;
    }

    .brand-logo-icon {
      width: 38px;
      height: 38px;
      border-radius: 11px;
      background: var(--primary-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 19px;
      box-shadow: 0 6px 18px var(--primary-glow);
    }

    .brand-title {
      font-family: var(--font-heading);
      font-size: 24px;
      font-weight: 800;
      letter-spacing: -0.5px;
      color: #0f172a;
    }

    .brand-title span {
      color: var(--primary);
    }

    /* NEW POLISHED SEGMENTED TAB SWITCHER */
    .auth-tab-switcher {
      display: grid;
      grid-template-columns: 1fr 1fr;
      background: #f1f5f9;
      padding: 4px;
      border-radius: 9999px;
      margin-bottom: 18px;
      position: relative;
      border: 1px solid #e2e8f0;
    }

    .tab-btn {
      padding: 8px 14px;
      border-radius: 9999px;
      border: none;
      background: transparent;
      color: #64748b;
      font-size: 12.5px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-family: var(--font-main);
    }

    .tab-btn.active {
      background: #ffffff;
      color: var(--primary);
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    }

    .form-mode-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 12px;
      border-radius: 9999px;
      font-size: 11px;
      font-weight: 700;
      color: var(--primary);
      background: var(--primary-light);
      border: 1px solid var(--primary-border);
      margin-bottom: 8px;
    }

    .auth-heading {
      font-family: var(--font-heading);
      font-size: 26px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.5px;
      margin-bottom: 5px;
    }

    .auth-subheading {
      font-size: 13.5px;
      color: #64748b;
      line-height: 1.5;
      text-align: center;
      margin-bottom: 18px;
    }

    /* Google SSO Button - Premium */
    .google-btn {
      width: 100%;
      height: 48px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: var(--radius-md);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 14px;
      font-weight: 700;
      color: #1e293b;
      cursor: pointer;
      transition: all 0.25s ease;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 0 0 0 rgba(255,107,0,0);
      position: relative;
      overflow: hidden;
    }

    .google-btn::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(66, 133, 244, 0.03), rgba(234, 67, 53, 0.03));
      opacity: 0;
      transition: opacity 0.25s ease;
    }

    .google-btn:hover {
      border-color: #a0aec0;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.09);
      transform: translateY(-1.5px);
    }

    .google-btn:hover::after {
      opacity: 1;
    }

    .google-btn svg {
      width: 20px;
      height: 20px;
      flex-shrink: 0;
    }

    /* Divider */
    .auth-divider {
      display: flex;
      align-items: center;
      margin: 16px 0;
      color: #94a3b8;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.8px;
      text-transform: uppercase;
    }

    .auth-divider::before,
    .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e2e8f0;
    }

    .auth-divider span {
      padding: 0 10px;
    }

    /* Form Groups & Inputs */
    .form-group {
      margin-bottom: 13px;
      position: relative;
    }

    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 700;
      color: #334155;
      margin-bottom: 5px;
    }

    .input-with-icon {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon-left {
      position: absolute;
      left: 13px;
      color: #94a3b8;
      font-size: 13px;
      pointer-events: none;
      transition: color 0.2s ease;
    }

    .form-control-input {
      width: 100%;
      height: 46px;
      padding: 0 40px 0 40px;
      border: 1.5px solid #e2e8f0;
      border-radius: var(--radius-md);
      font-size: 13.5px;
      font-weight: 500;
      color: #0f172a;
      background: #f9fafb;
      outline: none;
      transition: all 0.22s ease;
      font-family: var(--font-main);
    }

    .form-control-input::placeholder {
      color: #b0bec5;
      font-weight: 400;
    }

    .form-control-input:focus {
      border-color: var(--primary);
      background: #ffffff;
      box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1);
    }

    .form-control-input:focus ~ .input-icon-left {
      color: var(--primary);
    }

    .toggle-password-eye {
      position: absolute;
      right: 12px;
      color: #94a3b8;
      cursor: pointer;
      font-size: 13px;
      padding: 6px;
      transition: color 0.2s ease;
    }

    .toggle-password-eye:hover {
      color: #0f172a;
    }

    /* Aux Row */
    .form-aux-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 10px 0 16px;
      font-size: 12px;
    }

    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 7px;
      cursor: pointer;
      color: #334155;
      font-weight: 600;
      user-select: none;
    }

    .checkbox-label input[type="checkbox"] {
      width: 15px;
      height: 15px;
      accent-color: var(--primary);
      cursor: pointer;
      border-radius: 4px;
    }

    .forgot-link {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      transition: opacity 0.2s ease;
    }

    .forgot-link:hover {
      text-decoration: underline;
      opacity: 0.85;
    }

    /* Captcha Box */
    .captcha-card-box {
      background: #fff7ed;
      border: 1px solid #fed7aa;
      border-radius: var(--radius-md);
      padding: 10px 12px;
      margin-bottom: 14px;
    }

    .captcha-top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 7px;
      font-size: 10.5px;
      font-weight: 700;
    }

    .captcha-label-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .captcha-enter-txt {
      color: #64748b;
      font-size: 10.5px;
    }

    .captcha-interactive-row {
      display: grid;
      grid-template-columns: 1.1fr auto 1.2fr;
      gap: 7px;
      align-items: center;
    }

    .captcha-display {
      background: #ffffff;
      border: 1px solid #fed7aa;
      border-radius: 8px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Space Grotesk', monospace;
      font-size: 16px;
      font-weight: 800;
      letter-spacing: 4px;
      color: #0f172a;
      user-select: none;
      background-image: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(254, 215, 170, 0.35) 5px, rgba(254, 215, 170, 0.35) 10px);
    }

    .captcha-refresh-btn {
      width: 36px;
      height: 36px;
      border-radius: 8px;
      border: 1px solid #fed7aa;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .captcha-refresh-btn:hover {
      background: #ffedd5;
      transform: rotate(45deg);
    }

    .captcha-input {
      height: 36px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      padding: 0 8px;
      font-size: 12.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      outline: none;
      font-family: monospace;
      text-align: center;
      background: #ffffff;
    }

    .captcha-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.15);
    }

    /* Submit Button - Bold Premium Orange */
    .auth-submit-btn {
      width: 100%;
      height: 48px;
      background: var(--primary-gradient);
      border: none;
      border-radius: 9999px;
      color: #ffffff;
      font-size: 15px;
      font-weight: 700;
      letter-spacing: 0.3px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: pointer;
      box-shadow: 0 8px 24px rgba(255, 107, 0, 0.45);
      transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
      font-family: var(--font-main);
      position: relative;
      overflow: hidden;
    }

    .auth-submit-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
      transition: left 0.5s ease;
    }

    .auth-submit-btn:hover::before {
      left: 100%;
    }

    .auth-submit-btn:hover {
      background: linear-gradient(135deg, #ea580c 0%, #ff7a1f 100%);
      box-shadow: 0 12px 30px rgba(255, 107, 0, 0.55);
      transform: translateY(-2px) scale(1.01);
    }

    .auth-submit-btn:active {
      transform: translateY(1px) scale(0.99);
      box-shadow: 0 4px 12px rgba(255, 107, 0, 0.35);
    }

    /* Switch Footer */
    .auth-switch-footer {
      text-align: center;
      margin-top: 14px;
      font-size: 12.5px;
      color: #64748b;
      font-weight: 500;
    }

    .auth-switch-btn {
      background: none;
      border: none;
      color: var(--primary);
      font-weight: 700;
      cursor: pointer;
      padding: 0 3px;
      font-size: 12.5px;
      font-family: var(--font-main);
      text-decoration: none;
    }

    .auth-switch-btn:hover {
      text-decoration: underline;
    }

    .ssl-security-footer {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      margin-top: 16px;
      font-size: 11px;
      font-weight: 600;
      color: #64748b;
    }

    .ssl-security-footer i {
      color: #10b981;
      font-size: 11px;
    }

    .form-view-container {
      transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .hidden-view {
      display: none !important;
      opacity: 0;
      transform: scale(0.98);
    }

    /* Mobile: small card adjustments */
    @media (max-width: 640px) {
      .auth-card {
        padding: 24px 18px 20px;
        border-radius: 16px;
      }
      .brand-title {
        font-size: 22px;
      }
      .auth-heading {
        font-size: 22px;
      }
      .form-control-input {
        height: 44px;
        font-size: 13px;
      }
      .auth-submit-btn {
        height: 44px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <!-- Atom Particle Canvas Background -->
  <canvas id="atomCanvas"></canvas>
  <!-- Dark Gradient Overlay -->
  <div class="bg-overlay"></div>

  <!-- Main Viewport -->
  <main class="app-viewport">
    <div class="split-grid">

      <!-- ========================================================
           LEFT 60%: CAROUSEL SHOWCASE
           ======================================================== -->
      <div class="split-left">

        <!-- Top Floating Badge in Showcase -->
        <div class="top-float-badge">
          <span class="pulse-dot"></span>
          <span>1-Day Free Trial</span>
        </div>

        <!-- Bottom Floating Badge in Showcase -->
        <div class="bottom-float-badge">
          <div class="icon-wrap">
            <i class="fa-solid fa-bolt"></i>
          </div>
          <div class="badge-text-group">
            <span>Smart NFC & QR</span>
            <span class="badge-sub">Instant Feedback</span>
          </div>
        </div>

      <section class="showcase-card" id="showcaseContainer">
        
        <div class="carousel-wrapper">
          <div class="carousel-track" id="carouselTrack">
            
            <!-- SLIDE 1: INTERACTIVE PRIZE WHEEL -->
            <div class="carousel-slide" data-slide="0">
              <div class="feature-pill-badge">
                <i class="fa-solid fa-dharmachakra"></i>
                <span>Interactive Prize Wheel</span>
              </div>

              <!-- Phone Mockup Frame -->
              <div class="phone-mockup-wrapper">

                <!-- Phone -->
                <div class="phone-mockup">
                  <div class="phone-island">
                    <div class="phone-lens"></div>
                  </div>

                  <div class="phone-screen">
                    <div class="phone-status-bar">
                      <span>9:41</span>
                      <div class="status-icons">
                        <i class="fa-solid fa-signal"></i>
                        <i class="fa-solid fa-wifi"></i>
                        <i class="fa-solid fa-battery-full"></i>
                      </div>
                    </div>

                    <!-- Wheel Screen Content -->
                    <div class="wheel-screen-content">
                      <div class="wheel-sub-badge">
                        <i class="fa-solid fa-trophy"></i> Spin & Win
                      </div>
                      <div class="wheel-title-small">Lucky Prize Wheel</div>

                      <div class="wheel-canvas-container">
                        <div class="wheel-pointer-pin">
                          <svg viewBox="0 0 24 24">
                            <polygon points="12,24 0,0 24,0" />
                          </svg>
                        </div>

                        <!-- SVG Wheel Disc with Orange & Colorful Slices -->
                        <div class="wheel-disc" id="interactiveWheel" onclick="spinDemoWheel()">
                          <svg viewBox="0 0 300 300">
                            <!-- Slice 1: Vibrant Orange -->
                            <path d="M150,150 L150,10 A140,140 0 0,1 271.24,80 Z" fill="#ff6b00" />
                            <text x="195" y="75" fill="#ffffff" font-size="12" font-weight="bold" transform="rotate(30, 195, 75)">20% OFF</text>
                            
                            <!-- Slice 2: Royal Blue -->
                            <path d="M150,150 L271.24,80 A140,140 0 0,1 271.24,220 Z" fill="#2563eb" />
                            <text x="215" y="155" fill="#ffffff" font-size="12" font-weight="bold" transform="rotate(90, 215, 155)">FREE GIFT</text>
                            
                            <!-- Slice 3: Emerald Green -->
                            <path d="M150,150 L271.24,220 A140,140 0 0,1 150,290 Z" fill="#059669" />
                            <text x="195" y="235" fill="#ffffff" font-size="12" font-weight="bold" transform="rotate(150, 195, 235)">10% OFF</text>
                            
                            <!-- Slice 4: Amber Gold -->
                            <path d="M150,150 L150,290 A140,140 0 0,1 28.76,220 Z" fill="#f59e0b" />
                            <text x="105" y="235" fill="#ffffff" font-size="12" font-weight="bold" transform="rotate(210, 105, 235)">JACKPOT!</text>
                            
                            <!-- Slice 5: Purple -->
                            <path d="M150,150 L28.76,220 A140,140 0 0,1 28.76,80 Z" fill="#7c3aed" />
                            <text x="85" y="155" fill="#ffffff" font-size="12" font-weight="bold" transform="rotate(270, 85, 155)">COFFEE</text>
                            
                            <!-- Slice 6: Deep Coral -->
                            <path d="M150,150 L28.76,80 A140,140 0 0,1 150,10 Z" fill="#ea580c" />
                            <text x="105" y="75" fill="#ffffff" font-size="12" font-weight="bold" transform="rotate(330, 105, 75)">50% OFF</text>

                            <!-- Outer gold accent rim -->
                            <circle cx="150" cy="150" r="140" fill="none" stroke="#fed7aa" stroke-width="4" />
                            <circle cx="150" cy="16" r="3" fill="#ffffff" />
                            <circle cx="266" cy="83" r="3" fill="#ffffff" />
                            <circle cx="266" cy="217" r="3" fill="#ffffff" />
                            <circle cx="150" cy="284" r="3" fill="#ffffff" />
                            <circle cx="34" cy="217" r="3" fill="#ffffff" />
                            <circle cx="34" cy="83" r="3" fill="#ffffff" />
                          </svg>
                        </div>

                        <!-- Center Spin Knob -->
                        <div class="wheel-center-knob" onclick="spinDemoWheel()">
                          <span>SPIN</span>
                          <i class="fa-solid fa-play"></i>
                        </div>
                      </div>

                      <div class="wheel-result-banner" id="wheelPrizeText">
                        <i class="fa-solid fa-sparkles"></i> Click SPIN to win!
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Slide description -->
              <h2 class="slide-headline">Interactive Lucky Spin &amp; Prize Wheel</h2>
              <p class="slide-desc">
                Delight customers with gamified spin-the-wheel campaigns. Win exciting discount vouchers, free gifts, cashbacks, and bumper jackpot rewards with customized prize stocks and winning chances.
              </p>
            </div>

            <!-- SLIDE 2: SUBMIT HIS DETAILS (LEAD CAPTURE BEFORE SPIN) -->
            <div class="carousel-slide" data-slide="1">
              <div class="feature-pill-badge">
                <i class="fa-solid fa-id-card"></i>
                <span>Customer Details & Lead Capture</span>
              </div>

              <div class="phone-mockup-wrapper">
                
                <!-- Left Floating Card -->
                <div class="side-float-badge side-float-left">
                  <div class="badge-icon-sq badge-icon-orange">
                    <i class="fa-solid fa-user-check"></i>
                  </div>
                  <div class="badge-content-text">
                    <span class="badge-title-txt">Verified Leads</span>
                    <span class="badge-sub-txt">100% Real Customers</span>
                  </div>
                </div>

                <!-- Right Floating Card -->
                <div class="side-float-badge side-float-right">
                  <div class="badge-icon-sq badge-icon-yellow">
                    <i class="fa-brands fa-whatsapp"></i>
                  </div>
                  <div class="badge-content-text">
                    <span class="badge-title-txt">WhatsApp Sync</span>
                    <span class="badge-sub-txt">Instant Prize Voucher</span>
                  </div>
                </div>

                <!-- Phone Mockup with Customer Details Form -->
                <div class="phone-mockup">
                  <div class="phone-island">
                    <div class="phone-lens"></div>
                  </div>

                  <div class="phone-screen">
                    <div class="phone-status-bar">
                      <span>9:41</span>
                      <div class="status-icons">
                        <i class="fa-solid fa-signal"></i>
                        <i class="fa-solid fa-wifi"></i>
                        <i class="fa-solid fa-battery-full"></i>
                      </div>
                    </div>

                    <!-- Customer Lead Capture Form Screen -->
                    <div class="lead-form-screen">
                      <div class="lead-form-header">
                        <span class="mini-gift-badge">
                          <i class="fa-solid fa-gift"></i> Step 1 of 2
                        </span>
                        <h4>Enter Details to Spin</h4>
                        <p>Fill in your details below to unlock your lucky spin & receive coupon on WhatsApp.</p>
                      </div>

                      <div class="mock-field-group">
                        <label class="mock-field-label">Your Full Name</label>
                        <div class="mock-input-box">
                          <i class="fa-regular fa-user"></i>
                          <span>Alex Morgan</span>
                        </div>
                      </div>

                      <div class="mock-field-group">
                        <label class="mock-field-label">WhatsApp Number</label>
                        <div class="mock-input-box">
                          <i class="fa-brands fa-whatsapp" style="color:#25d366;"></i>
                          <span>+91 98765 43210</span>
                        </div>
                      </div>

                      <div class="mock-field-group">
                        <label class="mock-field-label">Email Address</label>
                        <div class="mock-input-box">
                          <i class="fa-regular fa-envelope"></i>
                          <span>alex.morgan@gmail.com</span>
                        </div>
                      </div>

                      <button class="mock-submit-btn">
                        <span>Submit & Unlock Spin</span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </button>

                      <div class="mock-trust-note">
                        <i class="fa-solid fa-shield-check" style="color:#10b981;"></i>
                        <span>Zero Spam • Instant WhatsApp Delivery</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Slide text details -->
              <h2 class="slide-headline">Instant Lead & Contact Capture</h2>
              <p class="slide-desc">
                Collect verified customer WhatsApp numbers, names, and emails automatically before visitors spin the prize wheel or leave your store.
              </p>

              <!-- Tags / Chips -->
              <div class="feature-tags-row">
                <span class="feature-tag-chip"><i class="fa-solid fa-clipboard-check text-success"></i> Smart Lead Form</span>
                <span class="feature-tag-chip"><i class="fa-brands fa-whatsapp text-success"></i> WhatsApp Auto-Send</span>
                <span class="feature-tag-chip"><i class="fa-solid fa-shield-halved" style="color:var(--primary);"></i> 1 Spin Per Device</span>
                <span class="feature-tag-chip"><i class="fa-solid fa-bolt text-warning"></i> Instant CRM Sync</span>
              </div>
            </div>

            <!-- SLIDE 3: SMART NFC & QR CODE STANDS -->
            <div class="carousel-slide" data-slide="2">
              <div class="feature-pill-badge">
                <i class="fa-solid fa-qrcode"></i>
                <span>Smart NFC & QR Displays</span>
              </div>

              <div class="phone-mockup-wrapper">
                
                <!-- Left Floating Card -->
                <div class="side-float-badge side-float-left">
                  <div class="badge-icon-sq badge-icon-orange">
                    <i class="fa-solid fa-chart-line"></i>
                  </div>
                  <div class="badge-content-text">
                    <span class="badge-title-txt">3x Reviews</span>
                    <span class="badge-sub-txt">5-Star Google Rating</span>
                  </div>
                </div>

                <!-- Right Floating Card -->
                <div class="side-float-badge side-float-right">
                  <div class="badge-icon-sq badge-icon-yellow">
                    <i class="fa-solid fa-award"></i>
                  </div>
                  <div class="badge-content-text">
                    <span class="badge-title-txt">Instant Coupon</span>
                    <span class="badge-sub-txt">Store Repeat Visits</span>
                  </div>
                </div>

                <div class="phone-mockup">
                  <div class="phone-island">
                    <div class="phone-lens"></div>
                  </div>

                  <div class="phone-screen">
                    <div class="phone-status-bar">
                      <span>9:41</span>
                      <div class="status-icons">
                        <i class="fa-solid fa-signal"></i>
                        <i class="fa-solid fa-wifi"></i>
                        <i class="fa-solid fa-battery-full"></i>
                      </div>
                    </div>

                    <div class="rewards-screen-content">
                      <div class="reward-voucher-box">
                        <div style="font-size:10px; color:#64748b; text-transform:uppercase; font-weight:700;">Claimed Reward</div>
                        <div class="voucher-discount">20% OFF</div>
                        <div class="voucher-title">Valid On Any Order Above $25</div>
                        <div class="qr-stand-mini">
                          <img src="{{ asset('frontend/images/qr.jpg') }}" alt="Voucher QR Code" onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PRIZE20'" />
                        </div>
                        <div style="font-size:10px; font-weight:700; color:#0f172a; margin-top:3px;">CODE: SPIN-WIN-2024</div>
                      </div>

                      <div style="background:#fff7ed; border-radius:12px; padding:7px 10px; border:1px solid #fed7aa; font-size:10px; color:#c2410c; text-align:center; font-weight:600;">
                        <i class="fa-brands fa-whatsapp" style="color:#25d366; margin-right:4px;"></i> Voucher coupon sent to customer phone!
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Slide text details -->
              <h2 class="slide-headline">Smart QR Stands & Rewards</h2>
              <p class="slide-desc">
                Place physical QR stands on tables or checkout counters. Reward visitors with coupons while generating 5-star Google reviews.
              </p>

              <!-- Tags / Chips -->
              <div class="feature-tags-row">
                <span class="feature-tag-chip"><i class="fa-solid fa-qrcode text-danger"></i> Custom QR Stands</span>
                <span class="feature-tag-chip"><i class="fa-brands fa-whatsapp text-success"></i> WhatsApp CRM</span>
                <span class="feature-tag-chip"><i class="fa-solid fa-nfc-symbol text-primary"></i> 1-Tap NFC Tap</span>
              </div>
            </div>

          </div>
        </div>

        <!-- Carousel Footer with Credibility Badges & Navigation -->
        <div class="carousel-nav-footer">
          <div class="trust-avatar-group">
            <div class="avatar-stack">
              <div class="avatar-circle avatar-1">AR</div>
              <div class="avatar-circle avatar-2">BK</div>
              <div class="avatar-circle avatar-3">RD</div>
              <div class="avatar-circle avatar-4">+k</div>
            </div>
            <div class="trust-text">
              Trusted by <strong>5,000+ businesses</strong>
            </div>
          </div>

          <div class="carousel-pagination-controls">
            <div class="carousel-indicators">
              <span class="indicator-dot active" onclick="goToSlide(0)"></span>
              <span class="indicator-dot" onclick="goToSlide(1)"></span>
              <span class="indicator-dot" onclick="goToSlide(2)"></span>
            </div>

            <div class="carousel-arrows">
              <button class="carousel-arrow-btn" onclick="prevSlide()" aria-label="Previous Slide">
                <i class="fa-solid fa-chevron-left"></i>
              </button>
              <button class="carousel-arrow-btn" onclick="nextSlide()" aria-label="Next Slide">
                <i class="fa-solid fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>

      </section>
      </div>

      <!-- Vertical Divider -->
      <div class="split-divider" aria-hidden="true"></div>

      <!-- ========================================================
           RIGHT 40%: LOGIN & REGISTRATION
           ======================================================== -->
      <div class="split-right">
      <section class="auth-card-container">
        
        <div class="auth-card">
          
          <!-- Brand Logo Header -->
          <div class="brand-header-wrap">
            <a href="{{ url('/') }}" class="brand-logo-row">
              <div class="brand-logo-icon">
                <i class="fa-solid fa-dharmachakra"></i>
              </div>
              <div class="brand-title">Prize<span>Wheel</span></div>
            </a>

            <!-- Intuitive Segmented Tab Switcher -->
            <div class="auth-tab-switcher">
              <button type="button" class="tab-btn {{ ($initialMode ?? 'login') !== 'signup' ? 'active' : '' }}" id="tabLoginBtn" onclick="switchToMode('login')">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
              </button>
              <button type="button" class="tab-btn {{ ($initialMode ?? 'login') === 'signup' ? 'active' : '' }}" id="tabSignupBtn" onclick="switchToMode('signup')">
                <i class="fa-solid fa-user-plus"></i> Create Account
              </button>
            </div>
          </div>

          <!-- ====================================================
               LOGIN VIEW
               ==================================================== -->
          <div id="loginViewContainer" class="form-view-container {{ ($initialMode ?? 'login') === 'signup' ? 'hidden-view' : '' }}">
            
            <div style="text-align:center;">
              <div class="form-mode-tag">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Business Dashboard</span>
              </div>
              <h1 class="auth-heading">Welcome Back</h1>
              <p class="auth-subheading">
                Sign in to manage your QR code stands, prize wheels, and customer campaigns.
              </p>
            </div>

            <!-- Sign in with Google Button -->
            <a href="{{ route('google_login') }}" class="google-btn" title="Sign in with your Google account">
              <svg viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
              </svg>
              <span>Sign In with Google</span>
            </a>

            <!-- Divider -->
            <div class="auth-divider">
              <span>OR SIGN IN WITH EMAIL</span>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ url('login_post') }}" id="loginForm">
              @csrf

              <div class="form-group">
                <label class="form-label" for="loginEmail">Email Address</label>
                <div class="input-with-icon">
                  <input 
                    type="email" 
                    id="loginEmail" 
                    name="email" 
                    class="form-control-input" 
                    placeholder="contact@business.com" 
                    required 
                    autocomplete="email"
                  />
                  <i class="fa-regular fa-envelope input-icon-left"></i>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label" for="loginPassword">Password</label>
                <div class="input-with-icon">
                  <input 
                    type="password" 
                    id="loginPassword" 
                    name="password" 
                    class="form-control-input" 
                    placeholder="••••••••" 
                    required 
                    autocomplete="current-password"
                  />
                  <i class="fa-solid fa-lock input-icon-left"></i>
                  <i class="fa-regular fa-eye toggle-password-eye" onclick="togglePasswordVisibility('loginPassword', this)"></i>
                </div>
              </div>

              <div class="form-aux-row">
                <label class="checkbox-label">
                  <input type="checkbox" name="remember" checked />
                  <span>Remember me</span>
                </label>
                <a href="{{ url('forgotPassword') }}" class="forgot-link">Forgot password?</a>
              </div>

              <button type="submit" class="auth-submit-btn">
                <span>Sign In to Dashboard</span>
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </form>

            <div class="auth-switch-footer">
              <span>Don't have an account?</span>
              <button type="button" class="auth-switch-btn" onclick="switchToMode('signup')">Create Account</button>
            </div>

            <div class="ssl-security-footer">
              <i class="fa-solid fa-shield-check"></i>
              <span>256-Bit SSL Encrypted • ISO 27001 Certified</span>
            </div>

          </div>


          <!-- ====================================================
               SIGNUP VIEW (CREATE ACCOUNT)
               ==================================================== -->
          <div id="signupViewContainer" class="form-view-container {{ ($initialMode ?? 'login') === 'signup' ? '' : 'hidden-view' }}">
            
            <div style="text-align:center;">
              <div class="form-mode-tag">
                <i class="fa-solid fa-rocket"></i>
                <span>1-Day Free Trial</span>
              </div>
              <h1 class="auth-heading">Create Account</h1>
              <p class="auth-subheading">
                Set up your business profile to start launching prize wheels & collecting reviews.
              </p>
            </div>

            <!-- Sign up with Google Button -->
            <a href="{{ route('google_login') }}" class="google-btn" title="Sign up with your Google account">
              <svg viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
              </svg>
              <span>Sign Up with Google</span>
            </a>

            <!-- Divider -->
            <div class="auth-divider">
              <span>OR REGISTER WITH EMAIL</span>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register_post') }}" id="signupForm">
              @csrf

              <!-- Business / Store Name -->
              <div class="form-group">
                <label class="form-label" for="regName">Business / Store Name</label>
                <div class="input-with-icon">
                  <input 
                    type="text" 
                    id="regName" 
                    name="name" 
                    class="form-control-input" 
                    placeholder="e.g. Apex Dental Clinic, Royal TVS" 
                    required 
                    autocomplete="organization"
                  />
                  <i class="fa-solid fa-store input-icon-left"></i>
                </div>
              </div>

              <!-- Email Address -->
              <div class="form-group">
                <label class="form-label" for="regEmail">Email Address</label>
                <div class="input-with-icon">
                  <input 
                    type="email" 
                    id="regEmail" 
                    name="email" 
                    class="form-control-input" 
                    placeholder="contact@business.com" 
                    required 
                    autocomplete="email"
                  />
                  <i class="fa-regular fa-envelope input-icon-left"></i>
                </div>
              </div>

              <!-- WhatsApp Number -->
              <div class="form-group">
                <label class="form-label" for="regPhone">WhatsApp / Contact Number</label>
                <div class="input-with-icon">
                  <input 
                    type="tel" 
                    id="regPhone" 
                    name="phone" 
                    class="form-control-input" 
                    placeholder="+91 98765 43210" 
                    autocomplete="tel"
                  />
                  <i class="fa-brands fa-whatsapp input-icon-left" style="color:#25d366;"></i>
                </div>
              </div>

              <!-- Password -->
              <div class="form-group">
                <label class="form-label" for="regPassword">Password</label>
                <div class="input-with-icon">
                  <input 
                    type="password" 
                    id="regPassword" 
                    name="password" 
                    class="form-control-input" 
                    placeholder="Minimum 6 characters" 
                    required 
                    minlength="6"
                    autocomplete="new-password"
                  />
                  <i class="fa-solid fa-lock input-icon-left"></i>
                  <i class="fa-regular fa-eye toggle-password-eye" onclick="togglePasswordVisibility('regPassword', this)"></i>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="form-group">
                <label class="form-label" for="regConfirmPassword">Confirm Password</label>
                <div class="input-with-icon">
                  <input 
                    type="password" 
                    id="regConfirmPassword" 
                    name="password_confirmation" 
                    class="form-control-input" 
                    placeholder="Re-enter password" 
                    required 
                    minlength="6"
                    autocomplete="new-password"
                  />
                  <i class="fa-solid fa-shield-halved input-icon-left"></i>
                  <i class="fa-regular fa-eye toggle-password-eye" onclick="togglePasswordVisibility('regConfirmPassword', this)"></i>
                </div>
              </div>

              <!-- Captcha Box -->
              <div class="captcha-card-box">
                <div class="captcha-top-row">
                  <span class="captcha-label-badge">
                    <i class="fa-solid fa-shield-check"></i> Human Verification
                  </span>
                  <span class="captcha-enter-txt">Enter code</span>
                </div>

                <div class="captcha-interactive-row">
                  <div class="captcha-display" id="captchaCodeDisplay">{{ session('captcha_code', '5URV6') }}</div>
                  <button type="button" class="captcha-refresh-btn" onclick="refreshCaptcha()" title="Refresh code">
                    <i class="fa-solid fa-rotate-right"></i>
                  </button>
                  <input type="text" name="captcha" id="captchaInput" class="captcha-input" placeholder="CODE" maxlength="8" required />
                </div>
              </div>

              <!-- Terms Checkbox -->
              <div style="margin: 10px 0 14px;">
                <label class="checkbox-label" style="font-size:11.5px; align-items:flex-start;">
                  <input type="checkbox" name="terms" required checked style="margin-top:2px;" />
                  <span>I agree to the <a href="#" style="color:var(--primary); text-decoration:none; font-weight:700;">Terms of Service</a> & <a href="#" style="color:var(--primary); text-decoration:none; font-weight:700;">Privacy Policy</a></span>
                </label>
              </div>

              <button type="submit" class="auth-submit-btn">
                <span>Create Account & Start 1-Day Trial</span>
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            </form>

            <div class="auth-switch-footer">
              <span>Already have an account?</span>
              <button type="button" class="auth-switch-btn" onclick="switchToMode('login')">Sign In</button>
            </div>

            <div class="ssl-security-footer">
              <i class="fa-solid fa-shield-check"></i>
              <span>256-Bit SSL Encrypted • 1-Day Full Access Trial</span>
            </div>

          </div>

        </div>

      </section>
      </div><!-- /split-right -->

    </div>
  </main>

  <!-- jQuery & Toastr JS -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script>
    toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: "4500",
      showDuration: "300",
      hideDuration: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut"
    };

    @if(Session::has('messege'))
      var type = "{{ Session::get('alert-type','info') }}";
      var msg = "{{ Session::get('messege') }}";
      switch(type) {
        case 'info': toastr.info(msg); break;
        case 'success': toastr.success(msg); break;
        case 'warning':
        case 'worning': toastr.warning(msg); break;
        case 'error': toastr.error(msg); break;
      }
    @endif

    function togglePasswordVisibility(inputId, eyeIcon) {
      const input = document.getElementById(inputId);
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }

    function switchToMode(mode) {
      const loginView = document.getElementById('loginViewContainer');
      const signupView = document.getElementById('signupViewContainer');
      const tabLogin = document.getElementById('tabLoginBtn');
      const tabSignup = document.getElementById('tabSignupBtn');

      if (mode === 'signup') {
        loginView.classList.add('hidden-view');
        signupView.classList.remove('hidden-view');
        tabLogin.classList.remove('active');
        tabSignup.classList.add('active');
        window.location.hash = 'signup';
      } else {
        signupView.classList.add('hidden-view');
        loginView.classList.remove('hidden-view');
        tabSignup.classList.remove('active');
        tabLogin.classList.add('active');
        window.location.hash = 'login';
      }
    }

    window.addEventListener('DOMContentLoaded', () => {
      const hash = window.location.hash.toLowerCase();
      if (hash === '#signup' || window.location.search.includes('mode=signup')) {
        switchToMode('signup');
      } else if (hash === '#login' || window.location.search.includes('mode=login')) {
        switchToMode('login');
      }
    });

    function refreshCaptcha() {
      const btn = document.querySelector('.captcha-refresh-btn i');
      if (btn) btn.classList.add('fa-spin');

      fetch("{{ route('captcha_refresh') }}")
        .then(response => response.json())
        .then(data => {
          if (data && data.captcha) {
            document.getElementById('captchaCodeDisplay').innerText = data.captcha;
          }
        })
        .catch(err => {
          console.error("Captcha refresh error:", err);
        })
        .finally(() => {
          if (btn) btn.classList.remove('fa-spin');
        });
    }

    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
      signupForm.addEventListener('submit', function (e) {
        const p1 = document.getElementById('regPassword').value;
        const p2 = document.getElementById('regConfirmPassword').value;
        if (p1 !== p2) {
          e.preventDefault();
          toastr.error("Passwords do not match. Please re-enter.");
          return false;
        }
      });
    }

    // Carousel Logic (Manual Navigation Only - Auto-Play Disabled)
    let currentSlide = 0;
    const totalSlides = 3;
    const track = document.getElementById('carouselTrack');
    const dots = document.querySelectorAll('.indicator-dot');

    function goToSlide(index) {
      currentSlide = (index + totalSlides) % totalSlides;
      const offset = -(currentSlide * 33.333333);
      if (track) {
        track.style.transform = `translateX(${offset}%)`;
      }

      dots.forEach((dot, idx) => {
        if (idx === currentSlide) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    }

    function nextSlide() {
      goToSlide(currentSlide + 1);
    }

    function prevSlide() {
      goToSlide(currentSlide - 1);
    }

    // Wheel Spin Micro-Animation
    let currentWheelRotation = 0;
    let isSpinning = false;
    const prizes = [
      "20% Discount Coupon! 🎁",
      "Free Refreshing Drink! 🥤",
      "10% Cashback Bonus! 💰",
      "JACKPOT! $50 Gift Card! 🏆",
      "Free Specialty Coffee! ☕",
      "50% Off Next Order! 🎉"
    ];

    function spinDemoWheel() {
      if (isSpinning) return;
      isSpinning = true;

      const wheel = document.getElementById('interactiveWheel');
      const banner = document.getElementById('wheelPrizeText');

      banner.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Spinning lucky wheel...`;

      const randomSlices = Math.floor(Math.random() * 6);
      const randomDeg = (5 * 360) + (randomSlices * 60) + 30;
      currentWheelRotation += randomDeg;

      wheel.style.transform = `rotate(${currentWheelRotation}deg)`;

      setTimeout(() => {
        isSpinning = false;
        const wonPrize = prizes[randomSlices % prizes.length];
        banner.innerHTML = `<i class="fa-solid fa-trophy"></i> Won: ${wonPrize}`;

        if (typeof confetti === 'function') {
          confetti({
            particleCount: 45,
            spread: 60,
            origin: { y: 0.6 }
          });
        }
      }, 4000);
    }

    // ===================================================
    // ATOM & ORBITAL BOHR SIMULATION CANVAS ANIMATION
    // High-visibility animated atomic nuclei, electron orbits,
    // and interactive molecular particle plexus
    // ===================================================
    (function initAtomCanvas() {
      const canvas = document.getElementById('atomCanvas');
      if (!canvas) return;
      const ctx = canvas.getContext('2d');

      let W, H, animFrame;
      const PARTICLE_COUNT = 75;
      const CONNECTION_DIST = 140;
      const MOUSE = { x: -9999, y: -9999 };

      // Track mouse for interactivity
      window.addEventListener('mousemove', e => {
        MOUSE.x = e.clientX;
        MOUSE.y = e.clientY;
      });

      function resize() {
        W = canvas.width = window.innerWidth;
        H = canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resize);
      resize();

      // Free-floating particle class
      class Particle {
        constructor() { this.reset(true); }
        reset(init) {
          // Concentrate particles mostly in showcase left 60%
          const maxStartX = window.innerWidth > 1024 ? W * 0.60 : W;
          this.x = Math.random() * maxStartX;
          this.y = init ? Math.random() * H : -10;
          this.r = 1.8 + Math.random() * 2.6;
          const speed = 0.25 + Math.random() * 0.45;
          const angle = Math.random() * Math.PI * 2;
          this.vx = Math.cos(angle) * speed;
          this.vy = Math.sin(angle) * speed * 0.6 + 0.1;
          this.alpha = 0.35 + Math.random() * 0.45;
          
          // High-visibility orange / warm amber / indigo palette
          const palette = [
            `rgba(255, 107, 0, ${this.alpha})`,
            `rgba(249, 115, 22, ${this.alpha * 0.9})`,
            `rgba(245, 158, 11, ${this.alpha * 0.85})`,
            `rgba(99, 102, 241, ${this.alpha * 0.75})`,
            `rgba(14, 165, 233, ${this.alpha * 0.7})`
          ];
          this.color = palette[Math.floor(Math.random() * palette.length)];
        }
        update() {
          // React to mouse proximity
          const dx = MOUSE.x - this.x;
          const dy = MOUSE.y - this.y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < 180) {
            this.vx += dx * 0.00015;
            this.vy += dy * 0.00015;
          }

          this.x += this.vx;
          this.y += this.vy;
          this.vx *= 0.998;
          this.vy *= 0.998;

          const maxX = window.innerWidth > 1024 ? W * 0.60 : W + 20;
          if (this.x < -20) this.x = maxX - 10;
          if (this.x > maxX) this.x = -10;
          if (this.y < -20) this.y = H + 10;
          if (this.y > H + 20) this.y = -10;
        }
        draw() {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
          ctx.fillStyle = this.color;
          ctx.fill();
        }
      }

      // Enhanced Bohr Atomic Model Class
      // Distinct glowing nucleus with 3 rotating orbital rings and orbiting electrons
      class AtomModel {
        constructor(x, y, scale = 1.0) {
          this.x = x;
          this.y = y;
          this.scale = scale;
          this.coreR = (4.5 + Math.random() * 3) * scale;
          this.pulse = Math.random() * Math.PI * 2;
          
          // 3 Distinct orbital rings with varied tilts and angles
          this.orbits = [
            { r: 42 * scale, tilt: 0.45, angle: 0, rotAngle: 0.2, speed: 0.016, color: 'rgba(255, 107, 0, 0.45)', electronColor: '#ff6b00' },
            { r: 72 * scale, tilt: 0.50, angle: Math.PI / 3, rotAngle: 1.25, speed: -0.012, color: 'rgba(99, 102, 241, 0.40)', electronColor: '#6366f1' },
            { r: 104 * scale, tilt: 0.42, angle: (Math.PI * 2) / 3, rotAngle: 2.35, speed: 0.009, color: 'rgba(245, 158, 11, 0.42)', electronColor: '#f59e0b' }
          ];

          // Gentle floating motion
          this.baseX = x;
          this.baseY = y;
          this.floatAngle = Math.random() * Math.PI * 2;
          this.floatSpeed = 0.008 + Math.random() * 0.006;
          this.floatAmpX = 14 + Math.random() * 10;
          this.floatAmpY = 16 + Math.random() * 12;
        }

        update() {
          this.pulse += 0.035;
          this.floatAngle += this.floatSpeed;
          this.x = this.baseX + Math.cos(this.floatAngle) * this.floatAmpX;
          this.y = this.baseY + Math.sin(this.floatAngle * 0.8) * this.floatAmpY;

          // Update orbital angles for electrons
          this.orbits.forEach(orb => {
            orb.angle += orb.speed;
          });
        }

        draw() {
          const pulseFactor = 0.85 + 0.25 * Math.sin(this.pulse);

          // 1. Nucleus Outer Halo
          const haloGrad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.coreR * 6 * pulseFactor);
          haloGrad.addColorStop(0, 'rgba(255, 107, 0, 0.35)');
          haloGrad.addColorStop(0.5, 'rgba(249, 115, 22, 0.12)');
          haloGrad.addColorStop(1, 'rgba(255, 107, 0, 0)');
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.coreR * 6 * pulseFactor, 0, Math.PI * 2);
          ctx.fillStyle = haloGrad;
          ctx.fill();

          // 2. Nucleus Core
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.coreR * pulseFactor, 0, Math.PI * 2);
          ctx.fillStyle = '#ff6b00';
          ctx.fill();

          // Core inner highlight
          ctx.beginPath();
          ctx.arc(this.x - this.coreR * 0.3, this.y - this.coreR * 0.3, this.coreR * 0.4, 0, Math.PI * 2);
          ctx.fillStyle = '#ffffff';
          ctx.fill();

          // 3. Orbital Elliptical Rings & Orbiting Electrons
          this.orbits.forEach(orb => {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate(orb.rotAngle);
            ctx.scale(1, orb.tilt);

            // Orbit line
            ctx.beginPath();
            ctx.arc(0, 0, orb.r, 0, Math.PI * 2);
            ctx.strokeStyle = orb.color;
            ctx.lineWidth = 1.4;
            ctx.stroke();

            // Orbiting electron position along ellipse
            const ex = Math.cos(orb.angle) * orb.r;
            const ey = Math.sin(orb.angle) * orb.r;

            // Electron glow
            ctx.beginPath();
            ctx.arc(ex, ey, 5.5, 0, Math.PI * 2);
            ctx.fillStyle = orb.color;
            ctx.fill();

            // Electron particle
            ctx.beginPath();
            ctx.arc(ex, ey, 2.8, 0, Math.PI * 2);
            ctx.fillStyle = orb.electronColor;
            ctx.fill();

            // Electron bright center
            ctx.beginPath();
            ctx.arc(ex, ey, 1.2, 0, Math.PI * 2);
            ctx.fillStyle = '#ffffff';
            ctx.fill();

            ctx.restore();
          });
        }
      }

      // Initialize Particles & Atom Models
      const particles = Array.from({ length: PARTICLE_COUNT }, () => new Particle());
      let atomModels = [];

      function createAtoms() {
        atomModels = [];
        const isDesktop = W > 1024;
        const showcaseW = isDesktop ? W * 0.68 : W;

        // Position recognizable Bohr atoms across showcase space
        atomModels.push(new AtomModel(showcaseW * 0.18, H * 0.25, 1.15));
        atomModels.push(new AtomModel(showcaseW * 0.82, H * 0.32, 1.05));
        atomModels.push(new AtomModel(showcaseW * 0.22, H * 0.78, 1.2));
        atomModels.push(new AtomModel(showcaseW * 0.78, H * 0.75, 0.95));
      }

      createAtoms();
      window.addEventListener('resize', createAtoms);

      function drawConnections() {
        const maxX = window.innerWidth > 1024 ? W * 0.72 : W;

        // Draw connections between nearby particles
        for (let i = 0; i < particles.length; i++) {
          for (let j = i + 1; j < particles.length; j++) {
            const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < CONNECTION_DIST) {
              const alpha = (1 - dist / CONNECTION_DIST) * 0.42;
              ctx.beginPath();
              ctx.moveTo(particles[i].x, particles[i].y);
              ctx.lineTo(particles[j].x, particles[j].y);
              ctx.strokeStyle = `rgba(255, 107, 0, ${alpha})`;
              ctx.lineWidth = 1.0;
              ctx.stroke();
            }
          }
        }

        // Draw dynamic connections to mouse cursor
        if (MOUSE.x > 0 && MOUSE.y > 0 && MOUSE.x < maxX) {
          for (let i = 0; i < particles.length; i++) {
            const dx = particles[i].x - MOUSE.x;
            const dy = particles[i].y - MOUSE.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 160) {
              const alpha = (1 - dist / 160) * 0.55;
              ctx.beginPath();
              ctx.moveTo(particles[i].x, particles[i].y);
              ctx.lineTo(MOUSE.x, MOUSE.y);
              ctx.strokeStyle = `rgba(255, 107, 0, ${alpha})`;
              ctx.lineWidth = 1.3;
              ctx.stroke();
            }
          }
        }
      }

      function animate() {
        ctx.clearRect(0, 0, W, H);

        // Draw Bohr atomic models
        atomModels.forEach(atom => {
          atom.update();
          atom.draw();
        });

        // Draw inter-particle plexus connections
        drawConnections();

        // Draw & update floating particles
        particles.forEach(p => {
          p.update();
          p.draw();
        });

        animFrame = requestAnimationFrame(animate);
      }

      animate();
    })();
  </script>
</body>
</html>