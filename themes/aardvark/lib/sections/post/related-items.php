<?php

if ( isset( $GLOBALS['ghostpool_layout'] ) && ( $GLOBALS['ghostpool_layout'] == 'gp-no-sidebar' OR $GLOBALS['ghostpool_layout'] == 'gp-fullwidth' ) ) {
	$per_page = apply_filters( 'ghostpool_no_sidebar_related_posts_per_page', 4 );
} else {
	$per_page = apply_filters( 'ghostpool_sidebar_related_posts_per_page', 6 );
}

// Check for tags and categories
$related_tags = wp_get_post_tags( get_the_ID() );
$related_cats = wp_get_post_terms( get_the_ID(), 'category' );

if ( $related_tags ) {
	$related_type = 'tag__in';
	$related_items = $related_tags;
} elseif ( $related_cats ) {
	$related_type = 'category__in';
	$related_items = $related_cats;
} else {
	$related_type = '';
	$related_items = '';
}

$temp_query = $wp_query;

if ( $related_items ) {

	$related_ids = array();

	foreach ( $related_items as $related_item ) $related_ids[] = $related_item->term_id;
		
	$args = array(
		'post_type'           => array( 'post', 'page' ),
		'orderby'             => 'rand',
		'order'               => 'asc',
		'paged'               => 1,
		'posts_per_page'      => $per_page,
		'offset'              => 0,
		$related_type         => $related_ids,
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
		'no_found_rows' 	  => true,
	); 
	
	$args = apply_filters( 'ghostpool_related_items_query', $args, $related_type, $related_ids );

	$gp_query = new WP_Query( $args ); if ( $gp_query->have_posts() ) : 
		
		// Format class
		if ( isset( $GLOBALS['ghostpool_layout'] ) && ( $GLOBALS['ghostpool_layout'] == 'gp-no-sidebar' OR $GLOBALS['ghostpool_layout'] == 'gp-fullwidth' ) ) {
			$format = 'gp-posts-columns-4';
		} else {
			$format = 'gp-posts-columns-2';
		}
		
		// Get image dimensions
		global $_wp_additional_image_sizes;
		$image_size = apply_filters( 'ghostpool_related_image_size', 'gp_related_image' );
		if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
			$image_width  = get_option( "{$image_size}_size_w" );
			$image_height  = get_option( "{$image_size}_size_h" );			
		} else {
			$image_width = $_wp_additional_image_sizes[$image_size]['width'];
			$image_height = $_wp_additional_image_sizes[$image_size]['height'];
		}
	
		?>
	
		<div id="gp-related-wrapper" class="gp-posts-wrapper <?php echo esc_attr( $format ); ?>">

			<div class="gp-divider-title-bg">
				<div class="gp-divider-title"><?php esc_html_e( 'You May Also Like', 'aardvark' ); ?></div>
			</div>
			
			<div class="gp-section-loop">
			
				<div class="gp-section-loop-inner">

					<?php while ( $gp_query->have_posts() ) : $gp_query->the_post(); ?>

						<section <?php post_class( 'gp-post-item' ); ?>>
				
							<?php if ( has_post_thumbnail() && ( ! get_post_meta( get_the_ID(), 'gallery_slider', true ) ) ) { ?>
				
								<div class="gp-post-thumbnail gp-loop-featured">
									<a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>>
										<?php the_post_thumbnail( $image_size ); ?>
									</a>
								</div>
				
							<?php } elseif ( get_post_format() == 'gallery' ) { ?>
								
								<div class="gp-post-gallery gp-loop-featured">		
									<?php echo ghostpool_gallery_slider_loop_content( $image_size, $image_width, $image_height, $format ); ?>
								</div>
		
							<?php } elseif ( get_post_format() == 'video' ) { ?>
			
								<div class="gp-post-video gp-loop-featured">
									<?php echo ghostpool_video_loop_content( $image_width, $image_height, $format ); ?>
								</div>	
		
							<?php } ?>		

							<?php if ( get_post_format() == 'audio' ) { ?> 
								<div class="gp-post-audio gp-loop-featured">
									<?php get_template_part( 'lib/sections/taxonomies/loop-audio' ); ?>
								</div>	
							<?php } ?>
					
						
							<div class="gp-loop-content">

								<div class="gp-loop-title"><a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>><?php the_title(); ?></a></div>
																						
								<div class="gp-loop-meta">
									<time class="gp-post-meta gp-meta-date" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
								</div>	

							</div>
				
						</section>
		
					<?php endwhile; ?>
				
				</div>
								
			</div>	
				
		</div>

	<?php endif; wp_reset_postdata(); ?>

<?php } ?>