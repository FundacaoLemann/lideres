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
	bp_core_remove_nav_item( 'docs' );

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
 * Faz o WP não carregar a tradução padrão (e usar a nossa).
 */
add_filter(
	'buddypress_locale_locations',
	function ( $val ) {
		unload_textdomain( 'buddypress' );
		return $val;
	}
);

add_filter(
	'bp_xprofile_get_visibility_levels',
	function( $visibility_levels ) {
		$order   = [ 'public', 'loggedin', 'friends', 'adminsonly' ];
		$ordered = [];
		foreach ( $order as $key ) {
			$ordered[ $key ] = $visibility_levels[ $key ];
			unset( $visibility_levels[ $key ] );
		}
		$ordered = $ordered + $visibility_levels;

		$ordered['public']['label']     = 'Público para todos';
		$ordered['adminsonly']['label'] = 'Privado';
		$ordered['loggedin']['label']   = 'Público para líderes';
		$ordered['friends']['label']    = 'Público para contatos';
		return $ordered;
	}
);
