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

        // $user_balance = mycred_get_users_balance($user_id, 'synergy_francs');

        $user_balance = get_current_user_current_sf_balance($user_id);

        if ($user_balance < $total_sf_points_needed) {
            $errors->add( 'validation', __('Insufficient points in your account to cover the required SF amount.', 'woocommerce') ); 
        }
    }
}

add_action( 'woocommerce_before_checkout_form', 'tsg_buy_sf_from_checkout' );
function tsg_buy_sf_from_checkout() { 
    
    $user_id = get_current_user_id();
    $total_sf_points_needed = 0;

    foreach (WC()->cart->get_cart() as $cart_item) {
        $product_id = $cart_item['product_id'];
        $product_price = wc_get_price_to_display($cart_item['data']);
        $sf_percentage = get_post_meta($product_id, 'sf_percentage', true);

        if (!empty($sf_percentage)) {
            $sf_points = ($product_price * floatval($sf_percentage)) / 100;
            $total_sf_points_needed += $sf_points;
        }
    }

    $user_balance = get_current_user_current_sf_balance($user_id);

    if ($user_balance < $total_sf_points_needed) {
        echo '<div class="tsg-buy-sf-from-checkout-wrapper ">
            <div class="woocommerce-info">
                <div class="woocommerce-info-text">
                    <span>Your balance is SF ' . $user_balance . '.</span> 
                    <a href="#" class="checkout-buy-sf-link"> Click here to buy SF</a>
                </div>
            </div>
            <div class="checkout-buy-sf-toggle-wrapper tsg-entry-hidden">
            <p>Enter the SF amount</p>';
        echo do_shortcode('[mycred_buy_form]');
        echo '</div>
        </div>';
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

            $buyer_deduction_for_his_ref = mycred_add(
                'buyer_ref_cost', // Reference
                $user_id, // User ID
                -$sf_buyer_referee_fee, // Points to deduct (negative)
                'Deducted %plural% for SF percentage on order #' . $order_id . ' to pay to the ref: ' . $buyer_referee_id, // Log entry
                $order_id, // Data (optional)
                'synergy_francs'
            );
            wc_get_logger()->debug( 'Checkout SF calculator Buyer Deduction:' . $buyer_deduction, array( 'source' => 'tsg' )  );

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
            $sale_amount = $sf_points - $sf_seller_referee_fee;
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
    $user_id = get_current_user_id(); 

    if (is_array($certificates)) {
        update_user_meta($user_id, 'user_certificates', $certificates);
        $saved_certificates = get_user_meta($user_id, 'user_certificates', true);

        if (!empty($saved_certificates)) {
            foreach ($saved_certificates as $index => $certificate) {
                if (isset($certificate['text'])) {
                    echo '<div class="item w2" id="certificate-' . $index . '">
                            <div class="itemr">
                                <div class="award-block tc">
                                    <a href="#" class="block-edit delete-certificate-btn" data-id="' . $index . '" data-text="' . esc_html($certificate['text']) . '">
                                        <img src="' . THE_SYNERGY_GROUP_URL . '/public/img/account/trash-can.png" alt="edit icon">
                                    </a>
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
    } else {
        echo '<p>Invalid certificates data</p>';
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
    } elseif (empty($transactionType) && $filter === 1) { //referral users filter /if filter === 1
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


function save_sf_multiplier() {
    // Check if multipliers data is provided
    if (isset($_POST['multipliers']) && is_array($_POST['multipliers'])) {
        $multipliers = $_POST['multipliers'];
        $errors = [];

        foreach ($multipliers as $multiplier) {
            if (isset($multiplier['product_id']) && isset($multiplier['sf_multiplier'])) {
                $product_id = intval($multiplier['product_id']);
                $sf_multiplier = sanitize_text_field($multiplier['sf_multiplier']);

                // Save the multiplier as post meta
                if (!update_post_meta($product_id, 'sf_multiplier', $sf_multiplier)) {
                    $errors[] = "Failed to save SF multiplier for product ID: $product_id";
                }
            } else {
                $errors[] = "Invalid data format for item: " . print_r($multiplier, true);
            }
        }

        if (empty($errors)) {
            wp_send_json_success('SF multipliers saved successfully.');
        } else {
            wp_send_json_error(['Failed to save SF multipliers:', 'errors' => $errors]);
        }
    } else {
        wp_send_json_error('Invalid data provided.');
    }
}
add_action('wp_ajax_save_sf_multiplier', 'save_sf_multiplier');
add_action('wp_ajax_nopriv_save_sf_multiplier', 'save_sf_multiplier');


function save_number_of_products() {
    // Check if product counts data is provided
    if (isset($_POST['product_counts']) && is_array($_POST['product_counts'])) {
        $product_counts = $_POST['product_counts'];
        $errors = [];

        foreach ($product_counts as $count) {
            if (isset($count['product_id']) && isset($count['number_of_products'])) {
                $product_id = intval($count['product_id']);
                $number_of_products = sanitize_text_field($count['number_of_products']);

                // Save the number of products as post meta
                if (!update_post_meta($product_id, 'number_of_products', $number_of_products)) {
                    $errors[] = "Failed to save product count for product ID: $product_id";
                }
            } else {
                $errors[] = "Invalid data format for item: " . print_r($count, true);
            }
        }

        if (empty($errors)) {
            wp_send_json_success('Product counts saved successfully.');
        } else {
            wp_send_json_error(['Failed to save product counts:', 'errors' => $errors]);
        }
    } else {
        wp_send_json_error('Invalid data provided.');
    }
}
add_action('wp_ajax_save_number_of_products', 'save_number_of_products');
add_action('wp_ajax_nopriv_save_number_of_products', 'save_number_of_products');

function save_user_limits_and_notification() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in.');
        return;
    }

    // Get the current user ID
    $user_id = get_current_user_id();

    // Check for data in the AJAX request
    if (isset($_POST['fee_collection_limit']) && isset($_POST['withdrawal_limit']) && isset($_POST['notification'])) {
        $fee_collection_limit = sanitize_text_field($_POST['fee_collection_limit']);
        $withdrawal_limit = sanitize_text_field($_POST['withdrawal_limit']);
        $notification_setting = sanitize_text_field($_POST['notification']);

        // Save each setting as user meta
        $fee_saved = update_user_meta($user_id, 'fee_collection_limit', $fee_collection_limit);
        $withdrawal_saved = update_user_meta($user_id, 'withdrawal_limit', $withdrawal_limit);
        $notification_saved = update_user_meta($user_id, 'notification', $notification_setting);

        // Check if all settings saved successfully
        if ($fee_saved && $withdrawal_saved && $notification_saved) {
            wp_send_json_success('Settings saved successfully.');
        } else {
            wp_send_json_error('Failed to save one or more settings.');
        }
    } else {
        wp_send_json_error('Missing data.');
    }
}
add_action('wp_ajax_save_user_limits_and_notification', 'save_user_limits_and_notification');


add_action('wp_ajax_admin_fee_overview_add_services', 'tsg_admin_fee_overview_add_services');
function tsg_admin_fee_overview_add_services() {
    $member = sanitize_text_field($_POST['member']);
    global $wpdb;

    $order_ids = $wpdb->get_col($wpdb->prepare(
        "SELECT ref_id FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d",
        $member
    ));

    $options = '';

    if (empty($order_ids)) {
        $options = '<option value="">No Services</option>';
    } else {
        $unique_product_ids = [];

        foreach ($order_ids as $order_id) {
            $order_items = $wpdb->get_results($wpdb->prepare(
                "SELECT order_item_id, order_item_name FROM {$wpdb->prefix}woocommerce_order_items 
                WHERE order_id = %d AND order_item_type = 'line_item'",
                $order_id
            ));

            foreach ($order_items as $item) {
                $product_id = $wpdb->get_var($wpdb->prepare(
                    "SELECT meta_value FROM {$wpdb->prefix}woocommerce_order_itemmeta 
                    WHERE order_item_id = %d AND meta_key = '_product_id'",
                    $item->order_item_id
                ));

                if ($product_id && !in_array($product_id, $unique_product_ids)) {
                    $unique_product_ids[] = $product_id;
                    $options .= '<option value="' . esc_attr($product_id) . '">' . esc_html($item->order_item_name) . '</option>';
                }
            }
        }

        // If no unique products were found, set a default option
        if (empty($options)) {
            $options = '<option value="">No Services</option>';
        }
    }

    echo $options;
}

add_action('wp_ajax_admin_filter_fee_overview', 'tsg_admin_filter_fee_overview');

function tsg_admin_filter_fee_overview() {
    global $wpdb;

    $member = sanitize_text_field($_POST['member']);
    $date_from = sanitize_text_field($_POST['date_from']);
    $date_to = sanitize_text_field($_POST['date_to']);
    $service_type = sanitize_text_field($_POST['service_type']);
    $transaction_type = sanitize_text_field($_POST['transaction_type']);
    $affiliate_fees = sanitize_text_field($_POST['affiliate_fees']);

    if (!empty($date_from)) {
        $date_from = DateTime::createFromFormat('m/d/Y', $date_from)->format('Y-m-d');
    }
    if (!empty($date_to)) {
        $date_to = DateTime::createFromFormat('m/d/Y', $date_to)->format('Y-m-d');
    }


    $date_condition = "";
    if (!empty($date_from) && !empty($date_to)) {
        $date_condition = "AND time BETWEEN %d AND %d";
    }

    $query = "SELECT * FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d ";

    $query_conditions = [$member];

    if (!empty($date_from) && !empty($date_to)) {
        $query_conditions[] = strtotime($date_from);
        $query_conditions[] = strtotime($date_to);
    }

    $logs = $wpdb->get_results($wpdb->prepare($query . $date_condition, ...$query_conditions));

    $filtered_results = [];
    $total_creds = 0; 

    foreach ($logs as $log) {
        $order_id = $log->ref_id;

        if (!empty($service_type)) {
            $product_check = $wpdb->get_var($wpdb->prepare(
                "SELECT order_item_id FROM {$wpdb->prefix}woocommerce_order_items 
                WHERE order_id = %d AND order_item_type = 'line_item'",
                $order_id
            ));
            
            if ($product_check) {
                $product_id = $wpdb->get_var($wpdb->prepare(
                    "SELECT meta_value FROM {$wpdb->prefix}woocommerce_order_itemmeta 
                    WHERE order_item_id = %d AND meta_key = '_product_id'",
                    $product_check
                ));

                if ($product_id != $service_type) {
                    continue;
                }
            }
        }

        if (!empty($transaction_type) && $log->ref != $transaction_type) {
            continue;
        }
        
        if (!empty($affiliate_fees) && trim(strtolower($log->ref)) != trim(strtolower($affiliate_fees))) {
            continue;
        }

        $total_creds += $log->creds; 

        $filtered_results[] = $log;
    }

    echo !empty($filtered_results) ? esc_html($total_creds) : '0';
    wp_die(); 
}

//Adimn - Fee management page
function tsg_get_unique_services_with_ref_id() {
    global $wpdb;

    $results = $wpdb->get_results("
        SELECT DISTINCT ref, ref_id
        FROM {$wpdb->prefix}myCRED_log
        WHERE ref IN ('buy_service', 'sale_of_service', 'buyer_ref_fee', 'seller_ref_fee')
    ");

    if (empty($results)) {
        return '<option value="">No services</option>';
    }

    $options = '';

    foreach ($results as $result) {
        $ref = esc_attr($result->ref);
        $ref_id = esc_attr($result->ref_id);
        $value = $ref_id . '|' . $ref;
        $options .= '<option value="' . $value . '">' . ucfirst(str_replace('_', ' ', $ref)) . ' (ID: ' . $ref_id . ')</option>';
    }

    return $options;
}


add_action('wp_ajax_admin_reverse_transaction', 'tsg_admin_reverse_transaction');

function tsg_admin_reverse_transaction() {
    global $wpdb;

    $ref_id = sanitize_text_field($_POST['ref_id']);
    $ref = sanitize_text_field($_POST['ref']);
    $reason = sanitize_text_field($_POST['reason']);

    $transaction = $wpdb->get_row($wpdb->prepare(
        "SELECT user_id, creds FROM {$wpdb->prefix}myCRED_log WHERE ref = %s AND ref_id = %d",
        $ref,
        $ref_id
    ));

    if ($transaction) {
        $user_id = $transaction->user_id;
        $amount = abs($transaction->creds); 

        mycred_subtract('penalty_reversal', $user_id, $amount, $reason);

        echo 'Transaction reversed successfully for user ID ' . esc_html($user_id) . ' with amount: ' . esc_html($amount) . '.';
    } else {
        echo 'Error: Transaction not found.';
    }

    wp_die(); 
}


add_action('wp_ajax_admin_manual_fee_adjustment', 'tsg_admin_manual_fee_adjustment');

function tsg_admin_manual_fee_adjustment() {

    $member = sanitize_text_field($_POST['rmember']);
    $manual_fee = floatval($_POST['manual_fee']); 

    if (empty($member) || !is_numeric($manual_fee)) {
        echo 'Error: Please provide a valid member and fee amount.';
        wp_die();
    }

    $result = mycred_add('manual_fee_adjustment', $member, $manual_fee, 'Manual fee adjustment');

    if ($result) {
        $operation = $manual_fee > 0 ? 'added' : 'deducted';
        echo 'Manual fee adjustment successfully ' . $operation . ' for user ID ' . esc_html($member) . ' with amount: ' . esc_html($manual_fee) . '.';
    } else {
        echo 'Error: Could not complete the transaction.';
    }

    wp_die(); 
}

add_action('wp_ajax_onchange_update_user_profile', 'tsg_onchange_update_user_profile');

function tsg_onchange_update_user_profile() {

    $field_name = sanitize_text_field($_POST['field_name']);
    $field_value = sanitize_text_field($_POST['field_value']);
    $user_id = get_current_user_id();

    if (update_user_meta($user_id, $field_name, $field_value)) {
        echo ( $field_value );
    } else {
        // wp_send_json_error(['message' => 'Failed to update profile.']);
        echo "Failed.";
    }

    wp_die(); 
}

add_action('wp_ajax_update_profile_image', 'tsg_update_profile_image');
function tsg_update_profile_image() {
    
    if (empty($_FILES['bp_avatar_upload']) || $_FILES['bp_avatar_upload']['error'] != 0) {
        wp_send_json_error(['message' => __('Invalid file upload.', 'the-synergy-group-addon')]);
        return; 
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $file = $_FILES['bp_avatar_upload'];
    $overrides = ['test_form' => false]; 
    $uploaded = wp_handle_upload($file, $overrides);

    if (!isset($uploaded['error']) && isset($uploaded['file'])) {
        $user_id = get_current_user_id();

        $args = [
            'item_id' => $user_id,
            'object' => 'user',
            'avatar_dir' => 'avatars',
            'file' => $file, 
            'crop_x' => 0,
            'crop_y' => 0,
            'crop_w' => bp_core_avatar_full_width(),
            'crop_h' => bp_core_avatar_full_height()
        ];

        $avatar_handle = bp_core_avatar_handle_upload($args, 'bp_core_avatar_handle_upload'); 

        if ($avatar_handle) {
            $new_avatar_url = bp_core_fetch_avatar(['item_id' => $user_id, 'type' => 'full', 'html' => false]);
            wp_send_json_success(['new_image_url' => $new_avatar_url]);
        } else {
            wp_send_json_error(['message' => __('Failed to set new avatar.', 'the-synergy-group-addon')]);
        }
    } else {
        wp_send_json_error(['message' => isset($uploaded['error']) ? $uploaded['error'] : __('File upload failed.', 'the-synergy-group-addon')]);
    }
}

//user settings page
function save_user_settings() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in.');
        return;
    }

    // Get the current user ID
    $user_id = get_current_user_id();

    // Check and sanitize data
    $profile_visibility = isset($_POST['profile_visibility']) ? sanitize_text_field($_POST['profile_visibility']) : null;
    $payment_methods = isset($_POST['payment_methods']) ? sanitize_text_field($_POST['payment_methods']) : null;
    $default_currency = isset($_POST['default_currency']) ? sanitize_text_field($_POST['default_currency']) : null;
    $notification_preferences = isset($_POST['notification_preferences']) ? sanitize_text_field($_POST['notification_preferences']) : null;
    $affiliate_earnings = isset($_POST['affiliate_earnings']) ? sanitize_text_field($_POST['affiliate_earnings']) : null;
    $data_export = isset($_POST['data_export']) ? sanitize_text_field($_POST['data_export']) : null;

    // Save user meta
    $errors = [];
    if ($profile_visibility && !update_user_meta($user_id, 'user_profile_visibility', $profile_visibility)) {
        $errors[] = 'Failed to save profile visibility.';
    }
    if ($payment_methods && !update_user_meta($user_id, 'user_payment_methods', $payment_methods)) {
        $errors[] = 'Failed to save payment methods.';
    }
    if ($default_currency && !update_user_meta($user_id, 'user_default_currency', $default_currency)) {
        $errors[] = 'Failed to save default currency.';
    }
    if ($notification_preferences && !update_user_meta($user_id, 'user_notification_preferences', $notification_preferences)) {
        $errors[] = 'Failed to save notification preferences.';
    }
    if ($affiliate_earnings && !update_user_meta($user_id, 'user_affiliate_earnings', $affiliate_earnings)) {
        $errors[] = 'Failed to save affiliate earnings.';
    }
    if ($data_export && !update_user_meta($user_id, 'user_data_export', $data_export)) {
        $errors[] = 'Failed to save data export.';
    }

    // Return response
    if (empty($errors)) {
        wp_send_json_success('User settings saved successfully.');
    } else {
        wp_send_json_error(['Failed to save some settings.', 'errors' => $errors]);
    }
}
add_action('wp_ajax_save_user_settings', 'save_user_settings');


add_action('wp_ajax_change_user_password', 'handle_change_user_password');

function handle_change_user_password() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error('You must be logged in to change your password.');
    }

    // Get the current user
    $user_id = get_current_user_id();
    $new_password = sanitize_text_field($_POST['password']);

    // Validate the password
    if (empty($new_password) || strlen($new_password) < 6) {
        wp_send_json_error('The password must be at least 6 characters long.');
    }

    // Update the user's password
    wp_set_password($new_password, $user_id);

    // Optional: Log the user out after changing the password
    wp_logout();

    wp_send_json_success('Password updated successfully.');
}



function get_user_leaderboard_positions($user_id, $point_type = 'synergy_francs') {
    global $wpdb, $mycred;

    if (!class_exists('myCRED_Core')) {
        return array('current_position' => '-', 'previous_position' => '-');
    }

    // Get the myCred log table name
    $log_table = $mycred->log_table;

    // Get the current timestamp
    $until = current_time('timestamp');

    // Query for the current position
    $current_position = $wpdb->get_var($wpdb->prepare("
        SELECT rank FROM (
            SELECT s.*, @rank := @rank + 1 rank FROM (
                SELECT l.user_id, SUM(l.creds) AS Balance 
                FROM {$log_table} l
                WHERE l.ctype = %s
                GROUP BY l.user_id
            ) s, (SELECT @rank := 0) init
            ORDER BY Balance DESC, s.user_id ASC
        ) r
        WHERE user_id = %d", $point_type, $user_id
    ));

    // Handle the case where no position is found
    if ($current_position === NULL) {
        $current_position = '-';
    }

    // Get the time range for the previous month
    $from_last_month = mktime(0, 0, 0, date('m', $until) - 1, 1, date('Y', $until));
    $until_last_month = mktime(23, 59, 59, date('m', $until), 0, date('Y', $until));

    // Query for the previous month's position
    $previous_position = $wpdb->get_var($wpdb->prepare("
        SELECT rank FROM (
            SELECT s.*, @rank := @rank + 1 rank FROM (
                SELECT l.user_id, SUM(l.creds) AS Balance 
                FROM {$log_table} l
                WHERE l.ctype = %s AND l.time BETWEEN %d AND %d
                GROUP BY l.user_id
            ) s, (SELECT @rank := 0) init
            ORDER BY Balance DESC, s.user_id ASC
        ) r
        WHERE user_id = %d", $point_type, $from_last_month, $until_last_month, $user_id
    ));

    // Handle the case where no position is found
    if ($previous_position === NULL) {
        $previous_position = '-';
    }

    return array(
        'current_position' => $current_position,
        'previous_position' => $previous_position
    );
}

add_action('wp_ajax_get_current_user_buy_sell_history', 'tsg_get_current_user_buy_sell_history');
function tsg_get_current_user_buy_sell_history() {
    $user_id = $_POST['user_id'];
    global $wpdb;

    if(!empty($user_id)) {
        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d AND ( ref LIKE %s OR ref LIKE %s)", $user_id, '%buy_creds_with%', '%withdrawal%'
        ));

        if ($results) {
            // echo '<pre>';
            // print_r($results);
            // echo '</pre>';
            foreach ($results as $row) {
                $user_info = get_userdata($row->user_id);
                $user_name = $user_info ? $user_info->display_name : 'Unknown User';
    
                echo '<div class="message-block spb" style="width: 100%;">
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
            echo '<div class="message-block spb" >
                <div class="text-icon">
                    <img src="'. THE_SYNERGY_GROUP_URL . 'public/img/account/transactions_blue.svg" alt="transaction icon"/>
                </div>';
            echo '<div class="message-text">
                    <p>No transactions found matching the criteria.</p>
                </div>';
            echo '<div class="btn-block"> </div>
                </div>';
     
        }

    } else {
        wp_die();
    }
    wp_die();
}

// //Change product price
// add_filter('woocommerce_cart_item_price', 'add_chf_sf_under_price_without_currency', 10, 3);
// function add_chf_sf_under_price_without_currency($price, $cart_item, $cart_item_key) {
//     $product_id = $cart_item['product_id'];

//     $product = wc_get_product($product_id);
//     $regular_price = (float) $product->get_regular_price();

//     $chf_percentage = (float) get_post_meta($product_id, 'chf_percentage', true);
//     $sf_percentage = (float) get_post_meta($product_id, 'sf_percentage', true);

//     $chf_value = $chf_percentage ? number_format($regular_price * ($chf_percentage / 100), 2) : 'N/A';
//     $sf_value = $sf_percentage ? number_format($regular_price * ($sf_percentage / 100), 2) : 'N/A';

//     $price .= '<div class="custom-cart-values">';
//     $price .= '<p><strong>CHF Value:</strong> ' . $chf_value . '</p>';
//     $price .= '<p>SF ' . $sf_value . '</p>';
//     $price .= '</div>';

//     return $price;
// }

// // Add SF Value under the product name in the checkout
// add_filter('woocommerce_checkout_cart_item_quantity', 'add_sf_in_checkout', 10, 3);
// function add_sf_in_checkout($product_name, $cart_item, $cart_item_key) {
//     $product_id = $cart_item['product_id'];

//     $product = wc_get_product($product_id);
//     $regular_price = (float) $product->get_regular_price();

//     $sf_percentage = (float) get_post_meta($product_id, 'sf_percentage', true);

//     $sf_value = $sf_percentage ? number_format($regular_price * ($sf_percentage / 100), 2) : 'N/A';
//     $product_name .= '<div class="custom-cart-values">';
//     $product_name .= '<p>' . $sf_value . '</p>';
//     $product_name .= '</div>';

//     return $product_name;
// }



// add_action('woocommerce_before_calculate_totals', 'apply_chf_price_in_cart', 10, 1);
// function apply_chf_price_in_cart($cart) {
//     if (is_admin() && !defined('DOING_AJAX')) {
//         return;
//     }

//     foreach ($cart->get_cart() as $cart_item) {
//         if (isset($cart_item['chf_price'])) {
//             $cart_item['data']->set_price($cart_item['chf_price']); // Set CHF price
//         }
//     }
// }


// add_filter('woocommerce_get_price_html', 'replace_regular_price_with_chf_price', 10, 2);
// function replace_regular_price_with_chf_price($price_html, $product) {
//     $product_id = $product->get_id();
//     $regular_price = $product->get_regular_price();

//     $chf_percentage = get_post_meta($product_id, 'chf_percentage', true);
//     $chf_price = !empty($chf_percentage) ? $regular_price * ($chf_percentage / 100) : $regular_price;

//     $sf_percentage = get_post_meta($product_id, 'sf_percentage', true);
//     $sf_price = !empty($sf_percentage) ? $regular_price * ($sf_percentage / 100) : 0;

//     $price_html = wc_price($chf_price);

//     if ($sf_price > 0) {
//         $price_html .= '<br><small>SF ' . number_format($sf_price, 2) . '</small>';
//     }

//     return $price_html;
// }

// Add CHF and SF Values below the category on the single product page
add_action('woocommerce_single_product_summary', 'display_chf_sf_single_product', 6);

function display_chf_sf_single_product() {
    global $product;

    if (!$product || !is_a($product, 'WC_Product')) {
        return; 
    }

    $product_id = $product->get_id();
    $regular_price = (float) $product->get_regular_price();


    $chf_percentage = get_post_meta($product_id, 'chf_percentage', true);
    $sf_percentage = get_post_meta($product_id, 'sf_percentage', true);


    if (!$chf_percentage && !$sf_percentage) {
        return;
    }

    $chf_value = $chf_percentage ? number_format($regular_price * ($chf_percentage / 100), 2) : 'N/A';
    $sf_value = $sf_percentage ? number_format($regular_price * ($sf_percentage / 100), 2) : 'N/A';

    echo '<div class="product-meta-values" style="margin-top: 10px;">';

    if ($chf_percentage) {
        echo '<p><strong>CHF Value:</strong> ' . $chf_value . '</p>';
    }
    if ($sf_percentage) {
        echo '<p><strong>SF Value:</strong> ' . $sf_value . '</p>';
    }

    echo '</div>';
}

//new price change
// Change the displayed price in the shop and single product pages to the CHF price
add_filter('woocommerce_get_price_html', 'replace_regular_price_with_chf_price', 10, 2);
function replace_regular_price_with_chf_price($price_html, $product) {
    $product_id = $product->get_id();
    $regular_price = (float) $product->get_regular_price();

    $chf_percentage = (float) get_post_meta($product_id, 'chf_percentage', true);
    $chf_price = $chf_percentage ? $regular_price * ($chf_percentage / 100) : $regular_price;

    $sf_percentage = (float) get_post_meta($product_id, 'sf_percentage', true);
    $sf_value = $sf_percentage ? $regular_price * ($sf_percentage / 100) : 0;

    // Display CHF price as the main price
    $price_html = wc_price($chf_price);

    // Add SF value as additional information
    if ($sf_value > 0) {
        $price_html .= '<br><small>SF ' . number_format($sf_value, 2) . '</small>';
    }

    return $price_html;
}

// Apply the CHF price to the cart items dynamically
add_action('woocommerce_before_calculate_totals', 'apply_chf_price_in_cart', 10, 1);
function apply_chf_price_in_cart($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item) {
        $product_id = $cart_item['product_id'];

        $product = wc_get_product($product_id);
        $regular_price = (float) $product->get_regular_price();

        $chf_percentage = (float) get_post_meta($product_id, 'chf_percentage', true);
        $chf_price = $chf_percentage ? $regular_price * ($chf_percentage / 100) : $regular_price;

        // Apply CHF price to the cart
        $cart_item['data']->set_price($chf_price);
    }
}

