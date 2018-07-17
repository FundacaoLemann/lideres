<?php
/*
Template Name: Blog
*/
get_header();

// Page options
$header = ghostpool_option( 'page_header' ) == 'default' ? ghostpool_option( 'page_page_header' ) : ghostpool_option( 'page_header' );
$height = ghostpool_option( 'page_header_height', 'padding-bottom' ) != '' ? ghostpool_option( 'page_header_height', 'padding-bottom' ) : ghostpool_option( 'page_page_header_height', 'height' );
$format = ghostpool_option( 'blog_format' );
$style = ghostpool_option( 'blog_style' );
$alignment = ghostpool_option( 'blog_alignment' );
$cats = ghostpool_option( 'blog_cats' ) ? implode( ',', ghostpool_option( 'blog_cats' ) ) : '';
$post_types = ghostpool_option( 'blog_post_types' ) ? implode( ',', ghostpool_option( 'blog_post_types' ) ) : ghostpool_option( 'blog_post_types' );
$orderby = ghostpool_option( 'blog_orderby' );
$per_page = ghostpool_option( 'blog_per_page' );
$offset = ghostpool_option( 'blog_offset' );
$image_size = ghostpool_option( 'blog_image_size' );
$content_display = ghostpool_option( 'blog_content_display' );	
$excerpt_length = ghostpool_option( 'blog_excerpt_length' );
$meta_author = ghostpool_option( 'blog_meta', 'author' );
$meta_date = ghostpool_option( 'blog_meta', 'date' );
$meta_comment_count = ghostpool_option( 'blog_meta', 'comment_count' );
$meta_views = ghostpool_option( 'blog_meta', 'views' );
$meta_likes = ghostpool_option( 'blog_meta', 'likes' );
$meta_cats = ghostpool_option( 'blog_meta', 'cats' );
$meta_tags = ghostpool_option( 'blog_meta', 'tags' );
$read_more_link = ghostpool_option( 'blog_read_more_link' );
$pagination = 'page-numbers';

?>

<?php ghostpool_page_header( get_the_ID(), $header, ghostpool_option( 'page_header_bg' ), $height ); ?>

<?php ghostpool_page_title( get_the_ID(), $header ); ?>

<div id="gp-content-wrapper" class="gp-container">

	<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>
	
	<div id="gp-inner-container">
	
		<div id="gp-content">
	
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
									
				<?php the_content(); ?>
	
			<?php endwhile; endif; rewind_posts(); ?>	

			<?php $args = array(
				'post_status' 	      => 'publish',
				'post_type'           => ghostpool_option( 'blog_post_types' ),
				ghostpool_cats( ghostpool_option( 'blog_cats' ), 'param' ) => ghostpool_cats( ghostpool_option( 'blog_cats' ), 'variables' ),
				'orderby'             => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'orderby' ),
				'order'               => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'order' ),
				'meta_key'            => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'meta_key' ),
				'meta_query' 		  => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'meta_query' ),
				'posts_per_page'      => ghostpool_option( 'blog_per_page' ),
				'paged'          	  => ghostpool_paged(),
			);

			$args = apply_filters( 'ghostpool_blog_query', $args );

			$gp_query = new WP_Query( $args );
	
			// Classes
			$css_classes = array(
				'gp-posts-wrapper',
				'gp-archive-wrapper',
				$format,
				$style,
				$alignment,
			);
			$css_classes = trim( implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
			
			?>
		
			<div class="<?php echo esc_attr( $css_classes ); ?>" data-type="blog-template"<?php if ( function_exists( 'ghostpool_filter_variables' ) ) { echo ghostpool_filter_variables( '', $cats, $post_types, $format, $style, $orderby, $per_page, $offset, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $pagination ); } ?>>
			
					<?php ghostpool_filter( ghostpool_option( 'blog_filters' ), ghostpool_option( 'blog_filter_cat_id' ), $orderby, 'page-numbers' ); ?>
													
					<div class="gp-section-loop <?php echo sanitize_html_class( ghostpool_option( 'ajax' ) ); ?>">
						
						<?php if ( $gp_query->have_posts() ) : ?>
						
							<div class="gp-section-loop-inner">								
								<?php if ( ghostpool_option( 'blog_format' ) == 'gp-posts-masonry' ) { ?><div class="gp-gutter-size"></div><?php } ?>					
								<?php while ( $gp_query->have_posts() ) : $gp_query->the_post(); ?>
									<?php if ( function_exists( 'ghostpool_post_loop' ) ) { ghostpool_post_loop( $format, $style, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link ); } ?>
								<?php endwhile; ?>
							</div>
						
							<?php echo ghostpool_pagination( $gp_query->max_num_pages, 'page-numbers' ); ?>
					
					<?php else : ?>

						<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark' ); ?></strong>

					<?php endif; wp_reset_postdata(); ?>
					
				</div>	
		
			</div>

		</div>

		<?php get_sidebar( 'left' ); ?>
	
		<?php get_sidebar( 'right' ); ?>

	</div>

	<?php do_action( 'ghostpool_end_content_wrapper' ); ?>
			
	<div class="gp-clear"></div>

</div>

<?php get_footer(); ?>