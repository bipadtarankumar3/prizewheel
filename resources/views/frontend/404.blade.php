<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if ($status == 'user_date_expired')
            Subscription Expired &bull; Prize Wheel
        @elseif ($status == 'no_camping_available')
            Coming Soon &bull; Prize Wheel
        @elseif ($status == 'spinn_not_available')
            Spins Unavailable &bull; Prize Wheel
        @else
            Page Not Found &bull; Prize Wheel
        @endif
    </title>

    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --primary: #ff6b00;
            --primary-glow: rgba(255, 107, 0, 0.35);
            --danger: #ef4444;
            --danger-glow: rgba(239, 68, 68, 0.3);
            --amber: #f59e0b;
            --amber-glow: rgba(245, 158, 11, 0.3);
            --indigo: #6366f1;
            --indigo-glow: rgba(99, 102, 241, 0.3);
            --slate-900: #0f172a;
            --slate-700: #334155;
            --slate-500: #64748b;
            --slate-400: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* === SIGNATURE RICH LIGHT SLATE ATOM UI BACKGROUND & DOT GRID === */
        body {
            background-color: #dbe4ef !important;
            background: radial-gradient(ellipse 95% 75% at 50% 15%, #e8eef6 0%, #d8e2ee 55%, #cbd6e4 100%) !important;
            background-attachment: fixed;
            color: var(--slate-900);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(71, 85, 105, 0.32) 1.2px, transparent 1.2px);
            background-size: 26px 26px;
            pointer-events: none;
            z-index: 0;
        }

        /* Atom Particle Canvas */
        #atomCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        /* Atmospheric Ambient Gradient Overlay */
        .bg-overlay {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 65% 55% at 15% 20%, rgba(255, 107, 0, 0.16) 0%, transparent 65%),
                radial-gradient(ellipse 60% 60% at 85% 75%, rgba(99, 102, 241, 0.14) 0%, transparent 65%),
                radial-gradient(ellipse 55% 50% at 50% 85%, rgba(245, 158, 11, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Main Page Layout */
        .page-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 540px;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* === CRISP HIGH-CONTRAST WHITE STATUS CARD === */
        .status_hero_card {
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 
                0 25px 60px -15px rgba(15, 23, 42, 0.15),
                0 10px 24px -5px rgba(15, 23, 42, 0.06),
                0 0 0 1px rgba(203, 213, 225, 0.6);
            border-radius: 30px;
            padding: 44px 34px 38px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: cardEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
            transition: transform 0.35s ease, box-shadow 0.35s ease;
        }

        .status_hero_card:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 35px 75px -15px rgba(15, 23, 42, 0.20),
                0 12px 28px -5px rgba(15, 23, 42, 0.08),
                0 0 0 1px rgba(148, 163, 184, 0.8);
        }

        /* Card Top Shimmer Line */
        .status_hero_card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 15%;
            right: 15%;
            height: 3.5px;
            border-radius: 0 0 6px 6px;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 0, 0.85), rgba(245, 158, 11, 0.95), transparent);
        }

        .status_hero_card.card-expired::before {
            background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.9), rgba(245, 158, 11, 0.95), transparent);
        }

        .status_hero_card.card-coming::before {
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.9), rgba(14, 165, 233, 0.95), transparent);
        }

        @keyframes cardEntrance {
            0% {
                opacity: 0;
                transform: translateY(28px) scale(0.96);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Brand Logo / Avatar */
        .brand-header {
            margin-bottom: 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .brand-logo-wrapper {
            width: 76px;
            height: 76px;
            border-radius: 22px;
            background: #ffffff;
            box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(226, 232, 240, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .brand-logo-wrapper:hover {
            transform: scale(1.05);
        }

        .brand-logo-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.18rem;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        /* Status Icon Container */
        .icon-hero-box {
            width: 88px;
            height: 88px;
            margin: 0 auto 24px;
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            font-size: 2.2rem;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .icon-hero-box:hover {
            transform: scale(1.08) rotate(4deg);
        }

        /* Pulsing Glow Ring */
        .icon-hero-box::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 36px;
            opacity: 0.35;
            animation: pulseRing 2.4s ease-out infinite;
            z-index: -1;
        }

        @keyframes pulseRing {
            0% {
                transform: scale(0.92);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.15);
                opacity: 0.15;
            }
            100% {
                transform: scale(0.92);
                opacity: 0.6;
            }
        }

        /* Variants of Status Icons */
        .icon-box-expired {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
            box-shadow: 0 16px 32px -8px rgba(220, 38, 38, 0.3);
            border: 1.5px solid #fecaca;
        }
        .icon-box-expired::after {
            background: rgba(239, 68, 68, 0.3);
        }

        .icon-box-coming {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: #4f46e5;
            box-shadow: 0 16px 32px -8px rgba(79, 70, 229, 0.3);
            border: 1.5px solid #c7d2fe;
        }
        .icon-box-coming::after {
            background: rgba(99, 102, 241, 0.3);
        }

        .icon-box-spins {
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            color: #ea580c;
            box-shadow: 0 16px 32px -8px rgba(234, 88, 12, 0.3);
            border: 1.5px solid #fed7aa;
        }
        .icon-box-spins::after {
            background: rgba(255, 107, 0, 0.3);
        }

        .icon-box-invalid {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            color: #475569;
            box-shadow: 0 16px 32px -8px rgba(71, 85, 105, 0.25);
            border: 1.5px solid #cbd5e1;
        }
        .icon-box-invalid::after {
            background: rgba(100, 116, 139, 0.25);
        }

        /* Status Pill Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 18px;
        }

        .status-badge .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            animation: dotBlink 1.8s ease-in-out infinite;
        }

        @keyframes dotBlink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.35; transform: scale(0.8); }
        }

        .badge-expired {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .badge-expired .dot { background: #dc2626; }

        .badge-coming {
            background: #eef2ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
        }
        .badge-coming .dot { background: #4f46e5; }

        .badge-spins {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }
        .badge-spins .dot { background: #ea580c; }

        .badge-invalid {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }
        .badge-invalid .dot { background: #64748b; }

        /* Headings & Typography */
        .status-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.85rem;
            line-height: 1.25;
            color: #0f172a;
            margin-bottom: 12px;
            letter-spacing: -0.025em;
        }

        .status-desc {
            font-size: 0.98rem;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 28px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Action Buttons Grid */
        .actions-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            margin-bottom: 24px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 22px;
            border-radius: 18px;
            font-family: 'Outfit', sans-serif;
            font-size: 1.02rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: none;
        }

        .btn-primary-action {
            background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%);
            color: #ffffff !important;
            box-shadow: 0 10px 24px -5px rgba(255, 107, 0, 0.42);
        }

        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px -5px rgba(255, 107, 0, 0.55);
            color: #ffffff !important;
            text-decoration: none;
        }

        .btn-secondary-action {
            background: #ffffff;
            color: #16a34a !important;
            border: 1.5px solid #22c55e;
            box-shadow: 0 6px 16px -3px rgba(34, 197, 94, 0.2);
        }

        .btn-secondary-action:hover {
            background: #22c55e;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px -3px rgba(34, 197, 94, 0.35);
            text-decoration: none;
        }

        .btn-outline-action {
            background: #f8fafc;
            color: #334155 !important;
            border: 1.5px solid #cbd5e1;
        }

        .btn-outline-action:hover {
            background: #e2e8f0;
            color: #0f172a !important;
            transform: translateY(-2px);
            text-decoration: none;
        }

        /* Subtle Help / Admin Notice Info Box */
        .info-pill-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 16px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.86rem;
            color: #334155;
            margin-bottom: 22px;
        }

        .info-pill-box i {
            color: var(--primary);
            font-size: 1rem;
        }

        /* Modern Micro Footer */
        .card-micro-footer {
            border-top: 1px solid #f1f5f9;
            padding-top: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--slate-400);
            font-weight: 500;
        }

        .card-micro-footer i {
            color: var(--primary);
            font-size: 0.85rem;
        }

        /* Rocket float animation */
        @keyframes rocketFloat {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50% { transform: translateY(-8px) rotate(5deg); }
        }
        .anim-rocket {
            display: inline-block;
            animation: rocketFloat 3s ease-in-out infinite;
        }

        /* Spinner gentle rotate animation */
        @keyframes wheelRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .anim-wheel {
            display: inline-block;
            animation: wheelRotate 12s linear infinite;
        }

        /* Responsive Mobile Styles */
        @media (max-width: 576px) {
            .page-container {
                padding: 16px 14px;
            }

            .status_hero_card {
                padding: 34px 22px 28px;
                border-radius: 26px;
            }

            .status-title {
                font-size: 1.55rem;
            }

            .status-desc {
                font-size: 0.92rem;
                margin-bottom: 22px;
            }

            .icon-hero-box {
                width: 76px;
                height: 76px;
                font-size: 1.9rem;
                border-radius: 24px;
                margin-bottom: 20px;
            }

            .btn-action {
                padding: 13px 18px;
                font-size: 0.96rem;
            }
        }
    </style>
</head>
<body>

    <!-- Background Atmospheric Glow Overlay -->
    <div class="bg-overlay"></div>

    <!-- Atom Particle & Planetary Orbits Canvas -->
    <canvas id="atomCanvas"></canvas>

    <!-- Main Content Container -->
    <div class="page-container">
        
        <div class="status_hero_card 
            @if ($status == 'user_date_expired') card-expired 
            @elseif ($status == 'no_camping_available') card-coming 
            @endif">

            {{-- Optional Brand Logo or Business Name --}}
            @if(isset($user))
                <div class="brand-header">
                    @if(!empty($user->logo))
                        <div class="brand-logo-wrapper">
                            <img src="{{$user->logo}}" alt="{{$user->name ?? 'Brand'}} Logo">
                        </div>
                    @endif
                    <div class="brand-name">{{ $user->name ?? 'Prize Wheel' }}</div>
                </div>
            @endif

            {{-- Status 1: Subscription Date Expired --}}
            @if ($status == 'user_date_expired')

                <div class="icon-hero-box icon-box-expired">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div class="status-badge badge-expired">
                    <span class="dot"></span>
                    <span>Subscription Expired</span>
                </div>

                <h1 class="status-title">Subscription Has Expired</h1>

                <p class="status-desc">
                    This promotional spin campaign is currently inactive because the account subscription has ended. Please contact the administrator or store owner to renew.
                </p>

                @if(isset($user) && !empty($user->phone))
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $user->phone);
                    @endphp
                    <div class="info-pill-box">
                        <i class="fa-solid fa-headset"></i>
                        <span>Support Helpline: <strong>{{ $user->phone }}</strong></span>
                    </div>
                @else
                    <div class="info-pill-box">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Contact your campaign administrator for account renewal</span>
                    </div>
                @endif

            {{-- Status 2: No Active Campaign Available --}}
            @elseif ($status == 'no_camping_available')

                <div class="icon-hero-box icon-box-coming">
                    <i class="fa-solid fa-rocket anim-rocket"></i>
                </div>

                <div class="status-badge badge-coming">
                    <span class="dot"></span>
                    <span>Stay Tuned</span>
                </div>

                <h1 class="status-title">Something Big Is Coming!</h1>

                <p class="status-desc">
                    We're preparing a brand-new interactive rewards campaign with exciting gifts and grand prizes. Keep this link bookmarked and check back soon!
                </p>

                @if(isset($user) && !empty($user->phone))
                    <div class="info-pill-box">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Contact Store: <strong>{{ $user->phone }}</strong></span>
                    </div>
                @endif

                <div class="actions-group">
                    <a href="javascript:location.reload()" class="btn-action btn-primary-action">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>Check Again / Refresh</span>
                    </a>
                </div>

            {{-- Status 3: Spins Not Available --}}
            @elseif ($status == 'spinn_not_available')

                <div class="icon-hero-box icon-box-spins">
                    <i class="fa-solid fa-dharmachakra anim-wheel"></i>
                </div>

                <div class="status-badge badge-spins">
                    <span class="dot"></span>
                    <span>Wheel Inactive</span>
                </div>

                <h1 class="status-title">No Spins Available Right Now</h1>

                <p class="status-desc">
                    The prize wheel segments are currently being configured or updated by the host. Please check back shortly to claim your rewards!
                </p>

                <div class="actions-group">
                    <a href="javascript:location.reload()" class="btn-action btn-primary-action">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>Refresh Status</span>
                    </a>
                </div>

            {{-- Status 4: Invalid URL / User Not Available --}}
            @else

                <div class="icon-hero-box icon-box-invalid">
                    <i class="fa-solid fa-compass"></i>
                </div>

                <div class="status-badge badge-invalid">
                    <span class="dot"></span>
                    <span>Page Not Found</span>
                </div>

                <h1 class="status-title">Invalid Campaign Link</h1>

                <p class="status-desc">
                    The requested prize wheel page was not found or the campaign link is invalid. Please double-check the URL and try again.
                </p>

                <div class="actions-group">
                    <a href="{{ url('/') }}" class="btn-action btn-primary-action">
                        <i class="fa-solid fa-house"></i>
                        <span>Return to Homepage</span>
                    </a>
                </div>

            @endif

        </div>

    </div>

    <!-- Atom UI Particle Simulation Script -->
    <script>
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

                    // Core highlight
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