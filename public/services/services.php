<?php

class Services
{

    function __construct()
    {
        add_action('init', array($this, 'services_post_type'), 0);
        add_action('woo_account_service_offering_tab_content', 'my_acc_service_tab_content');
    }

    // Register Services Post Type
    function services_post_type()
    {
        $labels = array(
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
        $args = array(
            'label'                 => __('Service', 'the-synergy-group-addon'),
            'description'           => __('Service Offering for Professionals', 'the-synergy-group-addon'),
            'labels'                => $labels,
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
        register_post_type('services', $args);
    }

    function my_acc_service_tab_content() : void {
        
    }
}
