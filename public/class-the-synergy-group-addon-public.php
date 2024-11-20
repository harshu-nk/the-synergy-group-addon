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
class The_Synergy_Group_Addon_Public
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/the-synergy-group-addon-public.css', array(), $this->version, 'all');
		wp_enqueue_style('datepicker-css', plugin_dir_url(__FILE__) . 'datepicker/css/datepicker.min.css', array(), '1.0.0');
		wp_enqueue_style('select2-css', plugin_dir_url(__FILE__) . 'css/select2.css', array(), '1.0.0');

		if (is_account_page() && current_user_can('manage_options')) { //Only for Admins
			wp_enqueue_style('tsg-select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0');
			
			
			
		}
		if (is_account_page()) {
			wp_enqueue_style($this->plugin_name . '-my-account', plugin_dir_url(__FILE__) . 'css/myaccount.css', array(), '1.0.2', 'all');
			wp_enqueue_style($this->plugin_name . '-my-account-faq', plugin_dir_url(__FILE__) . 'css/faq.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name . '-checkboxes', plugin_dir_url(__FILE__) . 'css/checkboxes.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name . '-form', plugin_dir_url(__FILE__) . 'css/form.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name . '-my-account-select', plugin_dir_url(__FILE__) . 'css/select.css', array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name . '-my-account-quantity', plugin_dir_url(__FILE__) . 'css/quantity.css', array(), $this->version, 'all');
			wp_enqueue_style('dropzone-css', 'https://unpkg.com/dropzone@5/dist/min/dropzone.min.css', array(), $this->version, 'all');
			wp_enqueue_style('jquery-ui-css', 'https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css', array(), $this->version, 'all');
		}


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script('jquery-validation', plugin_dir_url(__FILE__) . 'js/jquery.validate.min.js', array('jquery'), '1.19.5', true);
		wp_enqueue_script('my-account-faq', plugin_dir_url(__FILE__) . 'js/faq.js', array('jquery'), '1.19.5', true);
		wp_enqueue_script($this->plugin_name . '-my-account-public', plugin_dir_url(__FILE__) . 'js/the-synergy-group-addon-public.js', array('jquery', 'dropzone-js'), $this->version, false);
		wp_localize_script($this->plugin_name . '-my-account-public', 'tsg_public_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
		wp_enqueue_script($this->plugin_name . '-my-account-form', plugin_dir_url(__FILE__) . 'js/form.js', array('jquery'), '1.19.5', true);
		wp_enqueue_script('dropzone-js', 'https://unpkg.com/dropzone@5/dist/min/dropzone.min.js', array(), $this->version, true);
		wp_enqueue_script('datepicker-js', plugin_dir_url(__FILE__) . 'datepicker/js/datepicker.min.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('datepicker-en', plugin_dir_url(__FILE__) . 'datepicker/js/i18n/datepicker.en.js', array('datepicker-js'), '1.0.0', true);
		wp_enqueue_script('calendar-js', plugin_dir_url(__FILE__) . 'js/calendar.js', array('jquery', 'datepicker-js'), '1.0.0', true);
		wp_enqueue_script('files-js', plugin_dir_url(__FILE__) . 'js/files.js', array('jquery'), '1.0.0', true);
		//wp_enqueue_script('ex-select2-js', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('quantity-js', plugin_dir_url(__FILE__) . 'js/quantity.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('stars-js', plugin_dir_url(__FILE__) . 'js/stars.js', array('jquery'), '1.0.0', true);

		//wp_localize_script('tsg-account-admin-js', 'tsg_ajax', array('ajax_url' => admin_url('admin-ajax.php')));

		wp_enqueue_script('select2-js', plugin_dir_url(__FILE__) . 'js/custom-select2.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('tsg-select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'jquery', '4.1.0-rc.0');
		wp_enqueue_script('tsg-account-admin-js', plugin_dir_url(__FILE__) . 'js/the-syndergy-admin.js', array('jquery', 'tsg-select2-js', 'select2-js'), $this->version, true);

	}
}
