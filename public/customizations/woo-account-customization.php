<?php
class WooAccountCustomizations{
    
    function __construct(){
    }

    function tsg_add_my_account_notifications_endpoint() {
        add_rewrite_endpoint( 'notifications', EP_ROOT | EP_PAGES );
    }

    function tsg_notifications_query_vars( $vars ) {
        $vars[] = 'notifications';
        return $vars;
    }
      
    function my_account_tabs_customize($items) : array {
        $save_for_later = array( 
            'edit-account' => __( 'Profile', 'the-synergy-group-addon' )
        );
        unset( $items['edit-account'] ); // REMOVE TAB
        $items = array_merge( array_slice( $items, 0, 1 ), $save_for_later, array_slice( $items, 2 ) ); // PLACE TAB AFTER POSITION 2

        // New Tabs
        if ( current_user_can( 'manage_options' ) ) {
            $notifications_tab_title = __('Notifications', 'the-synergy-group-addon');
        }else{
            $notifications_tab_title = __('Activity / Messages', 'the-synergy-group-addon');
        }
        $items['notifications'] = $notifications_tab_title;
        return $items;
    }

    function tsg_notifications_tab_content() {
        if ( current_user_can( 'manage_options' ) ) {
            do_action('woo_account_admin_notifications_tab_content'); // For Admin
        }else{
            do_action('woo_account_user_activities_tab_content'); // For User
        }
    }

    /**
     * Add BuddyPress profile image upload/edit field to WooCommerce Edit Account page.
     */
    function bp_avatar_on_wc_edit_account() : void {
        bp_get_template_part( 'members/single/profile/change-avatar' );
    }

    /**
     * Handle BuddyPress avatar upload on WooCommerce Edit Account form submission.
     */
    function bp_handle_avatar_upload_in_wc_account( $user_id ) : void {
        if ( isset( $_POST['bp-avatar-delete'] ) && 1 == $_POST['bp-avatar-delete'] ) {
            bp_core_delete_existing_avatar( array( 'item_id' => $user_id ) );
        }

        if ( ! empty( $_FILES['bp-avatar-upload']['name'] ) ) {
            if ( bp_core_avatar_handle_upload( array( 'item_id' => $user_id, 'object' => 'user' ) ) ) {
                bp_core_fetch_avatar( array( 'item_id' => $user_id, 'type' => 'full', 'html' => true ) );
            }
        }
    }
}