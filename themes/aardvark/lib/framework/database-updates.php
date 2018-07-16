<?php

/**
 * Updating to v1.8
 *
 */	
if ( get_option( 'ghostpool_aardvark_db_version' ) < '1.8' ) {

	if ( ! function_exists( 'ghostpool_aardvark_v18_update_database' ) ) {
	
		function ghostpool_aardvark_v18_update_database() {
		
			global $wpdb;
			
			// Update vote down custom field name
			$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = %s WHERE meta_key = %s", 'ghostpool_voting_down', '_ghostpool_voting_down' ) );
																							
		}
		
	}
	add_action( 'init', 'ghostpool_aardvark_v18_update_database' );
	update_option( 'ghostpool_aardvark_db_version', '1.8' );

}

?>