<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="group-dir-count-top">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-top">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_list' ); ?>

	<ul id="groups-list" class="gp-bp-wrapper gp-posts-masonry gp-columns-4 gp-style-classic gp-align-center" aria-live="assertive" aria-atomic="true" aria-relevant="all">
	
		<li class="gp-gutter-size"></li>

		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<li <?php bp_group_class( array( 'gp-post-item' ) ); ?>>
									
				<?php $cover_image_url = bp_attachments_get_attachment( 'url', array( 'object_dir' => 'groups', 'item_id' => bp_get_group_id() ) );
				if ( bp_group_use_cover_image_header() == '1' && $cover_image_url != '' ) { ?>
					<a href="<?php bp_group_permalink() ?>" class="gp-post-thumbnail" style="background-image: url(<?php echo esc_url( $cover_image_url ); ?>);">
						<span class="gp-bp-col-cover-overlay"><?php echo preg_replace( '/\D/', '', bp_get_group_member_count() ); ?></span>
						<?php if ( ! bp_disable_group_avatar_uploads() ) { ?>												
							<span class="gp-bp-col-avatar">
								<span class="gp-bp-hover-effect"></span>
								<?php bp_group_avatar_thumb(); ?>
							</span>
						<?php } ?>
					</a>
				<?php } ?>
			
				<div class="gp-loop-content<?php if ( $cover_image_url == '' ) { ?> gp-no-cover-image<?php } ?>">
			
					<?php if ( $cover_image_url == '' && ! bp_disable_group_avatar_uploads() ) { ?>									
						<span class="gp-bp-col-cover-overlay"><?php echo preg_replace( '/\D/', '', bp_get_group_member_count() ); ?></span>	
						<div class="gp-bp-col-avatar">
							<a href="<?php bp_group_permalink() ?>">							
								<span class="gp-bp-hover-effect"></span>
								<?php bp_group_avatar_thumb(); ?>
							</a>
						</div>
					<?php } ?>
								
					<div class="gp-loop-title"><?php bp_group_link(); ?></div>
						
					<div class="gp-loop-meta">
						<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>"><?php printf( esc_html__( 'active %s', 'aardvark' ), bp_get_group_last_active() ); ?></span>
					</div>								
	
					<div class="gp-loop-text">
						<?php bp_group_description_excerpt(); ?>
					</div>	

					<?php

					/**
					 * Fires inside the listing of an individual group listing item.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_directory_groups_item' ); ?>

					<div class="gp-bp-col-action">
			
						<div class="gp-bp-col-group-type"><?php bp_group_type(); ?></div>

						<?php

						/**
						 * Fires inside the action section of an individual group listing item.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_directory_groups_actions' ); ?>

					</div>
	
				</div>
						
			</li>

		<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the listing of the groups list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php esc_html_e( 'There were no groups found.', 'aardvark' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_groups_loop' );