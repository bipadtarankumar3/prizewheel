<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
          @if ($Camping->title_status == 'on')
      {{$Camping->title}}
      @else
      Prize Wheel
      @endif
        </title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        {{-- <script type="text/javascript" src="https://ramjeehonda.com/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script> --}}

        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 


        <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 

        {{-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> --}}

        {{-- <link href="./myStyle.css" rel="stylesheet"> --}}

        <link rel="stylesheet" href="{{asset('frontend/spinner/wheel/main.css')}}" type="text/css" />
        <script type="text/javascript" src="{{asset('frontend/spinner/wheel/Winwheel.js')}}"></script>
        <script src="{{asset('frontend/spinner/wheel/TweenMax.min.js')}}"></script>
        <link rel='stylesheet' type='text/css' href='{{asset('frontend/spinner/wheel/rotation.css')}}' />	

        <link rel="stylesheet" href="{{asset('frontend/award/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/spinner/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/spinn_two/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/spinn_two/my-style.css')}}">
    
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap');

      html, body {
        overflow-x: hidden !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
        height: auto !important;
      }

      body {
        font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        display: block !important;
      }

      .main_page_wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 0;
      }

      /* Campaign Information Card */
      .campaign_hero_card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15), 0 0 1px 1px rgba(255, 255, 255, 0.8) inset;
        border-radius: 28px;
        padding: 28px 24px;
        transition: transform 0.3s ease;
      }

      /* Notice Banner */
      .notice_banner {
        display: flex;
        align-items: center;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 9999px;
        padding: 6px 14px;
        margin-bottom: 18px;
        overflow: hidden;
      }
      .notice_badge {
        background: #ef4444;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 9999px;
        margin-right: 10px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 4px;
      }
      .notice_scroll {
        flex-grow: 1;
        color: #b91c1c;
        font-weight: 600;
        font-size: 0.85rem;
        overflow: hidden;
      }

      /* Brand Logo */
      .brand_logo_wrapper {
        margin-bottom: 14px;
      }
      .brand_logo_img {
        max-height: 80px;
        max-width: 170px;
        object-fit: contain;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.08));
      }

      /* Campaign Titles */
      .campaign_main_title {
        font-size: clamp(1.35rem, 3.5vw, 1.85rem);
        font-weight: 800;
        color: #0f172a;
        line-height: 1.25;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
      }
      .campaign_sub_title {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 20px;
      }

      /* Meta Pills */
      .campaign_meta_pills {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
      .meta_pill {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 10px 16px;
      }
      .meta_pill .meta_icon {
        font-size: 1.25rem;
      }
      .meta_pill .meta_text {
        display: flex;
        flex-direction: column;
        text-align: left;
      }
      .meta_pill .meta_label {
        font-size: 0.72rem;
        text-transform: uppercase;
        font-weight: 600;
        color: #94a3b8;
        letter-spacing: 0.05em;
      }
      .meta_pill .meta_dates {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e293b;
      }
      .meta_pill .meta_count {
        font-size: 1.15rem;
        font-weight: 800;
        color: #2563eb;
      }

      /* Wheel Interactive Box */
      .wheel_interactive_box {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
      }

      .spin_form_btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        font-size: 1.2rem !important;
        font-weight: 800 !important;
        letter-spacing: 0.05em !important;
        text-transform: uppercase !important;
        padding: 14px 44px !important;
        border-radius: 9999px !important;
        border: none !important;
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5), 0 0 0 4px rgba(16, 185, 129, 0.15) !important;
        cursor: pointer !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
      }
      .spin_form_btn:hover:not(:disabled) {
        transform: translateY(-2px) scale(1.03) !important;
        box-shadow: 0 14px 30px -4px rgba(16, 185, 129, 0.65), 0 0 0 6px rgba(16, 185, 129, 0.2) !important;
      }
      .spin_form_btn:active:not(:disabled) {
        transform: translateY(1px) scale(0.98) !important;
      }
      .spin_form_btn:disabled {
        opacity: 0.6 !important;
        cursor: not-allowed !important;
        filter: grayscale(40%) !important;
      }

      /* Popup Announcement Modal */
      .newsShowPopupModal .modal-content {
        border: none;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      }
      .newsShowPopupModal .modal-body {
        padding: 24px;
        position: relative;
      }
      .popup_close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: #475569;
        cursor: pointer;
        z-index: 1060;
        transition: all 0.2s;
      }
      .popup_close:hover {
        background: #f1f5f9;
        transform: scale(1.08);
      }

      @media (max-width: 991.98px) {
        .main_page_wrapper {
          min-height: 100vh;
          display: block;
          padding: 12px 0 36px 0;
        }
        .spinner_col {
          margin-bottom: 24px !important;
        }
        div.the_wheel {
          width: min(86vw, 360px);
        }
        .campaign_hero_card {
          padding: 22px 18px;
          border-radius: 22px;
        }
        .campaign_main_title {
          font-size: 1.35rem;
        }
        .brand_logo_img {
          max-height: 65px;
        }
      }

      @media (max-width: 480px) {
        div.the_wheel {
          width: min(84vw, 320px);
        }
        .spin_form_btn {
          font-size: 1.05rem !important;
          padding: 12px 32px !important;
        }
        .notice_banner {
          padding: 4px 10px;
          margin-bottom: 14px;
        }
      }
    </style>
    </head>
