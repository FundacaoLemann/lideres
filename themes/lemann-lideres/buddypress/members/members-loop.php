<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php

parse_str( bp_ajax_querystring( 'members' ), $ajax_querystring );
if ( empty( $ajax_querystring ) || ! isset( $ajax_querystring['type'] ) ) {
	$ajax_querystring['type'] = 'alphabetical';
	$query_string             = http_build_query( $ajax_querystring );
} else {
	$query_string = $ajax_querystring;
}

if ( bp_has_members( $query_string ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="gp-bp-wrapper gp-posts-masonry gp-columns-4 gp-style-classic gp-align-center" aria-live="assertive" aria-relevant="all">

		<li class="gp-gutter-size"></li>

		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li <?php bp_member_class( array( 'gp-post-item' ) ); ?>>

				<?php
				$cover_image_url = bp_attachments_get_attachment( 'url', array( 'object_dir' => 'members', 'item_id' => bp_get_member_user_id() ) );
				if ( bp_displayed_user_use_cover_image_header() == '1' && $cover_image_url != '' ) { ?>
					<a href="<?php bp_member_permalink(); ?>" class="gp-post-thumbnail" style="background-image: url(<?php echo esc_attr( $cover_image_url ); ?>);">
						<span class="gp-bp-col-avatar">
							<span class="gp-bp-hover-effect"></span>
							<?php bp_member_avatar(); ?>
							<?php ghostpool_is_user_online( bp_get_member_user_id(), bp_get_member_last_active() ); ?>
						</span>
					</a>
				<?php } ?>

				<div class="gp-loop-content<?php if ( $cover_image_url == '' ) { ?> gp-no-cover-image<?php } ?>">

					<?php if ( $cover_image_url == '' ) { ?>
						<div class="gp-bp-col-avatar">
							<a href="<?php bp_member_permalink() ?>">
								<span class="gp-bp-hover-effect"></span>
								<?php bp_member_avatar(); ?>
								<?php ghostpool_is_user_online( bp_get_member_user_id(), bp_get_member_last_active() ); ?>
							</a>
						</div>
					<?php } ?>

					<div class="gp-loop-title">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
					</div>

					<div class="gp-loop-meta">
						<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_member_last_active( array( 'relative' => false ) ) ); ?>"><?php bp_member_last_active(); ?></span>
					</div>

					<?php if ( bp_get_member_latest_update() ) : ?>
						<div class="gp-loop-text">
							<?php bp_member_latest_update(); ?>
						</div>
					<?php endif; ?>

					<div class="gp-bp-col-action">
						<?php do_action( 'bp_directory_members_actions' ); ?>
					</div>

					<?php

					/**
					 * Fires inside the display of a directory member item.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_directory_members_item' ); ?>

					<?php
					 /***
					  * If you want to show specific profile fields here you can,
					  * but it'll add an extra query for each member in the loop
					  * (only one regardless of the number of fields you show):
					  *
					  * bp_member_profile_data( 'field=the field name' );
					  */
					?>

				</div>

			</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( 'Sorry, no members were found.', 'aardvark' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' );
