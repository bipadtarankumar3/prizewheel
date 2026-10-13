@extends('adminLayouts.home')
@section('content')

<div class="container-fluid">

@php
  $storeUrl = url('u/' . (Auth::user()->name_url ?: Auth::user()->id));
@endphp

@if (Auth::user()->type == 'admin')
  {{-- ==========================================
       SUPER ADMIN DASHBOARD
       ========================================== --}}
  <div class="dash-hero-card">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <span class="dash-hero-pill pill-orange">
            <i class="ti ti-shield-check"></i> Super Administrator
          </span>
          <span class="dash-hero-pill">
            <i class="ti ti-calendar"></i> {{ date('l, d F Y') }}
          </span>
        </div>
        <h2 class="dash-hero-title">Platform Master Overview 👋</h2>
        <p class="dash-hero-subtitle">
          Manage all subscribed businesses, wheel engagements, campaign activities, and user memberships platform-wide.
        </p>
      </div>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ url('admin/sub_user_list') }}" class="dash-hero-btn dash-hero-btn-primary">
          <i class="ti ti-users"></i> Manage All Stores
        </a>
        <a href="{{ url('admin/add_sub_user_page') }}" class="dash-hero-btn dash-hero-btn-secondary">
          <i class="ti ti-plus"></i> Add New Store
        </a>
      </div>
    </div>
  </div>

  {{-- Admin KPI Metric Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-6 col-xl-3">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-blue">
            <i class="ti ti-users"></i>
          </div>
          <span class="kpi-badge kpi-badge-neutral">Stores</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $Users }}</div>
          <p class="kpi-stat-label">Total Registered Stores</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-emerald">
            <i class="ti ti-user-check"></i>
          </div>
          <span class="kpi-badge kpi-badge-up">Active</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $ActiveUsers }}</div>
          <p class="kpi-stat-label">Active Store Subscriptions</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-orange">
            <i class="ti ti-user-x"></i>
          </div>
          <span class="kpi-badge kpi-badge-neutral">Inactive</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $InactiveUsers }}</div>
          <p class="kpi-stat-label">Inactive Stores</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-danger">
            <i class="ti ti-clock-pause"></i>
          </div>
          <span class="kpi-badge" style="background:#fee2e2; color:#b91c1c;">Expired</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $ExpiredUser }}</div>
          <p class="kpi-stat-label">Expired Accounts</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Admin Second Row: Platform Activity & Charts --}}
  <div class="row g-3 mb-4">
    <div class="col-lg-8">
      <div class="dash-modern-card h-100">
        <div class="dash-card-header">
          <h3 class="dash-card-title">
            <i class="ti ti-chart-line text-primary"></i> Store Registrations Trend (Last 7 Days)
          </h3>
          <span class="dash-hero-pill pill-blue fw-bold" style="background: #eff6ff !important; color: #1d4ed8 !important; border: 1px solid #bfdbfe !important;">
            <i class="ti ti-trending-up me-1"></i> Real-time Growth
          </span>
        </div>
        <div class="dash-card-body">
          <div id="adminGrowthChart" style="min-height: 280px;"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="dash-modern-card h-100">
        <div class="dash-card-header">
          <h3 class="dash-card-title">
            <i class="ti ti-chart-pie text-success"></i> Store Status Breakdown
          </h3>
        </div>
        <div class="dash-card-body d-flex flex-column justify-content-center">
          <div id="adminStatusDonutChart" style="min-height: 250px;"></div>
        </div>
      </div>
    </div>
  </div>

  {{-- Admin Table: Recent Stores --}}
  <div class="dash-modern-card">
    <div class="dash-card-header">
      <h3 class="dash-card-title">
        <i class="ti ti-building-store text-primary"></i> Recently Registered Store Accounts
      </h3>
      <a href="{{ url('admin/sub_user_list') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
        View All Stores <i class="ti ti-arrow-right ms-1"></i>
      </a>
    </div>
    <div class="dash-card-body p-0">
      <div class="table-responsive">
        <table class="table modern-table mb-0">
          <thead>
            <tr>
              <th>Store / Business</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Expiry Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($RecentUsers ?? [] as $store)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="user-avatar-circle">
                    {{ strtoupper(substr($store->name ?? 'S', 0, 1)) }}
                  </div>
                  <div>
                    <div class="fw-bold text-dark">{{ $store->name }}</div>
                    <small class="text-muted">{{ $store->name_url ?? 'no-custom-url' }}</small>
                  </div>
                </div>
              </td>
              <td>{{ $store->email }}</td>
              <td>{{ $store->phone ?? '—' }}</td>
              <td>
                @if($store->status == 'active')
                  <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-bold">Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill fw-bold">Inactive</span>
                @endif
              </td>
              <td>
                @if($store->expiry_date)
                  <span class="text-dark fw-semibold">{{ date('d M Y', strtotime($store->expiry_date)) }}</span>
                @else
                  <span class="text-muted">Unlimited</span>
                @endif
              </td>
              <td class="text-end">
                <a href="{{ url('admin/edit_sub_user/' . $store->id) }}" class="btn btn-sm btn-light text-primary rounded-circle" title="Edit">
                  <i class="ti ti-pencil"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">No stores registered yet.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

