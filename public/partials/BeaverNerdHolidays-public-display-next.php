<?php

/**
 * Provide a public-facing view for the plugin if today is not a nerd holiday 
 *
 * This file is used to markup the second parte of public-facing aspects of the plugin.
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
	<?php _e( 'Next Nerd Holiday...', 'BeaverNerdHolidays' ); ?>	
</h2>
<?php 
	foreach ( $holiday_future as $key => $holiday ) {
?>
<p class="nerdholiday-title"><?php echo $holiday['current_year_holidays'] . ' - ' . $holiday['holiday_title']; ?></p>
<?php
	}