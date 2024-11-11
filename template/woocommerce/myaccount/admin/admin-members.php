<form class="light-style">
  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="50" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/members2.svg" alt="members icon" />
        <h5>Member Fee Overview</h5>
      </div>
    </div>

    <div class="block-lines small-lines mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Total fees paid:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="date-from-total-fees-paid" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="date-to-total-fees-paid" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Outstanding fees:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="date-from-outstanding-fees" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="date-to-outstanding-fees" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Total withdrawals:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="date-from-total-withdrawals" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="date-to-total-withdrawals" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>

      </div>
    </div>

    <h6 class="borderb"><strong>List of all members</strong></h6>
    <div class="messages">
      <div class="messages-sub-block last-bord">
        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon ">
          </div>
          <div class="message-text">
            <p><strong>Affiliate member: John Troomer</strong><br>
              Total earnings: SF 923 (12 sales)<br>
              Total purchases: SF 654 (10 purchases)
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn">read more</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon ">
          </div>
          <div class="message-text">
            <p><strong>Affiliate member: Sarah Topler</strong><br>
              Total earnings: SF 923 (12 sales)<br>
              Total purchases: SF 654 (10 purchases)
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn">read more</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar_profile.svg" alt="avatar icon ">
          </div>
          <div class="message-text">
            <p><strong>Affiliate member: Sarah Topler</strong><br>
              Total earnings: SF 923 (12 sales)<br>
              Total purchases: SF 654 (10 purchases)
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
        <img width="50" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/members3.svg" alt="members icon" /> 
        <h5>Individual Member Details</h5>
      </div>
    </div>

    <div class="block-lines mt2">
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Select a Member</p>
        </div>
        <div class="line-right input-field width4">
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

      <div class="block-line spb">
        <div class="line-left">
          <p>Total fees paid by the member</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 350 + SF 950</p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Outstanding or pending fees</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 90 +SF 240</p>
        </div>
      </div>
    </div>

    <h6 class="borderb"><strong>Affiliate Earnings Reports:</strong></h6>
    <div class="messages">
      <div class="messages-sub-block last-bord">
        <div class="message-block spb">
          <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="transaction progress line icon ">
          </div>
          <div class="message-text">
            <p><strong>Collected Fees: SF 923 (12 sales)</strong><br>
              Service: Service name
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="transaction progress line icon ">
          </div>
          <div class="message-text">
            <p><strong>Collected Fees: SF 923 (12 sales)</strong><br>
              Service: Service name
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="transaction progress line icon ">
          </div>
          <div class="message-text">
            <p><strong>Collected Fees: SF 923 (12 sales)</strong><br>
              Service: Service name
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>
      </div>
    </div>

    <div class="block-lines">
      <div class="block-line fl-end line-continue-bot">
        <div class="line-right fl btns-part">
          <div class="btn-block">
            <a href="#" class="btn">history request</a>
          </div>
          <div class="btn-block">
            <a href="#" class="btn">Withdrawal request</a>
          </div>
        </div>
      </div>
    </div>


  </div>

</form>
         