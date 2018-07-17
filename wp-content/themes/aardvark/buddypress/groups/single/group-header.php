<?php 
/**
 * BuddyPress - Groups Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group();

	/**
	 * Fires before the display of a group's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_group_header' );

	global $bp; ?>

	<?php if ( ! bp_disable_group_avatar_uploads() ) { ?>
		<div id="item-header-avatar">
			<a href="<?php echo esc_url( bp_get_group_permalink() ); ?>" class="bp-tooltip" data-bp-tooltip="<?php echo esc_attr( bp_get_group_name() ); ?>">
				<?php bp_group_avatar(); ?>
			</a>
		</div>
	<?php } ?>

	<div id="item-header-content">

		<h2 class="gp-bp-header-title"><?php echo esc_attr( $bp->groups->current_group->name ); ?></h2>

		<?php do_action( 'bp_before_group_header_meta' ); ?>

		<span class="gp-bp-header-highlight"><?php bp_group_type(); ?></span>
	
		<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( $bp->groups->current_group, array( 'relative' => false ) ) ); ?>"><?php printf( esc_html_e( 'active %s', 'aardvark' ), bp_get_group_last_active() ); ?></span>
									
		<div class="gp-bp-header-desc">
			<?php bp_group_description(); ?>
		</div>
	
		<?php bp_group_type_list(); ?>
	
		<div class="gp-bp-header-actions">
			<?php do_action( 'bp_group_header_actions' ); ?>
		</div>
	
		<?php do_action( 'bp_group_header_meta' ); ?>

		<?php if ( bp_group_is_visible() ) { ?>

			<div class="gp-bp-header-members">
				<div class="gp-bp-header-members-title"><?php esc_html_e( 'Group Admins', 'aardvark' ); ?></div>
				<?php bp_group_list_admins(); do_action( 'bp_after_group_menu_admins' ); ?>
			</div>
	
			<?php if ( bp_group_has_moderators() ) { ?>
				<div class="gp-bp-header-members">
					<?php do_action( 'bp_before_group_menu_mods' ); ?>
					<div class="gp-bp-header-members-title"><?php esc_html_e( 'Group Mods' , 'aardvark' ); ?></div>
					<?php bp_group_list_mods(); do_action( 'bp_after_group_menu_mods' ); ?>
				</div>
			<?php } ?>
	
		<?php } ?>

		<?php
		/**
		 * Fires after the display of a group's header.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_after_group_header' );  ?>

		<div id="template-notices" role="alert" aria-atomic="true">
			<?php
			/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
			do_action( 'template_notices' ); ?>

		</div>

	</div>	

<?php endwhile; endif; ?>