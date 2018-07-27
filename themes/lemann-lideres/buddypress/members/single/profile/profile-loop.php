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
$args = [
	'exclude_groups' => '1 4 8',
	'exclude_fields' => '80 254 255 256',
];
if ( bp_has_profile( $args ) ) {
	bp_get_template_part( 'members/single/profile/profile-group-loop' );
}
/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' );
