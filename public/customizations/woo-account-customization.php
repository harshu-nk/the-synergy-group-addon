<?php
// namespace TSG\Customizations;

use Simple_History\Log_Initiators;

class WooAccountCustomizations
{

    function __construct()
    {
        add_action('template_redirect', array($this, 'save_custom_forms'));
        // add_action('wp_ajax_nopriv_get_taxonomy_terms', array($this, 'get_taxonomy_terms'));
        add_action('wp_ajax_get_service_details', array($this, 'get_service_details'));
        // add_action('wp_ajax_nopriv_get_service_details', array($this, 'get_service_details')); // If needed for non-logged-in users

    }

    function woo_adon_plugin_template($template, $template_name, $template_path)
    {
        global $woocommerce;
        $_template = $template;
        if (! $template_path)
            $template_path = $woocommerce->template_url;

        $plugin_path  = untrailingslashit(THE_SYNERGY_GROUP_PATH)  . '/template/woocommerce/';
        // Look within passed path within the theme - this is priority
        $template = locate_template(
            array(
                $template_path . $template_name,
                $template_name
            )
        );

        if (! $template && file_exists($plugin_path . $template_name))
            $template = $plugin_path . $template_name;

        if (! $template)
            $template = $_template;

        return $template;
    }

    function tsg_add_my_account_tab_endpoints()
    {
        add_rewrite_endpoint('notifications', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('service-offering', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('synergy-network-exchange-settings', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('customer-support', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('my-affiliate', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('customer-settings', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('sf-management', EP_ROOT | EP_PAGES);
    }

    function tsg_my_acc_tabs_query_vars($vars)
    {
        $vars[] = 'notifications';
        $vars[] = 'service-offering';
        $vars[] = 'synergy-network-exchange-settings';
        $vars[] = 'customer-settings';
        $vars[] = 'customer-support';
        $vars[] = 'my-affiliate';
        $vars[] = 'sf-management';
        return $vars;
    }

    function my_account_tabs_customize($items): array
    {
        $save_for_later = array(
            'edit-account' => __('Profile', 'the-synergy-group-addon')
        );
        unset($items['edit-account']); // REMOVE TAB
        unset($items['downloads']); // REMOVE TAB
        unset($items['edit-address']); // REMOVE TAB
        unset($items['payment-methods']); // REMOVE TAB
        unset($items['bp-messages']); // REMOVE TAB
        unset($items['points']); // REMOVE TAB
        $items = array_merge(array_slice($items, 0, 1), $save_for_later, array_slice($items, 2)); // PLACE TAB AFTER POSITION 2

        // New Tabs
        if (current_user_can('manage_options')) {
            $notifications_tab_title = __('Notifications', 'the-synergy-group-addon');
            $sf_overview_tab_title = __('SF Exchange Settings', 'the-synergy-group-addon');
            $items['sf-management'] = __('SF Management', 'the-synergy-group-addon');
        } else {
            $notifications_tab_title = __('Activity / Messages', 'the-synergy-group-addon');
            $sf_overview_tab_title = __('Synergy Francs', 'the-synergy-group-addon');
        }
        $items['notifications'] = $notifications_tab_title;
        $items['customer-settings'] = __('Settings', 'the-synergy-group-addon');
        $items['customer-support'] = __('Support', 'the-synergy-group-addon');
        $items['my-affiliate'] = __('Affiliate', 'the-synergy-group-addon');
        $items['service-offering'] = __('Service Offering', 'the-synergy-group-addon');
        $items['synergy-network-exchange-settings'] = $sf_overview_tab_title;
        $items['subscriptions'] = __('Transactions', 'the-synergy-group-addon');

        $customOrder = [
            'dashboard',
            'sf-management',
            'edit-account',
            'notifications',
            'customer-settings',
            'subscriptions',
            'service-offering',
            'synergy-network-exchange-settings',
            'customer-support',
            'my-affiliate',
            'customer-logout',
        ];

        uksort($items, function ($a, $b) use ($customOrder) {
            return array_search($a, $customOrder) - array_search($b, $customOrder);
        });

        // echo '<pre>';
        // print_r($items);
        // echo '</pre>';

        return $items;
    }

    function tsg_notifications_tab_content()
    {
        if (current_user_can('manage_options')) {
            do_action('woo_account_admin_notifications_tab_content'); // For Admin
        } else {
            do_action('woo_account_user_activities_tab_content'); // For User
        }
    }

    function tsg_customer_settings_tab_content(): void
    {
        $user_id = get_current_user_id();
        $settings = array(
            '2fa' => get_user_meta($user_id, '2fa', true),
            'profile_visibility' => get_user_meta($user_id, 'profile_visibility', true),
            'payment_method' => get_user_meta($user_id, 'payment_method', true),
            'default_currency' => get_user_meta($user_id, 'default_currency', true),
            'notification_preferences' => get_user_meta($user_id, 'notification_preferences', true),
            'affiliate_earnings' => get_user_meta($user_id, 'affiliate_earnings', true),
            'data_export' => get_user_meta($user_id, 'data_export', true),
        );
        wc_get_template('myaccount/customer/customer-settings.php', array('settings' => $settings));
    }

    function tsg_customer_support_tab_content(): void
    {
        wc_get_template('myaccount/customer/customer-support.php', array());
    }

    function tsg_customer_affiliate_tab_content(): void
    {
        wc_get_template('myaccount/customer/customer-affiliate.php', array());
    }

    function tsg_service_offering_tab_content(): void
    {
        $current_user_id = get_current_user_id();
        $business = get_user_meta($current_user_id, 'business_data', true);
        $available_products = array();
        $args = array(
            'author' => $current_user_id,
            'post_type' => 'product',
        );
        $author_posts = new WP_Query($args);
        if ($author_posts->have_posts()) {
            while ($author_posts->have_posts()) {
                $author_posts->the_post();
                $available_products[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title()
                );
            }
            wp_reset_postdata();
        }
        wc_get_template('myaccount/customer/service-offering.php', array('business' => $business, 'products' => $available_products));
    }

    function tsg_sf_settings_tab_content(): void
    {
        if (current_user_can('manage_options')) {
            wc_get_template('myaccount/admin/admin-exchange-settings.php', array());
        } else {
            $customer_history_args = array('user_id' => get_current_user_id());
            $history_data = new myCRED_Query_Log($customer_history_args);
            wc_get_template('myaccount/customer/customer-sf-overview.php', array('history' => $history_data->results));
        }
    }

    function tsg_sf_management_tab_content() : void {

        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                 array(
                     'taxonomy' => 'product_type',
                     'field'    => 'slug',
                     'terms'    => array('subscription', 'variable-subscription'), 
                 ),
             ),
          );
        $loop = new WP_Query( $args );
        $subscriptions = [];
        if ( $loop->have_posts() ) {
            while ( $loop->have_posts() ) : $loop->the_post();
                $subscriptions[] = array('id' => get_the_ID(), 'title' => get_the_title());
            endwhile;
        }
        
        wp_reset_postdata();

        $options = array(
            'sf_bonus_allocation' => get_option('sf_bonus_allocation', 0)
        );
        wc_get_template('myaccount/admin/admin-sf-management.php', array('plans' => $subscriptions, 'options' => $options)); 
    }

    /**
     * Add BuddyPress profile image upload/edit field to WooCommerce Edit Account page.
     */
    function bp_avatar_on_wc_edit_account(): void
    {

        // bp_get_template_part('members/single/profile/change-avatar');
    }

    function tsg_save_custom_fields_my_account($user_id)
    {
        $account_bio = ! empty($_POST['account_bio']) ? wc_clean(wp_unslash($_POST['account_bio'])) : '';
        if ($account_bio) {
            update_user_meta($user_id, 'description', $account_bio);
        }

        $mobile = ! empty($_POST['mobile']) ? wc_clean(wp_unslash($_POST['mobile'])) : '';
        if ($mobile) {
            $bpFieldUpdated = xprofile_set_field_data('mobile', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'mobile', $mobile);
            }
        }

        $whatsapp = ! empty($_POST['whatsapp']) ? wc_clean(wp_unslash($_POST['whatsapp'])) : '';
        if ($whatsapp) {
            $bpFieldUpdated = xprofile_set_field_data('whatsapp', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'whatsapp', $whatsapp);
            }
        }

        $other_tel = ! empty($_POST['other_tel']) ? wc_clean(wp_unslash($_POST['other_tel'])) : '';
        if ($other_tel) {
            $bpFieldUpdated = xprofile_set_field_data('other_tel', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'other_tel', $other_tel);
            }
        }

        $linkedin = ! empty($_POST['linkedin']) ? wc_clean(wp_unslash($_POST['linkedin'])) : '';
        if ($linkedin) {
            $bpFieldUpdated = xprofile_set_field_data('linkedin', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'linkedin', $linkedin);
            }
        }

        $twitter = ! empty($_POST['twitter']) ? wc_clean(wp_unslash($_POST['twitter'])) : '';
        if ($twitter) {
            $bpFieldUpdated = xprofile_set_field_data('twitter', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'twitter', $twitter);
            }
        }

