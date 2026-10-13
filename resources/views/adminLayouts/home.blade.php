<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/minisidebar/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 28 Jul 2023 05:22:23 GMT -->
<head>

  <!-- Title -->

  <title>Admin</title>


  <!-- Required Meta Tag -->

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="handheldfriendly" content="true" />
  <meta name="MobileOptimized" content="width" />
  <meta name="description" content="Admin" />
  <meta name="author" content="" />
  <meta name="keywords" content="Admin" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />


  <!-- Favicon -->

  <link rel="shortcut icon" type="image/png" href="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" />
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">


  <!-- Core Css -->

  <link rel="stylesheet" href="{{asset('adminAssets/libs/owl.carousel/dist/assets/owl.carousel.min.css')}}">

  <link rel="stylesheet" href="{{asset('adminAssets/css/style.min.css')}}" />
  
  {{-- <link rel="stylesheet" href="{{asset('adminAssets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}"> --}}
  <link rel="stylesheet" href="{{asset('adminAssets/css/my-style.css')}}?v={{ time() }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

  <style>
    /* Mobile Offcanvas Sidebar: Guaranteed Closed on Screens < 992px */
    @media (max-width: 991.98px) {
      #main-wrapper .left-sidebar,
      .left-sidebar,
      aside.left-sidebar {
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        left: -300px !important;
        transform: translateX(-100%) !important;
        width: 275px !important;
        max-width: 85vw !important;
        z-index: 1060 !important;
        background: #ffffff !important;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), left 0.3s ease !important;
        box-shadow: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 100vh !important;
        overflow-y: auto !important;
      }

      #main-wrapper.show-sidebar .left-sidebar,
      #main-wrapper.show-sidebar aside.left-sidebar {
        left: 0 !important;
        transform: translateX(0) !important;
        visibility: visible !important;
        opacity: 1 !important;
        box-shadow: 0 10px 40px rgba(15, 23, 42, 0.45) !important;
      }

      .sidebar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(3px);
        z-index: 1055;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease, visibility 0.25s ease;
        pointer-events: none;
      }

      #main-wrapper.show-sidebar .sidebar-backdrop {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
      }

      #main-wrapper .body-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        padding-top: 0 !important;
        margin-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }

      #main-wrapper .app-header,
      .app-header {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 64px !important;
        z-index: 1040 !important;
        margin: 0 !important;
        padding: 0 12px !important;
      }

      #main-wrapper .body-wrapper > .container-fluid,
      .body-wrapper > .container-fluid {
        padding-top: 76px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
        padding-bottom: 30px !important;
      }
    }

    @media (min-width: 992px) {
      #main-wrapper .left-sidebar,
      .left-sidebar,
      aside.left-sidebar {
        position: fixed !important;
        left: 0 !important;
        transform: none !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 260px !important;
        z-index: 1000 !important;
      }

      #main-wrapper .body-wrapper {
        margin-left: 260px !important;
        width: calc(100% - 260px) !important;
        padding-top: 0 !important;
        margin-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }

      #main-wrapper .app-header,
      .app-header {
        position: fixed !important;
        top: 0 !important;
        left: 260px !important;
        width: calc(100% - 260px) !important;
        height: 70px !important;
        z-index: 1040 !important;
        margin: 0 !important;
      }

      #main-wrapper .body-wrapper > .container-fluid,
      .body-wrapper > .container-fluid {
        padding-top: 85px !important;
        padding-left: 20px !important;
        padding-right: 20px !important;
        padding-bottom: 40px !important;
      }
    }
  </style>

</head>