// Display SF value under the product name in the cart and checkout pages
add_filter('woocommerce_cart_item_name', 'add_sf_under_product_name_in_cart', 10, 3);
add_filter('woocommerce_checkout_cart_item_quantity', 'add_sf_under_product_name_in_cart', 10, 3);
function add_sf_under_product_name_in_cart($product_name, $cart_item, $cart_item_key) {
    $product_id = $cart_item['product_id'];

    $product = wc_get_product($product_id);
    $regular_price = (float) $product->get_regular_price();

    $sf_percentage = (float) get_post_meta($product_id, 'sf_percentage', true);
    $sf_value = $sf_percentage ? number_format($regular_price * ($sf_percentage / 100), 2) : 'N/A';

    // Add SF value below product name
    $product_name .= '<div class="custom-cart-values">';
    $product_name .= '<p><small>SF ' . $sf_value . '</small></p>';
    $product_name .= '</div>';

    return $product_name;
}

//chart generation of the user side 
function synergy_get_chart_data() {
    global $wpdb;

    $results = $wpdb->get_results("
        SELECT 
            ref,
            FROM_UNIXTIME(time, '%Y-%m-%d') AS date,
            SUM(creds) AS total_creds
        FROM wp_myCRED_log
        GROUP BY ref, date
        ORDER BY date ASC
    ");

    $data = [];

    // Format data for Chart.js
    foreach ($results as $row) {
        $data[$row->ref]['labels'][] = $row->date;
        $data[$row->ref]['data'][] = $row->total_creds;
    }

    return $data;
}

add_action('wp_ajax_get_monthly_creds', 'tsg_get_monthly_creds');
function tsg_get_monthly_creds() {
    global $wpdb;
    $user_id = get_current_user_id();

    $monthly_data = [];

    $monthly_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                YEAR(FROM_UNIXTIME(time)) AS year, 
                MONTH(FROM_UNIXTIME(time)) AS month,
                SUM(CASE WHEN ref LIKE %s OR ref LIKE %s THEN creds ELSE 0 END) AS subscriptions,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS service_sales,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS affiliates,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS purchases
             FROM {$wpdb->prefix}myCRED_log 
             WHERE user_id = %d 
             GROUP BY year, month",
            '%logging_in%', 
            '%registration%', 
            '%sale_of_service%', 
            '%ref_fee%', 
            '%buy_creds_with%', 
            $user_id
        )
    );

    wp_send_json_success($monthly_data);

    wp_die();
}

