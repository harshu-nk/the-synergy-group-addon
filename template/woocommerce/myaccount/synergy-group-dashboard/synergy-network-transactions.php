<div class="account-text-block">
  <div class="account-title-block spb">
    <div class="title-content va">
      <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/payment.svg" alt="payment icon" />
      <h5>View All Transactions</h5>
    </div>
  </div>

  <div class="block-lines small-lines mt2 light-style">
    <form method="post">
      <div class="block-line spb">
        <div class="line-left">
          <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="tsg-all-transactions-date-from" name="date-from" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="tsg-all-transactions-date-to" name="date-to" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>

      <div class="block-line spb light-style">
        <div class="line-left">
          <p>Member:</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Any</span></p>
            <input type="hidden" id="all-transactions-member" name="member" value="Any" />
            <ul class="select-list hauto">
              <li>Member 1</li>
              <li>Member 2</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="block-line spb light-style">
        <div class="line-left">
          <p>Transaction Type:</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="all-transactions-transaction-type" name="transaction-type" value="" />
            <ul class="select-list hauto">
              <li>Transaction type 1</li>
              <li>Transaction type 2</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="block-line spb line-right">
        <div class="btn-block">
          <a href="#" class="btn" id="tsg-all-transactions-save-btn">View</a>
        </div>
      </div>
      <div id="tsg-all-transactions-error-msg" style="color: red;"></div>
    </form>
  </div>

  <h6><strong>Affliate Earnings:</strong></h6>
  <div class="messages">
    <div class="messages-sub-block">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction progress line icon "/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: John Troomer</strong><br>
            SF290 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction progress line icon "/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: Sarah Topler</strong><br>
            SF250 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="account-text-block">
  <div class="account-title-block spb">
    <div class="title-content va">
      <img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/pending_transactions.svg" alt="pending transactions icon" />
      <h5>Pending Transactions:</h5>
    </div>
  </div>
  
  <h6 class="borderb"><strong>List of pending buy/sell requests</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/alert_orange.svg" alt="alert icon "/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate Request</strong><br>
            SF290 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/alert_orange.svg" alt="alert icon "/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate Request</strong><br>
            SF250 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </div>

  <div class="block-lines2">
    <div class="block-line spb first">
      <div class="line-left">
        <p>Approval/Decline options</p>
      </div>
      <div class="line-right input-field btns-part va">
        <div class="btn-block">
          <a href="#" class="btn red-btn">Decline</a>
        </div>
        <div class="btn-block">
          <a href="#" class="btn style2">Approve</a>
        </div>
      </div>
    </div>
  </div>

  <h6 class="borderb"><strong>Pending Affiliate Adjustments</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/alert_orange.svg" alt="alert icon"/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate Adjustment</strong><br>
            SF290 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/alert_orange.svg" alt="alert icon"/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate Adjustment</strong><br>
            SF250 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="account-text-block">
  <div class="account-title-block spb" >
    <div class="title-content va">
      <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/payment.svg" alt="payment icon" />
      <h5>Transaction History:</h5>
    </div>
  </div>
  
  <div class="block-lines small-lines mt2" >
    <div class="block-line light-style">
      <form class="spb">
        <p class="search-p">Search:</p>
        <div class="search-line">
          <input type="text" id="tsg-transaction-search-value">
          <input type="submit" value="" id="tsg-transaction-search-submit">
        </div>
      </form>
    </div>
    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Period:</p>
      </div>
      <div class="line-right input-field width3 from-to-block va">
        <div class="from-to">
          <input type="text" id="tsg-transaction-history-date-from" name="date-from" data-position="bottom left" class="date-field" placeholder="Date From">
        </div>
        <div class="from-to-divider-block">
          <div class="from-to-divider"></div>
        </div>
        <div class="from-to">
          <input type="text" id="tsg-transaction-history-date-to" name="date-to" data-position="bottom left" class="date-field" placeholder="Date To">
        </div>
      </div>
    </div>

    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Member:</p>
      </div>
      <div class="line-right input-field width3">
        <div class="select">
          <p class="select-name"><span>Any</span></p>
          <input type="hidden" id="tsg-transaction-history-member" name="member" value="0" />
          <?php
            global $wpdb;
            $results = $wpdb->get_results("SELECT DISTINCT user_id FROM {$wpdb->prefix}myCRED_log");

            if ($results) {
                echo '<ul class="select-list hauto" id="tsg-transaction-history-member-list">';
                foreach ($results as $row) {
                    $user_info = get_userdata($row->user_id);
                    $user_name = $user_info ? $user_info->display_name : 'Unknown User';

                    echo '<li data-id="' . esc_attr($row->user_id) . '">' . esc_html($user_name) . '</li>';
                }
                echo '</ul>';
            } 
          ?>
        </div>
      </div>
    </div>

    <div class="block-line spb light-style">
      <div class="line-left">
        <p>Transaction Type:</p>
      </div>
      <div class="line-right input-field width3">
        <div class="select">
          <p class="select-name"><span>Select</span></p>
          <input type="hidden" id="tsg-history-transaction-type" name="transaction-type" value="" />
          <ul class="select-list hauto">
            <li>Transaction type 1</li>
            <li>Transaction type 2</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="block-line spb line-right">
      <div class="btn-block">
        <a href="#" class="btn" id="tsg-transaction-history-save">View</a>
      </div>
    </div>
    <div id="tsg-transaction-history-error-msg" style="color: red;"></div>
  </div>
  
  <h6 class="borderb" style="display: none;"><strong>Transaction History:</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord" id="tsg-display-transaction-history">
    </div>
  </div>

  <h6 class="borderb"><strong>Affiliate Transaction Details:</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction icon"/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: John Troomer</strong><br>
            SF290 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction icon"/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: Sarah Topler</strong><br>
            SF250 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

    </div>
  </div>

  <h6 class="borderb"><strong>SF Management for Affiliates:</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction icon"/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: John Troomer</strong><br>
            SF290 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction icon"/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: Sarah Topler</strong><br>
            SF250 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </div>

</div>
