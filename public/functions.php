<?php

function get_history_by_context($key, $value, $limit = 5)
{
    global $wpdb;

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                h.*, 
                c.context_id, 
                c.key, 
                c.value 
            FROM 
                {$wpdb->prefix}simple_history AS h
            JOIN 
                {$wpdb->prefix}simple_history_contexts AS c 
            ON 
                h.id = c.history_id 
            WHERE 
                c.key = %s 
                AND c.value = %s
                LIMIT %d",
            $key,
            $value,
            $limit
        ),
        ARRAY_A
    );

    return $results;
}

function admin_user_ids(){
    //Grab wp DB
    global $wpdb;
    //Get all users in the DB
    $wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");

    //Blank array
    $adminArray = array();
    //Loop through all users
    foreach ( $wp_user_search as $userid ) {
        //Current user ID we are looping through
        $curID = $userid->ID;
        //Grab the user info of current ID
        $curuser = get_userdata($curID);
        //Current user level
        $user_level = $curuser->user_level;
        //Only look for admins
        if($user_level >= 8){//levels 8, 9 and 10 are admin
            //Push user ID into array
            $adminArray[] = $curID;
        }
    }
    return $adminArray;
}

// Validate user myCred balance before checkout
add_action('woocommerce_after_checkout_validation', 'validate_mycred_balance_before_checkout', 10, 2);
function validate_mycred_balance_before_checkout($fields, $errors)
{
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        // $mycred = mycred();
        $total_sf_points_needed = 0;

        foreach (WC()->cart->get_cart() as $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_price = wc_get_price_to_display($cart_item['data']);
            $sf_percentage = get_post_meta($product_id, 'sf_percentage', true);

            if (!empty($sf_percentage)) {
                $sf_points = ($product_price * $sf_percentage) / 100;
                $total_sf_points_needed += $sf_points;
            }
        }

        $user_balance = get_users_balance($user_id, 'synergy_francs');

        if ($user_balance < $total_sf_points_needed) {
            $errors->add( 'validation', __('Insufficient points in your account to cover the required SF amount.', 'woocommerce') );
        }
    }
}

// Deduct SF percentage points after successful order
add_action('woocommerce_payment_complete', 'deduct_sf_percentage_after_checkout');
// add_action('woocommerce_thankyou', 'deduct_sf_percentage_after_checkout');
function deduct_sf_percentage_after_checkout($order_id){
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();
    $mycred = mycred();

    wc_get_logger()->debug( 'Checkout SF calculator running for order: #' . $order_id, array( 'source' => 'tsg' ) );

    // $total_sf_points = 0;

    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $product_price = wc_get_price_to_display(wc_get_product($product_id));
        $sf_percentage = get_post_meta($product_id, 'sf_percentage', true);
        wc_get_logger()->debug( 'Checkout SF calculator SF Percentage:' . $sf_percentage, array( 'source' => 'tsg' )  );

        if (!empty($sf_percentage)) {
            $sf_points = ($product_price * $sf_percentage) / 100;
            wc_get_logger()->debug( 'Checkout SF calculator SF Points:' . $sf_points, array( 'source' => 'tsg' )  );

            // Deducting full amount from buyer
            $buyer_deduction = mycred_add(
                'buy_service', // Reference
                $user_id, // User ID
                -$sf_points, // Points to deduct (negative)
                'Deducted %plural% for SF percentage on order #' . $order_id, // Log entry
                $order_id, // Data (optional)
                'synergy_francs'
            );
            wc_get_logger()->debug( 'Checkout SF calculator Buyer Deduction:' . $buyer_deduction, array( 'source' => 'tsg' )  );

            // Add Affiliate Profit to the buyer side
            $buyer_referee_id = get_user_meta($user_id, 'referred_by', true);
            $buyer_referee_id = $buyer_referee_id ? $buyer_referee_id : admin_user_ids()[0];

            $sf_buyer_referee_fee = ($sf_points * 10) / 100; //Change for the admin settings 10% for now
            wc_get_logger()->debug( 'Checkout SF calculator Buyer Ref ID:' . $buyer_referee_id, array( 'source' => 'tsg' )  );
            wc_get_logger()->debug( 'Checkout SF calculator Buyer Ref Fee:' . $sf_buyer_referee_fee, array( 'source' => 'tsg' )  );
            $buyer_refferal_cost = $mycred->add_creds(
                'buyer_ref_fee', // Reference
                $buyer_referee_id, // User ID
                floatval($sf_buyer_referee_fee), // Points to add
                'Addition ref fee for SF percentage on order #' . $order_id, // Log entry
                $order_id,
                'synergy_francs'
            );
            wc_get_logger()->debug( 'Checkout SF calculator Buyer Ref Costed:' . $buyer_refferal_cost, array( 'source' => 'tsg' )  );


            $seller_id = get_post_field( 'post_author', $product_id );
            wc_get_logger()->debug( 'Checkout SF calculator Seller ID:' . $seller_id, array( 'source' => 'tsg' )  );

            // Add Affiliate Profit to the seller side
            $seller_referee_id = get_user_meta($seller_id, 'referred_by', true);
            $seller_referee_id = $seller_referee_id ? $seller_referee_id : admin_user_ids()[0];
            $sf_seller_referee_fee = ($sf_points * 10) / 100; //Change for the admin settings 10% for now

            wc_get_logger()->debug( 'Checkout SF calculator Seller Ref ID:' . $seller_referee_id, array( 'source' => 'tsg' )  );
            wc_get_logger()->debug( 'Checkout SF calculator Seller Ref Fee:' . $sf_seller_referee_fee, array( 'source' => 'tsg' )  );
            $seller_refferal_cost = mycred_add(
                'seller_ref_fee', // Reference
                $seller_referee_id, // User ID
                floatval($sf_seller_referee_fee), // Points to deduct (negative)
                'Addition referee fee %plural% for SF percentage on order #' . $order_id, // Log entry
                $order_id, // Data (optional)
                'synergy_francs'
            );
            wc_get_logger()->debug( 'Checkout SF calculator Seller Ref Costed:' . $seller_refferal_cost, array( 'source' => 'tsg' )  );

            // Transfer Remaining Balance to the Seller
            $sale_amount = $sf_points - $sf_buyer_referee_fee - $sf_seller_referee_fee;
            wc_get_logger()->debug( 'Checkout SF calculator Seller Receive Amount:' . $sale_amount, array( 'source' => 'tsg' )  );

            $seller_received = mycred_add(
                'sale_of_service', // Reference
                $seller_id, // User ID
                floatval($sale_amount), // Points to deduct (negative)
                'Addition %plural% for SF percentage on order #' . $order_id, // Log entry
                $order_id, // Data (optional)
                'synergy_francs'
            );
            wc_get_logger()->debug( 'Checkout SF calculator Seller Received:' . $seller_received, array( 'source' => 'tsg' )  );

        }
    }
}

