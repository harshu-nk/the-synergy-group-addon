<?php 
class Transactions{

    function __construct()
    {
        
    }

    function admin_transaction_settings() : void {
        
    }
}

add_action('wp_ajax_fetch_user_orders', 'fetch_user_orders');
function fetch_user_orders() : void {
    $user_id = get_current_user_id();
    $selected_date = sanitize_text_field($_POST['selected_date']);

    if (!$selected_date) {
        wp_send_json_error('Invalid date');
    }

    // Query orders for the current user within the date range
    $args = [
        'customer_id' => $user_id,
        'date_query'  => [
            'year'  => date('Y', strtotime($selected_date)),
            'month' => date('m', strtotime($selected_date)),
            'day'   => date('d', strtotime($selected_date)),
        ],
        'limit'       => -1,
    ];

    $orders = wc_get_orders($args);

    if (empty($orders)) {
        wp_send_json_error('No orders found');
    }

    $order_data = [];

    foreach ($orders as $order) {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $product_author = get_the_author_meta('display_name', $product->post->post_author);
            // $rating = get_post_meta($product->get_id(), '_wc_average_rating', true);

            $chf_percentage = floatval($product->get_meta('chf_percentage')) / 100;
            if($chf_percentage !==  '' || $chf_percentage !== 0){
                $price = $product->get_price();
                $chf_cost = number_format($price * $chf_percentage, 2);
            }

            $sf_percentage = floatval($product->get_meta('sf_percentage')) / 100;
            if($sf_percentage !==  '' || $sf_percentage !== 0){
                $price = $product->get_price();
                $sf_cost = number_format($price * $sf_percentage, 2);
            }
            $seller_referee_id = get_user_meta($seller_id, 'referred_by', true);
            $ref_data = get_userdata($seller_referee_id);
            $average = $product->get_average_rating();
        
            $order_data[] = [
                'product_id' => $product->get_id(),
                'product_name'  => $product->get_name(),
                'product_author' => $product_author,
                'order_date'    => wc_format_datetime($order->get_date_created()),
                'order_cost'   => number_format($product->get_price(), 2) . ' (CHF '.$chf_cost.' + SF'.$sf_cost.')',
                'rating'        => '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>',
                'ref' => $ref_data->last_name .  " " . $ref_data->first_name,
            ];
        }
    }

    wp_send_json_success($order_data);
}

add_action('wp_ajax_fetch_user_sales', 'fetch_user_sales');
function fetch_user_sales() : void {
    global $wpdb;
    $user_id = get_current_user_id();
    $selected_date = sanitize_text_field($_POST['selected_date']);

    if (!$selected_date) {
        wp_send_json_error('Invalid date');
    }

    // Query to get order IDs with products by specific author
    $order_ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT oi.order_id
            FROM {$wpdb->prefix}woocommerce_order_items oi
            INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id
            INNER JOIN {$wpdb->prefix}posts p ON p.ID = oim.meta_value
            WHERE oim.meta_key = '_product_id' AND p.post_author = %d",
            $user_id
        )
    );

    // Get the orders based on the found order IDs
    $matching_orders = [];
    foreach ($order_ids as $order_id) {
        $matching_orders[] = wc_get_order($order_id);
    }

    $order_data = [];

    foreach ($matching_orders as $order) {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $product_author = get_the_author_meta('display_name', $product->post->post_author);
            // $rating = get_post_meta($product->get_id(), '_wc_average_rating', true);

            $chf_percentage = floatval($product->get_meta('chf_percentage')) / 100;
            if($chf_percentage !==  '' || $chf_percentage !== 0){
                $price = $product->get_price();
                $chf_cost = number_format($price * $chf_percentage, 2);
            }

            $sf_percentage = floatval($product->get_meta('sf_percentage')) / 100;
            if($sf_percentage !==  '' || $sf_percentage !== 0){
                $price = $product->get_price();
                $sf_cost = number_format($price * $sf_percentage, 2);
            }
            // $seller_referee_id = get_user_meta($seller_id, 'referred_by', true);
            // $ref_data = get_userdata($seller_referee_id);
            $average = $product->get_average_rating();
        
            $order_data[] = [
                'product_id' => $product->get_id(),
                'product_name'  => $product->get_name(),
                'product_author' => $product_author,
                'order_date'    => wc_format_datetime($order->get_date_created()),
                'order_cost'   => number_format($product->get_price(), 2) . ' (CHF '.$chf_cost.' + SF'.$sf_cost.')',
                'rating'        => '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>',
                // 'ref' => $ref_data->last_name .  " " . $ref_data->first_name,
            ];
        }
    }
    wp_send_json_success($order_data);
}

