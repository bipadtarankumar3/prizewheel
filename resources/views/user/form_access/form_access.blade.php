@extends('adminLayouts.home')
@section('content')

<!-- FontAwesome 6 CDN for complete icon reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* ==========================================================================
       Atom UI - Form Fields Access Matrix Styles
       ========================================================================== */
    :root {
        --primary-orange: #ff6b00;
        --accent-emerald: #10b981;
        --accent-blue: #3b82f6;
        --accent-purple: #8b5cf6;
        --accent-indigo: #4f46e5;
        --accent-rose: #f43f5e;
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

    /* Field Card */
    .field-toggle-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 22px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .field-toggle-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }

    .field-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    .icon-emerald { background: #ecfdf5; color: #059669; }
    .icon-blue { background: #eff6ff; color: #2563eb; }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-purple { background: #faf5ff; color: #7c3aed; }
    .icon-indigo { background: #eef2ff; color: #4f46e5; }
    .icon-rose { background: #fff1f2; color: #e11d48; }

    .field-title-text {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 4px;
    }
    .field-desc-text {
        font-size: 0.82rem;
        color: var(--slate-500);
        line-height: 1.4;
        margin-bottom: 16px;
    }

    /* Modern iOS Toggle Switch */
    .switch-ios {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }
    .switch-ios input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider-ios {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 34px;
    }
    .slider-ios:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    input:checked + .slider-ios {
        background-color: #10b981;
    }
    input:focus + .slider-ios {
        box-shadow: 0 0 1px #10b981;
    }
    input:checked + .slider-ios:before {
        transform: translateX(24px);
    }

    /* Live Preview Simulator */
    .preview-simulator-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    }

    .phone-mockup-frame {
        max-width: 380px;
        margin: 0 auto;
        background: #ffffff;
        border: 8px solid #0f172a;
        border-radius: 36px;
        box-shadow: 0 16px 36px -8px rgba(15, 23, 42, 0.25);
        overflow: hidden;
    }
    .phone-notch {
        height: 18px;
        background: #0f172a;
        width: 140px;
        margin: 0 auto;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .phone-screen {
        padding: 20px;
        background: #f8fafc;
        min-height: 480px;
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
                    <i class="ti ti-adjustments me-1"></i> Form Fields Configuration &bull; Lead Capture
                </span>
                <h1 class="user-hero-title">
                    Customer Form Fields Access Control
                </h1>
                <p class="user-hero-subtitle">
                    Selectively enable or require specific input fields in the user enquiry dialog shown before spinning the wheel.
                </p>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ URL::to('admin/bike_model') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-motorbike me-1"></i> Choose Option Models
                </a>
                <a href="{{ URL::to('admin/spinner_form_camping_list') }}" class="btn btn-dark btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-users me-1"></i> View Captured Leads
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         FORM ACCESS CONTROL FORM & LIVE PREVIEW
         ======================================================================== -->
    <form method="POST" action="{{ URL::to('admin/form_access_post') }}" id="formAccessSettingsForm">
        @csrf
        <input type="hidden" name="id" @if(isset($FormFields)) value="{{ $FormFields->id }}" @endif>

        <div class="row">
            <!-- Left Side: Toggle Control Grid -->
            <div class="col-lg-8 mb-4">
                <div class="row">

                    <!-- 1. WhatsApp Number -->
                    <div class="col-md-6 mb-4">
                        <div class="field-toggle-card">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="field-icon-box icon-emerald">
                                        <i class="ti ti-brand-whatsapp"></i>
                                    </div>
                                    <label class="switch-ios mb-0">
                                        <input type="checkbox" name="whatsapp_no" id="toggle_whatsapp"
                                               @if(isset($FormFields) && $FormFields->whatsapp_no == 'on') checked @endif>
                                        <span class="slider-ios"></span>
                                    </label>
                                </div>
                                <div class="field-title-text">WhatsApp Number</div>
                                <div class="field-desc-text">
                                    Capture client's WhatsApp contact number to send instant prize codes and promo updates.
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                <span class="badge badge-light border text-muted">Input Type: Tel</span>
                                <span class="font-weight-bold text-success" id="badge_whatsapp_status">
                                    {{ (isset($FormFields) && $FormFields->whatsapp_no == 'on') ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Email Address -->
                    <div class="col-md-6 mb-4">
                        <div class="field-toggle-card">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="field-icon-box icon-blue">
                                        <i class="ti ti-mail"></i>
                                    </div>
                                    <label class="switch-ios mb-0">
                                        <input type="checkbox" name="email" id="toggle_email"
                                               @if(isset($FormFields) && $FormFields->email == 'on') checked @endif>
                                        <span class="slider-ios"></span>
                                    </label>
                                </div>
                                <div class="field-title-text">Customer Email</div>
                                <div class="field-desc-text">
                                    Collect email addresses for CRM subscriber synchronization and automated winner coupons.
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                <span class="badge badge-light border text-muted">Input Type: Email</span>
                                <span class="font-weight-bold text-primary" id="badge_email_status">
                                    {{ (isset($FormFields) && $FormFields->email == 'on') ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Physical Address -->
                    <div class="col-md-6 mb-4">
                        <div class="field-toggle-card">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="field-icon-box icon-orange">
                                        <i class="ti ti-map-pin"></i>
                                    </div>
                                    <label class="switch-ios mb-0">
                                        <input type="checkbox" name="address" id="toggle_address"
                                               @if(isset($FormFields) && $FormFields->address == 'on') checked @endif>
                                        <span class="slider-ios"></span>
                                    </label>
                                </div>
                                <div class="field-title-text">Customer Address</div>
                                <div class="field-desc-text">
                                    Ask for town, district, or street address for physical gift shipping and store proximity routing.
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                <span class="badge badge-light border text-muted">Input Type: Textarea</span>
                                <span class="font-weight-bold text-warning" id="badge_address_status">
                                    {{ (isset($FormFields) && $FormFields->address == 'on') ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Choose Option (Bike/Model) -->
                    <div class="col-md-6 mb-4">
                        <div class="field-toggle-card">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="field-icon-box icon-purple">
                                        <i class="ti ti-motorbike"></i>
                                    </div>
                                    <label class="switch-ios mb-0">
                                        <input type="checkbox" name="choose_option" id="toggle_choose_option"
                                               @if(isset($FormFields) && $FormFields->choose_option == 'on') checked @endif>
                                        <span class="slider-ios"></span>
                                    </label>
                                </div>
                                <div class="field-title-text">Choose Option (Model)</div>
                                <div class="field-desc-text">
                                    Displays a vehicle or product dropdown so the player can declare their product interest.
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                <a href="{{ URL::to('admin/bike_model') }}" class="font-weight-bold text-primary" style="font-size: 0.76rem;">
                                    <i class="ti ti-settings me-1"></i> Manage Catalog
                                </a>
                                <span class="font-weight-bold" style="color: #7c3aed;" id="badge_option_status">
                                    {{ (isset($FormFields) && $FormFields->choose_option == 'on') ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Screenshot / Invoice Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="field-toggle-card">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="field-icon-box icon-indigo">
                                        <i class="ti ti-camera"></i>
                                    </div>
                                    <label class="switch-ios mb-0">
                                        <input type="checkbox" name="screenshot" id="screenshot"
                                               @if(isset($FormFields) && $FormFields->screenshot == 'on') checked @endif>
                                        <span class="slider-ios"></span>
                                    </label>
                                </div>
                                <div class="field-title-text">Screenshot / Bill Proof</div>
                                <div class="field-desc-text">
                                    Display a file upload picker for customer purchasing invoices, store tokens, or transaction receipts.
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                <span class="badge badge-light border text-muted">Input Type: File (JPG/PNG)</span>
                                <span class="font-weight-bold" style="color: #4f46e5;" id="badge_screenshot_status">
                                    {{ (isset($FormFields) && $FormFields->screenshot == 'on') ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Strict Mandatory Screenshot -->
                    <div class="col-md-6 mb-4 reqired_section" @if(isset($FormFields) && $FormFields->screenshot != 'on') style="display: none" @endif>
                        <div class="field-toggle-card" style="border: 2px dashed #f43f5e; background: #fff5f5;">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="field-icon-box icon-rose">
                                        <i class="ti ti-shield-check"></i>
                                    </div>
                                    <label class="switch-ios mb-0">
                                        <input type="checkbox" name="screenshot_required" id="screenshot_required"
                                               @if(isset($FormFields) && $FormFields->screenshot_required == 'on') checked @endif>
                                        <span class="slider-ios" style="background-color: #cbd5e1;"></span>
                                    </label>
                                </div>
                                <div class="field-title-text text-danger">Mandatory Screenshot</div>
                                <div class="field-desc-text text-dark">
                                    Strict Mode: Prevents submission without a receipt upload. Only approved customers can proceed.
                                </div>
                            </div>
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                                <span class="badge badge-danger text-white">Validation: Required</span>
                                <span class="font-weight-bold text-danger" id="badge_mandatory_status">
                                    {{ (isset($FormFields) && $FormFields->screenshot_required == 'on') ? 'Strict ON' : 'Optional' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Toolbar Card -->
                <div class="card p-4 border-0 shadow-sm rounded-20 d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <div class="font-weight-bold text-dark" style="font-size: 1.05rem;">Save Changes</div>
                        <div class="text-muted" style="font-size: 0.8rem;">Changes immediately reflect on your live wheel form.</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success font-weight-bold rounded-pill px-4 py-2 shadow-sm">
                            <i class="ti ti-device-floppy me-1"></i> Save Configuration
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Live Phone Preview Simulator -->
            <div class="col-lg-4 mb-4">
                <div class="preview-simulator-card">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                            <i class="ti ti-device-mobile text-primary me-1"></i> Live Wheel Form Simulator
                        </div>
                        <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 0.7rem;">Real-Time</span>
                    </div>

                    <div class="phone-mockup-frame">
                        <div class="phone-notch"></div>
                        <div class="phone-screen">
                            <div class="text-center mb-3">
                                <div class="badge badge-warning text-dark px-3 py-1 font-weight-bold mb-2">🎁 Spin To Win</div>
                                <h6 class="font-weight-bold text-dark mb-1">Enter Your Details</h6>
                                <p class="text-muted mb-0" style="font-size: 11px;">Fill this quick form to spin the prize wheel!</p>
                            </div>

                            <!-- Permanent fields -->
                            <div class="mb-2">
                                <label class="text-muted font-weight-bold mb-1" style="font-size: 11px;">Full Name *</label>
                                <input type="text" class="form-control form-control-sm bg-white" placeholder="e.g. John Doe" disabled>
                            </div>
                            <div class="mb-2">
                                <label class="text-muted font-weight-bold mb-1" style="font-size: 11px;">Mobile Number *</label>
                                <input type="text" class="form-control form-control-sm bg-white" placeholder="+91 98765 43210" disabled>
                            </div>

                            <!-- Dynamic fields based on toggles -->
                            <div class="mb-2 preview-field" id="sim_whatsapp" style="display: {{ (isset($FormFields) && $FormFields->whatsapp_no == 'on') ? 'block' : 'none' }};">
                                <label class="text-success font-weight-bold mb-1" style="font-size: 11px;">WhatsApp Number</label>
                                <input type="text" class="form-control form-control-sm bg-white border-success" placeholder="+91 WhatsApp Contact" disabled>
                            </div>

                            <div class="mb-2 preview-field" id="sim_email" style="display: {{ (isset($FormFields) && $FormFields->email == 'on') ? 'block' : 'none' }};">
                                <label class="text-primary font-weight-bold mb-1" style="font-size: 11px;">Email Address</label>
                                <input type="text" class="form-control form-control-sm bg-white border-primary" placeholder="user@example.com" disabled>
                            </div>

                            <div class="mb-2 preview-field" id="sim_address" style="display: {{ (isset($FormFields) && $FormFields->address == 'on') ? 'block' : 'none' }};">
                                <label class="text-warning font-weight-bold mb-1" style="font-size: 11px;">Residential Address</label>
                                <textarea class="form-control form-control-sm bg-white" rows="2" placeholder="Street, City, Postal Code" disabled></textarea>
                            </div>

                            <div class="mb-2 preview-field" id="sim_option" style="display: {{ (isset($FormFields) && $FormFields->choose_option == 'on') ? 'block' : 'none' }};">
                                <label class="font-weight-bold mb-1" style="color: #7c3aed; font-size: 11px;">Choose Interested Model</label>
                                <select class="form-control form-control-sm bg-white" disabled>
                                    <option>Select Model / Vehicle...</option>
                                </select>
                            </div>

                            <div class="mb-3 preview-field" id="sim_screenshot" style="display: {{ (isset($FormFields) && $FormFields->screenshot == 'on') ? 'block' : 'none' }};">
                                <label class="font-weight-bold mb-1" style="color: #4f46e5; font-size: 11px;" id="sim_screenshot_label">
                                    Upload Receipt / Bill {{ (isset($FormFields) && $FormFields->screenshot_required == 'on') ? '*' : '' }}
                                </label>
                                <div class="p-2 border border-dashed rounded text-center bg-white" style="font-size: 11px; color: #4f46e5;">
                                    <i class="ti ti-upload"></i> Tap to attach proof
                                </div>
                            </div>

                            <button type="button" class="btn btn-dark btn-block btn-sm rounded-pill font-weight-bold mt-2" disabled>
                                🎯 Continue to Spin Wheel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Screenshot conditional toggle
        $('#screenshot').on('change', function() {
            if (this.checked) {
                $('.reqired_section').slideDown(200);
                $('#sim_screenshot').slideDown(200);
                $('#badge_screenshot_status').text('Active');
            } else {
                $('.reqired_section').slideUp(200);
                $('#sim_screenshot').slideUp(200);
                $('#badge_screenshot_status').text('Disabled');
                $('#screenshot_required').prop('checked', false);
                $('#badge_mandatory_status').text('Optional');
                $('#sim_screenshot_label').text('Upload Receipt / Bill');
            }
        });

        // Screenshot Mandatory toggle
        $('#screenshot_required').on('change', function() {
            if (this.checked) {
                $('#badge_mandatory_status').text('Strict ON');
                $('#sim_screenshot_label').text('Upload Receipt / Bill *');
            } else {
                $('#badge_mandatory_status').text('Optional');
                $('#sim_screenshot_label').text('Upload Receipt / Bill');
            }
        });

        // Real-time phone simulator listeners
        $('#toggle_whatsapp').on('change', function() {
            $('#sim_whatsapp').toggle(this.checked);
            $('#badge_whatsapp_status').text(this.checked ? 'Active' : 'Disabled');
        });

        $('#toggle_email').on('change', function() {
            $('#sim_email').toggle(this.checked);
            $('#badge_email_status').text(this.checked ? 'Active' : 'Disabled');
        });

        $('#toggle_address').on('change', function() {
            $('#sim_address').toggle(this.checked);
            $('#badge_address_status').text(this.checked ? 'Active' : 'Disabled');
        });

        $('#toggle_choose_option').on('change', function() {
            $('#sim_option').toggle(this.checked);
            $('#badge_option_status').text(this.checked ? 'Active' : 'Disabled');
        });
    });
</script>
@endsection