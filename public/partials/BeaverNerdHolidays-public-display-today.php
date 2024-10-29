<?php

/**
 * Provide a public-facing view for the plugin if today is a nerd holiday 
 *
 * This file is used to markup the first part of public-facing aspects of the plugin.
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/public/partials
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<h2>
	<?php _e('Today is...', 'BeaverNerdHolidays'); ?>	
</h2>
<?php 
	foreach ( $holidays as $key => $holiday ) {
?>
		<p class="nerdholiday-title">
		<?php 
		if ( ! empty( $holiday['holiday_link'] ) ):
		?>
			<a href="<?php echo $holiday['holiday_link']; ?>" target="_blank">
		<?php 
		endif;
		echo $holiday['holiday_title']; 

		if ( isset( $holiday['holiday_link'] ) ):
		?>
			</a>
		<?php 
		endif;
		?>
		</p>

		<p class="nerdholiday-description">
<?php 
		if ( isset( $holiday['holiday_description'] ) ){
			echo $holiday['holiday_description']; 
		}
?>
		</p>
<?php 
	}
