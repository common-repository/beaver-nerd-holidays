<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/includes
 * @author     Erika Gili <ing.erika.gili@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BeaverNerdHolidays_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'BeaverNerdHolidays',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
