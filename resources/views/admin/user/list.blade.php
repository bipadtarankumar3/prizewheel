@extends('adminLayouts.home')
@section('content')

<style>
    /* Modern Dashboard Styling for Store & User Directory */
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
    .badge-pill-orange {
        background: rgba(255, 107, 0, 0.1);
        color: #ea580c;
        border: 1px solid rgba(255, 107, 0, 0.2);
    }
    .badge-pill-indigo {
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.2);
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

    .btn-hero-add-user {
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
        text-decoration: none !important;
    }
    .btn-hero-add-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px -3px rgba(255, 107, 0, 0.6);
        color: #ffffff !important;
    }

    .btn-hero-expired {
        background: #ffffff;
        color: #ef4444 !important;
        border: 1.5px solid #fecaca;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 9px 18px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
        text-decoration: none !important;
    }
    .btn-hero-expired:hover {
        background: #ef4444;
        color: #ffffff !important;
        border-color: #ef4444;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -2px rgba(239, 68, 68, 0.35);
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
    .stat-blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .stat-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-orange::before { background: linear-gradient(90deg, #ff6b00, #ea580c); }
    .stat-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
    .stat-danger::before { background: linear-gradient(90deg, #ef4444, #dc2626); }

    .stat-bubble-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .bubble-blue { background: #eff6ff; color: #2563eb; }
    .bubble-emerald { background: #ecfdf5; color: #059669; }
    .bubble-orange { background: #fff7ed; color: #ea580c; }
    .bubble-purple { background: #faf5ff; color: #7c3aed; }
    .bubble-danger { background: #fef2f2; color: #dc2626; }

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

    /* Live Registration Pulsing Dot */
    .pulse-dot-green {
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
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Filter & Search Bar */
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
    .preset-filter-chip.active-chip-today {
        background: linear-gradient(135deg, var(--primary-orange), #ea580c) !important;
        border-color: var(--primary-orange) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(255, 107, 0, 0.35);
    }

    /* Modern Table Container */
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

    /* User Profile Cell */
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
</style>

<div class="container-fluid user-manager-container">

    <!-- Hero Header with Primary Actions -->
    <div class="user-hero-card">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="hero-badge-pill badge-pill-orange">
                        <i class="ti ti-users"></i> Store Directory
                    </span>
                    <span class="hero-badge-pill badge-pill-indigo">
                        <i class="ti ti-shield-check"></i> Super Administrator
                    </span>
                    <span class="badge bg-light text-muted fw-bold rounded-pill border px-2 py-1">
                        <i class="ti ti-calendar"></i> {{ date('d M Y') }}
                    </span>
                </div>
                <h2 class="user-hero-title">
                    <i class="ti ti-building-store text-warning"></i>
                    <span>Store Registrations &amp; Client Directory</span>
                </h2>
                <p class="user-hero-subtitle">
                    Real-time oversight of all subscribed stores. Monitor daily registrations, client trial expiries, active campaigns, and access direct store dashboards.
                </p>
            </div>
            <div class="col-lg-5 col-md-12 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                    <a href="{{ URL::to('admin/add_sub_user_page') }}" class="btn-hero-add-user">
                        <i class="ti ti-plus"></i> Add New Store
                    </a>
                    <a href="{{ URL::to('admin/expiry_sub_user') }}" class="btn-hero-expired">
                        <i class="ti ti-clock-pause"></i> Expired Stores ({{ $expiredUsersCount ?? 0 }})
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary KPI Counter Strip (5 High-Density Metric Cards) -->
    <div class="row g-3 mb-4">
        
        <!-- 1. Total Stores -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="user-stat-card stat-blue">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-bubble-icon bubble-blue">
                        <i class="ti ti-building-store"></i>
                    </div>
                    <span class="badge bg-light-primary text-primary fw-bold rounded-pill px-2">Total</span>
                </div>
                <div class="stat-val-num">{{ number_format($totalUsersCount ?? count($user)) }}</div>
                <p class="stat-val-label">Total Stores</p>
            </div>
        </div>

        <!-- 2. Registered Today (Highlighted) -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="user-stat-card stat-orange">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-bubble-icon bubble-orange">
                        <i class="ti ti-user-plus"></i>
                    </div>
                    <span class="badge bg-light-warning text-danger fw-bold rounded-pill px-2 d-inline-flex align-items-center gap-1">
                        <span class="pulse-dot-green"></span> Live Today
                    </span>
                </div>
                <div class="stat-val-num text-danger">{{ number_format($todayRegisteredCount ?? 0) }}</div>
                <p class="stat-val-label">Registered Today</p>
            </div>
        </div>

        <!-- 3. This Month Registrations -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="user-stat-card stat-purple">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-bubble-icon bubble-purple">
                        <i class="ti ti-calendar-event"></i>
                    </div>
                    <span class="badge bg-light text-dark fw-bold rounded-pill px-2">This Month</span>
                </div>
                <div class="stat-val-num">{{ number_format($monthRegisteredCount ?? 0) }}</div>
                <p class="stat-val-label">New This Month</p>
            </div>
        </div>

        <!-- 4. Active Subscriptions -->
        <div class="col-xl col-md-6 col-sm-6">
            <div class="user-stat-card stat-emerald">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-bubble-icon bubble-emerald">
                        <i class="ti ti-circle-check"></i>
                    </div>
                    <span class="badge bg-light-success text-success fw-bold rounded-pill px-2">Active</span>
                </div>
                <div class="stat-val-num text-success">{{ number_format($activeUsersCount ?? 0) }}</div>
                <p class="stat-val-label">Active Subscriptions</p>
            </div>
        </div>

        <!-- 5. Expired / Inactive -->
        <div class="col-xl col-md-6 col-sm-12">
            <div class="user-stat-card stat-danger">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="stat-bubble-icon bubble-danger">
                        <i class="ti ti-alert-triangle"></i>
                    </div>
                    <span class="badge bg-light-danger text-danger fw-bold rounded-pill px-2">Expired</span>
                </div>
                <div class="stat-val-num text-muted">{{ number_format($expiredUsersCount ?? 0) }}</div>
                <p class="stat-val-label">Expired / Trial Ended</p>
            </div>
        </div>

    </div>

    <!-- Quick Preset Filter & Date Range Toolbar -->
    <div class="filter-panel-card">
        <div class="row align-items-center g-3">
            
            <!-- Quick Chips -->
            <div class="col-lg-6 col-md-12">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="text-muted small fw-bold text-uppercase me-1"><i class="ti ti-filter"></i> Presets:</span>
                    <a href="{{ URL::to('admin/sub_user_list') }}" class="preset-filter-chip @if(empty($activeFilter) && empty($start_date)) active-chip @endif">
                        All ({{ $totalUsersCount ?? 0 }})
                    </a>
                    <a href="{{ URL::to('admin/sub_user_list?filter=today') }}" class="preset-filter-chip @if(($activeFilter ?? '') == 'today') active-chip-today @endif">
                        <span class="pulse-dot-green"></span> Today ({{ $todayRegisteredCount ?? 0 }})
                    </a>
                    <a href="{{ URL::to('admin/sub_user_list?filter=month') }}" class="preset-filter-chip @if(($activeFilter ?? '') == 'month') active-chip @endif">
                        This Month ({{ $monthRegisteredCount ?? 0 }})
                    </a>
                    <a href="{{ URL::to('admin/sub_user_list?filter=active') }}" class="preset-filter-chip @if(($activeFilter ?? '') == 'active') active-chip @endif">
                        Active ({{ $activeUsersCount ?? 0 }})
                    </a>
                    <a href="{{ URL::to('admin/sub_user_list?filter=expired') }}" class="preset-filter-chip @if(($activeFilter ?? '') == 'expired') active-chip @endif">
                        Expired ({{ $expiredUsersCount ?? 0 }})
                    </a>
                </div>
            </div>

            <!-- Date Range Form -->
            <div class="col-lg-6 col-md-12">
                <form action="{{ URL::to('admin/sub_user_list') }}" method="post" class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap m-0">
                    @csrf
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted small fw-bold">From:</span>
                        <input type="date" class="form-control form-control-sm rounded-pill" name="start_date" style="width: 140px;" value="{{ $start_date ?? date('Y-m-d') }}">
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="text-muted small fw-bold">To:</span>
                        <input type="date" class="form-control form-control-sm rounded-pill" name="end_date" style="width: 140px;" value="{{ $end_date ?? date('Y-m-d') }}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                        <i class="ti ti-search"></i> Filter
                    </button>
                    @if(!empty($start_date) || !empty($activeFilter))
                        <a href="{{ URL::to('admin/sub_user_list') }}" class="btn btn-sm btn-light rounded-pill px-2 text-danger" title="Clear filters">
                            <i class="ti ti-x"></i>
                        </a>
                    @endif
                </form>
            </div>

        </div>
    </div>

    <!-- User Table Card -->
    <div class="user-table-card">
        
        <!-- Table Toolbar -->
        <div class="table-toolbar-strip">
            <div>
                <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="ti ti-list text-primary"></i>
                    <span>Store &amp; Client Registry</span>
                    <span class="badge bg-primary text-white rounded-pill fs-7">{{ $user->count() }} stores</span>
                </h4>
                <div class="text-muted small">
                    Showing registered clients with account status, activity stats, and quick session links.
                </div>
            </div>

            <!-- Bulk Action Form -->
            <div>
                <button type="button" onclick="$('#pdf_download_form').submit()" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                    <i class="ti ti-file-text"></i> Download Selected PDF
                </button>
            </div>
        </div>

        <div class="p-3">
            <form action="{{ URL::to('admin/downloadUserPdf') }}" method="post" id="pdf_download_form">
                @csrf

                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover border table-striped table-bordered text-nowrap align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 30px;">
                                    <input class="form-check-input" id="select_all" type="checkbox" title="Select all rows">
                                </th>
                                <th style="width: 40px;">#</th>
                                <th>Store &amp; Client</th>
                                <th>Registration Date</th>
                                <th>Contact Details</th>
                                <th>Active Status</th>
                                <th>Expiry Date</th>
                                <th>Wheel &amp; Activity</th>
                                <th>Account Note</th>
                                <th class="text-center" style="width: 160px;">Quick Access</th>
                                <th class="text-center" style="width: 80px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $key => $item)
                                @php
                                    $isRegisteredToday = !empty($item->created_at) && date('Y-m-d', strtotime($item->created_at)) == date('Y-m-d');
                                    $isExpired = !empty($item->expiry_date) && strtotime($item->expiry_date) < strtotime(date('Y-m-d'));
                                @endphp
                                <tr>
                                    <!-- Checkbox -->
                                    <td>
                                        <input name="checkbox[]" class="form-check-input checkbox" type="checkbox" value="{{ $item->id }}">
                                    </td>

                                    <!-- Index -->
                                    <td class="fw-bold text-muted">{{ $key + 1 }}</td>

                                    <!-- Store & Client Name -->
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if(!empty($item->logo))
                                                <img src="{{ $item->logo }}" alt="{{ $item->name }}" class="user-avatar-img">
                                            @else
                                                <div class="user-avatar-badge">
                                                    {{ strtoupper(substr($item->name ?? 'U', 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark fs-3">{{ $item->name }}</div>
                                                <div class="text-muted small font-monospace">ID: #{{ $item->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Registration Date with Relative Badge -->
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            {{ date('d M Y', strtotime($item->created_at)) }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ date('h:i A', strtotime($item->created_at)) }}
                                        </div>
                                        @if($isRegisteredToday)
                                            <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill px-2 py-1 mt-1">
                                                <span class="pulse-dot-green me-1"></span> New Today
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Contact Info -->
                                    <td>
                                        <div class="d-flex align-items-center gap-1 text-dark mb-1">
                                            <i class="ti ti-mail text-muted"></i>
                                            <a href="mailto:{{ $item->email }}" class="text-dark text-decoration-none fw-semibold">
                                                {{ $item->email }}
                                            </a>
                                        </div>
                                        @if(!empty($item->phone))
                                            <div class="d-flex align-items-center gap-1 text-muted small">
                                                <i class="ti ti-phone text-muted"></i>
                                                <a href="tel:{{ $item->phone }}" class="text-muted text-decoration-none">
                                                    {{ $item->phone }}
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-muted small">&mdash; No phone &mdash;</span>
                                        @endif
                                    </td>

                                    <!-- Status Badge -->
                                    <td>
                                        @if($item->status == 'active' && !$isExpired)
                                            <span class="badge bg-success-subtle text-success fw-bold px-2 py-1 rounded-pill">
                                                <i class="ti ti-check"></i> Active
                                            </span>
                                        @elseif($isExpired)
                                            <span class="badge bg-danger-subtle text-danger fw-bold px-2 py-1 rounded-pill">
                                                <i class="ti ti-clock-pause"></i> Expired
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary fw-bold px-2 py-1 rounded-pill">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Expiry Date -->
                                    <td>
                                        @if(!empty($item->expiry_date))
                                            <div class="fw-semibold {{ $isExpired ? 'text-danger' : 'text-dark' }}">
                                                {{ date('d M Y', strtotime($item->expiry_date)) }}
                                            </div>
                                            @php
                                                $daysLeft = ceil((strtotime($item->expiry_date) - time()) / 86400);
                                            @endphp
                                            @if(!$isExpired && $daysLeft >= 0)
                                                <small class="text-muted">{{ $daysLeft }} days left</small>
                                            @else
                                                <small class="text-danger fw-bold">Ended</small>
                                            @endif
                                        @else
                                            <span class="text-muted">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- Wheel & Activity Counts -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-light text-dark border px-2 py-1 rounded-3" title="Active Campaigns">
                                                <i class="ti ti-speakerphone text-primary"></i> {{ $item->campings_count ?? 0 }} Camps
                                            </span>
                                            <span class="badge bg-light text-dark border px-2 py-1 rounded-3" title="Configured Wheel Slices">
                                                <i class="ti ti-disc text-warning"></i> {{ $item->spinners_count ?? 0 }} Slices
                                            </span>
                                        </div>
                                        <div class="small text-muted mt-1">
                                            Rounds: <strong>{{ $item->spin_whell_round ?? 0 }}</strong>
                                        </div>
                                    </td>

                                    <!-- Note / Plan Tag -->
                                    <td>
                                        @if(!empty($item->note))
                                            <span class="badge bg-light-primary text-primary text-wrap text-start rounded-3 p-2 fw-semibold" style="max-width: 170px; font-size: 11.5px; line-height: 1.35;">
                                                {{ Str::limit($item->note, 45) }}
                                            </span>
                                        @else
                                            <span class="text-muted small">&mdash;</span>
                                        @endif
                                    </td>

                                    <!-- Quick Access Links -->
                                    <td class="text-center">
                                        <div class="d-flex flex-column gap-1 align-items-center">
                                            <!-- Dashboard Visit -->
                                            <a href="{{ URL::to('admin/dashboard_visit/'.$item->id) }}" class="action-pill-btn pill-btn-login w-100 justify-content-center" title="Login directly into this store's panel">
                                                <i class="ti ti-login"></i> Store Login
                                            </a>
                                            <!-- Live Wheel Site -->
                                            @if(!empty($item->name_url))
                                                <a href="{{ URL::to('u/'.$item->name_url) }}" target="_blank" class="action-pill-btn pill-btn-site w-100 justify-content-center" title="Open customer spin wheel link">
                                                    <i class="ti ti-external-link"></i> Live Wheel
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Edit / Delete Actions -->
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ URL::to('admin/edit_sub_user/'.$item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit store settings">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{ URL::to('admin/delete_sub_user/'.$item->id) }}" class="btn btn-sm btn-outline-danger" onclick="dataDelete(event)" title="Delete store">
                                                <i class="ti ti-trash"></i>
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

@endsection

@section('js')
<script>
$(document).ready(function() {
    // Select all checkboxes
    $('#select_all').on('click', function() {
        $('.checkbox').prop('checked', this.checked);
    });

    // Initialize DataTable with export buttons & 50 items per page
    $("#zero_config").DataTable({
        dom: 'Bfrtip',
        pageLength: 50,
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            'copy', 'excel', 'print'
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endsection