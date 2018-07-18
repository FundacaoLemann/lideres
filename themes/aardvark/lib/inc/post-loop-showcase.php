<?php if ( ! function_exists( 'ghostpool_post_loop_showcase' ) ) {
	function ghostpool_post_loop_showcase( $style = '', $excerpt_length = '', $meta_author = '', $meta_date = '', $meta_comment_count = '', $meta_views = '', $meta_likes = '', $meta_cats = '', $meta_tags = '', $read_more_link = '', $counter = '', $ranking = '', $ranking_counter = '', $per_page = '', $post_count = '' ) { 
	
	// Format
	if ( $counter > 1 ) {
		$format = 'gp-posts-list';
	} else {
		$format = '';
	}
		
	// Default image sizes
	if ( $counter > 1 ) {
		$image_size = 'gp_small_image';
	} else {
		$image_size = 'gp_column_image';
	}

	// Get image dimensions
	global $_wp_additional_image_sizes;
	if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
		$image_width  = get_option( "{$image_size}_size_w" );
		$image_height  = get_option( "{$image_size}_size_h" );			
	} else {
		$image_width = $_wp_additional_image_sizes[$image_size]['width'];
		$image_height = $_wp_additional_image_sizes[$image_size]['height'];
	} 
								
	?>
	
		<?php if ( $counter % $per_page == 2 OR $counter == 2 ) { ?>
			</div>
			<div class="gp-small-posts">
		<?php } elseif ( $counter % $per_page == 1 OR $counter == 1 ) { ?>
			<div class="gp-large-post">
		<?php } ?>

			<section <?php post_class( 'gp-post-item' ); ?>>
	
				<?php if ( ( ! has_post_thumbnail() && get_post_format() != 'video' ) && $ranking == 'gp-ranking' ) { ?>
					<span class="gp-ranking-counter"><?php echo absint( $ranking_counter ); ?></span>
				<?php } ?>
			
				<?php if ( has_post_thumbnail() && ( ! get_post_meta( get_the_ID(), 'gallery_slider', true ) ) ) { ?>

					<div class="gp-post-thumbnail gp-loop-featured">
						<a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>>
							<?php if ( $ranking == 'gp-ranking' ) { ?>
								<span class="gp-ranking-counter"><?php echo absint( $ranking_counter ); ?></span>
							<?php } ?>
							<?php the_post_thumbnail( $image_size ); ?>
						</a>					
					</div>

				<?php } elseif ( get_post_format() == 'gallery' && get_post_meta( get_the_ID(), 'gallery_slider', true ) ) { ?>

					<div class="gp-post-gallery gp-loop-featured">
						<?php if ( $ranking == 'gp-ranking' && $ranking_counter > 0 ) { ?>
							<span class="gp-ranking-counter"><?php echo absint( $ranking_counter ); ?></span>
						<?php } ?>
						<?php echo ghostpool_gallery_slider_loop_content( $image_size, $image_width, $image_height, $format ); ?>
					</div>	

				<?php } elseif ( get_post_format() == 'video' ) { ?>
					
					<div class="gp-post-video gp-loop-featured"<?php if ( $format == 'gp-posts-list' ) { ?> style="width: <?php echo absint( $image_width ); ?>px;"<?php } ?>>
						<?php if ( $ranking == 'gp-ranking' && $ranking_counter > 0 ) { ?>
							<span class="gp-ranking-counter"><?php echo absint( $ranking_counter ); ?></span>
						<?php } ?>
						<?php echo ghostpool_video_loop_content( $image_width, $image_height, $format ); ?>
					</div>
		
				<?php } ?>

				<?php if ( get_post_format() == 'audio' && $counter == '1' ) { ?>
					<div class="gp-post-audio gp-loop-featured">
						<?php get_template_part( 'lib/sections/taxonomies/loop-audio' ); ?>
					</div>
				<?php } ?>
												
				<div class="gp-loop-content">	
				
					<?php if ( get_post_format() == 'audio' && $counter > '1' ) { ?>
						<div class="gp-post-audio gp-loop-featured">
							<?php get_template_part( 'lib/sections/taxonomies/loop-audio' ); ?>
						</div>
					<?php } ?>

					<h2 class="gp-loop-title"><a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>><?php the_title(); ?></a></h2>

					<?php if ( $style == 'gp-style-modern' ) {
						ghostpool_loop_meta( $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats ); 
					} ?>
				
					<?php if ( $excerpt_length != '0' ) { ?>
						<div class="gp-loop-text">
							<p><?php echo ghostpool_excerpt( $excerpt_length, $read_more_link ); ?></p>
						</div>
					<?php } ?>

					<?php if ( $style == 'gp-style-classic' ) {
						ghostpool_loop_meta( $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats ); 
					} ?>

					<?php if ( $meta_tags ) { the_tags( '<div class="gp-loop-tags">', ' ', '</div>' ); } ?>

				</div>

			</section>

		<?php if ( ( $counter % $per_page == 0 ) OR $counter == $post_count ) { ?>
			</div>
		<?php } ?>

	<?php }

} ?>