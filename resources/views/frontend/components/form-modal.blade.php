<!-- Form Details Modal (Pre-spin & Post-spin) -->
<div class="modal fade bd-example-modal-lg FormModal" id="FormModal" tabindex="-1" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalTitle"><i class="fas fa-trophy mr-2 text-warning"></i> Claim Your Prize — Enter Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @if(($spin_form_timing ?? 'after_spin') == 'before_spin') style="display: none;" @endif>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <form action="{{URL::to('u/spinner_form/post')}}" method="POST" id="spinner_form" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="spinner_id" id="spinner_id">
          <input type="hidden" name="spinner_name" id="spinner_name">
          <input type="hidden" name="spinner_value" id="spinner_value">
          <input type="hidden" name="camping_id" value="{{ $Camping->id }}">
          <input type="hidden" id="screenshot-input" name="screenshot-file">

          <div class="winner-header-info text-center mb-4">
            <img src="" alt="Prize" class="spinner_image mb-2" style="max-height: 85px; max-width: 130px; object-fit: contain; display: none;">
            <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Congratulations, you won!</h3>
            <div style="background: #ecfdf5; border: 1.5px dashed #10b981; border-radius: 9999px; display: inline-block; padding: 6px 24px;">
              <span class="spinner_name_text" style="font-size: 1.25rem; font-weight: 800; color: #059669;"></span>
            </div>
          </div>

          <div class="prespin-header-info text-center mb-4" style="display: none;">
            <div style="width: 54px; height: 54px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 8px;">
              <i class="fas fa-user-edit"></i>
            </div>
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Enter Details to Spin & Win</h3>
            <p class="text-muted small mb-0">Please fill in your contact information below to unlock your spin!</p>
          </div>

          @php
            $hasWhatsapp = (!isset($FormFields) || $FormFields->whatsapp_no != 'off');
            $hasEmail = (!empty($FormFields) && $FormFields->email == 'on');
            $hasAddress = (!empty($FormFields) && $FormFields->address == 'on');
          @endphp

          <div class="form-row">
            <div class="form-group col-md-6 col-12">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group col-md-6 col-12">
              <label for="phone">
                @if($hasWhatsapp)
                  <i class="fab fa-whatsapp text-success mr-1"></i> Mobile / WhatsApp Number
                @else
                  Mobile Number
                @endif
              </label>
              <input type="text" name="phone" class="form-control" id="phone" min="10" onkeyup="numOnly(this)" onblur="numOnly(this)" maxlength="10" placeholder="{{ $hasWhatsapp ? '10 Digit Mobile / WhatsApp Number' : '10 Digit Mobile Number' }}" required>
              <input type="hidden" name="whatsapp_number" id="whatsapp_number">
              <span id="phone_error" style="color: #ef4444; font-size: 0.8rem; font-weight: 600;"></span>
            </div>
          </div>

          @if ($hasEmail || $hasAddress)
          <div class="form-row">
            @if ($hasEmail)
            <div class="form-group {{ $hasAddress ? 'col-md-6 col-12' : 'col-12' }}">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com">
            </div>
            @endif
            @if ($hasAddress)
            <div class="form-group {{ $hasEmail ? 'col-md-6 col-12' : 'col-12' }}">
              <label for="address">Address</label>
              <input type="text" name="address" class="form-control" id="address" placeholder="Enter your address">
            </div>
            @endif
          </div>
          @endif

          <div class="form-row">
            @if (!empty($FormFields) && $FormFields->choose_option == 'on')
              @if (isset($BikeModel) && count($BikeModel) > 0)
                <div class="form-group col-md-6 col-12">
                  <label for="bike_model_id">Are You Interested In</label>
                  <select name="bike_model_id" id="bike_model_id" class="form-control" required>
                    <option value="">Select an option</option>
                    @foreach ($BikeModel as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </select>
                </div>
              @endif
            @endif

            @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              <div class="form-group col-md-6 col-12">
                <label for="screenshot">Screenshot</label>
                <input type="file" name="screenshot" class="form-control" @if (!empty($FormFields) && $FormFields->screenshot_required == 'on') required @endif id="screenshot">
              </div>
            @endif
          </div>

          @if (!empty($FormFields) && $FormFields->screenshot == 'on')
            <div id="screenshot-preview-card" style="display: none; max-width: 340px; margin: 14px auto 0;" class="p-2 bg-light rounded text-center border">
              <div class="d-flex align-items-center justify-content-center mb-1 text-success font-weight-bold" style="font-size: 0.8rem;">
                <i class="fas fa-check-circle mr-1"></i> Winning Proof Screenshot Attached
              </div>
              <img id="screenshot-preview-img" src="" alt="Proof Screenshot" style="max-height: 95px; border-radius: 8px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.06); object-fit: contain;">
            </div>
          @endif

          <div class="text-right mt-3">
            @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              <button type="button" class="btn btn-secondary form_take_screenshot mr-2" data-dismiss="modal">Take Screenshot</button>
            @endif
            <button type="submit" class="btn btn-primary form_submit_button">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
