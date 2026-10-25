<!-- Modern Floating Share Button -->
<div class="share_floating_bar">
  <div class="share_toggle_btn sticky_share_btn">
    <i class="fas fa-share-alt"></i>
    <span>Share</span>
  </div>
  <ul class="share_options_menu listing">
    <li>
      <a href="https://wa.me/?text={{url()->current()}}" target="_blank" class="wa_btn" title="Share on WhatsApp">
        <i class="fab fa-whatsapp"></i>
      </a>
    </li>
    <li>
      <a href="http://www.facebook.com/share.php?u={{url()->current()}}" target="_blank" class="fb_btn" title="Share on Facebook">
        <i class="fab fa-facebook-f"></i>
      </a>
    </li>
  </ul>
</div>