add_filter( 'mycred_all_references', 'mycredpro_add_custom_references' );
function mycredpro_add_custom_references( $list ) {

	$list['sale_of_service'] = 'Sale of Service';
	$list['seller_ref_fee'] = 'Ref. fee for Sale of Service';
	$list['buyer_ref_fee'] = 'Ref. fee for Buy of Service';
	$list['buy_service'] = 'Buy of Service';

	return $list;

}

add_filter('mycred_add', function($val, $data){
    if(in_array($data['ref'], array('sale_of_service', 'seller_ref_fee', 'buyer_ref_fee', 'buy_service'))){
        $val = true;
    }
    return $val;
}, 10, 2);

function test_bench(){
    // $seller_id = get_post_field( 'post_author', 677 );
    // echo $seller_id;
}
add_action('wp_head', 'test_bench');


// Save Certificates Handler
add_action('wp_ajax_tsg_add_save_certificates', 'tsg_add_save_certificates');
function tsg_add_save_certificates() {

    if (!isset($_POST['certificates'])) {
        echo '<p>Failed to send data</p>';
        wp_die();
    }

    $certificates = json_decode(stripslashes($_POST['certificates']), true);

    if (is_array($certificates)) {
        foreach ($certificates as $certificate) {
            if (isset($certificate['id']) && isset($certificate['text'])) {
                echo '<div class="item w2" id="' . esc_html($certificate['id']) . '">
                        <div class="itemr">
                            <div class="award-block tc">
                                <a href="#" class="block-edit delete-certificate-btn" data-id="' . esc_html($certificate['id']) . '" data-text="' . esc_html($certificate['text']) . '"><img src="' . THE_SYNERGY_GROUP_URL . '/public/img/account/edit.svg" alt="edit icon"></a>
                                <div class="award-icon">
                                    <img src="' . THE_SYNERGY_GROUP_URL . '/public/img/account/award.svg" alt="award icon">
                                </div>
                                <p class="fs-20 mt18 tsg-certificate-name">' . esc_html($certificate['text']) . '</p>
                            </div>
                        </div>
                    </div>';
            }
        }
    } else {
        echo '<p>No valid certificates found</p>';
    }
    wp_die();
}

// Fetch Certificates Handler
// add_action('wp_ajax_fetch_certificates', 'fetch_certificates');
// function fetch_certificates() {
//     $user_id = get_current_user_id();
//     $certificates_str = xprofile_get_field_data('certificate', $user_id);

//     $certificates = !empty($certificates_str) ? json_decode($certificates_str) : [];
//     wp_send_json_success(['certificates' => $certificates]);
//     wp_die();
// }

//Service offering - delete selected product
add_action('wp_ajax_delete_product', 'tsg_delete_product');

