@extends('adminLayouts.home')
@section('content')

@php
  $storeUrl = str_replace('/public', '', url('u/' . (Auth::user()->name_url ?: Auth::user()->id)));
@endphp

<style>
    /* Modern Dashboard Styling for Spinner & Campaign Manager */
    :root {
        --primary-orange: #ff6b00;
        --primary-orange-glow: rgba(255, 107, 0, 0.25);
        --accent-emerald: #10b981;
        --accent-emerald-glow: rgba(16, 185, 129, 0.2);
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    /* Page container spacing to clear fixed navbar (72px) */
    .spinner-page-container {
        padding-top: 96px !important;
        padding-bottom: 40px !important;
    }
    @media (max-width: 991.98px) {
        .spinner-page-container {
            padding-top: 86px !important;
            padding-left: 14px !important;
            padding-right: 14px !important;
        }
    }

    .page-hero-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px 28px;
        margin-top: 4px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        position: relative;
        z-index: 5;
    }

    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    .hero-badge-orange {
        background: rgba(255, 107, 0, 0.1);
        color: #ea580c;
        border: 1px solid rgba(255, 107, 0, 0.2);
    }
    .hero-badge-indigo {
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.2);
    }

    .hero-title {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--slate-900);
        margin: 6px 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.02em;
    }

    .hero-subtitle {
        color: var(--slate-500);
        font-size: 0.92rem;
        line-height: 1.45;
        margin-bottom: 0;
    }

    .btn-hero-add-spinner {
        background: linear-gradient(135deg, var(--primary-orange), #ea580c);
        color: #ffffff !important;
        border: none;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 10px 22px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px -2px rgba(255, 107, 0, 0.45);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .btn-hero-add-spinner:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px -3px rgba(255, 107, 0, 0.6);
        color: #ffffff !important;
    }

    .btn-hero-launch-wheel {
        background: #ffffff;
        color: #0f172a !important;
        border: 1.5px solid #cbd5e1;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 9px 20px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }
    .btn-hero-launch-wheel:hover {
        background: #0f172a;
        color: #ffffff !important;
        border-color: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -3px rgba(15, 23, 42, 0.25);
    }

    /* Summary Metric Cards */
    .metric-widget-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px 22px;
        height: 100%;
        box-shadow: 0 4px 15px -2px rgba(15, 23, 42, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .metric-widget-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -4px rgba(15, 23, 42, 0.08);
    }
    .metric-widget-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #e2e8f0;
    }
    .widget-active::before { background: linear-gradient(90deg, #10b981, #059669); }
    .widget-orange::before { background: linear-gradient(90deg, #ff6b00, #ea580c); }
    .widget-blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .widget-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .widget-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
    }
    .icon-emerald { background: #ecfdf5; color: #059669; }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-blue { background: #eff6ff; color: #2563eb; }
    .icon-purple { background: #faf5ff; color: #7c3aed; }

    .widget-num {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--slate-900);
        line-height: 1.1;
        margin-bottom: 4px;
    }
    .widget-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* Campaign Cards Grid */
    .campaign-deck-container {
        margin-bottom: 30px;
    }

    .section-ribbon-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .section-ribbon-title {
        font-size: 1.22rem;
        font-weight: 700;
        color: var(--slate-900);
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .camp-card {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
    }
    .camp-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.1);
        border-color: #cbd5e1;
    }
    /* Active Campaign Card Style - Distinct Electric Indigo / Royal Violet */
    .camp-card.is-active-campaign {
        border-color: #4f46e5 !important;
        background: linear-gradient(180deg, #ffffff 0%, #f5f3ff 100%) !important;
        box-shadow: 0 10px 30px -4px rgba(79, 70, 229, 0.22) !important;
    }
    .camp-card.is-active-campaign::after {
        content: 'ACTIVE LIVE';
        position: absolute;
        top: -11px;
        right: 18px;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
        color: #ffffff !important;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.08em;
        padding: 3px 12px;
        border-radius: 999px;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.45) !important;
    }

    .camp-card.is-selected-filter {
        border-color: var(--primary-orange) !important;
        box-shadow: 0 0 0 3px var(--primary-orange-glow), 0 10px 25px -4px rgba(255, 107, 0, 0.18) !important;
    }

    .camp-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .camp-title-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--slate-900);
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .camp-subtitle-text {
        font-size: 0.82rem;
        color: var(--slate-500);
        margin-bottom: 0;
    }

    /* Single Active Switch Pill */
    .single-active-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 999px;
        padding: 5px 14px;
        cursor: pointer;
        transition: all 0.25s ease;
        user-select: none;
    }
    .single-active-pill:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .single-active-pill.pill-active {
        background: #eef2ff !important;
        border-color: #6366f1 !important;
        color: #4338ca !important;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
    }
    .single-active-pill input[type="radio"] {
        accent-color: #4f46e5;
        width: 16px;
        height: 16px;
        margin: 0;
        cursor: pointer;
    }
    .single-active-pill span {
        font-size: 0.76rem;
        font-weight: 800;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .single-active-pill.pill-active span {
        color: #4338ca !important;
    }

    /* Campaign Mini Stats Strip */
    .camp-metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px 12px;
        margin: 12px 0 14px 0;
        text-align: center;
    }
    .camp-metric-item {
        display: flex;
        flex-direction: column;
    }
    .camp-metric-val {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--slate-900);
    }
    .camp-metric-lbl {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--slate-500);
        text-transform: uppercase;
    }

    .camp-dates-strip {
        font-size: 0.78rem;
        color: var(--slate-600);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 14px;
    }

    .camp-card-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }
    .btn-camp-view {
        flex: 1;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        color: var(--slate-700);
        font-size: 0.84rem;
        font-weight: 700;
        padding: 8px 12px;
        border-radius: 12px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-camp-view:hover, .btn-camp-view.is-viewing {
        background: var(--slate-900);
        color: #ffffff;
        border-color: var(--slate-900);
    }
    .btn-camp-add {
        background: linear-gradient(135deg, var(--primary-orange), #ea580c);
        color: #ffffff !important;
        border: none;
        font-size: 0.84rem;
        font-weight: 700;
        padding: 8px 14px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 12px -2px rgba(255, 107, 0, 0.35);
        transition: all 0.2s ease;
    }
    .btn-camp-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px -2px rgba(255, 107, 0, 0.45);
    }

    /* Spinners Table Card */
    .spinner-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }
    .table-toolbar-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    /* Live Color Chip */
    .color-chip-preview {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 3px 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }
    .color-swatch-box {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    }

    /* Pulsing Green Indicator */
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseRing 1.8s infinite;
    }
    @keyframes pulseRing {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 7px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Pagination Bar */
    .camp-pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 18px;
    }
    .camp-pagination-wrapper .pagination {
        margin: 0;
        gap: 6px;
    }
    .camp-pagination-wrapper .page-item .page-link {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        color: var(--slate-700);
        font-weight: 600;
        padding: 6px 14px;
    }
    .camp-pagination-wrapper .page-item.active .page-link {
        background-color: var(--primary-orange);
        border-color: var(--primary-orange);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(255, 107, 0, 0.3);
    }
