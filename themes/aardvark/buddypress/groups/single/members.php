<?php
/**
 * BuddyPress - Groups Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) ) ) : ?>

	<?php

	/**
	 * Fires before the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_members_content' ); ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_group_members_list' ); ?>

	<ul id="member-list" class="gp-bp-wrapper gp-posts-masonry gp-columns-4 gp-style-classic gp-align-center">

		<li class="gp-gutter-size"></li>

		<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

			<li class="gp-post-item">
									
				<?php $cover_image_url = bp_attachments_get_attachment( 'url', array( 'object_dir' => 'members', 'item_id' => bp_get_member_user_id() ) );
				if ( bp_displayed_user_use_cover_image_header() == '1' && $cover_image_url != '' ) { ?>
					<a href="<?php bp_group_member_domain(); ?>" class="gp-post-thumbnail" style="background-image: url(<?php echo esc_url( $cover_image_url ); ?>);">												
						<span class="gp-bp-col-avatar">
							<span class="gp-bp-hover-effect"></span>
							<?php bp_group_member_avatar_thumb(); ?>
							<?php ghostpool_is_user_online( bp_get_member_user_id(), bp_get_member_last_active() ); ?>
						</span>
					</a>
				<?php } ?>
			
				<div class="gp-loop-content<?php if ( $cover_image_url == '' ) { ?> gp-no-cover-image<?php } ?>">
				
					<?php if ( $cover_image_url == '' ) { ?>												
						<div class="gp-bp-col-avatar">
							<a href="<?php bp_group_member_domain() ?>">
								<span class="gp-bp-hover-effect"></span>
								<?php bp_group_member_avatar_thumb(); ?>								
								<?php ghostpool_is_user_online( bp_get_member_user_id(), bp_get_member_last_active() ); ?>
							</a>
						</div>
					<?php } ?>
		
					<div class="gp-loop-title">
						<?php bp_group_member_link(); ?>
					</div>

					<div class="gp-loop-meta">
						<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_member_joined_since( array( 'relative' => false ) ) ); ?>"><?php bp_group_member_joined_since(); ?></span>
					</div>	
				
					<?php do_action( 'bp_group_members_list_item' ); ?>

					<?php if ( bp_is_active( 'friends' ) ) : ?>
						<div class="gp-bp-col-action">
							<?php bp_add_friend_button( bp_get_group_member_id(), bp_get_group_member_is_friend() ); ?>
							<?php do_action( 'bp_group_members_list_item_action' ); ?>
						</div>
					<?php endif; ?>
			
				</div>
							
			</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the group members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_group_members_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires after the display of the group members content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( 'No members were found.', 'aardvark' ); ?></p>
	</div>

<?php endif;