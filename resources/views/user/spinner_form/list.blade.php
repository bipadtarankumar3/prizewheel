@extends('adminLayouts.home')
@section('content')

<!-- FontAwesome 6 CDN for complete icon reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* ==========================================================================
       Atom UI - Spinner Enquiry Campaigns (Card-Only Modern View)
       ========================================================================== */
    :root {
        --primary-orange: #ff6b00;
        --primary-orange-glow: rgba(255, 107, 0, 0.25);
        --accent-emerald: #10b981;
        --accent-blue: #3b82f6;
        --accent-indigo: #4f46e5;
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
        position: relative;
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
    }
    .badge-pill-orange {
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
        flex-wrap: wrap;
    }

    .user-hero-subtitle {
        color: var(--slate-500);
        font-size: 0.92rem;
        line-height: 1.45;
        margin-bottom: 0;
    }

    /* Top 5 KPI Stat Widget Cards */
    .user-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 20px;
        height: 100%;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
        position: relative;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .user-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -4px rgba(15, 23, 42, 0.08);
    }
    .user-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #e2e8f0;
    }
    .stat-orange::before { background: linear-gradient(90deg, #ff6b00, #ea580c); }
    .stat-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .stat-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
    .stat-indigo::before { background: linear-gradient(90deg, #4f46e5, #4338ca); }

    .stat-bubble-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-bubble-icon i {
        font-size: 24px;
        line-height: 1;
    }
    .bubble-orange { background: #fff7ed; color: #ea580c; }
    .bubble-emerald { background: #ecfdf5; color: #059669; }
    .bubble-blue { background: #eff6ff; color: #2563eb; }
    .bubble-purple { background: #faf5ff; color: #7c3aed; }
    .bubble-indigo { background: #eef2ff; color: #4f46e5; }

    .stat-val-num {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--slate-900);
        line-height: 1.1;
        margin-top: 10px;
        margin-bottom: 3px;
    }
    .stat-val-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin: 0;
    }

    /* Filter & Search Toolbar */
    .filter-panel-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
    }

    .preset-filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--slate-700);
        background: #f8fafc;
        border: 1.5px solid #cbd5e1;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .preset-filter-chip:hover, .preset-filter-chip.active-chip {
        background: var(--slate-900);
        color: #ffffff !important;
        border-color: var(--slate-900);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }

    /* --------------------------------------------------------------------------
       CARD GRID LAYOUT
       -------------------------------------------------------------------------- */
    .campaign-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 22px;
        margin-bottom: 24px;
    }

    .campaign-lead-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
        box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    }
    .campaign-lead-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.09);
        border-color: #cbd5e1;
    }

    .card-top-strip {
        padding: 16px 20px 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
    }

    .card-body-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .campaign-name-heading {
        font-size: 1.18rem;
        font-weight: 800;
        color: var(--slate-900);
        line-height: 1.3;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .campaign-name-heading a {
        color: inherit;
        text-decoration: none;
    }
    .campaign-name-heading a:hover {
        color: var(--primary-orange);
    }

    .campaign-sub-slogan {
        font-size: 0.85rem;
        color: var(--slate-500);
        margin-bottom: 16px;
        line-height: 1.4;
    }

    /* Store Info Strip on Card */
    .card-store-strip {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 12px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .store-mini-avatar {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #475569;
        font-size: 0.85rem;
        overflow: hidden;
        flex-shrink: 0;
    }
    .store-mini-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Lead Progress Widget */
    .lead-progress-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }
    .progress-track-custom {
        height: 8px;
        background: #e2e8f0;
        border-radius: 9999px;
        overflow: hidden;
        margin: 8px 0;
    }
    .progress-fill-custom {
        height: 100%;
        background: linear-gradient(90deg, #ff6b00, #10b981);
        border-radius: 9999px;
        transition: width 0.6s ease;
    }

    /* Pill spec badges */
    .spec-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        background: #f1f5f9;
        color: var(--slate-700);
        border: 1px solid #e2e8f0;
    }

    /* Card Footer & Action Buttons */
    .card-actions-strip {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-view-leads {
        flex: 1;
        background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 0.88rem;
        border-radius: 10px;
        padding: 10px 14px;
        text-align: center;
        border: none;
        box-shadow: 0 3px 10px rgba(255, 107, 0, 0.25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-view-leads:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255, 107, 0, 0.35);
        color: #ffffff !important;
    }

    .btn-card-action {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: var(--slate-700);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.92rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-card-action:hover {
        background: var(--slate-900);
        color: #ffffff;
        border-color: var(--slate-900);
    }

    /* Pulse Status Badges */
    .status-pulse-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }
    .pulse-active {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .pulse-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulseAnimation 1.6s infinite;
    }
    .pulse-expired {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
    }
    .pulse-dot-gray {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #94a3b8;
    }

    @keyframes pulseAnimation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Quick Specs Modal Styling */
    .atom-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 18px 24px;
    }
    .modal-spec-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
    }
