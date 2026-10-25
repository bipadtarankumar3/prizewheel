<!-- Promotional Popup Modal -->
@php
  $popup = DB::table('popupalerts')->where('user_id', $user->id)->orderBy('id', 'desc')->first();
@endphp

<div class="modal fade quotation newsShowPopupModal" tabindex="-1" aria-labelledby="smallQuoteModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="width: 95%;">
      <div class="modal-body">
        <div style="float: right;">
          <button type="button" class="btn-close popup_close" onclick="popupModalClose()" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-content" style="text-align: center; border: 0px solid rgb(0, 0, 0);">
          @if (!empty($popup))
            @if (!empty($popup->title))
              <h4 class="mb-3">{{$popup->title}}</h4>
            @endif
            @if (!empty($popup->popup_img))
              <img src="{{$popup->popup_img}}" alt="Promotion" style="max-height: 405px; width: auto; max-width: 100%; border-radius: 12px; margin: 0 auto;">
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  @if (!empty($popup) && $popup->status == 'active')
    @if(!Session::get('popupShow'))
      setTimeout(function(){ $('.newsShowPopupModal').modal('show'); }, 1000);
    @else
      $('.newsShowPopupModal').modal('hide');
    @endif
  @endif

  function popupModalClose(){
    @php
      Session::put('popupShow', 'show');
    @endphp
    $('.newsShowPopupModal').modal('hide');
  }
</script>
