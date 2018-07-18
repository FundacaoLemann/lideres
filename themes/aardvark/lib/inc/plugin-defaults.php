<?php

/**
 * Set default option values for Responsive Visual Composer
 *
 */
if ( class_exists( 'BestBugVCEDO' ) ) {
	function ghostpool_bbvcedo_options_by_elements_default() {	
		return 'all';
	}	
	add_filter( 'bbvcedo_options_by_elements_default', 'ghostpool_bbvcedo_options_by_elements_default' );	
}

/**
 * Set default option values for WordPress Social Login
 *
 */
if ( has_action( 'wordpress_social_login' ) && get_option( 'ghostpool_wp_social_defaults' ) !== '1' ) {
	function ghostpool_wp_social_defaults() {	
		update_option( 'wsl_settings_social_icon_set', 'none' );
	}	
	add_action( 'init', 'ghostpool_wp_social_defaults', 1 );	
	update_option( 'ghostpool_wp_social_defaults', '1' );		
}

// Events Manager fixes
if ( function_exists( 'em_init' ) ) {

	function ghostpool_event_manager_defaults() {

		// Fix for events being set as drafts
		$events = array( 'Grand Designs Live London', 'Comic-Con', 'Camden Town Brewery' );
		foreach( $events as $event ) {
			$page = get_page_by_title( $event, OBJECT, 'event' );
			if ( ! empty( $page ) && get_post_meta( $page->ID, '_ghostpool_event_import', true ) && get_post_status( $page->ID ) == 'draft' ) {
				wp_update_post( array( 
					'ID' => $page->ID,  
					'post_status' => 'publish',
				) );
			}	
		}		

		// Fix for capabilities being cleared
		if ( ! user_can( 'administrator', 'publish_events' ) ) {
	
			global $wp_roles;

			$caps = array( 'publish_events', 'delete_others_events', 'edit_others_events', 'manage_others_bookings', 'publish_recurring_events', 'delete_others_recurring_events', 'edit_others_recurring_events', 'publish_locations', 'delete_others_locations',	'delete_locations', 'edit_others_locations', 'delete_event_categories', 'edit_event_categories' );

			$roles = array( 'administrator', 'editor' );

			foreach( $roles as $user_role ) {
				foreach( $caps as $cap ) {
					$wp_roles->add_cap( $user_role, $cap );
				}
			}
	
			$loose_caps = array( 'manage_bookings', 'upload_event_images', 'delete_events', 'edit_events', 'read_private_events', 'delete_recurring_events', 'edit_recurring_events', 'edit_locations', 'read_private_locations', 'read_others_locations' );

			$roles = array( 'administrator', 'editor', 'contributor', 'author', 'subscriber' );

			foreach( $roles as $user_role ) {
				foreach( $loose_caps as $cap ) {
					$wp_roles->add_cap( $user_role, $cap );
				}
			}
		
		}
	
	}
	add_action( 'admin_init', 'ghostpool_event_manager_defaults' );
	
}
	
?>