<body>


  <!-- Body Wrapper -->

  <div class="page-wrapper " id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <div class="">
    <!-- Sidebar Start -->

    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <!-- Brand Logo -->
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{URL::to('admin/dashboard')}}" class="sidebar-brand-link">
              @if(!empty(Auth::user()->logo))
                <img src="{{Auth::user()->logo}}" class="rounded-3 shadow-sm" style="height: 38px; width: 38px; object-fit: cover;" alt="Logo" />
              @else
                <div class="sidebar-brand-icon">
                  <i class="ti ti-aperture"></i>
                </div>
              @endif
              <div class="sidebar-brand-text">
                Prize<span>Wheel</span>
              </div>
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8 text-muted"></i>
            </div>
          </div>

          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
              <!-- ============================= -->
              <!-- Home -->
              <!-- ============================= -->
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
              </li>
              <!-- =================== -->
              <!-- Dashboard -->
              <!-- =================== -->
              @if (Auth::user()->type  == 'admin')
                <li class="sidebar-item {{ Request::is('admin/dashboard*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{URL::to('admin/dashboard')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-layout-dashboard"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/sub_user_list*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/sub_user_list*') ? 'active' : '' }}" href="{{URL::to('admin/sub_user_list')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-users"></i>
                    </span>
                    <span class="hide-menu">User</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/notice*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/notice*') ? 'active' : '' }}" href="{{URL::to('admin/notice')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-speakerphone"></i>
                    </span>
                    <span class="hide-menu">Notice</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/popup_alert*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/popup_alert*') ? 'active' : '' }}" href="{{URL::to('admin/popup_alert')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-device-desktop"></i>
                    </span>
                    <span class="hide-menu">Popup</span>
                  </a>
                </li>
                <!-- <li class="sidebar-item {{ Request::is('admin/expired_camping_list*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/expired_camping_list*') ? 'active' : '' }}" href="{{URL::to('admin/expired_camping_list')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-calendar-off"></i>
                    </span>
                    <span class="hide-menu">Expired camping list</span>
                  </a>
                </li> -->
              @else
                <li class="sidebar-item {{ Request::is('admin/dashboard*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" href="{{URL::to('admin/dashboard')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-layout-dashboard"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/camping_list*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/camping_list*') ? 'active' : '' }}" href="{{URL::to('admin/camping_list')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-sparkles"></i>
                    </span>
                    <span class="hide-menu">Campaign</span>
                  </a>
                </li>
                
                <li class="sidebar-item {{ Request::is('admin/spinner_list*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/spinner_list*') ? 'active' : '' }}" href="{{URL::to('admin/spinner_list')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-disc"></i>
                    </span>
                    <span class="hide-menu">Spinner</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/spinner_form_camping_list*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/spinner_form_camping_list*') ? 'active' : '' }}" href="{{URL::to('admin/spinner_form_camping_list')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-forms"></i>
                    </span>
                    <span class="hide-menu">Spinner Enquiry</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/bike_model*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/bike_model*') ? 'active' : '' }}" href="{{URL::to('admin/bike_model')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-adjustments"></i>
                    </span>
                    <span class="hide-menu">Choose Option</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/form_access*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/form_access*') ? 'active' : '' }}" href="{{URL::to('admin/form_access')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-list-details"></i>
                    </span>
                    <span class="hide-menu">Form Fields Access</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/ip_skip*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/ip_skip*') ? 'active' : '' }}" href="{{URL::to('admin/ip_skip')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-shield-lock"></i>
                    </span>
                    <span class="hide-menu">IP Skip</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/notice*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/notice*') ? 'active' : '' }}" href="{{URL::to('admin/notice')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-speakerphone"></i>
                    </span>
                    <span class="hide-menu">Notice</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/popup_alert*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/popup_alert*') ? 'active' : '' }}" href="{{URL::to('admin/popup_alert')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-device-desktop"></i>
                    </span>
                    <span class="hide-menu">Popup</span>
                  </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/expired_camping_list*') ? 'selected' : '' }}">
                  <a class="sidebar-link {{ Request::is('admin/expired_camping_list*') ? 'active' : '' }}" href="{{URL::to('admin/expired_camping_list')}}" aria-expanded="false">
                    <span>
                      <i class="ti ti-calendar-off"></i>
                    </span>
                    <span class="hide-menu">Expired Campaigns</span>
                  </a>
                </li>
              @endif
            </ul>
          </nav>

          <!-- Sidebar user footer card -->
          <div class="sidebar-user-footer-card">
            <div class="sidebar-user-avatar">
              {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
              <span class="sidebar-user-online-dot"></span>
            </div>
            <div class="sidebar-user-details">
              <span class="sidebar-user-name" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
              <span class="sidebar-user-badge">
                @if(session()->has('impersonated_by_admin'))
                  Store (Impersonated)
                @else
                  {{ Auth::user()->type == 'admin' ? 'Super Admin' : '1-Day Trial' }}
                @endif
              </span>
            </div>
            @if(session()->has('impersonated_by_admin'))
              <a href="{{ URL::to('admin/return_to_admin') }}" class="sidebar-user-return-btn" title="Back to Super Admin">
                <i class="ti ti-arrow-back-up"></i>
              </a>
            @else
              <a href="{{ URL::to('logout') }}" class="sidebar-user-logout" title="Sign Out">
                <i class="ti ti-logout"></i>
              </a>
            @endif
          </div>

        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop"></div>

    <!-- Sidebar End -->
    <!-- Main wrapper -->

    <div class="body-wrapper">

      <!-- Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          
          <!-- Left: Hamburger Toggler & Greeting -->
          <div class="d-flex align-items-center gap-2">
            <a class="nav-link sidebartoggler p-1 text-dark" id="headerCollapse" href="javascript:void(0)" title="Toggle Sidebar">
              <i class="ti ti-menu-2 fs-6"></i>
            </a>
            <div class="d-none d-lg-flex flex-column ms-1" style="line-height: 1.2;">
              <span class="text-muted" style="font-size: 11px;">Welcome back,</span>
              <span class="fw-bold text-dark text-truncate" style="font-size: 13.5px; max-width: 180px;">{{ Auth::user()->name }}</span>
            </div>
          </div>

          <!-- Center: Notice Announcement Ticker -->
          <div class="d-none d-xl-flex align-items-center ms-3 flex-grow-1" style="max-width: 360px;">
            @php
              $notice = DB::table('notices')->first();
            @endphp
            @if ($notice != '' && $notice->status == 'active')
              <div class="header-notice-pill">
                <span class="badge rounded-pill bg-danger text-white me-2 px-2 py-1" style="font-size:10px;"><i class="ti ti-speakerphone me-1"></i> NOTICE</span>
                <span class="text-truncate" style="max-width: 250px;">{{ $notice->notice }}</span>
              </div>
            @endif
          </div>

          <!-- Mobile Toggler -->
          <button class="navbar-toggler p-0 border-0 d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="p-2"><i class="ti ti-dots fs-7"></i></span>
          </button>

          <!-- Right: Badges, Actions, Profile -->
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="d-flex align-items-center justify-content-between">
              <ul class="navbar-nav flex-row ms-auto align-items-center gap-2">

                @if(session()->has('impersonated_by_admin'))
                  <!-- RETURN TO ADMIN NAVBAR BUTTON -->
                  <li class="nav-item">
                    <a href="{{ URL::to('admin/return_to_admin') }}" class="btn-return-admin-nav-pill" title="Exit store view and return to Super Admin">
                      <span class="admin-pulse-dot"></span>
                      <i class="ti ti-arrow-back-up"></i>
                      <span>Back to Admin</span>
                    </a>
                  </li>
                @endif

                @if(Auth::user()->type == 'user')
                  <!-- TRIAL ACCESS EXPIRATION BUTTON -->
                  @php
                    $userExpiry = Auth::user()->expiry_date;
                    $daysRemaining = 1;
                    if (!empty($userExpiry)) {
                        $expiryDate = \Carbon\Carbon::parse($userExpiry)->endOfDay();
                        $nowDate = \Carbon\Carbon::now();
                        $daysRemaining = max(0, (int)$nowDate->diffInDays($expiryDate, false));
                    }
                  @endphp

                  <li class="nav-item">
                    <a href="{{URL::to('admin/profile')}}" class="trial-expiry-pill-btn" title="View your subscription & account details">
                      <span class="trial-pulse-dot"></span>
                      @if($daysRemaining <= 1)
                        <span>Only <strong>1 day left</strong> to expire your account access</span>
                      @else
                        <span><strong>{{ $daysRemaining }} days left</strong> to expire access</span>
                      @endif
                      <span class="trial-renew-action">Renew <i class="ti ti-arrow-right"></i></span>
                    </a>
                  </li>

                  <!-- Customer Spin Mode Dropdown Trigger & Modal -->
                  <li class="nav-item dropdown d-none d-lg-block">
                    <a class="qr-flow-trigger-btn" href="javascript:void(0)" id="qrFlowDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Switch Spin Wheel Mode">
                      <span class="qr-flow-dot"></span>
                      @if(Auth::user()->default_spinn == 2)
                        <i class="ti ti-chart-pie fs-4"></i>
                        <span>Chances Mode</span>
                      @else
                        <i class="ti ti-bolt fs-4"></i>
                        <span>Skip Mode</span>
                      @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-end qr-flow-dropdown dropdown-menu-animate-up border-0" aria-labelledby="qrFlowDropdown">
                      
                      <!-- Header -->
                      <div class="qr-flow-header">
                        <div class="d-flex align-items-center justify-content-between">
                          <div class="d-flex align-items-center gap-2">
                            <div class="qr-flow-header-icon">
                              <i class="ti ti-disc"></i>
                            </div>
                            <span class="fw-bold fs-4 text-white">Spin Wheel Algorithm</span>
                          </div>
                          <span class="qr-flow-badge-landing">Wheel Mode</span>
                        </div>
                        <p class="mb-0 text-white-50 fs-2 mt-2">
                          Choose how prizes are given to customers when they spin:
                        </p>
                      </div>

                      <!-- Body Cards -->
                      <div class="qr-flow-body">
                        
                        <!-- Option 1: Chances Mode -->
                        <div class="qr-flow-card {{ Auth::user()->default_spinn == 2 ? 'active' : '' }}">
                          <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                              <div class="qr-flow-icon-circle qr-flow-icon-star">
                                <i class="ti ti-percentage"></i>
                              </div>
                              <span class="fw-bold text-dark fs-3">Chances Mode</span>
                              <span class="qr-flow-tag-recommended">Recommended</span>
                            </div>
                            <div>
                              @if(Auth::user()->default_spinn == 2)
                                <span class="qr-flow-btn-active-badge"><i class="ti ti-check"></i> ACTIVE</span>
                              @else
                                <form action="{{ URL::to('admin/change_spin_mode') }}" method="POST" class="m-0">
                                  @csrf
                                  <input type="hidden" name="spin_mode" value="2">
                                  <button type="submit" class="qr-flow-btn-activate">Activate</button>
                                </form>
                              @endif
                            </div>
                          </div>
                          <div class="d-flex align-items-start gap-2 fs-2 text-dark mb-2">
                            <i class="ti ti-check text-success fs-4 mt-1 flex-shrink-0"></i>
                            <span><strong>More Quantity = More Wins:</strong> Set higher chances for prizes you have more stock of so they win more often.</span>
                          </div>
                          <div class="d-flex align-items-start gap-2 fs-2 text-dark">
                            <i class="ti ti-ban text-danger fs-4 mt-1 flex-shrink-0"></i>
                            <span><strong>Chance 0 = Never Won:</strong> Any prize set with <strong>0 chances</strong> will <strong>never</strong> be won.</span>
                          </div>
                        </div>

                        <!-- Option 2: Skip Mode -->
                        <div class="qr-flow-card {{ Auth::user()->default_spinn == 1 ? 'active' : '' }}">
                          <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                              <div class="qr-flow-icon-circle qr-flow-icon-bolt">
                                <i class="ti ti-bolt"></i>
                              </div>
                              <span class="fw-bold text-dark fs-3">Skip Mode</span>
                              <span class="qr-flow-tag-direct">Direct</span>
                            </div>
                            <div>
                              @if(Auth::user()->default_spinn == 1)
                                <span class="qr-flow-btn-active-badge"><i class="ti ti-check"></i> ACTIVE</span>
                              @else
                                <form action="{{ URL::to('admin/change_spin_mode') }}" method="POST" class="m-0">
                                  @csrf
                                  <input type="hidden" name="spin_mode" value="1">
                                  <button type="submit" class="qr-flow-btn-activate">Activate</button>
                                </form>
                              @endif
                            </div>
                          </div>
                          <div class="d-flex align-items-start gap-2 fs-2 text-dark mb-2">
                            <i class="ti ti-player-skip-forward text-primary fs-4 mt-1 flex-shrink-0"></i>
                            <span><strong>Skip = Never Ever Won:</strong> Slices marked with <strong>"Skip"</strong> will <strong>never ever</strong> be won as a prize.</span>
                          </div>
                          <div class="d-flex align-items-start gap-2 fs-2 text-dark">
                            <i class="ti ti-gift text-primary fs-4 mt-1 flex-shrink-0"></i>
                            <span><strong>Active Prizes Only:</strong> Customers only win from available prizes that have quantity and are not skipped.</span>
                          </div>
                        </div>

                      </div>

                      <!-- Footer Action -->
                      <div class="qr-flow-footer">
                        <a href="{{ URL::to('u/' . Auth::user()->name_url) }}" target="_blank" class="qr-flow-preview-btn">
                          <i class="ti ti-external-link"></i> Test & Preview Live Spin Wheel
                        </a>
                      </div>

                    </div>
                  </li>
                @endif

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown ms-1">
                  <a class="header-profile-btn" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ !empty(Auth::user()->logo) ? Auth::user()->logo : asset('adminAssets/images/profile/user-1.jpg') }}" class="header-profile-avatar" alt="Avatar" />
                    <span class="header-profile-name d-none d-md-inline-block">{{ Str::limit(Auth::user()->name, 12) }}</span>
                    <i class="ti ti-chevron-down header-profile-chevron"></i>
                  </a>

                  <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up border-0" 
                       style="min-width: 330px; border-radius: 20px; box-shadow: 0 20px 45px -8px rgba(15, 23, 42, 0.16), 0 0 0 1px rgba(15, 23, 42, 0.05); overflow: hidden; padding: 0;" 
                       aria-labelledby="drop1">
                    <div class="profile-dropdown position-relative p-0" data-simplebar>
                      
                      <!-- User Header Profile Card -->
                      <div class="p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-bottom: 1px solid #f1f5f9;">
                        <img src="{{ !empty(Auth::user()->logo) ? Auth::user()->logo : asset('adminAssets/images/profile/user-1.jpg') }}" 
                             class="rounded-3 shadow-sm border" 
                             width="54" height="54" 
                             style="object-fit: cover; border-color: #e2e8f0 !important;" 
                             alt="User Avatar" />
                        <div class="overflow-hidden" style="line-height: 1.35;">
                          <h6 class="mb-0 text-dark fw-bold text-truncate" style="font-size: 14.5px;">{{ Auth::user()->name }}</h6>
                          <div class="text-muted text-truncate my-1" style="font-size: 11.5px;">{{ Auth::user()->email }}</div>
                          <span class="badge" style="background: rgba(255, 107, 0, 0.1); color: #ea580c; border: 1px solid rgba(255, 107, 0, 0.2); font-size: 10px; font-weight: 700; border-radius: 9999px; padding: 2px 8px;">
                            {{ Auth::user()->type == 'admin' ? '🛡 Administrator' : '✨ 1-Day Free Trial' }}
                          </span>
                        </div>
                      </div>

                      <!-- Impersonated Store View Notice -->
                      @if(session()->has('impersonated_by_admin'))
                        <div class="m-3 p-3 rounded-3" style="background: #0f172a; color: #ffffff; box-shadow: 0 6px 18px rgba(15, 23, 42, 0.15);">
                          <div class="d-flex align-items-center justify-content-between mb-1.5">
                            <span style="font-size: 11.5px; font-weight: 800; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 4px;">
                              <i class="ti ti-shield-lock"></i> Store View Mode
                            </span>
                            <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; font-size: 9.5px; border: 1px solid rgba(52, 211, 153, 0.3); border-radius: 9999px; padding: 2px 7px;">
                              Active
                            </span>
                          </div>
                          <p class="mb-2 text-white-50" style="font-size: 11px; line-height: 1.35;">
                            Viewing store as <strong class="text-white">{{ Auth::user()->name }}</strong>. Switch back anytime.
                          </p>
                          <a href="{{ URL::to('admin/return_to_admin') }}" 
                             class="btn btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1.5 shadow-sm" 
                             style="background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%); color: #ffffff; border: none; border-radius: 10px; padding: 7px 12px; font-size: 12px; box-shadow: 0 3px 10px rgba(255, 107, 0, 0.3);">
                            <i class="ti ti-arrow-back-up"></i> Switch Back to Admin
                          </a>
                        </div>
                      @endif

                      <!-- Navigation Menu List -->
                      <div class="p-2" style="display: flex; flex-direction: column; gap: 2px;">
                        @if (Auth::user()->type == 'admin')
                          <a href="{{URL::to('admin/sitesetting')}}" class="d-flex align-items-center gap-2.5 p-2 rounded-3 text-dark text-decoration-none" style="transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div style="width: 34px; height: 34px; border-radius: 9px; background: #f5f3ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                              <i class="ti ti-settings"></i>
                            </div>
                            <span class="fw-semibold text-dark" style="font-size: 13px;">Site Settings</span>
                            <i class="ti ti-chevron-right ms-auto text-muted" style="font-size: 12px; opacity: 0.4;"></i>
                          </a>
                        @endif

                        <a href="{{URL::to('admin/profile')}}" class="d-flex align-items-center gap-2.5 p-2 rounded-3 text-dark text-decoration-none" style="transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                          <div style="width: 34px; height: 34px; border-radius: 9px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                            <i class="ti ti-user"></i>
                          </div>
                          <span class="fw-semibold text-dark" style="font-size: 13px;">Account &amp; Profile</span>
                          <i class="ti ti-chevron-right ms-auto text-muted" style="font-size: 12px; opacity: 0.4;"></i>
                        </a>

                        @if (Auth::user()->type == 'user')
                          <a href="{{URL::to('admin/print_qr_code')}}" target="_blank" class="d-flex align-items-center gap-2.5 p-2 rounded-3 text-dark text-decoration-none" style="transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div style="width: 34px; height: 34px; border-radius: 9px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                              <i class="ti ti-qrcode"></i>
                            </div>
                            <span class="fw-semibold text-dark" style="font-size: 13px;">Download QR Stand</span>
                            <i class="ti ti-external-link ms-auto text-muted" style="font-size: 12px; opacity: 0.4;"></i>
                          </a>

                          <a href="{{URL::to('u/'.Auth::user()->name_url)}}" target="_blank" class="d-flex align-items-center gap-2.5 p-2 rounded-3 text-dark text-decoration-none" style="transition: all 0.2s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div style="width: 34px; height: 34px; border-radius: 9px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                              <i class="ti ti-world"></i>
                            </div>
                            <span class="fw-semibold text-dark" style="font-size: 13px;">Visit Live Site</span>
                            <i class="ti ti-external-link ms-auto text-muted" style="font-size: 12px; opacity: 0.4;"></i>
                          </a>

                          <a href="javascript:void(0)" onclick="clearAllSpain()" class="d-flex align-items-center gap-2.5 p-2 rounded-3 text-danger text-decoration-none" style="transition: all 0.2s ease;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                            <div style="width: 34px; height: 34px; border-radius: 9px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                              <i class="ti ti-trash"></i>
                            </div>
                            <span class="fw-semibold text-danger" style="font-size: 13px;">Clear Test Cookies</span>
                            <i class="ti ti-chevron-right ms-auto text-danger" style="font-size: 12px; opacity: 0.4;"></i>
                          </a>
                        @endif
                      </div>

                      <!-- Sign Out Button Footer -->
                      <div class="p-3 border-top" style="background: #ffffff;">
                        <a href="{{URL::to('logout')}}" 
                           class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2" 
                           style="background: #f8fafc; color: #dc2626; border: 1.5px solid #fee2e2; border-radius: 12px; padding: 9px; font-size: 13px; transition: all 0.2s ease;"
                           onmouseover="this.style.background='#fef2f2'; this.style.borderColor='#fca5a5';"
                           onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#fee2e2';">
                          <i class="ti ti-logout"></i> Sign Out
                        </a>
                      </div>

                    </div>
                  </div>
                </li>

              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Header End -->
      
        @yield('content')
      
    </div>
    </div>
  </div>


 

  <!--  Mobilenavbar -->
  <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
    aria-labelledby="offcanvasWithBothOptionsLabel">
    <nav class="sidebar-nav scroll-sidebar">
      <div class="offcanvas-header justify-content-between">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico" alt="" class="img-fluid">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body profile-dropdown mobile-navbar" data-simplebar="" data-simplebar>
        <ul id="sidebarnav">
          <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
              <span>
                <i class="ti ti-apps"></i>
              </span>
              <span class="hide-menu">Apps</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level my-3">
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-chat.svg" alt="" class="img-fluid" width="24" height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Chat Application</h6>
                    <span class="fs-2 d-block fw-normal text-muted">New messages arrived</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-invoice.svg" alt="" class="img-fluid" width="24"
                      height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Invoice App</h6>
                    <span class="fs-2 d-block fw-normal text-muted">Get latest invoice</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-mobile.svg" alt="" class="img-fluid" width="24"
                      height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Contact Application</h6>
                    <span class="fs-2 d-block fw-normal text-muted">2 Unsaved Contacts</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-message-box.svg" alt="" class="img-fluid" width="24"
                      height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Email App</h6>
                    <span class="fs-2 d-block fw-normal text-muted">Get new emails</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-cart.svg" alt="" class="img-fluid" width="24" height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">User Profile</h6>
                    <span class="fs-2 d-block fw-normal text-muted">learn more information</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-date.svg" alt="" class="img-fluid" width="24" height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Calendar App</h6>
                    <span class="fs-2 d-block fw-normal text-muted">Get dates</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-lifebuoy.svg" alt="" class="img-fluid" width="24"
                      height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Contact List Table</h6>
                    <span class="fs-2 d-block fw-normal text-muted">Add new contact</span>
                  </div>
                </a>
              </li>
              <li class="sidebar-item py-2">
                <a href="#" class="d-flex align-items-center">
                  <div class="bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-dd-application.svg" alt="" class="img-fluid" width="24"
                      height="24">
                  </div>
                  <div class="d-inline-block">
                    <h6 class="mb-1 bg-hover-primary">Notes Application</h6>
                    <span class="fs-2 d-block fw-normal text-muted">To-do and Daily tasks</span>
                  </div>
                </a>
              </li>
              <ul class="px-8 mt-7 mb-4">
                <li class="sidebar-item mb-3">
                  <h5 class="fs-5 fw-semibold">Quick Links</h5>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">Pricing Page</a>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">Authentication Design</a>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">Register Now</a>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">404 Error Page</a>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">Notes App</a>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">User Application</a>
                </li>
                <li class="sidebar-item py-2">
                  <a class="fw-semibold text-dark" href="#">Account Settings</a>
                </li>
              </ul>
            </ul>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="app-chat.html" aria-expanded="false">
              <span>
                <i class="ti ti-message-dots"></i>
              </span>
              <span class="hide-menu">Chat</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="app-calendar.html" aria-expanded="false">
              <span>
                <i class="ti ti-calendar"></i>
              </span>
              <span class="hide-menu">Calendar</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="app-email.html" aria-expanded="false">
              <span>
                <i class="ti ti-mail"></i>
              </span>
              <span class="hide-menu">Email</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>


  <!-- Search Bar -->

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content rounded-1">
        <div class="modal-header border-bottom">
          <input type="search" class="form-control fs-3" placeholder="Search here" id="search" />
          <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
            <i class="ti ti-x fs-5 ms-3"></i>
          </span>
        </div>
        <div class="modal-body message-body" data-simplebar="">
          <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
          <ul class="list mb-0 py-2">
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Modern</span>
                <span class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Dashboard</span>
                <span class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Contacts</span>
                <span class="fs-3 text-muted d-block">/apps/contacts</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Posts</span>
                <span class="fs-3 text-muted d-block">/apps/blog/posts</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Detail</span>
                <span
                  class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Shop</span>
                <span class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Modern</span>
                <span class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Dashboard</span>
                <span class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Contacts</span>
                <span class="fs-3 text-muted d-block">/apps/contacts</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Posts</span>
                <span class="fs-3 text-muted d-block">/apps/blog/posts</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Detail</span>
                <span
                  class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
              </a>
            </li>
            <li class="p-1 mb-1 bg-hover-light-black">
              <a href="#">
                <span class="fs-3 text-black fw-normal d-block">Shop</span>
                <span class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  @php
    $popup = DB::table('popupalerts')->where('user_type','admin')->where('status','active')->orderBy('id','desc')->first();
    $needsFirstLoginProfile = (Auth::check() && Auth::user()->type == 'user' && (session('google_first_login_modal') || empty(Auth::user()->phone)));
  @endphp
  @if (!empty($popup) && !$needsFirstLoginProfile)
  <!-- Modern Styled Popup Alert Modal -->
  <div class="modal fade newsShowPopupModal" id="newsShowPopupModal" tabindex="-1" aria-labelledby="newsShowPopupModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modern-popup-modal-content">
        
        <!-- Radiant Gradient Accent Bar -->
        <div class="popup-gradient-bar"></div>

        <!-- Modal Header -->
        <div class="popup-modal-header">
          <div class="d-flex align-items-center gap-3">
            <div class="popup-header-icon-box">
              <i class="ti ti-sparkles"></i>
            </div>
            <div>
              <span class="popup-category-badge">
                <i class="ti ti-bell-ringing"></i> Official Notice
              </span>
              <h4 class="popup-modal-title mb-0" id="newsShowPopupModalLabel">
                {{ $popup->title ?? 'Welcome to Digital Spin Wheel' }}
              </h4>
            </div>
          </div>
          <button type="button" class="popup-circle-close-btn" onclick="popupModalClose()" data-bs-dismiss="modal" aria-label="Close" title="Close announcement">
            <i class="ti ti-x"></i>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="popup-modal-body pb-4">
          @if (!empty($popup->popup_img))
            <div class="popup-image-showcase-frame mb-0">
              <img src="{{ $popup->popup_img }}" alt="{{ $popup->title ?? 'Announcement' }}" class="popup-main-image" loading="lazy">
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>
  @endif