add_action('wp_ajax_get_monthly_log_reg_buy_creds', 'tsg_get_monthly_log_reg_buy_creds');
function tsg_get_monthly_log_reg_buy_creds() {
    global $wpdb;
    $user_id = get_current_user_id();

    $monthly_data = [];

    $monthly_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                YEAR(FROM_UNIXTIME(time)) AS year, 
                MONTH(FROM_UNIXTIME(time)) AS month,
                SUM(CASE WHEN ref LIKE %s OR ref LIKE %s OR ref LIKE %s THEN creds ELSE 0 END) AS log_reg_buy_cred_total
             FROM {$wpdb->prefix}myCRED_log 
             WHERE user_id = %d 
             GROUP BY year, month",
            '%logging_in%', 
            '%registration%',
            '%buy_creds_with%', 
            $user_id
        )
    );

    wp_send_json_success($monthly_data);

    wp_die();
}

add_action('wp_ajax_get_monthly_paid_creds', 'tsg_get_monthly_paid_creds');
function tsg_get_monthly_paid_creds() {
    global $wpdb;
    $user_id = get_current_user_id();

    $monthly_data = [];

    $monthly_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                YEAR(FROM_UNIXTIME(time)) AS year, 
                MONTH(FROM_UNIXTIME(time)) AS month,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS service_buy_creds,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS sell_creds,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS withdrawal_creds,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS admin_deduction_creds,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS ref_cost_creds
             FROM {$wpdb->prefix}myCRED_log 
             WHERE user_id = %d 
             GROUP BY year, month",
            '%buy_service%', 
            '%sf_deduction%', 
            '%withdrawal%', 
            '%admin_deduction%', 
            '%buyer_ref_cost%', 
            $user_id
        )
    );

    wp_send_json_success($monthly_data);

    wp_die();
} 

