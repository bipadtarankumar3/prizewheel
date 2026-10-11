
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <title>CynoInfotech - HTML Scratch Card Script</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="HTML Scratch Card Script" />
    <meta name="keywords" content="">
    <!-- <link rel="icon" type="image/png" href="assets/images/favicon.png" /> -->
    <!-- theme stylesheet -->
    <link href="https://fonts.googleapis.com/css?family=Gilda+Display&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/scratchcard.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	
    
</head>

<body>
    <!-- start -->
    <div class="wrapper">
        <div class="main-container">
            
           
            <!-- content area part -->
            <div class="main-content">
                <section class="welcome">
                    <div class="container">
                        <div class="two-block">
                            <div class="left-block">
                                <div class="scratch-code">
                                    <div class="demo2" id="demo2" >
                                        <div class="code-content" id="secret-code">			
                                            <div class="code-area">
                                                            
                                                <h2>GET 15% DISCOUNT </h2>
                                                <p><img src="https://lavdemo.cssfloat.net/HTML-Scratch-Card-Script/assets/images/gift.png" alt="gift" width="100"></p>
                                                <div class="txt-code" id="txt-code-id">
                                                    <span class="copycouponcode">WOW15OFF</span>
                                                    <span class="tooltip"><img class="sc-copy" src="https://lavdemo.cssfloat.net/HTML-Scratch-Card-Script/assets/images/copy.png"><span class="tooltiptext myTooltip">Copy to clipboard</span></span>
                                                </div>	

                                                <button class="btn btn-primary mt-4">Apply</button>
                                                
                                            </div>			
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                     
                      

                    </div>
                </section>
            </div>
        </div>
        <!-- footer part -->
        <footer class="main-footer">
            <div class="container">
                <p> &copy; Copyright 2019 CynoInfotech, India - All Rights Reserved</p>
            </div>
        </footer>
    </div>


    <script src='assets/js/jquery.min.js'></script>
    <script src="assets/js/scratchcard.min.js"></script>
	<script src="assets/js/jquery.modal.min.js"></script>
    <!-- <script src="assets/js/demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



    <script>


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
        coverImage: 'https://lavdemo.cssfloat.net/HTML-Scratch-Card-Script/assets/images/cover-3.png',
        brushImage: "https://lavdemo.cssfloat.net/HTML-Scratch-Card-Script/assets/images/brush.png", // Use external image URL

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

    </script>

</body>

</html>