@else
  {{-- ==========================================
       STORE / CAMPAIGN USER DASHBOARD
       ========================================== --}}
  @php
    $storeUrl = url('u/' . (Auth::user()->name_url ?: Auth::user()->id));
    $activeCampaign = $campaigns->where('status', 'active')->first() ?? $campaigns->first();
  @endphp

  {{-- Hero Store Card with Quick Actions & URL Copy --}}
  <div class="dash-hero-card">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <span class="dash-hero-pill pill-orange">
            <i class="ti ti-crown"></i> Store Dashboard
          </span>
          @if(Auth::user()->default_spinn == 1)
            <span class="dash-hero-pill pill-blue">
              <i class="ti ti-adjustments"></i> Skip Mode Active
            </span>
          @else
            <span class="dash-hero-pill pill-blue">
              <i class="ti ti-dice"></i> Chances Mode Active
            </span>
          @endif
          @if(Auth::user()->expiry_date)
            <span class="dash-hero-pill">
              <i class="ti ti-clock"></i> Access until {{ date('d M Y', strtotime(Auth::user()->expiry_date)) }}
            </span>
          @endif
        </div>
        <h2 class="dash-hero-title">Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p class="dash-hero-subtitle">
          Your digital prize wheel is live and collecting leads. Monitor visits, track customer spins, analyze rewards, and manage campaigns in real-time.
        </p>
      </div>

      <div class="d-flex align-items-center gap-2 flex-wrap">
        <button type="button" class="dash-hero-btn dash-hero-btn-secondary" onclick="copyStoreUrl('{{ $storeUrl }}')">
          <i class="ti ti-copy"></i> Copy Wheel Link
        </button>
        <a href="{{ $storeUrl }}" target="_blank" class="dash-hero-btn dash-hero-btn-primary">
          <i class="ti ti-external-link"></i> Launch Wheel
        </a>
        <a href="{{ url('admin/add_camping_page') }}" class="dash-hero-btn dash-hero-btn-secondary">
          <i class="ti ti-plus"></i> New Campaign
        </a>
      </div>
    </div>
  </div>

  {{-- PRIMARY 6 HIGH-IMPACT METRIC CARDS --}}
  <div class="row g-3 mb-3">
    {{-- 1. Total Customer Visits --}}
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-blue">
            <i class="ti ti-eye"></i>
          </div>
          <span class="kpi-badge kpi-badge-up">+Visitors</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $totalVisits }}</div>
          <p class="kpi-stat-label">Total Visits</p>
        </div>
      </div>
    </div>

    {{-- 2. Total Wheel Spins --}}
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-purple">
            <i class="ti ti-disc"></i>
          </div>
          <span class="kpi-badge kpi-badge-neutral">Engaged</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $totalSpins }}</div>
          <p class="kpi-stat-label">Total Spins</p>
        </div>
      </div>
    </div>

    {{-- 3. Leads Captured --}}
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-emerald">
            <i class="ti ti-user-check"></i>
          </div>
          <span class="kpi-badge kpi-badge-up">Converted</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $SpinnerForm }}</div>
          <p class="kpi-stat-label">Total Leads</p>
        </div>
      </div>
    </div>

    {{-- 4. Conversion Rate --}}
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-orange">
            <i class="ti ti-chart-arrows"></i>
          </div>
          <span class="kpi-badge kpi-badge-up">{{ $conversionRate }}%</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $conversionRate }}%</div>
          <p class="kpi-stat-label">Conversion Rate</p>
        </div>
      </div>
    </div>

    {{-- 5. Active Prize Slices --}}
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-cyan">
            <i class="ti ti-gift"></i>
          </div>
          <span class="kpi-badge kpi-badge-neutral">Active</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ $Spinner }}</div>
          <p class="kpi-stat-label">Prize Slices</p>
        </div>
      </div>
    </div>

    {{-- 6. WhatsApp Alerts --}}
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-stat-card">
        <div class="d-flex align-items-center justify-content-between">
          <div class="kpi-icon-bubble bubble-green">
            <i class="ti ti-brand-whatsapp"></i>
          </div>
          <span class="kpi-badge kpi-badge-up">Alerts</span>
        </div>
        <div>
          <div class="kpi-stat-value">{{ Auth::user()->wp_count ?? 0 }}</div>
          <p class="kpi-stat-label">WhatsApp Sent</p>
        </div>
      </div>
    </div>
  </div>

  {{-- SECONDARY METRICS RIBBON (6 DEEP-DIVE STORE COUNTS) --}}
  <div class="row g-2 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
      <div class="p-3 bg-white rounded-3 border border-light shadow-sm d-flex align-items-center gap-3">
        <div class="text-primary fs-5"><i class="ti ti-packages"></i></div>
        <div>
          <div class="fw-bolder text-dark fs-5 lh-1">{{ number_format($totalPrizeStock ?? 0) }}</div>
          <small class="text-muted fw-semibold" style="font-size: 11.5px;">Prize Inventory</small>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <div class="p-3 bg-white rounded-3 border border-light shadow-sm d-flex align-items-center gap-3">
        <div class="text-success fs-5"><i class="ti ti-trophy"></i></div>
        <div>
          <div class="fw-bolder text-dark fs-5 lh-1">{{ $prizesClaimed ?? 0 }}</div>
          <small class="text-muted fw-semibold" style="font-size: 11.5px;">Prizes Won</small>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <div class="p-3 bg-white rounded-3 border border-light shadow-sm d-flex align-items-center gap-3">
        <div class="text-info fs-5"><i class="ti ti-receipt"></i></div>
        <div>
          <div class="fw-bolder text-dark fs-5 lh-1">{{ $receiptsUploaded ?? 0 }}</div>
          <small class="text-muted fw-semibold" style="font-size: 11.5px;">Bill Proofs</small>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <div class="p-3 bg-white rounded-3 border border-light shadow-sm d-flex align-items-center gap-3">
        <div class="text-danger fs-5"><i class="ti ti-shield-check"></i></div>
        <div>
          <div class="fw-bolder text-dark fs-5 lh-1">{{ $ipSkipsCount ?? 0 }}</div>
          <small class="text-muted fw-semibold" style="font-size: 11.5px;">Fraud Filters</small>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <div class="p-3 bg-white rounded-3 border border-light shadow-sm d-flex align-items-center gap-3">
        <div class="text-warning fs-5"><i class="ti ti-device-mobile"></i></div>
        <div>
          <div class="fw-bolder text-dark fs-5 lh-1">{{ $uniqueDevices ?? 0 }}</div>
          <small class="text-muted fw-semibold" style="font-size: 11.5px;">Unique Devices</small>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
      <div class="p-3 bg-white rounded-3 border border-light shadow-sm d-flex align-items-center gap-3">
        <div class="text-purple fs-5"><i class="ti ti-clock-play"></i></div>
        <div>
          <div class="fw-bolder text-dark fs-5 lh-1">{{ $spinConversionRate ?? 0 }}%</div>
          <small class="text-muted fw-semibold" style="font-size: 11.5px;">Spins / Visitor</small>
        </div>
      </div>
    </div>
  </div>

  {{-- ROW 2: 3 ANALYTICAL CHARTS (Timeline, Peak Hours, Prize Donut) --}}
  <div class="row g-3 mb-4">
    {{-- Chart 1: Engagement & Velocity (Area Curve) --}}
    <div class="col-lg-6">
      <div class="dash-modern-card h-100">
        <div class="dash-card-header">
          <div>
            <h3 class="dash-card-title">
              <i class="ti ti-chart-area-line text-primary"></i> Engagement & Lead Velocity
            </h3>
            <small class="text-muted">Visits, customer wheel spins, and completed inquiries</small>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="dash-hero-pill pill-blue">Visits</span>
            <span class="dash-hero-pill pill-orange">Spins</span>
            <span class="dash-hero-pill" style="background:rgba(16,185,129,0.15); color:#065f46; border-color:rgba(16,185,129,0.3);">Leads</span>
          </div>
        </div>
        <div class="dash-card-body">
          <div id="engagementTimelineChart" style="min-height: 290px;"></div>
        </div>
      </div>
    </div>

    {{-- Chart 2: Customer Activity by Time of Day (Column Chart) --}}
    <div class="col-lg-3">
      <div class="dash-modern-card h-100">
        <div class="dash-card-header">
          <div>
            <h3 class="dash-card-title">
              <i class="ti ti-clock-hour-4 text-warning"></i> Peak Spin Times
            </h3>
            <small class="text-muted">Customer traffic distribution</small>
          </div>
        </div>
        <div class="dash-card-body">
          <div id="hourlyActivityChart" style="min-height: 290px;"></div>
        </div>
      </div>
    </div>

    {{-- Chart 3: Prize Wheel Slices & Stock Allocation (Donut Chart) --}}
    <div class="col-lg-3">
      <div class="dash-modern-card h-100">
        <div class="dash-card-header">
          <div>
            <h3 class="dash-card-title">
              <i class="ti ti-trophy text-danger"></i> Prize Slices
            </h3>
            <small class="text-muted">Stock & probability ratio</small>
          </div>
          <a href="{{ url('admin/spinner_list') }}" class="btn btn-sm btn-light text-primary rounded-pill px-2" title="Manage Slices">
            <i class="ti ti-adjustments"></i> Edit
          </a>
        </div>
        <div class="dash-card-body d-flex flex-column justify-content-between">
          <div id="prizeDonutChart" style="min-height: 200px;"></div>
          
          <div class="mt-2" style="max-height: 120px; overflow-y: auto;">
            @foreach($spinnerSlices->take(6) as $slice)
            <div class="d-flex align-items-center justify-content-between py-1 border-bottom border-light">
              <div class="d-flex align-items-center gap-2 text-truncate">
                <span class="prize-badge-dot" style="background: {{ $slice->color ?: '#ff6b00' }};"></span>
                <span class="fw-semibold text-dark text-truncate" style="font-size: 12px;">{{ $slice->name }}</span>
              </div>
              <span class="badge bg-light text-dark fw-bold rounded-pill px-2" style="font-size: 11px;">
                Stock: {{ $slice->value ?? '—' }}
              </span>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ROW 3: DETAILED TABLES & RANKINGS --}}
  <div class="row g-3 mb-4">
    {{-- Left: Recent Customer Leads & Winners with WhatsApp Action --}}
    <div class="col-lg-8">
      <div class="dash-modern-card h-100">
        <div class="dash-card-header">
          <div>
            <h3 class="dash-card-title">
              <i class="ti ti-users text-primary"></i> Recent Inquiries & Lucky Winners
            </h3>
            <small class="text-muted">Customer submissions with prize awarded & one-click WhatsApp outreach</small>
          </div>
          <a href="{{ url('admin/spinner_form_camping_list') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
            View All Leads ({{ $SpinnerForm }}) <i class="ti ti-arrow-right ms-1"></i>
          </a>
        </div>

        <!-- Campaign & Date Filter Toolbar -->
        <div class="px-4 py-2 bg-light border-bottom">
          <form action="{{ url('admin/dashboard') }}" method="GET" id="leadFilterForm" class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Campaign Select Filter -->
            <div class="d-flex align-items-center gap-1">
              <span class="text-muted small fw-bold"><i class="ti ti-filter text-primary"></i> Campaign:</span>
              <select name="lead_campaign_id" id="lead_campaign_select" class="form-select form-select-sm rounded-pill shadow-none" style="min-width: 175px; font-size: 12.5px;">
                <option value="">All Campaigns</option>
                @if(isset($allCampaigns))
                  @foreach($allCampaigns as $ac)
                    <option value="{{ $ac->id }}" {{ (isset($leadCampaignId) && $leadCampaignId == $ac->id) ? 'selected' : '' }}>
                      {{ $ac->campaign_name }}
                    </option>
                  @endforeach
                @endif
              </select>
            </div>

            <!-- Date Range Filter -->
            <div class="d-flex align-items-center gap-1">
              <span class="text-muted small fw-bold"><i class="ti ti-calendar text-primary"></i> Date:</span>
              <input type="date" name="lead_start_date" id="lead_start_date" class="form-control form-control-sm rounded-pill shadow-none" style="width: 140px; font-size: 12.5px;" value="{{ $leadStartDate ?? '' }}">
              <span class="text-muted small">to</span>
              <input type="date" name="lead_end_date" id="lead_end_date" class="form-control form-control-sm rounded-pill shadow-none" style="width: 140px; font-size: 12.5px;" value="{{ $leadEndDate ?? '' }}">
            </div>

            <!-- Submit Filter & Reset -->
            <div class="d-flex align-items-center gap-1 ms-auto">
              <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" style="font-size: 12px;">
                <i class="ti ti-search me-1"></i> Filter
              </button>
              @if(!empty($leadCampaignId) || !empty($leadStartDate) || !empty($leadEndDate))
                <a href="{{ url('admin/dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-2 fw-semibold" style="font-size: 12px;" title="Reset Filters">
                  <i class="ti ti-rotate-2"></i> Reset
                </a>
              @endif
            </div>
          </form>
        </div>

        <div class="dash-card-body p-0">
          <div class="table-responsive">
            <table class="table modern-table mb-0" id="recentLeadsTable">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Phone / WhatsApp</th>
                  <th>Prize Won</th>
                  <th>Campaign</th>
                  <th>Proof</th>
                  <th>Date</th>
                  <th class="text-end">Direct Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentLeads as $lead)
                <tr class="lead-row" data-campaign-id="{{ $lead->camping_id }}" data-date="{{ date('Y-m-d', strtotime($lead->created_at)) }}">
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-circle">
                        {{ strtoupper(substr($lead->name ?: 'C', 0, 1)) }}
                      </div>
                      <div>
                        <div class="fw-bold text-dark">{{ $lead->name ?: 'Customer' }}</div>
                        <small class="text-muted">{{ $lead->email ?: 'No email' }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="fw-semibold text-dark">
                      {{ $lead->phone ?: ($lead->whatsapp_number ?: '—') }}
                    </div>
                  </td>
                  <td>
                    @if($lead->prize_name)
                      <span class="badge rounded-pill px-2 py-1 fw-bold text-dark" style="background: {{ $lead->prize_color ?: '#fef08a' }}; border: 1px solid rgba(0,0,0,0.08);">
                        <i class="ti ti-gift me-1"></i> {{ $lead->prize_name }}
                      </span>
                    @else
                      <span class="badge bg-light text-muted px-2 py-1 rounded-pill">Spun Wheel</span>
                    @endif
                  </td>
                  <td>
                    <span class="badge bg-light-primary text-primary px-2 py-1 rounded-pill fw-semibold">
                      {{ $lead->campaign_name ?: 'Default' }}
                    </span>
                  </td>
                  <td>
                    @if($lead->schreenshot)
                      <a href="{{ $lead->schreenshot }}" target="_blank" class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-bold text-decoration-none" title="View Uploaded Receipt">
                        <i class="ti ti-photo me-1"></i> Verified
                      </a>
                    @else
                      <span class="text-muted" style="font-size: 11.5px;">Standard</span>
                    @endif
                  </td>
                  <td>
                    <span class="text-muted" style="font-size: 12px;">
                      {{ date('d M, h:i A', strtotime($lead->created_at)) }}
                    </span>
                  </td>
                  <td class="text-end">
                    @php
                      $targetPhone = preg_replace('/[^0-9]/', '', $lead->whatsapp_number ?: $lead->phone);
                    @endphp
                    @if($targetPhone)
                      <a href="https://wa.me/{{ $targetPhone }}?text=Hello%20{{ urlencode($lead->name ?: 'Customer') }},%20congratulations%20on%20winning%20at%20our%20Prize%20Wheel!" target="_blank" class="btn-whatsapp-chat" title="Chat on WhatsApp">
                        <i class="ti ti-brand-whatsapp"></i> Chat
                      </a>
                    @else
                      <span class="text-muted" style="font-size: 12px;">—</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-5 text-muted">
                    <div class="py-3">
                      <i class="ti ti-confetti fs-8 text-primary mb-2 d-block"></i>
                      <h6>No customer inquiries yet</h6>
                      <p class="small text-muted mb-3">Share your wheel link with customers to start collecting leads!</p>
                      <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" onclick="copyStoreUrl('{{ $storeUrl }}')">
                        <i class="ti ti-copy me-1"></i> Copy Wheel Link
                      </button>
                    </div>
                  </td>
                </tr>
                @endforelse
                <tr id="no_leads_filtered_row" style="display: none;">
                  <td colspan="7" class="text-center py-5 text-muted">
                    <div class="py-2">
                      <i class="ti ti-filter-off fs-7 text-muted mb-2 d-block"></i>
                      <h6 class="text-dark">No inquiries found matching this filter</h6>
                      <p class="small text-muted mb-3">Try choosing a different campaign or wider date range.</p>
                      <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetLeadFilters()">
                        <i class="ti ti-rotate-2 me-1"></i> Reset Filters
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Right: Top Winning Prizes Leaderboard & Stand QR --}}
    <div class="col-lg-4">
      {{-- Card A: Top Winning Prizes Ranking --}}
      <div class="dash-modern-card mb-4">
        <div class="dash-card-header">
          <h3 class="dash-card-title">
            <i class="ti ti-medal text-warning"></i> Most Claimed Prizes
          </h3>
          <span class="badge bg-light text-muted fw-bold">Leaderboard</span>
        </div>
        <div class="dash-card-body p-3">
          @forelse($topWinningPrizesList ?? [] as $prizeRank)
          <div class="mb-3">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <span class="fw-bold text-dark text-truncate" style="font-size: 13.5px;">
                <span class="prize-badge-dot" style="background: {{ $prizeRank['color'] }};"></span>
                {{ $prizeRank['name'] }}
              </span>
              <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill">
                {{ $prizeRank['won_count'] }} Won
              </span>
            </div>
            <div class="progress" style="height: 6px;">
              @php
                $pct = min(100, round(($prizeRank['won_count'] / max(1, $prizesClaimed)) * 100));
              @endphp
              <div class="progress-bar rounded" role="progressbar" style="width: {{ $pct }}%; background: {{ $prizeRank['color'] }};"></div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1">
              <small class="text-muted" style="font-size: 11px;">Win share: {{ $pct }}%</small>
              <small class="text-muted" style="font-size: 11px;">Stock left: {{ $prizeRank['stock'] ?? '—' }}</small>
            </div>
          </div>
          @empty
          <div class="text-center py-3 text-muted">
            <p class="small mb-0">No prize claims recorded yet.</p>
          </div>
          @endforelse
        </div>
      </div>

      {{-- Card B: Customer Stand QR Widget --}}
      <div class="dash-qr-widget">
        <div class="dash-qr-frame">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ urlencode($storeUrl) }}" alt="Wheel QR Code" style="width: 120px; height: 120px; display: block; margin: 0 auto; border-radius: 8px;">
        </div>
        <h5 class="fw-bold text-dark mb-1" style="font-size: 15px;">Customer Spin Stand QR</h5>
        <p class="text-muted small mb-3">Place this QR code at your store counter or checkout table for instant customer spins!</p>
        
        <div class="d-grid gap-2">
          <button type="button" onclick="downloadNormalQr(this)" class="btn btn-dark rounded-3 fw-bold py-2">
            <i class="ti ti-download me-1"></i> Download QR
          </button>
          <a href="{{ url('admin/print_qr_code') }}" target="_blank" class="btn btn-outline-dark rounded-3 fw-bold py-2">
            <i class="ti ti-printer me-1"></i> Print Standee Material
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- ROW 4: COMPREHENSIVE CAMPAIGN PERFORMANCE COMPARISON TABLE --}}
  <div class="dash-modern-card mb-4">
    <div class="dash-card-header">
      <div>
        <h3 class="dash-card-title">
          <i class="ti ti-speakerphone text-primary"></i> Comprehensive Campaign Performance & Status
        </h3>
        <small class="text-muted">Detailed review of all marketing campaigns, duration, spin velocity, and leads captured</small>
      </div>
      <a href="{{ url('admin/add_camping_page') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
        <i class="ti ti-plus me-1"></i> New Campaign
      </a>
    </div>
    <div class="dash-card-body p-0">
      <div class="table-responsive">
        <table class="table modern-table mb-0">
          <thead>
            <tr>
              <th>Campaign Name</th>
              <th>Date Range</th>
              <th>Status</th>
              <th>Total Spin Allocation</th>
              <th>Leads Collected</th>
              <th>Spin Progress</th>
              <th>Wheel Timer</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($allCampaigns ?? [] as $camp)
            <tr>
              <td>
                <div class="fw-bold text-dark">{{ $camp->campaign_name }}</div>
                <small class="text-muted">{{ Str::limit($camp->title ?? '', 35) }}</small>
              </td>
              <td>
                <div class="text-dark fw-semibold" style="font-size: 13px;">
                  <i class="ti ti-calendar me-1 text-muted"></i>
                  {{ date('d M Y', strtotime($camp->start_date)) }} - {{ date('d M Y', strtotime($camp->end_date)) }}
                </div>
              </td>
              <td>
                @if($camp->status == 'active')
                  <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-bold">Active</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill fw-bold">Inactive</span>
                @endif
              </td>
              <td>
                <span class="fw-bold text-dark">{{ number_format($camp->number_of_total_spinn ?? 0) }}</span>
                <small class="text-muted">spins</small>
              </td>
              <td>
                <span class="fw-bolder text-primary fs-4">{{ $camp->form_submitted ?? 0 }}</span>
              </td>
              <td style="min-width: 140px;">
                @php
                  $totSpins = max(1, (int)($camp->number_of_total_spinn ?? 2000));
                  $compPct = min(100, round((($camp->form_submitted ?? 0) / $totSpins) * 100, 1));
                @endphp
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <small class="fw-bold text-dark">{{ $compPct }}%</small>
                  <small class="text-muted">{{ $camp->form_submitted ?? 0 }}/{{ $totSpins }}</small>
                </div>
                <div class="progress" style="height: 5px;">
                  <div class="progress-bar bg-primary rounded" style="width: {{ $compPct }}%;"></div>
                </div>
              </td>
              <td>
                <span class="badge bg-light text-dark fw-semibold px-2 py-1 rounded-pill">
                  <i class="ti ti-clock me-1"></i> {{ $camp->spinner_time ?? 20 }}s
                </span>
              </td>
              <td class="text-end">
                <a href="{{ url('admin/spinner_form_list/' . $camp->id) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3 fw-bold me-1" title="View Inquiries">
                  <i class="ti ti-eye me-1"></i> Leads
                </a>
                <a href="{{ url('admin/edit_camping/' . $camp->id) }}" class="btn btn-sm btn-light text-secondary rounded-pill px-2" title="Edit Campaign">
                  <i class="ti ti-pencil"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4 text-muted">No campaigns created yet.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ROW 5: OPERATIONAL QUICK-ACCESS ACTION BAR --}}
  <div class="card p-3 rounded-4 border border-light shadow-sm mb-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div class="d-flex align-items-center gap-2">
        <i class="ti ti-bolt fs-6 text-warning"></i>
        <span class="fw-bold text-dark">Quick Operational Shortcuts:</span>
      </div>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ url('admin/spinner_form_camping_list') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
          <i class="ti ti-file-download me-1"></i> Export Inquiries PDF
        </a>
        <a href="{{ url('admin/spinner_list') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
          <i class="ti ti-adjustments-horizontal me-1"></i> Configure Slices
        </a>
        <a href="{{ url('admin/ip_skip') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
          <i class="ti ti-shield-lock me-1"></i> IP Fraud Settings
        </a>
        <a href="{{ url('admin/profile') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-bold">
          <i class="ti ti-palette me-1"></i> Wheel Brand Customizer
        </a>
      </div>
    </div>
  </div>
