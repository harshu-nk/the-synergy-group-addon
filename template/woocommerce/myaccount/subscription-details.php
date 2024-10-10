<?php

/**
 * Subscription details table
 *
 * @author  Prospress
 * @package WooCommerce_Subscription/Templates
 * @since 1.0.0 - Migrated from WooCommerce Subscriptions v2.2.19
 * @version 1.0.0 - Migrated from WooCommerce Subscriptions v2.6.5
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
$current_user_id = get_current_user_id();
$referrer_id = get_user_meta($current_user_id, 'referred_by', true);
$referrer = get_user_by('ID', $referrer_id);
$sf_balance = mycred_display_users_balance($current_user_id, 'synergy_francs');
?>
<div class="light-style input-small">

	<div class="account-text-block">
		<div class="account-title-block spb">
			<div class="title-content va">
				<img width="45" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/subscriptions.svg" alt="subscriptions icon" />
				<h5><?php _e('Subscriptions', ''); ?></h5>
			</div>
		</div>

		<div class="block-lines">

			<?php foreach ($subscription->get_items() as $item_id => $item) {
				$_product = apply_filters('woocommerce_subscriptions_order_item_product', $item->get_product(), $item);
				if (apply_filters('woocommerce_order_item_visible', true, $item)) { ?>
					<div class="block-line spb media-full">
						<div class="line-left">
							<p><?php _e('Current Subscription Plan', ''); ?></p>
						</div>
						<div class="line-right">
							<?php if ($_product && ! $_product->is_visible()) {
								echo wp_kses_post(apply_filters('woocommerce_order_item_name', $item['name'], $item, false));
							} else {
								echo wp_kses_post(apply_filters('woocommerce_order_item_name', sprintf('<p><strong>%s</strong></p>', $item['name']), $item, false));
							} ?>
						</div>
					</div>

					<div class="block-line spb">
						<div class="line-left">
							<p>Cycle: Annual or Monthly</p>
						</div>
						<div class="line-right">
							<p><strong><?php echo wc_get_order_item_meta($item_id, 'payment-plan', true); ?></strong></p>
						</div>
					</div>

					<div class="block-line spb">
						<div class="line-left">
							<p>Start Date</p>
						</div>
						<div class="line-right">
							<p><strong><?php echo date('Y/m/d', strtotime($subscription->get_date('start'))); ?></strong></p>
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
								<?php $upgrade_downgrade_url = esc_url(WC_Subscriptions_Switcher::get_switch_url($item_id, $item, $subscription)); ?>
								<a href="<?php echo $upgrade_downgrade_url; ?>" class="btn style2">upgrade</a>
							</div>
							<div class="btn-block">
								<a href="<?php echo $upgrade_downgrade_url; ?>" class="btn style2">Downgrade</a>
							</div>
							<div class="btn-block">
								<?php
								$current_status = $subscription->get_status();
								$cancel_url = wcs_get_users_change_status_link($subscription->get_id(), 'cancelled', $current_status); ?>
								<a href="<?php echo $cancel_url; ?>" class="btn style2">Cancel</a>
							</div>
						</div>
					</div>

					<div class="block-line spb">
						<div class="line-left">
							<p>Next Billing Date</p>
						</div>
						<div class="line-right">
							<p><strong><?php echo esc_html(date('Y/m/d', strtotime($subscription->get_date_to_display('next_payment')))); ?></strong></p>
						</div>
					</div>

					<div class="block-line spb media-full">
						<div class="line-left">
							<p>Affiliate (Referred by…)</p>
						</div>
						<div class="line-right">
							<?php if ($referrer) { ?>
								<p><strong><?php echo $referrer->display_name; ?></strong></p>
							<?php } ?>
						</div>
					</div>
			<?php }
			} ?>
		</div>
	</div>

	<div class="account-text-block">
		<div class="account-title-block spb media-full">
			<div class="title-content va">
				<img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/purchases.svg" alt="purchases icon" />
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
							<img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/stars.svg" class="stars" alt="stars 5" />
						</div>
						<img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/stars_light.svg" class="stars light" alt="no selected stars" />
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
				<img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/purchases.svg" alt="purchases icon" />
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
							<img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/stars.svg" class="stars" alt="stars 5" />
						</div>
						<img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/stars_light.svg" class="stars light" alt="no selected stars" />
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
				<img width="48" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/earnings2.svg" alt="earnings icon" />
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
				<img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/withdrawals.svg" alt="withdrawals icon" />
				<h5>Withdrawals</h5>
			</div>
		</div>

		<div class="block-lines media-full">

			<div class="block-line spb">
				<div class="line-left">
					<p>Available Balance</p>
				</div>
				<div class="line-right">
					<p class="main-val"><?php echo $sf_balance; ?></p>
				</div>
			</div>

			<div class="block-line spb small-line">
				<div class="line-left">
					<p>Withdrawal Request</p>
				</div>
				<div class="line-right input-field width2">
					<div class="btn-block">
						<a href="#" class="btn style2 w100 user-withdraw-btn">Withdrawal</a>
					</div>
					<form class="user-withdraw-form" action="" method="POST">
						<input type="hidden" name="form-type" value="withdraw-request" />
						<p class="form-row">
							<input type="number" class="woocommerce-Input woocommerce-Input--text input-text" name="withdraw_amount" id="withdraw_amount" value="<?php echo esc_attr($sf_balance); ?>" max="<?php echo esc_attr($sf_balance); ?>" />
						</p>
						<div class="btn-block">
							<button type="submit" class="btn style2 w100">Submit</button>
						</div>
					</form>
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