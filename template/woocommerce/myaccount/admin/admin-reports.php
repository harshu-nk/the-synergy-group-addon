<form class="light-style">
  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="avatar icon" />
        <h5>Generate Reports</h5>
      </div>
    </div>

    <div class="block-lines small-lines mt2">
      <div class="block-line spb">
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
            <input type="hidden" id="transaction-type" name="transaction-type" value="">
            <ul class="select-list hauto">
              <li>Transaction type 1</li>
              <li>Transaction type 2</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <h6><strong>Fee Collection</strong></h6>
    <div class="block-lines">

      <div class="block-line media-full spb">
        <div class="line-left">
          <p>Total Fees Collected</p>
        </div>
        <div class="line-right">
          <p class="main-val">SF 1,525 + CHF 590 </p>
        </div>
      </div>

      <div class="block-line spb">
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

    <h6><strong>Withdrawal Reports</strong></h6>
    <div class="block-lines">
      <div class="block-line spb">
        <div class="line-left">
          <p>Total Withdrawals</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 590</p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Pending</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 50</p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Approved</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 590</p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Rejected</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 50</p>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Fee Reversals</p>
        </div>
        <div class="line-right">
          <p class="main-val2">CHF 50</p>
        </div>
      </div>

      <div class="block-line spb small-line">
        <div class="line-left">
          <p><strong>Manual Fee Reports</strong></p>
        </div>
        <div class="line-right va btns-part">
          <div class="btn-block">
            <a href="#" class="btn style2 minw">Report Manual Fee</a>
          </div>
        </div>
      </div>
    </div>

    <h6><strong>Affiliate Performance Reports</strong></h6>
    <div class="block-lines">

      <div class="block-line media-full spb">
        <div class="line-left">
          <p>Total Affiliate Earnings</p>
        </div>
        <div class="line-right">
          <p class="main-val">SF 1,525 + CHF 590 </p>
        </div>
      </div>

      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Earning by Affiliate</p>
        </div>
        <div class="line-right input-field width4">
          <select id="affiliate" class="select2-list" placeholder="Select Affiliate">
            <option value="Option 1">Option 1</option>
            <option value="Option 2">Option 2</option>
            <option value="Option 3">Option 3</option>
            <option value="Option 4">Option 4</option>
            <option value="Option 5">Option 5</option>
            <option value="Option 6">Option 6</option>
            <option value="Option 7">Option 7</option>
            <option value="Option 8">Option 8</option>
            <option value="Option 9">Option 9</option>
            <option value="Option 10">Option 10</option>
          </select>
        </div>
      </div>

      <div class="block-line spb">
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

    <h6 class="mt25"><strong>Referral Impact Analysis</strong></h6>
    <div class="chart-image">
      <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/admin_reports_shart.png" alt="chart with columns" />
    </div>
    <div class="chart-colors va">
      <div class="chart-color va">
        <div class="line-square square-green"></div>
        <p>Subscription Revenue</p>
      </div>
      <div class="chart-color va">
        <div class="line-square square-violet"></div>
        <p>Transaction Fees Paid to Affiliates</p>
      </div>
    </div>

  </div>

  <div class="account-text-block">
    <div class="account-title-block spb">
      <div class="title-content va">
        <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
        <h5>Fee Usage Analytics:</h5>
      </div>
    </div>

    <div class="block-lines mt2">
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Trends in Fee Payments and Withdrawals</p>
        </div>
        <div class="line-right width-field width2">
          <div class="btn-block">
            <a href="#" class="btn style2 w100">analyze</a>
          </div>
        </div>
      </div>

      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Member Fee Contribution Analysis</p>
        </div>
        <div class="line-right width-field width2">
          <div class="btn-block">
            <a href="#" class="btn style2 w100">analyze</a>
          </div>
        </div>
      </div>
    </div>

    <h6><strong>Activity Reports for Referred Members</strong></h6>
    <div class="block-lines">
      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Transaction Frequency Reports</p>
        </div>
        <div class="line-right width-field width2">
          <div class="btn-block">
            <a href="#" class="btn style2 w100">view report</a>
          </div>
        </div>
      </div>

      <div class="block-line small-line spb">
        <div class="line-left">
          <p>Transaction Type Analysis</p>
        </div>
        <div class="line-right width-field width2">
          <div class="btn-block">
            <a href="#" class="btn style2 w100">analyze</a>
          </div>
        </div>
      </div>

      <div class="block-line spb">
        <div class="line-left">
          <p>Total Transaction Amounts</p>
        </div>
        <div class="line-right va">
          <p class="main-val2">SF 1,525 + CHF 590</p>
        </div>
      </div>
    </div>
  </div>
</form>
        