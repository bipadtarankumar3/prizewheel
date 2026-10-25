<!-- Canvas Wheel Interactive Box (Chances Mode) -->
<div class="wheel_interactive_box">
  <div class="the_wheel_wrapper">
    <div class="the_wheel">
      <canvas id="canvas" width="434" height="434">
        <p style="color: white" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
      </canvas>
      <div id="new_pin_div">
        <img src="{{asset('frontend/spinner/wheel/pin.png')}}" id="new_pin" alt="Indicator Pin">
      </div>
    </div>
  </div>
  <div class="wheel_cta_wrapper mt-3">
    <button id="spin_button" class="btn spin_form_btn" onClick="submit_from()">
      <i class="fas fa-play-circle mr-2"></i> {{ ($spin_form_timing ?? 'after_spin') == 'before_spin' ? 'Enter Details & Spin' : 'Spin To Win' }}
    </button>
  </div>
</div>
