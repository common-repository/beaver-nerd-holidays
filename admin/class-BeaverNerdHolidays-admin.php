<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/admin
 * @author     Erika Gili <ing.erika.gili@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BeaverNerdHolidays_Admin {

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
	 * The year of the last calendar loaded.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $year_version    The year of the last calendar loaded.
	 */
	private $year_version;

	/**
	 * The option where to save the setting that allows or not the display of the developer's link
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $display_link    The setting that allows or not the display of the developer's link
	 */
	private $display_link;

	/**
	 * The name of the option in the Wordpress option table.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $option_name    The name of the option.
	 */
	private $option_name;

	/**
	 * The name of the plugin's table in the Wordpress database.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $option_name    The name of the table.
	 */
	private $table_name;

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
		$this->custom_option_name = 'beaver_nerd_holidays_settings';
		$plugin_settings = get_option( $this->custom_option_name );
		$this->year_version = $plugin_settings['version'];
		$this->display_link = (isset($plugin_settings['display_link'])) ? $plugin_settings['display_link'] : 0;	
		$this->table_name = "BeaverNerdHolidays";
	}

	/**
	 * Add the plugin menu to the toolbar.
	 *
	 * @since    1.0.0
	 */
	public function settings_menu() {

		add_menu_page('Beaver Nerd Holidays Settings', 'Nerd Holidays', 'administrator', 'BeaverNerdHolidays_settings', array($this, 'beavernerdholidays_settings_page'), 'dashicons-calendar-alt');
	}

	/**
	 * Add settings sections and fields
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		add_settings_section(
			$this->plugin_name . '_general',
			__( 'General', $this->plugin_name ),
			array( $this, 'section_general_cb' ),
			$this->plugin_name . '_settings' 
			);

		add_settings_field(
			$this->plugin_name . '_version',
			__('Year of the loaded holidays', $this->plugin_name),
			array( $this, 'field_version_cb' ),
			$this->plugin_name . '_settings',
			$this->plugin_name . '_general'
			);

		add_settings_field(
			$this->plugin_name . '_devlink',
			__('Display the developer\'s link', $this->plugin_name),
			array( $this, 'field_devlink_cb' ),
			$this->plugin_name . '_settings',
			$this->plugin_name . '_general'
			);

		add_settings_section(
			$this->plugin_name . '_update',
			__( 'Update holidays', $this->plugin_name ),
			array( $this, 'section_update_cb' ),
			$this->plugin_name . '_update_section' 
			);

		add_settings_field(
			$this->plugin_name . '_update_button',
			__('Check to update', $this->plugin_name),
			array( $this, 'field_update_button_cb' ),
			$this->plugin_name . '_update_section',
			$this->plugin_name . '_update'
			);

		register_setting( $this->plugin_name . '_settings', $this->custom_option_name, array( $this, 'sanitize_settings') );
	}

	/**
	 * Callback for the general section
	 *
	 * @since    1.0.0
	 */
	public function section_general_cb( $args ) {
		_e( 'General settings about the plugin', $this->plugin_name );
	}

	/**
	 * Callback for the field about the year in the general section
	 *
	 * @since    1.0.0
	 */
	public function field_version_cb( $args ) {
		echo $this->year_version;
	}

	/**
	 * Callback for the field about the developer's link in the general section
	 *
	 * @since    1.0.0
	 */
	public function field_devlink_cb( $args ) {
		echo '<input type="checkbox" name="' . $this->custom_option_name . '[display_link]" value="1"';
		echo checked( 1, $this->display_link, true );
		echo ' />';
	}

	/**
	 * Callback for the update section
	 *
	 * @since    1.0.0
	 */
	public function section_update_cb( $args ) {
		_e( 'It\'s available the update for the calendar with this year\'s holidays', $this->plugin_name );
	}

	/**
	 * Callback for the field about the update in the update section
	 *
	 * @since    1.0.0
	 */
	public function field_update_button_cb( $args ) {
		echo '<input type="checkbox" name="beaverNerdUpdate" value="Update" />';
	}

	/**
	 * Sanitization of the fields. Attention made to the checkbox that, if not checked, it's not sent. Sending also the year version to avoid the deleting of the option.
	 *
	 * @since    1.0.0
	 */
	public function sanitize_settings( $args ) {
		$response = false;
		if ( ! is_array($args) ) {
			$new = array();
			$new['display_link'] = '0';
			$new['version'] = $this->year_version;
			unset($args);
			$args = $new;
			$response = true;
		} else {
			if ( $args['display_link'] == '1' ) {
				$args['version'] = $this->year_version;
				$response = true;
			} else {
				$args['display_link'] == '0';
				$args['version'] = $this->year_version;
				$response = true;
			}
		}

		if( $response ) {
			return $args;
		}
	}

	/**
	 * Verify if exists the new calendar's file
	 *
	 * @since    1.0.0
	 */
	public function verify_exists_calendar() {
		$file = 'http://www.brilliantbeaver.com/beavernerdplugin/geek_source_' . date('Y') . '.json';
		$file_headers = @get_headers($file);
		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
		    $exists = false;
		}
		else {
		    $exists = true;
		}
		return $exists;
	}

	/**
	 * Update the calendar if it's a new year
	 *
	 * @since    1.0.0
	 */
	private function update_calendar() {
		if ( current_user_can( 'activate_plugins' ) ) {
			$this->load_updated_calendar();
			$this->lint_database();
		}
	}

	/**
	 * Use the activation methods to download the new calendar
	 *
	 * @since    1.0.0
	 */
	private function load_updated_calendar() {
		global $wpdb;
		include_once(plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-BeaverNerdHolidays-activator.php');
		$plugin_options = get_option($this->custom_option_name);
		$year_version = $plugin_options['version'];
		$display_link = $plugin_options['display_link'];
		
		$version = BeaverNerdHolidays_Activator::fill_plugin_table( $wpdb->prefix . "BeaverNerdHolidays");
		$this->year_version = $version;
		BeaverNerdHolidays_Activator::create_option( $version, $display_link );	
	}

	/**
	 * Erase from the database the old holidays
	 *
	 * @since    1.0.0
	 */
	private function lint_database() {
		global $wpdb;

		$query = "DELETE FROM " . $wpdb->prefix . $this->table_name . "  
			WHERE 
				YEAR(holiday_date)<YEAR(CURDATE())
				AND holiday_custom = 0";
		$wpdb->query($query);
	}

	/**
	 * Print the settings page
	 *
	 * @since    1.0.0
	 */
	public function beavernerdholidays_settings_page() {
		if ( current_user_can( 'activate_plugins' ) ) {
			include_once 'partials/BeaverNerdHolidays-admin-display.php';
		}
	}

	/**
	 * Return year of the last calendar downloaded
	 *
	 * @since    1.0.0
	 */
	public function get_year_version() {
		return $this->year_version;
	}
}
