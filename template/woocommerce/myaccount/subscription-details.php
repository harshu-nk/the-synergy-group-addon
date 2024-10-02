<?php
/**
 * Subscription details table
 *
 * @author  Prospress
 * @package WooCommerce_Subscription/Templates
 * @since 1.0.0 - Migrated from WooCommerce Subscriptions v2.2.19
 * @version 1.0.0 - Migrated from WooCommerce Subscriptions v2.6.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
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

  <?php foreach ( $subscription->get_items() as $item_id => $item ) {
			$_product = apply_filters( 'woocommerce_subscriptions_order_item_product', $item->get_product(), $item );
			if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) { ?>
	<div class="block-line spb media-full">
	  <div class="line-left">
		<p><?php _e('Current Subscription Plan', ''); ?></p>
	  </div>
	  <div class="line-right">
	  <?php if ( $_product && ! $_product->is_visible() ) {
				echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false ) );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', sprintf( '<p><strong>%s</strong></p>', $item['name'] ), $item, false ) );
			} ?>
	  </div>
	</div>

	<div class="block-line spb">
	  <div class="line-left">
		<p>Cycle: Annual or Monthly</p>
	  </div>
	  <div class="line-right">
		<p><strong><?php echo wc_get_order_item_meta( $item_id , 'payment-plan', true ); ?></strong></p>
	  </div>
	</div>

	<div class="block-line spb">
	  <div class="line-left">
		<p>Start Date</p>
	  </div>
	  <div class="line-right">
		<p><strong><?php echo date('Y/m/d', strtotime($subscription->get_date( 'start' ))); ?></strong></p>
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
			<?php $upgrade_downgrade_url = esc_url( WC_Subscriptions_Switcher::get_switch_url( $item_id, $item, $subscription ) ); ?>
		  	<a href="<?php echo $upgrade_downgrade_url; ?>" class="btn style2">upgrade</a>
		</div>
		<div class="btn-block">
		  <a href="<?php echo $upgrade_downgrade_url; ?>" class="btn style2">Downgrade</a>
		</div>
		<div class="btn-block">
			<?php 
			$current_status = $subscription->get_status();
			$cancel_url = wcs_get_users_change_status_link( $subscription->get_id(), 'cancelled', $current_status ); ?>
			<a href="<?php echo $cancel_url; ?>" class="btn style2">Cancel</a>
		</div>
	  </div>
	</div>

	<div class="block-line spb">
	  <div class="line-left">
		<p>Next Billing Date</p>
	  </div>
	  <div class="line-right">
		<p><strong><?php echo esc_html( date('Y/m/d', strtotime($subscription->get_date_to_display( 'next_payment' ))) ); ?></strong></p>
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
<table class="shop_table subscription_details">
	<tbody>
		<tr>
			<td><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></td>
			<td><?php echo esc_html( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?></td>
		</tr>
		<?php do_action( 'wcs_subscription_details_table_before_dates', $subscription ); ?>
		<?php
		$dates_to_display = apply_filters( 'wcs_subscription_details_table_dates_to_display', array(
			'start_date'              => _x( 'Start date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'last_order_date_created' => _x( 'Last order date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'next_payment'            => _x( 'Next payment date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'end'                     => _x( 'End date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'trial_end'               => _x( 'Trial end date', 'customer subscription table header', 'woocommerce-subscriptions' ),
		), $subscription );
		foreach ( $dates_to_display as $date_type => $date_title ) : ?>
			<?php $date = $subscription->get_date( $date_type ); ?>
			<?php if ( ! empty( $date ) ) : ?>
				<tr>
					<td><?php echo esc_html( $date_title ); ?></td>
					<td><?php echo esc_html( $subscription->get_date_to_display( $date_type ) ); ?></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php do_action( 'wcs_subscription_details_table_after_dates', $subscription ); ?>
		<?php if ( WCS_My_Account_Auto_Renew_Toggle::can_user_toggle_auto_renewal( $subscription ) ) : ?>
			<tr>
				<td><?php esc_html_e( 'Auto renew', 'woocommerce-subscriptions' ); ?></td>
				<td>
					<div class="wcs-auto-renew-toggle">
						<?php

						$toggle_classes = array( 'subscription-auto-renew-toggle', 'subscription-auto-renew-toggle--hidden' );

						if ( $subscription->is_manual() ) {
							$toggle_label     = __( 'Enable auto renew', 'woocommerce-subscriptions' );
							$toggle_classes[] = 'subscription-auto-renew-toggle--off';

							if ( WCS_Staging::is_duplicate_site() ) {
								$toggle_classes[] = 'subscription-auto-renew-toggle--disabled';
							}
						} else {
							$toggle_label     = __( 'Disable auto renew', 'woocommerce-subscriptions' );
							$toggle_classes[] = 'subscription-auto-renew-toggle--on';
						}?>
						<a href="#" class="<?php echo esc_attr( implode( ' ' , $toggle_classes ) ); ?>" aria-label="<?php echo esc_attr( $toggle_label ) ?>"><i class="subscription-auto-renew-toggle__i" aria-hidden="true"></i></a>
						<?php if ( WCS_Staging::is_duplicate_site() ) : ?>
								<small class="subscription-auto-renew-toggle-disabled-note"><?php echo esc_html__( 'Using the auto-renewal toggle is disabled while in staging mode.', 'woocommerce-subscriptions' ); ?></small>
						<?php endif; ?>
					</div>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action( 'wcs_subscription_details_table_before_payment_method', $subscription ); ?>
		<?php if ( $subscription->get_time( 'next_payment' ) > 0 ) : ?>
			<tr>
				<td><?php esc_html_e( 'Payment', 'woocommerce-subscriptions' ); ?></td>
				<td>
					<span data-is_manual="<?php echo esc_attr( wc_bool_to_string( $subscription->is_manual() ) ); ?>" class="subscription-payment-method"><?php echo esc_html( $subscription->get_payment_method_to_display( 'customer' ) ); ?></span>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action( 'woocommerce_subscription_before_actions', $subscription ); ?>
		<?php $actions = wcs_get_all_user_actions_for_subscription( $subscription, get_current_user_id() ); ?>
		<?php if ( ! empty( $actions ) ) : ?>
			<tr>
				<td><?php esc_html_e( 'Actions', 'woocommerce-subscriptions' ); ?></td>
				<td>
					<?php foreach ( $actions as $key => $action ) : ?>
						<?php $classes = [ 'button', sanitize_html_class( $key ) ]; ?>
						<?php $classes[] = isset( $action['block_ui'] ) && $action['block_ui'] ? 'wcs_block_ui_on_click' : '' ?>
						<a
							href="<?php echo esc_url( $action['url'] ); ?>"
							class="<?php echo trim( implode( ' ', $classes ) ); ?>"
						>
							<?php echo esc_html( $action['name'] ); ?>
						</a>
					<?php endforeach; ?>
				</td>
			</tr>
		<?php endif; ?>
		<?php do_action( 'woocommerce_subscription_after_actions', $subscription ); ?>
	</tbody>
</table>

<?php if ( $notes = $subscription->get_customer_order_notes() ) : ?>
	<h2><?php esc_html_e( 'Subscription updates', 'woocommerce-subscriptions' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo esc_html( date_i18n( _x( 'l jS \o\f F Y, h:ia', 'date on subscription updates list. Will be localized', 'woocommerce-subscriptions' ), wcs_date_to_time( $note->comment_date ) ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wp_kses_post( wpautop( wptexturize( $note->comment_content ) ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>
