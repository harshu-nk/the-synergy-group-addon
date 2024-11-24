<?php

add_action('wp_ajax_get_user_products', 'get_user_products');
function get_user_products()
{
    $user_id = get_current_user_id();
    $products = wc_get_products(array(
        'author' => $user_id,
        'limit' => -1
    ));

    $product_list = array();
    foreach ($products as $product) {
        $product_list[] = array(
            'id' => $product->get_id(),
            'title' => $product->get_name()
        );
    }

    wp_send_json_success($product_list);
}

add_action('wp_ajax_get_product_details', 'get_product_details');
function get_product_details()
{
    $product_id = intval($_POST['product_id']);
    $product = wc_get_product($product_id);

    if ($product) {
        $product_data = array(
            'id' => $product->get_id(),
            'name' => $product->get_name(),
            'long_description' => $product->get_description(),
            'short_description' => $product->get_short_description(),
            'chf_price' => $product->get_price(),
            // Add any custom fields you need
        );

        wp_send_json_success($product_data);
    } else {
        wp_send_json_error('Product not found.');
    }
}

add_action('wp_ajax_save_product', 'save_product');
function save_product()
{
    $product_id = intval($_POST['product-id']);
    $product_name = sanitize_text_field($_POST['service-name']);
    $product_desc = sanitize_textarea_field($_POST['long-description']);
    $product_short_desc = sanitize_textarea_field($_POST['short-description']);
    $product_price = floatval(sanitize_text_field($_POST['product-price']));

    if ($product_id) {
        // Update existing product
        $product = wc_get_product($product_id);
    } else {
        // Create new product
        $product = new WC_Product_Simple();
    }

    $product->set_name($product_name);
    $product->set_description($product_desc);
    $product->set_short_description($product_short_desc);
    $product->set_regular_price($product_price);

    $product->update_meta_data('sf_percentage', sanitize_text_field($_POST['pricing-sf']));
    $product->update_meta_data('chf_percentage', sanitize_text_field($_POST['pricing-chf']));
    $product->update_meta_data('perf_analytics', sanitize_text_field($_POST['performance-analytics']));

    if (isset($_POST['selected-category'])) {
        $product->set_category_ids(isset($_POST['selected-category']) ? (array) $_POST['selected-category'] : array());
    }

    // Handle Featured Image Upload
    if (!empty($_FILES['service-image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $featured_image_id = media_handle_upload('service-image', 0);
        if (!is_wp_error($featured_image_id)) {
            set_post_thumbnail($product->get_id(), $featured_image_id); // Set the featured image
        }
    }

    // Handle Gallery Images Upload
    if (!empty($_FILES['service-gallery']['name'][0])) { // Check if at least one file is uploaded
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $gallery_image_ids = [];
        foreach ($_FILES['service-gallery']['name'] as $key => $value) {
            if (!empty($_FILES['service-gallery']['name'][$key])) {
                $file = [
                    'name'     => $_FILES['service-gallery']['name'][$key],
                    'type'     => $_FILES['service-gallery']['type'][$key],
                    'tmp_name' => $_FILES['service-gallery']['tmp_name'][$key],
                    'error'    => $_FILES['service-gallery']['error'][$key],
                    'size'     => $_FILES['service-gallery']['size'][$key],
                ];

                $gallery_image_id = media_handle_sideload($file, $product->get_id());
                if (!is_wp_error($gallery_image_id)) {
                    $gallery_image_ids[] = $gallery_image_id;
                }
            }
        }

        if (!empty($gallery_image_ids)) {
            $product->set_gallery_image_ids($gallery_image_ids);
        }
    }
   
    $product->save();

    wp_send_json_success('Product saved successfully!');
}

add_action('wp_ajax_delete_product', 'delete_product');
function delete_product()
{
    $product_id = intval($_POST['product_id']);
    if (wp_delete_post($product_id, true)) {
        wp_send_json_success('Product deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete product.');
    }
}

add_action('wp_ajax_upload_gallery_images', 'upload_gallery_images');
function upload_gallery_images()
{
    if (!empty($_FILES)) {
        $file = $_FILES['file'];
        $upload = wp_handle_upload($file, array('test_form' => false));

        if (isset($upload['url'])) {
            // Handle successful upload (store image URL, attach to product, etc.)
            wp_send_json_success($upload['url']);
        } else {
            wp_send_json_error('Upload failed.');
        }
    }
}

add_action('wp_ajax_get_taxonomy_terms', 'get_taxonomy_terms');

function get_taxonomy_terms()
{
    $taxonomy = isset($_GET['taxonomy']) ? sanitize_text_field($_GET['taxonomy']) : '';
    $search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'search' => $search
    ));

    $results = array();
    foreach ($terms as $term) {
        $results[] = array(
            'id' => $term->term_id,
            'slug' => $term->slug,
            'text' => $term->name
        );
    }

    wp_send_json($results);
}

