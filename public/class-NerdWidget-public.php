<?php 

/**
 * The public-facing widget of the plugin.
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/public
 */

/**
 * The public-facing widget of the plugin.
 *
 * Defines the widget on front-end and back-end.
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/public
 * @author     Erika Gili <ing.erika.gili@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BeaverNerdHolidaysWidget extends WP_Widget {

	/**
	 * The option name used in the options table.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $custom_option_name    The option used by the plugin.
	 */
	private $custom_option_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		parent::__construct('BeaverNerdHolidays', 'BeaverNerdHolidays', array( 'description' => __( 'Which Nerd Holiday is today?', 'BeaverNerdHolidays' )));
		$this->custom_option_name = 'beaver_nerd_holidays_settings';
	}

	/**
	 * Outputs the content of the widget on front-end
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		global $wpdb;
		$plugin_options = get_option( $this->custom_option_name );
		// query to retrieve if today is an holiday
		$table_name = $wpdb->prefix . 'BeaverNerdHolidays';
		$query = "SELECT * FROM $table_name WHERE (DATE_FORMAT(holiday_date, '%m%d') = DATE_FORMAT(CURDATE(), '%m%d') AND holiday_forever = 1 ) OR (holiday_date = CURDATE() AND holiday_forever = 0)";
		$holidays = $wpdb->get_results( $query, 'ARRAY_A' );
		if ( !empty( $holidays ) ) {
			include_once( 'partials/BeaverNerdHolidays-public-display-today.php' );
		} else {
			// today is not an holiday, i'll display the next holiday date
			$future_holiday_date = "SELECT 
					date_format(current_year_holidays, '%d %M') as current_year_holidays,
					holiday_title,
					holiday_description,
					holiday_link
				from 
				(
					select
						(
							case holiday_forever
								when 1 then 
									STR_TO_DATE(concat(year(curdate()), '-', month(holiday_date), '-', day(holiday_date)), '%Y-%m-%d')
								else holiday_date
							end
						) as current_year_holidays,
				        holiday_title,
				        holiday_description,
				        holiday_link
					from 
						$table_name
					union
						select
						(
							case holiday_forever
								when 1 then 
									STR_TO_DATE(concat(year(curdate()) + 1, '-', month(holiday_date), '-', day(holiday_date)), '%Y-%m-%d')
								else holiday_date
							end
						) as current_year_holidays,
				        holiday_title,
				        holiday_description,
				        holiday_link
						from $table_name
				) normalized_dates
				where current_year_holidays > curdate() and
				current_year_holidays <= 
				(
					select min(current_year_holidays)
					from
					(
						select
						(
							case holiday_forever
								when 1 then 
									STR_TO_DATE(concat(year(curdate()), '-', month(holiday_date), '-', day(holiday_date)), '%Y-%m-%d')
								else holiday_date
							end
						) as current_year_holidays
						from $table_name
						union
						select
						(
							case holiday_forever
								when 1 then 
									STR_TO_DATE(concat(year(curdate()) + 1, '-', month(holiday_date), '-', day(holiday_date)), '%Y-%m-%d')
								else holiday_date
							end
						) as current_year_holidays
						from $table_name
					)tmp_table
				where current_year_holidays > curdate()
				)
				order by current_year_holidays";

			$holiday_future = $wpdb->get_results( $future_holiday_date, 'ARRAY_A' );
				
			include_once( 'partials/BeaverNerdHolidays-public-display-next.php' );
		}
		if ($plugin_options['display_link']) {
			include_once( 'partials/BeaverNerdHolidays-public-display-footer.php' );
		}
			
	}

	/**
	* Outputs the options form on admin page
	*
	* @param array $instance The widget options
	*/
	public function form( $instance ) {
		echo 'No need to set!';
	}
}