add_action('wp_ajax_get_monthly_affiliate_creds', 'tsg_get_monthly_affiliate_creds');
function tsg_get_monthly_affiliate_creds() {
    global $wpdb;
    $user_id = get_current_user_id();

    $monthly_data = [];

    $monthly_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                YEAR(FROM_UNIXTIME(time)) AS year, 
                MONTH(FROM_UNIXTIME(time)) AS month,
                SUM(CASE WHEN ref LIKE %s THEN creds ELSE 0 END) AS sum_affiliates_creds
             FROM {$wpdb->prefix}myCRED_log 
             WHERE user_id = %d 
             GROUP BY year, month", 
            '%buyer_ref_cost%', 
            $user_id
        )
    );

    wp_send_json_success($monthly_data);

    wp_die();
}

add_action('wp_ajax_get_monthly_total_creds', 'tsg_get_monthly_total_creds');
function tsg_get_monthly_total_creds() {
    global $wpdb;
    $user_id = get_current_user_id();

    $monthly_data = [];

    $monthly_data = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT 
                YEAR(FROM_UNIXTIME(time)) AS year, 
                MONTH(FROM_UNIXTIME(time)) AS month,
                SUM(creds) AS sum_sf_creds
             FROM {$wpdb->prefix}myCRED_log 
             WHERE user_id = %d 
             GROUP BY year, month",
             $user_id
        )
    );

    wp_send_json_success($monthly_data);

    wp_die();
}

function get_current_user_current_sf_balance($user_id) {
    global $wpdb;

    $sum_creds = $wpdb->get_var( $wpdb->prepare(
        "SELECT SUM(creds) FROM {$wpdb->prefix}myCRED_log WHERE user_id = %d", $user_id
    ));
    return $sum_creds;
}