<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      @if ($Camping->title_status == 'on')
      {{$Camping->title}}
      @else
      Prize Wheel
      @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
  {{-- <link href="https://codepen.io/hexagoncircle/pen/vYxKLOa.css" rel="stylesheet"> --}}
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Award & Spinner Styles -->
    <link rel="stylesheet" href="{{asset('frontend/award/css/style.css')}}?v={{filemtime(public_path('frontend/award/css/style.css'))}}">
    <link rel="stylesheet" href="{{asset('frontend/spinner/style.css')}}?v={{filemtime(public_path('frontend/spinner/style.css'))}}">
    <link rel="stylesheet" href="{{asset('frontend/css/spinn_one/responsive.css')}}?v={{filemtime(public_path('frontend/css/spinn_one/responsive.css'))}}">
    <link rel="stylesheet" href="{{asset('frontend/css/spinn_one/my-style.css')}}?v={{filemtime(public_path('frontend/css/spinn_one/my-style.css'))}}">

    <style>
      /* Spinning animation */
      .is-spinning .spinner {
        transition: transform <?php echo $rotation_time;?>s cubic-bezier(0.1, -0.01, 0, 1);
      }

      html, body {
        overflow-x: hidden !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
        min-height: 100vh;
      }

      body {
        font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        margin: 0;
        padding: 0;
        display: block !important;
      }

      body.default-bg {
        background-color: #f8fafc !important;
        background-image: radial-gradient(rgba(148, 163, 184, 0.38) 1.2px, transparent 1.2px) !important;
        background-size: 26px 26px !important;
      }

      /* === ATOM PARTICLE CANVAS & BACKGROUND (BLURRED) === */
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
          radial-gradient(ellipse 65% 55% at 20% 25%, rgba(255, 107, 0, 0.08) 0%, transparent 65%),
          radial-gradient(ellipse 60% 60% at 80% 75%, rgba(99, 102, 241, 0.07) 0%, transparent 65%),
          radial-gradient(ellipse 50% 50% at 50% 50%, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
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

      /* Reset older styles */
      .camping_box {
        display: none !important;
      }
      .main_box {
        background: transparent !important;
        height: auto !important;
        border-radius: 0 !important;
        padding: 0 !important;
      }

      /* Campaign Information Card (Compact & Modern) */
      .campaign_hero_card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.85);
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
        padding: 5px 12px;
        margin-bottom: 14px;
        overflow: hidden;
      }
      .notice_badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #ef4444;
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 2.5px 8px;
        border-radius: 9999px;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.35);
        animation: badgePulse 2s infinite ease-in-out;
      }
      @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
      }
      .notice_scroll {
        flex: 1;
        min-width: 0;
        margin-left: 10px;
      }
      .notice_scroll marquee {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #dc2626;
        margin: 0;
        line-height: 1;
      }

      .brand_logo_wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 12px;
      }
      .brand_logo_card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        padding: 8px 16px;
        border-radius: 16px;
        box-shadow: 0 8px 20px -4px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.04);
        transition: transform 0.25s ease;
      }
      .brand_logo_card:hover {
        transform: translateY(-2px) scale(1.02);
      }
      .brand_logo_img {
        max-height: 62px;
        max-width: 140px;
        object-fit: contain;
      }

      .campaign_main_title {
        font-size: 1.55rem;
        font-weight: 800;
        color: #0f172a;
        text-align: center;
        margin-bottom: 4px;
        line-height: 1.25;
        letter-spacing: -0.01em;
      }
      .campaign_sub_title {
        font-size: 0.88rem;
        color: #64748b;
        text-align: center;
        margin-bottom: 16px;
        line-height: 1.45;
      }

      .meta_cards_grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
      .meta_pill {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.25s ease;
      }
      .meta_pill:hover {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.08);
        transform: translateY(-1px);
      }
      .meta_icon_circle {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
      }
      .meta_icon_validity {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
      }
      .meta_icon_spins {
        background: rgba(14, 165, 233, 0.12);
        color: #0284c7;
      }
      .meta_pill_content {
        display: flex;
        flex-direction: column;
        min-width: 0;
      }
      .meta_pill_label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 1px;
      }
      .meta_pill_val {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
      }
      .meta_badge_number {
        font-size: 1.05rem;
        font-weight: 800;
        color: #2563eb;
      }

      /* Deal Wheel Showcase (Enlarged to take more space) */
      .deal_wheel_wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
      }

      .deal-wheel {
        --size: clamp(300px, 82vmin, 550px);
        position: relative;
        display: grid;
        align-items: center;
        justify-items: center;
        grid-template-areas: "spinner";
        filter: drop-shadow(0 25px 50px rgba(15, 23, 42, 0.28));
        user-select: none;
        margin: 0 auto 20px auto;
      }

      .deal-wheel > * {
        grid-area: spinner;
      }

      .spinner {
        position: relative;
        display: grid;
        align-items: center;
        grid-template-areas: "spinner";
        width: var(--size) !important;
        height: var(--size) !important;
        transform: rotate(calc(var(--rotate, 25) * 1deg));
        border-radius: 50% !important;
        box-shadow: 0 0 0 8px #f59e0b, 0 0 0 14px rgba(245, 158, 11, 0.35), 0 20px 50px rgba(0, 0, 0, 0.3) !important;
        list-style-type: none !important;
        padding: 0 !important;
        margin: 0 !important;
        border: 4px solid #ffffff !important;
      }

      .spinner * {
        grid-area: spinner;
      }

      .prize {
        position: relative;
        display: flex;
        align-items: center;
        padding: 0 calc(var(--size) / 6.5) 0 calc(var(--size) / 20);
        width: 50%;
        height: 50%;
        transform-origin: center right;
        transform: rotate(var(--rotate));
        user-select: none;
      }

      .prize .text {
        font-family: 'Outfit', sans-serif !important;
        font-size: clamp(12px, calc(var(--size) / 23), 18px) !important;
        font-weight: 800 !important;
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.7), 0 0 8px rgba(0, 0, 0, 0.3) !important;
        letter-spacing: 0.02em;
        white-space: nowrap;
      }

      /* Center 3D Spin Button */
      .cap.start-btn-spin {
        --cap-size: calc(var(--size) / 3.8);
        position: relative;
        justify-self: center;
        width: var(--cap-size) !important;
        height: var(--cap-size) !important;
        background: radial-gradient(circle at 35% 30%, #ffffff 0%, #fef3c7 40%, #f59e0b 85%, #d97706 100%) !important;
        border-radius: 50% !important;
        text-align: center !important;
        justify-content: center !important;
        align-items: center !important;
        display: flex !important;
        flex-direction: column !important;
        border: 5px solid #ffffff !important;
        box-shadow: 0 0 0 4px #f59e0b, 0 12px 30px rgba(217, 119, 6, 0.5), inset 0 2px 4px rgba(255, 255, 255, 0.9) !important;
        cursor: pointer !important;
        font-family: 'Outfit', sans-serif !important;
        font-weight: 900 !important;
        font-size: clamp(14px, calc(var(--size) / 15), 24px) !important;
        letter-spacing: 0.08em !important;
        color: #78350f !important;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8) !important;
        text-transform: uppercase !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        animation: capPulse 2.4s infinite !important;
        z-index: 10 !important;
      }

      .cap.start-btn-spin:hover {
        transform: scale(1.08) !important;
        box-shadow: 0 0 0 6px #f59e0b, 0 16px 36px rgba(217, 119, 6, 0.65) !important;
        color: #451a03 !important;
      }

      .cap.start-btn-spin:active {
        transform: scale(0.96) !important;
      }

      .cap.start-btn-spin i {
        font-size: 0.65em;
        margin-bottom: 2px;
        animation: bounceArrow 1.5s infinite;
      }

      @keyframes capPulse {
        0%, 100% {
          box-shadow: 0 0 0 4px #f59e0b, 0 8px 20px rgba(217, 119, 6, 0.45);
        }
        50% {
          box-shadow: 0 0 0 8px #f59e0b, 0 14px 34px rgba(217, 119, 6, 0.7);
        }
      }

      @keyframes bounceArrow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
      }

      /* Modern Pointer Needle */
      .ticker {
        position: absolute;
        left: calc(var(--size) / -22) !important;
        width: calc(var(--size) / 6.5) !important;
        height: calc(var(--size) / 10) !important;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%) !important;
        z-index: 12 !important;
        clip-path: polygon(15% 0, 100% 50%, 15% 100%, 0% 50%) !important;
        transform-origin: center left !important;
        filter: drop-shadow(2px 4px 8px rgba(0, 0, 0, 0.45)) !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
      }

      /* CTA Spin Button */
      .spin_form_btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        font-family: 'Outfit', sans-serif !important;
        font-size: 1.15rem !important;
        font-weight: 800 !important;
        letter-spacing: 0.05em !important;
        text-transform: uppercase !important;
        padding: 15px 48px !important;
        border-radius: 9999px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5), 0 0 0 4px rgba(16, 185, 129, 0.15) !important;
      }

      .spin_form_btn:not(:disabled) {
        animation: spinPulse 2.4s infinite;
      }
      .spin_form_btn:hover:not(:disabled) {
        transform: translateY(-2px) scale(1.03) !important;
        box-shadow: 0 16px 35px -4px rgba(16, 185, 129, 0.75), 0 0 0 6px rgba(16, 185, 129, 0.25) !important;
      }
      .spin_form_btn:active:not(:disabled) {
        transform: translateY(1px) scale(0.98) !important;
      }
      .spin_form_btn:disabled {
        opacity: 0.65 !important;
        cursor: not-allowed !important;
        filter: grayscale(35%) !important;
        animation: none !important;
      }

      @keyframes spinPulse {
        0%, 100% {
          box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5), 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        50% {
          box-shadow: 0 14px 32px -2px rgba(16, 185, 129, 0.7), 0 0 0 8px rgba(16, 185, 129, 0.25);
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
      .share_options_menu li {
        margin: 4px 0;
      }
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
      .share_options_menu a:hover {
        transform: scale(1.12);
      }
      .share_options_menu .wa_btn {
        background: #25d366;
      }
      .share_options_menu .fb_btn {
        background: #1877f2;
      }

      /* Celebration / Blast Overlay */
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

      .blast .trophy_img {
        max-width: 120px !important;
        height: auto !important;
        filter: drop-shadow(0 15px 25px rgba(245, 158, 11, 0.45)) !important;
        animation: trophyFloat 3s ease-in-out infinite !important;
      }

      @keyframes trophyFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
      }

      .blast .content .text h2 {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800 !important;
        font-size: 1.55rem !important;
        color: #0f172a !important;
        margin: 18px 0 8px 0 !important;
      }

      .blast .spinner_image_show {
        max-width: 140px !important;
        max-height: 125px !important;
        object-fit: contain !important;
        border-radius: 16px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12) !important;
        margin: 0 auto 12px auto !important;
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

      .reedem-btn:hover {
        transform: translateY(-2px) scale(1.03) !important;
        box-shadow: 0 14px 30px -4px rgba(245, 158, 11, 0.65) !important;
        color: #ffffff !important;
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

      @media (min-width: 1200px) {
        .deal-wheel {
          --size: clamp(340px, 42vw, 560px);
        }
      }

      @media (max-width: 991.98px) {
        .main_page_wrapper {
          min-height: 100vh;
          display: block;
          padding: 16px 0 40px 0;
        }
        .text_col {
          margin-bottom: 20px !important;
        }
        .spinner_col {
          margin-bottom: 24px !important;
          display: flex !important;
          flex-direction: column !important;
          align-items: center !important;
          justify-content: center !important;
          width: 100% !important;
        }
        .deal_wheel_wrapper {
          display: flex !important;
          flex-direction: column !important;
          align-items: center !important;
          justify-content: center !important;
          width: 100% !important;
          margin: 0 auto !important;
        }
        .deal-wheel {
          --size: min(84vw, 360px);
          margin: 0 auto 16px auto !important;
        }
        .campaign_hero_card {
          padding: 18px 16px;
          border-radius: 20px;
          max-width: 100%;
        }
        .campaign_main_title {
          font-size: 1.35rem;
        }
        .brand_logo_img {
          max-height: 56px;
        }
      }

      @media (max-width: 480px) {
        .deal-wheel {
          --size: min(82vw, 310px);
          margin: 0 auto 16px auto !important;
        }
      }

      @media (max-width: 360px) {
        .deal-wheel {
          --size: min(82vw, 275px);
          margin: 0 auto 16px auto !important;
        }
      }

      @media (max-width: 576px) {
        .modal-dialog {
          margin: 12px !important;
        }
        .modal-body {
          padding: 20px 16px !important;
        }
        .FormModal .form-control {
          font-size: 16px !important;
        }
        .blast .content {
          padding: 30px 18px !important;
          border-radius: 24px !important;
          max-width: 95% !important;
        }
        .blast .trophy_img {
          max-width: 90px !important;
        }
        .blast .content .text h2 {
          font-size: 1.25rem !important;
        }
        .blast .award_text {
          font-size: 1.4rem !important;
          padding: 10px 18px !important;
        }
        .reedem-btn {
          font-size: 1.05rem !important;
          padding: 12px 36px !important;
        }
      }
    </style>
</head>
<body 
  @if($user->default_background == 'color') style="background:{{$user->background_color}}" 
  @elseif($user->default_background == 'image' && !empty($user->background_image)) style="background:url('{{$user->background_image}}');background-repeat: no-repeat;background-size: cover;background-position: top;min-height: 100vh;" 
  @else class="default-bg"
  @endif >

  <!-- Atom Particle Canvas & Subtle Glow Overlay -->
  <canvas id="atomCanvas"></canvas>
  <div class="bg-overlay"></div>

  <div class="main_page_wrapper">
    <div class="container py-3" id="cn_wheel_main_div">
      <div class="row align-items-center justify-content-center">
        <!-- Left Column (Desktop) / Second Section (Mobile): Campaign Information Card -->
        <div class="col-xl-4 col-lg-5 col-md-10 col-12 text_col mb-4 mb-lg-0 order-2 order-lg-1">
          <div class="campaign_hero_card">
            @php
                $notice = DB::table('notices')->where('user_id',$user->id)->where('status','active')->first();
            @endphp
            @if ($notice != '' && $notice->status == 'active')
              <div class="notice_banner">
                <span class="notice_badge"><i class="fas fa-bullhorn"></i> Notice</span>
                <div class="notice_scroll">
                  <marquee direction="left" onmouseover="this.stop();" onmouseleave="this.start();">
                    {{$notice->notice}}
                  </marquee>
                </div>
              </div>
            @endif

            <div class="brand_logo_wrapper">
              <div class="brand_logo_card">
                <img src="{{$user->logo}}" class="brand_logo_img" alt="Logo">
              </div>
            </div>

            @if ($Camping->title_status == 'on')
              <h1 class="campaign_main_title">{{$Camping->title}}</h1>
            @endif

            @if ($Camping->sub_title_status == 'on')
              <p class="campaign_sub_title">{{$Camping->sub_title}}</p>
            @endif

            <div class="meta_cards_grid">
              @if ($Camping->validity_status == 'on')
                <div class="meta_pill">
                  <div class="meta_icon_circle meta_icon_validity">
                    <i class="far fa-calendar-alt"></i>
                  </div>
                  <div class="meta_pill_content">
                    <span class="meta_pill_label">Offer Validity</span>
                    <span class="meta_pill_val">
                      @php
                        $startDate = date_create($Camping->start_date);
                        $endDate = date_create($Camping->end_date);
                      @endphp
                      {{ date_format($startDate, "d M Y") }} &mdash; {{ date_format($endDate, "d M Y") }}
                    </span>
                  </div>
                </div>
              @endif

              @if ($SpinnerFormAccessCount != 'NO_LIMIT')
                <div class="meta_pill">
                  <div class="meta_icon_circle meta_icon_spins">
                    <i class="fas fa-sync-alt fa-spin-hover"></i>
                  </div>
                  <div class="meta_pill_content">
                    <span class="meta_pill_label">Spin Limit Remaining</span>
                    <span class="meta_pill_val meta_badge_number">
                      <span class="spin_time_count">
                        @php
                          echo $count = $user->spin_whell_round - $SpinnerFormAccessCount;
                        @endphp
                      </span>
                    </span>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Right Column (Desktop) / First Section (Mobile): Deal Wheel -->
        <div class="col-xl-8 col-lg-7 col-12 spinner_col text-center order-1 order-lg-2">
          <div class="deal_wheel_wrapper">
            <div class="deal-wheel">
              <ul class="spinner"></ul>
              <figure class="cap start-btn-spin">
                <div class="grim-reaper" data-reaction="dancing" xmlns="http://www.w3.org/2000/svg"></div>
                <i class="fas fa-play" style="font-size: 13px; margin-bottom: 2px;"></i>
                <span>SPIN</span>
              </figure>
              <div class="ticker"></div>
            </div>

            <div class="mt-2">
              <button class="btn spin_form_btn start-btn-spin" type="button">
                <i class="fas fa-play-circle mr-2"></i> SPIN TO WIN
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modern Floating Share Button -->
  <div class="share_floating_bar">
    <div class="share_toggle_btn sticky_share_btn">
      <i class="fas fa-share-alt"></i>
      <span>Share</span>
    </div>
    <ul class="share_options_menu listing">
      <li>
        <a href="https://wa.me/?text={{url()->current()}}" target="_blank" class="wa_btn" title="Share on WhatsApp">
          <i class="fab fa-whatsapp"></i>
        </a>
      </li>
      <li>
        <a href="http://www.facebook.com/share.php?u={{url()->current()}}" target="_blank" class="fb_btn" title="Share on Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
      </li>
    </ul>
  </div>

  <!-- Winner Celebration Overlay -->
  <div class="blast" id="blast" style="display: none">
    <div class="content">
      <div class="trophy" style="text-align: center; margin-bottom: 8px;">
        <img src="{{asset('frontend/spinner/wheel/trophy.png')}}" class="trophy_img" alt="trophy" style="max-height: 110px; object-fit: contain; display: none;">
        <img src="" alt="Won Prize" class="spinner_image_show" onerror="this.onerror=null; this.src='{{asset('frontend/spinner/wheel/trophy.png')}}';" style="max-height: 110px; object-fit: contain; display: none;">
      </div>
      <div class="text text-center">
        <h2>Congratulations, you won!</h2>
        <div class="award_text">Award</div>
      </div>
      <div class="text text-center mt-3">
        <button class="btn reedem-btn" onclick="check_user_spinner_submit()">REEDEM</button>
      </div>
    </div>
  </div>

  <audio id="player" style="display: none;">
    <source src="{{asset('mp3/wheel2.wav')}}" type="audio/mpeg">
  </audio>
  <audio id="error" style="display: none;">
    <source src="{{asset('mp3/error.mp3')}}" type="audio/mpeg">
  </audio>
  <audio id="own" style="display: none;">
    <source src="{{asset('mp3/won.mp3')}}" type="audio/mpeg">
  </audio>

  <!-- Redeem Modal -->
  <div class="modal fade" id="ReedemModal" tabindex="-1" role="dialog" aria-labelledby="ReedemModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-gift mr-2 text-warning"></i> Redeem Gift</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4 text-center">
          @if (!empty($FormFields) && $FormFields->screenshot == 'on')
            <h5 class="font-weight-bold text-dark mb-2">If you have a Screenshot then please click on Next button and if have not Please Take Screenshot.</h5>
            <p class="text-muted mb-0">
              यदि आप Screenshot लेकर नहीं रखे है तो 
              कृपया Screenshot लेकर Next दबाए और आगे अपलोड करे !
            </p>
          @else
            <h5 class="font-weight-bold text-dark mb-2">धन्यवाद! आपने Prize Wheel के माध्यम से अपना ऑफर सुनिश्चित किया है!</h5>
            <p class="text-muted mb-0" style="font-size: 1.05rem;">
              ऑफर को Redeem करने के लिए कृपया <b>Next</b> दबाकर अपना डिटेल भरें।
            </p>
          @endif
        </div>
        <div class="modal-footer justify-content-between">
          @if (!empty($FormFields) && $FormFields->screenshot == 'on')
            <button type="button" class="btn btn-secondary take_screenshot" data-dismiss="modal">Take Screenshot</button>
          @else
            <div></div>
          @endif
          <button type="button" class="btn btn-success px-4 font-weight-bold" style="border-radius: 9999px; padding: 10px 28px;" onclick="open_form_modal()">Next <i class="fas fa-arrow-right ml-1"></i></button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form Details Modal -->
  <div class="modal fade bd-example-modal-lg FormModal" id="FormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-trophy mr-2 text-warning"></i> Claim Your Prize — Enter Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4">
          <form action="{{URL::to('u/spinner_form/post')}}" method="POST" id="spinner_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="spinner_id" id="spinner_id">
            <input type="hidden" name="spinner_name" id="spinner_name">
            <input type="hidden" name="spinner_value" id="spinner_value">
            <div class="text-center mb-4">
              <img src="" alt="Prize" class="spinner_image mb-2" style="max-height: 85px; max-width: 130px; object-fit: contain; display: none;">
              <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Congratulations, you won!</h3>
              <div style="background: #ecfdf5; border: 1.5px dashed #10b981; border-radius: 9999px; display: inline-block; padding: 6px 24px;">
                <span class="spinner_name_text" style="font-size: 1.25rem; font-weight: 800; color: #059669;"></span>
              </div>
            </div>
            @php
              $hasWhatsapp = (!isset($FormFields) || $FormFields->whatsapp_no != 'off');
              $hasEmail = (!empty($FormFields) && $FormFields->email == 'on');
              $hasAddress = (!empty($FormFields) && $FormFields->address == 'on');
            @endphp
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
              </div>
              <div class="form-group col-md-6">
                <label for="phone">
                  @if($hasWhatsapp)
                    <i class="fab fa-whatsapp text-success mr-1"></i> Mobile / WhatsApp Number
                  @else
                    Mobile Number
                  @endif
                </label>
                <input type="text" name="phone" class="form-control" id="phone" min="10" onkeyup="numOnly(this)" onblur="numOnly(this)" maxlength="10" placeholder="{{ $hasWhatsapp ? '10 Digit Mobile / WhatsApp Number' : 'Mobile Number' }}" required>
                <input type="hidden" name="whatsapp_number" id="whatsapp_number">
                <span id="phone_error" style="color:red"></span>
              </div>
            </div>
            @if ($hasEmail || $hasAddress)
            <div class="form-row">
              @if ($hasEmail)
              <div class="form-group {{ $hasAddress ? 'col-md-6' : 'col-12' }}">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
              </div>
              @endif
              @if ($hasAddress)
              <div class="form-group {{ $hasEmail ? 'col-md-6' : 'col-12' }}">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" id="address" placeholder="Address">
              </div>
              @endif
            </div>
            @endif
            <div class="form-row">
              @if (!empty($FormFields) && $FormFields->choose_option == 'on')
              @if (count($BikeModel) > 0)
                <div class="form-group col-md-6">
                  <label for="bike_model_id">Are You Interested in</label>
                  <select name="bike_model_id" id="bike_model_id" class="form-control" required>
                    <option value="">Select</option>
                    @foreach ($BikeModel as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                </div>
              @endif
              @endif
              @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              <div class="form-group col-md-6">
                <label for="screenshot">Screenshot </label>
                <input type="file" name="screenshot" class="form-control" @if (!empty($FormFields) && $FormFields->screenshot_required == 'on') required @endif id="screenshot">
              </div>
              @endif
            </div>
            <div class="text-right mt-3">
              @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              <button type="button" class="btn btn-secondary form_take_screenshot mr-2" data-dismiss="modal">Take Screenshot</button>
              @endif
              <button type="submit" class="btn btn-primary form_submit_button">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


    
  @php
  $popup = DB::table('popupalerts')->where('user_id',$user->id)->orderBy('id','desc')->first();
@endphp
  <div class="modal fade quotation newsShowPopupModal"  tabindex="-1" aria-labelledby="smallQuoteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"  style="width: 95%;">

        <div class="modal-body">

          <div class="" style="float: right;">
              <button type="button" class="btn-close popup_close"  onclick="popupModalClose()" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fas fa-times"></i>
              </button>
          </div>
            <div class="modal-content" style="    text-align: center;border: 0px solid rgb(0, 0, 0);">
              @if (!empty($popup))
                 
                 @if (!empty($popup->popup_img))
                    <h4>{{$popup->title}}</h4> 
                 @endif
                 @if (!empty($popup->popup_img))
                      <img src="{{$popup->popup_img}}" alt=""  style="height: 405px;">   
                 @endif
               
              @endif
                
              </div>
          
        </div>

      </div>
    </div>
  </div>



   <!-- Preloader -->
<div id="preloader" style="display: none">
  <div id="status">&nbsp;</div>
</div>
    <style>
      /* Preloader */

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ffffff91;
    z-index: 9999;
  /* makes sure it stays on top */
}

#status {
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  /* centers the loading animation horizontally one the screen */
  top: 50%;
  /* centers the loading animation vertically one the screen */
  background-image: url(https://raw.githubusercontent.com/niklausgerber/PreLoadMe/master/img/status.gif);
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}
    </style>


    
  <!-- Import Js Files -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script  src="{{asset('frontend/award/js/blast.js')}}?v={{filemtime(public_path('frontend/award/js/blast.js'))}}"></script>


  <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

  @php
      //print_r($spinner_data_json);
  @endphp
      <script>
          /**
 * Prize data will space out evenly on the deal wheel based on the amount of items available.
 * @param text [string] name of the prize
 * @param color [string] background color of the prize
 * @param reaction ['resting' | 'dancing' | 'laughing' | 'shocked'] Sets the reaper's animated reaction
 */
// const prizes = [
//   {
//     text: "10% Off Sticker Price",
//     color: "hsl(197 30% 43%)",
//     reaction: "dancing",
//     price:"10"
//   },
//   { 
//     text: "Free Car",
//     color: "hsl(200 58% 39%)",
//     reaction: "shocked",
//     price:"10"
//   },
//   { 
//     text: "No Money Down",
//     color: "hsl(43 74% 66%)",
//     reaction: "shocked",
//     price:"10" 
//   },
//   {
//     text: "Half Off Sticker Price",
//     color: "hsl(27 87% 67%)",
//     reaction: "shocked",
//     price:"10"
//   },
//   {
//     text: "Free DIY Carwash",
//     color: "hsl(12 76% 61%)",
//     reaction: "dancing",
//     price:"10"
//   },
//   {
//     text: "Eternal Damnation",
//     color: "hsl(500 60% 52%)",
//     reaction: "laughing",
//     price:"10"
//   },
//   {
//     text: "Used Travel Mug",
//     color: "hsl(91 43% 54%)",
//     reaction: "laughing",
//     price:"10"
//   },
//   {
//     text: "One Solid Hug",
//     color: "hsl(140 36% 74%)",
//     reaction: "dancing",
//     price:"10"
//   }
// ];


const prizes = <?php print_r($spinner_data_json);?>;
let skip_data = <?php print_r($spinner_skip_json);?>;
 console.log(skip_data);

const wheel = document.querySelector(".deal-wheel");
const spinner = wheel.querySelector(".spinner");
const trigger = wheel.querySelector(".start-btn-spin");
const ticker = wheel.querySelector(".ticker");
const reaper = wheel.querySelector(".grim-reaper");
const prizeSlice = 360 / prizes.length;
const prizeOffset = Math.floor(180 / prizes.length);
const spinClass = "is-spinning";
const selectedClass = "selected";
const spinnerStyles = window.getComputedStyle(spinner);
let tickerAnim;
let rotation = 0;
let currentSlice = 0;
let prizeNodes;

const createPrizeNodes = () => {
  prizes.forEach(({ text, color, reaction,image }, i) => {
    const rotation = ((prizeSlice * i) * -1) - prizeOffset;
    spinner.insertAdjacentHTML(
        "beforeend",
        `<li class="prize prize_data" data-reaction=${reaction} style="--rotate: ${rotation}deg">
          <span class="text">${text}</span>
          
        </li>`
      );
    
    
  });
};

const createConicGradient = () => {
  spinner.setAttribute(
    "style",
    `background: conic-gradient(
      from -90deg,
      ${prizes
        .map(({ color }, i) => `${color} 0 ${(100 / prizes.length) * (prizes.length - i)}%`)
        .reverse()
      }
    );`
  );
};


const setupWheel = () => {
  createConicGradient();
  createPrizeNodes();
  prizeNodes = wheel.querySelectorAll(".prize_data");
  console.log(prizeNodes);
};

const spinertia = (min, max) => {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
};

const runTickerAnimation = () => {
  // https://css-tricks.com/get-value-of-css-rotation-through-javascript/
  const values = spinnerStyles.transform.split("(")[1].split(")")[0].split(",");
  const a = values[0];
  const b = values[1];  
  let rad = Math.atan2(b, a);
  
  if (rad < 0) rad += (2 * Math.PI);
  
  const angle = Math.round(rad * (180 / Math.PI));
  const slice = Math.floor(angle / prizeSlice);
  
  if (currentSlice !== slice) {
    
    ticker.style.animation = "none";
    setTimeout(() => ticker.style.animation = null, 10);
    currentSlice = slice;
  }

  tickerAnim = requestAnimationFrame(runTickerAnimation);
 
};

const selectPrize = () => {
   
  let selected = Math.floor(rotation / prizeSlice);
  if (selected >= prizes.length) selected = prizes.length - 1;
  if (selected < 0) selected = 0;

  const isInvalid = (p) => {
    if (!p) return true;
    const isSkipped = skip_data.some(s => s && s.trim().toLowerCase() === p.text.trim().toLowerCase()) || (p.skip && (p.skip.toString().trim().toLowerCase() === 'yes' || p.skip.toString().trim() === '1'));
    const noStock = (p.price !== undefined && p.price !== null && Number(p.price) <= 0);
    const zeroChance = (p.chances !== undefined && p.chances !== null && Number(p.chances) <= 0);
    return isSkipped || noStock || zeroChance;
  };

  if (isInvalid(prizes[selected])) {
    const fallbackIdx = prizes.findIndex(p => !isInvalid(p));
    if (fallbackIdx !== -1) {
      selected = fallbackIdx;
    }
  }

  console.log(prizes[selected]);

  if (prizes[selected] != undefined) {
    $.ajax({
      url: "{{URL::to('u/spinner_value_check')}}",
          type: 'post',
          // dataType: 'application/json',
          data:  {
            spinner_id:prizes[selected].id
          },
          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
          success: function(data) {
           
            if (data.status == true) {

              prizeNodes[selected].classList.add(selectedClass);

              document.getElementById('player').pause();
              playing = false;
              $(this).text("restart sound");

              $('#confetti-canvas').show();
              blast_fun();
              $('.award_text').html(prizes[selected].text);
              $('#blast').addClass('show-blast').css('display', 'flex').show();

              let prizeImg = (prizes[selected] && prizes[selected].image && typeof prizes[selected].image === 'string' && prizes[selected].image.trim() !== '') ? prizes[selected].image.trim() : '';

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

              let safeImg = resolveSafeImageUrl(prizeImg);

              if (safeImg !== '') {
                  $('.spinner_image_show').attr('src', safeImg).css('display', 'inline-block');
                  $('.trophy_img').css('display', 'none');
                  $('.spinner_image').attr('src', safeImg).css('display', 'inline-block');
              } else {
                  $('.trophy_img').attr('src', "{{asset('frontend/spinner/wheel/trophy.png')}}").css('display', 'inline-block');
                  $('.spinner_image_show').css('display', 'none');
                  $('.spinner_image').attr('src', "{{asset('frontend/spinner/wheel/trophy.png')}}").css('display', 'inline-block');
              }

              $('#spinner_id').val(prizes[selected].id);
              $('#spinner_name').val(prizes[selected].text);
              $('.spinner_name_text').html(prizes[selected].text);
              $('#spinner_value').val(prizes[selected].price);

              document.getElementById('own').play();
                      playing = true;

              reaper.dataset.reaction = prizeNodes[selected].dataset.reaction;

              setTimeout(() => {
                $('#confetti-canvas').hide();
              }, 2000);

              $(".start-btn-spin").removeAttr('disabled');

            }
            
          },
        error: function(err) {
            reject(err) // Reject the promise and go to catch()
        }
    });
  }else{
    prizeNodes[selected].classList.add(selectedClass);

    document.getElementById('player').pause();
    playing = false;
    $(this).text("restart sound");
  }

};

trigger.addEventListener("click", () => {
//   if (reaper.dataset.reaction !== "resting") {
//     reaper.dataset.reaction = "resting";
//   }

if($(".start-btn-spin").attr('disabled')){
     return;
}

$(".start-btn-spin").attr('disabled','disabled');


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

    $.ajax({
      url: "{{URL::to('u/spinner_round_check')}}",
          type: 'post',
          // dataType: 'application/json',
          data:  {
            user_id:'{{$user->id}}',
            campaign_id:'{{$Camping->id}}',
          },
          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
          success: function(data) {
           
            $('.spin_time_count').html(data.total_count);
            if (data.status == false) {
              swal({
                title: "Oh! Sorry",
                text: "<h2>"+data.message+"</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a>",
                html: true,
                type: "error",
                confirmButtonText: "Ok"
              });

              document.getElementById('error').play();
              playing = true;
              return;

            }else{
                const getEligibleTargetIndex = () => {
                  const eligible = [];
                  prizes.forEach((p, idx) => {
                    const isSkipped = skip_data.some(s => s && s.trim().toLowerCase() === p.text.trim().toLowerCase()) || (p.skip && (p.skip.toString().trim().toLowerCase() === 'yes' || p.skip.toString().trim() === '1'));
                    const noStock = (p.price !== undefined && p.price !== null && Number(p.price) <= 0);
                    const zeroChance = (p.chances !== undefined && p.chances !== null && Number(p.chances) <= 0);
                    if (!isSkipped && !noStock && !zeroChance) {
                      eligible.push(idx);
                    }
                  });
                  if (eligible.length === 0) return -1;

                  let total = 0;
                  eligible.forEach(idx => {
                    const qty = Math.max(1, Number(prizes[idx].price) || 1);
                    const c = Number(prizes[idx].chances) || 0;
                    const chanceFactor = (c > 0 ? c : 1);
                    total += (qty * chanceFactor);
                  });
                  let rand = Math.random() * total;
                  for (let idx of eligible) {
                    const qty = Math.max(1, Number(prizes[idx].price) || 1);
                    const c = Number(prizes[idx].chances) || 0;
                    const chanceFactor = (c > 0 ? c : 1);
                    const w = (qty * chanceFactor);
                    if (rand <= w) return idx;
                    rand -= w;
                  }
                  return eligible[0];
                };

                const targetIdx = getEligibleTargetIndex();
                if (targetIdx === -1) {
                  swal("Notice", "Currently no prizes are available. Please try again later.", "info");
                  $('.confirm').removeAttr('disabled');
                  return;
                }

                try {
                  let playerAudio = document.getElementById('player');
                  if (playerAudio) playerAudio.play().catch(e => console.log('Audio play error:', e));
                } catch(e){}
                playing = true;

                if (reaper && reaper.dataset && reaper.dataset.reaction !== "resting") {
                  reaper.dataset.reaction = "resting";
                }

                trigger.disabled = true;
                const fullSpins = spinertia(6, 9) * 360;
                const sliceCenter = (targetIdx * prizeSlice) + (prizeSlice / 2);
                const jitter = (Math.random() - 0.5) * (prizeSlice * 0.4);
                rotation = fullSpins + sliceCenter + jitter;

                prizeNodes.forEach((prize) =>{
                  prize.classList.remove(selectedClass);
                });
                wheel.classList.add(spinClass);
                spinner.style.setProperty("--rotate", rotation);
                ticker.style.animation = "none";
                runTickerAnimation();

                swal.close();
            }
            $('.confirm').removeAttr('disabled');
            
          },
        error: function(err) {
            reject(err) // Reject the promise and go to catch()
        }
    });


    } else {
      swal("Cancelled", "Your spin wheel is cancled :)", "error");
    }
 });

          
});

