@extends('adminLayouts.home')
@section('content')

<!-- FontAwesome 6 CDN for complete icon reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* ==========================================================================
       Atom UI - Choose Option (Bike Model) Catalogue Styles
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
        flex-wrap: wrap;
    }

    .user-hero-subtitle {
        color: var(--slate-500);
        font-size: 0.92rem;
        line-height: 1.45;
        margin-bottom: 0;
    }

    /* KPI Stat Cards */
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
    }
    .stat-orange::before { background: linear-gradient(90deg, #ff6b00, #ea580c); }
    .stat-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .stat-bubble-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-bubble-icon i { font-size: 24px; line-height: 1; }
    .bubble-orange { background: #fff7ed; color: #ea580c; }
    .bubble-emerald { background: #ecfdf5; color: #059669; }
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

    /* Filter Toolbar */
    .filter-panel-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
    }

    /* Card Grid */
    .option-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .option-item-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        position: relative;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.03);
    }
    .option-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }

    .option-avatar-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--primary-orange);
    }

    .option-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--slate-900);
        margin: 12px 0 4px 0;
        word-break: break-word;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .pill-active { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .pill-inactive { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    .action-btn-circle {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: var(--slate-700);
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .action-btn-circle:hover {
        background: var(--slate-900);
        color: #ffffff;
        border-color: var(--slate-900);
    }
    .action-btn-delete:hover {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
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
                    <i class="ti ti-motorbike me-1"></i> Form Customization &bull; Dropdown Catalog
                </span>
                <h1 class="user-hero-title">
                    Choose Option (Model) Catalog
                    <span class="badge badge-light border text-muted ml-2" style="font-size: 0.78rem; font-weight: 600;">
                        {{ $bike->count() }} {{ Str::plural('Option', $bike->count()) }}
                    </span>
                </h1>
                <p class="user-hero-subtitle">
                    Manage the selectable vehicle / product models available in customer wheel enquiry forms.
                </p>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ URL::to('admin/form_access') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-adjustments me-1"></i> Form Fields Access
                </a>
                <a href="{{ URL::to('admin/add_bike_page') }}" class="btn btn-primary btn-sm rounded-pill px-3 py-2 font-weight-bold shadow-sm" style="background: var(--primary-orange); border-color: var(--primary-orange);">
                    <i class="ti ti-plus me-1"></i> Add New Option
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         KPI STAT CARDS
         ======================================================================== -->
    @php
        $totalCount = $bike->count();
        $activeCount = $bike->where('status', 'active')->count();
        $inactiveCount = $bike->where('status', 'inactive')->count();
    @endphp
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="user-stat-card stat-orange">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Total Options</span>
                    <div class="stat-bubble-icon bubble-orange">
                        <i class="ti ti-list-details"></i>
                    </div>
                </div>
                <div class="stat-val-num">{{ $totalCount }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Configured model options</div>
            </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
            <div class="user-stat-card stat-emerald">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Active in Forms</span>
                    <div class="stat-bubble-icon bubble-emerald">
                        <i class="ti ti-circle-check"></i>
                    </div>
                </div>
                <div class="stat-val-num text-success">{{ $activeCount }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Visible to customers</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="user-stat-card stat-purple">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Inactive Options</span>
                    <div class="stat-bubble-icon bubble-purple">
                        <i class="ti ti-circle-minus"></i>
                    </div>
                </div>
                <div class="stat-val-num" style="color: #7c3aed;">{{ $inactiveCount }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Hidden from dropdowns</div>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         SEARCH & FILTER TOOLBAR
         ======================================================================== -->
    <div class="filter-panel-card">
        <form action="{{ URL::to('admin/bike_model') }}" method="POST">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">Start Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" 
                           value="{{ !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : '' }}">
                </div>

                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">End Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" 
                           value="{{ !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : '' }}">
                </div>

                <div class="col-md-4 text-md-right">
                    <button type="submit" class="btn btn-dark btn-sm font-weight-bold px-3">
                        <i class="ti ti-filter me-1"></i> Filter
                    </button>
                    <a href="{{ URL::to('admin/bike_model') }}" class="btn btn-outline-secondary btn-sm ml-1" title="Reset Filters">
                        <i class="ti ti-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================================================
         CARD GRID VIEW
         ======================================================================== -->
    <form action="{{ URL::to('admin/downloadBikePdf') }}" method="POST" id="bikePdfForm">
        @csrf

        @if($bike->count() > 0)
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="select_all_bikes">
                    <label class="custom-control-label font-weight-bold text-dark" for="select_all_bikes" style="font-size: 0.85rem; cursor: pointer;">
                        Select All for PDF Download
                    </label>
                </div>
                <button type="submit" class="btn btn-outline-danger btn-sm font-weight-bold rounded-pill px-3">
                    <i class="ti ti-file-text me-1"></i> Download PDF
                </button>
            </div>

            <div class="option-grid-container">
                @foreach ($bike as $key => $item)
                    <div class="option-item-card">
                        <div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="checkbox" name="checkbox[]" class="checkbox bike-chk" value="{{ $item->id }}">
                                    <span class="badge badge-light border text-muted font-weight-bold" style="font-size: 0.72rem;">
                                        #{{ $item->id }}
                                    </span>
                                </div>

                                @if($item->status == 'active')
                                    <span class="status-pill pill-active">
                                        <i class="ti ti-check" style="font-size: 10px;"></i> Active
                                    </span>
                                @else
                                    <span class="status-pill pill-inactive">
                                        <i class="ti ti-x" style="font-size: 10px;"></i> Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-3 mt-3">
                                <div class="option-avatar-icon">
                                    <i class="ti ti-motorbike"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="option-title text-truncate">{{ $item->name }}</div>
                                    <div class="text-muted" style="font-size: 0.74rem;">
                                        Added {{ date('d M Y', strtotime($item->created_at)) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top">
                            <span class="text-muted" style="font-size: 0.72rem;">Model Item #{{ $key + 1 }}</span>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ URL::to('admin/edit_bike/'.$item->id) }}" class="action-btn-circle" title="Edit Option">
                                    <i class="ti ti-edit"></i>
                                </a>
                                <a href="{{ URL::to('admin/delete_bike/'.$item->id) }}" onclick="dataDelete(event)" class="action-btn-circle action-btn-delete" title="Delete Option">
                                    <i class="ti ti-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card text-center p-5 border-0 shadow-sm" style="border-radius: 20px;">
                <div class="my-4">
                    <i class="ti ti-motorbike text-muted" style="font-size: 48px; opacity: 0.3;"></i>
                </div>
                <h4 class="font-weight-bold text-dark">No Options Found</h4>
                <p class="text-muted">No choose options / models are registered yet.</p>
                <div>
                    <a href="{{ URL::to('admin/add_bike_page') }}" class="btn btn-dark btn-sm rounded-pill px-4">
                        <i class="ti ti-plus me-1"></i> Add First Option
                    </a>
                </div>
            </div>
        @endif
    </form>
</div>

@endsection

@section('js')
<script>
    $('#select_all_bikes').on('change', function() {
        var isChecked = this.checked;
        $('.bike-chk').prop('checked', isChecked);
    });

    $('.bike-chk').on('change', function() {
        var allChecked = $('.bike-chk').length > 0 && $('.bike-chk:checked').length === $('.bike-chk').length;
        $('#select_all_bikes').prop('checked', allChecked);
    });
</script>
@endsection