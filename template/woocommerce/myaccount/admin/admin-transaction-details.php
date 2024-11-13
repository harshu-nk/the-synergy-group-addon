<form class="account-col-right light-style">
  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions2.svg" alt="transactions icon" />
        <h5>View All Transactions</h5>
      </div>
    </div>

    <div class="block-lines mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="tsg-admin-all-transaction-history-date-from" name="" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="tsg-admin-all-transaction-history-date-to" name="tsg-admin-all-transaction-history-date-to" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>
      <div class="block-line spb light-style">
        <div class="line-left">
          <p>Member:</p>
        </div>
        <div class="line-right input-field width3">
          <select id="admin-all-affiliate-member" class="select2-list"></select>
        </div>
      </div>
      <div class="block-line spb">
        <div class="line-left">
          <p>Transaction Type</p>
        </div>
        <div class="line-right input-field width3">
          <select id="admin-all-affiliate-transaction-type" class="select2-list"></select>
        </div>
      </div>
    </div>
    <div class="btn-block fl-end">
      <a href="#" class="btn btn-small minw" id="tsg-admin-all-transaction-filter-btn">Filter transactions</a>
    </div>
    <h6 class="borderb tsg-admin-cash-flow-title" style="display: none;"><strong>Transactions</strong></h6>
    <div class="messages tsg-display-transaction-history"></div>

  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions2.svg" alt="transactions icon" />
        <h5>Transaction History</h5>
      </div>
    </div>

    <div class="block-lines small-lines mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="date-from2" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="date-to2" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Member:</p>
        </div>
        <div class="line-right input-field width3">
          <select id="transaction-history-members" multiple class="select2-list" placeholder="Select">
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
          <p>Transaction Type:</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="transaction-type2" name="transaction-type2" value="">
            <ul class="select-list hauto">
              <li>Transaction type 1</li>
              <li>Transaction type 2</li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <h6 class="borderb"><strong>Transaction History</strong></h6>
    <div class="messages">
      <div class="messages-sub-block last-bord">
        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar.svg" alt="transaction progress line icon" />
          </div>
          <div class="message-text">
            <p><strong>Transaction 02.09.2024 - 13:57</strong><br>
              SF290 (affiliate partnership program)`
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar.svg" alt="transaction progress line icon" />
          </div>
          <div class="message-text">
            <p><strong>Transaction 02.09.2024 - 13:57</strong><br>
              SF290 (affiliate partnership program)`
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar.svg" alt="transaction progress line icon" />
          </div>
          <div class="message-text">
            <p><strong>Transaction 02.09.2024 - 13:57</strong><br>
              SF290 (affiliate partnership program)`
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="text-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar.svg" alt="transaction progress line icon" />
          </div>
          <div class="message-text">
            <p><strong>Transaction 02.09.2024 - 13:57</strong><br>
              SF290 (affiliate partnership program)`
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/fee_money.svg" alt="transactions icon" />
        <h5>Fee Breakdown</h5>
      </div>
    </div>

    <div class="block-lines small-lines mt2">
      <div class="block-line spb">
        <div class="line-left">
          <p>Period:</p>
        </div>
        <div class="line-right input-field width3 from-to-block va">
          <div class="from-to">
            <input type="text" id="date-from3" name="date" data-position="bottom left" class="date-field" placeholder="Date From">
          </div>
          <div class="from-to-divider-block">
            <div class="from-to-divider"></div>
          </div>
          <div class="from-to">
            <input type="text" id="date-to3" name="date" data-position="bottom left" class="date-field" placeholder="Date To">
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Member:</p>
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
          </select>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Transaction Type:</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="transaction-type3" name="transaction-type3" value="">
            <ul class="select-list hauto">
              <li>Transaction type 1</li>
              <li>Transaction type 2</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Fee Type:</p>
        </div>
        <div class="line-right input-field width3">
          <div class="select">
            <p class="select-name"><span>Select</span></p>
            <input type="hidden" id="fee-type3" name="fee-type3" value="">
            <ul class="select-list hauto">
              <li>Fee type 1</li>
              <li>Fee type 2</li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <h6 class="borderb"><strong>Collected fees</strong></h6>
    <div class="messages">
      <div class="messages-sub-block last-bord">
        <div class="message-block spb">
          <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
          </div>
          <div class="message-text">
            <p><strong>Affiliate member: John Troomer</strong><br>
              Collected Fees: SF 923 (12 sales)<br>
              Service: Service name
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
          </div>
          <div class="message-text">
            <p><strong>Affiliate member: Sarah Topler</strong><br>
              Collected Fees: SF 923 (12 sales)<br>
              Service: Service name
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

        <div class="message-block spb">
          <div class="message-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
          </div>
          <div class="message-text">
            <p><strong>Affiliate member: Sarah Topler</strong><br>
              Collected Fees: SF 923 (12 sales)<br>
              Service: Service name
            </p>
          </div>
          <div class="btn-block">
            <a href="#" class="btn minw2">view</a>
          </div>
        </div>

      </div>
    </div>

  </div>
</form>
         