<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.brilliantbeaver.com
 * @since             1.0.0
 * @package           BeaverNerdHolidays
 *
 * @wordpress-plugin
 * Plugin Name:       BeaverNerdHolidays
 * Plugin URI:        http://www.brilliantbeaver.com/2016/05/14/beavernerdholidays/
 * Description:       Plugin to display a Nerd Calendar on a widget
 * Version:           1.0.0
 * Author:            Erika Gili
 * Author URI:        http://www.brilliantbeaver.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       BeaverNerdHolidays
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-BeaverNerdHolidays-activator.php
 */
function activate_plugin_name() {
	if ( current_user_can( 'activate_plugins' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-BeaverNerdHolidays-activator.php';
		BeaverNerdHolidays_Activator::activate();
	}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-BeaverNerdHolidays-deactivator.php
 */
function deactivate_plugin_name() {
	if ( current_user_can( 'activate_plugins' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-BeaverNerdHolidays-deactivator.php';
		BeaverNerdHolidays_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-BeaverNerdHolidays.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new BeaverNerdHolidays();
	$plugin->run();

}
run_plugin_name();
