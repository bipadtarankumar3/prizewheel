@extends('adminLayouts.home')
@section('content')

<div class="container-fluid">

  <!-- Header Banner -->
  <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: #fff;">
    <div class="card-body p-4 p-md-5">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold mb-2" style="background: rgba(16, 185, 129, 0.2); color: #34d399; font-size: 11px;">
            <i class="ti ti-cash me-1"></i> Revenue & Transactions Oversight
          </span>
          <h2 class="fw-bold mb-2 text-white" style="letter-spacing: -0.5px;">Store Subscription Payments</h2>
          <p class="mb-0 text-slate-300" style="color: #94a3b8; max-width: 680px; font-size: 14px; line-height: 1.6;">
            Real-time tracking of all subscription renewals and receipts generated across your managed stores via Razorpay.
          </p>
        </div>
        <div class="d-flex align-items-center gap-2">
          <a href="{{ url('admin/plans') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-semibold">
            <i class="ti ti-packages me-1"></i> Plans
          </a>
          <a href="{{ url('admin/razorpay_settings') }}" class="btn btn-primary rounded-pill px-3 py-2 fw-semibold" style="background: #ff6b00; border-color: #ff6b00;">
            <i class="ti ti-key me-1"></i> Gateway Settings
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Metric Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small text-uppercase fw-bold">Total Revenue</span>
          <div class="p-2 rounded-3 bg-success-subtle text-success">
            <i class="ti ti-wallet fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">₹{{ number_format($totalRevenue, 2) }}</h2>
        <span class="text-muted small">Lifetime collected revenue</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small text-uppercase fw-bold">This Month</span>
          <div class="p-2 rounded-3 bg-primary-subtle text-primary">
            <i class="ti ti-calendar fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">₹{{ number_format($thisMonthRevenue, 2) }}</h2>
        <span class="text-muted small">{{ date('F Y') }} revenue</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small text-uppercase fw-bold">Total Transactions</span>
          <div class="p-2 rounded-3 bg-info-subtle text-info">
            <i class="ti ti-receipt fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $totalCount }}</h2>
        <span class="text-muted small">{{ $successCount }} Successful payments</span>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <span class="text-muted small text-uppercase fw-bold">Pending / Failed</span>
          <div class="p-2 rounded-3 bg-warning-subtle text-warning">
            <i class="ti ti-clock-pause fs-4"></i>
          </div>
        </div>
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $pendingCount }}</h2>
        <span class="text-muted small">Incomplete checkouts</span>
      </div>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
      <form action="{{ url('admin/payments') }}" method="GET">
        <div class="row g-3 align-items-end">
          
          <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">Search Keyword</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="ti ti-search"></i></span>
              <input type="text" name="search" class="form-control border-start-0" placeholder="Receipt / Payment ID / Store..." value="{{ request('search') }}">
            </div>
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-bold text-muted">From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-bold text-muted">To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-bold text-muted">Filter by Store</label>
            <select name="user_id" class="form-select">
              <option value="">All Stores</option>
              @foreach($usersList as $u)
                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                  {{ Str::limit($u->name, 20) }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-2">
            <label class="form-label small fw-bold text-muted">Status</label>
            <select name="status" class="form-select">
              <option value="">All Statuses</option>
              <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (Paid)</option>
              <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
          </div>

          <div class="col-md-1 d-flex gap-1">
            <button type="submit" class="btn btn-primary w-100 rounded-3" title="Apply Filters" style="background: #ff6b00; border-color: #ff6b00;">
              <i class="ti ti-filter"></i>
            </button>
            <a href="{{ url('admin/payments') }}" class="btn btn-light border rounded-3" title="Clear Filters">
              <i class="ti ti-rotate"></i>
            </a>
          </div>

        </div>
      </form>
    </div>
  </div>

  <!-- Payments Records Table -->
  <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
    <div class="card-header bg-white border-bottom p-4 d-flex align-items-center justify-content-between">
      <h5 class="fw-bold mb-0 text-dark">Transaction Records ({{ $payments->total() }})</h5>
      <span class="text-muted small">Showing {{ $payments->firstItem() ?? 0 }} - {{ $payments->lastItem() ?? 0 }}</span>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-4">Receipt / Order ID</th>
            <th>Store Client</th>
            <th>Plan Selected</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Validity Extended</th>
            <th>Payment Date</th>
            <th class="text-end pe-4">Invoice</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payments as $p)
            <tr>
              <td class="ps-4">
                <span class="fw-bold text-dark d-block">{{ $p->payment_unique_id }}</span>
                <small class="text-muted font-monospace">{{ $p->razorpay_payment_id ?: 'Pending Gateway' }}</small>
              </td>

              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background: #ea580c; font-size: 12px;">
                    {{ strtoupper(substr($p->user->name ?? 'S', 0, 1)) }}
                  </div>
                  <div>
                    <span class="fw-bold text-dark d-block">{{ $p->user->name ?? 'Deleted Store' }}</span>
                    <small class="text-muted">{{ $p->user->email ?? 'N/A' }}</small>
                  </div>
                </div>
              </td>

              <td>
                <span class="badge rounded-pill bg-light text-dark border px-3 py-2 fw-semibold">
                  {{ $p->plan_name }}
                </span>
              </td>

              <td>
                <span class="fw-bold text-dark fs-6">₹{{ number_format($p->amount, 2) }}</span>
              </td>

              <td>
                @if($p->status === 'success')
                  <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 fw-bold">
                    ✓ Paid
                  </span>
                @elseif($p->status === 'pending')
                  <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2 fw-bold">
                    ⏳ Pending
                  </span>
                @else
                  <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2 fw-bold">
                    ✕ Failed
                  </span>
                @endif
              </td>

              <td>
                @if($p->expiry_extended_to)
                  <span class="text-dark fw-semibold">{{ date('d M Y', strtotime($p->expiry_extended_to)) }}</span>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              <td>
                <span class="text-dark d-block small fw-semibold">{{ $p->created_at->format('d M Y') }}</span>
                <small class="text-muted">{{ $p->created_at->format('h:i A') }}</small>
              </td>

              <td class="text-end pe-4">
                <a href="{{ url('admin/invoice/' . $p->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold">
                  <i class="ti ti-file-text me-1"></i> Invoice
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="ti ti-receipt-off fs-1 d-block mb-2"></i>
                No payment transactions match the selected criteria.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($payments->hasPages())
      <div class="card-footer bg-white border-top p-4 d-flex justify-content-center">
        {{ $payments->links() }}
      </div>
    @endif
  </div>

</div>

@endsection
