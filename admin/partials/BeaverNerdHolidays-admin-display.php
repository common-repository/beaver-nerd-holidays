<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.brilliantbeaver.com
 * @since      1.0.0
 *
 * @package    BeaverNerdHolidays
 * @subpackage BeaverNerdHolidays/admin/partials
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! current_user_can( 'activate_plugins' ) ) exit; // exit if user doesn't have permissions

if ( isset( $_POST['beaverNerdUpdate']) && check_admin_referer( 'beavernerdholidays_update_settings', 'beavernerdholidays_update_nonce' ) ) {
	$this->update_calendar();
}

?>

<div class="wrap">
	<h2>Nerd Holidays Settings</h2>

	<?php 
		if ( isset($_REQUEST['settings-updated']) ) {
			if ( $_REQUEST['settings-updated'] == "true" ) {
				echo '<div class="notice notice-success"><p>';
				_e( 'Settings saved successfully!', 'BeaverNerdHolidays' );
				echo '</p></div>';
			} else {
				echo '<div class="notice notice-error"><p>';
				_e( 'Settings not saved!', 'BeaverNerdHolidays' );
				echo '</p></div>';
			}		
		}
	?>

	<form method="post" action="options.php">
		<?php 
			settings_fields( $this->plugin_name . '_settings' ); 
			do_settings_sections( $this->plugin_name . '_settings' );		
			submit_button(); 
		?>

	</form>

	<?php 
		if (date('Y') > $this->year_version) :
			if ( $this->verify_exists_calendar() ) :
	?>

	<form method="post" action="">
		<?php 
			settings_fields( $this->plugin_name . '_update_section' ); 
			do_settings_sections( $this->plugin_name . '_update_section' );	
			wp_nonce_field( 'beavernerdholidays_update_settings', 'beavernerdholidays_update_nonce' );	
			submit_button( __('Update!', 'BeaverNerdHolidays') ); 
		?>

	</form>

	<?php 
			endif;
		endif; 
	?>
</div>
