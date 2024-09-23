<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://dayzsolutions.com
 * @since      1.0.0
 *
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    The_Synergy_Group_Addon
 * @subpackage The_Synergy_Group_Addon/includes
 * @author     Harshana Nishshanka <harshu.nk62@gmail.com>
 */
class The_Synergy_Group_Addon_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'the-synergy-group-addon',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
