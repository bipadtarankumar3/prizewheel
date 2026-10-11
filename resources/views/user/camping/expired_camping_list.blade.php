@extends('adminLayouts.home')
@section('content')

<style>
    /* ==========================================================================
       Atom UI - Expired Campaigns Archive Styles (Matching Store Registry)
       ========================================================================== */
    :root {
        --primary-orange: #ff6b00;
        --primary-orange-glow: rgba(255, 107, 0, 0.25);
        --accent-emerald: #10b981;
        --accent-blue: #3b82f6;
        --accent-indigo: #4f46e5;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
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
    .badge-pill-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
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

    /* KPI Stat Widget Cards */
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
    .stat-danger::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .stat-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .stat-orange::before { background: linear-gradient(90deg, #ff6b00, #ea580c); }
    .stat-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .stat-bubble-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .bubble-danger { background: #fef2f2; color: #dc2626; }
    .bubble-emerald { background: #ecfdf5; color: #059669; }
    .bubble-blue { background: #eff6ff; color: #2563eb; }
    .bubble-orange { background: #fff7ed; color: #ea580c; }
    .bubble-purple { background: #faf5ff; color: #7c3aed; }

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
        padding: 16px 20px;
        margin-bottom: 22px;
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

    /* Table Container */
    .user-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .table-toolbar-strip {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* Store Avatar */
    .user-avatar-badge {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        border: 1.5px solid rgba(255, 107, 0, 0.2);
        color: #ea580c;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .user-avatar-img {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        object-fit: cover;
        border: 1.5px solid #e2e8f0;
        flex-shrink: 0;
    }

    .action-pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 9999px;
        font-size: 0.74rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .pill-btn-login {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .pill-btn-login:hover {
        background: #1d4ed8;
        color: #ffffff !important;
        border-color: #1d4ed8;
        transform: translateY(-1px);
    }
    .pill-btn-site {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .pill-btn-site:hover {
        background: #047857;
        color: #ffffff !important;
        border-color: #047857;
        transform: translateY(-1px);
    }

    .badge-status-ended {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
</style>

<div class="container-fluid user-manager-container">

    <!-- Hero Header with Primary Actions -->
    <div class="user-hero-card">
        <div class="row align-items-center">
            
            <div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="hero-badge-pill badge-pill-danger">
                        <i class="ti ti-archive"></i> CONCLUDED CAMPAIGN ARCHIVE
                    </span>
                    <span class="text-muted small">&bull; Historical Engagement Telemetry</span>
                </div>
                <h2 class="user-hero-title">
                    <i class="ti ti-calendar-off text-danger"></i>
                    <span>Expired Campaign Registry</span>
                    <span class="badge bg-danger text-white rounded-pill fs-7">{{ $totalExpired }} Expired</span>
                </h2>
                <p class="user-hero-subtitle">
                    Registry of concluded promotional spin campaigns with participation statistics, captured leads, prize slice breakdown, and client store details.
                </p>
            </div>

            <div class="col-lg-4 col-md-12 text-lg-end text-start">
                <div class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                    <a href="{{ URL::to('admin/camping_list') }}" class="btn btn-outline-dark rounded-pill px-3 py-2 fw-bold" style="font-size: 0.88rem;">
                        <i class="ti ti-sparkles text-warning me-1"></i> Active Campaigns
                    </a>
                    <button type="button" onclick="$('#pdf_download_form').submit()" class="btn btn-danger rounded-pill px-3 py-2 fw-bold" style="font-size: 0.88rem;">
                        <i class="ti ti-file-text me-1"></i> Download Selected PDF
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- 5 KPI Stat Widgets Row -->
    <div class="row g-3 mb-4">
        <!-- Expired Campaigns -->
        <div class="col-xl-2 col-md-4 col-sm-6" style="flex: 1;">
            <div class="user-stat-card stat-danger">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Expired Campaigns</span>
                    <div class="stat-bubble-icon bubble-danger">
                        <i class="ti ti-calendar-off"></i>
                    </div>
                </div>
                <div class="stat-val-num text-danger">{{ $totalExpired }}</div>
                <div class="text-muted small" style="font-size: 11px;">
                    <span class="text-danger fw-bold">{{ $recentlyExpired }}</span> ended in last 30d
                </div>
            </div>
        </div>

        <!-- Captured Leads -->
        <div class="col-xl-2 col-md-4 col-sm-6" style="flex: 1;">
            <div class="user-stat-card stat-emerald">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Captured Leads</span>
                    <div class="stat-bubble-icon bubble-emerald">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
                <div class="stat-val-num text-success">{{ number_format($totalLeads) }}</div>
                <div class="text-muted small" style="font-size: 11px;">
                    Customer form submissions
                </div>
            </div>
        </div>

        <!-- Target Form Quota -->
        <div class="col-xl-2 col-md-4 col-sm-6" style="flex: 1;">
            <div class="user-stat-card stat-blue">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Quota Target</span>
                    <div class="stat-bubble-icon bubble-blue">
                        <i class="ti ti-target-arrow"></i>
                    </div>
                </div>
                <div class="stat-val-num text-primary">{{ number_format($totalQuota) }}</div>
                <div class="text-muted small" style="font-size: 11px;">
                    Planned customer entries
                </div>
            </div>
        </div>

        <!-- Spin Pool -->
        <div class="col-xl-2 col-md-4 col-sm-6" style="flex: 1;">
            <div class="user-stat-card stat-orange">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Spin Pool</span>
                    <div class="stat-bubble-icon bubble-orange">
                        <i class="ti ti-rotate-clockwise-2"></i>
                    </div>
                </div>
                <div class="stat-val-num text-warning">{{ number_format($totalSpinsAllocated) }}</div>
                <div class="text-muted small" style="font-size: 11px;">
                    Lifetime spins capacity
                </div>
            </div>
        </div>

        <!-- Prize Slices -->
        <div class="col-xl-2 col-md-4 col-sm-6" style="flex: 1;">
            <div class="user-stat-card stat-purple">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Prize Slices</span>
                    <div class="stat-bubble-icon bubble-purple">
                        <i class="ti ti-disc"></i>
                    </div>
                </div>
                <div class="stat-val-num text-dark">{{ number_format($totalSlicesConfigured) }}</div>
                <div class="text-muted small" style="font-size: 11px;">
                    Across <span class="fw-bold">{{ $uniqueStoresCount }}</span> client stores
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Preset Filter & Search Toolbar -->
    <div class="filter-panel-card">
        <form action="{{ URL::to('admin/expired_camping_list') }}" method="GET" class="m-0">
            <div class="row align-items-center g-3">
                
                <!-- Search Query -->
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted small fw-bold"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control form-control-sm rounded-pill" name="search" placeholder="Search campaign or client..." value="{{ $search }}">
                    </div>
                </div>

                <!-- Date Range From -->
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted small fw-bold">From:</span>
                        <input type="date" class="form-control form-control-sm rounded-pill" name="start_date" value="{{ $start_date }}">
                    </div>
                </div>

                <!-- Date Range To -->
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted small fw-bold">To:</span>
                        <input type="date" class="form-control form-control-sm rounded-pill" name="end_date" value="{{ $end_date }}">
                    </div>
                </div>

                @if(Auth::user()->type == 'admin')
                    <!-- Store Selector -->
                    <div class="col-lg-3 col-md-6">
                        <select name="store_id" class="form-select form-select-sm rounded-pill">
                            <option value="">-- All Client Stores --</option>
                            @foreach($allStores as $s)
                                <option value="{{ $s->id }}" {{ $store_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }} (ID #{{ $s->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Filter Actions -->
                <div class="col-lg-2 col-md-6 text-end ms-auto">
                    <div class="d-flex align-items-center justify-content-end gap-1">
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                            <i class="ti ti-filter"></i> Filter
                        </button>
                        @if(!empty($start_date) || !empty($end_date) || !empty($store_id) || !empty($search))
                            <a href="{{ URL::to('admin/expired_camping_list') }}" class="btn btn-sm btn-light rounded-pill px-2 text-danger" title="Clear filters">
                                <i class="ti ti-x"></i>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- Expired Campaigns Table Card -->
    <div class="user-table-card">
        
        <!-- Table Toolbar -->
        <div class="table-toolbar-strip">
            <div>
                <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="ti ti-calendar-off text-danger"></i>
                    <span>Expired Campaigns Directory</span>
                    <span class="badge bg-danger text-white rounded-pill fs-7">{{ $camping->count() }} records</span>
                </h4>
                <div class="text-muted small">
                    Showing concluded marketing campaigns with audience participation, lead conversions, and store details.
                </div>
            </div>

            <div>
                <button type="button" onclick="$('#pdf_download_form').submit()" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                    <i class="ti ti-file-text"></i> Download Selected PDF
                </button>
            </div>
        </div>

        <div class="p-3">
            <form action="{{ URL::to('admin/downloadCampaignPdf') }}" method="POST" id="pdf_download_form">
                @csrf

                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover border table-striped table-bordered text-nowrap align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 30px;">
                                    <input class="form-check-input" id="select_all" type="checkbox" title="Select all rows">
                                </th>
                                <th style="width: 50px;"># ID</th>
                                <th>Campaign &amp; Theme</th>
                                <th>Store &amp; Client</th>
                                <th>Timeline &amp; Duration</th>
                                <th>Leads &amp; Quota</th>
                                <th>Slices &amp; Prizes</th>
                                <th class="text-center" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($camping as $key => $item)
                                @php
                                    $store = $item->user;
                                    $startDate = \Carbon\Carbon::parse($item->start_date);
                                    $endDate = \Carbon\Carbon::parse($item->end_date);
                                    $durationDays = max(1, (int)$startDate->diffInDays($endDate));
                                    $leadsPercent = $item->total_form > 0 ? min(100, round(($item->spinner_forms_count / $item->total_form) * 100)) : 0;
                                @endphp
                                <tr>
                                    <!-- Checkbox -->
                                    <td>
                                        <input name="checkbox[]" class="form-check-input checkbox" type="checkbox" value="{{ $item->id }}">
                                    </td>

                                    <!-- ID & Status -->
                                    <td>
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="fw-bold text-dark font-monospace">#{{ $item->id }}</span>
                                            <span class="badge-status-ended mt-1">
                                                <i class="ti ti-clock-stop"></i> Ended
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Campaign & Theme Details -->
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-3" title="{{ $item->campaign_name }}">
                                                {{ $item->campaign_name }}
                                            </span>
                                            @if(!empty($item->title))
                                                <span class="text-primary fw-semibold fs-2" title="{{ $item->title }}">
                                                    <i class="ti ti-sparkles me-1 text-warning"></i>{{ $item->title }}
                                                </span>
                                            @endif
                                            @if(!empty($item->sub_title))
                                                <span class="text-muted fs-1" style="max-width: 280px; white-space: normal; line-height: 1.2;">
                                                    {{ Str::limit($item->sub_title, 45) }}
                                                </span>
                                            @endif
                                            <div class="d-flex align-items-center gap-1 mt-1">
                                                <span class="badge bg-light text-muted border" style="font-size: 10px;">
                                                    <i class="ti ti-bolt text-warning"></i> {{ $item->spinner_time ?? 15 }}s speed
                                                </span>
                                                <span class="badge bg-light text-muted border" style="font-size: 10px;">
                                                    <i class="ti ti-mail text-info"></i> {{ $item->mail_send == 'YES' ? 'Email ON' : 'Email OFF' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Store & Client Details -->
                                    <td>
                                        @if($store)
                                            <div class="d-flex align-items-center gap-2">
                                                @if(!empty($store->logo))
                                                    <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="user-avatar-img">
                                                @else
                                                    <div class="user-avatar-badge">
                                                        {{ strtoupper(substr($store->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-column" style="line-height: 1.25;">
                                                    <span class="fw-bold text-dark" title="{{ $store->name }}">
                                                        {{ $store->name }}
                                                    </span>
                                                    <span class="text-muted small">
                                                        {{ $store->email ?? 'No email' }}
                                                    </span>
                                                    <div class="d-flex align-items-center gap-1 mt-1">
                                                        @if(Auth::user()->type == 'admin')
                                                            <a href="{{ URL::to('admin/dashboard_visit/'.$store->id) }}" class="action-pill-btn pill-btn-login" title="Login to Store Panel">
                                                                <i class="ti ti-login"></i> Store Login
                                                            </a>
                                                        @endif
                                                        @if(!empty($store->name_url))
                                                            <a href="{{ URL::to('u/'.$store->name_url) }}" target="_blank" class="action-pill-btn pill-btn-site" title="Live Site">
                                                                <i class="ti ti-external-link"></i> Live Wheel
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted italic">ID #{{ $item->created_by }}</span>
                                        @endif
                                    </td>

                                    <!-- Timeline & Duration -->
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <div class="d-flex align-items-center gap-1 text-muted fs-2">
                                                <i class="ti ti-calendar-event text-primary"></i>
                                                <span>From: <strong>{{ $startDate->format('d M, Y') }}</strong></span>
                                            </div>
                                            <div class="d-flex align-items-center gap-1 text-danger fs-2">
                                                <i class="ti ti-calendar-off"></i>
                                                <span>To: <strong>{{ $endDate->format('d M, Y') }}</strong></span>
                                            </div>
                                            <div class="d-flex align-items-center gap-1 mt-1">
                                                <span class="badge bg-secondary-subtle text-dark border" style="font-size: 10px;">
                                                    <i class="ti ti-hourglass"></i> {{ $durationDays }} days ran
                                                </span>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 10px;">
                                                    Ended {{ $endDate->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Leads & Quota Performance -->
                                    <td>
                                        <div class="d-flex flex-column" style="min-width: 140px;">
                                            <div class="d-flex align-items-baseline justify-content-between gap-1 mb-1">
                                                <span class="fw-bold text-dark fs-3">{{ $item->spinner_forms_count }} leads</span>
                                                <span class="text-muted small">/ {{ $item->total_form }} quota</span>
                                            </div>
                                            <div class="progress w-100 mb-1" style="height: 6px; border-radius: 9999px; background: #e2e8f0;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $leadsPercent }}%;"></div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                                <span>{{ $leadsPercent }}% achieved</span>
                                                <span>{{ number_format($item->number_of_total_spinn) }} spins</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Slices & Prizes -->
                                    <td>
                                        <div class="d-flex flex-column align-items-start gap-1">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                                <i class="ti ti-disc me-1"></i> {{ $item->spinners_count }} Slices
                                            </span>
                                            <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-semibold" style="font-size: 11.5px;" data-bs-toggle="modal" data-bs-target="#campaignModal_{{ $item->id }}">
                                                View Slices &amp; Chances <i class="ti ti-chevron-right"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <!-- Inspect Full Details Modal -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#campaignModal_{{ $item->id }}" title="Inspect Full Campaign Breakdown">
                                            <i class="ti ti-eye"></i> Details
                                        </button>
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

<!-- =========================================================================
     MODALS SECTION (Placed safely outside the table)
     ========================================================================= -->
@foreach ($camping as $item)
    @php
        $store = $item->user;
        $startDate = \Carbon\Carbon::parse($item->start_date);
        $endDate = \Carbon\Carbon::parse($item->end_date);
        $durationDays = max(1, (int)$startDate->diffInDays($endDate));
    @endphp
    <div class="modal fade" id="campaignModal_{{ $item->id }}" tabindex="-1" aria-labelledby="campaignModalLabel_{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                
                <!-- Modal Header -->
                <div class="modal-header bg-dark text-white py-3 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-danger text-white">
                            <i class="ti ti-calendar-off fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" id="campaignModalLabel_{{ $item->id }}">
                                {{ $item->campaign_name }}
                            </h5>
                            <span class="text-white-50 small">Campaign ID #{{ $item->id }} &bull; Ended {{ $endDate->format('d M, Y') }}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    
                    <!-- Store & Parameters Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light border h-100">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-2">Owning Client Store</span>
                                @if($store)
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        @if(!empty($store->logo))
                                            <img src="{{ $store->logo }}" alt="" class="user-avatar-img" style="width: 34px; height: 34px;">
                                        @else
                                            <div class="user-avatar-badge" style="width: 34px; height: 34px; font-size: 13px;">
                                                {{ strtoupper(substr($store->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $store->name }}</div>
                                            <div class="text-muted small">{{ $store->email }}</div>
                                        </div>
                                    </div>
                                    @if(!empty($store->phone))
                                        <div class="small text-muted mb-2"><i class="ti ti-phone me-1"></i> {{ $store->phone }}</div>
                                    @endif
                                    @if(Auth::user()->type == 'admin')
                                        <a href="{{ URL::to('admin/dashboard_visit/'.$store->id) }}" class="btn btn-warning btn-sm fw-bold w-100">
                                            <i class="ti ti-login me-1"></i> Store Dashboard Login
                                        </a>
                                    @endif
                                @else
                                    <span class="text-muted italic">Store ID #{{ $item->created_by }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light border h-100">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-2">Campaign Parameters</span>
                                <div class="d-flex justify-content-between py-1 border-bottom small">
                                    <span class="text-muted">Start Date:</span>
                                    <span class="fw-bold text-dark">{{ $startDate->format('d M, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom small">
                                    <span class="text-muted">Ended Date:</span>
                                    <span class="fw-bold text-danger">{{ $endDate->format('d M, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom small">
                                    <span class="text-muted">Total Run Days:</span>
                                    <span class="fw-bold text-dark">{{ $durationDays }} days</span>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom small">
                                    <span class="text-muted">Wheel Spin Speed:</span>
                                    <span class="fw-bold text-dark">{{ $item->spinner_time ?? 15 }}s</span>
                                </div>
                                <div class="d-flex justify-content-between py-1 small">
                                    <span class="text-muted">Email Alert:</span>
                                    <span class="fw-bold {{ $item->mail_send == 'YES' ? 'text-success' : 'text-muted' }}">{{ $item->mail_send ?? 'NO' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Headline Banner -->
                    <div class="p-3 rounded-3 mb-4" style="background: linear-gradient(135deg, #fff7ed, #ffedd5); border: 1px solid #fed7aa;">
                        <span class="badge bg-warning text-dark fw-bold px-2 py-0.5 rounded-pill mb-2" style="font-size: 10px;">
                            CAMPAIGN BANNER TEXT
                        </span>
                        <h5 class="fw-bold text-dark mb-1">{{ $item->title ?: 'No Headline' }}</h5>
                        <p class="text-secondary mb-0 small">{{ $item->sub_title ?: 'No Subtitle' }}</p>
                    </div>

                    <!-- Metric Counters -->
                    <div class="row g-2 mb-4 text-center">
                        <div class="col-4">
                            <div class="p-3 rounded-3 bg-light border">
                                <span class="text-muted small d-block">Captured Leads</span>
                                <h4 class="fw-bold text-success mb-0">{{ $item->spinner_forms_count }}</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3 bg-light border">
                                <span class="text-muted small d-block">Target Quota</span>
                                <h4 class="fw-bold text-primary mb-0">{{ $item->total_form }}</h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3 bg-light border">
                                <span class="text-muted small d-block">Max Spins Pool</span>
                                <h4 class="fw-bold text-dark mb-0">{{ number_format($item->number_of_total_spinn) }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Configured Slices Table -->
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-dark fs-3">
                                <i class="ti ti-disc text-primary me-1"></i> Configured Slices ({{ $item->spinners->count() }})
                            </span>
                        </div>

                        @if($item->spinners->count() > 0)
                            <div class="table-responsive border rounded-3">
                                <table class="table table-sm table-striped align-middle mb-0" style="font-size: 12px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th>Slice / Prize Name</th>
                                            <th>Odds (Chances %)</th>
                                            <th>Value / Price</th>
                                            <th>Color</th>
                                            <th>Skip Mode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item->spinners as $sIdx => $slice)
                                            <tr>
                                                <td>{{ $sIdx + 1 }}</td>
                                                <td class="fw-bold text-dark">{{ $slice->name }}</td>
                                                <td>
                                                    <span class="badge bg-primary-subtle text-primary fw-bold">
                                                        {{ $slice->chances ?? '0' }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ !empty($slice->price) ? '₹'.$slice->price : ($slice->value ?? '—') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <span class="d-inline-block rounded-circle" style="width: 14px; height: 14px; background: {{ $slice->color ?? '#999' }}; border: 1px solid rgba(0,0,0,0.15);"></span>
                                                        <span class="font-monospace small">{{ $slice->color ?? '—' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($slice->skip == 1)
                                                        <span class="badge bg-danger-subtle text-danger" style="font-size: 10px;">Skip</span>
                                                    @else
                                                        <span class="badge bg-success-subtle text-success" style="font-size: 10px;">Award Prize</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-3 text-center text-muted border rounded-3 bg-light small">
                                No custom slices configured.
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light py-2 px-4 justify-content-between">
                    <div>
                        @if(!empty($store->name_url))
                            <a href="{{ URL::to('u/'.$store->name_url) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-external-link me-1"></i> Open Live Wheel Link
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach

@endsection

@section('js')
<script>
$(document).ready(function() {
    // Select all checkboxes
    $('#select_all').on('click', function() {
        $('.checkbox').prop('checked', this.checked);
    });

    // Initialize DataTable with export buttons matching store registry
    $("#zero_config").DataTable({
        dom: 'Bfrtip',
        pageLength: 25,
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            'copy', 'excel', 'print'
        ],
        order: [[1, 'desc']] // Sort by ID descending
    });
});
</script>
@endsection