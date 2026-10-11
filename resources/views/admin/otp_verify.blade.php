<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>Verify OTP | PrizeWheel Security</title>
  <meta name="description" content="Two-factor verification for PrizeWheel Admin." />
  <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/spinner/wheel/trophy.png') }}" />

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Toastr Notifications -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

  <style>
    :root {
      --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --font-heading: 'Space Grotesk', var(--font-main);

      --primary: #ff6b00;
      --primary-hover: #ea580c;
      --primary-gradient: linear-gradient(135deg, #ff6b00 0%, #ff8c3a 50%, #f97316 100%);
      --primary-glow: rgba(255, 107, 0, 0.35);
      --primary-light: #fff7ed;

      --text-dark: #0f172a;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --card-bg: #ffffff;

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

    /* Atom Canvas */
    #atomCanvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 2;
      pointer-events: none;
    }

    .bg-overlay {
      position: fixed;
      inset: 0;
      z-index: 1;
      background:
        radial-gradient(ellipse 65% 55% at 20% 30%, rgba(255, 107, 0, 0.09) 0%, transparent 65%),
        radial-gradient(ellipse 55% 55% at 75% 70%, rgba(79, 70, 229, 0.07) 0%, transparent 60%);
      pointer-events: none;
    }

    .app-viewport {
      position: relative;
      z-index: 5;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 20px;
    }

    .split-grid {
      display: grid;
      grid-template-columns: 1.15fr 0.95fr;
      max-width: 1100px;
      width: 100%;
      background: #ffffff;
      border-radius: 28px;
      border: 1px solid rgba(226, 232, 240, 0.95);
      box-shadow: 0 25px 60px -12px rgba(15, 23, 42, 0.14);
      overflow: hidden;
    }

    /* Left Security Showcase */
    .split-left {
      background: linear-gradient(145deg, #0f172a 0%, #1e293b 100%);
      padding: 56px 48px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      color: #ffffff;
      overflow: hidden;
    }

    .split-left::after {
      content: '';
      position: absolute;
      top: -30%;
      left: -20%;
      width: 140%;
      height: 140%;
      background: radial-gradient(circle, rgba(255, 107, 0, 0.18) 0%, transparent 60%);
      pointer-events: none;
    }

    .brand-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 13px;
      font-weight: 700;
      color: #ffffff;
      width: fit-content;
      backdrop-filter: blur(8px);
    }
    .brand-pill img {
      width: 20px;
      height: 20px;
      object-fit: contain;
    }

    .security-hero-box {
      margin: 40px 0;
      position: relative;
      z-index: 3;
    }

    .security-icon-shield {
      width: 68px;
      height: 68px;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--primary) 0%, #ea580c 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      color: #ffffff;
      margin-bottom: 24px;
      box-shadow: 0 10px 30px var(--primary-glow);
    }

    .security-title {
      font-family: var(--font-heading);
      font-size: 30px;
      font-weight: 800;
      line-height: 1.25;
      letter-spacing: -0.02em;
      margin-bottom: 14px;
      color: #ffffff;
    }

    .security-desc {
      font-size: 15px;
      color: #94a3b8;
      line-height: 1.6;
      max-width: 440px;
    }

    .security-perks {
      display: flex;
      flex-direction: column;
      gap: 16px;
      position: relative;
      z-index: 3;
    }

    .perk-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
    }

    .perk-icon-circle {
      width: 34px;
      height: 34px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.07);
      border: 1px solid rgba(255, 255, 255, 0.12);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ff8c3a;
      font-size: 14px;
      flex-shrink: 0;
    }

    .perk-text h5 {
      font-size: 14px;
      font-weight: 700;
      color: #f1f5f9;
      margin-bottom: 2px;
    }
    .perk-text p {
      font-size: 12.5px;
      color: #94a3b8;
      margin: 0;
      line-height: 1.4;
    }

    /* Right Auth Form */
    .split-right {
      padding: 56px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .badge-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--primary-light);
      color: #ea580c;
      border: 1px solid rgba(255, 107, 0, 0.2);
      padding: 5px 14px;
      border-radius: 9999px;
      font-size: 11.5px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 12px;
      width: fit-content;
    }

    .auth-title {
      font-family: var(--font-heading);
      font-size: 26px;
      font-weight: 800;
      color: var(--text-dark);
      letter-spacing: -0.02em;
      margin-bottom: 8px;
    }

    .auth-sub {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.55;
      margin-bottom: 28px;
    }

    .otp-envelope-card {
      background: #f8fafc;
      border: 1.5px dashed #cbd5e1;
      border-radius: 14px;
      padding: 12px 16px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .envelope-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: #e0f2fe;
      color: #0284c7;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .envelope-txt {
      font-size: 12.5px;
      color: #475569;
      line-height: 1.4;
    }
    .envelope-txt strong {
      color: #0f172a;
    }

    /* OTP Input */
    .otp-input-wrap {
      margin-bottom: 24px;
    }

    .otp-input-field {
      width: 100%;
      height: 60px;
      border-radius: 14px;
      border: 2px solid #cbd5e1;
      background: #ffffff;
      font-family: monospace, var(--font-main);
      font-size: 32px;
      font-weight: 800;
      text-align: center;
      letter-spacing: 12px;
      color: #0f172a;
      outline: none;
      transition: all 0.25s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .otp-input-field:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.18);
      background: #fffdfa;
    }

    .otp-btn-submit {
      width: 100%;
      height: 52px;
      background: var(--primary-gradient);
      color: #ffffff;
      border: none;
      border-radius: 14px;
      font-size: 15px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      box-shadow: 0 6px 20px var(--primary-glow);
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      margin-bottom: 20px;
    }

    .otp-btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(255, 107, 0, 0.5);
      color: #ffffff;
    }

    .resend-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 13px;
      color: var(--text-muted);
      padding-top: 10px;
      border-top: 1px solid #f1f5f9;
    }

    .resend-link {
      color: var(--primary);
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s ease;
    }
    .resend-link:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }

    .back-login-link {
      color: #64748b;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s ease;
    }
    .back-login-link:hover {
      color: #0f172a;
    }

    /* Responsive */
    @media (max-width: 991px) {
      .split-grid {
        grid-template-columns: 1fr;
        max-width: 520px;
      }
      .split-left {
        padding: 40px 32px 32px;
      }
      .security-title {
        font-size: 24px;
      }
      .security-hero-box {
        margin: 24px 0;
      }
      .split-right {
        padding: 40px 32px;
      }
    }

    @media (max-width: 480px) {
      .app-viewport {
        padding: 15px 12px;
      }
      .split-left {
        padding: 30px 22px;
      }
      .split-right {
        padding: 30px 22px;
      }
      .otp-input-field {
        font-size: 24px;
        letter-spacing: 8px;
        height: 52px;
      }
    }
  </style>
