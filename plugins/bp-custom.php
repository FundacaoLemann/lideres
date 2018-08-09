<?php
defined( 'ABSPATH' ) || exit;

/**
 * Altera a aba padrão de visualização do usuário.
 */
define( 'BP_DEFAULT_COMPONENT', 'profile' );

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

	bp_core_remove_subnav_item( 'activity', 'favorites' );
	bp_core_remove_subnav_item( 'activity', 'friends' );
	bp_core_remove_subnav_item( 'activity', 'groups' );
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
	if ( bp_is_group_home() && ! bp_group_is_admin() && ! bp_group_is_mod() ) {
		wp_redirect( home_url( '/' ) );
		exit;
	}
}
add_action( 'wp', 'lemann_group_home_redirect' );

/**
 * Faz o WP não carregar a tradução padrão (e usar a nossa).
 */
add_filter( 'buddypress_locale_locations', function ( $val ) {
	unload_textdomain( 'buddypress' );
	return $val;
});
