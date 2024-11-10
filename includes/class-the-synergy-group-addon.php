<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://dayzsolutions.com
 * @since      1.0.0
 *
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/includes
 * @author     Harshana Nishshanka <harshu.nk62@gmail.com>
 */
class The_Synergy_Group_Addon {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      The_Synergy_Group_Addon_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'THE_SYNERGY_GROUP_ADDON_VERSION' ) ) {
			$this->version = THE_SYNERGY_GROUP_ADDON_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'the-synergy-group-addon';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - The_Synergy_Group_Addon_Loader. Orchestrates the hooks of the plugin.
	 * - The_Synergy_Group_Addon_i18n. Defines internationalization functionality.
	 * - The_Synergy_Group_Addon_Admin. Defines all hooks for the admin area.
	 * - The_Synergy_Group_Addon_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-the-synergy-group-addon-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-the-synergy-group-addon-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-the-synergy-group-addon-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-the-synergy-group-addon-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/customizations/woo-account-customization.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/notification/notifications.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/referral/referral.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/services/services.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/transactions/transactions.php';

		// Helper
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/functions.php';

		$this->loader = new The_Synergy_Group_Addon_Loader();
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-post-types/cpts.php';
		new CPTs();

		new Referrals();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the The_Synergy_Group_Addon_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new The_Synergy_Group_Addon_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new The_Synergy_Group_Addon_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new The_Synergy_Group_Addon_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$woo_customizations = new WooAccountCustomizations;
		// Let Woo Templates override within the plugin
		$this->loader->add_filter( 'woocommerce_locate_template', $woo_customizations, 'woo_adon_plugin_template', 1, 3 );

		$this->loader->add_action('woocommerce_account_menu_items', $woo_customizations, 'my_account_tabs_customize', 30 );
		$this->loader->add_action('woocommerce_before_edit_account_form', $woo_customizations, 'bp_avatar_on_wc_edit_account', 20 );
		$this->loader->add_action('woocommerce_save_account_details', $woo_customizations, 'bp_handle_avatar_upload_in_wc_account' );
		$this->loader->add_action('init', $woo_customizations, 'tsg_add_my_account_tab_endpoints');
		$this->loader->add_action('query_vars', $woo_customizations, 'tsg_my_acc_tabs_query_vars');
		$this->loader->add_action('woocommerce_account_notifications_endpoint', $woo_customizations, 'tsg_notifications_tab_content');
		$this->loader->add_action('woocommerce_account_service-offering_endpoint', $woo_customizations, 'tsg_service_offering_tab_content');
		$this->loader->add_action('woocommerce_account_synergy-network-exchange-settings_endpoint', $woo_customizations, 'tsg_sf_settings_tab_content');
		$this->loader->add_action('woocommerce_account_customer-settings_endpoint', $woo_customizations, 'tsg_customer_settings_tab_content');
		$this->loader->add_action('woocommerce_account_customer-support_endpoint', $woo_customizations, 'tsg_customer_support_tab_content');
		$this->loader->add_action('woocommerce_account_my-affiliate_endpoint', $woo_customizations, 'tsg_customer_affiliate_tab_content');
		$this->loader->add_action('woocommerce_account_sf-management_endpoint', $woo_customizations, 'tsg_sf_management_tab_content');
		$this->loader->add_action( 'woocommerce_save_account_details', $woo_customizations, 'tsg_save_custom_fields_my_account' );

		$this->loader->add_action('woocommerce_account_synergy-network-transactions_endpoint', $woo_customizations, 'tsg_synergy_network_dashboard_transactions_tab_content');
		$this->loader->add_action('woocommerce_account_synergy-network-members_endpoint', $woo_customizations, 'tsg_synergy_network_dashboard_members_tab_content');
		$this->loader->add_action('woocommerce_account_synergy-network-admin-withdrawals_endpoint', $woo_customizations, 'tsg_synergy_network_dashboard_admin_withdrawals_tab_content');


		// Activity Log on Messages / Activities Tab
		// $this->loader->add_action('admin_head', $woo_customizations, 'tsg_simple_history_output');
		// Force History Fetching for the Frontend
		// $simpleHistory = new \Simple_History\Simple_History;
		// $this->loader->add_action('simple_history/after_init', $simpleHistory, function() use ($simpleHistory){
		// 	$simpleHistory->add_admin_actions();
		// });

		// add_action('simple_history/after_init', array(new \Simple_History\Simple_History, 'add_admin_actions'));
		$this->loader->add_action('wc_account_after_system_notifications', $woo_customizations, 'tsg_simple_history_output');

		$notifications = new Notifier;
		$this->loader->add_action('woo_account_admin_notifications_tab_content', $notifications, 'my_account_admin_notifications' );
		$this->loader->add_action('woo_account_user_activities_tab_content', $notifications, 'my_account_user_notifications' );
		$this->loader->add_action( 'wp_ajax_search_users', $notifications, 'ajax_search_users' );
		$this->loader->add_action( 'wp_ajax_nopriv_search_users', $notifications, 'ajax_search_users' );
		$this->loader->add_action( 'wp_ajax_admin_send_notification', $notifications, 'admin_send_notification' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    The_Synergy_Group_Addon_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
