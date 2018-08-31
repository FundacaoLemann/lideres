<?php
/**
 *
 * This template file is used for fetching desired options page file at admin settings end.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( isset( $_GET['tab'] ) ) {
	$bprm_tab = sanitize_text_field( $_GET['tab'] );
} else {
	$bprm_tab = 'general';
}

bprm_include_admin_setting_tabs( $bprm_tab );

/**
 * Include setting template.
 *
 * @param string $bprm_tab
 */
function bprm_include_admin_setting_tabs( $bprm_tab ) {
	switch ( $bprm_tab ) {
		case 'general':
			include 'wbbpp-setting-general-tab.php';
			break;
		case 'support':
			include 'wbbpp-setting-support-tab.php';
			break;
		case 'gen_settings':
			include 'wbbpp-setting-fields-tab.php';
			break;
		case 'group_settings':
			include 'wbbpp-setting-groups-tab.php';
			break;	
		default:
			include 'wbbpp-setting-general-tab.php';
			break;
	}
}
