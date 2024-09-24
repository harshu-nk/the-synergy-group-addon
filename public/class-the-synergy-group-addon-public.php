<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://dayzsolutions.com
 * @since      1.0.0
 *
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/public
 * @author     Harshana Nishshanka <harshu.nk62@gmail.com>
 */
class The_Synergy_Group_Addon_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/the-synergy-group-addon-public.css', array(), $this->version, 'all' );
	
		if(is_account_page() && current_user_can( 'manage_options' )){ //Only for Admins
			wp_enqueue_style( 'tsg-select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0');
			wp_enqueue_script( 'tsg-select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'jquery', '4.1.0-rc.0');
			wp_enqueue_script( 'tsg-account-admin-js', plugin_dir_url( __FILE__ ) . 'js/the-syndergy-admin.js', array('jquery', 'tsg-select2-js'), '1.0', true);
			wp_localize_script( 'tsg-account-admin-js', 'tsg_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in The_Synergy_Group_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The The_Synergy_Group_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/the-synergy-group-addon-public.js', array( 'jquery' ), $this->version, false );

	}

}
