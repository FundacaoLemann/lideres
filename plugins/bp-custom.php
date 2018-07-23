<?php
defined( 'ABSPATH' ) || exit;

/**
 * Altera a navegação do BuddyPress.
 */
function lemann_bp_setup_nav() {
	bp_core_remove_nav_item( 'forums' );
	bp_core_remove_nav_item( 'groups' );
	bp_core_remove_nav_item( 'events' );
}
add_action( 'bp_setup_nav', 'lemann_bp_setup_nav', 999 );