function tsg_delete_product() {

    if (!isset($_POST['product_id']) || !current_user_can('delete_posts')) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    }

    $product_id = intval($_POST['product_id']);

    if (get_post_type($product_id) !== 'product') {
        wp_send_json_error(['message' => 'Invalid product ID']);
        wp_die();
    }

    if (wp_delete_post($product_id, true)) {
        wp_send_json_success(['message' => 'Product deleted successfully']);
    } else {
        wp_send_json_error(['message' => 'Failed to delete the product']);
    }

    wp_die();
}

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function unique_multidim_obj($obj, $key){
    $uniqueArray = [];
    foreach ($obj as $object) {
        if (!isset($uniqueArray[$object->{$key}])) {
            $uniqueArray[$object->{$key}] = $object;
        }
    }

    // Reset the keys of the unique array
    $uniqueArray = array_values($uniqueArray);
    return $uniqueArray;
}

//Admin SF management - configure subscription
add_action('wp_ajax_configure_subscription', 'tsg_configure_subscription');

function tsg_configure_subscription() {

    if (!isset($_POST['data'])) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    } 
    else{
        $subscriptions = $_POST['data'];

        foreach ($subscriptions as $product_id => $sf_allowance_value) {
            $product_id = intval($product_id);
            $sf_allowance_value = sanitize_text_field($sf_allowance_value);
    
            update_field('sf_allowance', $sf_allowance_value, $product_id);
        }
        wp_send_json_success(['message' => 'Subscription data saved successfully']);
    }
    
    wp_die();
}

//Admin SF management - adjust SF bonus
add_action('wp_ajax_adjust_sf_bonus', 'tsg_adjust_sf_bonus');

function tsg_adjust_sf_bonus() {

    if (!isset($_POST['data'])) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    } else {

        $sf_bonus_allocation = sanitize_text_field($_POST['data']['sf_bonus_allocation']);
        $selected_date = sanitize_text_field($_POST['data']['date']);

        update_option('sf_bonus_allocation', $sf_bonus_allocation);
        update_option('selected_date', $selected_date);
        wp_send_json_success([
            'message' => 'SF Bonus allocation and date saved successfully',
            'debug' => $_POST['data']
        ]);
    }
    wp_die();
}

//Admin SF management - allocate SF to member
add_action('wp_ajax_+', 'tsg_allocate_sf_to_member');

function tsg_allocate_sf_to_member() {

    if (!isset($_POST['data'])) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    } else {
        
    }
    wp_die();
}

//Admin SF management - withdraw SF from member
add_action('wp_ajax_withdraw_sf_from_member', 'tsg_withdraw_sf_from_member');

function tsg_withdraw_sf_from_member() {
    if (!isset($_POST['data']['amount']) || !isset($_POST['data']['user_id'])) {
        wp_send_json_error(['message' => 'Missing required data']);
        wp_die();
    }

    $amount = absint($_POST['data']['amount']);
    $user_id = intval($_POST['data']['user_id']);

    if ($amount <= 0 || $user_id <= 0) {
        wp_send_json_error(['message' => 'Invalid amount or user ID']);
        wp_die();
    }

    $result = mycred_subtract('withdrawal', $user_id, -$amount, 'Points deduction for withdrawal');

    if ($result) {
        wp_send_json_success(['message' => 'Points deducted successfully']);
    } else {
        wp_send_json_error(['message' => 'Failed to deduct points']);
    }

    wp_die();
}

//Admin SF management - remove SF from circulation
add_action('wp_ajax_remove_sf_from_circulation', 'tsg_remove_sf_from_circulation');

function tsg_remove_sf_from_circulation() {

    if (!isset($_POST['data']['amount'])) {
        wp_send_json_error(['message' => 'Missing required data']);
        wp_die();
    }

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Unauthorized: Only admin can perform this action']);
        wp_die();
    }

    $admin_id = get_current_user_id();
    $amount = absint($_POST['data']['amount']);

    if ($amount <= 0) {
        wp_send_json_error(['message' => 'Invalid amount']);
        wp_die();
    }

    $result = mycred_subtract('admin_deduction', $admin_id, -$amount, 'Points removed from circulation by admin');

    if ($result) {
        wp_send_json_success(['message' => 'Points deducted from admin successfully']);
    } else {
        wp_send_json_error(['message' => 'Failed to deduct points from admin']);
    }

    wp_die();
}

//All transactions - Display all transactions.
add_action('wp_ajax_display_all_transactions_data', 'tsg_display_all_transactions_data');

function tsg_display_all_transactions_data() {

    if (!isset($_POST['data'])) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    } else {
        
    }
    wp_die();
}

//All transactions - Display all transactions.
add_action('wp_ajax_display_all_transactions_history', 'tsg_display_all_transactions_history');