</style>

<div class="container-fluid user-manager-container">

    <!-- ========================================================================
         HERO HEADER
         ======================================================================== -->
    <div class="user-hero-card">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div>
                <span class="hero-badge-pill badge-pill-orange">
                    <i class="ti ti-speakerphone me-1"></i> Spinner Campaigns &amp; Enquiry Telemetry
                </span>
                <h1 class="user-hero-title">
                    Campaign Enquiry Tracker
                    <span class="badge badge-light border text-muted ml-2" style="font-size: 0.78rem; font-weight: 600;">
                        {{ $totalCampaigns }} {{ Str::plural('Campaign', $totalCampaigns) }}
                    </span>
                </h1>
                <p class="user-hero-subtitle">
                    Real-time lead capture volume, form fill conversion, quota consumption, and customer engagement across wheel campaigns.
                </p>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ URL::to('admin/expired_camping_list') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-archive me-1"></i> Expired Archive
                </a>
                <a href="{{ URL::to('admin/camping_list') }}" class="btn btn-dark btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-settings me-1"></i> Manage Wheels
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         TOP 5 MODERN KPI METRIC COUNTS (With Native Tabler & FA Icons)
         ======================================================================== -->
    <div class="row mb-4">
        <!-- 1. Total Campaigns -->
        <div class="col-xl col-md-4 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-orange">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Total Campaigns</span>
                    <div class="stat-bubble-icon bubble-orange">
                        <i class="ti ti-layout-grid"></i>
                    </div>
                </div>
                <div class="stat-val-num">{{ $totalCampaigns }}</div>
                <div class="d-flex align-items-center gap-1 mt-1 font-weight-bold" style="font-size: 0.76rem;">
                    <span class="text-success"><i class="fas fa-circle" style="font-size: 7px;"></i> {{ $activeCampaignsCount }} Live</span>
                    <span class="text-muted ml-1">&bull; {{ $expiredCampaignsCount }} Ended</span>
                </div>
            </div>
        </div>

        <!-- 2. Captured Leads -->
        <div class="col-xl col-md-4 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-emerald">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Captured Leads</span>
                    <div class="stat-bubble-icon bubble-emerald">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
                <div class="stat-val-num text-success">{{ number_format($totalLeads) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">
                    Customer form submissions
                </div>
            </div>
        </div>

        <!-- 3. Customer Proofs / Screenshots -->
        <div class="col-xl col-md-4 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-blue">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Verified Proofs</span>
                    <div class="stat-bubble-icon bubble-blue">
                        <i class="ti ti-receipt"></i>
                    </div>
                </div>
                <div class="stat-val-num text-primary">{{ number_format($totalScreenshots) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">
                    Bill &amp; receipt uploads
                </div>
            </div>
        </div>

        <!-- 4. Prizes Claimed -->
        <div class="col-xl col-md-6 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-purple">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Prizes Unlocked</span>
                    <div class="stat-bubble-icon bubble-purple">
                        <i class="ti ti-trophy"></i>
                    </div>
                </div>
                <div class="stat-val-num" style="color: #7c3aed;">{{ number_format($totalPrizesAwarded) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">
                    Awarded wheel slices
                </div>
            </div>
        </div>

        <!-- 5. Form Quota Capacity -->
        <div class="col-xl col-md-6 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-indigo">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Total Spin Pool</span>
                    <div class="stat-bubble-icon bubble-indigo">
                        <i class="ti ti-disc"></i>
                    </div>
                </div>
                <div class="stat-val-num" style="color: #4f46e5;">{{ number_format($totalSpinsAllocated) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">
                    Form quota: {{ number_format($totalQuota) }}
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         FILTER & SEARCH TOOLBAR (Card-Wise Controls)
         ======================================================================== -->
    <div class="filter-panel-card">
        <form action="{{ URL::to('admin/spinner_form_camping_list') }}" method="POST" id="filterForm">
            @csrf
            
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
                <!-- Status Preset Chips -->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="font-weight-bold text-muted mr-1" style="font-size: 0.8rem; text-transform: uppercase;">
                        Status:
                    </span>
                    <a href="javascript:void(0)" onclick="setStatusFilter('all')" 
                       class="preset-filter-chip {{ ($status_filter ?? 'all') == 'all' ? 'active-chip' : '' }}">
                        <i class="ti ti-list"></i> All ({{ $totalCampaigns }})
                    </a>
                    <a href="javascript:void(0)" onclick="setStatusFilter('active')" 
                       class="preset-filter-chip {{ ($status_filter ?? '') == 'active' ? 'active-chip' : '' }}">
                        <span class="pulse-dot" style="display: inline-block;"></span> Active Live ({{ $activeCampaignsCount }})
                    </a>
                    <a href="javascript:void(0)" onclick="setStatusFilter('expired')" 
                       class="preset-filter-chip {{ ($status_filter ?? '') == 'expired' ? 'active-chip' : '' }}">
                        <i class="ti ti-history text-muted"></i> Concluded ({{ $expiredCampaignsCount }})
                    </a>
                    <input type="hidden" name="status_filter" id="status_filter_input" value="{{ $status_filter ?? 'all' }}">
                </div>

                <!-- PDF Bulk Download Action -->
                <div>
                    <button type="button" onclick="submitPdfExport()" class="btn btn-outline-danger btn-sm font-weight-bold rounded-pill px-3">
                        <i class="ti ti-file-text me-1"></i> Download PDF
                    </button>
                </div>
            </div>

            <!-- Filter Inputs Grid -->
            <div class="row align-items-end pt-2 border-top">
                <!-- Search text -->
                <div class="col-md-3 mb-2">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">Search Campaign / Store</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="ti ti-search text-muted"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0" 
                               placeholder="Name, title, email, phone..." value="{{ $search ?? '' }}">
                    </div>
                </div>

                <!-- Start Date -->
                <div class="col-md-2 col-sm-6 mb-2">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">From Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" 
                           value="{{ !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : '' }}">
                </div>

                <!-- End Date -->
                <div class="col-md-2 col-sm-6 mb-2">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">To Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" 
                           value="{{ !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : '' }}">
                </div>

                <!-- Store Filter (Super Admin) -->
                @if(Auth::user()->type == 'admin' && isset($allStores) && $allStores->count() > 0)
                <div class="col-md-3 mb-2">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">Filter By Store</label>
                    <select name="store_id" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">-- All Registered Stores ({{ $allStores->count() }}) --</option>
                        @foreach($allStores as $st)
                            <option value="{{ $st->id }}" {{ ($store_id ?? '') == $st->id ? 'selected' : '' }}>
                                {{ $st->name }} ({{ $st->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="col-md-3 mb-2"></div>
                @endif

                <!-- Actions -->
                <div class="col-md-2 mb-2 text-right">
                    <button type="submit" class="btn btn-dark btn-sm font-weight-bold px-3">
                        <i class="ti ti-filter me-1"></i> Apply
                    </button>
                    <a href="{{ URL::to('admin/spinner_form_camping_list') }}" class="btn btn-outline-secondary btn-sm ml-1" title="Reset Filters">
                        <i class="ti ti-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk PDF Form wrapper for card checkboxes -->
    <form action="{{ URL::to('admin/downloadFormCampingPdf') }}" method="POST" id="pdfBulkForm">
        @csrf

        <!-- ====================================================================
             CARD GRID VIEW ONLY
             ==================================================================== -->
        @if($camping->count() > 0)
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="select_all_cards">
                    <label class="custom-control-label font-weight-bold text-dark" for="select_all_cards" style="font-size: 0.85rem; cursor: pointer;">
                        Select All Campaigns for PDF Export
                    </label>
                </div>
                <span class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                    Showing {{ $camping->count() }} of {{ $totalCampaigns }} {{ Str::plural('card', $camping->count()) }}
                </span>
            </div>

            <div class="campaign-grid-container">
                @foreach($camping as $key => $item)
                    @php
                        $today = date('Y-m-d');
                        $isActive = ($item->status == 'active' && $item->end_date >= $today);
                        $leadsCount = $item->spinner_forms_count ?? ($item->form_submitted ?? 0);
                        $quota = max(1, intval($item->total_form));
                        $percent = min(100, round(($leadsCount / $quota) * 100));
                        
                        // Runtime duration calculation
                        $startTs = strtotime($item->start_date);
                        $endTs = strtotime($item->end_date);
                        $nowTs = time();
                        $daysRemaining = round(($endTs - $nowTs) / (60 * 60 * 24));
                    @endphp

                    <div class="campaign-lead-card">
                        <!-- Card Top Strip -->
                        <div class="card-top-strip">
                            <div class="d-flex align-items-center gap-2">
                                <input type="checkbox" name="checkbox[]" class="checkbox campaign-chk" value="{{ $item->id }}" title="Select for PDF">
                                <span class="badge badge-light border text-muted font-weight-bold" style="font-size: 0.74rem;">
                                    #{{ $item->id }}
                                </span>
                            </div>

                            <div>
                                @if($isActive)
                                    <span class="status-pulse-badge pulse-active" title="Wheel is live and accepting submissions">
                                        <span class="pulse-dot"></span> Active Live
                                    </span>
                                @else
                                    <span class="status-pulse-badge pulse-expired" title="Campaign concluded or set to inactive">
                                        <span class="pulse-dot-gray"></span> Concluded
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body-content">
                            <!-- Campaign Title -->
                            <h3 class="campaign-name-heading">
                                <a href="{{ URL::to('admin/spinner_form_list/'.$item->id) }}" title="View Enquiries & Leads">
                                    {{ $item->campaign_name ?? 'Untitled Campaign' }}
                                </a>
                            </h3>

                            <div class="campaign-sub-slogan">
                                @if(!empty($item->title))
                                    <span class="font-weight-bold text-dark">{{ $item->title }}</span>
                                @endif
                                @if(!empty($item->sub_title))
                                    <span class="text-muted ml-1">&bull; {{ Str::limit($item->sub_title, 55) }}</span>
                                @endif
                            </div>

                            <!-- Store Context Strip -->
                            @if(isset($item->user))
                                <div class="card-store-strip">
                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                        <div class="store-mini-avatar">
                                            @if(!empty($item->user->logo))
                                                <img src="{{ $item->user->logo }}" alt="{{ $item->user->name }}">
                                            @else
                                                {{ strtoupper(substr($item->user->name ?? 'S', 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="font-weight-bold text-dark text-truncate" style="font-size: 0.82rem;">
                                                {{ $item->user->name }}
                                            </div>
                                            <div class="text-muted text-truncate" style="font-size: 0.72rem;">
                                                {{ $item->user->email }}
                                            </div>
                                        </div>
                                    </div>

                                    @if(Auth::user()->type == 'admin')
                                        <a href="{{ URL::to('admin/user/login_as_user/'.$item->user->id) }}" 
                                           class="btn btn-outline-primary btn-sm py-1 px-2 font-weight-bold" 
                                           style="font-size: 0.72rem; border-radius: 6px;"
                                           title="Login directly into this store's portal" target="_blank">
                                            <i class="ti ti-login"></i> Store
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Lead Telemetry & Quota Progress Box -->
                            <div class="lead-progress-box">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="font-weight-bold text-muted" style="font-size: 0.75rem; text-transform: uppercase;">
                                        Captured Leads / Enquiries
                                    </span>
                                    <span class="font-weight-bold text-dark" style="font-size: 0.82rem;">
                                        {{ $percent }}% Quota
                                    </span>
                                </div>

                                <div class="d-flex align-items-baseline gap-2">
                                    <span class="font-weight-bold text-dark" style="font-size: 1.55rem; line-height: 1;">
                                        {{ number_format($leadsCount) }}
                                    </span>
                                    <span class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                        / {{ number_format($item->total_form) }} Quota Target
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="progress-track-custom">
                                    <div class="progress-fill-custom" style="width: {{ $percent }}%;"></div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.72rem;">
                                    <span><i class="ti ti-clock me-1"></i> Form speed: {{ $item->spinner_time ?? 10 }}s</span>
                                    <span>Spins pool: {{ number_format($item->number_of_total_spinn ?? 0) }}</span>
                                </div>
                            </div>

                            <!-- Campaign Timeline & Attributes -->
                            <div class="d-flex align-items-center justify-content-between mb-3 text-muted" style="font-size: 0.78rem;">
                                <div>
                                    <i class="ti ti-calendar text-primary me-1"></i>
                                    <span class="font-weight-bold text-dark">{{ date('d M Y', strtotime($item->start_date)) }}</span>
                                    &rarr;
                                    <span class="font-weight-bold text-dark">{{ date('d M Y', strtotime($item->end_date)) }}</span>
                                </div>
                                @if($isActive && $daysRemaining >= 0)
                                    <span class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 0.7rem;">
                                        {{ $daysRemaining }}d left
                                    </span>
                                @elseif(!$isActive)
                                    <span class="badge badge-light border text-muted px-2 py-1 font-weight-bold" style="font-size: 0.7rem;">
                                        Ended
                                    </span>
                                @endif
                            </div>

                            <!-- Spec Pills -->
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="spec-pill" title="Number of slices configured on wheel">
                                    <i class="ti ti-chart-pie text-warning me-1"></i> {{ $item->spinners_count ?? 0 }} Slices
                                </span>
                                <span class="spec-pill" title="Email dispatch status for leads">
                                    @if(($item->mail_send ?? 'NO') == 'YES')
                                        <i class="ti ti-mail-check text-success me-1"></i> Alerts ON
                                    @else
                                        <i class="ti ti-mail text-muted me-1"></i> Alerts OFF
                                    @endif
                                </span>
                                @if(!empty($item->title_status) && $item->title_status == 'on')
                                    <span class="spec-pill text-info" title="Banner Title Visibility">
                                        <i class="ti ti-heading me-1"></i> Banner Title
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Actions Strip -->
                        <div class="card-actions-strip">
                            <a href="{{ URL::to('admin/spinner_form_list/'.$item->id) }}" class="btn-view-leads">
                                <i class="ti ti-users"></i> View Leads ({{ $leadsCount }})
                            </a>

                            <button type="button" class="btn-card-action" data-toggle="modal" data-target="#campaignModal_{{ $item->id }}" title="Quick Campaign Specs & Details">
                                <i class="ti ti-info-circle"></i>
                            </button>

                            @if(isset($item->user) && !empty($item->user->name_url))
                                <a href="{{ URL::to('wheel/'.$item->user->name_url) }}" target="_blank" class="btn-card-action" title="Preview Wheel Frontend">
                                    <i class="ti ti-external-link"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card text-center p-5 border-0 shadow-sm" style="border-radius: 20px;">
                <div class="my-4">
                    <i class="ti ti-speakerphone text-muted" style="font-size: 50px; opacity: 0.3;"></i>
                </div>
                <h4 class="font-weight-bold text-dark">No Enquiry Campaigns Found</h4>
                <p class="text-muted">No campaigns matched your current search filters or date range.</p>
                <div>
                    <a href="{{ URL::to('admin/spinner_form_camping_list') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">
                        Reset Filters
                    </a>
                </div>
            </div>
        @endif
    </form>
</div>

<!-- ============================================================================
     MODALS SECTION: Rendered outside containers to prevent DOM nesting bugs
     ============================================================================ -->
@foreach($camping as $item)
    <div class="modal fade" id="campaignModal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel_{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
                <div class="atom-modal-header d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge badge-warning text-dark font-weight-bold mr-2">ID #{{ $item->id }}</span>
                        <span class="font-weight-bold" style="font-size: 1.05rem;">{{ $item->campaign_name }}</span>
                    </div>
                    <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="modal-spec-row">
                        <span class="text-muted">Campaign Title:</span>
                        <span class="font-weight-bold text-dark">{{ $item->title ?? 'None' }}</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Sub-Title / Slogan:</span>
                        <span class="font-weight-bold text-dark">{{ $item->sub_title ?? 'None' }}</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Store Owner:</span>
                        <span class="font-weight-bold text-dark">{{ $item->user->name ?? 'N/A' }} ({{ $item->user->email ?? '' }})</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Campaign Duration:</span>
                        <span class="font-weight-bold text-dark">{{ date('d M Y', strtotime($item->start_date)) }} - {{ date('d M Y', strtotime($item->end_date)) }}</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Current Status:</span>
                        <span class="badge {{ $item->status == 'active' ? 'badge-success' : 'badge-secondary' }} px-2 py-1">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Leads Captured:</span>
                        <span class="font-weight-bold text-success">{{ $item->spinner_forms_count ?? $item->form_submitted }} Forms</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Target Form Quota:</span>
                        <span class="font-weight-bold text-dark">{{ $item->total_form }} Max</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Slices Configured:</span>
                        <span class="font-weight-bold text-primary">{{ $item->spinners_count ?? 0 }} Wheel Slices</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Wheel Spin Speed:</span>
                        <span class="font-weight-bold text-dark">{{ $item->spinner_time ?? 10 }} Seconds</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Lead Email Alerts:</span>
                        <span class="font-weight-bold text-dark">{{ $item->mail_send ?? 'NO' }}</span>
                    </div>
                    <div class="modal-spec-row">
                        <span class="text-muted">Total Spin Capacity:</span>
                        <span class="font-weight-bold text-dark">{{ number_format($item->number_of_total_spinn ?? 0) }} Spins</span>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 d-flex justify-content-between p-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" data-dismiss="modal">Close</button>
                    <a href="{{ URL::to('admin/spinner_form_list/'.$item->id) }}" class="btn btn-warning btn-sm font-weight-bold rounded-pill px-3">
                        <i class="ti ti-eye me-1"></i> View All Captured Leads
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Handle Select All Checkbox for PDF export across all cards
        $('#select_all_cards').on('change', function() {
            var isChecked = this.checked;
            $('.campaign-chk').prop('checked', isChecked);
        });

        // Update Select All state when individual card checkboxes change
        $('.campaign-chk').on('change', function() {
            var allChecked = $('.campaign-chk').length > 0 && $('.campaign-chk:checked').length === $('.campaign-chk').length;
            $('#select_all_cards').prop('checked', allChecked);
        });
    });

    // Set status filter and submit form
    function setStatusFilter(status) {
        $('#status_filter_input').val(status);
        $('#filterForm').submit();
    }

    // Submit bulk PDF export with selected checkboxes
    function submitPdfExport() {
        if ($('.campaign-chk:checked').length === 0) {
            // Select all by default if none checked
            $('.campaign-chk').prop('checked', true);
        }
        $('#pdfBulkForm').submit();
    }
</script>
@endsection