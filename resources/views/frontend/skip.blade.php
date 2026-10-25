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

      .camping_box { display: none !important; }
      .main_box {
        background: transparent !important;
        height: auto !important;
        border-radius: 0 !important;
        padding: 0 !important;
      }

      /* Campaign Hero Card */
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

      /* Deal Wheel (Skip Mode) */
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

      /* Needle Ticker */
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

        <!-- Right Column: Deal Wheel (Skip Mode) Component -->
        <div class="col-xl-8 col-lg-7 col-12 spinner_col text-center order-1 order-lg-2">
          @include('frontend.components.wheel-skip')
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

  <!-- Import JS Dependencies -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="{{asset('frontend/award/js/blast.js')}}?v={{filemtime(public_path('frontend/award/js/blast.js'))}}"></script>
  <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

  <!-- Skip Wheel Logic Script -->
  <script>
    const prizes = <?php print_r($spinner_data_json);?>;
    let skip_data = <?php print_r($spinner_skip_json);?>;

    const spinFormTiming = "{{ $spin_form_timing ?? 'after_spin' }}";
    // Server-side source of truth: if no pending form record for this IP, clear stale sessionStorage
    @php $serverPreSpinId = $preSpinFormRecord ? $preSpinFormRecord->id : null; @endphp
    const serverPreSpinFormId = {{ $serverPreSpinId ? $serverPreSpinId : 'null' }};
    if (!serverPreSpinFormId) {
      sessionStorage.removeItem('preSpinFormId_{{ $user->id }}');
      sessionStorage.removeItem('preSpinName_{{ $user->id }}');
      sessionStorage.removeItem('spin_completed_{{ $user->id }}');
    }
    let preSpinFormId = serverPreSpinFormId ? String(serverPreSpinFormId) : (sessionStorage.getItem('preSpinFormId_{{ $user->id }}') || null);
    let submittedUserName = sessionStorage.getItem('preSpinName_{{ $user->id }}') || '';
    let currentSelectedPrizeIndex = null;

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
      prizes.forEach(({ text, color, reaction, image }, i) => {
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
    };

    const spinertia = (min, max) => {
      min = Math.ceil(min);
      max = Math.floor(max);
      return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    const runTickerAnimation = () => {
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

      currentSelectedPrizeIndex = selected;
      window.currentSelectedPrize = prizes[selected];

      if (prizes[selected] != undefined) {
        $.ajax({
          url: "{{URL::to('u/spinner_value_check')}}",
          type: 'post',
          data: {
            spinner_id: prizes[selected].id
          },
          headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
          success: function(data) {
            if (data.status == true) {
              prizeNodes[selected].classList.add(selectedClass);

              document.getElementById('player').pause();
              playing = false;

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

              if (reaper) reaper.dataset.reaction = prizeNodes[selected].dataset.reaction;

              setTimeout(() => {
                $('#confetti-canvas').hide();
              }, 2000);

              $(".start-btn-spin").removeAttr('disabled');
            }
          },
          error: function(err) {
            console.log(err);
          }
        });
      } else {
        prizeNodes[selected].classList.add(selectedClass);
        document.getElementById('player').pause();
        playing = false;
      }
    };

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

    function startActualSpin() {
      executeSpinRound();
    }

    function executeSpinRound() {
      $(".start-btn-spin").attr('disabled','disabled');

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
              text: "<h2>"+data.message+"</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a>",
              html: true,
              type: "error",
              confirmButtonText: "Ok"
            });

            document.getElementById('error').play();
            playing = true;
            $(".start-btn-spin").removeAttr('disabled');
            return;
          } else {
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
              $(".start-btn-spin").removeAttr('disabled');
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

            prizeNodes.forEach((prize) => {
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
          $(".start-btn-spin").removeAttr('disabled');
          $('.confirm').removeAttr('disabled');
        }
      });
    }

    trigger.addEventListener("click", () => {
      if($(".start-btn-spin").attr('disabled')){
        return;
      }

      // If before_spin mode is active and user hasn't submitted details yet, open form!
      if (spinFormTiming === 'before_spin' && !preSpinFormId) {
        openPreSpinModal();
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
          executeSpinRound();
        } else {
          $(".start-btn-spin").removeAttr('disabled');
          swal("Cancelled", "Your spin wheel is cancelled :)", "error");
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
      $('#formModalTitle').html('<i class="fas fa-trophy mr-2 text-warning"></i> Claim Your Prize — Enter Details');
      $('.winner-header-info').show();
      $('.prespin-header-info').hide();
      $('.form_submit_button').html('Submit');
      $('#ReedemModal').one('hidden.bs.modal', function(){
        $('#FormModal').modal('show');
        setTimeout(function(){ proceedingToForm = false; }, 400);
      }).modal('hide');
    }

    $("#spinner_form").on('submit', function(e) {
      e.preventDefault();
      var phone = $('#phone').val();
      if (!$('#whatsapp_number').val()) {
        $('#whatsapp_number').val(phone);
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

          // Handle BEFORE SPIN form submission response:
          if (isPreSpin && (data.status == 1 || data.message == 'PreSpinFormSubmitted')) {
            preSpinFormId = data.form_id;
            submittedUserName = data.name || $('#name').val();
            sessionStorage.setItem('preSpinFormId_{{ $user->id }}', preSpinFormId);
            sessionStorage.setItem('preSpinName_{{ $user->id }}', submittedUserName);

            proceedingToForm = false;
            $('#FormModal').modal('hide');

            // Immediately start actual spin!
            setTimeout(function() {
              startActualSpin();
            }, 400);
            return;
          }

          // Normal AFTER SPIN submission response:
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
              text: data.message || "An error occurred. Please try again.",
              type: "error",
              confirmButtonText: "Ok"
            });
          }
        },
        error: function(err) {
          $('.form_submit_button').removeAttr('disabled');
          $('#preloader').hide();
          swal("Error", "Something went wrong. Please check your connection and try again.", "error");
        }
      });
    });

    function check_user_spinner_submit(){
      // In before_spin mode, visitor already submitted details. Never open form modal again!
      if (spinFormTiming === 'before_spin') {
        $('#preloader').show();
        $('.reedem-btn').attr('disabled', 'disabled');

        var formId = preSpinFormId || sessionStorage.getItem('preSpinFormId_{{ $user->id }}') || '';
        var winningSpinnerId = $('#spinner_id').val() || (currentSelectedPrizeIndex !== null && prizes[currentSelectedPrizeIndex] ? prizes[currentSelectedPrizeIndex].id : '');
        var winningPrizeName = $('#spinner_name').val() || $('.spinner_name_text').text() || (currentSelectedPrizeIndex !== null && prizes[currentSelectedPrizeIndex] ? prizes[currentSelectedPrizeIndex].text : '');

        $.ajax({
          url: "{{URL::to('u/spinner_form_update_prize')}}",
          type: 'POST',
          data: {
            form_id: formId,
            spinner_id: winningSpinnerId,
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
                text: "<h4>Congratulations " + (submittedUserName || '') + "!</h4><p>Your prize <b>" + (winningPrizeName || data.prize_name || '') + "</b> has been confirmed!</p><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a></p>",
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

      // Standard flow:
      proceedingToForm = true;
      $('#blast').removeClass('show-blast').fadeOut(250, function(){
        $('#formModalTitle').html('<i class="fas fa-trophy mr-2 text-warning"></i> Claim Your Prize — Enter Details');
        $('.winner-header-info').show();
        $('.prespin-header-info').hide();
        $('.form_submit_button').html('Submit');
        $('#FormModal').modal('show');
        setTimeout(function(){ proceedingToForm = false; }, 400);
      });
    }

    $('#FormModal').on('hidden.bs.modal', function () {
      if (!proceedingToForm && !$('#FormModal').hasClass('show') && !$('.FormModal').hasClass('show') && !$('#FormModal').is(':visible')) {
        if ($('#blast').hasClass('show-blast') || $('#blast').is(':visible')) {
          $('#blast').addClass('show-blast').fadeIn(200);
        }
      }
    });

    jQuery(".sticky_share_btn").click(function () {
      jQuery(".listing").fadeToggle(600);
    });
    jQuery(".form_take_screenshot").click(function () {
      $('#FormModal').modal('hide');
      $('#ReedemModal').modal('hide');
    });

    $(document).ready(function(){
      @php
        $isLimitFinished = ($SpinnerFormAccessCount !== 'NO_LIMIT' && ($user->spin_whell_round - $SpinnerFormAccessCount) <= 0);
      @endphp
      const isLimitFinished = {{ $isLimitFinished ? 'true' : 'false' }};
      const hasCompletedSession = sessionStorage.getItem('spin_completed_{{ $user->id }}') === 'true';

      // Auto open details form on page load in before_spin mode ONLY if user hasn't submitted yet and has remaining spins:
      if (spinFormTiming === 'before_spin' && !preSpinFormId && !isLimitFinished && !hasCompletedSession) {
        setTimeout(function() {
          openPreSpinModal();
        }, 400);
      }
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

    $(document).on('click', '.spin_form_btn', function() {
      trigger.click();
    });
  </script>
</body>
</html>