<body 
      @if($user->default_background == 'color') style="background:{{$user->background_color}}" 
      @elseif($user->default_background == 'image' && !empty($user->background_image)) style="background:url('{{$user->background_image}}');background-repeat: no-repeat;background-size: cover;background-position: top;min-height: 100vh;" 
      @else   
        style="background:url('{{URL::to('frontend/images/spin_2_back.jpg')}}');background-repeat: no-repeat;background-size: cover;background-position: top;min-height: 100vh;"
      @endif >

        <div class="main_page_wrapper">
            <div class="container py-3" id="cn_wheel_main_div">
                <div class="row align-items-center justify-content-center">
                    <!-- Left Column (Desktop) / Second Section (Mobile): Campaign Information Card -->
                    <div class="col-lg-5 col-md-10 col-12 text_col mb-4 mb-lg-0 order-2 order-lg-1">
                        <div class="campaign_hero_card">
                            @php
                                $notice = DB::table('notices')->where('user_id', $user->id)->where('status', 'active')->first();
                            @endphp
                            @if ($notice != '' && $notice->status == 'active')
                                <div class="notice_banner">
                                    <span class="notice_badge"><i class="fas fa-bullhorn"></i> Notice</span>
                                    <div class="notice_scroll">
                                        <marquee direction="left" onmouseover="this.stop();" onmouseleave="this.start();">
                                            {{$notice->notice}}
                                        </marquee>
                                    </div>
                                </div>
                            @endif

                            <div class="brand_logo_wrapper text-center">
                                <img src="{{$user->logo}}" class="brand_logo_img" alt="{{$user->name}}">
                            </div>

                            @if ($Camping->title_status == 'on')
                                <h2 class="campaign_main_title text-center">{{$Camping->title}}</h2>
                            @endif

                            @if ($Camping->sub_title_status == 'on')
                                <p class="campaign_sub_title text-center">{{$Camping->sub_title}}</p>
                            @endif

                            <div class="campaign_meta_pills">
                                @if ($Camping->validity_status == 'on')
                                    <div class="meta_pill validity_pill">
                                        <i class="far fa-calendar-alt meta_icon text-success"></i>
                                        <div class="meta_text">
                                            <span class="meta_label">Offer Validity</span>
                                            <span class="meta_dates">
                                                <?php
                                                    $startDate = date_create($Camping->start_date);
                                                    $endDate = date_create($Camping->end_date);
                                                    echo date_format($startDate, "d M Y") . " — " . date_format($endDate, "d M Y");
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if ($SpinnerFormAccessCount != 'NO_LIMIT')
                                    <div class="meta_pill spins_pill">
                                        <i class="fas fa-sync-alt meta_icon text-primary"></i>
                                        <div class="meta_text">
                                            <span class="meta_label">Spin Limit Remaining</span>
                                            <span class="meta_count spin_time_count">
                                                @php
                                                    echo $count = $user->spin_whell_round - $SpinnerFormAccessCount;
                                                @endphp
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="background_form_part" style="display: none">
                            <input type="text" name="name" class="form-control" placeholder="Name" id="p_name" required value=""> 
                            <br>
                            <input type="text" name="mobile" class="form-control" placeholder="Mobile" id="p_mobile" required>
                            <br>
                            <div style="text-align:center;"> 
                                <button id="spin_button" class="btn btn-sm btn-success background_form_btn" onClick="submit_from()"> Spin To Win</button>
                            </div>
                            <div class="error_alert alert alert-danger mt-3">
                                <h5 id="alert_msg"></h5>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Desktop) / First Section (Mobile): Spin Wheel -->
                    <div class="col-lg-7 col-md-10 col-12 spinner_col text-center mb-4 mb-lg-0 order-1 order-lg-2">
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
                                    <i class="fas fa-play-circle mr-2"></i> Spin To Win
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="entry-links"></div>
        </div>
       


    
