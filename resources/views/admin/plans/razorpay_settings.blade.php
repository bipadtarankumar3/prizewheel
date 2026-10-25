@extends('adminLayouts.home')
@section('content')

<div class="container-fluid">

  <!-- Header Banner -->
  <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff;">
    <div class="card-body p-4 p-md-5">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold mb-2" style="background: rgba(255, 255, 255, 0.2); color: #fff; font-size: 11px;">
            <i class="ti ti-lock me-1"></i> Individual Payment Gateway
          </span>
          <h2 class="fw-bold mb-2 text-white" style="letter-spacing: -0.5px;">Razorpay Payment Credentials</h2>
          <p class="mb-0" style="color: rgba(255, 255, 255, 0.9); max-width: 680px; font-size: 14px; line-height: 1.6;">
            All store subscription payments will be routed directly to your personal Razorpay merchant account. All admins hold their own individual credentials.
          </p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ url('admin/plans') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-semibold">
            <i class="ti ti-packages me-1"></i> Manage Plans
          </a>
          <a href="{{ url('admin/payments') }}" class="btn btn-light rounded-pill px-3 py-2 fw-semibold text-primary">
            <i class="ti ti-receipt me-1"></i> Payment Logs
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    
    <!-- Razorpay Credentials Form -->
    <div class="col-lg-7">
      <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-white border-bottom p-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <div class="p-2 rounded-3 text-white" style="background: #0284c7;">
                <i class="ti ti-key fs-4"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-0 text-dark">API Keys & Activation</h5>
                <small class="text-muted">Enter your Razorpay Live or Test Key ID and Key Secret</small>
              </div>
            </div>
            <span class="badge rounded-pill px-3 py-2 {{ $admin->razorpay_enabled ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} fw-bold">
              {{ $admin->razorpay_enabled ? '● Gateway Active' : '○ Gateway Disabled' }}
            </span>
          </div>
        </div>

        <form action="{{ url('admin/razorpay_settings') }}" method="POST">
          @csrf
          <div class="card-body p-4">
            
            <!-- Enable/Disable Gateway Switch -->
            <div class="p-3 rounded-3 mb-4 border d-flex align-items-center justify-content-between" style="background: #f8fafc;">
              <div>
                <h6 class="fw-bold mb-1 text-dark">Accept Online Payments with Razorpay</h6>
                <small class="text-muted">When enabled, your store users can renew their plans directly via UPI, Cards, & NetBanking.</small>
              </div>
              <div class="form-check form-switch fs-4 mb-0">
                <input class="form-check-input" type="checkbox" name="razorpay_enabled" id="razorpay_enabled" {{ $admin->razorpay_enabled ? 'checked' : '' }}>
              </div>
            </div>

            <!-- Key ID Input -->
            <div class="mb-4">
              <label class="form-label fw-bold text-dark small">Razorpay Key ID *</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="ti ti-id"></i></span>
                <input type="text" name="razorpay_key_id" class="form-control border-start-0" placeholder="rzp_test_... or rzp_live_..." value="{{ $admin->razorpay_key_id }}" required>
              </div>
              <small class="text-muted">Found in Razorpay Dashboard > Settings > API Keys</small>
            </div>

            <!-- Key Secret Input -->
            <div class="mb-4">
              <label class="form-label fw-bold text-dark small">Razorpay Key Secret *</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="ti ti-shield-lock"></i></span>
                <input type="password" name="razorpay_key_secret" id="razorpay_key_secret" class="form-control border-start-0 border-end-0" placeholder="{{ !empty($admin->razorpay_key_secret) ? '••••••••••••••••••••••••' : 'Enter Secret Key' }}">
                <button type="button" class="input-group-text bg-light border-start-0" onclick="toggleSecretVisibility()">
                  <i class="ti ti-eye" id="secretToggleIcon"></i>
                </button>
              </div>
              <small class="text-muted">Kept securely encrypted. Leave empty if you do not wish to change the existing secret.</small>
            </div>

            <!-- Currency Notice -->
            <div class="p-3 rounded-3 mb-3" style="background: #eff6ff; border: 1px solid #bfdbfe;">
              <div class="d-flex align-items-center gap-2 text-primary fw-semibold small">
                <i class="ti ti-info-circle fs-5"></i>
                <span>Currency is fixed to Indian Rupee (INR ₹). UPI, QR, Credit/Debit cards & Netbanking are automatically enabled.</span>
              </div>
            </div>

          </div>

          <div class="card-footer bg-white border-top p-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" style="background: #0284c7; border-color: #0284c7;">
              <i class="ti ti-device-floppy me-1"></i> Save Razorpay Credentials
            </button>
          </div>
        </form>

      </div>
    </div>

    <!-- Instructions & How To Guide -->
    <div class="col-lg-5">
      <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-4">
          <h5 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
            <i class="ti ti-help text-primary"></i> How to Get Your API Keys
          </h5>
          <ol class="small text-muted ps-3 mb-0 d-flex flex-column gap-2" style="line-height: 1.6;">
            <li>Log into your <strong><a href="https://dashboard.razorpay.com" target="_blank" class="text-primary text-decoration-none">Razorpay Dashboard</a></strong>.</li>
            <li>In the left sidebar, navigate to <strong>Settings</strong> &gt; <strong>API Keys</strong>.</li>
            <li>Click <strong>Generate Key</strong> (or copy your existing Live Key ID).</li>
            <li>Copy the <strong>Key ID</strong> and <strong>Key Secret</strong>.</li>
            <li>Paste them here and turn on the <strong>Accept Online Payments</strong> switch.</li>
            <li>Your retail store users will immediately see the payment gateway active on their subscription renewals!</li>
          </ol>
        </div>
      </div>

      <div class="card border-0 rounded-4 shadow-sm" style="background: #f8fafc; border: 1px dashed #cbd5e1 !important;">
        <div class="card-body p-4">
          <h6 class="fw-bold text-dark mb-2">Automated Notifications</h6>
          <p class="small text-muted mb-0">
            Whenever a client completes a payment through your Razorpay gateway, they will automatically receive a branded receipt email, and you will receive an instant revenue notification email at <strong>{{ $admin->email }}</strong>.
          </p>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
function toggleSecretVisibility() {
  const input = document.getElementById('razorpay_key_secret');
  const icon = document.getElementById('secretToggleIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('ti-eye');
    icon.classList.add('ti-eye-off');
  } else {
    input.type = 'password';
    icon.classList.remove('ti-eye-off');
    icon.classList.add('ti-eye');
  }
}
</script>

@endsection
