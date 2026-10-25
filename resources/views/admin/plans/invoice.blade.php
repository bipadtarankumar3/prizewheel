<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - {{ $payment->payment_unique_id }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    body {
      background-color: #f1f5f9;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      color: #0f172a;
    }
    .invoice-card {
      max-width: 800px;
      margin: 40px auto;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.06);
      padding: 48px;
    }
    @media print {
      body {
        background: #fff;
      }
      .invoice-card {
        margin: 0;
        box-shadow: none;
        padding: 20px;
        max-width: 100%;
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<div class="container py-4">

  <!-- Action Bar -->
  <div class="d-flex align-items-center justify-content-between max-width-800 mx-auto mb-3 no-print" style="max-width: 800px;">
    <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold">
      ← Back
    </a>
    <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" style="background: #ff6b00; border-color: #ff6b00;">
      <i class="ti ti-printer me-1"></i> Print / Save as PDF
    </button>
  </div>

  <div class="invoice-card">
    
    <!-- Invoice Header -->
    <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
      <div>
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="rounded-3 p-2 text-white d-flex align-items-center justify-content-center" style="background: #ff6b00; width: 40px; height: 40px;">
            <i class="ti ti-aperture fs-4"></i>
          </div>
          <h3 class="fw-extrabold mb-0 text-dark" style="letter-spacing: -0.5px;">Prize<span style="color: #ff6b00;">Wheel</span></h3>
        </div>
        <p class="text-muted small mb-0">Digital Spin Wheel & Gamified Customer Engagement Platform</p>
      </div>

      <div class="text-end">
        <h4 class="text-uppercase fw-bold text-muted mb-1" style="letter-spacing: 1px;">TAX INVOICE</h4>
        <span class="fw-bold text-dark fs-5">#{{ $payment->payment_unique_id }}</span>
        <div class="mt-2">
          @if($payment->status === 'success')
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">✓ PAID</span>
          @else
            <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill fw-bold">{{ strtoupper($payment->status) }}</span>
          @endif
        </div>
      </div>
    </div>

    <!-- Billed To & From Details -->
    <div class="row g-4 mb-4">
      <div class="col-6">
        <span class="text-uppercase small fw-bold text-muted d-block mb-2">Billed To (Client):</span>
        <h5 class="fw-bold text-dark mb-1">{{ $payment->user->name ?? 'Store Client' }}</h5>
        <p class="text-muted small mb-0">{{ $payment->user->email ?? '' }}</p>
        <p class="text-muted small mb-0">{{ $payment->user->phone ?? '' }}</p>
        @if(!empty($payment->user->name_url))
          <small class="text-primary fw-semibold">{{ url('u/' . $payment->user->name_url) }}</small>
        @endif
      </div>

      <div class="col-6 text-end">
        <span class="text-uppercase small fw-bold text-muted d-block mb-2">Platform / Admin Details:</span>
        <h5 class="fw-bold text-dark mb-1">{{ $payment->admin->name ?? 'Administrator' }}</h5>
        <p class="text-muted small mb-0">{{ $payment->admin->email ?? '' }}</p>
        <p class="text-muted small mb-0">Date: <strong>{{ $payment->created_at->format('d F Y, h:i A') }}</strong></p>
        <p class="text-muted small mb-0">Gateway Ref: <code>{{ $payment->razorpay_payment_id ?: 'Razorpay Web Checkout' }}</code></p>
      </div>
    </div>

    <!-- Line Items Table -->
    <div class="table-responsive mb-4">
      <table class="table table-bordered align-middle">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="p-3">Description</th>
            <th class="p-3 text-center">Period / Validity</th>
            <th class="p-3 text-center">Qty</th>
            <th class="p-3 text-end">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="p-3">
              <span class="fw-bold text-dark d-block">{{ $payment->plan_name }}</span>
              <small class="text-muted">Digital spin wheel subscription access, campaigns, WhatsApp automation & lead capture.</small>
            </td>
            <td class="p-3 text-center text-muted small">
              {{ $payment->plan ? $payment->plan->duration_days . ' Days' : 'Subscription' }}
              @if($payment->expiry_extended_to)
                <div class="fw-semibold text-dark">Valid until: {{ date('d M Y', strtotime($payment->expiry_extended_to)) }}</div>
              @endif
            </td>
            <td class="p-3 text-center">1</td>
            <td class="p-3 text-end fw-bold text-dark fs-6">₹{{ number_format($payment->amount, 2) }}</td>
          </tr>
        </tbody>
        <tfoot class="border-top">
          <tr>
            <td colspan="3" class="text-end fw-bold p-3">Subtotal:</td>
            <td class="text-end fw-bold p-3">₹{{ number_format($payment->amount, 2) }}</td>
          </tr>
          <tr>
            <td colspan="3" class="text-end fw-bold p-3">Taxes & Fees:</td>
            <td class="text-end text-muted p-3">₹0.00 (Inclusive)</td>
          </tr>
          <tr class="table-light">
            <td colspan="3" class="text-end fw-extrabold fs-5 p-3 text-dark">Total Amount Paid:</td>
            <td class="text-end fw-extrabold fs-5 p-3 text-success">₹{{ number_format($payment->amount, 2) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>

    <!-- Notes & Footer -->
    <div class="border-top pt-4 text-center">
      <p class="small text-muted mb-1">
        This is a computer-generated receipt for electronic payment via Razorpay. No physical signature is required.
      </p>
      <small class="text-muted">Thank you for powering your customer engagement with Prize Wheel!</small>
    </div>

  </div>

</div>

</body>
</html>
