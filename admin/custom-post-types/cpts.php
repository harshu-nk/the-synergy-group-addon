<?php

class CPTs
{

    function __construct()
    {
        add_action('init', array($this, 'tsg_custom_post_types'), 0);
    }

    // Register Custom Post Types
    function tsg_custom_post_types()
    {
        $service_labels = array(
            'name'                  => _x('Services', 'Post Type General Name', 'the-synergy-group-addon'),
            'singular_name'         => _x('Service', 'Post Type Singular Name', 'the-synergy-group-addon'),
            'menu_name'             => __('Services', 'the-synergy-group-addon'),
            'name_admin_bar'        => __('Service', 'the-synergy-group-addon'),
            'archives'              => __('Service Archives', 'the-synergy-group-addon'),
            'attributes'            => __('Service Attributes', 'the-synergy-group-addon'),
            'parent_item_colon'     => __('Parent Service:', 'the-synergy-group-addon'),
            'all_items'             => __('All Services', 'the-synergy-group-addon'),
            'add_new_item'          => __('Add New Service', 'the-synergy-group-addon'),
            'add_new'               => __('Add New Service', 'the-synergy-group-addon'),
            'new_item'              => __('New Service', 'the-synergy-group-addon'),
            'edit_item'             => __('Edit Service', 'the-synergy-group-addon'),
            'update_item'           => __('Update Service', 'the-synergy-group-addon'),
            'view_item'             => __('View Service', 'the-synergy-group-addon'),
            'view_items'            => __('View Services', 'the-synergy-group-addon'),
            'search_items'          => __('Search Service', 'the-synergy-group-addon'),
            'not_found'             => __('Not found', 'the-synergy-group-addon'),
            'not_found_in_trash'    => __('Not found in Trash', 'the-synergy-group-addon'),
            'featured_image'        => __('Featured Image', 'the-synergy-group-addon'),
            'set_featured_image'    => __('Set featured image', 'the-synergy-group-addon'),
            'remove_featured_image' => __('Remove featured image', 'the-synergy-group-addon'),
            'use_featured_image'    => __('Use as featured image', 'the-synergy-group-addon'),
            'insert_into_item'      => __('Insert into service', 'the-synergy-group-addon'),
            'uploaded_to_this_item' => __('Uploaded to this service', 'the-synergy-group-addon'),
            'items_list'            => __('Services list', 'the-synergy-group-addon'),
            'items_list_navigation' => __('Items list navigation', 'the-synergy-group-addon'),
            'filter_items_list'     => __('Filter items list', 'the-synergy-group-addon'),
        );
        $service_args = array(
            'label'                 => __('Service', 'the-synergy-group-addon'),
            'description'           => __('Service Offering for Professionals', 'the-synergy-group-addon'),
            'labels'                => $service_labels,
            'supports'              => array('title', 'editor', 'revisions', 'custom-fields'),
            'taxonomies'            => array('category', 'post_tag'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-buddicons-topics',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rest_base'             => 'services',
        );
        register_post_type('services', $service_args);

        $withdrawal_labels = array(
            'name'                  => _x( 'Withdrawal Requests', 'Post Type General Name', 'the-synergy-group-addon' ),
            'singular_name'         => _x( 'Withdrawal Request', 'Post Type Singular Name', 'the-synergy-group-addon' ),
            'menu_name'             => __( 'Withdrawal Req', 'the-synergy-group-addon' ),
            'name_admin_bar'        => __( 'Withdrawal Reqs', 'the-synergy-group-addon' ),
            'archives'              => __( 'Request Archives', 'the-synergy-group-addon' ),
            'attributes'            => __( 'Request Attributes', 'the-synergy-group-addon' ),
            'parent_item_colon'     => __( 'Parent Request:', 'the-synergy-group-addon' ),
            'all_items'             => __( 'All Requests', 'the-synergy-group-addon' ),
            'add_new_item'          => __( 'Add New Request', 'the-synergy-group-addon' ),
            'add_new'               => __( 'New Request', 'the-synergy-group-addon' ),
            'new_item'              => __( 'New Request', 'the-synergy-group-addon' ),
            'edit_item'             => __( 'Edit Request', 'the-synergy-group-addon' ),
            'update_item'           => __( 'Update Request', 'the-synergy-group-addon' ),
            'view_item'             => __( 'View Request', 'the-synergy-group-addon' ),
            'view_items'            => __( 'View Request', 'the-synergy-group-addon' ),
            'search_items'          => __( 'Search Request', 'the-synergy-group-addon' ),
            'not_found'             => __( 'Not found', 'the-synergy-group-addon' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'the-synergy-group-addon' ),
            'featured_image'        => __( 'Featured Image', 'the-synergy-group-addon' ),
            'set_featured_image'    => __( 'Set featured image', 'the-synergy-group-addon' ),
            'remove_featured_image' => __( 'Remove featured image', 'the-synergy-group-addon' ),
            'use_featured_image'    => __( 'Use as featured image', 'the-synergy-group-addon' ),
            'insert_into_item'      => __( 'Insert into item', 'the-synergy-group-addon' ),
            'uploaded_to_this_item' => __( 'Uploaded to this request', 'the-synergy-group-addon' ),
            'items_list'            => __( 'Requests list', 'the-synergy-group-addon' ),
            'items_list_navigation' => __( 'Requests list navigation', 'the-synergy-group-addon' ),
            'filter_items_list'     => __( 'Filter requests list', 'the-synergy-group-addon' ),
        );
        $withdrawal_args = array(
            'label'                 => __( 'Withdrawal Request', 'the-synergy-group-addon' ),
            'description'           => __( 'SF Withdrawal Requests made from the user ends', 'the-synergy-group-addon' ),
            'labels'                => $withdrawal_labels,
            'supports'              => array( 'title' ),
            // 'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-money-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( 'withdrawal_request', $withdrawal_args );
    }
}