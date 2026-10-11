@extends('adminLayouts.home')
@section('content')

<!-- FontAwesome 6 CDN for complete icon reliability -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    /* ==========================================================================
       Atom UI - Campaign Leads & Enquiry Registry Styles
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
    .stat-emerald::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
    .stat-blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
    .stat-orange::before { background: linear-gradient(90deg, #ff6b00, #ea580c); }

    .stat-bubble-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-bubble-icon i { font-size: 24px; line-height: 1; }
    .bubble-emerald { background: #ecfdf5; color: #059669; }
    .bubble-purple { background: #faf5ff; color: #7c3aed; }
    .bubble-blue { background: #eff6ff; color: #2563eb; }
    .bubble-orange { background: #fff7ed; color: #ea580c; }

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

    /* Table Container */
    .user-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .table-toolbar-strip {
        padding: 16px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table thead th {
        background: #f8fafc;
        color: var(--slate-700);
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e2e8f0;
        padding: 14px 16px;
    }
    .table tbody td {
        vertical-align: middle;
        padding: 14px 16px;
        border-color: #f1f5f9;
        font-size: 0.88rem;
    }
    .table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .customer-avatar-mini {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .action-btn-circle {
        width: 32px;
        height: 32px;
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

    /* Modal Styling */
    .atom-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
        padding: 18px 24px;
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
                    <i class="ti ti-users me-1"></i> Customer Enquiries &bull; Lead Registry
                </span>
                <h1 class="user-hero-title">
                    {{ isset($camping) ? $camping->campaign_name : 'Campaign' }} Leads
                    <span class="badge badge-light border text-muted ml-2" style="font-size: 0.78rem; font-weight: 600;">
                        {{ $SpinnerForm->count() }} {{ Str::plural('Entry', $SpinnerForm->count()) }}
                    </span>
                    @if(isset($camping))
                        <span class="badge badge-warning text-dark ml-1" style="font-size: 0.74rem;">
                            ID #{{ $camping->id }}
                        </span>
                    @endif
                </h1>
                <p class="user-hero-subtitle">
                    @if(isset($camping) && isset($camping->user))
                        Store: <strong>{{ $camping->user->name }}</strong> ({{ $camping->user->email }}) &bull;
                        Timeline: {{ date('d M Y', strtotime($camping->start_date)) }} - {{ date('d M Y', strtotime($camping->end_date)) }}
                    @else
                        Direct customer submissions collected via the prize wheel enquiry dialog.
                    @endif
                </p>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 mt-md-0">
                <a href="{{ URL::to('admin/spinner_form_camping_list') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 font-weight-bold">
                    <i class="ti ti-arrow-left me-1"></i> Back to Campaign List
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         TOP 4 KPI SUMMARY STAT CARDS
         ======================================================================== -->
    <div class="row mb-4">
        <!-- 1. Total Leads -->
        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-emerald">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Captured Leads</span>
                    <div class="stat-bubble-icon bubble-emerald">
                        <i class="ti ti-users"></i>
                    </div>
                </div>
                <div class="stat-val-num text-success">{{ number_format($totalLeads ?? $SpinnerForm->count()) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Total enquiries submitted</div>
            </div>
        </div>

        <!-- 2. Prizes Won -->
        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-purple">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Prizes Unlocked</span>
                    <div class="stat-bubble-icon bubble-purple">
                        <i class="ti ti-trophy"></i>
                    </div>
                </div>
                <div class="stat-val-num" style="color: #7c3aed;">{{ number_format($totalWinners ?? 0) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Awarded wheel slices</div>
            </div>
        </div>

        <!-- 3. Attached Proofs -->
        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-blue">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">Attached Proofs</span>
                    <div class="stat-bubble-icon bubble-blue">
                        <i class="ti ti-receipt"></i>
                    </div>
                </div>
                <div class="stat-val-num text-primary">{{ number_format($totalProofs ?? 0) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Receipts &amp; bill uploads</div>
            </div>
        </div>

        <!-- 4. WhatsApp Numbers -->
        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="user-stat-card stat-orange">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="stat-val-label">WhatsApp Contacts</span>
                    <div class="stat-bubble-icon bubble-orange">
                        <i class="ti ti-brand-whatsapp"></i>
                    </div>
                </div>
                <div class="stat-val-num text-warning">{{ number_format($totalWhatsapp ?? 0) }}</div>
                <div class="text-muted font-weight-bold" style="font-size: 0.76rem;">Ready for direct chat</div>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         SEARCH & FILTER TOOLBAR
         ======================================================================== -->
    <div class="filter-panel-card">
        <form action="{{ URL::to('admin/spinner_form_list/'.$id) }}" method="POST">
            @csrf
            <div class="row align-items-end">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">Search Customer</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="ti ti-search text-muted"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0" 
                               placeholder="Name, phone, whatsapp, email..." value="{{ $search ?? '' }}">
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">From Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" 
                           value="{{ !empty($start_date) ? date('Y-m-d', strtotime($start_date)) : '' }}">
                </div>

                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <label class="font-weight-bold text-muted" style="font-size: 0.78rem;">To Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" 
                           value="{{ !empty($end_date) ? date('Y-m-d', strtotime($end_date)) : '' }}">
                </div>

                <div class="col-md-2 text-md-right">
                    <button type="submit" class="btn btn-dark btn-sm font-weight-bold px-3">
                        <i class="ti ti-filter me-1"></i> Filter
                    </button>
                    <a href="{{ URL::to('admin/spinner_form_list/'.$id) }}" class="btn btn-outline-secondary btn-sm ml-1" title="Reset Filters">
                        <i class="ti ti-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- ========================================================================
         LEADS TABLE REGISTRY
         ======================================================================== -->
    <form action="{{ URL::to('admin/downloadSpinnerFormListPdf') }}" method="POST" id="leadsPdfForm">
        @csrf
        <input type="hidden" name="campaign_id" value="{{ $id }}">

        <div class="user-table-card">
            <div class="table-toolbar-strip">
                <div class="d-flex align-items-center gap-2">
                    <div class="custom-control custom-checkbox mr-2">
                        <input type="checkbox" class="custom-control-input" id="select_all">
                        <label class="custom-control-label font-weight-bold text-dark" for="select_all" style="font-size: 0.85rem; cursor: pointer;">
                            Select All Leads
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-info btn-sm font-weight-bold rounded-pill px-3">
                        <i class="ti ti-file-text me-1"></i> Download Selected PDF
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="zero_config" class="table table-hover mb-0 text-nowrap">
                    <thead>
                        <tr>
                            <th width="40" class="text-center">#</th>
                            <th>Sl.</th>
                            <th>Customer Profile</th>
                            <th>WhatsApp</th>
                            <th>Prize Won</th>
                            <th>Interested Model</th>
                            <th class="text-center">Proof / Bill</th>
                            <th>Timestamp</th>
                            <th>Device IP</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($SpinnerForm as $key => $item)
                            <tr>
                                <td class="text-center">
                                    <input name="checkbox[]" class="checkbox lead-chk" type="checkbox" value="{{ $item->id }}">
                                </td>
                                <td class="font-weight-bold text-muted">{{ $key + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="customer-avatar-mini">
                                            {{ strtoupper(substr($item->name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark" style="font-size: 0.92rem;">
                                                {{ $item->name ?? 'Anonymous' }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.76rem;">
                                                <i class="ti ti-phone text-muted me-1"></i>
                                                <a href="tel:{{ $item->phone }}" class="text-muted">{{ $item->phone }}</a>
                                                @if(!empty($item->email))
                                                    &bull; <a href="mailto:{{ $item->email }}" class="text-muted">{{ Str::limit($item->email, 20) }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if(!empty($item->whatsapp_number))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->whatsapp_number) }}" target="_blank" class="badge badge-success px-2 py-1 font-weight-bold" style="font-size: 0.74rem; text-decoration: none;">
                                            <i class="ti ti-brand-whatsapp me-1"></i> {{ $item->whatsapp_number }}
                                        </a>
                                    @else
                                        <span class="text-muted font-italic" style="font-size: 0.75rem;">Not Provided</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($item->spinner_name))
                                        <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold" style="font-size: 0.78rem;">
                                            <i class="ti ti-trophy me-1"></i> {{ $item->spinner_name }}
                                        </span>
                                    @else
                                        <span class="badge badge-light border text-danger" style="font-size: 0.74rem;">Slice Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($item->bike_name))
                                        <span class="badge badge-light border text-dark font-weight-bold" style="font-size: 0.76rem;">
                                            <i class="ti ti-motorbike text-primary me-1"></i> {{ $item->bike_name }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 0.78rem;">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(!empty($item->schreenshot))
                                        <div class="d-inline-flex flex-column align-items-center">
                                            <a href="{{ $item->schreenshot }}" target="_blank">
                                                <img src="{{ $item->schreenshot }}" alt="Proof" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px;" class="border shadow-sm">
                                            </a>
                                            <a href="{{ $item->schreenshot }}" download="{{ $item->name ?? 'proof' }}" class="text-primary font-weight-bold mt-1" style="font-size: 0.7rem;">
                                                <i class="ti ti-download"></i> Save
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 0.75rem;">No File</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-dark font-weight-bold" style="font-size: 0.8rem;">
                                        {{ date('d M Y', strtotime($item->created_at)) }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.72rem;">
                                        {{ date('h:i A', strtotime($item->created_at)) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-family: monospace; font-size: 0.75rem;">
                                        {{ Str::limit($item->mac_address ?? 'N/A', 14) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="action-btn-circle" onclick="spinner_form_details('{{ $item->id }}')" title="Quick Customer Overview">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <a href="{{ URL::to('admin/delete_spinner_form_list/'.$item->id) }}" onclick="dataDelete(event)" class="action-btn-circle action-btn-delete" title="Delete Enquiry">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<!-- ============================================================================
     ATOM UI CUSTOMER OVERVIEW MODAL
     ============================================================================ -->
<div class="modal fade" id="add_spinner_modal" tabindex="-1" role="dialog" aria-labelledby="modalLeadDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="atom-modal-header d-flex align-items-center justify-content-between">
                <div>
                    <span class="badge badge-warning text-dark font-weight-bold mr-2">LEAD DOSSIER</span>
                    <span class="font-weight-bold" style="font-size: 1.05rem;">Customer Lead Details</span>
                </div>
                <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close" onclick="hide_modal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 spinner_body">
                <!-- Loaded dynamically via AJAX -->
            </div>
            <div class="modal-footer bg-light border-top-0 d-flex justify-content-end p-3">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4" data-dismiss="modal" onclick="hide_modal()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    function spinner_form_details(id) {
        $.ajax({
            type: "GET",
            url: "{{ URL::to('admin/spinner_form_details/') }}/" + id,
            success: function(data) {
                $('.spinner_body').html(data);
                $('#add_spinner_modal').modal('show');
            },
            error: function(err) {
                console.error(err);
            }
        });
    }

    function hide_modal() {
        $('#add_spinner_modal').modal('hide');
    }

    $('#select_all').on('click', function() {
        var isChecked = this.checked;
        $('.lead-chk').prop('checked', isChecked);
    });

    if ($('#zero_config').length) {
        $('#zero_config').DataTable({
            dom: 'Bfrtip',
            pageLength: 25,
            order: [[ 1, 'asc' ]],
            buttons: [
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    title: 'Campaign Captured Leads Registry'
                },
                'copy', 'excel', 'print'
            ]
        });
    }
</script>
@endsection