<div class="blast" id="blast" style="display: none">
    <div class="content">
        <div class="trophy">
            <img src="{{asset('frontend/spinner/wheel/trophy.png')}}" class="trophy_img" alt="trophy">
            <br>
            <img src="" alt="" srcset="" class="spinner_image_show" width="40%">
        </div>
        <div class="text text-center">
            <h2 class="my-3">Congratulations, you won!</h2>
            <h1 class="award_text">Award</h1>
        </div>
        <div class="text text-center">
            <button class="btn btn-warning reedem-btn" onclick="check_user_spinner_submit()" >Reedem</button>
        </div>

    </div>
  </div>

    <audio  id="error"  >
        <source src="{{asset('mp3/error.mp3')}}"  type="audio/mpeg">
        
    </audio>
    <audio  id="own"  >
        <source src="{{asset('mp3/won.mp3')}}"  type="audio/mpeg">
        
    </audio>
    <audio  id="circleSound" >
        <source src="{{asset('mp3/wheel2.mp3')}}"  type="audio/mpeg">
    </audio>

    <style>
            
        .error_alert, .prize_msg_alert{
             
             display:none;
        }
      
      </style>

        <!-- Modal -->
  <div class="modal fade" id="ReedemModal" tabindex="-1" role="dialog" aria-labelledby="ReedemModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Reedem Gift</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              <h5>If you have a Screenshot then please click on Next button and if have not Please Take Screenshot.</h5>
              <p>
                यदि आप Screenshot लेकर नहीं रखे है तो 
                कृपया Screenshot लेकर Next दबाए और आगे अपलोड करे !
              </p>
            @else
              <h5>धन्यवाद! आपने Prize Wheel के माध्यम से अपना ऑफर सुनिश्चित किया है 
                उसको Reedem के लिए कृपया Next दबाकर अपना डिटेल डाले |</h5>
            @endif
        </div>
        <div class="modal-footer">
            @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              {{-- <button type="button" class="btn btn-secondary take_screenshot" data-dismiss="modal">Take Screenshot</button> --}}
            @endif
          
          <button type="button" class="btn btn-success"  onclick="open_form_modal()">Next</button>
        </div>
      </div>
    </div>
  </div>



  
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg FormModal" id="FormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-header" style="background: #fff;">
            <h5 class="modal-title" id="exampleModalLongTitle">Submit your details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-content">
            <form class="my-4 p-4" action="{{URL::to('u/spinner_form/post')}}" method="POST" id="spinner_form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="spinner_id" id="spinner_id">
              <input type="hidden" name="spinner_name" id="spinner_name">
              <input type="hidden" name="spinner_value" id="spinner_value">
              <input type="hidden" id="screenshot-input" name="screenshot-file">

              <div class="form-row">
                <div class="form-group col-md-3"></div>
                <div class="form-group col-md-6 text-center">
                  <img src="" alt="" srcset="" class="spinner_image" width="40%">
                  <h3>Congratulations, you won!</h3>
                  
                  <h3 class="spinner_name_text"></h3>
                </div>
                <div class="form-group col-md-3"></div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="phone">Mobile Number</label>
                  <input type="text" name="phone" class="form-control" id="phone" min="10"  onkeyup="numOnly(this)" onblur="numOnly(this)" maxlength="10" placeholder="Mobile Number" required>
                  <span id="phone_error"  style="color:red"></span>
                </div>
                
                
              </div>
              <div class="form-row">
                @if (!empty($FormFields) && $FormFields->whatsapp_no == 'on')
                <div class="form-group col-md-4">
                  <label for="whatsapp_number">Whatsapp Number</label>
                  <input type="text" name="whatsapp_number" class="form-control" min="10"  onkeyup="wpNumOnly(this)" onblur="numOnly(this)"  maxlength="10" id="whatsapp_number" placeholder="whatsapp Number" required>
                  <span id="wp_phone_error"  style="color:red"></span>
                </div>
                @endif
                @if (!empty($FormFields) && $FormFields->email == 'on')
                    
                
                <div class="form-group col-md-4">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                @endif
                @if (!empty($FormFields) && $FormFields->address == 'on')
                    
                
                <div class="form-group  col-md-4">
                  <label for="address">Address</label>
                  <input type="text" name="address" class="form-control" id="address" placeholder="">
                </div>
                @endif
              </div>
              <div class="form-row">
  
                @if (!empty($FormFields) && $FormFields->choose_option == 'on')
  
                @if (count($BikeModel) > 0)
                    <div class="form-group col-md-6">
                      <label for="screenshot">Are You Interested in</label>
                      <select name="bike_model_id" id="bike_model_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach ($BikeModel as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                @endif
                @endif
                @if (!empty($FormFields) && $FormFields->screenshot == 'on')
                {{-- <div class="form-group col-md-6">
                  <label for="screenshot">Screenshot </label>
                  <input type="file" name="screenshot" class="form-control" @if (!empty($FormFields) && $FormFields->screenshot_required == 'on') required @endif id="screenshot" placeholder="Screenshot">
                </div> --}}
                @endif
               
              </div>
              @if (!empty($FormFields) && $FormFields->screenshot == 'on')
              {{-- <button type="button" class="btn btn-secondary form_take_screenshot" data-dismiss="modal">Take Screenshot</button> --}}
              <button type="button" class="btn btn-secondary take_screen_button" onclick="captureScreenshot('blast','screenshot-input')">Take Screenshot</button>
              
              <button type="submit" class="btn btn-primary form_submit_button" style="display: none">Submit</button>
              
              @else
              <button type="submit" class="btn btn-primary form_submit_button">Submit</button>
              @endif
            </form>
          </div>
        </div>
      </div>
  
    @php
      $popup = DB::table('popupalerts')->where('user_id', $user->id)->orderBy('id', 'desc')->first();
    @endphp
    <div class="modal fade quotation newsShowPopupModal" tabindex="-1" aria-labelledby="smallQuoteModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="position: relative; border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35); width: 95%; margin: 0 auto; background: #fff;">
          <button type="button" class="popup_close" onclick="popupModalClose()" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <div class="modal-body text-center p-3">
            @if (!empty($popup))
              @if (!empty($popup->title) && trim($popup->title) !== '...' && trim($popup->title) !== '')
                <h4 class="mb-3 font-weight-bold" style="color: #0f172a;">{{$popup->title}}</h4> 
              @endif
              @if (!empty($popup->popup_img))
                <img src="{{$popup->popup_img}}" alt="Announcement" style="max-height: 65vh; max-width: 100%; object-fit: contain; border-radius: 12px;">   
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  
  
  
     <!-- Preloader -->
  <div id="preloader" style="display: none">
    <div id="status">&nbsp;</div>
  </div>
      <style>
        /* Preloader */
  
  #preloader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ffffff91;
      z-index: 9999;
    /* makes sure it stays on top */
  }
  
  #status {
    width: 200px;
    height: 200px;
    position: absolute;
    left: 50%;
    /* centers the loading animation horizontally one the screen */
    top: 50%;
    /* centers the loading animation vertically one the screen */
    background-image: url(https://raw.githubusercontent.com/niklausgerber/PreLoadMe/master/img/status.gif);
    /* path to your loading animation */
    background-repeat: no-repeat;
    background-position: center;
    margin: -100px 0 0 -100px;
    /* is width and height divided by two */
  }
      </style>
  
  



