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

  <h6 class="borderb" id="tsg-members-filter-container-label tsg-entry-hidden" ><strong>List of all members</strong></h6>

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
          <input type="hidden" id="member" name="member" value="Bella Tomson" />
          <ul class="select-list hauto">
            <li>Bella Tomson</li>
            <li>Member 2</li>
            <li>Member 3</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="block-line spb">
      <div class="line-left">
        <p>Individual member SF balance</p>
      </div>
      <div class="line-right va">
        <p class="main-val2">SF 1,200</p>
      </div>
    </div>
  </div>

  <h6 class="borderb"><strong>Transaction history </strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/transactions_blue.svg" alt="transaction progress line icon "/>
        </div>
        <div class="message-text">
          <p><strong>Transaction 001 (Sell)</strong><br>
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
          <p><strong>Transaction 002 (Buy)</strong><br>
            SF250 (affiliate partnership program)
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </div>

  <div class="block-lines2 big-p">
    <div class="block-line spb first">
      <div class="line-left">
        <p>Affiliate Earnings:</p>
      </div>
      <div class="line-right va">
        <p class="main-val2">CHF 400 + SF 1,200</p>
      </div>
    </div>
  </div>

  <h6 class="borderb"><strong>Referred Members:</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar.svg" alt="avatar icon "/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: John Troomer</strong><br>
            Transaction fees SF290
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>

      <div class="message-block spb">
        <div class="text-icon">
          <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/avatar.svg" alt="avatar icon "/>
        </div>
        <div class="message-text">
          <p><strong>Affiliate member: Sarah Topler</strong><br>
            Transaction fees SF250
          </p>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </div>

  <h6 class="borderb"><strong>Referral Activity:</strong></h6>
  <div class="messages">
    <div class="messages-sub-block last-bord">
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
          <p class="select-name"><span>Bella Tomson</span></p>
          <input type="hidden" id="member2" name="member2" value="Bella Tomson" />
          <ul class="select-list hauto">
            <li>Bella Tomson</li>
            <li>Member 2</li>
            <li>Member 3</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="block-line fl-end">
      <div class="line-right fl btns-part">
        <div class="btn-block">
          <a href="#" class="btn">Adjust AFFiliate Earnings</a>
        </div>
        <div class="btn-block">
          <a href="#" class="btn">adjust SF</a>
        </div>
      </div>
    </div>
  </div>

</div>



          