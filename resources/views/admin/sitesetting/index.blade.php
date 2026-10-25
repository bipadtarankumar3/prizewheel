@extends('adminLayouts.home')
@section('content')

<div class="container-fluid">

  <!-- Header & Breadcrumb -->
  <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4 rounded-4 border-0">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.3px;">Store Settings</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ URL::to('admin/dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active text-primary" aria-current="page">Settings</li>
            </ol>
          </nav>
        </div>
        <div class="col-3 text-end d-none d-md-block">
          <div class="d-inline-flex p-3 rounded-circle bg-white shadow-sm text-primary">
            <i class="ti ti-settings fs-7"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.save_settings') }}" enctype="multipart/form-data" id="settingsForm">
    @csrf

    <div class="row">
      <!-- Main Column: Lead Form Submission Timing -->
      <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm mb-4">
          <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <span class="p-2 rounded-3 bg-light-primary text-primary d-inline-flex">
                <i class="ti ti-adjustments-horizontal fs-5"></i>
              </span>
              <div>
                <h5 class="fw-bold mb-0 text-dark">Spin Lead Form Timing</h5>
                <small class="text-muted">Choose when visitors should submit their contact details.</small>
              </div>
            </div>
          </div>

          <div class="card-body p-4">
            <div class="row g-3">

              <!-- Option 1: After Spin -->
              <div class="col-md-6">
                <label class="timing-card-option h-100 d-block cursor-pointer {{ ($spin_form_timing ?? 'after_spin') == 'after_spin' ? 'active' : '' }}" for="timing_after_spin">
                  <input type="radio" name="spin_form_timing" id="timing_after_spin" value="after_spin" class="d-none timing-radio" {{ ($spin_form_timing ?? 'after_spin') == 'after_spin' ? 'checked' : '' }}>
                  <div class="p-4 rounded-4 border h-100 timing-inner transition-all">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="timing-icon rounded-circle d-flex align-items-center justify-content-center p-3">
                        <i class="ti ti-gift fs-5"></i>
                      </div>
                      <span class="badge rounded-pill bg-light-secondary text-secondary px-3 py-1 fw-semibold small">Default Flow</span>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Submit Form After Spin</h6>
                    <p class="text-muted small mb-3">
                      Visitor spins the wheel first. Once they win a prize, the enquiry form appears to claim and submit details.
                    </p>
                    <div class="steps-flow d-flex align-items-center gap-1 flex-wrap small text-muted">
                      <span class="badge bg-light text-dark border">1. Spin Wheel</span>
                      <i class="ti ti-arrow-right text-muted" style="font-size: 11px;"></i>
                      <span class="badge bg-light text-dark border">2. Win Prize</span>
                      <i class="ti ti-arrow-right text-muted" style="font-size: 11px;"></i>
                      <span class="badge bg-light text-dark border">3. Fill Form</span>
                    </div>
                  </div>
                </label>
              </div>

              <!-- Option 2: Before Spin -->
              <div class="col-md-6">
                <label class="timing-card-option h-100 d-block cursor-pointer {{ ($spin_form_timing ?? 'after_spin') == 'before_spin' ? 'active' : '' }}" for="timing_before_spin">
                  <input type="radio" name="spin_form_timing" id="timing_before_spin" value="before_spin" class="d-none timing-radio" {{ ($spin_form_timing ?? 'after_spin') == 'before_spin' ? 'checked' : '' }}>
                  <div class="p-4 rounded-4 border h-100 timing-inner transition-all">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <div class="timing-icon rounded-circle d-flex align-items-center justify-content-center p-3">
                        <i class="ti ti-forms fs-5"></i>
                      </div>
                      <span class="badge rounded-pill bg-light-success text-success px-3 py-1 fw-semibold small">High Lead Capture</span>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Submit Form Before Spin</h6>
                    <p class="text-muted small mb-3">
                      Visitor fills and submits their details before spinning. When they win, clicking <b>Redeem</b> automatically updates their enquiry with the prize.
                    </p>
                    <div class="steps-flow d-flex align-items-center gap-1 flex-wrap small text-muted">
                      <span class="badge bg-light text-dark border">1. Fill Details</span>
                      <i class="ti ti-arrow-right text-muted" style="font-size: 11px;"></i>
                      <span class="badge bg-light text-dark border">2. Spin Wheel</span>
                      <i class="ti ti-arrow-right text-muted" style="font-size: 11px;"></i>
                      <span class="badge bg-light text-dark border">3. Click Redeem</span>
                    </div>
                  </div>
                </label>
              </div>

            </div>

            <!-- Helpful note callout -->
            <div class="alert alert-light-primary rounded-3 border-0 mt-4 mb-0 d-flex align-items-start gap-2.5 p-3">
              <i class="ti ti-info-circle text-primary fs-5 mt-0.5"></i>
              <div class="small text-muted">
                <strong class="text-dark">How "Before Spin" Works:</strong> Visitors are prompted to submit their contact info before the wheel unlocks. Once submitted, the wheel spins and when they click "Redeem", their enquiry record in <b>Spinner Enquiry</b> is updated with the prize won and WhatsApp alert is dispatched.
              </div>
            </div>
          </div>
        </div>

        <!-- Optional Background Audio Setting -->
        <div class="card border-0 rounded-4 shadow-sm mb-4">
          <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <span class="p-2 rounded-3 bg-light-warning text-warning d-inline-flex">
                <i class="ti ti-music fs-5"></i>
              </span>
              <div>
                <h5 class="fw-bold mb-0 text-dark">Wheel Background Music (Optional)</h5>
                <small class="text-muted">Custom audio track for your spinning wheel page.</small>
              </div>
            </div>
          </div>
          <div class="card-body p-4">
            <div class="row align-items-center g-3">
              <div class="col-md-7">
                <label for="music" class="form-label fw-semibold text-dark small mb-1">Upload MP3 Audio</label>
                <input type="file" name="file" class="form-control rounded-3" id="music" accept="audio/mpeg, audio/mp3, audio/wav">
                @php
                  $currentMusic = $settings['background_music'] ?? ($legacy_sitesetting->background_music ?? null);
                @endphp
                @if (!empty($currentMusic))
                  <div class="mt-2 p-2 bg-light rounded-3 d-flex align-items-center gap-2">
                    <audio controls style="height: 32px; width: 100%;">
                      <source src="{{ $currentMusic }}" type="audio/mpeg">
                      Your browser does not support audio.
                    </audio>
                  </div>
                @endif
              </div>
              <div class="col-md-5">
                <label class="form-label fw-semibold text-dark small mb-1">Music Status</label>
                @php
                  $musicStatus = $settings['background_music_status'] ?? ($legacy_sitesetting->background_music_status ?? 'inactive');
                @endphp
                <select name="status" class="form-select rounded-3">
                  <option value="active" {{ $musicStatus == 'active' ? 'selected' : '' }}>Active (Enabled)</option>
                  <option value="inactive" {{ $musicStatus != 'active' ? 'selected' : '' }}>Inactive (Disabled)</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Side Column: Summary & Save Action -->
      <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm mb-4 sticky-top" style="top: 20px;">
          <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3">Save Preferences</h5>
            <p class="text-muted small mb-4">
              Changes applied here will immediately take effect for all active campaigns and visitor spin sessions.
            </p>

            <div class="p-3 rounded-3 bg-light mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2 small">
                <span class="text-muted">Active Timing:</span>
                <span class="fw-bold text-primary" id="selectedTimingSummary">
                  {{ ($spin_form_timing ?? 'after_spin') == 'before_spin' ? 'Submit Form Before Spin' : 'Submit Form After Spin' }}
                </span>
              </div>
              <div class="d-flex justify-content-between align-items-center small">
                <span class="text-muted">Store ID:</span>
                <span class="fw-semibold text-dark">{{ $user->name_url ?? $user->name }}</span>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2.5 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
              <i class="ti ti-device-floppy fs-5"></i>
              <span>Save Settings</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>

<style>
.cursor-pointer {
  cursor: pointer;
}
.transition-all {
  transition: all 0.25s ease-in-out;
}
.timing-inner {
  border: 2px solid #e2e8f0;
  background: #ffffff;
}
.timing-icon {
  background: #f1f5f9;
  color: #475569;
  width: 48px;
  height: 48px;
}
.timing-card-option.active .timing-inner {
  border-color: #0d6efd;
  background: #f8faff;
  box-shadow: 0 8px 24px -4px rgba(13, 110, 253, 0.15);
}
.timing-card-option.active .timing-icon {
  background: #0d6efd;
  color: #ffffff;
}
.timing-card-option:hover .timing-inner {
  border-color: #93c5fd;
  transform: translateY(-2px);
}
</style>

@endsection

@section('js')
<script>
  $(document).ready(function() {
    $('.timing-card-option').on('click', function() {
      $('.timing-card-option').removeClass('active');
      $(this).addClass('active');
      $(this).find('input[type="radio"]').prop('checked', true);

      var selectedVal = $(this).find('input[type="radio"]').val();
      if (selectedVal === 'before_spin') {
        $('#selectedTimingSummary').text('Submit Form Before Spin');
      } else {
        $('#selectedTimingSummary').text('Submit Form After Spin');
      }
    });
  });
</script>
@endsection
