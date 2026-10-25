@extends('adminLayouts.home')
@section('content')

<!-- Razorpay Standard Checkout SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container-fluid">

  @php
    $isExpired = $user->isExpired();
    $daysLeft = $user->daysRemaining();
  @endphp

  <!-- Status Alert Banner -->
  @if($isExpired)
    <div class="alert alert-danger rounded-4 p-4 shadow-sm border-0 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center p-3">
          <i class="ti ti-alert-triangle fs-3"></i>
        </div>
        <div>
          <h5 class="fw-bold text-danger mb-1">Your Store Subscription Has Expired!</h5>
          <p class="mb-0 text-muted small">
            Customer wheel spins and new campaign creation are paused. Select one of the plans below to instantly renew via Razorpay.
          </p>
        </div>
      </div>
      <a href="#plansGrid" class="btn btn-danger rounded-pill px-4 py-2 fw-semibold shadow-sm">
        <i class="ti ti-credit-card me-1"></i> Choose Plan & Pay
      </a>
    </div>
  @endif

  <!-- Top Hero Card: Current Subscription Overview -->
  <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #fff;">
    <div class="card-body p-4 p-md-5">
      <div class="row align-items-center g-4">
        
        <div class="col-lg-7">
          <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
            <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold" style="background: {{ $isExpired ? 'rgba(239, 68, 68, 0.25)' : 'rgba(16, 185, 129, 0.25)' }}; color: {{ $isExpired ? '#fca5a5' : '#6ee7b7' }}; border: 1px solid {{ $isExpired ? 'rgba(239, 68, 68, 0.4)' : 'rgba(16, 185, 129, 0.4)' }}; font-size: 11px;">
              {{ $isExpired ? '● Subscription Expired' : '● Active Subscription' }}
            </span>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(255, 255, 255, 0.1); color: #cbd5e1; font-size: 11px;">
              Store: {{ $user->name }}
            </span>
          </div>
          <h2 class="fw-bold mb-2 text-white" style="letter-spacing: -0.5px;">
            {{ $currentPlan ? $currentPlan->name : '1-Day Trial / Free Tier' }}
          </h2>
          <p class="mb-0" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">
            Manage your store membership plan, access entitlements, and view previous Razorpay payment receipts.
          </p>
        </div>

        <div class="col-lg-5">
          <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="row g-3 text-center">
              <div class="col-6 border-end border-white-10">
                <span class="text-muted small text-uppercase fw-semibold d-block">Expiry Date</span>
                <span class="fw-bold fs-5 {{ $isExpired ? 'text-danger' : 'text-white' }}">
                  {{ $user->expiry_date ? date('d M Y', strtotime($user->expiry_date)) : 'Not Set' }}
                </span>
                <small class="d-block {{ $isExpired ? 'text-danger' : 'text-success' }} fw-semibold mt-1">
                  {{ $isExpired ? 'Ended' : $daysLeft . ' Days Left' }}
                </small>
              </div>
              <div class="col-6">
                <span class="text-muted small text-uppercase fw-semibold d-block">Wheel Spin Balance</span>
                <span class="fw-bold fs-5 text-white">
                  {{ $user->spin_whell_round ?: 0 }} Spins
                </span>
                <small class="d-block text-muted mt-1">
                  Total Spins Used: {{ $user->total_spin_round ?: 0 }}
                </small>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- User Payment & Subscription Stat Counters -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small text-uppercase fw-bold">Total Invoices</span>
          <div class="p-2 rounded-3 bg-primary-subtle text-primary">
            <i class="ti ti-receipt-2 fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $totalPaymentsCount }}</h2>
        <span class="text-muted small">All payments & invoices</span>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small text-uppercase fw-bold">Total Amount Paid</span>
          <div class="p-2 rounded-3 bg-success-subtle text-success">
            <i class="ti ti-wallet fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">₹{{ number_format($totalAmountSpent, 2) }}</h2>
        <span class="text-muted small">Successful renewal spend</span>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small text-uppercase fw-bold">Completed Renewals</span>
          <div class="p-2 rounded-3 bg-info-subtle text-info">
            <i class="ti ti-circle-check fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $successfulPaymentsCount }}</h2>
        <span class="text-muted small">Activated subscriptions</span>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white h-100">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small text-uppercase fw-bold">Account Access</span>
          <div class="p-2 rounded-3 {{ $isExpired ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
            <i class="ti {{ $isExpired ? 'ti-lock-cancel' : 'ti-shield-check' }} fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold {{ $isExpired ? 'text-danger' : 'text-success' }} mb-1" style="letter-spacing: -0.5px;">
          {{ $isExpired ? 'Expired' : 'Active' }}
        </h2>
        <span class="text-muted small">
          {{ $isExpired ? 'Ended on ' . ($user->expiry_date ? date('d M Y', strtotime($user->expiry_date)) : 'N/A') : $daysLeft . ' Days Remaining' }}
        </span>
      </div>
    </div>
  </div>

  <!-- Plans Selection Section -->
  <div class="mb-5" id="plansGrid">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
      <div>
        <h4 class="fw-bold text-dark mb-1">Choose a Subscription Plan</h4>
        <p class="text-muted small mb-0">Select a plan to renew and unlock all digital wheel features instantly via Razorpay.</p>
      </div>
      @if(!$adminRazorpayConfigured)
        <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2 fw-semibold">
          <i class="ti ti-info-circle me-1"></i> Admin Online Gateway Pending Setup
        </span>
      @endif
    </div>

    <div class="row g-4">
      @forelse($plans as $plan)
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 rounded-4 shadow-sm position-relative overflow-hidden transition-all hover-shadow" style="border: 2px solid {{ $plan->is_popular ? '#ff6b00' : '#e2e8f0' }} !important; background: #ffffff;">
            
            @if($plan->is_popular)
              <div class="position-absolute top-0 end-0 py-1 px-4 text-white text-uppercase fw-bold" style="background: #ff6b00; font-size: 10px; letter-spacing: 1px; border-bottom-left-radius: 12px;">
                ★ Recommended
              </div>
            @endif

            <div class="card-body p-4 d-flex flex-column">
              <span class="badge rounded-pill px-3 py-1 mb-2 fw-semibold bg-light text-dark border align-self-start">
                {{ $plan->duration_days }} Days Access
              </span>
              <h4 class="fw-bold mb-1 text-dark">{{ $plan->name }}</h4>
              <p class="text-muted small mb-3">{{ $plan->description ?: 'Complete prize wheel & review marketing package' }}</p>

              <!-- Price -->
              <div class="p-3 rounded-3 mb-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                <div class="d-flex align-items-baseline gap-1">
                  <span class="fs-4 fw-bold text-dark">₹</span>
                  <span class="display-6 fw-extrabold text-dark" style="letter-spacing: -1px;">{{ number_format($plan->price, 0) }}</span>
                  <span class="text-muted fw-semibold small">/ {{ $plan->duration_days }} Days</span>
                </div>
              </div>

              <!-- Features List -->
              <div class="mb-4 flex-grow-1">
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                  <li class="d-flex align-items-center gap-2">
                    <i class="ti ti-circle-check-filled text-success fs-5"></i>
                    <span><strong>{{ $plan->spin_rounds_limit === -1 ? 'Unlimited' : number_format($plan->spin_rounds_limit) }}</strong> Wheel Spins</span>
                  </li>
                  <li class="d-flex align-items-center gap-2">
                    <i class="ti ti-circle-check-filled text-success fs-5"></i>
                    <span><strong>{{ $plan->campaigns_limit === -1 ? 'Unlimited' : $plan->campaigns_limit }}</strong> Active Campaigns</span>
                  </li>
                  <li class="d-flex align-items-center gap-2">
                    @if($plan->has_whatsapp)
                      <i class="ti ti-circle-check-filled text-success fs-5"></i>
                      <span>WhatsApp Customer Alerts</span>
                    @else
                      <i class="ti ti-circle-x text-muted fs-5"></i>
                      <span class="text-muted text-decoration-line-through">WhatsApp Automation</span>
                    @endif
                  </li>
                  <li class="d-flex align-items-center gap-2">
                    @if($plan->has_ip_skip)
                      <i class="ti ti-circle-check-filled text-success fs-5"></i>
                      <span>IP Skip & Fraud Protection</span>
                    @else
                      <i class="ti ti-circle-x text-muted fs-5"></i>
                      <span class="text-muted text-decoration-line-through">IP Protection</span>
                    @endif
                  </li>
                  <li class="d-flex align-items-center gap-2">
                    @if($plan->has_custom_branding)
                      <i class="ti ti-circle-check-filled text-success fs-5"></i>
                      <span>Custom Logo & Background</span>
                    @else
                      <i class="ti ti-circle-x text-muted fs-5"></i>
                      <span class="text-muted text-decoration-line-through">Custom Branding</span>
                    @endif
                  </li>
                  @if(!empty($plan->features_list))
                    @php
                      $cleanFeatures = preg_split('/(\\\\r\\\\n|\\\\n|\\\\r|\r\n|\n|\r)/', $plan->features_list);
                    @endphp
                    @foreach($cleanFeatures as $feat)
                      @if(trim($feat))
                        <li class="d-flex align-items-center gap-2">
                          <i class="ti ti-circle-check-filled text-primary fs-5"></i>
                          <span>{{ trim($feat) }}</span>
                        </li>
                      @endif
                    @endforeach
                  @endif
                </ul>
              </div>

              <!-- Pay CTA Button -->
              <button type="button" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm pay-plan-btn" data-plan-id="{{ $plan->id }}" data-plan-name="{{ $plan->name }}" data-plan-price="{{ $plan->price }}" style="background: {{ $plan->is_popular ? '#ff6b00' : '#0284c7' }}; border-color: {{ $plan->is_popular ? '#ff6b00' : '#0284c7' }};">
                <i class="ti ti-bolt me-1"></i> Pay ₹{{ number_format($plan->price, 0) }} via Razorpay
              </button>

            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="card border-0 rounded-4 shadow-sm text-center py-5">
            <p class="text-muted mb-0">No active plans are currently listed. Please contact your account administrator.</p>
          </div>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Previous Payment History -->
  <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-5">
    <div class="card-header bg-white border-bottom p-4">
      <h5 class="fw-bold mb-0 text-dark">Your Payment & Receipt History</h5>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-4">Receipt / Order</th>
            <th>Plan Name</th>
            <th>Amount Paid</th>
            <th>Payment ID</th>
            <th>Validity Extended To</th>
            <th>Date & Time</th>
            <th>Status</th>
            <th class="text-end pe-4">Receipt</th>
          </tr>
        </thead>
        <tbody>
          @forelse($paymentsHistory as $payment)
            <tr>
              <td class="ps-4 fw-bold text-dark">{{ $payment->payment_unique_id }}</td>
              <td><span class="badge rounded-pill bg-light text-dark border px-3 py-2 fw-semibold">{{ $payment->plan_name }}</span></td>
              <td class="fw-bold text-dark">₹{{ number_format($payment->amount, 2) }}</td>
              <td><small class="text-muted font-monospace">{{ $payment->razorpay_payment_id ?: '—' }}</small></td>
              <td>
                @if($payment->expiry_extended_to)
                  <span class="text-dark fw-semibold">{{ date('d M Y', strtotime($payment->expiry_extended_to)) }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td>
                <small class="text-dark fw-semibold d-block">{{ $payment->created_at->format('d M Y') }}</small>
                <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
              </td>
              <td>
                @if($payment->status === 'success')
                  <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 fw-bold">✓ Paid</span>
                @elseif($payment->status === 'pending')
                  <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2 fw-bold">⏳ Pending</span>
                @else
                  <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2 fw-bold">✕ Failed</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <a href="{{ url('admin/invoice/' . $payment->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                  <i class="ti ti-file-text me-1"></i> Invoice
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="ti ti-receipt-off fs-1 d-block mb-2"></i>
                No payment history yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Razorpay Payment Processing Script -->
<script>
document.querySelectorAll('.pay-plan-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const planId = this.getAttribute('data-plan-id');
    const originalText = this.innerHTML;
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Preparing Gateway...';

    fetch("{{ url('admin/subscription/create_order') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ plan_id: planId })
    })
    .then(res => res.json())
    .then(orderData => {
      btn.disabled = false;
      btn.innerHTML = originalText;

      if (!orderData.success) {
        alert(orderData.message || 'Unable to initialize payment gateway.');
        return;
      }

      const options = {
        key: orderData.razorpay_key,
        amount: orderData.amount,
        currency: orderData.currency,
        name: "Prize Wheel",
        description: orderData.plan_description,
        image: "{{ asset('frontend/spinner/wheel/trophy.png') }}",
        order_id: orderData.order_id,
        prefill: {
          name: orderData.user_name,
          email: orderData.user_email,
          contact: orderData.user_phone
        },
        theme: {
          color: "#ff6b00"
        },
        handler: function (response) {
          btn.disabled = true;
          btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Verifying Payment...';

          // Verify signature on backend
          fetch("{{ url('admin/subscription/verify_payment') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              razorpay_payment_id: response.razorpay_payment_id,
              razorpay_order_id: response.razorpay_order_id,
              razorpay_signature: response.razorpay_signature,
              payment_id: orderData.payment_id
            })
          })
          .then(vRes => vRes.json())
          .then(vData => {
            if (vData.success) {
              alert(vData.message || 'Subscription renewed successfully!');
              window.location.href = "{{ url('admin/billing') }}";
            } else {
              alert(vData.message || 'Payment verification failed.');
              btn.disabled = false;
              btn.innerHTML = originalText;
            }
          })
          .catch(err => {
            console.error(err);
            alert('Verification request failed. Please check your transaction history.');
            btn.disabled = false;
            btn.innerHTML = originalText;
          });
        },
        modal: {
          ondismiss: function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
          }
        }
      };

      const rzp = new Razorpay(options);
      rzp.on('payment.failed', function (response) {
        alert("Payment Failed: " + response.error.description);
        btn.disabled = false;
        btn.innerHTML = originalText;
      });
      rzp.open();

    })
    .catch(err => {
      console.error(err);
      alert('Network or server error while connecting to payment gateway.');
      btn.disabled = false;
      btn.innerHTML = originalText;
    });
  });
});
</script>

@endsection