@endif

</div>

{{-- Toast Clipboard Feedback --}}
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

  function downloadNormalQr(btn) {
    const originalText = btn ? btn.innerHTML : '';
    if (btn) {
      btn.innerHTML = '<i class="ti ti-loader fa-spin me-1"></i> Downloading...';
      btn.style.pointerEvents = 'none';
    }

    const qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&margin=20&data={{ urlencode($storeUrl ?? '') }}";
    const filename = "{{ Str::slug(Auth::user()->name ?? 'spin-wheel') }}-qr-code.png";

    fetch(qrUrl)
      .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.blob();
      })
      .then(blob => {
        const blobUrl = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = blobUrl;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        setTimeout(() => window.URL.revokeObjectURL(blobUrl), 1000);
      })
      .catch(err => {
        console.warn('Direct fetch failed, falling back to direct link:', err);
        const fallbackLink = document.createElement('a');
        fallbackLink.href = qrUrl;
        fallbackLink.target = '_blank';
        fallbackLink.download = filename;
        document.body.appendChild(fallbackLink);
        fallbackLink.click();
        document.body.removeChild(fallbackLink);
      })
      .finally(() => {
        if (btn) {
          btn.innerHTML = originalText;
          btn.style.pointerEvents = 'auto';
        }
      });
  }

  document.addEventListener("DOMContentLoaded", function () {
    @if (Auth::user()->type == 'admin')
      // --- Super Admin Growth Chart ---
      const adminGrowthEl = document.querySelector("#adminGrowthChart");
      if (adminGrowthEl && typeof ApexCharts !== 'undefined') {
          const adminStoreNamesByDay = {!! json_encode($adminChartStoreNames ?? []) !!};

          const growthOptions = {
          series: [{
            name: "New Stores Registered",
            data: {!! json_encode($adminChartRegistrations ?? [1, 2, 0, 3, 1, 4, 2]) !!}
          }],
          chart: {
            type: 'area',
            height: 280,
            fontFamily: "inherit",
            toolbar: { show: false }
          },
          colors: ['#ff6b00'],
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.45,
              opacityTo: 0.05,
              stops: [0, 95, 100]
            }
          },
          stroke: {
            curve: 'smooth',
            width: 3
          },
          dataLabels: { enabled: false },
          xaxis: {
            categories: {!! json_encode($adminChartDates ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
            labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
          },
          yaxis: {
            labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
          },
          grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4
          },
          tooltip: {
            theme: 'dark',
            custom: function({series, seriesIndex, dataPointIndex, w}) {
              const count = series[seriesIndex][dataPointIndex];
              const date = w.globals.categoryLabels[dataPointIndex];
              const names = (adminStoreNamesByDay[dataPointIndex] && adminStoreNamesByDay[dataPointIndex].length > 0)
                ? adminStoreNamesByDay[dataPointIndex].join(', ')
                : 'No store registered';
              
              let html = '<div class="p-2.5" style="background: #0f172a; color: #ffffff; border-radius: 10px; font-size: 12px; box-shadow: 0 4px 18px rgba(0,0,0,0.35); min-width: 170px;">';
              html += '<div style="font-weight: 700; color: #94a3b8; font-size: 11px; margin-bottom: 2px;">' + date + '</div>';
              html += '<div style="color: #ff6b00; font-weight: 800; font-size: 13px; margin-bottom: 4px;">' + count + ' ' + (count === 1 ? 'Store' : 'Stores') + ' Registered</div>';
              if (count > 0) {
                html += '<div style="color: #f8fafc; font-weight: 600; font-size: 11.5px; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 4px;"><i class="ti ti-building-store" style="color: #38bdf8; margin-right: 4px;"></i>' + names + '</div>';
              }
              html += '</div>';
              return html;
            }
          }
        };
        new ApexCharts(adminGrowthEl, growthOptions).render();
      }

      // --- Super Admin Status Donut ---
      const adminDonutEl = document.querySelector("#adminStatusDonutChart");
      if (adminDonutEl && typeof ApexCharts !== 'undefined') {
        const donutOptions = {
          series: [{{ $ActiveUsers ?? 1 }}, {{ $InactiveUsers ?? 0 }}, {{ $ExpiredUser ?? 0 }}],
          chart: {
            type: 'donut',
            height: 250,
            fontFamily: "inherit"
          },
          labels: ['Active Stores', 'Inactive', 'Expired'],
          colors: ['#10b981', '#94a3b8', '#ef4444'],
          legend: {
            position: 'bottom',
            fontSize: '12px'
          },
          dataLabels: { enabled: false },
          plotOptions: {
            pie: {
              donut: {
                size: '68%',
                labels: {
                  show: true,
                  total: {
                    show: true,
                    label: 'Total Stores',
                    formatter: () => '{{ $Users ?? 0 }}'
                  }
                }
              }
            }
          }
        };
        new ApexCharts(adminDonutEl, donutOptions).render();
      }

    @else
      // --- Store User Engagement Area Chart ---
      const timelineEl = document.querySelector("#engagementTimelineChart");
      if (timelineEl && typeof ApexCharts !== 'undefined') {
        const timelineOptions = {
          series: [
            {
              name: "Customer Visits",
              data: {!! json_encode($chartVisits ?? [12, 18, 15, 22, 19, 25, 28]) !!}
            },
            {
              name: "Wheel Spins",
              data: {!! json_encode($chartSpins ?? [8, 12, 10, 16, 14, 18, 20]) !!}
            },
            {
              name: "Leads Captured",
              data: {!! json_encode($chartLeads ?? [2, 4, 3, 6, 5, 7, 8]) !!}
            }
          ],
          chart: {
            type: 'area',
            height: 290,
            fontFamily: "inherit",
            toolbar: { show: false }
          },
          colors: ['#2563eb', '#9333ea', '#10b981'],
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.35,
              opacityTo: 0.05,
              stops: [0, 90, 100]
            }
          },
          stroke: {
            curve: 'smooth',
            width: 2.5
          },
          dataLabels: { enabled: false },
          xaxis: {
            categories: {!! json_encode($chartDates ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
            labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
          },
          yaxis: {
            labels: { style: { colors: '#94a3b8', fontSize: '12px' } }
          },
          grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4
          },
          tooltip: {
            theme: 'dark'
          }
        };
        new ApexCharts(timelineEl, timelineOptions).render();
      }

      // --- Peak Customer Activity Column Chart ---
      const hourlyEl = document.querySelector("#hourlyActivityChart");
      if (hourlyEl && typeof ApexCharts !== 'undefined') {
        const hourlyOptions = {
          series: [{
            name: "Spins Triggered",
            data: {!! json_encode($hourlyValues ?? [2, 5, 3, 7, 1]) !!}
          }],
          chart: {
            type: 'bar',
            height: 290,
            fontFamily: "inherit",
            toolbar: { show: false }
          },
          colors: ['#ff8800'],
          plotOptions: {
            bar: {
              borderRadius: 6,
              columnWidth: '42%',
              distributed: false
            }
          },
          dataLabels: { enabled: false },
          xaxis: {
            categories: ['Morning', 'Lunch', 'Afternoon', 'Evening', 'Night'],
            labels: { style: { colors: '#94a3b8', fontSize: '11px' } }
          },
          yaxis: {
            labels: { style: { colors: '#94a3b8', fontSize: '11px' } }
          },
          grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4
          },
          tooltip: {
            theme: 'dark'
          }
        };
        new ApexCharts(hourlyEl, hourlyOptions).render();
      }

      // --- Store User Prize Slices Donut Chart ---
      const prizeDonutEl = document.querySelector("#prizeDonutChart");
      if (prizeDonutEl && typeof ApexCharts !== 'undefined') {
        @php
          $sliceNames = [];
          $sliceValues = [];
          $sliceColors = [];
          $fallbackPalette = ['#ff6b00', '#2563eb', '#10b981', '#9333ea', '#f59e0b', '#06b6d4', '#ec4899', '#84cc16'];
          $idx = 0;
          foreach($spinnerSlices as $s) {
              $sliceNames[] = $s->name ?: 'Prize ' . ($idx + 1);
              $sliceValues[] = max(1, (int)($s->value ?: ($s->chances ?: 10)));
              $sliceColors[] = ($s->color && $s->color != '#ffffff') ? $s->color : $fallbackPalette[$idx % count($fallbackPalette)];
              $idx++;
          }
          if(empty($sliceNames)) {
              $sliceNames = ['Discount 10%', 'Free Gift', 'Try Again', 'Special Voucher'];
              $sliceValues = [30, 20, 40, 10];
              $sliceColors = ['#ff6b00', '#10b981', '#94a3b8', '#2563eb'];
          }
        @endphp

        const prizeDonutOptions = {
          series: {!! json_encode($sliceValues) !!},
          chart: {
            type: 'donut',
            height: 200,
            fontFamily: "inherit"
          },
          labels: {!! json_encode($sliceNames) !!},
          colors: {!! json_encode($sliceColors) !!},
          legend: { show: false },
          dataLabels: { enabled: false },
          plotOptions: {
            pie: {
              donut: {
                size: '72%',
                labels: {
                  show: true,
                  total: {
                    show: true,
                    label: 'Slices',
                    formatter: () => '{{ $Spinner }}'
                  }
                }
              }
            }
          },
          tooltip: {
            theme: 'dark'
          }
        };
        new ApexCharts(prizeDonutEl, prizeDonutOptions).render();
      }
    @endif

    // Client-side live filter for Recent Inquiries
    function applyLeadClientFilters() {
      const selectedCamp = $('#lead_campaign_select').val();
      const startDate = $('#lead_start_date').val();
      const endDate = $('#lead_end_date').val();

      let visibleCount = 0;
      const rows = $('.lead-row');

      if (rows.length === 0) return;

      rows.each(function() {
        const rowCamp = $(this).attr('data-campaign-id');
        const rowDate = $(this).attr('data-date');

        let matchCamp = !selectedCamp || rowCamp === selectedCamp;
        let matchDate = true;
        if (startDate && rowDate && rowDate < startDate) matchDate = false;
        if (endDate && rowDate && rowDate > endDate) matchDate = false;

        if (matchCamp && matchDate) {
          $(this).show();
          visibleCount++;
        } else {
          $(this).hide();
        }
      });

      if (visibleCount === 0) {
        $('#no_leads_filtered_row').show();
      } else {
        $('#no_leads_filtered_row').hide();
      }
    }

    window.resetLeadFilters = function() {
      $('#lead_campaign_select').val('');
      $('#lead_start_date').val('');
      $('#lead_end_date').val('');
      $('.lead-row').show();
      $('#no_leads_filtered_row').hide();
      window.location.href = "{{ url('admin/dashboard') }}";
    };

    $('#lead_campaign_select, #lead_start_date, #lead_end_date').on('change', function() {
      applyLeadClientFilters();
    });
  });
</script>

@endsection