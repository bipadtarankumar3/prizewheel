<!-- Atom Particle Canvas & Subtle Glow Overlay -->
<canvas id="atomCanvas"></canvas>
<div class="bg-overlay"></div>

<script>
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

    window.addEventListener('mousemove', function(e) {
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
          `rgba(217, 119, 6, ${this.alpha})`,
          `rgba(245, 158, 11, ${this.alpha * 0.95})`,
          `rgba(251, 191, 36, ${this.alpha * 0.9})`,
          `rgba(252, 211, 77, ${this.alpha * 0.85})`,
          `rgba(234, 88, 12, ${this.alpha * 0.75})`
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
          { r: 42 * scale, tilt: 0.45, angle: 0, rotAngle: 0.2, speed: 0.016, color: 'rgba(245, 158, 11, 0.45)', electronColor: '#d97706' },
          { r: 72 * scale, tilt: 0.50, angle: Math.PI / 3, rotAngle: 1.25, speed: -0.012, color: 'rgba(251, 191, 36, 0.42)', electronColor: '#f59e0b' },
          { r: 104 * scale, tilt: 0.42, angle: (Math.PI * 2) / 3, rotAngle: 2.35, speed: 0.009, color: 'rgba(217, 119, 6, 0.40)', electronColor: '#b45309' }
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

        // Halo
        const haloGrad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.coreR * 6 * pulseFactor);
        haloGrad.addColorStop(0, 'rgba(251, 191, 36, 0.38)');
        haloGrad.addColorStop(0.5, 'rgba(245, 158, 11, 0.14)');
        haloGrad.addColorStop(1, 'rgba(251, 191, 36, 0)');
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.coreR * 6 * pulseFactor, 0, Math.PI * 2);
        ctx.fillStyle = haloGrad;
        ctx.fill();

        // Core
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.coreR * pulseFactor, 0, Math.PI * 2);
        ctx.fillStyle = '#f59e0b';
        ctx.fill();

        // Highlight
        ctx.beginPath();
        ctx.arc(this.x - this.coreR * 0.3, this.y - this.coreR * 0.3, this.coreR * 0.4, 0, Math.PI * 2);
        ctx.fillStyle = '#ffffff';
        ctx.fill();

        // Orbits & Electrons
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
            ctx.strokeStyle = `rgba(217, 119, 6, ${alpha})`;
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
            ctx.strokeStyle = `rgba(217, 119, 6, ${alpha})`;
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