function tsg_display_all_transactions_history() {

    global $wpdb;
    $current_user_id = get_current_user_id();

    $dataSearch = isset($_POST['data']['dataSearch']) ? sanitize_text_field($_POST['data']['dataSearch']) : '';
    $dateFrom = isset($_POST['data']['dateFrom']) ? sanitize_text_field($_POST['data']['dateFrom']) : '';
    $dateTo = isset($_POST['data']['dateTo']) ? sanitize_text_field($_POST['data']['dateTo']) : '';
    $transactionType = isset($_POST['data']['transactionType']) ? sanitize_text_field($_POST['data']['transactionType']) : '';
    $member = isset($_POST['data']['member']) ? intval($_POST['data']['member']) : 0;
    $filter = isset($_POST['data']['filter']) ? intval($_POST['data']['filter']) : 0;

    if (!empty($dateFrom)) {
        $dateFrom = DateTime::createFromFormat('m/d/Y', $dateFrom)->format('Y-m-d');
    }
    if (!empty($dateTo)) {
        $dateTo = DateTime::createFromFormat('m/d/Y', $dateTo)->format('Y-m-d');
    }

    $query = "SELECT * FROM {$wpdb->prefix}myCRED_log WHERE 1=1";
    $params = [];

    if (!empty($dataSearch)) {
        $query .= " AND entry LIKE %s";
        $params[] = '%' . $wpdb->esc_like($dataSearch) . '%';
    }

    if (!empty($dateFrom)) {
        $query .= " AND time >= %d";
        $params[] = strtotime($dateFrom);
    }

    if (!empty($dateTo)) {
        $query .= " AND time <= %d";
        $params[] = strtotime($dateTo);
    }

    if (!empty($transactionType)) {
        $query .= " AND ref = %s";
        $params[] = $transactionType;
    }

    if ( $member > 0 ) {
        $query .= " AND user_id = %d";
        $params[] = $member;
    } elseif (empty($transactionType) && $filter === 1) {
        $referred_users_meta = get_user_meta($current_user_id, 'referred_users', true);
        $referred_user_ids = !empty($referred_users_meta) ? maybe_unserialize($referred_users_meta) : [];

        if (!empty($referred_user_ids)) {
            $placeholders = implode(',', array_fill(0, count($referred_user_ids), '%d'));
            $query .= " AND user_id IN ($placeholders)";
            $params = array_merge($params, $referred_user_ids);
        } else {
            $query .= " AND user_id = 0";
        }
    }

    if (!empty($params)) {
        $prepared_query = $wpdb->prepare($query, ...$params);
        $results = $wpdb->get_results($prepared_query);
    } else {
        $results = $wpdb->get_results($query);
    }

    if ($results) {
        // echo '<pre>';
        // print_r($results);
        // echo '</pre>';
        foreach ($results as $row) {
            $user_info = get_userdata($row->user_id);
            $user_name = $user_info ? $user_info->display_name : 'Unknown User';

            echo '<div class="message-block spb" >
                <div class="text-icon">
                    <img src="'. THE_SYNERGY_GROUP_URL . 'public/img/account/transactions_blue.svg" alt="transaction icon"/>
                </div>';
            echo '<div class="message-text">
                    <p><strong>Affiliate member: ' . $user_name . '</strong><br>SF' . $row->creds . ' (' . $row->entry . ')' . date('Y-m-d H:i:s', $row->time) . '</p>
                </div>';
            echo '<div class="btn-block">
                    <a href="#" class="btn">read more</a>
                </div>
            </div>';

        }
    } else {
        echo "<p>No transactions found matching the criteria.</p>";
    }

    wp_die();
}

//Fiter SF balance by member
add_action('wp_ajax_filter_members', 'tsg_filter_members');

function tsg_filter_members() {
  
    $sfRange = isset($_POST['sfRange']) ? sanitize_text_field($_POST['sfRange']) : '';
    $userStatus = isset($_POST['userStatus']) ? sanitize_text_field($_POST['userStatus']) : '';

    $ranges = [
        [1, 50],
        [50, 100],
        [100, 150]
    ];

    if (array_key_exists($sfRange, $ranges)) {
        $selectedRange = $ranges[$sfRange];
        $minBalance = $selectedRange[0];
        $maxBalance = $selectedRange[1];
    } else {
        $minBalance = 0;
        $maxBalance = PHP_INT_MAX;
    }

    $users_in_range = [];
    $all_users = get_users();

    foreach ($all_users as $user) {
        $user_id = $user->ID;
        $user_sf_balance = mycred_get_users_total_balance($user_id);
        $user_status = get_user_meta($user_id, 'tsg_user_status', true);

        if (
            $user_sf_balance >= $minBalance && 
            $user_sf_balance <= $maxBalance && 
            $user_status == $userStatus
        ) {
            $users_in_range[] = [
                'user_id' => $user_id,
                'user_name' => $user->display_name,
                'sf_balance' => $user_sf_balance,
                'tsg_user_status' => $user_status,
            ];
        }
    }

    $member_count = 0;
    echo '<div class="messages-sub-block last-bord" >'; 
    if (!empty($users_in_range)) {
        foreach ($users_in_range as $user) {
            $member_count++;
            if ($user['tsg_user_status'] == 0) {
                $user_status_txt = "Inactive";
            } elseif ($user['tsg_user_status'] == 1) {
                $user_status_txt = "Active";
            } else {
                $user_status_txt = "Undefined";
            }  
            echo '<div class="message-block spb">
                <div class="text-icon">';
            echo '<img src="' . THE_SYNERGY_GROUP_URL . 'public/img/account/avatar_profile.svg" alt="avatar icon "/>
                </div>
                <div class="message-text">';
            echo '<p><strong>ID: ' . esc_html($user['user_id']) . ' | Member: ' . esc_html($user['user_name']) . '</strong><br>';
            echo '(SF Balance: ' . esc_html($user['sf_balance']) . ' - User Status: ' . $user_status_txt . ')
                </p>
                </div>
                <div class="btn-block">
                <a href="#" class="btn">read more</a>
                </div>
            </div>';       
        }
    } else {
        echo '<p>No users found matching the selected balance range and status.</p>';
    }
    echo '</div>';

    echo '<div class="block-lines2 big-p">
        <div class="block-line spb first">
        <div class="line-left">
            <p>Member Count:</p>
        </div>
        <div class="line-right va" >
            <p class="main-val2" >' . $member_count . '</p>
        </div>
        </div>
    </div>';
   
    wp_die();
}

