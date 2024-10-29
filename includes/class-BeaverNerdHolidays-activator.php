<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/includes
 * @author     Erika Gili <ing.erika.gili@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BeaverNerdHolidays_Activator {

	/**
	 * Create and fill table and options field
	 *
	 * Call every method to complete the activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() { 		
		global $wpdb;
		$table_name = $wpdb->prefix . "BeaverNerdHolidays";
		self::create_plugin_table($table_name);
		$version = self::fill_plugin_table($table_name); 
		self::create_option($version);
	}

	/**
	 * Create plugin's table
	 *
	 * @since    1.0.0
	 */
	private static function create_plugin_table( $table_name ) {
		global $wpdb;	

		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			holiday_date date DEFAULT '0000-00-00' NOT NULL,
			holiday_title varchar(100) DEFAULT '' NOT NULL,
			holiday_description varchar(255) DEFAULT '' NOT NULL,
			holiday_link varchar(100) DEFAULT '' NOT NULL,
			holiday_forever bit DEFAULT 0 NOT NULL,
			holiday_custom bit DEFAULT 0 NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 * Fill table with the data retrieved from a JSON hosted on developer's website
	 *
	 * @since          1.0.0
	 * @return   array Year version of the calendar
	 */
	public static function fill_plugin_table( $table_name ) {
		global $wpdb;

		$geson = file_get_contents( 'http://www.brilliantbeaver.com/beavernerdplugin/geek_source_' . date('Y') . '.json' );
		$file = json_decode( $geson, true );
		foreach( $file['items'] as $key => $array ) {
			$wpdb->insert( $table_name, $array );
		}
		return $file['version'];			
	}

	/**
	 * Create and fill the option
	 *
	 * @since    1.0.0
	 */
	public static function create_option( $version, $display_link = '0' ) {
		$plugin_settings = array( 'version' => $version,
			'display_link' => $display_link );
		
		update_option( 'beaver_nerd_holidays_settings', $plugin_settings, false );
	}

}
