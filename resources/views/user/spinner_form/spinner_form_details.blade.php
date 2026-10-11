<div class="p-3">
    <!-- Header Strip -->
    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
        <div style="width: 50px; height: 50px; border-radius: 14px; background: linear-gradient(135deg, #ff6b00, #ea580c); color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800;">
            {{ strtoupper(substr($SpinnerForm->name ?? 'C', 0, 1)) }}
        </div>
        <div class="overflow-hidden">
            <h5 class="font-weight-bold text-dark mb-0">{{ $SpinnerForm->name ?? 'Anonymous Customer' }}</h5>
            <div class="text-muted" style="font-size: 0.8rem;">
                Enquiry #{{ $SpinnerForm->id }} &bull; {{ date('d M Y, h:i A', strtotime($SpinnerForm->created_at)) }}
            </div>
        </div>
    </div>

    <!-- Data Spec Grid -->
    <div class="row mb-3">
        <!-- Prize Won -->
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-trophy text-warning me-1"></i> Prize Result / Slice Won
                </span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 0.95rem;">
                    @if(!empty($SpinnerForm->spinner_name))
                        <span class="badge badge-warning text-dark px-2 py-1 font-weight-bold">
                            {{ $SpinnerForm->spinner_name }}
                        </span>
                    @else
                        <span class="text-muted">No Prize / Slices Deleted</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Interested Model -->
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-motorbike text-primary me-1"></i> Interested Model / Option
                </span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 0.95rem;">
                    {{ $SpinnerForm->bike_name ?? 'None Selected' }}
                </div>
            </div>
        </div>

        <!-- Phone Number -->
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-phone text-success me-1"></i> Primary Phone
                </span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 0.95rem;">
                    <a href="tel:{{ $SpinnerForm->phone }}" class="text-dark">{{ $SpinnerForm->phone ?? 'N/A' }}</a>
                </div>
            </div>
        </div>

        <!-- WhatsApp Number -->
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-brand-whatsapp text-success me-1"></i> WhatsApp Contact
                </span>
                <div class="mt-1 d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                        {{ $SpinnerForm->whatsapp_number ?? 'N/A' }}
                    </span>
                    @if(!empty($SpinnerForm->whatsapp_number))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $SpinnerForm->whatsapp_number) }}" target="_blank" class="btn btn-success btn-sm py-0 px-2 rounded-pill font-weight-bold" style="font-size: 0.72rem;">
                            <i class="ti ti-brand-whatsapp"></i> Chat
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-mail text-info me-1"></i> Email Address
                </span>
                <div class="font-weight-bold text-dark mt-1 text-truncate" style="font-size: 0.95rem;">
                    {{ $SpinnerForm->email ?? 'N/A' }}
                </div>
            </div>
        </div>

        <!-- IP / Mac -->
        <div class="col-md-6 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-network text-secondary me-1"></i> Device IP Address
                </span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 0.95rem; font-family: monospace;">
                    {{ $SpinnerForm->mac_address ?? 'N/A' }}
                </div>
            </div>
        </div>

        @if(!empty($SpinnerForm->address))
        <!-- Address -->
        <div class="col-12 mb-3">
            <div class="p-3 bg-light rounded-12 border">
                <span class="text-muted font-weight-bold" style="font-size: 0.72rem; text-transform: uppercase;">
                    <i class="ti ti-map-pin text-danger me-1"></i> Delivery / Home Address
                </span>
                <div class="font-weight-bold text-dark mt-1" style="font-size: 0.9rem;">
                    {{ $SpinnerForm->address }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Screenshot / Receipt Proof -->
    @if(!empty($SpinnerForm->schreenshot))
        <div class="card p-3 border rounded-15 bg-white mb-2">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold text-dark" style="font-size: 0.88rem;">
                    <i class="ti ti-file-certificate text-primary me-1"></i> Attached Customer Bill / Proof
                </span>
                <a href="{{ $SpinnerForm->schreenshot }}" download="{{ $SpinnerForm->name ?? 'receipt' }}" class="btn btn-outline-primary btn-sm rounded-pill font-weight-bold px-3">
                    <i class="ti ti-download me-1"></i> Download File
                </a>
            </div>
            <div class="text-center p-2 bg-light rounded-12">
                <a href="{{ $SpinnerForm->schreenshot }}" target="_blank">
                    <img src="{{ $SpinnerForm->schreenshot }}" alt="Proof" class="img-fluid rounded border shadow-sm" style="max-height: 260px; object-fit: contain;">
                </a>
            </div>
        </div>
    @endif
</div>