<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/includes
 * @author     Erika Gili <ing.erika.gili@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BeaverNerdHolidays_Deactivator {

	/**
	 * Delete option and plugin's table
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;

		delete_option('beaver_nerd_holidays_settings');

		$table_name = $wpdb->prefix . "BeaverNerdHolidays";

		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);
	}

}
