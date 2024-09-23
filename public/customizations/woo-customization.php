<?php
class WooCustomizations{
    
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

}