</style>

<div class="container-fluid spinner-page-container">

    <!-- Hero Header with Primary Actions -->
    <div class="page-hero-header">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="hero-badge-pill hero-badge-orange">
                        <i class="fas fa-dharmachakra"></i> Wheel Segments
                    </span>
                    <span class="hero-badge-pill hero-badge-indigo">
                        <i class="fas fa-layer-group"></i> Campaign Control
                    </span>
                </div>
                <h2 class="hero-title">
                    <i class="fas fa-dharmachakra text-warning"></i>
                    <span>Spinner &amp; Wheel Management</span>
                </h2>
                <p class="hero-subtitle">
                    Organize wheel prize slices by campaign. Switch your single active campaign on-the-fly and monitor prize distribution.
                </p>
            </div>
            <div class="col-lg-5 col-md-12 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                    <button type="button" onclick="add_spinner_btn()" class="btn-hero-add-spinner" id="hero_add_spinner_btn">
                        <i class="fas fa-plus"></i> Add New Spinner
                    </button>
                    <a href="{{ $storeUrl }}" target="_blank" class="btn-hero-launch-wheel" title="Open live customer wheel">
                        <i class="fas fa-external-link-alt"></i> Launch Wheel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Metrics Dashboard Strip -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Campaigns -->
        <div class="col-xl-3 col-sm-6">
            <div class="metric-widget-card widget-blue">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="widget-num">{{ $totalCampaignsCount }}</div>
                        <div class="widget-label">Total Campaigns</div>
                    </div>
                    <div class="widget-icon-box icon-blue">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
                <div class="mt-2 text-muted small">
                    <span class="badge bg-light-primary text-primary fw-bold">{{ $activeCampaignsCount }} Active</span>
                    <span class="ms-1">&bull; {{ $totalCampaignsCount - $activeCampaignsCount }} Inactive</span>
                </div>
            </div>
        </div>

        <!-- 2. Currently Active Campaign -->
        <div class="col-xl-3 col-sm-6">
            <div class="metric-widget-card widget-active">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="widget-num text-success fs-5 text-truncate" style="max-width: 170px;" title="{{ $activeCampaign->campaign_name ?? 'None' }}">
                            {{ $activeCampaign->campaign_name ?? 'None' }}
                        </div>
                        <div class="widget-label">Live Active Campaign</div>
                    </div>
                    <div class="widget-icon-box icon-emerald">
                        <i class="fas fa-broadcast-tower"></i>
                    </div>
                </div>
                <div class="mt-2 small text-success fw-bold d-flex align-items-center gap-2">
                    <span class="pulse-dot"></span>
                    <span>1 Campaign Active at a time</span>
                </div>
            </div>
        </div>

        <!-- 3. Total Wheel Slices -->
        <div class="col-xl-3 col-sm-6">
            <div class="metric-widget-card widget-orange">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="widget-num">{{ $totalSpinnersCount }}</div>
                        <div class="widget-label">Total Spin Slices</div>
                    </div>
                    <div class="widget-icon-box icon-orange">
                        <i class="fas fa-gift"></i>
                    </div>
                </div>
                <div class="mt-2 text-muted small">
                    <span>Configured wheel segments across campaigns</span>
                </div>
            </div>
        </div>

        <!-- 4. Total Stock Inventory -->
        <div class="col-xl-3 col-sm-6">
            <div class="metric-widget-card widget-purple">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="widget-num">{{ number_format($totalStockQty) }}</div>
                        <div class="widget-label">Total Prize Stock</div>
                    </div>
                    <div class="widget-icon-box icon-purple">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
                <div class="mt-2 text-muted small">
                    <span>{{ number_format($totalFormsCount) }} total entries joined</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaign Cards Section (Paginated) -->
    <div class="campaign-deck-container">
        <div class="section-ribbon-bar">
            <div>
                <h4 class="section-ribbon-title">
                    <i class="fas fa-layer-group text-primary"></i>
                    <span>Campaign Wise Spinner Overview</span>
                    <span class="badge bg-primary text-white rounded-pill fs-6">{{ $campings->total() }}</span>
                </h4>
                <p class="text-muted small mb-0 mt-1">
                    Select any campaign card below to filter its spinners. Click the radio switch to set it as the <strong>only active campaign</strong>.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" onclick="showAllSpinners()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold" id="btn_show_all">
                    <i class="fas fa-list-ul"></i> Show All Spinners ({{ $Spinner->count() }})
                </button>
            </div>
        </div>

        <!-- Grid of Campaign Cards -->
        <div class="row g-3" id="campaign_cards_row">
            @forelse ($campings as $camp)
                @php
                    $isThisActive = ($activeCampaign && $activeCampaign->id == $camp->id);
                @endphp
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="camp-card @if($isThisActive) is-active-campaign @endif" 
                         id="camp_card_{{ $camp->id }}"
                         data-camp-id="{{ $camp->id }}"
                         data-camp-name="{{ $camp->campaign_name }}">
                        
                        <div>
                            <!-- Header: Title & Single Active Radio Switch -->
                            <div class="camp-card-header">
                                <div>
                                    <h5 class="camp-title-text">{{ $camp->campaign_name }}</h5>
                                    @if(!empty($camp->title))
                                        <p class="camp-subtitle-text text-truncate" style="max-width: 190px;" title="{{ $camp->title }}">
                                            {{ $camp->title }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Single Active Radio -->
                                <label class="single-active-pill @if($isThisActive) pill-active @endif" id="active_pill_{{ $camp->id }}" title="Make this the only active campaign">
                                    <input type="radio" 
                                           name="single_active_campaign_radio" 
                                           value="{{ $camp->id }}" 
                                           @if($isThisActive) checked @endif
                                           onchange="setSingleActiveCampaign('{{ $camp->id }}', '{{ addslashes($camp->campaign_name) }}')">
                                    <span class="active-status-text-{{ $camp->id }}">
                                        @if($isThisActive) ACTIVE @else INACTIVE @endif
                                    </span>
                                </label>
                            </div>

                            <!-- Validity Dates -->
                            <div class="camp-dates-strip">
                                <i class="far fa-calendar-alt text-primary"></i>
                                <span>
                                    @php
                                        $sDate = !empty($camp->start_date) ? date('d M Y', strtotime($camp->start_date)) : 'N/A';
                                        $eDate = !empty($camp->end_date) ? date('d M Y', strtotime($camp->end_date)) : 'N/A';
                                    @endphp
                                    {{ $sDate }} &mdash; {{ $eDate }}
                                </span>
                            </div>

                            <!-- Metrics Grid -->
                            <div class="camp-metrics-grid">
                                <div class="camp-metric-item">
                                    <span class="camp-metric-val text-primary">{{ $camp->spinners_count }}</span>
                                    <span class="camp-metric-lbl">Slices</span>
                                </div>
                                <div class="camp-metric-item border-start border-end">
                                    <span class="camp-metric-val text-success">{{ number_format($camp->total_quantity) }}</span>
                                    <span class="camp-metric-lbl">Stock Qty</span>
                                </div>
                                <div class="camp-metric-item">
                                    <span class="camp-metric-val text-dark">{{ $camp->total_forms_joined }}</span>
                                    <span class="camp-metric-lbl">Joined</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action Buttons -->
                        <div class="camp-card-actions">
                            <button type="button" 
                                    class="btn-camp-view btn-view-camp-{{ $camp->id }}" 
                                    onclick="filterByCampaign('{{ $camp->id }}', '{{ addslashes($camp->campaign_name) }}')">
                                <i class="fas fa-eye"></i> View Spinners ({{ $camp->spinners_count }})
                            </button>
                            <button type="button" 
                                    class="btn-camp-add" 
                                    onclick="add_spinner_btn('{{ $camp->id }}')" 
                                    title="Add Prize Slice to this campaign">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-4 rounded-4">
                        <i class="fas fa-info-circle fs-4 mb-2 d-block"></i>
                        No campaigns found. <a href="{{URL::to('admin/add_camping_page')}}" class="fw-bold">Create your first campaign</a> to start adding prize wheel segments!
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Campaign Pagination Links -->
        @if ($campings->hasPages())
            <div class="camp-pagination-wrapper">
                {{ $campings->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Spinners List Table Section -->
    <div class="spinner-table-card" id="spinner_table_section">
        <div class="table-toolbar-header">
            <div>
                <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="fas fa-dharmachakra text-warning"></i>
                    <span id="spinner_table_title">All Wheel Spinners</span>
                    <span class="badge bg-primary text-white rounded-pill fs-7" id="spinner_table_count">{{ $Spinner->count() }} items</span>
                </h4>
                <div class="text-muted small" id="spinner_table_filter_desc">
                    Showing prize wheel segments across all campaigns.
                </div>
            </div>

            <!-- Search by Date Form & Actions -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form action="{{URL::to('admin/spinner_list')}}" method="post" class="d-flex align-items-center gap-2 flex-wrap">
                    @csrf
                    <input type="date" class="form-control form-control-sm rounded-pill" name="start_date" style="width: 145px;" value="<?php echo isset($start_date)?date('Y-m-d',strtotime($start_date)):date('Y-m-d'); ?>">
                    <input type="date" class="form-control form-control-sm rounded-pill" name="end_date" style="width: 145px;" value="<?php echo isset($end_date)?date('Y-m-d',strtotime($end_date)):date('Y-m-d'); ?>">
                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body p-3">
            <form action="{{URL::to('admin/downloadSpinnerPdf')}}" method="post" id="pdf_download_form">
                @csrf
                <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                        <i class="fas fa-file-pdf"></i> Download Selected PDF
                    </button>
                    <div id="filter_clear_btn_holder" style="display: none;">
                        <button type="button" onclick="showAllSpinners()" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary">
                            <i class="fas fa-times-circle"></i> Clear Campaign Filter
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover border table-striped table-bordered text-nowrap align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="30"><input name="" class="select_all form-check-input" id="select_all" type="checkbox"></th>
                                <th width="40">Sl.</th>
                                <th>Campaign</th>
                                <th>Prize Name</th>
                                <th>Max Qty</th>
                                <th>Image</th>
                                @if (Auth::user()->default_spinn == 2)
                                    <th>Chances</th>
                                @else
                                    <th>Skip</th>
                                @endif
                                <th>Wheel Color</th>
                                <th>Status</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Spinner as $key => $item)
                                <tr class="spinner-row" data-camp-id="{{ $item->camping_id }}" data-camp-name="{{ strtolower($item->c_name ?? $item->c_title ?? '') }}">
                                    <td>
                                        <input name="checkbox[]" class="checkbox form-check-input" type="checkbox" value="{{$item->id}}">
                                    </td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <span class="badge bg-light-primary text-primary fw-bold px-2 py-1 rounded-pill" style="cursor: pointer;" onclick="filterByCampaign('{{ $item->camping_id }}', '{{ addslashes($item->c_name ?? $item->c_title ?? 'Campaign') }}')">
                                            <i class="fas fa-tag me-1"></i>{{ $item->c_name ?? $item->c_title ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-dark">{{ $item->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light-success text-success fw-bold px-2 py-1 rounded-pill">
                                            {{ $item->value }} units
                                        </span>
                                    </td>

                                    <td>
                                        @if(!empty($item->image))
                                            <img src="{{$item->image}}" alt="" width="48px" height="48px" style="object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                                        @else
                                            <span class="text-muted small">No Image</span>
                                        @endif
                                    </td>

                                    @if (Auth::user()->default_spinn == 2)
                                        <td>
                                            @if((float)$item->chances > 0 && $item->skip != 'Yes')
                                                <span class="badge bg-success text-white">{{ $item->chances == 1 ? '1 (Win)' : $item->chances . ' (Win)' }}</span>
                                            @else
                                                <span class="badge bg-danger text-white">0 (Skip)</span>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            @if($item->skip == 'Yes')
                                                <span class="badge bg-light-danger text-danger">Yes</span>
                                            @else
                                                <span class="badge bg-light-success text-success">No</span>
                                            @endif
                                        </td>
                                    @endif

                                    <td>
                                        <div class="color-chip-preview">
                                            <div class="color-swatch-box" style="background: {{ $item->color }};"></div>
                                            <span class="small font-monospace">{{ $item->color }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @if($item->status == 'active')
                                            <span class="badge bg-success text-white px-2 py-1 rounded-pill">Active</span>
                                        @else
                                            <span class="badge bg-secondary text-white px-2 py-1 rounded-pill">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-primary" onclick="edit_spinner('{{URL::to('admin/edit_spinner/'.$item->id)}}')" title="Edit Spinner">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{URL::to('admin/delete_spinner/'.$item->id)}}" class="btn btn-sm btn-outline-danger" onclick="dataDelete(event)" title="Delete Spinner">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Spinner Modal (Create / Edit) -->
<div class="modal fade" id="add_spinner_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark" id="exampleModalLabel">
                    <i class="fas fa-dharmachakra text-primary me-2"></i>Configure Prize Wheel Segment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hide_modal()"></button>
            </div>
            <div class="modal-body spinner_body p-4">
                <!-- Dynamically injected via AJAX -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    let currentSelectedCampingId = null;
    let dataTableInstance = null;

    $(document).ready(function() {
        // Multi-select checkboxes
        $('#select_all').on('click', function() {
            $('.checkbox').prop('checked', this.checked);
        });

        // Initialize DataTable
        dataTableInstance = $("#zero_config").DataTable({
            dom: 'Bfrtip',
            pageLength: 15,
            columnDefs: [
                { orderable: false, targets: [0, 5, 9] }
            ],
            buttons: [
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
                'copy', 'excel', 'print'
            ]
        });

        @if(!empty($filterCampingId))
            filterByCampaign('{{ $filterCampingId }}', '');
        @endif
    });

    // 1. FILTER SPINNERS TABLE BY CAMPAIGN
    function filterByCampaign(campId, campName) {
        currentSelectedCampingId = campId;

        // Visual selection on cards
        $('.camp-card').removeClass('is-selected-filter');
        $('#camp_card_' + campId).addClass('is-selected-filter');

        $('.btn-camp-view').removeClass('is-viewing');
        $('.btn-view-camp-' + campId).addClass('is-viewing');

        // Update Table Title & Header
        $('#spinner_table_title').text('Spinners for: ' + (campName || 'Campaign #' + campId));
        $('#spinner_table_filter_desc').html('Showing prize wheel slices belonging strictly to <strong>' + (campName || 'Selected Campaign') + '</strong>.');
        $('#filter_clear_btn_holder').show();

        // Custom filter with DataTable
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                if (!currentSelectedCampingId) return true;
                const rowNode = dataTableInstance.row(dataIndex).node();
                const rowCampId = $(rowNode).attr('data-camp-id');
                return rowCampId == currentSelectedCampingId;
            }
        );

        dataTableInstance.draw();
        
        // Remove the custom filter function after draw so it doesn't pile up
        $.fn.dataTable.ext.search.pop();

        // Update count badge
        const visibleRowsCount = dataTableInstance.rows({ filter: 'applied' }).count();
        $('#spinner_table_count').text(visibleRowsCount + ' items');

        // Smooth scroll to table
        $('html, body').animate({
            scrollTop: $("#spinner_table_section").offset().top - 80
        }, 400);
    }

    // 2. SHOW ALL SPINNERS
    function showAllSpinners() {
        currentSelectedCampingId = null;

        $('.camp-card').removeClass('is-selected-filter');
        $('.btn-camp-view').removeClass('is-viewing');

        $('#spinner_table_title').text('All Wheel Spinners');
        $('#spinner_table_filter_desc').text('Showing prize wheel segments across all campaigns.');
        $('#filter_clear_btn_holder').hide();

        dataTableInstance.search('').columns().search('').draw();
        const totalRows = dataTableInstance.rows().count();
        $('#spinner_table_count').text(totalRows + ' items');
    }

    // 3. SET SINGLE ACTIVE CAMPAIGN VIA AJAX (Only 1 Campaign Active At A Time)
    function setSingleActiveCampaign(campId, campName) {
        $.ajax({
            type: "POST",
            url: "{{ URL::to('admin/set_single_active_campaign') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'campaign_id': campId
            },
            beforeSend: function() {
                // UI feedback
                $('.active-status-text-' + campId).text('Activating...');
            },
            success: function(response) {
                if (response.status) {
                    // Update all campaign cards
                    $('.camp-card').removeClass('is-active-campaign');
                    $('.single-active-pill').removeClass('pill-active');
                    $('.camp-card input[type="radio"]').prop('checked', false);
                    $('[class^="active-status-text-"]').text('INACTIVE');

                    // Activate chosen card
                    $('#camp_card_' + campId).addClass('is-active-campaign');
                    $('#active_pill_' + campId).addClass('pill-active');
                    $('#camp_card_' + campId + ' input[type="radio"]').prop('checked', true);
                    $('.active-status-text-' + campId).text('ACTIVE');

                    // Toast message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message, 'Active Campaign Updated');
                    } else if (typeof swal !== 'undefined') {
                        swal("Activated!", response.message, "success");
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function(err) {
                console.error(err);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to update active campaign.', 'Error');
                } else {
                    alert('Error updating active campaign.');
                }
            }
        });
    }

    // 4. ADD SPINNER MODAL (Pass optional campaign ID to pre-select)
    function add_spinner_btn(campId) {
        $.ajax({
            type: "GET",
            url: "{{ URL::to('admin/spinner_form') }}",
            data: {
                'camping_id': campId || ''
            },
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage);
            },
            success: function(data) {
                $('.spinner_body').html(data);
                $('#add_spinner_modal').modal('show');
            } 
        });
    }

    // 5. EDIT SPINNER MODAL
    function edit_spinner(url) {
        $.ajax({
            type: "GET",
            url: url,
            data: { 'id': '' },
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage);
            },
            success: function(data) {
                $('.spinner_body').html(data);
                $('#add_spinner_modal').modal('show');
            } 
        });
    }

    // 6. SUBMIT SPINNER FORM
    function add_spinner_submit() {
        var spin_round = $('.value').val();
        if (spin_round === '') {
            $('.spin_round_error').html('Please Enter Spin Round Value');
            return;
        } else {
            $('.spin_round_error').html('');
        }

        var url = $('#spinner_form').attr("action");
        var form = $('#spinner_form')[0];
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage);
            },
            success: function(data) {
                if (typeof swal !== 'undefined') {
                    swal({
                        title: "Saved!",
                        text: "Spinner saved successfully.",
                        type: "success",
                        confirmButtonText: "OK"
                    });
                }
                setTimeout(() => {
                    location.reload(true);
                }, 1200);
            } 
        });
    }

    function hide_modal() {
        $('#add_spinner_modal').modal('hide');
    }
</script>
@endsection