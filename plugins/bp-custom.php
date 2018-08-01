<?php
defined( 'ABSPATH' ) || exit;

/**
 * Altera a navegação do BuddyPress.
 */
function lemann_bp_setup_nav() {
	buddypress()->members->nav->edit_nav( array(
		'name' => 'Postagens',
	), 'activity' );

	bp_core_remove_nav_item( 'forums' );
	bp_core_remove_nav_item( 'groups' );
	bp_core_remove_nav_item( 'events' );
}
add_action( 'bp_setup_nav', 'lemann_bp_setup_nav', 999 );

/**
 * Remove a barra do WordPress se o usuário não for um superadmin.
 */
function lemann_remove_admin_bar() {
	if ( ! is_super_admin() ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}
add_action( 'wp', 'lemann_remove_admin_bar' );
