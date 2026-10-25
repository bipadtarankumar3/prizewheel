<!-- Campaign Information Card (Left Column Desktop / Second Section Mobile) -->
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

  <div class="brand_logo_wrapper">
    <div class="brand_logo_card">
      <img src="{{$user->logo}}" class="brand_logo_img" alt="Logo">
    </div>
  </div>

  @if ($Camping->title_status == 'on')
    <h1 class="campaign_main_title">{{$Camping->title}}</h1>
  @endif

  @if ($Camping->sub_title_status == 'on')
    <p class="campaign_sub_title">{{$Camping->sub_title}}</p>
  @endif

  <div class="meta_cards_grid">
    @if ($Camping->validity_status == 'on')
      <div class="meta_pill">
        <div class="meta_icon_circle meta_icon_validity">
          <i class="far fa-calendar-alt"></i>
        </div>
        <div class="meta_pill_content">
          <span class="meta_pill_label">Offer Validity</span>
          <span class="meta_pill_val">
            @php
              $startDate = date_create($Camping->start_date);
              $endDate = date_create($Camping->end_date);
            @endphp
            {{ date_format($startDate, "d M Y") }} &mdash; {{ date_format($endDate, "d M Y") }}
          </span>
        </div>
      </div>
    @endif

    @if ($SpinnerFormAccessCount != 'NO_LIMIT')
      <div class="meta_pill">
        <div class="meta_icon_circle meta_icon_spins">
          <i class="fas fa-sync-alt fa-spin-hover"></i>
        </div>
        <div class="meta_pill_content">
          <span class="meta_pill_label">Spin Limit Remaining</span>
          <span class="meta_pill_val meta_badge_number">
            <span class="spin_time_count">
              @php
                echo $count = $user->spin_whell_round - $SpinnerFormAccessCount;
              @endphp
            </span>
          </span>
        </div>
      </div>
    @endif
  </div>
</div>
