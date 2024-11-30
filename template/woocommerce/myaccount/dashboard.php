<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// $allowed_html = array(
// 	'a' => array(
// 		'href' => array(),
// 	),
// );
?>

<!-- <p> -->
	<?php
	// printf(
	// 	/* translators: 1: user display name 2: logout url */
	// 	wp_kses( __( 'Hello0000 %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
	// 	'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
	// 	esc_url( wc_logout_url() )
	// );
	?>
<!-- </p> -->

<!-- <p> -->
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	// $dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	// if ( wc_shipping_enabled() ) {
	// 	/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
	// 	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	// }
	// printf(
	// 	wp_kses( $dashboard_desc, $allowed_html ),
	// 	esc_url( wc_get_endpoint_url( 'orders' ) ),
	// 	esc_url( wc_get_endpoint_url( 'edit-address' ) ),
	// 	esc_url( wc_get_endpoint_url( 'edit-account' ) )
	// );
	?>
<!-- </p> -->
<?php
    $user_id = get_current_user_id();
    $sf_balance = mycred_get_users_cred($user_id);


    function get_current_user_subscription_status($user_id) {
        $subscriptions = wcs_get_users_subscriptions($user_id);
    
        if ( ! empty( $subscriptions ) ) {
            foreach ( $subscriptions as $subscription ) {
                $status = $subscription->get_status();
                return $status;
            }
        } else {
            return 'No subscription';
        }
    }

    function get_current_user_recent_messages($user_id) {
        global $wpdb;

        $admin_users = get_users(array('role' => 'administrator'));
        $admin_ids = wp_list_pluck($admin_users, 'ID');
        $admin_ids_string = implode(',', array_map('intval', $admin_ids));

        // Define the timestamp for "recently read" (e.g., within the last 30 days)
        $recent_time = date('Y-m-d H:i:s', strtotime('-30 days'));

        $query = "
            SELECT DISTINCT m.*, t.subject
            FROM {$wpdb->prefix}bm_message_messages m
            JOIN {$wpdb->prefix}bm_message_recipients r ON m.thread_id = r.thread_id
            JOIN {$wpdb->prefix}bm_threads t ON m.thread_id = t.id
            WHERE 
                (m.sender_id IN ($admin_ids_string) OR (r.last_read IS NULL OR r.last_read < %s))
                AND r.user_id = %d
            ORDER BY m.created_at DESC
        ";

        $prepared_query = $wpdb->prepare($query, $recent_time, $user_id);
        $messages = $wpdb->get_results($prepared_query);
        return $messages;
    }

    function get_current_user_affiliate_earnings($user_id) {
        $sum_creds = $wpdb->get_var( $wpdb->prepare(
            "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%ref_fee%'
        ));
        $recent_transactions = $wpdb->get_results( $wpdb->prepare(
            "SELECT DISTINCT creds, entry, time FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $user_id, '%ref_fee%'
        ));

        return [
            'sum_creds' => $sum_creds,
            'recent_transactions' => $recent_transactions,
        ];
    }

    function get_current_user_product_ids($user_id) {

        if (!$user_id) {
            return [];
        }
    
        global $wpdb;
    
        $query = "
            SELECT ID 
            FROM {$wpdb->prefix}posts
            WHERE post_type = 'product'
            AND post_status = 'publish'
            AND post_author = %d
        ";
    
        $prepared_query = $wpdb->prepare($query, $user_id);
        $product_ids = $wpdb->get_col($prepared_query);
    
        return $product_ids;
    }

    function get_current_user_views_of_services($id) {
        $product_view_count = get_post_meta( $id, 'product_view_count', true );
        $product_view_count = !empty( $product_view_count ) ? $product_view_count : 0;
        return $product_view_count;
    }
    $current_user_product_ids = get_current_user_product_ids($user_id);
    $current_user_product_views = array_map('get_current_user_views_of_services', $current_user_product_ids);
    $current_user_total_product_views = array_sum( $current_user_product_views);
    $total_product_views_precentage = ( $current_user_total_product_views / 1000 ) * 100;