//Filter sf transaction details by member
add_action('wp_ajax_filter_member_transactions', 'tsg_filter_member_transactions');

function tsg_filter_member_transactions() {
    $member = isset($_POST['member']) ? sanitize_text_field($_POST['member']) : '';

    if( !empty($member) ){
        $balance = mycred_get_users_total_balance( $member );
        echo '<div class="block-line spb">
                <div class="line-left">
                    <p>Individual member SF balance</p>
                </div>
                <div class="line-right va">
                    <p class="main-val2">SF ' . $balance . '</p>
                </div>
            </div>';

        echo '<h6 class="borderb"><strong>Transaction history </strong></h6>';
        echo '<div class="messages">
                <div class="messages-sub-block last-bord">
                    <div class="message-block spb">
                        <div class="text-icon">
                            <img src="' . THE_SYNERGY_GROUP_URL . 'public/img/account/transactions_blue.svg" alt="transaction progress line icon "/>
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
                </div>
            </div>';

        echo '<div class="block-lines2 big-p">
                <div class="block-line spb first">
                    <div class="line-left">
                    <p>Affiliate Earnings:</p>
                    </div>
                    <div class="line-right va">
                    <p class="main-val2">CHF 400 + SF ' .$balance. '</p>
                    </div>
                </div>
            </div>';

        echo '<h6 class="borderb"><strong>Referred Members:</strong></h6>';
        echo '<div class="messages">
                <div class="messages-sub-block last-bord">
                    <div class="message-block spb">
                        <div class="text-icon">
                            <img src="' . THE_SYNERGY_GROUP_URL . 'public/img/account/avatar.svg" alt="avatar icon "/>
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
                </div>
            </div>';

        echo '<h6 class="borderb"><strong>Referral Activity:</strong></h6>';
        echo '<div class="messages">
                <div class="messages-sub-block last-bord">
                    <div class="message-block spb">
                        <div class="text-icon">
                            <img src="' . THE_SYNERGY_GROUP_URL . 'public/img/account/transactions_blue.svg" alt="transaction progress line icon "/>
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
                </div>
            </div>';
    } else {
        echo '<p>User is undefined.</p>';
    }
    wp_die();
}

//Adjust SF values
//All transactions - Display all transactions.
add_action('wp_ajax_adjust_sf_amount', 'tsg_adjust_sf_amount');

function tsg_adjust_sf_amount() {

    if (!isset($_POST['member']) || !isset($_POST['newSf'])) {
        echo '<p>Fail to send data</p>';
        wp_die();
    } else {
        echo '<p>' . $_POST['member'] . '</p>';
        echo '<p>' . $_POST['newSf'] . '</p>';
    }
    wp_die();
}

add_action('wp_ajax_adjust_affiliate_earning', 'tsg_adjust_affiliate_earning');

function tsg_adjust_affiliate_earning() {

    if (!isset($_POST['member']) || !isset($_POST['newAffiliateEarning'])) {
        echo '<p>Fail to send data</p>';
        wp_die();
    } else {
        echo '<p>' . $_POST['member'] . '</p>';
        echo '<p>' . $_POST['newAffiliateEarning'] . '</p>';
    }
    wp_die();
}

//For testing perpose -> test
function tsg_console_log($message, $data) {
    $json_data = json_encode($data);
    echo "<script>console.log('$message:', " . $json_data . ");</script>";
}

// function update_withdrawal_status() {
//     if (isset($_POST['post_id']) && isset($_POST['status'])) {
//         $post_id = intval($_POST['post_id']);
//         $status = sanitize_text_field($_POST['status']);

//         if (get_post($post_id) === null) {
//             wp_send_json_error('Invalid post ID');
//             return;
//         }

//         if (update_post_meta($post_id, 'status', $status)) {
//             wp_send_json_success('Status updated to ' . $status);
//         } else {
//             wp_send_json_error('Failed to update post meta');
//         }
//     } else {
//         wp_send_json_error('Missing parameters');
//     }
// }
add_action('wp_ajax_update_withdrawal_status', 'update_withdrawal_status');
add_action('wp_ajax_nopriv_update_withdrawal_status', 'update_withdrawal_status');


