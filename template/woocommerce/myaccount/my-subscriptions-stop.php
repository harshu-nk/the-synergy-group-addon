<?php
if (! defined('ABSPATH')) {
	exit;
}
$current_user_id = get_current_user_id();
$referrer_id = get_user_meta($current_user_id, 'referred_by', true);
$referrer = get_user_by('ID', $referrer_id);
$sf_balance = mycred_display_users_balance($current_user_id, 'synergy_francs');
?>
<div class="account-col-right">
		<div class="light-style input-small">

		<div class="account-text-block">
			<div class="account-title-block spb">
			<div class="title-content va">
				<img width="45" src="img/account/subscriptions.svg" alt="subscriptions icon" />
				<h5>Subscriptions</h5>
			</div>
			</div>

			<div class="block-lines">

			<div class="block-line spb media-full">
				<div class="line-left">
				<p>Current Subscription Plan</p>
				</div>
				<div class="line-right">
				<p><strong>Increase Reach</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Cycle: Annual or Monthly</p>
				</div>
				<div class="line-right">
				<p><strong>Annual</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Start Date</p>
				</div>
				<div class="line-right">
				<p><strong>2024/04/04</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Fee Model</p>
				</div>
				<div class="line-right">
				<p><strong>10%</strong></p>
				</div>
			</div>

			<div class="block-line spb small-line">
				<div class="line-left">
				<p>Change</p>
				</div>
				<div class="line-right va btns-part">
				<div class="btn-block">
					<a href="#" class="btn style2">upgrate</a>
				</div>
				<div class="btn-block">
					<a href="#" class="btn style2">Downgrade</a>
				</div>
				<div class="btn-block">
					<a href="#" class="btn style2">Cancel</a>
				</div>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Next Billing Date</p>
				</div>
				<div class="line-right">
				<p><strong>2025/04/04</strong></p>
				</div>
			</div>

			<div class="block-line spb media-full">
				<div class="line-left">
				<p>Affiliate (Referred by…)</p>
				</div>
				<div class="line-right">
				<p><strong>John Clarckson</strong></p>
				</div>
			</div>
			</div>
		</div>

		<div class="account-text-block">
			<div class="account-title-block spb media-full">
			<div class="title-content va">
				<img width="48" src="img/account/purchases.svg" alt="purchases icon" />
				<h5>Purchases</h5>
			</div>
			<div class="line-right input-field">
				<div class="select">
				<p class="select-name"><span>Apr 04 2024</span></p>
				<input type="hidden" id="data-export" name="data-export" value="Apr 04 2024" />
				<ul class="select-list hauto">
					<li>Apr 04 2024</li>
					<li>May 25 2024</li>
				</ul>
				</div>
			</div>
			</div>

			<div class="block-lines">

			<div class="block-line spb">
				<div class="line-left">
				<p>Service Name</p>
				</div>
				<div class="line-right">
				<p><strong>Super Service</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Service Provider</p>
				</div>
				<div class="line-right">
				<p><strong>Synergy</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Purchase Date</p>
				</div>
				<div class="line-right">
				<p><strong>2024/04/04</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Cost</p>
				</div>
				<div class="line-right">
				<p><strong>1,450 (CHF 360 + SF 1,090)</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Transaction Fees</p>
				</div>
				<div class="line-right">
				<p><strong>7.5%</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Affiliate Beneficiary</p>
				</div>
				<div class="line-right">
				<p><strong>John Clarckson</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Rating</p>
				</div>
				<div class="line-right">
				<div data-stars="3.4" class="stars-block">
					<div class="main-stars">
					<img src="img/stars.svg" class="stars" alt="stars 5" />
					</div>
					<img src="img/stars_light.svg" class="stars light" alt="no selected stars" />
				</div>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Review</p>
				</div>
				<div class="line-right textarea-field">
				<textarea id="review" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit,"></textarea>
				</div>
			</div>

			</div>
		</div>

		<div class="account-text-block">
			<div class="account-title-block spb media-full">
			<div class="title-content va">
				<img width="48" src="img/account/purchases.svg" alt="purchases icon" />
				<h5>Sales</h5>
			</div>
			<div class="line-right input-field">
				<div class="select">
				<p class="select-name"><span>Apr 04 2024</span></p>
				<input type="hidden" id="data-export" name="data-export" value="Apr 04 2024" />
				<ul class="select-list hauto">
					<li>Apr 04 2024</li>
					<li>May 25 2024</li>
				</ul>
				</div>
			</div>
			</div>

			<div class="block-lines">

			<div class="block-line spb">
				<div class="line-left">
				<p>Service Name</p>
				</div>
				<div class="line-right">
				<p><strong>Super Service</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Service Provider</p>
				</div>
				<div class="line-right">
				<p><strong>Synergy</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Purchase Date</p>
				</div>
				<div class="line-right">
				<p><strong>2024/04/04</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Cost</p>
				</div>
				<div class="line-right">
				<p><strong>1,450 (CHF 360 + SF 1,090)</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Transaction Fees</p>
				</div>
				<div class="line-right">
				<p><strong>7.5%</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Affiliate Beneficiary</p>
				</div>
				<div class="line-right">
				<p><strong>John Clarckson</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Rating</p>
				</div>
				<div class="line-right">
				<div data-stars="4.5" class="stars-block">
					<div class="main-stars">
					<img src="img/stars.svg" class="stars" alt="stars 5" />
					</div>
					<img src="img/stars_light.svg" class="stars light" alt="no selected stars" />
				</div>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Review</p>
				</div>
				<div class="line-right textarea-field">
				<textarea id="review" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt  consectetur adipiscing elit,"></textarea>
				</div>
			</div>

			</div>
		</div>

		<div class="account-text-block">
			<div class="account-title-block spb media-full">
			<div class="title-content va">
				<img width="48" src="img/account/earnings2.svg" alt="earnings icon" />
				<h6>My Affiliate Earnings</h6>
			</div>
			<div class="line-right input-field">
				<div class="select">
				<p class="select-name"><span>Apr 04 2024</span></p>
				<input type="hidden" id="data-export" name="data-export" value="Apr 04 2024" />
				<ul class="select-list hauto">
					<li>Apr 04 2024</li>
					<li>May 25 2024</li>
				</ul>
				</div>
			</div>
			</div>

			<div class="fl-end mt25">
			<p class="main-val">CHF 3600 + SF 1,090</p>
			</div>

			<div class="block-lines media-full">

			<div class="block-line spb">
				<div class="line-left">
				<p>Date</p>
				</div>
				<div class="line-right">
				<p><strong>2024/04/04</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Referred Member Name</p>
				</div>
				<div class="line-right">
				<p><strong>John Clarckson</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Referred Member Subscription Plan</p>
				</div>
				<div class="line-right">
				<p><strong>Starting Out</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Referred Member Fee</p>
				</div>
				<div class="line-right">
				<p><strong>10%</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Service/Product Purchased</p>
				</div>
				<div class="line-right">
				<p><strong>Super Service</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Transaction Amount (CHF)</p>
				</div>
				<div class="line-right">
				<p><strong>CHF 360 + SF 1,090</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Affiliate Fee Earned (CHF)</p>
				</div>
				<div class="line-right">
				<p><strong>CHF 36</strong></p>
				</div>
			</div>

			<div class="block-line spb">
				<div class="line-left">
				<p>Affiliate Fee Earned (SF)</p>
				</div>
				<div class="line-right">
				<p><strong>CHF 109</strong></p>
				</div>
			</div>

			</div>
		</div>

		<div class="account-text-block">
			<div class="account-title-block spb media-full">
			<div class="title-content va">
				<img width="55" src="img/account/withdrawals.svg" alt="withdrawals icon" />
				<h5>Withdrawals</h5>
			</div>
			</div>

			<div class="block-lines media-full">

			<div class="block-line spb">
				<div class="line-left">
				<p>Available Balance</p>
				</div>
				<div class="line-right">
				<p class="main-val">CHF 360</p>
				</div>
			</div>

			<div class="block-line spb small-line">
				<div class="line-left">
				<p>Withdrawal Request</p>
				</div>
				<div class="line-right input-field width2">
				<div class="btn-block">
					<a href="#" class="btn style2 w100">Withdrawal</a>
				</div>
				</div>
			</div>

			<div class="block-line spb small-line">
				<div class="line-left">
				<p>Withdrawal History</p>
				</div>
				<div class="line-right input-field width2">
				<div class="btn-block">
					<a href="#" class="btn style2 w100">Check history</a>
				</div>
				</div>
			</div>

			</div>
		</div>
		
		</div>
	</div>