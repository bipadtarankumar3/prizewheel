@extends('adminLayouts.home')
@section('content')

<!-- FontAwesome 6 CDN for complete icon reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* ==========================================================================
       Atom UI - Popup Alert Campaign Studio Styles
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

    /* Studio Card */
    .studio-panel-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 26px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
        height: 100%;
    }

    /* Image Dropzone Box */
    .upload-dropzone-box {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }
    .upload-dropzone-box:hover {
        border-color: var(--primary-orange);
        background: #fff7ed;
    }

    /* Modal Simulator Card */
    .modal-simulator-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 26px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    }

    .mockup-popup-box {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        max-width: 380px;
        margin: 0 auto;
        position: relative;
    }

    .mockup-img-container {
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    .mockup-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mockup-close-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.5);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        z-index: 10;
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
                    <i class="ti ti-bell-ringing me-1"></i> Promotional Popups &bull; Lead Magnets
                </span>
                <h1 class="user-hero-title">
                    Modal Alert &amp; Popup Campaign Studio
                </h1>
                <p class="user-hero-subtitle">
                    Configure visual splash modals and flash banners that greet visitors when opening the digital spin wheel.
                </p>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ URL::to('admin/notice') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-speakerphone me-1"></i> Notice Ticker Studio
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         STUDIO WORKSPACE & SIMULATOR
         ======================================================================== -->
    <div class="row">
        <!-- Left: Form Controls -->
        <div class="col-lg-7 mb-4">
            <div class="studio-panel-card">
                <h5 class="font-weight-bold text-dark mb-1">Popup Campaign Settings</h5>
                <p class="text-muted mb-4" style="font-size: 0.85rem;">
                    Design the image and headline displayed in the greeting lightbox modal.
                </p>

                <form method="POST" action="{{ URL::to('admin/add_popup_alert') }}" enctype="multipart/form-data" id="popupAlertForm">
                    @csrf
                    <input type="hidden" name="id" @if(isset($popupalert)) value="{{ $popupalert->id }}" @endif>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="font-weight-bold text-dark mb-1" style="font-size: 0.9rem;">
                            Popup Headline / Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" id="popupTitleInput" class="form-control" 
                               value="{{ isset($popupalert) ? $popupalert->title : '' }}" 
                               placeholder="e.g. Special Holiday Bonus: Win Up to ₹50,000 Today!" required
                               style="border-radius: 12px; font-size: 0.95rem;">
                        <small class="text-muted">Displays prominently above or on the greeting popup card.</small>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="font-weight-bold text-dark mb-1" style="font-size: 0.9rem;">
                            Promotional Banner / Creative Image
                        </label>

                        <div class="upload-dropzone-box" onclick="$('#popup_img_file').click()">
                            <input type="file" name="popup_img" id="popup_img_file" class="d-none" accept="image/*">
                            <div class="mb-2">
                                <i class="ti ti-photo-up" style="font-size: 38px; color: var(--primary-orange);"></i>
                            </div>
                            <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                                Click to upload or replace popup creative
                            </div>
                            <div class="text-muted" style="font-size: 0.78rem;">
                                Recommended: 800x600px or square ratio (PNG, JPG, WebP)
                            </div>
                        </div>

                        @if(isset($popupalert) && !empty($popupalert->popup_img))
                            <div class="d-flex align-items-center gap-2 mt-2 p-2 bg-light rounded-12 border">
                                <img src="{{ $popupalert->popup_img }}" alt="Current Popup Image" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;">
                                <div class="overflow-hidden">
                                    <div class="font-weight-bold text-dark" style="font-size: 0.8rem;">Current Active Creative</div>
                                    <div class="text-muted text-truncate" style="font-size: 0.72rem;">{{ $popupalert->popup_img }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Status Selection -->
                    <div class="mb-4">
                        <label class="font-weight-bold text-dark mb-1" style="font-size: 0.9rem;">
                            Campaign Status <span class="text-danger">*</span>
                        </label>
                        <div class="card p-3 border rounded-15 bg-light">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="status" id="popActive" value="active" 
                                       {{ (!isset($popupalert) || $popupalert->status == 'active') ? 'checked' : '' }} onchange="updateSimStatus('active')">
                                <label class="form-check-label font-weight-bold text-success" for="popActive">
                                    <i class="ti ti-circle-check me-1"></i> Active (Display on wheel load)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="popInactive" value="inactive"
                                       {{ (isset($popupalert) && $popupalert->status == 'inactive') ? 'checked' : '' }} onchange="updateSimStatus('inactive')">
                                <label class="form-check-label font-weight-bold text-muted" for="popInactive">
                                    <i class="ti ti-circle-minus me-1"></i> Inactive (Hide popup)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                        <span class="text-muted" style="font-size: 0.8rem;">Changes publish immediately.</span>
                        <button type="submit" class="btn btn-success font-weight-bold rounded-pill px-4 py-2 shadow-sm">
                            <i class="ti ti-device-floppy me-1"></i> Save Popup Alert
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Live Modal Simulator -->
        <div class="col-lg-5 mb-4">
            <div class="modal-simulator-card">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                        <i class="ti ti-device-mobile text-primary me-1"></i> Live Customer Popup Simulator
                    </div>
                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 0.7rem;">Real-Time</span>
                </div>

                <div class="mockup-popup-box">
                    <div class="mockup-close-btn">&times;</div>
                    <div class="mockup-img-container">
                        @if(isset($popupalert) && !empty($popupalert->popup_img))
                            <img src="{{ $popupalert->popup_img }}" alt="Popup" id="simPopupImage">
                        @else
                            <div id="simImgPlaceholder" class="text-center p-3 text-muted">
                                <i class="ti ti-photo" style="font-size: 48px; opacity: 0.3;"></i>
                                <div class="mt-2 font-weight-bold" style="font-size: 0.8rem;">No Image Uploaded</div>
                            </div>
                            <img src="" alt="Popup" id="simPopupImage" style="display: none;">
                        @endif
                    </div>
                    <div class="p-4 text-center">
                        <div class="badge badge-warning text-dark px-3 py-1 font-weight-bold mb-2">🎉 Exclusive Bonus</div>
                        <h5 class="font-weight-bold text-dark mb-2" id="simPopupTitle">
                            {{ isset($popupalert) && !empty($popupalert->title) ? $popupalert->title : 'Exclusive Prize Wheel Event!' }}
                        </h5>
                        <p class="text-muted mb-3" style="font-size: 0.82rem;">
                            Spin today to unlock instant discount vouchers and guaranteed rewards!
                        </p>
                        <button type="button" class="btn btn-dark btn-block font-weight-bold rounded-pill shadow-sm" disabled style="background: var(--primary-orange); border-color: var(--primary-orange);">
                            🎁 Spin Now To Claim
                        </button>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <span class="badge {{ (!isset($popupalert) || $popupalert->status == 'active') ? 'badge-success' : 'badge-secondary' }} px-3 py-2 font-weight-bold" id="simStatusPill" style="font-size: 0.8rem;">
                        {{ (!isset($popupalert) || $popupalert->status == 'active') ? '🟢 Live on Customer Wheels' : '⏸ Campaign Paused' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#popupTitleInput').on('input', function() {
        var val = $(this).val();
        if (val.trim() === '') {
            $('#simPopupTitle').text('Exclusive Prize Wheel Event!');
        } else {
            $('#simPopupTitle').text(val);
        }
    });

    $('#popup_img_file').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(evt) {
                $('#simPopupImage').attr('src', evt.target.result).show();
                $('#simImgPlaceholder').hide();
            };
            reader.readAsDataURL(file);
        }
    });

    function updateSimStatus(status) {
        if (status === 'active') {
            $('#simStatusPill').removeClass('badge-secondary').addClass('badge-success').text('🟢 Live on Customer Wheels');
        } else {
            $('#simStatusPill').removeClass('badge-success').addClass('badge-secondary').text('⏸ Campaign Paused');
        }
    }
</script>
@endsection