add_action('wp_ajax_load_affiliate_profiles', 'tsg_load_affiliate_profiles');

function tsg_load_affiliate_profiles() {
    $selectedProfile = isset($_POST['selectedProfile']) ? sanitize_text_field($_POST['selectedProfile']) : '';
    $flipStatus = isset($_POST['flipStatus']) ? sanitize_text_field($_POST['flipStatus']) : '';

    global $wpdb;
    $referred_users_meta = $wpdb->get_var($wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'referred_users'",
        $selectedProfile
    ));

    $referral_code = $wpdb->get_var($wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'referral_code'",
        $selectedProfile
    ));

    $referred_users_count = 0;
    if ($referred_users_meta) {
        $referred_users = maybe_unserialize($referred_users_meta);
        if (is_array($referred_users)) {
            $referred_users_count = count($referred_users);
        }
    }

    $current_status = get_user_meta($selectedProfile, 'referred_status', true);
    if ($flipStatus === '1') {
        $new_status = ($current_status === '1') ? '0' : '1';
        update_user_meta($selectedProfile, 'referred_status', $new_status);
    }
    $status = ($current_status === '1') ? 'Active' : 'Inactive';

    $sum_creds = $wpdb->get_var( $wpdb->prepare(
        "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ref LIKE %s", $selectedProfile, '%ref_fee%'
    ));
     
    // echo "Total creds for user $selectedProfile with ref containing 'ref_fee': " . $sum_creds;
    // echo "Referral Code: " . esc_html($referral_code) . "<br>";
    // echo "Referred Users Count: " . esc_html($referred_users_count);
    // echo "Referred Status: " . esc_html($status);

    echo '<div class="block-line spb media-full">
        <div class="line-left">
          <p>Affiliate ID</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>' . esc_html($referral_code) . '</strong></p>
        </div>
      </div>
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Total Number of Referrals</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>' . esc_html($referred_users_count) . '</strong></p>
        </div>
      </div>
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Earnings from Referrals</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>SF ' . $sum_creds . '</strong></p>
        </div>
      </div>
      <div class="block-line spb media-full">
        <div class="line-left">
          <p>Affiliate Status</p>
        </div>
        <div class="line-right">
          <p class="main-val2"><strong>' . esc_html($status) . '</strong></p>
        </div>
      </div>';

    wp_die();
}

add_action('wp_ajax_save_affiliate_commission_rate', 'tsg_save_affiliate_commission_rate');

function tsg_save_affiliate_commission_rate() {
    $user_id = get_current_user_id();
    $commission_rate = isset($_POST['commission_rate']) ? sanitize_text_field($_POST['commission_rate']) : '';
    $commission_reason = isset($_POST['commission_reason']) ? sanitize_text_field($_POST['commission_reason']) : '';

    $new_record = array(
        'rate'   => $commission_rate,
        'reason' => $commission_reason,
        'date'   => current_time('Y-m-d'),
        'time'   => current_time('H:i:s'),
    );

    $existing_records = get_user_meta($user_id, 'affiliate_commission_rate', true);
    if (!is_array($existing_records)) {
        $existing_records = array();
    }

    $existing_records[] = $new_record;
    update_user_meta($user_id, 'affiliate_commission_rate', $existing_records);

    echo $commission_rate . '%';
    wp_die();
}


add_action('wp_ajax_search_affiliate_users', 'tsg_search_affiliate_users');

function tsg_search_affiliate_users()
{
    global $wpdb;

    $current_user_id = get_current_user_id();
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $referred_users_meta = get_user_meta($current_user_id, 'referred_users', true);

    $referred_user_ids = !empty($referred_users_meta) ? maybe_unserialize($referred_users_meta) : [];

    if (empty($referred_user_ids)) {
        wp_send_json([]); 
    }

    $args = array(
        'include'        => $referred_user_ids, 
        'number'         => 10, 
    );

    if (!empty($search)) {
        $args['search'] = '*' . esc_attr($search) . '*';
        $args['search_columns'] = array('user_login', 'user_email', 'display_name');
    }

    $user_query = new WP_User_Query($args);

    $results = array();
    if (!empty($user_query->get_results())) {
        foreach ($user_query->get_results() as $user) {
            $results[] = array(
                'id'   => $user->ID,
                'text' => $user->display_name,
            );
        }
    }

    wp_send_json($results);
}

add_action('wp_ajax_display_affiliate_commission_adjustment_history', 'tsg_display_affiliate_commission_adjustment_history');

