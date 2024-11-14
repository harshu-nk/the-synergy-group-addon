<form class="light-style">

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon" />
        <h5>Affiliate Profiles</h5>
      </div>
      <div class="line-right input-field">
        <select id="affiliate-profiles" class="select2-list">
        </select>
      </div>
    </div>
    <div class="block-lines mt2" id="tsg-affiliate-profiles-container">
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Affiliate ID</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>.....</strong></p>
        </div>
      </div>
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Total Number of Referrals</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>.....</strong></p>
        </div>
      </div>
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Earnings from Referrals</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>.....</strong></p>
        </div>
      </div>
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Affiliate Status</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>.....</strong></p>
        </div>
      </div>
    </div>
    <div class="btn-block fl-end mt25">
      <a href="#" class="btn btn-small minw" id="tsg-affiliate-profiles-status-change">Change Status</a>
    </div>
    <div class="" id="tsg-affiliate-profiles-error-message" style="color: red;"></div>
  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/recent_transavtions.svg" alt="recent transactions icon" />
        <h5>Affiliate Transactions</h5>
      </div>
    </div>
    <div class="block-lines mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="tsg-admin-transaction-history-date-from" name="" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="tsg-admin-transaction-history-date-to" name="tsg-admin-transaction-history-date-to" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>
      <div class="block-line spb light-style">
        <div class="line-left">
          <p>Member:</p>
        </div>
        <div class="line-right input-field width3">
          <select id="admin-affiliate-member" class="select2-list"></select>
        </div>
      </div>
      <div class="block-line spb">
        <div class="line-left">
          <p>Transaction Type</p>
        </div>
        <div class="line-right input-field width3">
          <select id="admin-affiliate-transaction-type" class="select2-list"></select>
        </div>
      </div>
    </div>
    <div class="btn-block fl-end">
      <a href="#" class="btn btn-small minw" id="tsg-admin-transaction-filter-btn">Filter transactions</a>
    </div>
    <h6 class="borderb tsg-admin-cash-flow-title" style="display: none;"><strong>Cash Flow Reports</strong></h6>
    <div class="messages tsg-display-transaction-history"></div>
    
  </div>

  <div class="account-text-block">
    <div class="account-title-block va">
      <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/earnings.svg" class="mr2" alt="payment icon" />
      <h5>Affiliate Payments</h5>
    </div>

    <div class="block-lines big-p mt2 media-full">
      <div class="block-line spb">
        <div class="line-left">
          <p>Setup Payout Methods</p>
        </div>
        <?php 
          global $wpdb;
          $current_user_id = get_current_user_id();

          $payment_method = get_user_meta($current_user_id, 'payment_method', true);
          $payment_schedule = get_user_meta($current_user_id, 'payment_schedule', true);
          $payment_method = !empty($payment_method) ? esc_html($payment_method) : 'Not Set';
          $payment_schedule = !empty($payment_schedule) ? esc_html($payment_schedule) : 'Not Set';
        ?>
        <div class="line-right icon-right va">
          <p><strong id="tsg-admin-setup-payment-method-display"><?php echo $payment_method; ?></strong></p>
          <a href="#" class="icon-a tsg-item-toggle-btn" data-target="#tsg-admin-setup-payment-method-container"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon"></a>
        </div>
      </div>
      <div class="block-line spb" id="tsg-admin-setup-payment-method-container" style="display: none;">
        <div class="line-left icon-right va">
          <select id="tsg-admin-setup-payment-method" class="select2-list">
            <option value="invoice">Invoice</option>
            <option value="bank_transfer">Bank Transfer</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="stripe">Stripe</option>
            <option value="cash_on_delivery">Cash on Delivery</option>
          </select>
        </div>
        <div class="line-left fl-end ">
          <a href="#" class="btn btn-small minw" id="tsg_save_payment_method">Save</a>
        </div>
      </div>
      <div class="block-line spb">
        <div class="line-left">
          <p>Processing Payouts</p>
        </div>
        <div class="line-right icon-right va">
          <p><strong>schedule: <span id="tsg-admin-schedule-display"><?php echo $payment_schedule; ?></span></strong></p>
          <a href="#" class="icon-a tsg-item-toggle-btn" data-target="#tsg-admin-schedule-container"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon"></a>
        </div>
      </div>
      <div class="block-line spb" id="tsg-admin-schedule-container" style="display: none;">
        <div class="line-right icon-right va">
          <input type="date" id="tsg-admin-schedule-date" name="" data-position="bottom left" class="date-field" placeholder="Date">
        </div>
        <div class="line-left fl-end">
          <a href="#" class="btn btn-small minw" id="tsg_admin_save_schedule">Save</a>
        </div>
      </div>
      <div id="tsg-payment-method-save-error" style="display:none"></div>
      
    </div>
    <div class="btn-block fl-end divide-top">
      <a href="#" class="btn btn-small minw" id="tsg_view_payment_history">View payment history</a>
    </div>
    <h6 class="borderb tsg-admin-payout-history-title" style="display: none;"><strong>Payout History</strong></h6>
    <div class="messages" id="tsg_affiliate_payout_history">
    </div>

  </div>

  <div class="account-text-block">
    <?php
      global $wpdb;
      $user_id = get_current_user_id();
      $affiliate_commission_data = get_user_meta($user_id, 'affiliate_commission_rate', true);
      $commission_rate = isset($affiliate_commission_data['rate']) ? $affiliate_commission_data['rate'] : 'Not set';
    ?>
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="50" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/fee_money.svg" alt="fee adjustments icon">
        <h5>Fee Adjustments</h5>
      </div>
    </div>
    <div class="block-lines big-p mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Adjust Fee Earnings</p>
        </div>
        <div class="line-right icon-right va light-style">
          <p><strong id="tsg-commission-rate-display"><?php echo esc_html($commission_rate) . '%'; ?></strong></p>
          <a href="#" class="icon-a tsg-item-toggle-btn" data-target="#tsg-commisson-rate-container" id="tsg-commisson-rate-toggle"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon"></a>
        </div>
      </div>

      <div class="spb" id="tsg-commisson-rate-container" style="display: none;">
        <div class="block-line">
          <div class="line-left">
            <p>Adjust Commission rate</p>
          </div>
          <div class="line-right icon-right va light-style">
            <p class="form-row">
              <input type="number" min="0" max="100" class="input-text" name="tsg-commission-rate-input" id="tsg-commission-rate-input" value="" />
            </p>
          </div>
        </div>
        <div class="block-line">
          <div class="line-left">
            <p>Reason</p>
          </div>
          <div class="line-right icon-right va light-style">
            <p class="form-row">
              <input type="text"  class="input-text" name="tsg-commission-reason" id="tsg-commission-reason" autocomplete="given-name" value="" />
            </p>
          </div>
        </div>
        <div class="block-line line-right va btns-part">
          <div class="btn-block">
            <a href="#" class="btn style2 minw" id="tsg-adjust-fee-commission">Change</a>
          </div>
        </div>
      </div>

      <div id="tsg-commission-rate-error"></div>
      <div class="block-line spb small-line">
        <div class="line-left">
          <p>Dispute Resolution</p>
        </div>
        <div class="line-right va btns-part">
          <div class="btn-block">
            <a href="<?php site_url(); ?>/my-account/admin-help-support/" class="btn style2 minw">raise disputes</a>
          </div>
        </div>
      </div>
      <div class="block-line spb small-line">
        <div class="line-left">
          <p>Audit Trail</p>
        </div>
        <div class="line-right va btns-part">
          <div class="btn-block">
            <a href="#" class="btn style2 minw" id="tsg-affiliate-audit-btn">Audit Trial</a>
          </div>
        </div>
      </div>
      <div class="block-line spb small-line" id="tsg-affiliate-audit-container" ></div>
    </div>

  </div>

</form>
         