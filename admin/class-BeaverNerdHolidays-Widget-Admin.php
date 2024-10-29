<?php 
/**
 * The dashboard-side widget of the plugin.
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/admin
 */

/**
 * The dashboard-side widget of the plugin.
 *
 * Checks if there are updates available for the calendar and displays an alert.
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/admin
 * @author     Erika Gili <ing.erika.gili@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BeaverNerdHolidays_Widget_Admin {

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
	 * The name of the widget.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $widget_name    The name of the widget.
	 */
	private $widget_name;

	/**
	 * The slug of the widget.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $widget_slug    The slug of the widget.
	 */
	private $widget_slug;

	/**
	 * The name of the settings page of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings_page    The name of the settings page.
	 */
	private $settings_page;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($name, $version) {
		$this->plugin_name = $name;
		$this->version = $version;
		$this->widget_name = 'Nerd Calendar update available!';
		$this->widget_slug = 'beaver_nerd_holidays_dashboard_widget';
		$this->settings_page = $this->plugin_name . '_settings';
	}

	/**
	 * If exists a newer version of the calendar displays the widget.
	 *
	 * @since    1.0.0
	 */
	public function check_update() {
		$admin = new BeaverNerdHolidays_Admin( $this->plugin_name, $this->version );
		if (date('Y') > $admin->get_year_version()) {
			if ( $admin->verify_exists_calendar() ) {
				wp_add_dashboard_widget($this->widget_slug, $this->widget_name, array($this, 'dashboard_widget_function'));
				global $wp_meta_boxes;
				//SET THIS WIDGET AS FIRST, from Wordpress Codex, Dashboard_Widgets_API
				 	
			 	// Get the regular dashboard widgets array 
			 	// (which has our new widget already but at the end)
			 
			 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
			 	
			 	// Backup and delete our new dashboard widget from the end of the array
			 
			 	$widget_backup = array( $this->widget_slug => $normal_dashboard[$this->widget_slug] );
			 	unset( $normal_dashboard[$this->widget_slug] );
			 
			 	// Merge the two arrays together so our widget is at the beginning
			 
			 	$sorted_dashboard = array_merge( $widget_backup, $normal_dashboard );
			 
			 	// Save the sorted array back into the original metaboxes 
			 
			 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
			}
		}		
	}

	/**
	 * Content of the widget.
	 *
	 * @since    1.0.0
	 */
	public function dashboard_widget_function() {
		echo '<p>';
		_e('It\'s available the update for your Nerd Calendar!', $this->plugin_name);
		echo '</p><a href="' . admin_url( 'options-general.php?page=' . $this->settings_page ) . '" class="button button-primary">' . __('Go to settings', 'BeaverNerdHolidays') . '</a>';
		echo '<br class="clear" />';
	}
}