function tsg_display_affiliate_commission_adjustment_history() {
    
    $user_id = get_current_user_id();
    $affiliate_commission_meta = get_user_meta($user_id, 'affiliate_commission_rate', true);

    if (!empty($affiliate_commission_meta) && is_array($affiliate_commission_meta)) {
        $output = '';

        foreach ($affiliate_commission_meta as $commission) {
            $date = isset($commission['date']) ? $commission['date'] : '';
            $time = isset($commission['time']) ? $commission['time'] : '';
            $rate = isset($commission['rate']) ? $commission['rate'] : '';
            $reason = isset($commission['reason']) ? $commission['reason'] : '';

            $formatted_date = date('d.m.Y', strtotime($date));
            $formatted_time = date('H:i', strtotime($time));

            $output .= '
            <div class="message-block spb">
                <div class="text-icon">
                    <img src="' . THE_SYNERGY_GROUP_URL . '/public/img/account/transactions_blue.svg" alt="progress line icon">
                </div>
                <div class="message-text">
                    <p><strong>updated at: ' . esc_html($formatted_date) . ' - ' . esc_html($formatted_time) . '</strong><br>
                    commission rate: ' . esc_html($rate) . '% (' . esc_html($reason) . ')</p>
                </div>
                <div class="btn-block">
                    <a href="#" class="btn minw2">read more</a>
                </div>
            </div>';
        }

        echo $output;
    } else {
        echo 'No commission history available.';
    }

    wp_die();
}


add_action('wp_ajax_search_affiliate_transaction_type', 'tsg_search_affiliate_transaction_type');

function tsg_search_affiliate_transaction_type() {
    global $wpdb;

    $results = $wpdb->get_results("SELECT DISTINCT ref FROM {$wpdb->prefix}myCRED_log");

    $transaction_types = array();
    if (!empty($results)) {
        foreach ($results as $result) {
            $transaction_types[] = array(
                'id'   => $result->ref,
                'text' => ucfirst(str_replace('_', ' ', $result->ref)),
            );
        }
    }

    wp_send_json($transaction_types);
}

add_action('wp_ajax_display_affiliate_payout_details', 'tsg_display_affiliate_payout_details');

function tsg_display_affiliate_payout_details() {
    global $wpdb;
    $current_user_id = get_current_user_id();

    $referred_users_meta = $wpdb->get_var($wpdb->prepare(
        "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'referred_users'",
        $current_user_id
    ));

    $referred_user_ids = maybe_unserialize($referred_users_meta);
    $output = '';

    if (!empty($referred_user_ids) && is_array($referred_user_ids)) {

        foreach ($referred_user_ids as $referred_user_id) {
            $results = $wpdb->get_results($wpdb->prepare(
                "SELECT ID, post_author, post_date, post_title 
                FROM {$wpdb->posts} 
                WHERE post_author = %d AND post_type = 'cashcred_withdrawal'",
                $referred_user_id
            ));

            if (!empty($results)) {
                foreach ($results as $row) {
                    $formatted_date = date('F j, Y', strtotime($row->post_date));
                    $author_name = get_the_author_meta('display_name', $row->post_author);

                    $referred_user_referred_users_meta = $wpdb->get_var($wpdb->prepare(
                        "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'referred_users'",
                        $referred_user_id
                    ));

                    $referred_user_referred_user_ids = maybe_unserialize($referred_user_referred_users_meta);
                    $referred_users_count = !empty($referred_user_referred_user_ids) && is_array($referred_user_referred_user_ids) ? count($referred_user_referred_user_ids) : 0;

                    $output .= '
                        <div class="message-block spb">
                            <div class="text-icon">
                                <img src="' . THE_SYNERGY_GROUP_URL . '/public/img/account/avatar_profile.svg" alt="avatar icon">
                            </div>
                            <div class="message-text">
                                <p><strong>Affiliate member: ' . esc_html($author_name) . '</strong><br>
                                    (' . esc_html($row->post_title) . ' - ' . esc_html($formatted_date) . ' - Referrals Count: ' . esc_html($referred_users_count) . ')</p>
                            </div>
                            <div class="btn-block">
                                <a href="#" class="btn minw2">view</a>
                            </div>
                        </div>';
                }
            }
        }
    }

    if (empty($output)) {
        $output .= '<p>No referred users with cashcred withdrawals found.</p>';
    }

    echo $output;
}

add_action('wp_ajax_save_admin_payment_method', 'tsg_save_admin_payment_method');
function tsg_save_admin_payment_method() {

    $current_user_id = get_current_user_id();
    $payment_method = sanitize_text_field($_POST['payment_method']);

    update_user_meta($current_user_id, 'payment_method', $payment_method);

    echo $payment_method;
}

add_action('wp_ajax_save_admin_schedule_date', 'tsg_save_admin_schedule_date');
function tsg_save_admin_schedule_date() {

    $current_user_id = get_current_user_id();
    $schedule_date = sanitize_text_field($_POST['schedule_date']);

    update_user_meta($current_user_id, 'payment_schedule', $schedule_date);

    echo $schedule_date;
}

