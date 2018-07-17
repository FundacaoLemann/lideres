<?php

/**
 * Load custom BuddyPress stylesheet
 *
 */
if ( ! function_exists( 'ghostpool_bp_enqueue_scripts' ) ) {	
	function ghostpool_bp_enqueue_scripts() {
		wp_enqueue_style( 'ghostpool-bp', get_template_directory_uri() . '/lib/css/bp.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_bp_enqueue_scripts' );

/**
 * Disable activation redirect
 *
 */
remove_action( 'bp_admin_init', 'bp_do_activation_redirect', 1 );

/**
 * Default active components
 *
 */
if ( function_exists( 'bp_is_active' ) ) {
	function ghostpool_buddypress_defaults() {	
		$default_components = array(
			'activity'      => 1,
			'members'       => 1,
			'groups'		=> 1,
			'settings'      => 1,
			'xprofile'      => 1,
			'notifications' => 1,
		);
		return $default_components;		
	}	
	add_filter( 'bp_new_install_default_components', 'ghostpool_buddypress_defaults' );	
}

/**
 * Default avatar dimensions
 *
 */
if ( ! defined( 'BP_AVATAR_THUMB_WIDTH' ) ) {
	define( 'BP_AVATAR_THUMB_WIDTH', 90 );
}
if ( ! defined( 'BP_AVATAR_THUMB_HEIGHT' ) ) {
	define( 'BP_AVATAR_THUMB_HEIGHT', 90 );
}
if ( ! defined( 'BP_AVATAR_FULL_WIDTH' ) ) {
	define( 'BP_AVATAR_FULL_WIDTH', 210 );
}
if ( ! defined( 'BP_AVATAR_FULL_HEIGHT' ) ) {
	define( 'BP_AVATAR_FULL_HEIGHT', 210 );
}

/**
 * Default cover image dimensions
 *
 */
if ( ! function_exists( 'ghostpool_xprofile_cover_image' ) ) {	
	function ghostpool_xprofile_cover_image( $settings = array() ) {
		$settings['width'] = 1500;
		$settings['height'] = 300;
		return $settings;
	}
}
add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'ghostpool_xprofile_cover_image', 10, 1 );
add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'ghostpool_xprofile_cover_image', 10, 1 );

/**
 * Add custom activity stream classes
 *
 */
if ( ! function_exists( 'ghostpool_bp_get_activity_css_class' ) ) {
	function ghostpool_bp_get_activity_css_class( $class ) {
		global $activities_template;
		if ( is_user_logged_in() ) {
			return $activities_template->activity->component . ' ' . $activities_template->activity->type . $class . ' gp-user-can-comment';
		} else {
			return $activities_template->activity->component . ' ' . $activities_template->activity->type . $class;
		}
	}
}
add_filter( 'bp_get_activity_css_class', 'ghostpool_bp_get_activity_css_class', 10, 2 );

/**
 * Remove WordPress SEO title filter from BuddyPress pages
 *
 */
if ( function_exists( 'wpseo_auto_load' ) ) {
	if ( ! function_exists( 'ghostpool_remove_bp_wpseo_title' ) ) {
		function ghostpool_remove_bp_wpseo_title() {
			if ( ! bp_is_blog_page() ) { 
				$front_end = WPSEO_Frontend::get_instance();
				remove_filter( 'pre_get_document_title', array( $front_end, 'title' ), 15 );
			}	
		}
	}
	add_action( 'init', 'ghostpool_remove_bp_wpseo_title' );
}

/**
 * Add shortcode support to Activity Visual Composer element
 *
 */
if ( ! function_exists( 'ghostpool_bp_get_activity_content_body' ) ) {
	function ghostpool_bp_get_activity_content_body( $content ) {
		return do_shortcode( $content );
	}
}
add_filter( 'bp_get_activity_content_body', 'ghostpool_bp_get_activity_content_body' );

/**
 * User online indicator
 *
 */
if ( ! function_exists( 'ghostpool_is_user_online' ) ) {
	function ghostpool_is_user_online( $user_id, $last_active, $time = 5 ) {
		global $wpdb;
		$sql = $wpdb->prepare( "SELECT u.user_login FROM $wpdb->users u JOIN $wpdb->usermeta um ON um.user_id = u.ID WHERE u.ID = %d AND um.meta_key = 'last_activity' AND DATE_ADD( um.meta_value, INTERVAL %d MINUTE ) >= UTC_TIMESTAMP()", $user_id, $time );
		$user_login = $wpdb->get_var( $sql );
		if ( isset( $user_login ) && $user_login != '' ) {
			echo '<div class="gp-user-online"><div class="bp-tooltip" data-bp-tooltip="' . $last_active . '"></div></div>';
		} else {
			echo '<div class="gp-user-offline"><div class="bp-tooltip" data-bp-tooltip="' . $last_active . '"></div></div>';
		}
	}
}

?>