        $facebook = ! empty($_POST['facebook']) ? wc_clean(wp_unslash($_POST['facebook'])) : '';
        if ($facebook) {
            $bpFieldUpdated = xprofile_set_field_data('facebook', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'facebook', $facebook);
            }
        }

        $instagram = ! empty($_POST['instagram']) ? wc_clean(wp_unslash($_POST['instagram'])) : '';
        if ($instagram) {
            $bpFieldUpdated = xprofile_set_field_data('twitter', $user_id, $mobile);
            if (!$bpFieldUpdated) {
                update_user_meta($user_id, 'twitter', $instagram);
            }
        }
    }

    /**
     * Handle BuddyPress avatar upload on WooCommerce Edit Account form submission.
     */
    function bp_handle_avatar_upload_in_wc_account($user_id): void
    {
        if (isset($_POST['bp-avatar-delete']) && 1 == $_POST['bp-avatar-delete']) {
            bp_core_delete_existing_avatar(array('item_id' => $user_id));
        }

        if (! empty($_FILES['bp-avatar-upload']['name'])) {
            if (bp_core_avatar_handle_upload(array('item_id' => $user_id, 'object' => 'user'))) {
                bp_core_fetch_avatar(array('item_id' => $user_id, 'type' => 'full', 'html' => true));
            }
        }
    }

    function tsg_simple_history_output()
    {

        global $wpdb;
        $current_user_id = get_current_user_id(); // Get the current user's ID

        // Write the SQL query to fetch history events for the current user and where the logger is "SimpleUserLogger"
        $query = "SELECT h.*, c1.value as user_email, c2.value as server_remote_addr, c3.value as user_login
        FROM {$wpdb->prefix}simple_history h
        JOIN {$wpdb->prefix}simple_history_contexts c1 ON h.id = c1.history_id AND c1.key = '_user_email'
        JOIN {$wpdb->prefix}simple_history_contexts c2 ON h.id = c2.history_id AND c2.key = '_server_remote_addr'
        JOIN {$wpdb->prefix}simple_history_contexts c3 ON h.id = c3.history_id AND c3.key = '_user_login'
        WHERE h.id IN (
            SELECT history_id
            FROM {$wpdb->prefix}simple_history_contexts
            WHERE `key` = '_user_id'
            AND `value` = %d
        )
        AND h.logger = 'SimpleUserLogger' AND h.message = 'Logged in' ORDER BY h.id DESC
        LIMIT 10";

        // Prepare and execute the query, passing the current user ID
        $prepared_query = $wpdb->prepare($query, $current_user_id);
        $history_data = $wpdb->get_results($prepared_query);
?>

        <div class="account-text-block">
            <div class="account-title-block borderb va">
                <img width="57" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/activity_log.svg" class="mr2" alt="activity log icon" />
                <h5><?php _e('Activity Log', 'the-synergy-group-addon') ?></h5>
            </div>
            <h6 class="mt25">Recent Logins</h6>

            <div class="block-lines small-lines media-full">
                <?php foreach ($history_data as $loginData) { ?>
                    <div class="block-line spb">
                        <div class="line-left va">
                            <div class="line-icon2">
                                <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/arrow_right.svg" alt="arrow right icon" />
                            </div>
                            <p><?php echo date('Y/m/d H:i', strtotime($loginData->date)); ?>. IP <?php echo $loginData->server_remote_addr; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <h6 class="mt25">Service Interactions</h6>
            <div class="block-lines small-lines media-full">
                <div class="block-line spb">
                    <div class="line-left va">
                        <div class="line-icon2">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/arrow_right.svg" alt="arrow right icon" />
                        </div>
                        <p>2024/07/07 - 17:45. Update 0.2.0231.01</p>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left va">
                        <div class="line-icon2">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/arrow_right.svg" alt="arrow right icon" />
                        </div>
                        <p>2024/07/07 - 19:42. Update 0.2.0231.02</p>
                    </div>
                </div>
            </div>

            <h6 class="mt25">Exchange Transactions</h6>
            <div class="block-lines small-lines media-full">
                <div class="block-line spb">
                    <div class="line-left va">
                        <div class="line-icon2">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/arrow_right.svg" alt="arrow right icon" />
                        </div>
                        <p>Transaction 46841521684651</p>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left va">
                        <div class="line-icon2">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/arrow_right.svg" alt="arrow right icon" />
                        </div>
                        <p>Transaction 46841521684652</p>
                    </div>
                </div>

                <div class="block-line spb">
                    <div class="line-left va">
                        <div class="line-icon2">
                            <img src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/arrow_right.svg" alt="arrow right icon" />
                        </div>
                        <p>Transaction 46841521684653</p>
                    </div>
                </div>
            </div>
        </div>
<?php }

    function save_custom_forms(): void
    {
        // Admin SF Exchaneg Settings
        if (current_user_can('manage_options') && isset($_POST['form-type']) && $_POST['form-type'] == 'admin-exchange-settings') {
            // $core_settings = mycred_get_option( 'mycred_pref_core' );

            $buying_sf_rate = $_POST['buying-sf'];
            $mycred_pref_buycreds = mycred_get_option('mycred_pref_buycreds');

            if (isset($mycred_pref_buycreds['gateway_prefs']) && isset($buying_sf_rate)) {
                $old_rate = 0;
                $buying_sf_rate = absint($buying_sf_rate);
                foreach ($mycred_pref_buycreds['gateway_prefs'] as $key => $gateway) {
                    $old_rate = $mycred_pref_buycreds['gateway_prefs'][$key]['exchange']['synergy_francs'];
                    $mycred_pref_buycreds['gateway_prefs'][$key]['exchange']['synergy_francs'] = $buying_sf_rate;
                }

                $updated = mycred_update_option('mycred_pref_buycreds', $mycred_pref_buycreds);

                if ($updated) {
                    $message = 'SF Exchange buying rates - Updated from 1CHF = ' . $old_rate . 'SF to 1CHF = ' . $buying_sf_rate . 'SF.';
                    SimpleLogger()->info(
                        $message,
                        array(
                            '_initiator' => Log_Initiators::WP_USER,
                            '_user_id' => get_current_user_id(),
                            'log_type' => 'buying_sf'
                        )
                    );

                    // $mycred = mycred();
                    // $mycred->add_to_log(
                    //     'buying_sf',
                    //     get_current_user_id(),
                    //     0,
                    //     'Log entry',
                    //     date('YmdHis'),
                    //     $message,
                    //     'cred_config'
                    // );
                }
            }

            $selling_sf_rate = $_POST['selling-sf'];
            $mycred_pref_cashcreds = mycred_get_option('mycred_pref_cashcreds');
            if (isset($mycred_pref_cashcreds['gateway_prefs']) && isset($selling_sf_rate)) {
                $old_sell_rate = 0;
                $selling_sf_rate = absint($selling_sf_rate);
                foreach ($mycred_pref_cashcreds['gateway_prefs'] as $key => $gateway) {
                    $old_sell_rate = $mycred_pref_cashcreds['gateway_prefs'][$key]['exchange']['synergy_francs'];
                    $mycred_pref_cashcreds['gateway_prefs'][$key]['exchange']['synergy_francs'] = $selling_sf_rate;
                }

                $updated = mycred_update_option('mycred_pref_cashcreds', $mycred_pref_cashcreds);

                if ($updated) {
                    $message = 'SF Exchange cash (sell) rates - Updated from 1CHF = ' . $old_sell_rate . 'SF to 1CHF = ' . $selling_sf_rate . 'SF.';
                    SimpleLogger()->info(
                        $message,
                        array(
                            '_initiator' => Log_Initiators::WP_USER,
                            '_user_id' => get_current_user_id(),
                            'log_type' => 'selling_sf'
                        )
                    );
                }
            }
        }

        if (current_user_can('manage_options') && isset($_POST['form-type']) && $_POST['form-type'] == 'admin-exchange-thresholds') {
            $min_sf_limit = $_POST['min-sf-limits'];
            $max_sf_limit = $_POST['max-sf-limits'];
            $notification_threshold = $_POST['notification-threshold'];
            $alerts = $_POST['alerts'];

            $configs = array(
                'transaction_min_sf_limit' => $min_sf_limit,
                'transaction_max_sf_limit' => $max_sf_limit,
                'send_notifications_at_sf' => $notification_threshold,
                'send_alert_at_sf' => $alerts
            );
            update_option('tsg_addon_configs', $configs);
        }

        if (isset($_POST['form-type']) && $_POST['form-type'] == 'withdraw-request') {
            $current_user_id = get_current_user_id();
            $req = array(
                'post_type' => 'withdrawal_request',
                'post_title'    => 'Withdrawal Request of SF ' . wp_strip_all_tags($_POST['withdraw_amount']),
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_author'   => $current_user_id,
                'meta_input'   => array(
                    'requested_by' => $current_user_id,
                    'amount' =>  wp_strip_all_tags($_POST['withdraw_amount']),
                    'status' => 'pending'
                ),
            );
            wp_insert_post($req);
        }

        if (isset($_POST['form-type']) && $_POST['form-type'] == 'selling-request') {
            $current_user_id = get_current_user_id();
            $req = array(
                'post_type' => 'sell_request',
                'post_title'    => 'Selling Request of SF ' . wp_strip_all_tags($_POST['selling_amount']),
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_author'   => $current_user_id,
                'meta_input'   => array(
                    'requested_by' => $current_user_id,
                    'amount' =>  wp_strip_all_tags($_POST['selling_amount']),
                    'status' => 'pending'
                ),
            );
            wp_insert_post($req);
        }

        if (isset($_POST['form-type']) && $_POST['form-type'] == 'business-profile') {
            $current_user_id = get_current_user_id();
            $business_name = sanitize_text_field($_POST['business-name']);
            $industry = sanitize_text_field($_POST['industry']);
            $experience_years = sanitize_text_field($_POST['years-experience']);
            $company_description = sanitize_text_field($_POST['company-description']);
            $business_website = sanitize_text_field($_POST['website']);

            // Handle company logo upload
            if (!empty($_FILES['company_logo']['name'])) {
                $uploadedfile = $_FILES['company_logo'];
                $upload_overrides = array('test_form' => false);
                $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

                if ($movefile && !isset($movefile['error'])) {
                    $company_logo_url = $movefile['url'];
                } else {
                    echo $movefile['error'];
                }
            }

            // Store data in user meta
            $current_business_meta = get_user_meta($current_user_id, 'business_data', true);
            if (empty($current_business_meta)) {
                $current_business_meta = [];
            }
            if (isset($_POST['business-name'])) {
                $current_business_meta['business_name'] = $business_name;
            }
            if (isset($_POST['industry'])) {
                $current_business_meta['industry'] = $industry;
            }
            if (isset($_POST['years-experience'])) {
                $current_business_meta['exp_years'] = $experience_years;
            }
            if (!empty($_FILES['company_logo']['name']) && !empty($company_logo_url)) {
                $current_business_meta['company_logo'] = $company_logo_url;
            }
            if (isset($_POST['company-description'])) {
                $current_business_meta['company_description'] = $company_description;
            }
            if (isset($_POST['website'])) {
                $current_business_meta['business_website'] = $business_website;
            }

            update_user_meta($current_user_id, 'business_data', $current_business_meta);
        }

        if (isset($_POST['form-type']) && $_POST['form-type'] == 'customer-settings') {
            $current_user_id = get_current_user_id();

            $password = sanitize_text_field($_POST['password']);
            if($password !== ''){
                wp_set_password( $password, $current_user_id );
            }

            $twofa = sanitize_text_field($_POST['two-factor']);
            if($twofa !== ''){
                update_user_meta($current_user_id, '2fa', sanitize_title($twofa));
            }

            $profile_visibility = sanitize_text_field($_POST['profile-visibility']);
            if($profile_visibility !== ''){
                update_user_meta($current_user_id, 'profile_visibility', sanitize_title($profile_visibility));
            }

            $payment_method = sanitize_text_field($_POST['payment-methods']);
            if($payment_method !== ''){
                update_user_meta($current_user_id, 'payment_method', sanitize_title($payment_method));
            }

            $default_currency = sanitize_text_field($_POST['default-currency']);
            if($default_currency !== ''){
                update_user_meta($current_user_id, 'default_currency', sanitize_title($default_currency));
            }

            $notification_pref = sanitize_text_field($_POST['preferences']);
            if($notification_pref !== ''){
                update_user_meta($current_user_id, 'notification_preferences', sanitize_title($notification_pref));
            }

            $aff_earnings = sanitize_text_field($_POST['affiliate-earnings']);
            if($aff_earnings !== ''){
                update_user_meta($current_user_id, 'affiliate_earnings', sanitize_title($aff_earnings));
            }

            $data_export = sanitize_text_field($_POST['data-export']);
            if($data_export !== ''){
                update_user_meta($current_user_id, 'data_export', sanitize_title($data_export));
            }
        }
    }

    // function get_service_details() {
    //     // Check if the service ID is set and valid
    //     if (isset($_POST['service_id'])) {
    //         $service_id = intval($_POST['service_id']);
    
    //         // Get the service post
    //         $service = get_post($service_id);
    //         if (!$service) {
    //             wp_send_json_error('Service not found');
    //         }
    
    //         // Get custom meta data for the service
    //         // $service_meta = get_post_meta($service_id);
    
    //         // Construct the response data
    //         $response_data = array(
    //             'name' => $service->post_title,
    //             'long_description' => $service->post_content,
    //             'short_description' => get_post_meta($service_id, 'short_description', true),
    //             'pricing_units' => get_post_meta($service_id, 'pricing_units', true),
    //             'sf_percentage' => get_post_meta($service_id, 'sf_percentage', true),
    //             'chf_percentage' => get_post_meta($service_id, 'chf_percentage', true),
    //             'service_image' => wp_get_attachment_url(get_post_meta($service_id, 'service_image', true)),
    //             'service_gallery' => get_post_meta($service_id, 'service_gallery', true), // Array of gallery images
    //         );
    
    //         wp_send_json_success($response_data);
    //     }
    
    //     wp_send_json_error('Invalid service ID');
    // }    

    function get_history_by_context($key, $value)
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
                    AND c.value = %s",
                $key,
                $value
            ),
            ARRAY_A
        );

        return $results;
    }
}