function get_unique_statuses() {
    global $wpdb;
    $results = $wpdb->get_col("
        SELECT DISTINCT meta_value 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = 'status'
    ");

    return $results ? $results : ['Approved', 'Cancelled', 'Processing', 'Pending'];
}

function filter_withdrawal_history() {
    $date_from = isset($_POST['date_from']) ? sanitize_text_field($_POST['date_from']) : '';
    $date_to = isset($_POST['date_to']) ? sanitize_text_field($_POST['date_to']) : '';
    $members = isset($_POST['members']) ? (array) $_POST['members'] : [];
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

    $args = array(
        'post_type' => 'cashcred_withdrawal',
        'posts_per_page' => -1,
        'meta_query' => array(),
    );

    if (!empty($status)) {
        $args['meta_query'][] = array(
            'key' => 'status',
            'value' => $status,
            'compare' => '='
        );
    }

    if (!empty($members)) {
        $args['author__in'] = $members;
    }

    if (!empty($date_from) && !empty($date_to)) {
        $args['date_query'] = array(
            array(
                'after' => $date_from,
                'before' => $date_to,
                'inclusive' => true,
            ),
        );
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();

            $member_name = get_the_author_meta('display_name', get_the_author_meta('ID'));
            $amount = get_the_title();
            $date = get_the_date('d.m.Y');
            $payment_currency = get_post_meta(get_the_ID(), 'currency', true);
            $status = get_post_meta(get_the_ID(), 'status', true);
            $payment_method = get_post_meta(get_the_ID(), 'gateway', true);
            ?>
            <div class="message-block message-media spb">
                <div class="message-icon">
                    <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/money2.svg" alt="money icon" />
                </div>
                <div class="message-text">
                    <div class="message-line spb">
                        <p class="message-line-name">Member:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($member_name); ?></strong><br></p>
                    </div>
                    <div class="message-line spb">
                        <p class="message-line-name">Amount:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($payment_currency); ?> <?php echo esc_html($amount); ?></strong><br></p>
                    </div>
                    <div class="message-line spb">
                        <p class="message-line-name">Date:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($date); ?></strong><br></p>
                    </div>
                    <div class="message-line spb">
                        <p class="message-line-name">Payment method:</p>
                        <p class="message-line-value"><strong><?php echo esc_html($payment_method); ?></strong><br></p>
                    </div>
                </div>
                <div class="message-btns">
                    <div class="btns-first-line fl-end">
                        <div class="btn-block">
                            <a href="#" class="btn green-btn">export</a>
                        </div>
                    </div>
                    <div class="status">
                        <p>Status: <span class="goldc"><?php echo esc_html($status); ?></span></p>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo "<p>No withdrawals found for the selected criteria.</p>";
    endif;

    $html = ob_get_clean();
    wp_send_json_success(['html' => $html]);
}

add_action('wp_ajax_filter_withdrawal_history', 'filter_withdrawal_history');
add_action('wp_ajax_nopriv_filter_withdrawal_history', 'filter_withdrawal_history');


function save_payment_settings() {
    // Check for payment method and details in the AJAX request
    if (isset($_POST['payment_method']) && isset($_POST['payment_details'])) {
        $payment_method = sanitize_text_field($_POST['payment_method']);
        $payment_details = sanitize_text_field($_POST['payment_details']);

        // Save values as options in WordPress
        $method_saved = update_option('payment_method_option', $payment_method);
        $details_saved = update_option('payment_details_option', $payment_details);

        // Check if both options saved successfully
        if ($method_saved && $details_saved) {
            wp_send_json_success('Payment settings saved successfully.');
        } else {
            wp_send_json_error('Failed to save payment settings.');
        }
    } else {
        wp_send_json_error('Missing payment method or payment details.');
    }
}
add_action('wp_ajax_save_payment_settings', 'save_payment_settings');
add_action('wp_ajax_nopriv_save_payment_settings', 'save_payment_settings');



function save_fee_structure() {
    // Check if fees data is provided
    if (isset($_POST['fees']) && is_array($_POST['fees'])) {
        $fees = $_POST['fees'];

        // Debug log for received data
        error_log("Received Fees Data: " . print_r($fees, true));

        $success = true;
        foreach ($fees as $fee) {
            // Validate each item has product_id and fee_structure
            if (isset($fee['product_id']) && isset($fee['fee_structure'])) {
                $product_id = intval($fee['product_id']);
                $fee_structure = sanitize_text_field($fee['fee_structure']);

                // Save the fee structure as post meta
                if (!update_post_meta($product_id, 'fee_structure', $fee_structure)) {
                    $success = false;
                    error_log("Failed to save fee structure for product ID: $product_id");
                }
            } else {
                $success = false;
                error_log("Missing product ID or fee structure in item: " . print_r($fee, true));
            }
        }

        // Send response based on success or failure
        if ($success) {
            wp_send_json_success('Fee structures saved successfully.');
        } else {
            wp_send_json_error('Failed to save one or more fee structures.');
        }
    } else {
        wp_send_json_error('Invalid data provided.');
    }
}
add_action('wp_ajax_save_fee_structure', 'save_fee_structure');
add_action('wp_ajax_nopriv_save_fee_structure', 'save_fee_structure');




