<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://dayzsolutions.com
 * @since             1.0.0
 * @package           The_Synergy_Group_Addon
 *
 * @wordpress-plugin
 * Plugin Name:       The Synergy Group Addon
 * Plugin URI:        https://dayzsolutions.com
 * Description:       This is a dependant of many plugins which has to be responsible for the website customisations for My Account related solutions.
 * Version:           1.0.0
 * Author:            Harshana Nishshanka
 * Author URI:        https://dayzsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       the-synergy-group-addon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'THE_SYNERGY_GROUP_ADDON_VERSION', '1.0.0' );
define( 'THE_SYNERGY_GROUP_URL', plugin_dir_url( __FILE__ ) );
define( 'THE_SYNERGY_GROUP_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-the-synergy-group-addon-activator.php
 */
function activate_the_synergy_group_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-synergy-group-addon-activator.php';
	The_Synergy_Group_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-the-synergy-group-addon-deactivator.php
 */
function deactivate_the_synergy_group_addon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-the-synergy-group-addon-deactivator.php';
	The_Synergy_Group_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_the_synergy_group_addon' );
register_deactivation_hook( __FILE__, 'deactivate_the_synergy_group_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-the-synergy-group-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_the_synergy_group_addon() {

	$plugin = new The_Synergy_Group_Addon();
	$plugin->run();

}
run_the_synergy_group_addon();
