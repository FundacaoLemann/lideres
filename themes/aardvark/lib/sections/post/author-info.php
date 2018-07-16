<?php 

// Profile fields
$bp_bio = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Bio', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$bio = get_the_author_meta( 'description' );
$bp_twitter = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Twitter', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$twitter = get_the_author_meta( 'twitter' );
$bp_facebook = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Facebook', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$facebook = get_the_author_meta( 'facebook' );
$bp_googleplus = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Google+', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$googleplus = get_the_author_meta( 'googleplus' );
$bp_pinterest = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Pinterest', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$pinterest = get_the_author_meta( 'pinterest' );
$bp_youtube = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'YouTube', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$youtube = get_the_author_meta( 'youtube' );
$bp_vimeo = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Vimeo', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$vimeo = get_the_author_meta( 'vimeo' );
$bp_flickr = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Flickr', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$flickr = get_the_author_meta( 'flickr' );
$bp_linkedin = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'LinkedIn', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$linkedin = get_the_author_meta( 'linkedin' );
$bp_instagram = function_exists( 'bp_get_profile_field_data' ) ? bp_get_profile_field_data( array( 'field' => 'Instagram', 'user_id' => get_the_author_meta( 'ID' ) ) ) : '';
$instagram = get_the_author_meta( 'instagram' );
		
if ( $bp_bio OR $bio ) { ?>

	<div id="gp-author-info-wrapper">
	
		<div class="gp-divider-title">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 85 ); ?> 
			<div id="gp-author-name">
				<?php esc_html_e( 'Written by', 'aardvark' ); ?> <?php echo ghostpool_author_name( get_the_ID() ); ?>
			</div>
		</div>	

		<div id="gp-author-details">

			<div id="gp-author-social-icons">
	
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

			<div id="gp-author-desc">
				<?php if ( $bp_bio ) {
					echo esc_attr( $bp_bio );
				} else {
					echo esc_attr( $bio );
				} ?>
			</div>
		</div>

	</div>
	
<?php } ?>