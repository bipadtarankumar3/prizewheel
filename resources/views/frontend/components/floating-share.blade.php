@php
  $shareTitle = ($Camping->title_status == 'on' && !empty($Camping->title)) ? $Camping->title : 'Prize Wheel';
  $shareSub = ($Camping->sub_title_status == 'on' && !empty($Camping->sub_title)) ? $Camping->sub_title : '';
  
  $waMessage = "🎉 *" . $shareTitle . "*\n";
  if (!empty($shareSub)) {
    $waMessage .= $shareSub . "\n\n";
  }
  if (!empty($Camping->validity_status) && $Camping->validity_status == 'on' && !empty($Camping->start_date) && !empty($Camping->end_date)) {
    $startDate = date('d M Y', strtotime($Camping->start_date));
    $endDate = date('d M Y', strtotime($Camping->end_date));
    $waMessage .= "📅 Offer Validity: " . $startDate . " — " . $endDate . "\n\n";
  }
  $waMessage .= "👉 Spin the wheel to win your prize:\n" . url()->current();
  $waShareUrl = "https://wa.me/?text=" . rawurlencode($waMessage);
  $fbShareUrl = "https://www.facebook.com/sharer/sharer.php?u=" . rawurlencode(url()->current());
@endphp

<!-- Modern Floating Share Button -->
<div class="share_floating_bar">
  <div class="share_toggle_btn sticky_share_btn" id="shareToggleBtn">
    <i class="fas fa-share-alt"></i>
    <span>Share</span>
  </div>
  <ul class="share_options_menu listing">
    <li>
      <a href="{{ $waShareUrl }}" target="_blank" class="wa_btn" title="Share on WhatsApp">
        <i class="fab fa-whatsapp"></i>
      </a>
    </li>
    <li>
      <a href="{{ $fbShareUrl }}" target="_blank" class="fb_btn" title="Share on Facebook">
        <i class="fab fa-facebook-f"></i>
      </a>
    </li>
  </ul>
</div>

