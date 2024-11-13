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
            <input type="text" id="tsg-admin-transaction-history-date-from" name="tsg-admin-transaction-history-date-from" data-position="bottom left" class="date-field" placeholder="Date From">
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

    <h6 class="borderb"><strong>Cash Flow Reports</strong></h6>
    <div class="messages tsg-display-transaction-history"></div>
    <div class="btn-block fl-end divide-top">
      <a href="#" class="btn btn-small minw" id="tsg-admin-transaction-filter-btn">Filter transactions</a>
    </div>
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
        <div class="line-right icon-right va">
          <p><strong>bank transfer</strong></p>
          <a href="#" class="icon-a"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon"></a>
        </div>
      </div>
      <div class="block-line spb">
        <div class="line-left">
          <p>Processing Payouts</p>
        </div>
        <div class="line-right icon-right va">
          <p><strong>schedule: 12.10.2024</strong></p>
          <a href="#" class="icon-a"><img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/edit.svg" alt="edit icon"></a>
        </div>
        <div class="btn-block fl-end divide-top">
          <a href="#" class="btn btn-small minw" id="tsg_save_payment_details">View payment history</a>
        </div>
      </div>
    </div>

    <h6 class="borderb"><strong>Payout History</strong></h6>
    <div class="messages" id="tsg_affiliate_payout_history">

    </div>
    <div class="btn-block fl-end divide-top">
      <a href="#" class="btn btn-small minw" id="tsg_view_payment_history">View payment history</a>
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
         