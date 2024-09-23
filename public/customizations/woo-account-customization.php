<?php
class WooAccountCustomizations{
    
    function __construct()
    {
    }

    function my_account_tabs_customize($items) : array {
        $save_for_later = array( 
            'edit-account' => __( 'Profile', 'the-synergy-group-addon' )
        );
        unset( $items['edit-account'] ); // REMOVE TAB
        $items = array_merge( array_slice( $items, 0, 1 ), $save_for_later, array_slice( $items, 2 ) ); // PLACE TAB AFTER POSITION 2
        return $items;
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