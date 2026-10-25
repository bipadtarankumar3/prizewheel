<!-- Winner Celebration Overlay -->
<div class="blast" id="blast" style="display: none">
  <div class="content">
    <div class="trophy" style="text-align: center; margin-bottom: 8px;">
      <img src="{{asset('frontend/spinner/wheel/trophy.png')}}" class="trophy_img" alt="trophy" style="max-height: 110px; object-fit: contain; display: none;">
      <img src="" alt="Won Prize" class="spinner_image_show" onerror="this.onerror=null; this.src='{{asset('frontend/spinner/wheel/trophy.png')}}';" style="max-height: 110px; object-fit: contain; display: none;">
    </div>
    <div class="text text-center">
      <h2>Congratulations, you won!</h2>
      <div class="award_text">Award</div>
    </div>
    <div class="text text-center mt-3">
      <button class="btn reedem-btn" onclick="check_user_spinner_submit()">REEDEM</button>
    </div>
  </div>
</div>
