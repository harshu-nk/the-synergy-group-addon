<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://dayzsolutions.com
 * @since      1.0.0
 *
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/admin
 * @author     Harshana Nishshanka <harshu.nk62@gmail.com>
 */
class The_Synergy_Group_Addon_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/the-synergy-group-addon-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/the-synergy-group-addon-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, 'tsg_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
		//wp_enqueue_script($this->plugin_name, 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'jquery', '4.1.0-rc.0');
		//wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/the-syndergy-admin.js', array('jquery', $this->plugin_name), $this->version, true);

	}

}
