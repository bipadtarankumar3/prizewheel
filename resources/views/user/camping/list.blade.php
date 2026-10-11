@extends('adminLayouts.home')
@section('content')

<div class="container-fluid">

  {{-- ==========================================
       FUTURISTIC CAMPAIGN HERO & METRICS HUB
       ========================================== --}}
  <div class="dash-hero-card mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <span class="dash-hero-pill pill-orange">
            <i class="ti ti-speakerphone"></i> Campaign Central
          </span>
          <span class="dash-hero-pill pill-blue">
            <i class="ti ti-activity"></i> {{ $activeCampaignsCount ?? 0 }} Active Now
          </span>
          <span class="dash-hero-pill">
            <i class="ti ti-calendar"></i> {{ date('d M Y') }}
          </span>
        </div>
        <h2 class="dash-hero-title">Campaign Intelligence & Lead Tracking 🚀</h2>
        <p class="dash-hero-subtitle">
          Real-time analytics for every marketing wheel campaign. Track how many customers joined, what type of details were captured, and which prizes were unlocked.
        </p>
      </div>

      <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ url('admin/add_camping_page') }}" class="dash-hero-btn dash-hero-btn-primary">
          <i class="ti ti-plus"></i> Create New Campaign
        </a>
        <a href="{{ url('admin/expired_camping_list') }}" class="dash-hero-btn dash-hero-btn-secondary" style="border-color: rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.15); color: #fca5a5;">
          <i class="ti ti-calendar-off"></i> Expired Campaigns
        </a>
        <a href="{{ url('admin/spinner_form_camping_list') }}" class="dash-hero-btn dash-hero-btn-secondary">
          <i class="ti ti-id"></i> All Customer Leads
        </a>
      </div>
    </div>

    {{-- Futuristic Summary Counters Ribbon --}}
    <div class="row g-2 mt-3 pt-3 border-top border-white border-opacity-10">
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle bg-white bg-opacity-10 p-2 text-warning d-flex align-items-center justify-content-center">
            <i class="ti ti-speakerphone fs-5"></i>
          </div>
          <div>
            <div class="fw-bolder fs-5 lh-1 text-white">{{ $totalCampaignsCount ?? 0 }}</div>
            <small class="text-white text-opacity-75" style="font-size: 11.5px;">Total Campaigns</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle bg-white bg-opacity-10 p-2 text-info d-flex align-items-center justify-content-center">
            <i class="ti ti-users fs-5"></i>
          </div>
          <div>
            <div class="fw-bolder fs-5 lh-1 text-white">{{ number_format($totalParticipantsJoined ?? 0) }}</div>
            <small class="text-white text-opacity-75" style="font-size: 11.5px;">Participants Joined</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle bg-white bg-opacity-10 p-2 text-success d-flex align-items-center justify-content-center">
            <i class="ti ti-trophy fs-5"></i>
          </div>
          <div>
            <div class="fw-bolder fs-5 lh-1 text-white">{{ number_format($totalPrizesAwarded ?? 0) }}</div>
            <small class="text-white text-opacity-75" style="font-size: 11.5px;">Prizes Won</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle bg-white bg-opacity-10 p-2 text-danger d-flex align-items-center justify-content-center">
            <i class="ti ti-photo-check fs-5"></i>
          </div>
          <div>
            <div class="fw-bolder fs-5 lh-1 text-white">{{ number_format($totalVerifiedReceipts ?? 0) }}</div>
            <small class="text-white text-opacity-75" style="font-size: 11.5px;">Receipt Uploads</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ==========================================
       SEARCH & DATE FILTER BAR
       ========================================== --}}
  <div class="card p-3 rounded-4 border border-light shadow-sm mb-4 bg-white">
    <form action="{{ url('admin/camping_list') }}" method="post">
      @csrf
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label small fw-bold text-muted mb-1">Start Date</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-light text-muted"><i class="ti ti-calendar"></i></span>
            <input type="date" class="form-control border-light bg-light" name="start_date" value="{{ isset($start_date) ? date('Y-m-d', strtotime($start_date)) : '' }}" placeholder="Filter from date">
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label small fw-bold text-muted mb-1">End Date</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-light text-muted"><i class="ti ti-calendar"></i></span>
            <input type="date" class="form-control border-light bg-light" name="end_date" value="{{ isset($end_date) ? date('Y-m-d', strtotime($end_date)) : '' }}" placeholder="Filter to date">
          </div>
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary rounded-3 fw-bold flex-grow-1">
            <i class="ti ti-filter me-1"></i> Apply Filter
          </button>
          <a href="{{ url('admin/camping_list') }}" class="btn btn-light rounded-3 fw-bold text-muted" title="Reset filter">
            <i class="ti ti-rotate-clockwise"></i>
          </a>
        </div>
      </div>
    </form>
  </div>

  {{-- ==========================================
       DETAILED CAMPAIGN INTELLIGENCE TABLE
       ========================================== --}}
  <form id="bulkCampaignForm" action="{{ url('admin/downloadCampaignPdf') }}" method="post">
    @csrf

    <div class="dash-modern-card">
      <div class="dash-card-header">
        <div class="d-flex align-items-center gap-2">
          <h3 class="dash-card-title">
            <i class="ti ti-list-details text-primary"></i> All Wheel Campaigns & Captured Data Breakdown
          </h3>
          <span class="badge bg-light text-muted fw-bold rounded-pill">{{ count($camping) }} Campaigns</span>
        </div>

        <div class="d-flex align-items-center gap-2">
          <button type="submit" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
            <i class="ti ti-file-download me-1"></i> Download Selected PDF
          </button>
          <a href="{{ url('admin/add_camping_page') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
            <i class="ti ti-plus me-1"></i> New Campaign
          </a>
        </div>
      </div>

      <div class="dash-card-body p-0">
        <div class="table-responsive">
          <table class="table modern-table mb-0 align-middle">
            <thead>
              <tr>
                <th style="width: 40px;">
                  <input class="form-check-input" id="select_all" type="checkbox" title="Select All">
                </th>
                <th>Campaign & Live Status</th>
                <th>Participants & Velocity</th>
                <th>Captured Details Breakdown</th>
                <th>Prizes & Stock</th>
                <th>Timeline & Speed</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($camping as $key => $item)
              @php
                $isEnded = !empty($item->end_date) && (strtotime($item->end_date) < strtotime(date('Y-m-d')));
                $totSpins = max(1, (int)($item->number_of_total_spinn ?? 2000));
                $compPct = min(100, round((($item->form_submitted ?? 0) / $totSpins) * 100, 1));
                $storeUrl = url('u/' . (Auth::user()->name_url ?: Auth::user()->id));
              @endphp
              <tr>
                {{-- Bulk Checkbox --}}
                <td>
                  <input name="checkbox[]" class="form-check-input camp-checkbox" type="checkbox" value="{{ $item->id }}">
                </td>

                {{-- Campaign Name & Live Status --}}
                <td>
                  <div class="d-flex align-items-start gap-2">
                    <div>
                      <div class="d-flex align-items-center gap-2 mb-1">
                        @if(!$isEnded && $item->status == 'active')
                          <span class="camp-pulse-dot" title="Campaign Live & Active"></span>
                          <span class="badge bg-success-subtle text-success px-2 py-0 rounded-pill fw-bold" style="font-size: 11px;">Active</span>
                        @elseif($isEnded)
                          <span class="badge bg-danger-subtle text-danger px-2 py-0 rounded-pill fw-bold" style="font-size: 11px;">Expired</span>
                        @else
                          <span class="badge bg-secondary-subtle text-secondary px-2 py-0 rounded-pill fw-bold" style="font-size: 11px;">Paused</span>
                        @endif
                        <span class="fw-bold text-dark fs-4">{{ $item->campaign_name }}</span>
                      </div>
                      <div class="text-muted small text-truncate" style="max-width: 250px;">
                        {{ $item->title ?: 'Digital Spin Wheel Campaign' }}
                      </div>
                      @if($item->sub_title)
                        <small class="text-muted text-opacity-75 text-truncate d-block" style="max-width: 250px; font-size: 11px;">
                          {{ $item->sub_title }}
                        </small>
                      @endif
                    </div>
                  </div>
                </td>

                {{-- Participants Joined & Velocity --}}
                <td>
                  <div style="min-width: 170px;">
                    <div class="d-flex align-items-baseline gap-1 mb-1">
                      <span class="fs-6 fw-bolder text-primary lh-1">{{ $item->total_joined ?? 0 }}</span>
                      <span class="small fw-bold text-dark">Users Joined</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-1 text-muted" style="font-size: 11px;">
                      <span>Spins: <strong>{{ $item->form_submitted ?? 0 }}</strong> / {{ number_format($totSpins) }}</span>
                      <span class="fw-bold text-dark">{{ $compPct }}%</span>
                    </div>

                    <div class="camp-glow-bar">
                      <div class="camp-glow-bar-fill" style="width: {{ $compPct }}%;"></div>
                    </div>
                  </div>
                </td>

                {{-- What Type of Details Were Captured (Data Chips) --}}
                <td>
                  <div class="d-flex flex-wrap gap-1" style="max-width: 280px;">
                    {{-- 1. Phone / WhatsApp --}}
                    <span class="camp-data-pill pill-phone" title="Phone & WhatsApp numbers captured">
                      <i class="ti ti-phone"></i> {{ $item->phone_count ?? 0 }} Phone
                    </span>

                    {{-- 2. Emails --}}
                    <span class="camp-data-pill pill-email" title="Customer email addresses captured">
                      <i class="ti ti-mail"></i> {{ $item->email_count ?? 0 }} Email
                    </span>

                    {{-- 3. Bill / Receipt Proofs --}}
                    <span class="camp-data-pill pill-receipt" title="Customers who uploaded purchase receipts/bill proof">
                      <i class="ti ti-photo"></i> {{ $item->receipt_count ?? 0 }} Receipts
                    </span>

                    {{-- 4. Bike Models / Products (if available) --}}
                    @if(!empty($item->model_count))
                      <span class="camp-data-pill pill-model" title="Vehicle / Product model selected">
                        <i class="ti ti-motorbike"></i> {{ $item->model_count }} Models
                      </span>
                    @endif

                    {{-- 5. Address Info --}}
                    @if(!empty($item->address_count))
                      <span class="camp-data-pill pill-address" title="Customer addresses collected">
                        <i class="ti ti-map-pin"></i> {{ $item->address_count }} Addr
                      </span>
                    @endif

                    {{-- 6. Unique Devices --}}
                    <span class="camp-data-pill pill-device" title="Distinct mobile & desktop devices">
                      <i class="ti ti-device-mobile"></i> {{ $item->unique_devices ?? 0 }} Devices
                    </span>
                  </div>
                </td>

                {{-- Prizes & Rewards Claimed --}}
                <td>
                  <div style="min-width: 150px;">
                    <div class="d-flex align-items-center gap-1 mb-1">
                      <i class="ti ti-trophy text-warning"></i>
                      <span class="fw-bold text-dark" style="font-size: 13px;">{{ $item->prizes_won_count ?? 0 }} Prizes Won</span>
                    </div>
                    
                    <small class="text-muted d-block" style="font-size: 11.5px;">
                      Wheel Slices: <strong>{{ $item->slices_count ?? 0 }}</strong> configured
                    </small>

                    @if(!empty($item->top_prize_name))
                      <div class="mt-1">
                        <span class="badge rounded-pill px-2 py-1 text-dark fw-bold text-truncate d-inline-block" style="background: {{ $item->top_prize_color ?: '#fef08a' }}; max-width: 140px; font-size: 11px;" title="Top winning prize">
                          ★ {{ $item->top_prize_name }} ({{ $item->top_prize_count }}x)
                        </span>
                      </div>
                    @endif
                  </div>
                </td>

                {{-- Timeline & Speed --}}
                <td>
                  <div style="min-width: 140px;">
                    <div class="text-dark fw-semibold" style="font-size: 12.5px;">
                      {{ date('d M Y', strtotime($item->start_date)) }}
                    </div>
                    <div class="text-muted" style="font-size: 11.5px;">
                      to {{ date('d M Y', strtotime($item->end_date)) }}
                    </div>
                    <div class="mt-1">
                      <span class="badge bg-light text-muted px-2 py-0 rounded-pill" style="font-size: 11px;">
                        <i class="ti ti-clock-play me-1"></i> {{ $item->spinner_time ?? 20 }}s spin
                      </span>
                    </div>
                  </div>
                </td>

                {{-- Futuristic Actions --}}
                <td class="text-end">
                  <div class="d-inline-flex align-items-center gap-1">
                    {{-- View Inquiries Leads Link --}}
                    <a href="{{ url('admin/spinner_form_list/' . $item->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" title="Inspect Customer Leads">
                      <i class="ti ti-users me-1"></i> Leads ({{ $item->total_joined ?? 0 }})
                    </a>

                    {{-- Edit Campaign --}}
                    <a href="{{ url('admin/edit_camping/' . $item->id) }}" class="btn btn-sm btn-light text-dark rounded-circle p-2" title="Edit Campaign Settings">
                      <i class="ti ti-pencil"></i>
                    </a>

                    {{-- Copy Live Wheel Link --}}
                    <button type="button" class="btn btn-sm btn-light text-primary rounded-circle p-2" onclick="copyStoreUrl('{{ $storeUrl }}')" title="Copy Live Wheel Link">
                      <i class="ti ti-copy"></i>
                    </button>

                    {{-- Delete Campaign --}}
                    <a href="{{ url('admin/delete_camping/' . $item->id) }}" class="btn btn-sm btn-light text-danger rounded-circle p-2" onclick="return confirm('Are you sure you want to delete this campaign?');" title="Delete Campaign">
                      <i class="ti ti-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                  <div class="py-4">
                    <i class="ti ti-speakerphone-off fs-8 text-primary mb-2 d-block"></i>
                    <h5 class="fw-bold">No campaigns found</h5>
                    <p class="text-muted small mb-3">Create your first wheel campaign to start capturing customer leads and rewarding prizes.</p>
                    <a href="{{ url('admin/add_camping_page') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                      <i class="ti ti-plus me-1"></i> Create Campaign
                    </a>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </form>

</div>

{{-- Toast Notification --}}
<div id="toastCopyFeedback" class="toast-copy-notify">
  <i class="ti ti-check fs-5 text-success"></i>
  <span>Wheel Link copied to clipboard!</span>
</div>

<script>
  function copyStoreUrl(url) {
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(url).then(showToast);
    } else {
      let textArea = document.createElement("textarea");
      textArea.value = url;
      textArea.style.position = "fixed";
      textArea.style.left = "-999999px";
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();
      try {
        document.execCommand('copy');
        showToast();
      } catch (err) {
        console.error('Copy failed', err);
      }
      textArea.remove();
    }
  }

  function showToast() {
    const toast = document.getElementById('toastCopyFeedback');
    if (toast) {
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 2500);
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    const selectAll = document.getElementById('select_all');
    if (selectAll) {
      selectAll.addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.camp-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
      });
    }
  });
</script>

@endsection