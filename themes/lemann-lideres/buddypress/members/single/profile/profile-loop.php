<?php
/**
 * BuddyPress - Members Profile Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */
/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_before_profile_loop_content' ); ?>

<?php
$exclude_groups = [ 4, 9, 10, 11 ];
if ( is_event_month() ) {
	$exclude_groups[] = 8;
}

// Campos do grupo com id 1 que não devem ser exibidos.
$campos_destaque_perfil = [ 1, 253, 27, 32, 574 ];

$args = [
	'exclude_groups' => implode( ',', $exclude_groups ),
	'exclude_fields' => '80 254 255 256 ' . implode( ' ', LEMANN_BP_OUTROS + $campos_destaque_perfil ),
];
if ( bp_has_profile( $args ) ) {
	bp_get_template_part( 'members/single/profile/profile-group-loop' );
}
/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' );
