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

/**
 * Redireciona usuários que não são moderadores de um grupo
 * para a página inicial do site.
 */
function lemann_group_home_redirect() {
	if ( bp_is_group_home() ) {
		$user_id  = get_current_user_id();
		$group_id = bp_get_group_id();
		if ( groups_is_user_mod( $user_id, $group_id ) ) {
			wp_redirect( home_url( '/' ) );
			exit;
		}
	}
}
add_action( 'wp', 'lemann_group_home_redirect' );
