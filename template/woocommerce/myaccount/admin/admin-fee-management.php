<form class="light-style">

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/earnings.svg" alt="earnings icon" />
        <h5>Collected Fees Overview</h5>
      </div>
    </div>
    <div class="block-lines mt2">
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
          <input type="text" id="tsg-admin-fee-overview-date-from" name="" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
          <input type="text" id="tsg-admin-fee-overview-date-to" name="tsg-admin-fee-overview-date-to" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Member</p>
        </div>
        <div class="line-right input-field width3">
          <select id="admin-fee-overview-member" class="select2-list"></select>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Transaction Type</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <select id="tsg-admin-fee-overview-transaction-type" class="select2-list">
              <option value="" disabled selected>Select transaction type</option>
              <option value="buy_service">Buy service</option>
              <option value="sale_of_service">Sale of service</option>
            </select>
          </div>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Service Type</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <select id="tsg-admin-fee-overview-service-type" class="select2-list">
            </select>
          </div>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Affiliate</p>
        </div>
        <div class="line-right input-field width3">
          <select id="tsg-admin-fee-overview-affiliate-fees" class="select2-list">
            <option value="" disabled selected>Affiliate fee</option>
            <option value="buyer_ref_fee">Buyer ref fee</option>
            <option value="seller_ref_fee">Seller ref fee</option>
          </select>
        </div>
      </div>
      <div class="block-line spb" id="tsg-admin-fee-overview-error" style="display: none;"></div>
      <div class="block-line fl-end mt25">
        <a href="#" class="btn btn-small minw" id="tsg-fee-overview-filter-btn">Filter</a>
      </div>

      <div class="block-line media-full spb">
        <div class="line-left">
          <p><strong>Total Fees Collected</strong></p>
        </div>
        <div class="line-right">
          <p class="main-val">SF <span class="tsg-fee-overview-sf">0</span> + CHF 0</p>
        </div>
      </div>

      <div class="block-line media-full spb">
        <div class="line-left">
          <p>Synergy Franc (SF)</p>
        </div>
        <div class="line-right">
          <p class="main-val2">SF <span class="tsg-fee-overview-sf">0</span></p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Cash (CHF)</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 0</p>
        </div>
      </div>
    </div>
  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="50" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/fee_money.svg" alt="fee icon" />
        <h5>Pending Fees</h5>
      </div>
    </div>

    <div class="block-lines">
      <div class="block-line spb">
        <div class="line-left">
          <p>Due Fees</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 525</p>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p>Due Fees List</p>
        </div>
        <div class="line-right va btns-part">
          <div class="btn-block">
            <a href="#" class="btn">collect overdue fees</a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="messages">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon" />
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: John Troomer</strong><br>
            (Activity: 7 - Referrals Count: 12)</p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn minw2">view</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon" />
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: Sarah Topler</strong><br>
            (Activity: 5 - Referrals Count: 9)</p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn minw2">view</a>
        </div>
      </div>
    </div>

    <div class="block-lines mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Pending Fees</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 590</p>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><strong>Pending Fees List</strong></p>
        </div>
        <div class="line-right va btns-part">
          <div class="btn-block">
            <a href="#" class="btn">collect overdue fees</a>
          </div>
        </div>
      </div>
    </div>

    <div class="messages">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon" />
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: John Troomer</strong><br>
            (Activity: 7 - Referrals Count: 12)</p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn minw2">view</a>
        </div>
      </div>

      <div class="message-block last-bord spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon" />
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: Sarah Topler</strong><br>
            (Activity: 5 - Referrals Count: 9)</p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn minw2">view</a>
        </div>
      </div>
    </div>

  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="50" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/fee_money.svg" alt="fee icon" />
        <h5>Reverse Fees</h5>
      </div>
    </div>

    <div class="block-lines mt2">
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Select transaction to reverse fees</p>
        </div>
        <div class="line-right input-field width2">
          <div class="select">
          <select id="tsg-admin-reverse-transaction" class="select2-list">
              <option value="" disabled selected>Select a service</option>
              <?php echo tsg_get_unique_services_with_ref_id(); ?>
          </select>
          </div>
        </div>
      </div>
    </div>
    
    <p>Enter reason for reversal (required for audit)</p>
    <textarea id="tsg-admin-reverse-transaction-reason" class="mt20" placeholder=""></textarea>
    <div class="btn-block fl-end mt25">
      <a href="#" class="btn btn-small minw" id="tsg-admin-reverse-transaction-btn">Reverse Fees</a>
    </div>
    <div class="block-line spb" id="tsg-admin-reverse-transaction-msg" style="display: none;"></div>
  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="50" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/fee_money.svg" alt="fee icon" />
        <h5>Manual Fees</h5>
      </div>
    </div>

    <div class="block-lines mt2">
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Select member or transaction</p>
        </div>
        <div class="line-right input-field width4">
          <select id="admin-manual-fee-member" class="select2-list"></select>
        </div>
      </div>

      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Adjust transaction</p>
        </div>
        <div class="line-right input-field width4">
          <input type="number" id="tsg-admin-manual-fee" name="">
        </div>
      </div>
    </div>
    
    <div class="btn-block fl-end mt25">
      <a href="#" class="btn btn-small minw" id="tsg-admin-manual-fee-btn">Assign fee</a>
    </div>
    <div class="block-line spb" id="tsg-admin-manual-fee-msg" style="display: none;"></div>
  </div>

</form>
         