add_action('wp_ajax_fetch_mycred_history', 'fetch_mycred_history');
function fetch_mycred_history() : void {
    $user_id = get_current_user_id();
    $selected_date = sanitize_text_field($_POST['date']);
    if (!$selected_date) {
        // wp_send_json_error('Invalid date');
    }
    $date = strtotime($selected_date);
    $seller_fee_args = array('ref' => 'seller_ref_fee', 'time' => $date, 'user_id' => $user_id);
    $buyer_fee_args = array('ref' => 'buyer_ref_fee', 'time' => $date, 'user_id' => $user_id);
    $seller_fees = new myCRED_Query_Log($seller_fee_args);
    $buyer_fees = new myCRED_Query_Log($buyer_fee_args);
    $results = array_merge($seller_fees->results, $buyer_fees->results);

    $order_ids = [];
    foreach($results as $aff_data){
        $order_ids[] = $aff_data->ref_id;
    }
    $orders = wc_get_orders([
        'include' => $order_ids,
    ]);
    $order_data = [];

    foreach ($orders as $order) {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $product_author = get_the_author_meta('display_name', $product->post->post_author);
            // $rating = get_post_meta($product->get_id(), '_wc_average_rating', true);

            $chf_percentage = floatval($product->get_meta('chf_percentage')) / 100;
            if($chf_percentage !==  '' || $chf_percentage !== 0){
                $price = $product->get_price();
                $chf_cost = number_format($price * $chf_percentage, 2);
            }

            $sf_percentage = floatval($product->get_meta('sf_percentage')) / 100;
            if($sf_percentage !==  '' || $sf_percentage !== 0){
                $price = $product->get_price();
                $sf_cost = number_format($price * $sf_percentage, 2);
            }

            $member_subscriptions = WC_Subscriptions_Order::get_users_subscription_orders( $product->post->post_author );
            // $seller_referee_id = get_user_meta($seller_id, 'referred_by', true);
            $ref_data = get_userdata($seller_referee_id);
            $average = $product->get_average_rating();
        
            $order_data[] = [
                'main_cost' => 'CHF '.$chf_cost.' + SF'.$sf_cost,
                'product_id' => $product->get_id(),
                'product_name'  => $product->get_name(),
                'product_author' => $product_author,
                'order_date'    => wc_format_datetime($order->get_date_created()),
                'order_cost'   => number_format($product->get_price(), 2) . ' (CHF '.$chf_cost.' + SF'.$sf_cost.')',
                'sf_cost' => 'SF'.$sf_cost,
                'chf_cost' => 'CHF'.$chf_cost,
                'rating'        => '<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>',
                'ref' => $ref_data->last_name .  " " . $ref_data->first_name,
            ];
        }
    }
    // echo 'OK';
    wp_send_json_success($order_data);
}

function test_transcations(){
    $member_subscriptions = WC_Subscriptions_Order::get_users_subscription_orders( 16 );

    echo '<pre>';
    print_r((array) $member_subscriptions);
    echo '</pre>';
    // global $wpdb;
    // $user_id = get_current_user_id();
    // $order_ids = $wpdb->get_col(
    //     $wpdb->prepare(
    //         "SELECT DISTINCT oi.order_id
    //         FROM {$wpdb->prefix}woocommerce_order_items oi
    //         INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id
    //         INNER JOIN {$wpdb->prefix}posts p ON p.ID = oim.meta_value
    //         WHERE oim.meta_key = '_product_id' AND p.post_author = %d",
    //         $user_id
    //     )
    // );
    // echo '<pre>';
    // print_r($order_ids);
    // echo '</pre>';
}
// add_action('wp_head', 'test_transcations');