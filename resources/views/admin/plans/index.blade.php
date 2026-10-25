@extends('adminLayouts.home')
@section('content')

<div class="container-fluid">

  <!-- Header Banner -->
  <div class="card border-0 rounded-4 shadow-sm mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff;">
    <div class="card-body p-4 p-md-5">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
          <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
            <span class="badge rounded-pill px-3 py-2 text-uppercase fw-bold" style="background: rgba(255, 107, 0, 0.2); color: #ff8a3d; border: 1px solid rgba(255, 107, 0, 0.3); font-size: 11px; letter-spacing: 0.5px;">
              <i class="ti ti-crown me-1"></i> Admin Plan Studio
            </span>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(255, 255, 255, 0.1); color: #cbd5e1; font-size: 11px;">
              <i class="ti ti-building-store me-1"></i> Subscribed Stores: {{ $totalSubscribedUsers }}
            </span>
          </div>
          <h2 class="fw-bold mb-2 text-white" style="letter-spacing: -0.5px;">Subscription Plans & Access Management</h2>
          <p class="mb-0 text-slate-300" style="color: #94a3b8; max-width: 720px; font-size: 14px; line-height: 1.6;">
            Create and customize subscription tiers for your retail clients. Define duration, spin wheel rounds, campaign limits, feature toggles, and pricing.
          </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <a href="{{ url('admin/razorpay_settings') }}" class="btn btn-outline-light rounded-pill px-3 py-2 fw-semibold">
            <i class="ti ti-credit-card me-1"></i> Razorpay Gateway
          </a>
          <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" style="background: #ff6b00; border-color: #ff6b00;" data-bs-toggle="modal" data-bs-target="#createPlanModal">
            <i class="ti ti-plus me-1"></i> Create New Plan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Plan Cards Grid -->
  <div class="row g-4">
    @forelse($plans as $plan)
      <div class="col-lg-4 col-md-6">
        <div class="card h-100 border-0 rounded-4 shadow-sm position-relative overflow-hidden transition-all hover-shadow" style="border: 2px solid {{ $plan->is_popular ? '#ff6b00' : '#e2e8f0' }} !important; background: #ffffff;">
          
          @if($plan->is_popular)
            <div class="position-absolute top-0 end-0 py-1 px-4 text-white text-uppercase fw-bold" style="background: #ff6b00; font-size: 10px; letter-spacing: 1px; border-bottom-left-radius: 12px;">
              ★ Most Popular
            </div>
          @endif

          <div class="card-body p-4 d-flex flex-column">
            
            <!-- Plan Header -->
            <div class="d-flex align-items-start justify-content-between mb-3">
              <div>
                <span class="badge rounded-pill px-3 py-1 mb-2 fw-semibold {{ $plan->status === 'active' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                  {{ ucfirst($plan->status) }}
                </span>
                <h4 class="fw-bold mb-1 text-dark">{{ $plan->name }}</h4>
                <p class="text-muted small mb-0">{{ $plan->description ?: 'Subscription package for digital prize wheel stores' }}</p>
              </div>
            </div>

            <!-- Price & Validity -->
            <div class="p-3 rounded-3 mb-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
              <div class="d-flex align-items-baseline gap-1">
                <span class="fs-4 fw-bold text-dark">₹</span>
                <span class="display-6 fw-extrabold text-dark" style="letter-spacing: -1px;">{{ number_format($plan->price, 0) }}</span>
                <span class="text-muted fw-semibold small">/ {{ $plan->duration_days }} Days</span>
              </div>
              <div class="mt-2 pt-2 border-top d-flex justify-content-between small text-muted">
                <span>Active Stores on Plan:</span>
                <span class="fw-bold text-dark">{{ $plan->users_count }}</span>
              </div>
            </div>

            <!-- Feature Entitlements -->
            <div class="mb-4 flex-grow-1">
              <h6 class="text-uppercase fw-bold text-muted small mb-3" style="font-size: 11px; letter-spacing: 0.5px;">Plan Entitlements:</h6>
              <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                
                <li class="d-flex align-items-center gap-2">
                  <i class="ti ti-circle-check-filled text-success fs-5"></i>
                  <span><strong>{{ $plan->spin_rounds_limit === -1 ? 'Unlimited' : number_format($plan->spin_rounds_limit) }}</strong> Wheel Spins</span>
                </li>

                <li class="d-flex align-items-center gap-2">
                  <i class="ti ti-circle-check-filled text-success fs-5"></i>
                  <span><strong>{{ $plan->campaigns_limit === -1 ? 'Unlimited' : $plan->campaigns_limit }}</strong> Active Campaigns</span>
                </li>

                <li class="d-flex align-items-center gap-2">
                  @if($plan->has_whatsapp)
                    <i class="ti ti-circle-check-filled text-success fs-5"></i>
                    <span>WhatsApp Automation & Alerts</span>
                  @else
                    <i class="ti ti-circle-x text-muted fs-5"></i>
                    <span class="text-muted text-decoration-line-through">WhatsApp Automation</span>
                  @endif
                </li>

                <li class="d-flex align-items-center gap-2">
                  @if($plan->has_ip_skip)
                    <i class="ti ti-circle-check-filled text-success fs-5"></i>
                    <span>IP Fraud / Repeat Spin Protection</span>
                  @else
                    <i class="ti ti-circle-x text-muted fs-5"></i>
                    <span class="text-muted text-decoration-line-through">IP Skip Protection</span>
                  @endif
                </li>

                <li class="d-flex align-items-center gap-2">
                  @if($plan->has_custom_branding)
                    <i class="ti ti-circle-check-filled text-success fs-5"></i>
                    <span>Custom Logo & Background Branding</span>
                  @else
                    <i class="ti ti-circle-x text-muted fs-5"></i>
                    <span class="text-muted text-decoration-line-through">Custom Branding</span>
                  @endif
                </li>

                @if(!empty($plan->features_list))
                  @foreach(explode("\n", $plan->features_list) as $feat)
                    @if(trim($feat))
                      <li class="d-flex align-items-center gap-2">
                        <i class="ti ti-circle-check-filled text-primary fs-5"></i>
                        <span>{{ trim($feat) }}</span>
                      </li>
                    @endif
                  @endforeach
                @endif
              </ul>
            </div>

            <!-- Card Actions -->
            <div class="pt-3 border-top d-flex align-items-center justify-content-between gap-2">
              <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold" onclick="togglePlanStatus({{ $plan->id }})">
                <i class="ti ti-power me-1"></i> {{ $plan->status === 'active' ? 'Deactivate' : 'Activate' }}
              </button>
              <div class="d-flex align-items-center gap-1">
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 fw-semibold text-primary" data-bs-toggle="modal" data-bs-target="#editPlanModal{{ $plan->id }}">
                  <i class="ti ti-edit me-1"></i> Edit
                </button>
                <a href="{{ url('admin/plans/delete/' . $plan->id) }}" class="btn btn-sm btn-light border rounded-pill px-2 text-danger" onclick="return confirm('Are you sure you want to delete plan {{ $plan->name }}?')">
                  <i class="ti ti-trash"></i>
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Edit Plan Modal -->
      <div class="modal fade" id="editPlanModal{{ $plan->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom p-4">
              <h5 class="modal-title fw-bold">Edit Plan: {{ $plan->name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/plans/update/' . $plan->id) }}" method="POST">
              @csrf
              <div class="modal-body p-4">
                <div class="row g-3">
                  <div class="col-md-8">
                    <label class="form-label fw-bold small">Plan Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-bold small">Price (INR ₹) *</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $plan->price }}" required>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-bold small">Short Description</label>
                    <input type="text" name="description" class="form-control" value="{{ $plan->description }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-bold small">Duration (Days) *</label>
                    <input type="number" name="duration_days" class="form-control" value="{{ $plan->duration_days }}" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-bold small">Spin Rounds (-1 for Unlimited) *</label>
                    <input type="number" name="spin_rounds_limit" class="form-control" value="{{ $plan->spin_rounds_limit }}" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-bold small">Campaigns Limit (-1 for Unlimited) *</label>
                    <input type="number" name="campaigns_limit" class="form-control" value="{{ $plan->campaigns_limit }}" required>
                  </div>

                  <div class="col-12 mt-3">
                    <label class="form-label fw-bold small">Feature Access Toggles</label>
                    <div class="d-flex flex-wrap gap-4 p-3 rounded-3 bg-light border">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="has_ip_skip" id="ip_skip_{{ $plan->id }}" {{ $plan->has_ip_skip ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="ip_skip_{{ $plan->id }}">IP Skip Protection</label>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="has_whatsapp" id="whatsapp_{{ $plan->id }}" {{ $plan->has_whatsapp ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="whatsapp_{{ $plan->id }}">WhatsApp Alerts</label>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="has_custom_branding" id="branding_{{ $plan->id }}" {{ $plan->has_custom_branding ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="branding_{{ $plan->id }}">Custom Branding</label>
                      </div>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_popular" id="pop_{{ $plan->id }}" {{ $plan->is_popular ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="pop_{{ $plan->id }}">Badge as 'Most Popular'</label>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-bold small">Additional Features / Bullet Points (one per line)</label>
                    <textarea name="features_list" class="form-control" rows="3">{{ $plan->features_list }}</textarea>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label fw-bold small">Status</label>
                    <select name="status" class="form-select">
                      <option value="active" {{ $plan->status === 'active' ? 'selected' : '' }}>Active (Available for Users)</option>
                      <option value="inactive" {{ $plan->status === 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer border-top p-3">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #ff6b00; border-color: #ff6b00;">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    @empty
      <div class="col-12">
        <div class="card border-0 rounded-4 shadow-sm text-center py-5">
          <div class="card-body">
            <i class="ti ti-packages text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">No Subscription Plans Found</h4>
            <p class="text-muted">Create your first pricing plan so your stores can subscribe and renew via Razorpay.</p>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-2 mt-2" style="background: #ff6b00; border-color: #ff6b00;" data-bs-toggle="modal" data-bs-target="#createPlanModal">
              <i class="ti ti-plus me-1"></i> Create Plan Now
            </button>
          </div>
        </div>
      </div>
    @endforelse
  </div>

</div>

<!-- Create Plan Modal -->
<div class="modal fade" id="createPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom p-4">
        <h5 class="modal-title fw-bold"><i class="ti ti-sparkles text-primary me-2"></i>Create New Subscription Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url('admin/plans/store') }}" method="POST">
        @csrf
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-bold small">Plan Name *</label>
              <input type="text" name="name" class="form-control" placeholder="e.g. Starter 30-Days, Pro Quarterly" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold small">Price (INR ₹) *</label>
              <input type="number" step="0.01" name="price" class="form-control" placeholder="999.00" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-bold small">Short Description</label>
              <input type="text" name="description" class="form-control" placeholder="Brief subtitle for the plan">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold small">Duration (Days) *</label>
              <input type="number" name="duration_days" class="form-control" value="30" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold small">Spin Rounds (-1 for Unlimited) *</label>
              <input type="number" name="spin_rounds_limit" class="form-control" value="500" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold small">Campaigns Limit (-1 for Unlimited) *</label>
              <input type="number" name="campaigns_limit" class="form-control" value="2" required>
            </div>

            <div class="col-12 mt-3">
              <label class="form-label fw-bold small">Feature Access Toggles</label>
              <div class="d-flex flex-wrap gap-4 p-3 rounded-3 bg-light border">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="has_ip_skip" id="new_ip_skip" checked>
                  <label class="form-check-label fw-semibold" for="new_ip_skip">IP Skip Protection</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="has_whatsapp" id="new_whatsapp" checked>
                  <label class="form-check-label fw-semibold" for="new_whatsapp">WhatsApp Alerts</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="has_custom_branding" id="new_branding" checked>
                  <label class="form-check-label fw-semibold" for="new_branding">Custom Branding</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="is_popular" id="new_popular">
                  <label class="form-check-label fw-semibold" for="new_popular">Badge as 'Most Popular'</label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold small">Additional Features / Bullet Points (one per line)</label>
              <textarea name="features_list" class="form-control" rows="3" placeholder="Google Review Booster&#10;CSV Customer Export&#10;Priority Tech Support"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold small">Status</label>
              <select name="status" class="form-select">
                <option value="active" selected>Active (Available for Users)</option>
                <option value="inactive">Inactive (Hidden)</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top p-3">
          <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #ff6b00; border-color: #ff6b00;">Create Plan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function togglePlanStatus(planId) {
  fetch("{{ url('admin/plans/toggle_status') }}/" + planId, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      location.reload();
    }
  })
  .catch(err => console.error(err));
}
</script>

@endsection