?>

<div class="account-text-block" style="margin-top: 0 !important;">
    <h4><strong>Overview</strong></h4>
    <div class="block-lines big-p">

        <div class="block-line spb">
        <div class="line-left va">
            <div class="line-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/balance.svg" alt="balance icon" />
            </div>
            <p>SF balance</p>
        </div>
        <div class="line-right">
            <p class="main-val"><span>SF </span><?php echo $sf_balance; ?></p>
        </div>
        </div>

        <div class="block-line spb">
        <div class="line-left va">
            <div class="line-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/status.svg" alt="status icon" />
            </div>
            <p>Subscription status</p>
        </div>
        <div class="line-right va">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/account_check.svg" alt="check icon" />
            <p><?php echo get_current_user_subscription_status($user_id); ?></p>
        </div>
        </div>

        <div class="block-line spb">
        <div class="line-left va">
            <div class="line-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/performance.svg" alt="performance icon" />
            </div>
            <p>Service performance</p>
        </div>
        <div class="line-right va">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/account_check.svg" alt="check icon" />
            <p>On</p>
        </div>
        </div>

    </div>
</div>

<div class="account-text-block">
    <div class="account-title-block borderb spb">
        <div class="title-content va">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/recent_messages.svg" alt="recent messages icon" />
        <h5>Recent messages</h5>
        </div>
        <div class="mes-num">
            <?php $messages = get_current_user_recent_messages($user_id); ?>
            <p><?php echo count($messages); ?></p>
        </div>
    </div>

    <div class="messages">
    <?php $limited_messages = array_slice($messages, 0, 5);
        if (! empty($limited_messages)) {
            foreach ($limited_messages as $message) {
                $messageUrl = Better_Messages()->functions->get_user_messages_url($current_user_id, $message->thread_id); ?>
                <div class="message-block spb">
                    <div class="message-icon">
                        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="message icon ">
                    </div>
                    <div class="message-text">
                        <p><?php echo $message->subject ? sanitize_text_field($message->subject) : substr(sanitize_text_field($message->message), 0, 40) . "..."; ?></p>
                    </div>
                    <div class="btn-block">
                        <a href="<?php echo esc_url($messageUrl); ?>" class="btn"><?php _e('read more', 'the-synergy-group-addon'); ?></a>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="message-block spb">
                <div class="message-icon">
                    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/message2.svg" alt="message icon " />
                </div>
                <div class="message-text">
                    <p><?php _e('No recent messages at the moment.', 'the-synergy-group-addon'); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="add-options jc items text-white pt15">
<a href="<?php echo wc_get_account_endpoint_url( 'service-offering/#tsg-manage-service-section' ); ?>" class="item w3">
    <div class="itemr">
        <div class="option-account">
            <div class="option-icon">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/add_service.svg" alt="add service icon" />
            </div>
            <h5 class="tc">Add a <br>Service</h5>
        </div>
    </div>
</a>

<a href="<?php echo wc_get_account_endpoint_url( 'francs/#tsg-sf-exchange-section' ); ?>" class="item w3">
    <div class="itemr">
    <div class="option-account">
        <div class="option-icon">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/buy_sf.svg" alt="buy SF icon" />
        </div>
        <h5 class="tc">Buy <br>SF</h5>
    </div>
    </div>
</a>

<a href="#" class="item w3">
    <div class="itemr">
    <div class="option-account">
        <div class="option-icon">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/upgrate.svg" alt="buy SF icon" />
        </div>
        <h5 class="tc">Upgrade<br> Subscription</h5>
    </div>
    </div>
</a>

</div>

<div class="analytics items jc pt15">

<div class="item w2">
    <div class="itemr">
    <div class="analytics-block">
        <div class="account-title-block borderb va">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/analytics1.svg" class="mr2" alt="service analytics icon" />
        <h5>Service Analytics</h5>
        </div>

        <div class="progress-lines">

        <div class="progress-block">
            <p>Engagement</p>
            <div class="progress"><div class="progress-val" style="width:80%;"></div></div>
        </div>

        <div class="progress-block">
            <p>Conversion rates</p>
            <div class="progress"><div class="progress-val bg-green" style="width:70%;"></div></div>
        </div>

        <div class="progress-block">
            <p>Client satisfaction</p>
            <div class="progress"><div class="progress-val bg-viol" style="width:60%;"></div></div>
        </div>

        </div>

        <div class="btn-block mt30">
        <a href="#" class="btn btn-small w100">more details</a>
        </div>

    </div>
    </div>
</div>

<div class="item w2">
    <div class="itemr">
    <div class="analytics-block">
        <div class="account-title-block borderb va">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/analytics1.svg" class="mr2" alt="service analytics icon" />
        <h5>Financial Analytics</h5>
        </div>

        <div class="progress-lines">

        <div class="progress-block">
            <p>Visualize earnings</p>
            <div class="progress"><div class="progress-val" style="width:80%;"></div></div>
        </div>

        <div class="progress-block">
            <p>SF spending</p>
            <div class="progress"><div class="progress-val bg-green" style="width:80%;"></div></div>
        </div>

        <div class="progress-block">
            <p>Cash flow from services / 
            Synergy Francs</p>
            <div class="progress"><div class="progress-val bg-viol" style="width:80%;"></div></div>
        </div>

        </div>

        <div class="btn-block mt30">
        <a href="#" class="btn btn-small w100">more details</a>
        </div>

    </div>
    </div>
</div>

</div>

<div class="account-text-block">
<div class="account-title-block va">
    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/earnings.svg" class="mr2" alt="Affiliate Earnings icon" />
    <h5>Affiliate Earnings</h5>
</div>

<div class="block-lines big-p mt2">

    <div class="block-line spb">
    <div class="line-left va">
        <div class="line-icon">
        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/balance.svg" alt="balance icon" />
        </div>
        <p>SF balance</p>
    </div>
    <div class="line-right">
        <?php $affiliate_earnings = get_current_user_affiliate_earnings($user_id); ?>
        <p class="main-val">SF <?php echo $affiliate_earnings['sum_creds']; ?></p>
    </div>
    </div>

</div>

<div class="account-title-block va mt25">
    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money.svg" class="mr2" alt="money icon" />
    <h6>Recent transactions</h6>
</div>

<div class="block-lines small-lines media-full">
    <?php if (!empty($affiliate_earnings['recent_transactions'])) : ?>
        <?php foreach ($affiliate_earnings['recent_transactions'] as $recent_transaction) : ?>
            <div class="block-line spb">
                <div class="line-left va">
                    <div class="line-icon2">
                        <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/list_blue.svg" alt="<?php esc_attr_e('List icon', 'the-synergy-group-addon'); ?>" />
                    </div>
                    <?php 
                    // Format date safely
                    $date = !empty($recent_transaction->time) ? date('d.m.Y', $recent_transaction->time) : __('Unknown Date', 'the-synergy-group-addon'); 
                    ?>
                    <p><?php echo esc_html($recent_transaction->entry) . ' ' . esc_html($date); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo 'SF ' . esc_html($recent_transaction->creds); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="block-line spb">
            <div class="line-left va">
                <div class="line-icon2">
                    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/list_blue.svg" alt="<?php esc_attr_e('List icon', 'the-synergy-group-addon'); ?>" />
                </div>
                <p><?php _e('No transaction at the moment.', 'the-synergy-group-addon'); ?></p>
            </div>
            <div class="line-right"></div>
        </div>
    <?php endif; ?>    
</div>

</div><p>


<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */