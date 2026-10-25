<!-- Redeem Modal -->
<div class="modal fade" id="ReedemModal" tabindex="-1" role="dialog" aria-labelledby="ReedemModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-gift mr-2 text-warning"></i> Redeem Gift</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4 text-center">
        @if (!empty($FormFields) && $FormFields->screenshot == 'on')
          <h5 class="font-weight-bold text-dark mb-2">If you have a Screenshot then please click on Next button and if have not Please Take Screenshot.</h5>
          <p class="text-muted mb-0">
            यदि आप Screenshot लेकर नहीं रखे है तो 
            कृपया Screenshot लेकर Next दबाए और आगे अपलोड करे !
          </p>
        @else
          <h5 class="font-weight-bold text-dark mb-2">धन्यवाद! आपने Prize Wheel के माध्यम से अपना ऑफर सुनिश्चित किया है!</h5>
          <p class="text-muted mb-0" style="font-size: 1.05rem;">
            ऑफर को Redeem करने के लिए कृपया <b>Next</b> दबाकर अपना डिटेल भरें।
          </p>
        @endif
      </div>
      <div class="modal-footer justify-content-between">
        @if (!empty($FormFields) && $FormFields->screenshot == 'on')
          <button type="button" class="btn btn-secondary take_screenshot" data-dismiss="modal">Take Screenshot</button>
        @else
          <div></div>
        @endif
        <button type="button" class="btn btn-success px-4 font-weight-bold" style="border-radius: 9999px; padding: 10px 28px;" onclick="open_form_modal()">Next <i class="fas fa-arrow-right ml-1"></i></button>
      </div>
    </div>
  </div>
</div>