</head>
<body>

  <!-- Floating Atom Particle Canvas Background -->
  <canvas id="atomCanvas"></canvas>
  <div class="bg-overlay"></div>

  <main class="app-viewport">
    <div class="split-grid">

      <!-- Left Security Showcase Column -->
      <div class="split-left">
        <div>
          <div class="brand-pill">
            <img src="{{ asset('frontend/spinner/wheel/trophy.png') }}" alt="PrizeWheel" onerror="this.style.display='none'">
            <span>Prize<span>Wheel</span> Platform</span>
          </div>

          <div class="security-hero-box">
            <div class="security-icon-shield">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h1 class="security-title">Two-Factor Security Verification</h1>
            <p class="security-desc">
              Your administrative dashboard is protected with high-grade multi-factor authentication to ensure safe management of customer vouchers, wheel campaigns, and review links.
            </p>
          </div>
        </div>

        <div class="security-perks">
          <div class="perk-item">
            <div class="perk-icon-circle">
              <i class="fa-solid fa-bolt"></i>
            </div>
            <div class="perk-text">
              <h5>Instant OTP Delivery</h5>
              <p>A fresh 6-digit code has been delivered to your authorized inbox.</p>
            </div>
          </div>
          <div class="perk-item">
            <div class="perk-icon-circle">
              <i class="fa-solid fa-lock"></i>
            </div>
            <div class="perk-text">
              <h5>Session Token Encryption</h5>
              <p>Single-use authorization code invalidates immediately upon successful sign-in.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right OTP Verification Form -->
      <div class="split-right">
        <div>
          <div class="badge-tag">
            <i class="fa-solid fa-fingerprint"></i>
            <span>Identity Check</span>
          </div>

          <h2 class="auth-title">Enter Verification Code</h2>
          <p class="auth-sub">
            Please enter the 6-digit OTP sent to your registered admin email address to unlock your session.
          </p>

          <div class="otp-envelope-card">
            <div class="envelope-icon">
              <i class="fa-regular fa-envelope-open"></i>
            </div>
            <div class="envelope-txt">
              Code sent to: <strong>{{ $maskedEmail ?? 'your registered email' }}</strong><br>
              <span style="font-size: 11.5px; color: #94a3b8;">Default test code is <strong>123456</strong> if running in local sandbox.</span>
            </div>
          </div>

          <!-- OTP Form -->
          <form method="POST" action="{{ url('otp_verify') }}" id="otpForm">
            @csrf

            <div class="otp-input-wrap">
              <label for="otpInputField" style="font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;">
                6-Digit OTP Code
              </label>
              <input 
                type="text" 
                name="otp" 
                id="otpInputField" 
                class="otp-input-field" 
                placeholder="------" 
                maxlength="6" 
                pattern="[0-9]*" 
                inputmode="numeric" 
                autocomplete="one-time-code" 
                required 
                autofocus
              />
            </div>

            <button type="submit" class="otp-btn-submit" id="submitOtpBtn">
              <span>Verify &amp; Continue</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </form>

          <div class="resend-row">
            <a href="{{ url('resend_otp') }}" class="resend-link" title="Send a fresh OTP code">
              <i class="fa-solid fa-rotate-right"></i> Resend Code
            </a>
            <a href="{{ url('login') }}" class="back-login-link">
              <i class="fa-solid fa-arrow-left"></i> Back to Login
            </a>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- jQuery & Toastr -->
  <script src="{{ asset('adminAssets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script>
    // Notifications
    @if(Session::has('messege'))
      var type = "{{ Session::get('alert-type', 'info') }}";
      toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 4000
      };
      switch (type) {
        case 'info': toastr.info("{{ Session::get('messege') }}"); break;
        case 'success': toastr.success("{{ Session::get('messege') }}"); break;
        case 'warning': toastr.warning("{{ Session::get('messege') }}"); break;
        case 'error': toastr.error("{{ Session::get('messege') }}"); break;
      }
    @endif

    @if(Session::has('otp_error'))
      toastr.error("Invalid OTP code. Please check your email or resend a new code.", "Verification Failed");
    @endif

    // Numeric filter for OTP input
    const otpInput = document.getElementById('otpInputField');
    if (otpInput) {
      otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 6) {
          // Auto submit when 6 digits are reached
          // document.getElementById('otpForm').submit();
        }
      });
    }

    // =========================================================
    // ATOM PARTICLES CANVAS ENGINE
    // =========================================================
    (function initAtomCanvas() {
      const canvas = document.getElementById('atomCanvas');
      if (!canvas) return;
      const ctx = canvas.getContext('2d');
      let width, height;
      let atoms = [];
      const numAtoms = 42;

      function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resize);
      resize();

      class Atom {
        constructor() {
          this.reset();
        }
        reset() {
          this.x = Math.random() * width;
          this.y = Math.random() * height;
          this.radius = Math.random() * 2.8 + 1.2;
          this.vx = (Math.random() - 0.5) * 0.7;
          this.vy = (Math.random() - 0.5) * 0.7;
          this.alpha = Math.random() * 0.5 + 0.2;
          this.color = Math.random() > 0.4 ? '255, 107, 0' : '79, 70, 229';
        }
        update() {
          this.x += this.vx;
          this.y += this.vy;
          if (this.x < 0 || this.x > width) this.vx *= -1;
          if (this.y < 0 || this.y > height) this.vy *= -1;
        }
        draw() {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
          ctx.fillStyle = `rgba(${this.color}, ${this.alpha})`;
          ctx.shadowBlur = 8;
          ctx.shadowColor = `rgba(${this.color}, 0.6)`;
          ctx.fill();
        }
      }

      for (let i = 0; i < numAtoms; i++) {
        atoms.push(new Atom());
      }

      function connect() {
        for (let i = 0; i < atoms.length; i++) {
          for (let j = i + 1; j < atoms.length; j++) {
            const dx = atoms[i].x - atoms[j].x;
            const dy = atoms[i].y - atoms[j].y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 120) {
              const alpha = (1 - dist / 120) * 0.18;
              ctx.beginPath();
              ctx.strokeStyle = `rgba(255, 107, 0, ${alpha})`;
              ctx.lineWidth = 1;
              ctx.moveTo(atoms[i].x, atoms[i].y);
              ctx.lineTo(atoms[j].x, atoms[j].y);
              ctx.stroke();
            }
          }
        }
      }

      function animate() {
        ctx.clearRect(0, 0, width, height);
        atoms.forEach(atom => {
          atom.update();
          atom.draw();
        });
        connect();
        requestAnimationFrame(animate);
      }
      animate();
    })();
  </script>

</body>
</html>