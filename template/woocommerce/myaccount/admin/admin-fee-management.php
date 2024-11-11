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
            <input type="text" id="date-from" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="date-to" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Member</p>
        </div>
        <div class="line-right input-field width3">
          <select id="member" multiple class="select2-list" placeholder="Select">
            <option value="Member 1">Member 1</option>
            <option value="Member 2">Member 2</option>
            <option value="Member 3">Member 3</option>
            <option value="Member 4">Member 4</option>
            <option value="Member 5">Member 5</option>
            <option value="Member 6">Member 6</option>
            <option value="Member 7">Member 7</option>
            <option value="Member 8">Member 8</option>
            <option value="Member 9">Member 9</option>
            <option value="Member 10">Member 10</option>
          </select>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Transaction Type</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="transaction-type" name="transaction-type" value="">
            <ul class="select-list hauto">
              <li>Transaction Type 1</li>
              <li>Transaction Type 2</li>
              <li>Transaction Type 3</li>
              <li>Transaction Type 4</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Service Type</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="service-type" name="service-type" value="">
            <ul class="select-list hauto">
              <li>Service Type 1</li>
              <li>Service Type 2</li>
              <li>Service Type 3</li>
              <li>Service Type 4</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Affiliate</p>
        </div>
        <div class="line-right input-field width3">
          <select id="affiliate" class="select2-list">
            <option value="Option 1">Option 1</option>
            <option value="Option 2">Option 2</option>
            <option value="Option 3">Option 3</option>
            <option value="Option 4">Option 4</option>
            <option value="Option 5">Option 5</option>
            <option value="Option 6">Option 6</option>
            <option value="Option 7">Option 7</option>
            <option value="Option 7">Option 8</option>
            <option value="Option 7">Option 9</option>
            <option value="Option 7">Option 10</option>
        </select>
        </div>
      </div>

      <div class="block-line media-full spb">
        <div class="line-left">
          <p><strong>Total Fees Collected</strong></p>
        </div>
        <div class="line-right">
          <p class="main-val">SF 1,525 + CHF 590</p>
        </div>
      </div>

      <div class="block-line media-full spb">
        <div class="line-left">
          <p>Synergy Franc (SF)</p>
        </div>
        <div class="line-right">
          <p class="main-val2">SF 1,525</p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Cash (CHF)</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 590</p>
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
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="transaction-to-reverse" name="transaction-to-reverse" value="">
            <ul class="select-list hauto">
              <li>Option 1</li>
              <li>Option 2</li>
              <li>Option 3</li>
              <li>Option 4</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <p>Enter reason for reversal (required for audit)</p>
    <textarea id="greeting" class="mt20" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit,"></textarea>
    <div class="btn-block fl-end mt25">
      <a href="#" class="btn btn-small minw">Reverse Fees</a>
    </div>

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
          <select id="manual-fees-members" multiple class="select2-list" placeholder="Select">
            <option value="Member 1">Member 1</option>
            <option value="Member 2">Member 2</option>
            <option value="Member 3">Member 3</option>
            <option value="Member 4">Member 4</option>
            <option value="Member 5">Member 5</option>
            <option value="Member 6">Member 6</option>
            <option value="Member 7">Member 7</option>
            <option value="Member 8">Member 8</option>
            <option value="Member 9">Member 9</option>
            <option value="Member 10">Member 10</option>
          </select>
        </div>
      </div>

      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Adjust transaction</p>
        </div>
        <div class="line-right input-field width4">
          <input type="text" id="adjust-transaction" name="adjust-transaction">
        </div>
      </div>
    </div>
    
    <div class="btn-block fl-end mt25">
      <a href="#" class="btn btn-small minw">Assign fee</a>
    </div>

  </div>

</form>
         