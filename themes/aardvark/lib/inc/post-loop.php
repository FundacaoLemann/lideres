<?php if ( ! function_exists( 'ghostpool_post_loop' ) ) {
	function ghostpool_post_loop( $format = '', $style = '', $image_size = '', $content_display = '', $excerpt_length = '', $meta_author = '', $meta_date = '', $meta_comment_count = '', $meta_views = '', $meta_likes = '', $meta_cats = '', $meta_tags = '', $read_more_link = '', $counter = '', $ranking = '', $ranking_counter = '' ) {

		// Default image sizes	
		if ( $image_size != 'default' ) {
			$image_size = $image_size;	
		} else {				
			if ( $format == 'gp-posts-list' ) {
				$image_size = 'gp_list_image';
			} elseif ( $format == 'gp-posts-large' ) {
				$image_size = 'gp_featured_image';
			} else {
				$image_size = 'gp_column_image';
			}
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

		<section <?php post_class( 'gp-post-item' ); ?> itemscope itemtype="http://schema.org/Blog">

			<?php if ( ! has_post_thumbnail() && get_post_format() != 'video' && $ranking == 'gp-ranking' && $ranking_counter > 0 ) { ?>
				<span class="gp-ranking-counter"><?php echo absint( $ranking_counter ); ?></span>
			<?php } ?>	

			<?php if ( has_post_thumbnail() && ! get_post_meta( get_the_ID(), 'gallery_slider', true ) ) { ?>

				<div class="gp-post-thumbnail gp-loop-featured">
					<a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>>
						<?php if ( $ranking == 'gp-ranking' && $ranking_counter > 0 ) { ?>
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

			<?php if ( get_post_format() == 'audio' && $format != 'gp-posts-list' ) { ?>
				<div class="gp-post-audio gp-loop-featured">
					<?php get_template_part( 'lib/sections/taxonomies/loop-audio' ); ?>
				</div>
			<?php } ?>
		
			<div class="gp-loop-content">
		
				<?php if ( get_post_format() == 'audio' && $format == 'gp-posts-list' ) { ?>
					<div class="gp-post-audio">
						<?php get_template_part( 'lib/sections/taxonomies/loop-audio' ); ?>
					</div>	
				<?php } ?>
		
				<h2 class="gp-loop-title"><a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>><?php the_title(); ?></a></h2>

				<?php if ( $style == 'gp-style-modern' ) {
					ghostpool_loop_meta( $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats ); 
				} ?>
				
				<?php if ( $content_display == 'full_content' ) { ?>

					<div class="gp-loop-text">
						<?php global $more; $more = 0; the_content( esc_html__( 'Read More', 'aardvark' ) ); ?>
					</div>

				<?php } else { ?>

					<?php if ( $excerpt_length != '0' ) { ?>
						<div class="gp-loop-text">
							<p><?php echo ghostpool_excerpt( $excerpt_length, $read_more_link, $style ); ?></p>
						</div>
					<?php } ?>

				<?php } ?>	

				<?php if ( $style == 'gp-style-classic' ) {
					ghostpool_loop_meta( $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats ); 
				} ?>

				<?php if ( $meta_tags == '1' ) { the_tags( '<div class="gp-loop-tags">', ' ', '</div>' ); } ?>

			</div>	

		</section>

	<?php }

} ?>