function tsg_services_woocommerce_product_custom_fields()
{
    woocommerce_wp_text_input(array(
        'id' => 'sf_percentage',
        'label' => __('SF Percentage', ''),
    ));

    woocommerce_wp_text_input(array(
        'id' => 'chf_percentage',
        'label' => __('CHF Percentage', ''),
    ));
}
add_action('woocommerce_product_options_general_product_data', 'tsg_services_woocommerce_product_custom_fields');
add_action('woocommerce_process_product_meta', 'tsg_services_woocommerce_product_custom_fields_save');
function tsg_services_woocommerce_product_custom_fields_save($post_id)
{
    // Custom Product Text Field
    $woocommerce_sf_perc = $_POST['sf_percentage'];
    if (!empty($woocommerce_sf_perc))
        update_post_meta($post_id, 'sf_percentage', esc_attr($woocommerce_sf_perc));
    // Custom Product Number Field
    $woocommerce_chf_perc = $_POST['chf_percentage'];
    if (!empty($woocommerce_chf_perc))
        update_post_meta($post_id, 'chf_percentage', esc_attr($woocommerce_chf_perc));
    // Custom Product Textarea Field
    $woocommerce_custom_procut_textarea = $_POST['_custom_product_textarea'];
    if (!empty($woocommerce_custom_procut_textarea))
        update_post_meta($post_id, '_custom_product_textarea', esc_html($woocommerce_custom_procut_textarea));
}

/**
 * @snippet       Alter Product Pricing Part 1 - WooCommerce Product
 * @compatible    WooCommerce 8
 */

add_filter('woocommerce_get_price_html', 'tsg_services_alter_price_display', 9999, 2);
function tsg_services_alter_price_display($price, $product)
{

    // ONLY ON FRONTEND
    if (is_admin()) return $price;

    // ONLY IF PRICE NOT NULL
    if ('' === $product->get_price() || $product->get_meta('chf_percentage') || $product->get_meta('sf_percentage')) return $price;

    // IF CUSTOMER LOGGED IN, APPLY 20% DISCOUNT   
    // if (wc_current_user_has_role('customer')) {
        $alter_percentage = floatval($product->get_meta('chf_percentage')) / 100;

        if ($product->is_type('simple') || $product->is_type('variation')) {
            if ($product->is_on_sale()) {
                $price = wc_format_sale_price(wc_get_price_to_display($product, array('price' => $product->get_regular_price())) * $alter_percentage, wc_get_price_to_display($product) * $alter_percentage) . $product->get_price_suffix();
            } else {
                $price = wc_price(wc_get_price_to_display($product) * $alter_percentage) . 'SF 100' . $product->get_price_suffix();
            }
        } elseif ($product->is_type('variable')) {
            $prices = $product->get_variation_prices(true);
            if (empty($prices['price'])) {
                $price = apply_filters('woocommerce_variable_empty_price_html', '', $product);
            } else {
                $min_price = current($prices['price']);
                $max_price = end($prices['price']);
                $min_reg_price = current($prices['regular_price']);
                $max_reg_price = end($prices['regular_price']);
                if ($min_price !== $max_price) {
                    $price = wc_format_price_range($min_price * $alter_percentage, $max_price * $alter_percentage);
                } elseif ($product->is_on_sale() && $min_reg_price === $max_reg_price) {
                    $price = wc_format_sale_price(wc_price($max_reg_price * $alter_percentage), wc_price($min_price * $alter_percentage));
                } else {
                    $price = wc_price($min_price * $alter_percentage);
                }
                $price = apply_filters('woocommerce_variable_price_html', $price . $product->get_price_suffix(), $product);
            }
        }
    // }

    return $price;
}

/**
 * @snippet       Alter Product Pricing Part 2 - WooCommerce Cart/Checkout
 * @compatible    WooCommerce 8
 */

add_action('woocommerce_before_calculate_totals', 'tsg_services_alter_price_cart', 9999);

function tsg_services_alter_price_cart($cart)
{

    if (is_admin() && ! defined('DOING_AJAX')) return;

    if (did_action('woocommerce_before_calculate_totals') >= 2) return;

    // IF CUSTOMER NOT LOGGED IN, DONT APPLY DISCOUNT
    // if (! wc_current_user_has_role('customer')) return;

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $alter_percentage = floatval($product->get_meta('chf_percentage')) / 100;

        if($alter_percentage !==  '' || $alter_percentage !== 0){
            $price = $product->get_price();
            $cart_item['data']->set_price($price * $alter_percentage);
        }
    }
}
