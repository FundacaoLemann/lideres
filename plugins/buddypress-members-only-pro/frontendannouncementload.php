<?php
if (! defined ( 'ABSPATH' )) {
	exit ();
}

$m_contentFrontendAnnouncement = get_option ( 'contentFrontendAnnouncement' );
$bpenableannouncement = get_option ( 'bpenableannouncement' );
function tomas_frontendAnnouncementTop() {
	$m_contentFrontendAnnouncement = get_option ( 'contentFrontendAnnouncement' );
	$m_contentFrontendAnnouncement = stripslashes ( $m_contentFrontendAnnouncement );
	echo '<div id="topbar" style="position: absolute; top: 0; left: 0; width: 100%; z-index:999999; background: #ccc;">';
	echo "<div style='text-align:center'>";
	echo $m_contentFrontendAnnouncement;
	echo '</div>';
	echo '</div>';
}

if ((! (empty ( $m_contentFrontendAnnouncement ))) && (! (empty ( $bpenableannouncement )))) {
	$saved_register_page_url = get_option ( 'bpmoregisterpageurl' );
	$saved_register_page_url = str_ireplace ( 'http://', '', $saved_register_page_url );
	$saved_register_page_url = str_ireplace ( 'https://', '', $saved_register_page_url );
	$saved_register_page_url = str_ireplace ( 'ws://', '', $saved_register_page_url );
	$saved_register_page_url = str_ireplace ( 'www.', '', $saved_register_page_url );
	
	$current_url = $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	$current_url = str_ireplace ( 'http://', '', $current_url );
	$current_url = str_ireplace ( 'https://', '', $current_url );
	$current_url = str_ireplace ( 'ws://', '', $current_url );
	$current_url = str_ireplace ( 'www.', '', $current_url );
	
	if (stripos ( $saved_register_page_url, $current_url ) === false) {
	} else {
		add_action ( 'wp_head', 'tomas_frontendAnnouncementTop' );
	}
}