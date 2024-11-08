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
add_action('wp_ajax_save_certificates', 'save_certificates');
function save_certificates() {
    if (!empty($_POST['certificates']) && is_array($_POST['certificates'])) {
        $user_id = get_current_user_id();
        $certificates = array_map('wc_clean', $_POST['certificates']);

        // Save certificates as a single string or JSON encoded array
        $certificates_str = json_encode($certificates);
        xprofile_set_field_data('certificate', $user_id, $certificates_str);
    }
    $user_id = get_current_user_id();
    $certificates_str = xprofile_get_field_data('certificate', $user_id);

    $certificates = !empty($certificates_str) ? json_decode($certificates_str) : [];
    wp_send_json_success(['certificates' => $certificates]);
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
    } else {

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
        
    }
    wp_die();
}

//Admin SF management - allocate SF to member
add_action('wp_ajax_allocate_sf_to_member', 'tsg_allocate_sf_to_member');

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

    if (!isset($_POST['data'])) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    } else {
        
    }
    wp_die();
}

//Admin SF management - remove SF from circulation
add_action('wp_ajax_remove_sf_from_circulation', 'tsg_remove_sf_from_circulation');

function tsg_remove_sf_from_circulation() {

    if (!isset($_POST['data'])) {
        wp_send_json_error(['message' => 'Unauthorized request']);
        wp_die();
    } else {
        
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