<div class="modal fade quotation ClearAllSpainModal"  tabindex="-1" aria-labelledby="smallQuoteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"  style="width: 95%;">

        <div class="modal-body">

          <div class="" style="float: right;">
              <button type="button" class="btn-close popup_close"  onclick="popupModalClose()" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fas fa-times"></i>
              </button>
          </div>
            <div class="modal-content">

              <form action="{{URL::to('admin/spin_pi_clear')}}" method="POST" style="padding: 25px;">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="delete_conformation">Type <span style="color: red">Delete</span> For Clear Cookies</label>
                    <input type="text" name="delete_conformation" onkeyup="delete_confirmation_type(this.value)"  class="form-control" id="delete_conformation" placeholder="Delete conformation" style="    margin-top: 10px;" required>
                  </div>
             
                  
                </div>
                <div class="form-row text-right" style="    margin-top: 10px;
    text-align: end;">
                  <div class="form-group col-md-12">
                   <button class="btn btn-danger delete_conformation_btn" disabled>Submit</button>
                  </div>
             
                  
                </div>
              </form>
                
            </div>
          
        </div>

      </div>
    </div>
  </div>



  <!-- Customizer -->
  <!-- Import Js Files -->
  <script src="{{asset('adminAssets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('adminAssets/libs/simplebar/dist/simplebar.min.js')}}"></script>
  <script src="{{asset('adminAssets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <!-- core files -->
  <script src="{{asset('adminAssets/js/app.min.js')}}"></script>
  <script src="{{asset('adminAssets/js/app.minisidebar.init.js')}}"></script>
  <script src="{{asset('adminAssets/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('adminAssets/js/custom.js')}}"></script>
  <script>
    $(function () {
      if ($(window).width() >= 992) {
        $("#main-wrapper").attr("data-sidebartype", "full").removeClass("mini-sidebar");
      } else {
        $("#main-wrapper").removeClass("show-sidebar");
      }

      // Close mobile sidebar on backdrop or close icon click
      $('#sidebarBackdrop, #sidebarCollapse').on('click', function() {
        $('#main-wrapper').removeClass('show-sidebar');
      });

      // Close mobile sidebar on navigation link click
      $('.sidebar-nav .sidebar-link').on('click', function() {
        if ($(window).width() < 992) {
          $('#main-wrapper').removeClass('show-sidebar');
        }
      });
    });
  </script>
  <!-- current page js files -->
  <script src="{{asset('adminAssets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{asset('adminAssets/js/dashboard4.js')}}"></script>
  {{-- <script src="{{asset('adminAssets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script> --}}

  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <!-- Toastr -->

  
  <script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">



  @yield('js')

 

  <script>
    @if(Session::has('messege'))
    var type = "{{Session::get('alert-type','info')}}";
    switch (type) {
        case 'info':
            toastr.info("{{Session::get('messege')}}");
            bresk;
        case 'success':
            toastr.success("{{Session::get('messege')}}");
            bresk;
        case 'worning':
            toastr.worning("{{Session::get('messege')}}");
            bresk;
        case 'error':
            toastr.error("{{Session::get('messege')}}");
            bresk;
    }
    @endif


    
    function dataDelete(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute(
            'href'
            ); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
        console.log(urlToRedirect); // verify if this is the right URL
        swal({
            title: "Are you sure",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                window.location.href = urlToRedirect;
            } else {
                return false;
            }
        });
    }


    // Auto show active popup alert
    @if (!empty($popup) && $popup->status == 'active')
      if (!sessionStorage.getItem('popupDismissed')) {
        setTimeout(function(){ 
          if ($('#firstLoginModal').length === 0) {
            $('.newsShowPopupModal').modal('show');
          }
        }, 600);
      }
    @endif

    function popupModalClose(){
      sessionStorage.setItem('popupDismissed', 'true');
      $('.newsShowPopupModal').modal('hide');
    } 

    function clearAllSpain(){

        $('.ClearAllSpainModal').modal('show');
    } 



    function delete_confirmation_type(data) {
      if (data == 'Delete') {
          $('.delete_conformation_btn').removeAttr('disabled');  // Enable the button
      } else {
          $('.delete_conformation_btn').attr('disabled', 'disabled');  // Disable the button
      }
    }

    @if(Auth::check() && Auth::user()->type == 'user' && (session('google_first_login_modal') || empty(Auth::user()->phone)))
      $(document).ready(function() {
        if ($('#firstLoginModal').length) {
          $('.newsShowPopupModal').modal('hide');
          $('#firstLoginModal').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#firstLoginModal').modal('show');

          $('#firstLoginModal').on('shown.bs.modal', function () {
            var $phoneInput = $(this).find('input[name="phone"]');
            if ($phoneInput.length) {
              $phoneInput.focus();
            }
          });
        }
      });
    @endif

  </script>

  @if(Auth::check() && Auth::user()->type == 'user' && (session('google_first_login_modal') || empty(Auth::user()->phone)))
  <!-- Mandatory First Login Profile Completion Modal -->
  <div class="modal fade" id="firstLoginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="firstLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
      <div class="modal-content first-login-modal-content border-0 shadow-lg">
        <div class="modal-header first-login-modal-header border-0 flex-column align-items-start position-relative">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-white text-dark fw-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
              <i class="ti ti-rocket text-primary me-1"></i> 1-Day Trial Active
            </span>
          </div>
          <h4 class="modal-title fw-bold text-white mb-1" id="firstLoginModalLabel">
            Complete Your Business Profile
          </h4>
          <p class="text-white-50 fs-3 mb-0" style="line-height: 1.4;">
            Welcome to PrizeWheel! Please fill in your contact & business details to activate your 1-day free trial dashboard.
          </p>
        </div>
        <form action="{{ route('complete_first_login_profile') }}" method="POST">
          @csrf
          <div class="modal-body first-login-modal-body p-4">
            
            <div class="mb-3">
              <label class="form-label fw-bold text-dark fs-3 mb-1">Business / Store Name <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="ti ti-building-store"></i></span>
                <input type="text" name="name" class="form-control border-start-0" value="{{ Auth::user()->name }}" required placeholder="e.g. Apex Dental Clinic" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold text-dark fs-3 mb-1">WhatsApp / Contact Number <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="ti ti-brand-whatsapp text-success"></i></span>
                <input type="tel" name="phone" id="firstLoginPhone" class="form-control border-start-0" value="{{ Auth::user()->phone }}" required placeholder="10 Digit Mobile / WhatsApp Number" autocomplete="tel" />
              </div>
              <small class="text-muted fs-2">We send spin notifications and customer leads to this WhatsApp number.</small>
            </div>

            <div class="mb-3">
              <label class="form-label fw-bold text-dark fs-3 mb-1">Custom URL Slug <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 fs-2 text-muted">/u/</span>
                <input type="text" name="name_url" class="form-control border-start-0" value="{{ Auth::user()->name_url }}" required placeholder="my_business" />
              </div>
              <small class="text-muted fs-2">Your public customer link: <strong>{{ url('u/' . (Auth::user()->name_url ?: 'my_business')) }}</strong></small>
            </div>


          </div>
          <div class="modal-footer bg-light border-0 px-4 py-3 justify-content-between">
            <span class="text-muted fs-2"><i class="ti ti-shield-check text-success"></i> Secure & encrypted</span>
            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" style="background: linear-gradient(135deg, #ff6b00 0%, #ea580c 100%); border: none;">
              <span>Activate & Launch Dashboard</span> <i class="ti ti-arrow-right ms-1"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif

</body>


<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/minisidebar/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 28 Jul 2023 05:22:25 GMT -->
</html>