spinner.addEventListener("transitionend", () => {
  cancelAnimationFrame(tickerAnim);
  trigger.disabled = false;
  trigger.focus();
  rotation %= 360;

  selectPrize();
  wheel.classList.remove(spinClass);
  spinner.style.setProperty("--rotate", rotation);
});

setupWheel();



    let proceedingToForm = false;
    function open_form_modal(){
      proceedingToForm = true;
      $('#ReedemModal').one('hidden.bs.modal', function(){
        $('#FormModal').modal('show');
        setTimeout(function(){ proceedingToForm = false; }, 400);
      }).modal('hide');
    }

      $("#spinner_form").on('submit',(function(e) {
        e.preventDefault();
        var phone  = $('#phone').val();
        if (!$('#whatsapp_number').val()) {
          $('#whatsapp_number').val(phone);
        }
        var name  = $('#name').val();
        var email  = $('#email').val();
        var whatsapp_number  = $('#whatsapp_number').val();
        var address  = $('#address').val();
        var bike_model_id  = $('#bike_model_id').val();
 
        $('.form_submit_button').attr('disabled','disabled');
        $('#preloader').show();
        //get the action-url of the form
        var actionurl = e.currentTarget.action;

        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                // dataType: 'application/json',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                  $('.form_submit_button').removeAttr('disabled');
                  if (data.message == 'Inserted') {
                    
                    swal({
                      title: "Success",
                      text: "<h4>Thank You For Submit Us Details</h4><span>Our Team Will be Contact You Soon </span> <p  style='margin:7px'><b>Helpline Number </b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a></p>", 
                      html: true,
                      type: "success",
                      confirmButtonText: "Cool",
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Ok",
                    }, function(isConfirm) {
                        if (isConfirm) {
                          location.reload(true);
                        } else {
                            return false;
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
                      title: "Error!",
                      text: "Here's my error message!",
                      type: "error",
                      confirmButtonText: "Ok"
                    });
                  }
                  $('#preloader').hide();
                   
                }
        });
      }));


      function check_user_spinner_submit(){
        proceedingToForm = true;
        $('#blast').removeClass('show-blast').fadeOut(250, function(){
          $('#FormModal').modal('show');
          setTimeout(function(){ proceedingToForm = false; }, 400);
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
      // $('.click_to_spain h3').circleType({radius: 160, dir:-1});


      $(document).ready(function(){
            // $(document).bind("contextmenu",function(e){
            //     return false;
            // });
            // document.onkeydown = (e) => {
            //     if (e.key == 123) {
            //         e.preventDefault();
            //     }
            //     if (e.ctrlKey && e.shiftKey && e.key == 'I') {
            //         e.preventDefault();
            //     }
            //     if (e.ctrlKey && e.shiftKey && e.key == 'C') {
            //         e.preventDefault();
            //     }
            //     if (e.ctrlKey && e.shiftKey && e.key == 'J') {
            //         e.preventDefault();
            //     }
            //     if (e.ctrlKey && e.key == 'U') {
            //         e.preventDefault();
            //     }
            // };
      });


      	
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
      	
    function wpNumOnly(selector) {
        const numericValue = selector.value.replace(/[^0-9]/g, '');
        $('.form_submit_button').attr('disabled','disabled');
        if (numericValue.length !== 10) {
            const errorMessageSpan = document.getElementById("wp_phone_error");
            errorMessageSpan.textContent = 'Enter Valid 10 Digit Number';
            selector.value = numericValue;
        } else {
            const errorMessageSpan = document.getElementById("wp_phone_error");
            errorMessageSpan.textContent = '';
            selector.value = numericValue;
            $('.form_submit_button').removeAttr('disabled');
        }
    }

      //
      @if (!empty($popup) && $popup->status == 'active')
        @if(!Session::get('popupShow'))
            //alert('fff');
            setTimeout(function(){ $('.newsShowPopupModal').modal('show');}, 1000);
            
        @else
            //alert('ddd');
            $('.newsShowPopupModal').modal('hide');
        @endif
      @endif

      function popupModalClose(){
          //alert('pop');
          @php
              Session::put('popupShow','show');
          @endphp
          $('.newsShowPopupModal').modal('hide');
      } 

      $(document).on('click', '.spin_form_btn', function() {
        trigger.click();
      });

      // ===================================================
      // ATOM PARTICLE CANVAS & BOHR ATOMIC SIMULATION
      // ===================================================
      (function initAtomCanvas() {
        const canvas = document.getElementById('atomCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');

        let W, H, animFrame;
        const PARTICLE_COUNT = 75;
        const CONNECTION_DIST = 140;
        const MOUSE = { x: -9999, y: -9999 };

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

        class Particle {
          constructor() { this.reset(true); }
          reset(init) {
            this.x = Math.random() * W;
            this.y = init ? Math.random() * H : -10;
            this.r = 1.8 + Math.random() * 2.6;
            const speed = 0.25 + Math.random() * 0.45;
            const angle = Math.random() * Math.PI * 2;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed * 0.6 + 0.1;
            this.alpha = 0.35 + Math.random() * 0.45;
            
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

            if (this.x < -20) this.x = W + 10;
            if (this.x > W + 20) this.x = -10;
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

        class AtomModel {
          constructor(x, y, scale = 1.0) {
            this.x = x;
            this.y = y;
            this.scale = scale;
            this.coreR = (4.5 + Math.random() * 3) * scale;
            this.pulse = Math.random() * Math.PI * 2;
            
            this.orbits = [
              { r: 42 * scale, tilt: 0.45, angle: 0, rotAngle: 0.2, speed: 0.016, color: 'rgba(255, 107, 0, 0.45)', electronColor: '#ff6b00' },
              { r: 72 * scale, tilt: 0.50, angle: Math.PI / 3, rotAngle: 1.25, speed: -0.012, color: 'rgba(99, 102, 241, 0.40)', electronColor: '#6366f1' },
              { r: 104 * scale, tilt: 0.42, angle: (Math.PI * 2) / 3, rotAngle: 2.35, speed: 0.009, color: 'rgba(245, 158, 11, 0.42)', electronColor: '#f59e0b' }
            ];

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

            this.orbits.forEach(orb => {
              orb.angle += orb.speed;
            });
          }

          draw() {
            const pulseFactor = 0.85 + 0.25 * Math.sin(this.pulse);

            // 1. Halo
            const haloGrad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.coreR * 6 * pulseFactor);
            haloGrad.addColorStop(0, 'rgba(255, 107, 0, 0.35)');
            haloGrad.addColorStop(0.5, 'rgba(249, 115, 22, 0.12)');
            haloGrad.addColorStop(1, 'rgba(255, 107, 0, 0)');
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.coreR * 6 * pulseFactor, 0, Math.PI * 2);
            ctx.fillStyle = haloGrad;
            ctx.fill();

            // 2. Core
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.coreR * pulseFactor, 0, Math.PI * 2);
            ctx.fillStyle = '#ff6b00';
            ctx.fill();

            // Highlight
            ctx.beginPath();
            ctx.arc(this.x - this.coreR * 0.3, this.y - this.coreR * 0.3, this.coreR * 0.4, 0, Math.PI * 2);
            ctx.fillStyle = '#ffffff';
            ctx.fill();

            // 3. Orbits & Electrons
            this.orbits.forEach(orb => {
              ctx.save();
              ctx.translate(this.x, this.y);
              ctx.rotate(orb.rotAngle);
              ctx.scale(1, orb.tilt);

              ctx.beginPath();
              ctx.arc(0, 0, orb.r, 0, Math.PI * 2);
              ctx.strokeStyle = orb.color;
              ctx.lineWidth = 1.4;
              ctx.stroke();

              const ex = Math.cos(orb.angle) * orb.r;
              const ey = Math.sin(orb.angle) * orb.r;

              ctx.beginPath();
              ctx.arc(ex, ey, 5.5, 0, Math.PI * 2);
              ctx.fillStyle = orb.color;
              ctx.fill();

              ctx.beginPath();
              ctx.arc(ex, ey, 2.8, 0, Math.PI * 2);
              ctx.fillStyle = orb.electronColor;
              ctx.fill();

              ctx.beginPath();
              ctx.arc(ex, ey, 1.2, 0, Math.PI * 2);
              ctx.fillStyle = '#ffffff';
              ctx.fill();

              ctx.restore();
            });
          }
        }

        const particles = Array.from({ length: PARTICLE_COUNT }, () => new Particle());
        let atomModels = [];

        function createAtoms() {
          atomModels = [];
          atomModels.push(new AtomModel(W * 0.14, H * 0.22, 1.15));
          atomModels.push(new AtomModel(W * 0.86, H * 0.28, 1.1));
          atomModels.push(new AtomModel(W * 0.18, H * 0.80, 1.2));
          atomModels.push(new AtomModel(W * 0.82, H * 0.78, 1.0));
          if (W > 1024) {
            atomModels.push(new AtomModel(W * 0.50, H * 0.12, 0.9));
          }
        }

        createAtoms();
        window.addEventListener('resize', createAtoms);

        function drawConnections() {
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

          if (MOUSE.x > 0 && MOUSE.y > 0) {
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

          atomModels.forEach(atom => {
            atom.update();
            atom.draw();
          });

          drawConnections();

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