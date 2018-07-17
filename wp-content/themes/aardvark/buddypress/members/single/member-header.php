<?php
/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
?>

<?php
/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' ); ?>

<div id="item-header-avatar">
	<a href="<?php bp_displayed_user_link(); ?>">
		<?php echo ghostpool_is_user_online( bp_displayed_user_id(), bp_get_last_activity( bp_displayed_user_id() ) ) ?>
		<?php bp_displayed_user_avatar( 'type=full' ); ?>
	</a>
</div>

<div id="item-header-content">

	<div class="gp-bp-header-title"><?php echo bp_core_get_user_displayname( bp_displayed_user_id() ); ?></div>
								
	<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
		<h2 class="gp-bp-header-highlight user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
	<?php endif; ?>
	
	<span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_user_last_activity( bp_displayed_user_id() ) ); ?>"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>
	
	<?php do_action( 'bp_before_member_header_meta' ); ?>
		
	<?php if ( bp_is_active( 'activity' ) ) : ?>
		<div class="gp-bp-header-desc">
			<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>
		</div>
	<?php endif; ?>

	<div class="gp-bp-header-actions">
		<?php do_action( 'bp_member_header_actions' ); ?>
	</div>

	<?php do_action( 'bp_profile_header_meta' ); /* Display custom profile fields */ ?>

	<div id="gp-author-social-icons">
	
		<?php 
		
		// Profile fields
		$bp_twitter = bp_get_profile_field_data( array( 'field' => 'Twitter' ) );
		$twitter = get_the_author_meta( 'twitter', bp_displayed_user_id() );
		$bp_facebook = bp_get_profile_field_data( array( 'field' => 'Facebook' ) );
		$facebook = get_the_author_meta( 'facebook', bp_displayed_user_id() );
		$bp_googleplus = bp_get_profile_field_data( array( 'field' => 'Google+' ) );
		$googleplus = get_the_author_meta( 'googleplus', bp_displayed_user_id() );
		$bp_pinterest = bp_get_profile_field_data( array( 'field' => 'Pinterest' ) );
		$pinterest = get_the_author_meta( 'pinterest', bp_displayed_user_id() );
		$bp_youtube = bp_get_profile_field_data( array( 'field' => 'YouTube' ) );
		$youtube = get_the_author_meta( 'youtube', bp_displayed_user_id() );
		$bp_vimeo = bp_get_profile_field_data( array( 'field' => 'Vimeo' ) );
		$vimeo = get_the_author_meta( 'vimeo', bp_displayed_user_id() );
		$bp_flickr = bp_get_profile_field_data( array( 'field' => 'Flickr' ) );
		$flickr = get_the_author_meta( 'flickr', bp_displayed_user_id() );
		$bp_linkedin = bp_get_profile_field_data( array( 'field' => 'LinkedIn' ) );
		$linkedin = get_the_author_meta( 'linkedin', bp_displayed_user_id() );
		$bp_instagram = bp_get_profile_field_data( array( 'field' => 'Instagram' ) );
		$instagram = get_the_author_meta( 'instagram', bp_displayed_user_id() );
		
		?>
	
		<?php if ( $bp_twitter ) { ?><a href="<?php echo esc_url( $bp_twitter ); ?>" class="gp-twitter-icon"></a><?php } elseif ( $twitter ) { ?><a href="<?php echo esc_url( $twitter ); ?>" class="gp-twitter-icon"></a><?php } ?>

		<?php if ( $bp_facebook ) { ?><a href="<?php echo esc_url( $bp_facebook ); ?>" class="gp-facebook-icon"></a><?php } elseif ( $facebook ) { ?><a href="<?php echo esc_url( $facebook ); ?>" class="gp-facebook-icon"></a><?php } ?>

		<?php if ( $bp_googleplus ) { ?><a href="<?php echo esc_url( $bp_googleplus ); ?>" class="gp-google-plus-icon"></a><?php } elseif ( $googleplus ) { ?><a href="<?php echo esc_url( $googleplus ); ?>" class="gp-google-plus-icon"></a><?php } ?>

		<?php if ( $bp_pinterest ) { ?><a href="<?php echo esc_url( $bp_pinterest ); ?>" class="gp-pinterest-icon"></a><?php } elseif ( $pinterest ) { ?><a href="<?php echo esc_url( $pinterest ); ?>" class="gp-pinterest-icon"></a><?php } ?>

		<?php if ( $bp_youtube ) { ?><a href="<?php echo esc_url( $bp_youtube ); ?>" class="gp-youtube-icon"></a><?php } elseif ( $youtube ) { ?><a href="<?php echo esc_url( $youtube ); ?>" class="gp-youtube-icon"></a><?php } ?>

		<?php if ( $bp_vimeo ) { ?><a href="<?php echo esc_url( $bp_vimeo ); ?>" class="gp-vimeo-icon"></a><?php } elseif ( $vimeo ) { ?><a href="<?php echo esc_url( $vimeo ); ?>" class="gp-vimeo-icon"></a><?php } ?>

		<?php if ( $bp_flickr ) { ?><a href="<?php echo esc_url( $bp_flickr ); ?>" class="gp-flickr-icon"></a><?php } elseif ( $flickr ) { ?><a href="<?php echo esc_url( $flickr ); ?>" class="gp-flickr-icon"></a><?php } ?>

		<?php if ( $bp_linkedin ) { ?><a href="<?php echo esc_url( $bp_linkedin ); ?>" class="gp-linkedin-icon"></a><?php } elseif ( $linkedin ) { ?><a href="<?php echo esc_url( $linkedin ); ?>" class="gp-linkedin-icon"></a><?php } ?>

		<?php if ( $bp_instagram ) { ?><a href="<?php echo esc_url( $bp_instagram ); ?>" class="gp-instagram-icon"></a><?php } elseif ( $instagram ) { ?><a href="<?php echo esc_url( $instagram ); ?>" class="gp-instagram-icon"></a><?php } ?>

	</div>
			
	<?php
	/**
	 * Fires after the display of a member's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_header' ); ?>

	<div id="template-notices" role="alert" aria-atomic="true">
		<?php
		/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
		do_action( 'template_notices' ); ?>

	</div>
									
</div>