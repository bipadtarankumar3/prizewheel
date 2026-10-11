@extends('adminLayouts.home')
@section('content')

<!-- FontAwesome 6 CDN for complete icon reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* ==========================================================================
       Atom UI - Broadcast Notice Bar Studio Styles
       ========================================================================== */
    :root {
        --primary-orange: #ff6b00;
        --accent-emerald: #10b981;
        --accent-blue: #3b82f6;
        --accent-purple: #8b5cf6;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --slate-200: #e2e8f0;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    .user-manager-container {
        padding-top: 15px;
        padding-bottom: 40px;
    }

    /* Hero Header Banner */
    .user-hero-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    }

    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        border: 1px solid rgba(255, 107, 0, 0.25);
    }

    .user-hero-title {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--slate-900);
        margin: 6px 0 4px 0;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-hero-subtitle {
        color: var(--slate-500);
        font-size: 0.92rem;
        line-height: 1.45;
        margin-bottom: 0;
    }

    /* Live Ticker Preview Banner */
    .live-ticker-preview-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 18px;
        padding: 22px 26px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.2);
    }

    .marquee-preview-box {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 12px 18px;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .marquee-text-flow {
        display: inline-block;
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        color: #fef08a;
        animation: marqueeFlow 18s linear infinite;
    }

    @keyframes marqueeFlow {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    /* Studio Control Card */
    .studio-control-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    }

    .preset-pill-btn {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 9999px;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--slate-700);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .preset-pill-btn:hover {
        background: var(--slate-900);
        color: #ffffff;
        border-color: var(--slate-900);
    }
</style>

<div class="container-fluid user-manager-container">

    <!-- ========================================================================
         HERO HEADER
         ======================================================================== -->
    <div class="user-hero-card">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div>
                <span class="hero-badge-pill">
                    <i class="ti ti-speakerphone me-1"></i> Live Broadcast &bull; Marquee Ticker
                </span>
                <h1 class="user-hero-title">
                    Broadcast Notice Bar Studio
                </h1>
                <p class="user-hero-subtitle">
                    Configure the scrolling promotional notice shown at the top of customer engagement pages and wheel screens.
                </p>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ URL::to('admin/popup_alert') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-bell me-1"></i> Popup Alerts
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         LIVE TICKER SIMULATOR BANNER
         ======================================================================== -->
    <div class="live-ticker-preview-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-warning text-dark font-weight-bold px-2 py-1">
                    <i class="ti ti-broadcast me-1"></i> LIVE SCREEN PREVIEW
                </span>
                <span class="text-white-50" style="font-size: 0.82rem;">How visitors see the notice ticker</span>
            </div>
            <div id="previewStatusBadge">
                @if(isset($notice) && $notice->status == 'active')
                    <span class="badge badge-success px-3 py-1 font-weight-bold">
                        <i class="ti ti-circle-check me-1"></i> Broadcasting
                    </span>
                @else
                    <span class="badge badge-secondary px-3 py-1 font-weight-bold">
                        <i class="ti ti-player-pause me-1"></i> Muted / Inactive
                    </span>
                @endif
            </div>
        </div>

        <div class="marquee-preview-box">
            <div class="marquee-text-flow" id="liveMarqueeText">
                📢 {{ isset($notice) && !empty($notice->notice) ? $notice->notice : 'Welcome to Prize Wheel! Spin today to unlock grand discount vouchers and rewards!' }}
            </div>
        </div>
    </div>

    <!-- ========================================================================
         STUDIO CONTROL CARD
         ======================================================================== -->
    <div class="studio-control-card">
        <form method="POST" action="{{ URL::to('admin/add_notice') }}">
            @csrf
            <input type="hidden" name="id" @if(isset($notice)) value="{{ $notice->id }}" @endif>

            <div class="row">
                <!-- Announcement text -->
                <div class="col-lg-8 mb-4">
                    <label class="font-weight-bold text-dark mb-1" style="font-size: 0.95rem;">
                        Announcement Text / Ticker Message <span class="text-danger">*</span>
                    </label>
                    <p class="text-muted mb-2" style="font-size: 0.8rem;">
                        Keep it engaging and concise. Emojis and special characters are fully supported.
                    </p>

                    <textarea name="notice" id="noticeInput" rows="3" class="form-control" 
                              placeholder="Enter scrolling announcement text..." required
                              style="border-radius: 12px; font-size: 0.95rem; line-height: 1.5;">{{ isset($notice) ? $notice->notice : '' }}</textarea>

                    <!-- Quick Preset Templates -->
                    <div class="d-flex align-items-center flex-wrap gap-2 mt-3">
                        <span class="text-muted font-weight-bold mr-1" style="font-size: 0.76rem;">Quick Templates:</span>
                        <button type="button" class="preset-pill-btn" onclick="applyTemplate('🎁 Festive Mega Spin Festival is Live! Win free bikes and gold vouchers today!')">
                            Festive Mega Spin
                        </button>
                        <button type="button" class="preset-pill-btn" onclick="applyTemplate('⚡ Flash Hour: High Winning Probability unlocked for the next 2 hours only!')">
                            Flash Hour
                        </button>
                        <button type="button" class="preset-pill-btn" onclick="applyTemplate('📢 Upload your purchase bill screenshot to unlock premium VIP wheel spins!')">
                            Receipt Bonus
                        </button>
                    </div>
                </div>

                <!-- Status & Broadcast Controls -->
                <div class="col-lg-4 mb-4">
                    <label class="font-weight-bold text-dark mb-1" style="font-size: 0.95rem;">
                        Broadcast Status <span class="text-danger">*</span>
                    </label>
                    <p class="text-muted mb-2" style="font-size: 0.8rem;">
                        Activate to show immediately or pause the ticker banner.
                    </p>

                    <div class="card p-3 border rounded-15 bg-light mb-3">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="status" id="statusActive" value="active" 
                                   {{ (!isset($notice) || $notice->status == 'active') ? 'checked' : '' }} onchange="updateStatusPreview('active')">
                            <label class="form-check-label font-weight-bold text-success" for="statusActive">
                                <i class="ti ti-circle-check me-1"></i> Active (Broadcasting)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="statusInactive" value="inactive"
                                   {{ (isset($notice) && $notice->status == 'inactive') ? 'checked' : '' }} onchange="updateStatusPreview('inactive')">
                            <label class="form-check-label font-weight-bold text-muted" for="statusInactive">
                                <i class="ti ti-circle-minus me-1"></i> Inactive (Paused)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                <span class="text-muted" style="font-size: 0.82rem;">
                    Updated automatically across all active stores &amp; customer wheels.
                </span>
                <button type="submit" class="btn btn-success font-weight-bold rounded-pill px-4 py-2 shadow-sm">
                    <i class="ti ti-device-floppy me-1"></i> Save &amp; Broadcast Notice
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#noticeInput').on('input', function() {
        var text = $(this).val();
        if (text.trim() === '') {
            $('#liveMarqueeText').text('📢 Enter your announcement text above to see live broadcast preview...');
        } else {
            $('#liveMarqueeText').text('📢 ' + text);
        }
    });

    function applyTemplate(msg) {
        $('#noticeInput').val(msg).trigger('input');
    }

    function updateStatusPreview(status) {
        if (status === 'active') {
            $('#previewStatusBadge').html('<span class="badge badge-success px-3 py-1 font-weight-bold"><i class="ti ti-circle-check me-1"></i> Broadcasting</span>');
        } else {
            $('#previewStatusBadge').html('<span class="badge badge-secondary px-3 py-1 font-weight-bold"><i class="ti ti-player-pause me-1"></i> Muted / Inactive</span>');
        }
    }
</script>
@endsection