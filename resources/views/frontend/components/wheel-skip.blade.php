<!-- Deal Wheel Interactive Box (Skip Mode) -->
<div class="deal_wheel_wrapper">
  <div class="deal-wheel">
    <ul class="spinner"></ul>
    <figure class="cap start-btn-spin">
      <div class="grim-reaper" data-reaction="dancing" xmlns="http://www.w3.org/2000/svg"></div>
      <i class="fas fa-play" style="font-size: 13px; margin-bottom: 2px;"></i>
      <span>SPIN</span>
    </figure>
    <div class="ticker"></div>
  </div>

  <div class="mt-2">
    <button class="btn spin_form_btn start-btn-spin" type="button">
      <i class="fas fa-play-circle mr-2"></i> {{ ($spin_form_timing ?? 'after_spin') == 'before_spin' ? 'FILL DETAILS & SPIN' : 'SPIN TO WIN' }}
    </button>
  </div>
</div>
