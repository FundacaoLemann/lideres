<?php
/**
 *
 * This file is called for general settings section at admin settings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( is_multisite() && is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
	$wbbpp_general_settings = get_site_option( 'wbbpp_general_settings' );
} else {
	$wbbpp_general_settings = get_option( 'wbbpp_general_settings' );
}
?>
<form method="post" action="options.php">
	<?php
	settings_fields( 'wbbpp_general_settings_section' );
	do_settings_sections( 'wbbpp_general_settings_section' );
	?>
	<div class="container">
		<p><i class="fa fa-question-circle"></i>
			<span class="bprm-tab-description">
				<?php esc_html_e( 'To use the Google Autocomplete Field Type in the resume, you must register your app project on the Google API Console and get a Google API key which you can add here.', 'buddypress-profile-pro' ); ?>
				
			</span>
		</p>
		<p>
			<strong><?php esc_html_e( 'Step 1: ', 'buddypress-profile-pro' ); ?></strong>
			<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="blank"><?php esc_html_e( 'Get an API Key from the Google API Console.', 'buddypress-profile-pro' ); ?></a>
			<span><?php esc_html_e( '( Click the GET A KEY in the link provided, which guides you through the process of registering a project in the Google API Console. )', 'buddypress-profile-pro' ); ?></span>
		</p>
		<p>
			<strong><?php esc_html_e( 'Step 2:', 'buddypress-profile-pro' ); ?></strong>
			<span><?php esc_html_e( 'Add the API key in the below field.', 'buddypress-profile-pro' ); ?></span>
		</p>
		<table class="form-table">
			<tr>
				<th scope="row"><label for="blogname"><?php esc_html_e( 'Google API Key', 'buddypress-profile-pro' ); ?></label></th>
				<td><input name='wbbpp_general_settings[place_api]' type='text' class="regular-text" value='<?php echo isset( $wbbpp_general_settings['place_api'] ) ? $wbbpp_general_settings['place_api'] : ''; ?>' placeholder="<?php esc_html_e( 'API Key', 'buddypress-profile-pro' ); ?>" /><p class="description" id="tagline-description"><?php esc_html_e( 'This API Key will help fetch the google places while setting place for work and education.', 'buddypress-profile-pro' ); ?>
					<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="blank"><?php esc_html_e( 'Get google API Key.', 'buddypress-profile-pro' ); ?></a>
				</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="blogname"><?php esc_html_e( 'Enable profile fields visibility settings', 'buddypress-profile-pro' ); ?></label></th>
				<td><input type="checkbox" name="wbbpp_general_settings[fld_visib_stngs]" value="yes" <?php if(isset($wbbpp_general_settings['fld_visib_stngs'])) checked($wbbpp_general_settings['fld_visib_stngs'],'yes') ?>>
					<p class="description" id="tagline-description"><?php esc_html_e( 'Enable this option if you want users to change their profile fields visibility setting.', 'buddypress-profile-pro' ); ?>
					</p>
				</td>
			</tr>
	    </table>
	</div>
	<?php submit_button(); ?>
</form>
