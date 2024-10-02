<?php
class WooAccountCustomizations
{

    function __construct() {}

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

    function tsg_add_my_account_notifications_endpoint()
    {
        add_rewrite_endpoint('notifications', EP_ROOT | EP_PAGES);
    }

    function tsg_notifications_query_vars($vars)
    {
        $vars[] = 'notifications';
        return $vars;
    }

    function my_account_tabs_customize($items): array
    {
        $save_for_later = array(
            'edit-account' => __('Profile', 'the-synergy-group-addon')
        );
        unset($items['edit-account']); // REMOVE TAB
        $items = array_merge(array_slice($items, 0, 1), $save_for_later, array_slice($items, 2)); // PLACE TAB AFTER POSITION 2

        // New Tabs
        if (current_user_can('manage_options')) {
            $notifications_tab_title = __('Notifications', 'the-synergy-group-addon');
        } else {
            $notifications_tab_title = __('Activity / Messages', 'the-synergy-group-addon');
        }
        $items['notifications'] = $notifications_tab_title;
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
}
