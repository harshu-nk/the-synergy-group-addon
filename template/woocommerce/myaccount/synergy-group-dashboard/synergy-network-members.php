<div class="account-text-block">
  <div class="account-title-block spb">
    <div class="title-content va">
      <img width="40" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon" />
      <h5>Member Overview:</h5>
    </div>
  </div>

  <div class="block-lines small-lines mt2">
    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Filter by SF balance</p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>Select</span></p>
          <input type="hidden" id="" name="filter-sf-balance" value="" />
          <ul class="select-list hauto" id="tsg-sf-balance-range-list">
            <li class="tsg-select-option" data-id="">All</li>
            <li class="tsg-select-option" data-id="0">1-50</li>
            <li class="tsg-select-option" data-id="1">50-100</li>
            <li class="tsg-select-option" data-id="2">100-150</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Filter by Active/inactive status</p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>Select</span></p>
          <input type="hidden" id="" name="filter-status" value="" />
          <ul class="select-list hauto" id="tsg-member-status-list">
            <li class="tsg-select-option" data-id="">All</li>
            <li class="tsg-select-option" data-id="1">Active</li>
            <li class="tsg-select-option" data-id="0">Inactive</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="btn-block">
      <input type="hidden" id="tsg-member-status" name="member-status" value="" />
      <input type="hidden" id="tsg-sf-balance-range" name="sf-balance-range" value="" />
      <a href="#" class="btn" id="tsg-members-filter-btn">Filter</a>
    </div>
  </div>

  <h6 class="borderb tsg-entry-hidden" ><strong>List of all members</strong></h6>

    <div class="messages" id="tsg-members-filter-container">
    
    </div> 
</div>

<div class="account-text-block">
  <div class="account-title-block spb">
    <div class="title-content va">
      <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/member_details.svg" alt="member details icon" />
      <h5>Member Details:</h5>
    </div>
  </div>

  <div class="block-lines small-lines mt2">
    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Select a Member</p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>Select</span></p>
          <input type="hidden" id="tsg-member-member" name="member" value="" />
          <?php
            global $wpdb;
            $results = $wpdb->get_results("SELECT DISTINCT user_id FROM {$wpdb->prefix}myCRED_log");

            echo '<ul class="select-list hauto" id="tsg-member-member-list">';
            echo '<li data-id="0">Any</li>';
            if ($results) {
                foreach ($results as $row) {
                    $user_info = get_userdata($row->user_id);
                    $user_name = $user_info ? $user_info->display_name : 'Unknown User';

                    echo '<li data-id="' . esc_attr($row->user_id) . '">' . esc_html($user_name) . '</li>';
                }
            } 
            echo '</ul>';
          ?>
        </div>
      </div>
    </div>
    <div class="btn-block">
      <a href="#" class="btn" id="tsg-member-member-filter-btn">Filter</a>
    </div>
  </div>

  <div id="tsg-member-details-container">
  </div>

</div>

<!-- thid section -->
<div class="account-text-block">
  <div class="account-title-block spb">
    <div class="title-content va">
      <img width="60" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/adjust_member_sf.svg" alt="adjust meber SF icon" />
      <h5>Adjust Member SF:</h5>
    </div>
  </div>

  <div class="block-lines small-lines mt2">
    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Select a Member</p>
      </div>
      <div class="line-right input-field">
        <div class="select">
          <p class="select-name"><span>Select</span></p>
          <input type="hidden" id="tsg-sf-adjust-member" name="member2" value="" />
          <?php
            global $wpdb;
            $results = $wpdb->get_results("SELECT DISTINCT user_id FROM {$wpdb->prefix}myCRED_log");

            echo '<ul class="select-list hauto" id="tsg-sf-adjust-member-list">';
            if ($results) {
                foreach ($results as $row) {
                    $user_info = get_userdata($row->user_id);
                    $user_name = $user_info ? $user_info->display_name : 'Unknown User';

                    echo '<li data-id="' . esc_attr($row->user_id) . '">' . esc_html($user_name) . '</li>';
                }
            } 
            echo '</ul>';
          ?>
        </div>
      </div>
    </div>

    <div class="block-line fl-end">
      <div class="line-right fl btns-part">
        <div class="btn-block">
          <a href="#" class="btn" id="tsg-adjust-affiliate-earning-btn">Adjust AFFiliate Earnings</a>
        </div>
        <div class="btn-block">
          <a href="#" class="btn" id="tsg-adjust-sf-btn">adjust SF</a>
        </div>
      </div>
    </div>
    <div class="block-line light-style" id="tsg-adjust-sf-container">
        <div class="search-line">
          <input type="text" id="tsg-adjust-sf" placeholder="Enter SF Value">
        </div>
        <div class="btn-block">
          <a href="#" class="btn" id="tsg-adjust-sf-save">Adjust</a>
        </div>
    </div>
    <div class="block-line light-style" id="tsg-adjust-affiliate-earning-container" >
        <div class="search-line">
          <input type="text" id="tsg-adjust-affiliate-earning" placeholder="Enter New Affiliate Earnings">
        </div>
        <div class="btn-block">
          <a href="#" class="btn" id="tsg-adjust-affiliate-earning-save">Adjust</a>
        </div>
    </div>
    <div class="block-line light-style" id="tsg-adjust-msg-container"></div>
  </div>

</div>



          