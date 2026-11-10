{{-- Shared Terms of Service & Privacy Policy modal (used on register page and first-login profile modal). Checkbox must have id="termsCheckbox". --}}
<link rel="stylesheet" href="{{ asset('adminAssets/css/legal-modal.css') }}?v={{ time() }}">
@if(!empty($loadFontAwesome))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>.legal-modal-backdrop{z-index:200000;}</style>
@endif

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
<script>
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
        // Keep body scroll locked if a Bootstrap modal is still open underneath
        if (!document.querySelector('.modal.show')) {
          document.body.style.overflow = '';
        }
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
      const termsErr = document.getElementById('firstLoginTermsError');
      if (termsErr) termsErr.style.display = 'none';
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
</script>
