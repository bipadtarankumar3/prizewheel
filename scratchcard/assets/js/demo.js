(function($){
    'use strict';
   
    $('.demo1').scratchCard({
        onComplete: function() {
            alert('callback for demo 1');
            
        }
    });
    
    $('.demo2').scratchCard({
        width: '300',
        height: '300',
        scratched: '40',
        coverImage: 'assets/images/cover-3.png',
        brushImage: 'assets/images/brush.png',
        onComplete: function() {
            alert('callback for demo 2');
        }
    });
    
    $('.demo3').scratchCard({
        inpopup:true,
        triggerOn: "#popupopen1",
        onComplete: function() {
            alert('callback for demo 3');
        }
    });
    
    $('.demo4').scratchCard({
        width: '300',
        height: '300',
        scratched: '40',
        coverImage: '../assets/images/cover-1.png',
        brushImage: '../assets/images/brush.png',
        inpopup:true,
        autoTrigger:true,
        triggerAfter:1,
        triggerOn: "#popupopen2",
        onComplete: function() {
            alert('callback for demo 4');
        }
    });
    
    $('.demo5').scratchCard({
        width: '300',
        height: '300',
        scratched: '40',
        coverImage: 'assets/images/cover-2.png',
        brushImage: 'assets/images/brush.png',
        inpopup:true,
        triggerOn: "#popupopen3",
        onComplete: function() {
            alert('callback for demo 5');
        }
    });
    
    $(document).on('click','.sc-copy', function(e){                                
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).parent().closest('div').find(".copycouponcode").text()).select();
        document.execCommand("copy");
        $(this).parent().closest('div').find(".myTooltip").html("Copied: " + $temp.val());
        $temp.remove();
    }); 
    
}(jQuery));