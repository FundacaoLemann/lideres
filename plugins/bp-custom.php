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
add_filter( 'buddypress_locale_locations', function ( $val ) {
	unload_textdomain( 'buddypress' );
	return $val;
});

add_filter( 'xprofile_filter_profile_group_tabs', function ( $tabs ) {
	$current = '';
	if ( 'extended-fields' == bp_current_action() ) {
		$current = ' class="current"';

		$tabs[0] = str_replace( ' class="current"', '', $tabs[0] );
	}
	$tabs[] = sprintf(
		'<li %1$s><a href="%2$s">%3$s</a></li>',
		$current,
		esc_url( bp_displayed_user_domain() . bp_get_profile_slug() . '/extended-fields/' ),
		esc_html( __( 'Carreiras', 'lemann-lideres' ) )
	);
	return $tabs;
} );