<script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
<script  src="{{asset('frontend/award/js/blast.js')}}"></script>

      
       <script>


        
      	
    function numOnly(selector) {
        const numericValue = selector.value.replace(/[^0-9]/g, '');
        $('.form_submit_button').attr('disabled','disabled');
        if (numericValue.length !== 10) {
            const errorMessageSpan = document.getElementById("phone_error");
            errorMessageSpan.textContent = 'Enter Valid 10 Digit Number';
            selector.value = numericValue;
        } else {
            const errorMessageSpan = document.getElementById("phone_error");
            errorMessageSpan.textContent = '';
            selector.value = numericValue;
            $('.form_submit_button').removeAttr('disabled');
        }
    }
      	
    function wpNumOnly(selector) {
        const numericValue = selector.value.replace(/[^0-9]/g, '');
        $('.form_submit_button').attr('disabled','disabled');
        if (numericValue.length !== 10) {
            const errorMessageSpan = document.getElementById("wp_phone_error");
            errorMessageSpan.textContent = 'Enter Valid 10 Digit Number';
            selector.value = numericValue;
        } else {
            const errorMessageSpan = document.getElementById("wp_phone_error");
            errorMessageSpan.textContent = '';
            selector.value = numericValue;
            $('.form_submit_button').removeAttr('disabled');
        }
    }

        var  playing = false;
       
        function show_alert_error(msg)
          {
               $('#alert_msg').text(msg);
               $('.error_alert').show();
               
               location.href='#p_mobile';
          }
          
          function hide_alert_error()
          {
          
              $('.error_alert').hide();
          }
          
          
          function show_prize_msg(msg)
          {
               $('#prize_msg').text(msg);
               $('.prize_msg_alert').show();
               location.href='#p_mobile';
          }
          
          function hide_prize_msg()
          {
               $('#code_msg').html('');
               
              $('.prize_msg_alert').hide();
          }
          
          
          function show_code_msg(msg)
          {
               $('#code_msg').html(msg);
               
              // $('.prize_msg_alert').show();
               
               //location.href='#p_mobile';
          }
          
          function submit_from()
          {

            
        swal({
            title: "Best Of Luck",
            text: "If you click on 'Yes' button it will reduce your spin limit",
            type: "success",
            showCancelButton: true,
            confirmButtonColor: 'green',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){

            if (isConfirm){

                $('.confirm').attr('disabled','disabled');

                
                $.ajax({
                url: "{{URL::to('u/spinner_round_check')}}",
                    type: 'post',
                    // dataType: 'application/json',
                    data:  {
                        user_id:'{{$user->id}}',
                        campaign_id:'{{$Camping->id}}',
                    },
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(data) {
                    
                        $('.spin_time_count').html(data.total_count);
                        if (data.status == false) {
                        swal({
                            title: "Oh! Sorry",
                            text: "<h2>"+data.message+"</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a>",
                            html: true,
                            type: "error",
                            confirmButtonText: "Ok"
                        });

                        document.getElementById('error').play();
                        playing = true;
                        return;

                        }else{

                            hide_alert_error();
                            hide_prize_msg();
            

                            // if($('#p_name').val() == '' || $('#p_name').val() == ' ' )
                            // {
                            //     //alert('Enter name !');
                                
                            //     show_alert_error('Enter name !');
                                
                            // }
                                        
                            // else if($('#p_mobile').val() == '' || $('#p_mobile').val() == ' ' || (!$('#p_mobile').val().match('[0-9]{10}')) ||   ($('#p_mobile').val().length!=10)  )
                            // {
                            //    // alert('Enter valid 10 digit mobile number !');
                                
                            //    //show_alert_error('Enter valid 10 digit mobile number !');
                            // }
                            
                            // else
                            // {
                                document.getElementById('circleSound').play();
                                playing = true;

                                    $.ajax({
                                    url: "{{URL::to('form_submit')}}",
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Set the CSRF token
                                    },
                                    data: {
                                        campaign_id: "{{$campaign_id}}",
                                        name: $('#p_name').val(),
                                        mobile: $('#p_mobile').val(),
                                        // Add any other fields you need to send
                                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                                    },
                                    success: function(response) {
                                        if (response.success && response.data) {
                                            // Call calculatePrize with the received segment number
                                            calculatePrize(response.data.segment_number, response.data.degree, response.data.after_angle);
                                            show_code_msg('Your code is <b>' + response.data.code + '</b>');
                                        } else {
                                            if (playing == true) {
                                                try { document.getElementById('circleSound').pause(); } catch(e){}
                                                playing = false;
                                            }
                                            swal("Notice", response.message || "No prize available for selection.", "info");
                                            $(".spin_form_btn").removeAttr('disabled');
                                            wheelSpinning = false;
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        if (playing == true) {
                                            try { document.getElementById('circleSound').pause(); } catch(e){}
                                            playing = false;
                                        }
                                        swal("Error", "Could not connect to server. Please try again.", "error");
                                        $(".spin_form_btn").removeAttr('disabled');
                                        wheelSpinning = false;
                                    }
                                });

                            // }

                            swal.close();

                        }
                        $('.confirm').removeAttr('disabled');
                        
                    },
                    error: function(err) {
                        reject(err) // Reject the promise and go to catch()
                    }
                });

            } else {
            swal("Cancelled", "Your spin wheel is cancled :)", "error");
            }
            }  
            
            )
        }
    
             
       
          // Create new wheel object specifying the parameters at creation time.
          
          var theWheel = new Winwheel({
              'numSegments'  : {{$spinn_count}},     // Specify number of segments.
              'responsive'   : true,
              'outerRadius'  : 212,   // Set outer radius so wheel fits inside the background.
              'textFontSize' : 17,    // Set font size as desired.
              'segments'     :  <?php echo $spinner_data_json;?>,       // Define segments including colour and text.
              'animation' :          // Specify the animation to use.
              {
                  'type'     : 'spinToStop',
                  'duration' : {{$Camping->spinner_time}},     // Duration in seconds.
                  'spins'    : 8,     // Number of complete spins.
                  'callbackFinished' : alertPrize
              }
          });

          // Vars used by the code in this page to do power controls.
          var wheelPower    = 0;
          var wheelSpinning = false;

          // -------------------------------------------------------
          // Function to handle the onClick on the power buttons.
          // -------------------------------------------------------
          function powerSelected(powerLevel)
          {
              // Ensure that power can't be changed while wheel is spinning.
              if (wheelSpinning == false)
              {
                  // Reset all to grey incase this is not the first time the user has selected the power.
                  document.getElementById('pw1').className = "";
                  document.getElementById('pw2').className = "";
                  document.getElementById('pw3').className = "";

                  // Now light up all cells below-and-including the one selected by changing the class.
                  if (powerLevel >= 1)
                  {
                      document.getElementById('pw1').className = "pw1";
                  }

                  if (powerLevel >= 2)
                  {
                      document.getElementById('pw2').className = "pw2";
                  }

                  if (powerLevel >= 3)
                  {
                      document.getElementById('pw3').className = "pw3";
                  }

                  // Set wheelPower var used when spin button is clicked.
                  wheelPower = powerLevel;

                //   document.getElementById('spin_button').className = "clickable";
              }
          }

          // -------------------------------------------------------
          // Click handler for spin button.
          // -------------------------------------------------------
          function startSpin()
          {
              // Ensure that spinning can't be clicked again while already running.
              if (wheelSpinning == false)
              {
                  // Based on the power level selected adjust the number of spins for the wheel, the more times is has
                  // to rotate with the duration of the animation the quicker the wheel spins.
                  if (wheelPower == 1)
                  {
                      theWheel.animation.spins = 3;
                  }
                  else if (wheelPower == 2)
                  {
                      theWheel.animation.spins = 8;
                  }
                  else if (wheelPower == 3)
                  {
                      theWheel.animation.spins = 15;
                  }

                  document.getElementById('spin_button').className = "";

                  // Begin the spin animation by calling startAnimation on the wheel object.
                  theWheel.startAnimation();

                  // Set to true so that power can't be changed and spin button re-enabled during
                  // the current animation. The user will have to reset before spinning again.
                  wheelSpinning = true;
              }
          }

          // -------------------------------------------------------
          // Function for reset button.
          // -------------------------------------------------------
          function resetWheel()
          {
              theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
              theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
              theWheel.draw();                // Call draw to render changes to the wheel.

              document.getElementById('pw1').className = "";  // Remove all colours from the power level indicators.
              document.getElementById('pw2').className = "";
              document.getElementById('pw3').className = "";

              wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.
          }

          // -------------------------------------------------------
          // Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters
          // note the indicated segment is passed in as a parmeter as 99% of the time you will want to know this to inform the user of their prize.
          // -------------------------------------------------------
          function alertPrize(indicatedSegment)
          {
                console.log('Indicated segment won:', indicatedSegment);

                if (playing == true) {
                    try { document.getElementById('circleSound').pause(); } catch(e){}
                    playing = false;
                }

                if (!indicatedSegment) {
                    $(".spin_form_btn").removeAttr('disabled');
                    wheelSpinning = false;
                    return;
                }

                try {
                    let ownSound = document.getElementById('own');
                    if (ownSound) ownSound.play().catch(function(e){ console.log('Audio error:', e); });
                } catch(e){}

                blast_fun();
                $('.award_text').html(indicatedSegment.text);
                $('.blast').show();

                if (indicatedSegment.image && indicatedSegment.image != '') {
                    $('.spinner_image_show').attr('src', indicatedSegment.image);
                    $('.spinner_image').attr('src', indicatedSegment.image);
                } else {
                    $('.trophy_img').attr('src', "{{asset('frontend/spinner/wheel/trophy.png')}}");
                    $('.spinner_image').attr('src', "{{asset('frontend/spinner/wheel/trophy.png')}}");
                }

                $('#spinner_id').val(indicatedSegment.id);
                $('#spinner_name').val(indicatedSegment.text);
                $('.spinner_name_text').html(indicatedSegment.text);
                $('#spinner_value').val(indicatedSegment.price);

                setTimeout(() => {
                    $('#confetti-canvas').hide();
                }, 2000);

                $(".spin_form_btn").removeAttr('disabled');
                wheelSpinning = false;
          }

          function calculatePrize(segmentNumber, degree, after_angle) {
              $(".spin_form_btn").attr('disabled', 'disabled');
              wheelSpinning = true;
              let stopAt = 0;
              if (segmentNumber && typeof theWheel.getRandomForSegment === 'function') {
                  stopAt = theWheel.getRandomForSegment(segmentNumber);
              }
              if (!stopAt && after_angle) {
                  let lessBound = (after_angle - degree) + 5;
                  stopAt = Math.floor(Math.random() * (after_angle - lessBound - 4)) + lessBound + 2;
              }
              if (stopAt) {
                  theWheel.animation.stopAngle = stopAt;
              }
              theWheel.startAnimation();
          }










          //--------------------------------------------------------
          
    function open_form_modal(){
      $('#FormModal').modal('show');
    }

      $("#spinner_form").on('submit',(function(e) {
        e.preventDefault();
        var name  = $('#name').val();
        var email  = $('#email').val();
        var whatsapp_number  = $('#whatsapp_number').val();
        var phone  = $('#phone').val();
        var address  = $('#address').val();
        var bike_model_id  = $('#bike_model_id').val();
 
        $('.form_submit_button').attr('disabled','disabled');
        $('#preloader').show();
        //get the action-url of the form
        var actionurl = e.currentTarget.action;

        //do your own request an handle the results
        $.ajax({
                url: actionurl,
                type: 'post',
                // dataType: 'application/json',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                  $('.form_submit_button').removeAttr('disabled');
                  if (data.message == 'Inserted') {
                    
                    swal({
                      title: "Success",
                      text: "<h4>Thank You For Submit Us Details</h4><span>Our Team Will be Contact You Soon </span> <p  style='margin:7px'><b>Helpline Number </b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a></p>", 
                      html: true,
                      type: "success",
                      confirmButtonText: "Cool",
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Ok",
                    }, function(isConfirm) {
                        if (isConfirm) {
                          location.reload(true);
                        } else {
                            return false;
                        }
                    });
                    

                  } else if(data.message == 'AlreadyInserted'){
                    swal({
                      title: "Error!",
                      text: "<h2>Already Submitted</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a>",
                      html: true,
                      type: "error",
                      confirmButtonText: "Cool"
                    });
                  } else {
                    swal({
                      title: "Error!",
                      text: "Here's my error message!",
                      type: "error",
                      confirmButtonText: "Ok"
                    });
                  }
                  $('#preloader').hide();
                   
                }
        });
      }));


      function check_user_spinner_submit(){
        // $.ajax({
        //   url: "{{URL::to('u/spinner_form_check/post')}}",
        //   type: 'post',
        //   // dataType: 'application/json',
        //   data:  {
        //     id:''
        //   },
        //   headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
        //   success: function(data) {
        //     if (data.message == 'AlreadyInserted') {
        //       swal({
        //         title: "Error!",
        //         text: "<h2>Already Submitted</h2><p style='margin:7px'><b>Helpline Number</b></p><a href='tel:{{$user->phone}}'><p><i class='fas fa-phone'></i> {{$user->phone}}</a>",
        //         html: true,
        //         type: "error",
        //         confirmButtonText: "Ok"
        //       });

        //       document.getElementById('error').play();
        //   playing = true;

        //     }else {
        //       $('#ReedemModal').modal('show');
        //     }
              
        //   }
        // });

        $('#ReedemModal').modal('show');

      }


      jQuery(".sticky_share_btn").click(function () {
        jQuery(".listing").fadeToggle(600);
      });
      jQuery(".form_take_screenshot").click(function () {
        $('#FormModal').modal('hide');
        $('#ReedemModal').modal('hide');
      });


      function captureScreenshot(elementId, inputId, callback) {
        const targetElement = document.getElementById(elementId);

        if (!targetElement) {
            console.error(`Element with ID "${elementId}" not found.`);
            return;
        }

        html2canvas(targetElement)
            .then(canvas => {
                const imageData = canvas.toDataURL("image/png");
                const inputElement = document.getElementById(inputId);

                if (inputElement) {
                    inputElement.value = imageData;
                } else {
                    console.warn(`Input field with ID "${inputId}" not found.`);
                }

                if (callback && typeof callback === "function") {
                    callback(imageData);
                } else {
                    alert("Screenshot captured successfully! Please click the 'Submit' button.");
                    $('.take_screen_button').hide();
                    $('.form_submit_button').show();
                }
            })
            .catch(error => {
                console.error("Error capturing the screenshot:", error);
            });
    }


                //
      @if (!empty($popup) && $popup->status == 'active')
        @if(!Session::get('popupShow'))
            //alert('fff');
            setTimeout(function(){ $('.newsShowPopupModal').modal('show');}, 1000);
            
        @else
            //alert('ddd');
            $('.newsShowPopupModal').modal('hide');
        @endif
      @endif

      function popupModalClose(){
          //alert('pop');
          @php
              Session::put('popupShow','show');
          @endphp
          $('.newsShowPopupModal').modal('hide');
      } 



          
      </script>
</body>
</html>
