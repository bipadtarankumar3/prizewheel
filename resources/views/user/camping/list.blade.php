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
                  <div class="d-inline-flex align-items-center gap-1 flex-nowrap">
                    {{-- Create Spinner Button: Redirects directly to Spinner Page --}}
                    <a href="{{ url('admin/spinner_list?campaign_id=' . $item->id) }}" 
                       class="btn btn-sm text-white rounded-pill px-3 fw-bold btn-create-spinner d-inline-flex align-items-center justify-content-center" 
                       style="background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%); border: none; box-shadow: 0 2px 8px rgba(255, 107, 0, 0.28); white-space: nowrap; height: 36px;" 
                       title="Create Spinner for {{ $item->campaign_name }}">
                      <i class="ti ti-plus me-1"></i> Create Spinner
                    </a>

                    {{-- View Inquiries Leads Link (Icon + Count only) --}}
                    <a href="{{ url('admin/spinner_form_list/' . $item->id) }}" 
                       class="btn btn-sm btn-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center justify-content-center" 
                       style="white-space: nowrap; height: 36px;" 
                       title="{{ $item->total_joined ?? 0 }} Customer Leads">
                      <i class="ti ti-users me-1"></i> {{ $item->total_joined ?? 0 }}
                    </a>

                    {{-- Edit Campaign --}}
                    <a href="{{ url('admin/edit_camping/' . $item->id) }}" 
                       class="btn btn-sm btn-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center p-0" 
                       style="width: 36px; height: 36px;" 
                       title="Edit Campaign Settings">
                      <i class="ti ti-pencil"></i>
                    </a>

                    {{-- Copy Live Wheel Link --}}
                    <button type="button" 
                            class="btn btn-sm btn-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center p-0" 
                            style="width: 36px; height: 36px;" 
                            onclick="copyStoreUrl('{{ $storeUrl }}')" 
                            title="Copy Live Wheel Link">
                      <i class="ti ti-copy"></i>
                    </button>

                    {{-- Delete Campaign (Checked for Spins Safety) --}}
                    <button type="button" 
                            class="btn btn-sm btn-light text-danger rounded-circle d-inline-flex align-items-center justify-content-center p-0" 
                            style="width: 36px; height: 36px;" 
                            onclick="handleCampaignDelete('{{ $item->id }}', '{{ addslashes($item->campaign_name) }}', {{ (int)($item->slices_count ?? 0) }})" 
                            title="Delete Campaign">
                      <i class="ti ti-trash"></i>
                    </button>
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

<!-- Modal 1: Cannot Delete Campaign (When spins exist) -->
<div class="modal fade" id="cannotDeleteCampModal" tabindex="-1" aria-labelledby="cannotDeleteCampModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-body p-4 text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: #fee2e2; color: #dc2626;">
          <i class="ti ti-alert-triangle" style="font-size: 32px;"></i>
        </div>
        <h4 class="fw-bolder text-dark mb-2" id="cannotDeleteCampModalLabel">Cannot Delete Campaign</h4>
        <p class="text-muted small mb-3">
          The campaign <strong id="blocked_camp_name" class="text-dark"></strong> cannot be deleted because it has <strong id="blocked_spin_count" class="text-danger"></strong> configured.
        </p>
        <div class="p-3 bg-light rounded-3 text-start mb-3 border">
          <div class="d-flex align-items-center gap-2 text-danger small mb-1">
            <i class="ti ti-shield-x fs-5"></i>
            <span class="fw-bold">Data Protection Safety Rule</span>
          </div>
          <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.45;">
            Campaigns with created prize spins cannot be deleted to protect active wheel URLs and prize records. Please delete or reassign its spins first.
          </p>
        </div>
        <div class="d-flex align-items-center justify-content-center gap-2">
          <a href="{{ url('admin/spinner_list') }}" class="btn btn-primary rounded-pill px-3 fw-bold">
            <i class="ti ti-settings me-1"></i> Go to Spinner List
          </a>
          <button type="button" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold" data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal 2: Confirm Delete Campaign (When 0 spins exist) -->
<div class="modal fade" id="confirmDeleteCampModal" tabindex="-1" aria-labelledby="confirmDeleteCampModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 430px;">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-body p-4 text-center">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: #fee2e2; color: #dc2626;">
          <i class="ti ti-trash" style="font-size: 30px;"></i>
        </div>
        <h4 class="fw-bolder text-dark mb-2" id="confirmDeleteCampModalLabel">Delete Campaign?</h4>
        <p class="text-muted small mb-4">
          Are you sure you want to permanently delete <strong id="delete_camp_name" class="text-dark"></strong>? This action cannot be undone.
        </p>
        <div class="d-flex align-items-center justify-content-center gap-2">
          <button type="button" class="btn btn-light rounded-pill px-3 fw-semibold" data-bs-dismiss="modal">
            Cancel
          </button>
          <a href="#" id="delete_camp_confirm_btn" class="btn btn-danger rounded-pill px-4 fw-bold">
            <i class="ti ti-trash me-1"></i> Yes, Delete
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .btn-create-spinner {
    transition: all 0.2s ease;
  }
  .btn-create-spinner:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(255, 107, 0, 0.45) !important;
    color: #ffffff !important;
  }
</style>

<script>

  function handleCampaignDelete(campId, campName, slicesCount) {
    if (slicesCount > 0) {
      document.getElementById('blocked_camp_name').innerText = campName;
      document.getElementById('blocked_spin_count').innerText = slicesCount + ' prize spin' + (slicesCount > 1 ? 's' : '');
      const modal = new bootstrap.Modal(document.getElementById('cannotDeleteCampModal'));
      modal.show();
    } else {
      document.getElementById('delete_camp_name').innerText = campName;
      document.getElementById('delete_camp_confirm_btn').setAttribute('href', "{{ url('admin/delete_camping') }}/" + campId);
      const modal = new bootstrap.Modal(document.getElementById('confirmDeleteCampModal'));
      modal.show();
    }
  }
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