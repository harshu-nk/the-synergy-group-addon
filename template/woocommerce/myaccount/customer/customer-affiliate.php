<?php
$mycred_transactions = mycred_get_users_reference_sum(get_current_user_id(), 'synergy_francs');
$current_user_id = get_current_user_id();

global $wpdb;

$table_name = 'wp_myCRED_log'; // Replace with your actual table name
$total_creds = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT SUM(creds) FROM $table_name WHERE user_id = %d",
        $current_user_id
    )
);
$total_creds = $total_creds ? $total_creds : 0;

$table_name = 'wp_myCRED_log'; // Replace with your actual table name
$total_sales_creds = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT SUM(creds) FROM $table_name WHERE user_id = %d AND ref = %s",
        $current_user_id,
        'sale_of_service'
    )
);
$total_sales_creds = $total_sales_creds ? $total_sales_creds : 0;


$referral_code = (new Referrals)->generateRefCode($user_info->ID);
$referral_url = site_url('/register') . '?ref=' . $referral_code;
$referred_users = get_user_meta($user_info->ID, 'referred_users', true);


$leaderboard_data = get_user_leaderboard_positions($current_user_id);
$current_position = esc_html($leaderboard_data['current_position']);
$previous_position = esc_html($leaderboard_data['previous_position']);

$change_image = '';

if ($current_position && $previous_position && $current_position !== '-') {
    if ($previous_position > $current_position) {
        $change_image = '<img width="24" src="' . THE_SYNERGY_GROUP_URL . 'public/img/account/green_arrow_top.svg" alt="green arrow" />';
    } elseif ($previous_position < $current_position) {
        $change_image = '<img width="24" src="' . THE_SYNERGY_GROUP_URL . 'public/img/account/red_arrow_bot.svg" alt="red arrow" />';
    }
} else {
    $change_image = 'N/A';
}


$sum_creds = $wpdb->get_var( $wpdb->prepare(
    "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $current_user_id, '%ref_fee%'
));

if (empty($sum_creds)) {
    $sum_creds = 0;
}

$meta_key = 'referred_users';
$meta_value = get_user_meta($current_user_id, $meta_key, true);
$referred_users = maybe_unserialize($meta_value);
$referred_count = is_array($referred_users) ? count($referred_users) : 0;

$sum_purchased_creds = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT SUM(creds) 
        FROM {$wpdb->prefix}myCRED_log 
        WHERE user_id = %d AND ref = %s", 
        $current_user_id, 
        'buy_creds_with_bank'
    )
);

$sum_purchased_creds = $sum_purchased_creds ? $sum_purchased_creds : 0;

$sum_sold_creds = $wpdb->get_var(
    $wpdb->prepare(
        "SELECT SUM(creds) 
        FROM {$wpdb->prefix}myCRED_log 
        WHERE user_id = %d AND ref = %s", 
        $current_user_id, 
        'withdrawal'
    )
);
$sum_sold_creds = $sum_sold_creds ? abs($sum_sold_creds) : 0;

$total_net_position = $sum_purchased_creds - $sum_sold_creds;
?>
<div class="light-style input-small">
    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="55" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/hands.svg" alt="My Affiliate Earnings icon" />
                <div class="title-text">
                    <h5 class="big-title">My Affiliate Earnings</h5>
                    <p>from Transaction Fees from ALL the members</p>
                </div>
            </div>
        </div>

        <div class="block-lines">
        <?php 
        foreach($mycred_transactions as $label => $amount){ 
            if($amount < 0){
                continue;
            }
            ?>
            <div class="block-line spb">
                <div class="line-left">
                    <p><?php echo ucwords(str_replace('_', ' ' , $label)); ?></p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo number_format(abs($amount), 2); ?></p>
                </div>
            </div>
        <?php } ?>
        </div>

        <h6 class="mt25"><strong>Trend:</strong></h6>
        <div class="chart-image">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_chart1.jpg" alt="chart 1" />
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="Transaction Fees icon" />
                <div class="title-text">
                    <h5 class="big-title">Transaction Fees </h5>
                    <p>I've paid to Josh Johansen</p>
                </div>
            </div>
        </div>

        <div class="block-lines">

        <div class="block-lines">
            <?php 
            foreach($mycred_transactions as $label => $amount){ 
                if($amount > 0){
                    continue;
                }
                ?>
                <div class="block-line spb">
                    <div class="line-left">
                        <p><?php echo ucwords(str_replace('_', ' ' , $label)); ?></p>
                    </div>
                    <div class="line-right">
                        <p class="main-val2">SF <?php echo number_format(abs($amount), 2); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

            <!-- <div class="block-line spb">
                <div class="line-left">
                    <p>Services Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 350</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Sales Made</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Sold</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 150</p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Total SF Paid To-Date</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF 550</p>
                </div>
            </div> -->

        </div>

        <h6 class="mt25"><strong>Trend:</strong></h6>
        <div class="chart-image">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_chart2.jpg" alt="chart 2" />
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="Net Affiliate Transaction Fee Position icon" />
                <div class="title-text">
                    <h5 class="big-title">Net Affiliate Transaction Fee Position</h5>
                </div>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb">
                <div class="line-left">
                    <p>Services Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo abs($total_creds); ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Sales Made</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo abs($total_sales_creds); ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Purchased</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo esc_html($sum_purchased_creds); ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>SF Sold</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo esc_html($sum_sold_creds); ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Total SF Net Position To-Date</p>
                </div>
                <div class="line-right">
                    <p class="main-val2">SF <?php echo esc_html($total_net_position); ?></p>
                </div>
            </div>

        </div>

        <h6 class="mt25"><strong>Trend:</strong></h6>
        <div class="chart-image last">
            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_chart3.jpg" alt="chart 3" />
        </div>

        <div class="block-lines mt2 media-full">
            <div class="block-line spb">
                <div class="line-left">
                    <p>You</p>
                </div>
                <div class="line-right input-field width3">
                    <div class="progress-line">
                        <div class="progress-value" style="width: 80%;"></div>
                    </div>
                </div>
            </div>
            <div class="block-line spb">
                <div class="line-left">
                    <p>Josh Jansen</p>
                </div>
                <div class="line-right input-field width3">
                    <div class="progress-line">
                        <div class="progress-value" style="width: 40%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="47" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/affiliate_progress.svg" alt="Affiliate Leaderboard icon" />
                <div class="title-text">
                    <h5 class="big-title">Affiliate Leaderboard</h5>
                </div>
            </div>
        </div>

        <div class="block-lines mt2">

            <div class="block-line spb media-full">
                <div class="line-left">
                    <p>My Affiliate Link:</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><a target="_blank" href="<?php echo esc_attr($referral_url); ?>" class="blue-link"><?php echo esc_attr($referral_url); ?></a></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Current Position</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo $current_position; ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Position Last Month</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo $previous_position; ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Change from Last Month</p>
                </div>
                <div class="line-right">
                    <?php echo $change_image; ?>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Affiliate Name</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo esc_attr($referral_code); ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Nr. Members Referred</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo esc_html($referred_count); ?></p>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Affiliate Income Earned</p>
                </div>
                <div class="line-right">
                    <p class="main-val2"><?php echo esc_attr($sum_creds); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>