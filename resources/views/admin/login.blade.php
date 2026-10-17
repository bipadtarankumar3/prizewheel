<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>Prize Wheel | Digital Spin Wheel & Multi-Platform for Prize Distribution</title>
  <meta name="description" content="Digital Spin Wheel, Reviews & Rewards Hub. Boost 5-star Google Reviews and engage customers with gamified prize wheels." />
  <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/spinner/wheel/trophy.png') }}" />
  
  <!-- Modern Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Toastr Notification CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  
  <!-- Confetti JS for Celebrations -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <!-- Login & Registration Page Stylesheet -->
  <link rel="stylesheet" href="{{ asset('adminAssets/css/login.css') }}?v={{ time() }}">
</head>
<body>

  <!-- Atom Particle Canvas Background -->
  <canvas id="atomCanvas"></canvas>
  <!-- Dark Gradient Overlay -->
  <div class="bg-overlay"></div>

  <!-- Mobile Viewport Switcher Bar (Visible on mobile/tablet <= 1023px) -->
  <div class="auth-mobile-switch-bar">
    <button type="button" class="mobile-switch-tab active" id="tabShowLogin" onclick="switchMobileAuthView('login')">
      <i class="bi bi-person-lock"></i> <span>Sign In</span>
    </button>
    <button type="button" class="mobile-switch-tab" id="tabShowTour" onclick="switchMobileAuthView('tour')">
      <i class="bi bi-phone"></i> <span>Spin &amp; Win Demo</span>
    </button>
  </div>

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



      <section class="showcase-card" id="showcaseContainer">
        
        <div class="carousel-wrapper">
          <div class="carousel-track" id="carouselTrack">
            
            <!-- SLIDE 1: INTERACTIVE PRIZE WHEEL -->
            <div class="carousel-slide" data-slide="0">
              <div class="feature-pill-badge">
                <i class="fa-solid fa-dharmachakra"></i>
                <span>Magic Spin Wheel</span>
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
                        <!-- Gold Teardrop Pointer -->
                        <div class="wheel-pointer-pin">
                          <svg viewBox="0 0 22 32" fill="none">
                            <defs>
                              <linearGradient id="goldPin" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#fbbf24"/>
                                <stop offset="50%" stop-color="#f59e0b"/>
                                <stop offset="100%" stop-color="#b45309"/>
                              </linearGradient>
                            </defs>
                            <ellipse cx="11" cy="10" rx="9" ry="9" fill="url(#goldPin)" stroke="#92400e" stroke-width="1"/>
                            <polygon points="11,30 4,14 18,14" fill="url(#goldPin)" stroke="#92400e" stroke-width="1"/>
                            <ellipse cx="8" cy="8" rx="3" ry="3" fill="rgba(255,255,255,0.45)"/>
                          </svg>
                        </div>

                        <!-- SVG Wheel Disc — 6 coloured slices with radius text -->
                        <div class="wheel-disc" id="interactiveWheel" onclick="spinDemoWheel()">
                          <svg viewBox="0 0 300 300">
                            <defs>
                              <!-- Thick red outer rim gradient -->
                              <linearGradient id="rimGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#ef4444"/>
                                <stop offset="100%" stop-color="#b91c1c"/>
                              </linearGradient>
                            </defs>

                            <!-- Red outer rim ring -->
                            <circle cx="150" cy="150" r="148" fill="url(#rimGrad)" />
                            <circle cx="150" cy="150" r="135" fill="#fff" />

                            <!-- Slice 1: Orange — top-right (0°→60°) -->
                            <path d="M150,150 L150,16 A134,134 0 0,1 266,83 Z" fill="#f97316" />
                            <!-- Slice 2: Purple -->
                            <path d="M150,150 L266,83 A134,134 0 0,1 266,217 Z" fill="#7c3aed" />
                            <!-- Slice 3: Red-Orange -->
                            <path d="M150,150 L266,217 A134,134 0 0,1 150,284 Z" fill="#ef4444" />
                            <!-- Slice 4: Blue -->
                            <path d="M150,150 L150,284 A134,134 0 0,1 34,217 Z" fill="#2563eb" />
                            <!-- Slice 5: Green -->
                            <path d="M150,150 L34,217 A134,134 0 0,1 34,83 Z" fill="#10b981" />
                            <!-- Slice 6: Amber/Gold -->
                            <path d="M150,150 L34,83 A134,134 0 0,1 150,16 Z" fill="#f59e0b" />

                            <!-- White divider lines -->
                            <line x1="150" y1="150" x2="150" y2="16" stroke="#fff" stroke-width="2.5"/>
                            <line x1="150" y1="150" x2="266" y2="83" stroke="#fff" stroke-width="2.5"/>
                            <line x1="150" y1="150" x2="266" y2="217" stroke="#fff" stroke-width="2.5"/>
                            <line x1="150" y1="150" x2="150" y2="284" stroke="#fff" stroke-width="2.5"/>
                            <line x1="150" y1="150" x2="34" y2="217" stroke="#fff" stroke-width="2.5"/>
                            <line x1="150" y1="150" x2="34" y2="83" stroke="#fff" stroke-width="2.5"/>

                            <!-- Slice labels: simple rotated text per slice, anchored at midpoint radius -->
                            <!-- Slice 1 midpoint = 30° (Orange) -->
                            <text x="150" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#fff" font-family="sans-serif" transform="rotate(30,150,150)">JACKPOT!</text>
                            <!-- Slice 2 midpoint = 90° (Purple) -->
                            <text x="150" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#fff" font-family="sans-serif" transform="rotate(90,150,150)">COFFEE</text>
                            <!-- Slice 3 midpoint = 150° (Red) -->
                            <text x="150" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#fff" font-family="sans-serif" transform="rotate(150,150,150)">50% OFF</text>
                            <!-- Slice 4 midpoint = 210° (Blue) -->
                            <text x="150" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#fff" font-family="sans-serif" transform="rotate(210,150,150)">20% OFF</text>
                            <!-- Slice 5 midpoint = 270° (Green) -->
                            <text x="150" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#fff" font-family="sans-serif" transform="rotate(270,150,150)">FREE GIFT</text>
                            <!-- Slice 6 midpoint = 330° (Gold) -->
                            <text x="150" y="88" text-anchor="middle" font-size="12" font-weight="800" fill="#fff" font-family="sans-serif" transform="rotate(330,150,150)">10% OFF</text>

                            <!-- Inner white hub ring -->
                            <circle cx="150" cy="150" r="34" fill="#fff" stroke="rgba(255,107,0,0.6)" stroke-width="3"/>

                            <!-- Gold studs on red rim at slice boundaries -->
                            <circle cx="150" cy="7" r="6" fill="#fbbf24" stroke="#92400e" stroke-width="1"/>
                            <circle cx="266" cy="78" r="6" fill="#fbbf24" stroke="#92400e" stroke-width="1"/>
                            <circle cx="266" cy="222" r="6" fill="#fbbf24" stroke="#92400e" stroke-width="1"/>
                            <circle cx="150" cy="293" r="6" fill="#fbbf24" stroke="#92400e" stroke-width="1"/>
                            <circle cx="34" cy="222" r="6" fill="#fbbf24" stroke="#92400e" stroke-width="1"/>
                            <circle cx="34" cy="78" r="6" fill="#fbbf24" stroke="#92400e" stroke-width="1"/>

                            <!-- Diamond arrow markers at slice midpoints on outer rim -->
                            <polygon points="150,138 142,150 150,162 158,150" fill="#fff" opacity="0.9" transform="rotate(-90, 150, 150) translate(0,-116)"/>
                            <polygon points="150,138 142,150 150,162 158,150" fill="#fff" opacity="0.9" transform="rotate(-30, 150, 150) translate(0,-116)"/>
                            <polygon points="150,138 142,150 150,162 158,150" fill="#fff" opacity="0.9" transform="rotate(30, 150, 150) translate(0,-116)"/>
                            <polygon points="150,138 142,150 150,162 158,150" fill="#fff" opacity="0.9" transform="rotate(90, 150, 150) translate(0,-116)"/>
                            <polygon points="150,138 142,150 150,162 158,150" fill="#fff" opacity="0.9" transform="rotate(150, 150, 150) translate(0,-116)"/>
                            <polygon points="150,138 142,150 150,162 158,150" fill="#fff" opacity="0.9" transform="rotate(210, 150, 150) translate(0,-116)"/>
                          </svg>
                        </div>

                        <!-- Center Spin Knob -->
                        <div class="wheel-center-knob" onclick="spinDemoWheel()">
                          <span>SPIN</span>
                          <i class="fa-solid fa-play"></i>
                        </div>
                      </div>

                      <div class="wheel-result-banner" id="wheelPrizeText">
                        <i class="fa-solid fa-trophy"></i> Click SPIN to win!
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
                    value="{{ old('name') }}"
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
                    value="{{ old('email') }}"
                    class="form-control-input" 
                    placeholder="contact@business.com" 
                    required 
                    autocomplete="email"
                  />
                  <i class="fa-regular fa-envelope input-icon-left"></i>
                </div>
                <div id="emailAvailabilityNotice" style="font-size: 11.5px; margin-top: 5px; font-weight: 600; display: none;"></div>
              </div>

              <!-- WhatsApp Number -->
              <div class="form-group">
                <label class="form-label" for="regPhone">WhatsApp / Contact Number</label>
                <div class="input-with-icon">
                  <input 
                    type="tel" 
                    id="regPhone" 
                    name="phone" 
                    value="{{ old('phone') }}"
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
                <label class="checkbox-label" style="font-size:11.5px; align-items:flex-start; cursor:pointer;" onclick="handleTermsLabelClick(event)">
                  <input type="checkbox" name="terms" id="termsCheckbox" required onclick="handleTermsCheckboxClick(event)" style="margin-top:2px; cursor:pointer; accent-color:var(--primary);" />
                  <span id="termsLabelText">I agree to the <a href="javascript:void(0)" onclick="openLegalModal('terms'); event.stopPropagation();" style="color:var(--primary); text-decoration:none; font-weight:700;">Terms of Service</a> & <a href="javascript:void(0)" onclick="openLegalModal('privacy'); event.stopPropagation();" style="color:var(--primary); text-decoration:none; font-weight:700;">Privacy Policy</a></span>
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

  <!-- Terms of Service & Privacy Policy Modal -->
  <div class="legal-modal-backdrop" id="legalModalBackdrop" style="display: none;" onclick="handleLegalBackdropClick(event)">
    <div class="legal-modal-card" role="dialog" aria-modal="true" aria-labelledby="legalModalTitle">
      
      <!-- Modal Header -->
      <div class="legal-modal-header">
        <div class="legal-modal-title-wrap">
          <div class="legal-modal-icon">
            <i class="fa-solid fa-shield-halved"></i>
          </div>
          <div>
            <h3 class="legal-modal-title" id="legalModalTitle">Legal Agreements & Policies</h3>
            <p class="legal-modal-subtitle">Review our Terms of Service & Privacy Policy to activate your account</p>
          </div>
        </div>
        <button type="button" class="legal-modal-close" onclick="closeLegalModal()" title="Close dialog">&times;</button>
      </div>

      <!-- Tab Buttons -->
      <div class="legal-modal-tabs">
        <button type="button" class="legal-tab-btn active" id="tabTermsBtn" onclick="switchLegalTab('terms')">
          <i class="fa-solid fa-file-contract"></i>
          <span>Terms of Service</span>
        </button>
        <button type="button" class="legal-tab-btn" id="tabPrivacyBtn" onclick="switchLegalTab('privacy')">
          <i class="fa-solid fa-user-shield"></i>
          <span>Privacy Policy</span>
        </button>
      </div>

      <!-- Modal Body (Scrollable) -->
      <div class="legal-modal-body">
        
        <!-- Terms Pane -->
        <div class="legal-pane" id="paneTerms">
          <div class="legal-section">
            <span class="legal-badge">Clause 1</span>
            <h4>Acceptance of Terms</h4>
            <p>Welcome to PrizeWheel. By registering, accessing, or using our interactive gamification platform, you confirm that you are at least 18 years of age and agree to be legally bound by these Terms of Service. If you are registering on behalf of a business entity, you represent and warrant that you possess the authority to bind such entity to these Terms.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Clause 2</span>
            <h4>Account Registration & 1-Day Trial</h4>
            <p>During registration, you agree to provide true, accurate, and current business details, including business name, official contact number, and authorized email address. New registered accounts receive a complimentary 1-Day Full Access Trial to test and configure prize campaigns. After the trial period, continuous campaign access requires subscription activation or renewal according to your chosen plan.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Clause 3</span>
            <h4>Campaigns & Prize Fulfilment</h4>
            <p>You are solely responsible for all prizes, discount vouchers, gifts, and promotional promises advertised on your custom wheel campaigns. You warrant that all promotional contents comply with applicable local trade, commercial, and consumer protection laws. PrizeWheel provides software infrastructure only and does not supply physical awards or settle merchant-customer prize disputes.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Clause 4</span>
            <h4>Lead Capture & Customer Communications</h4>
            <p>Customer contact records (names, phone numbers, email addresses) captured via wheel forms belong to you as data controller. You agree to obtain proper customer consent before sending promotional WhatsApp, SMS, or email communications and adhere to relevant anti-spam regulations.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Clause 5</span>
            <h4>Platform Integrity & Prohibited Use</h4>
            <p>You agree not to reverse engineer, scrape, bypass rate limits, inject malicious scripts, or exploit the wheel spin mechanics. Any attempt to artificially manipulate win probabilities or compromise server infrastructure will result in immediate account termination without refund.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Clause 6</span>
            <h4>Limitation of Liability</h4>
            <p>PrizeWheel is provided on an "as-is" and "as-available" basis. We disclaim all implied warranties of merchantability or fitness for a particular purpose. In no event shall PrizeWheel be liable for indirect, incidental, or consequential business losses or lost revenue.</p>
          </div>
        </div>

        <!-- Privacy Pane -->
        <div class="legal-pane" id="panePrivacy" style="display: none;">
          <div class="legal-section">
            <span class="legal-badge">Privacy 1</span>
            <h4>Information We Collect</h4>
            <p>We collect information provided directly by you during account creation (business name, owner/representative name, email address, WhatsApp/mobile phone number, and encrypted authentication credentials). We also record server logs, IP addresses, and campaign analytics to ensure platform security and fraud prevention.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Privacy 2</span>
            <h4>How We Use Collected Data</h4>
            <p>Collected information is used strictly to provide, maintain, and enhance platform services; verify authentic human users; deliver transaction notifications; provide technical customer support; and verify campaign performance metrics.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Privacy 3</span>
            <h4>Zero Unauthorized Resale</h4>
            <p><strong>We do not sell, rent, or trade your personal or customer lead data to third-party data brokers.</strong> Your captured customer leads remain strictly associated with your merchant account and can be exported by you at any time.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Privacy 4</span>
            <h4>Data Security & Encryption</h4>
            <p>We implement enterprise-grade security protocols, including 256-bit SSL encryption in transit, strict database access controls, salted credential hashing, and regular security reviews to safeguard your information against unauthorized access, loss, or disclosure.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Privacy 5</span>
            <h4>Cookies & Session Storage</h4>
            <p>We use essential cookies and session tokens to remember your login state, maintain active dashboard sessions, and prevent cross-site request forgery (CSRF) attacks.</p>
          </div>

          <div class="legal-section">
            <span class="legal-badge">Privacy 6</span>
            <h4>Your Rights & Contact</h4>
            <p>You maintain the right to review, update, or request the deletion of your account information at any time. For privacy inquiries or assistance, reach our support team via the helpline number listed on our platform.</p>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="legal-modal-footer">
        <div class="legal-modal-footer-note">
          <i class="fa-solid fa-circle-info"></i>
          <span>Clicking "I Agree & Accept" will mark the agreement checkbox as accepted.</span>
        </div>
        <div class="legal-modal-btn-row">
          <button type="button" class="legal-btn-secondary" onclick="closeLegalModal()">
            Decline / Close
          </button>
          <button type="button" class="legal-btn-primary" onclick="acceptTermsAndClose()">
            <i class="fa-solid fa-check"></i>
            <span>I Agree & Accept</span>
          </button>
        </div>
      </div>

    </div>
  </div>

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

    @if($errors->any())
      @foreach($errors->all() as $err)
        toastr.error("{{ $err }}");
      @endforeach
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

    // Mobile Viewport Switcher Controller (Sign In vs Spin & Win Demo)
    window.switchMobileAuthView = function(mode) {
      const showcasePanel = document.querySelector('.split-left');
      const formPanel = document.querySelector('.split-right');
      const tabLogin = document.getElementById('tabShowLogin');
      const tabTour = document.getElementById('tabShowTour');

      if (mode === 'tour') {
        if (showcasePanel) showcasePanel.classList.add('mobile-active');
        if (formPanel) formPanel.classList.add('mobile-hidden');
        if (tabTour) tabTour.classList.add('active');
        if (tabLogin) tabLogin.classList.remove('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      } else {
        if (showcasePanel) showcasePanel.classList.remove('mobile-active');
        if (formPanel) formPanel.classList.remove('mobile-hidden');
        if (tabLogin) tabLogin.classList.add('active');
        if (tabTour) tabTour.classList.remove('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    };

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
      const shouldSignup = hash === '#signup' || 
                           window.location.search.includes('mode=signup') || 
                           "{{ old('name') || old('phone') || (($initialMode ?? '') === 'signup') ? '1' : '0' }}" === "1";
      if (shouldSignup) {
        switchToMode('signup');
      } else if (hash === '#login' || window.location.search.includes('mode=login')) {
        switchToMode('login');
      }

      // Real-time email validation for signup
      const regEmailInput = document.getElementById('regEmail');
      const emailNotice = document.getElementById('emailAvailabilityNotice');
      let emailTimer = null;

      if (regEmailInput && emailNotice) {
        regEmailInput.addEventListener('input', function() {
          clearTimeout(emailTimer);
          const emailVal = this.value.trim();

          if (!emailVal || !emailVal.includes('@') || emailVal.length < 5) {
            emailNotice.style.display = 'none';
            return;
          }

          emailNotice.style.display = 'block';
          emailNotice.style.color = '#64748b';
          emailNotice.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Checking email...';

          emailTimer = setTimeout(() => {
            fetch("{{ route('check_email_availability') }}?email=" + encodeURIComponent(emailVal))
              .then(res => res.json())
              .then(data => {
                if (data.status === 'exists') {
                  emailNotice.style.display = 'block';
                  emailNotice.style.color = '#ef4444';
                  emailNotice.dataset.exists = '1';
                  emailNotice.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + data.message + ' <a href="javascript:void(0)" onclick="switchToMode(\'login\')" style="color:#ff6b00; text-decoration:underline; font-weight:700;">Sign in here</a>';
                } else if (data.status === 'available') {
                  emailNotice.style.display = 'block';
                  emailNotice.style.color = '#10b981';
                  emailNotice.dataset.exists = '0';
                  emailNotice.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + data.message;
                } else {
                  emailNotice.style.display = 'none';
                  emailNotice.dataset.exists = '0';
                }
              })
              .catch(() => {
                emailNotice.style.display = 'none';
              });
          }, 400);
        });
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

    /* ==========================================================================
       TERMS & PRIVACY MODAL LOGIC
       ========================================================================== */
    function openLegalModal(tab) {
      const modal = document.getElementById('legalModalBackdrop');
      if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        switchLegalTab(tab || 'terms');
      }
    }

    function closeLegalModal() {
      const modal = document.getElementById('legalModalBackdrop');
      if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
      }
    }

    function handleLegalBackdropClick(event) {
      if (event.target && event.target.id === 'legalModalBackdrop') {
        closeLegalModal();
      }
    }

    function switchLegalTab(tab) {
      const tabTerms = document.getElementById('tabTermsBtn');
      const tabPrivacy = document.getElementById('tabPrivacyBtn');
      const paneTerms = document.getElementById('paneTerms');
      const panePrivacy = document.getElementById('panePrivacy');

      if (!tabTerms || !tabPrivacy || !paneTerms || !panePrivacy) return;

      if (tab === 'privacy') {
        tabTerms.classList.remove('active');
        tabPrivacy.classList.add('active');
        paneTerms.style.display = 'none';
        panePrivacy.style.display = 'block';
      } else {
        tabPrivacy.classList.remove('active');
        tabTerms.classList.add('active');
        panePrivacy.style.display = 'none';
        paneTerms.style.display = 'block';
      }
    }

    let termsAccepted = false;

    function acceptTermsAndClose() {
      termsAccepted = true;
      const termsCheckbox = document.getElementById('termsCheckbox');
      if (termsCheckbox) {
        termsCheckbox.checked = true;
        if (typeof $ !== 'undefined') {
          $(termsCheckbox).trigger('change');
        }
      }
      closeLegalModal();
      if (typeof toastr !== 'undefined') {
        toastr.success("Terms of Service & Privacy Policy accepted!");
      }
    }

    function handleTermsCheckboxClick(e) {
      const termsCheckbox = document.getElementById('termsCheckbox');
      if (!termsAccepted) {
        if (e) {
          e.preventDefault();
        }
        if (termsCheckbox) {
          termsCheckbox.checked = false;
        }
        openLegalModal('terms');
        return false;
      } else {
        if (termsCheckbox && !termsCheckbox.checked) {
          termsAccepted = false;
        }
      }
    }

    function handleTermsLabelClick(e) {
      if (e.target && (e.target.id === 'termsCheckbox' || (e.target.tagName && e.target.tagName.toLowerCase() === 'a'))) {
        return;
      }
      handleTermsCheckboxClick(e);
    }

    window.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeLegalModal();
      }
    });

    // Ensure terms checkbox starts unchecked
    document.addEventListener('DOMContentLoaded', function() {
      const termsCheckbox = document.getElementById('termsCheckbox');
      if (termsCheckbox) {
        termsCheckbox.checked = false;
        termsAccepted = false;
      }
    });

    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
      signupForm.addEventListener('submit', function (e) {
        const termsCheckbox = document.getElementById('termsCheckbox');
        if (termsCheckbox && !termsCheckbox.checked) {
          e.preventDefault();
          openLegalModal('terms');
          if (typeof toastr !== 'undefined') {
            toastr.info("Please review and accept our Terms of Service & Privacy Policy to continue.");
          }
          return false;
        }

        const p1 = document.getElementById('regPassword').value;
        const p2 = document.getElementById('regConfirmPassword').value;
        if (p1 !== p2) {
          e.preventDefault();
          toastr.error("Passwords do not match. Please re-enter.");
          return false;
        }

        const emailNotice = document.getElementById('emailAvailabilityNotice');
        if (emailNotice && emailNotice.dataset.exists === '1') {
          e.preventDefault();
          toastr.error("This email is already registered. Please sign in or use Google Login.");
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