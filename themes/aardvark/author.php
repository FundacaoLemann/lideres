<?php get_header();

// Page options
$header = ghostpool_option( 'author_page_header' );
$format = ghostpool_option( 'author_format' );
$style = ghostpool_option( 'author_style' );
$alignment = ghostpool_option( 'author_alignment' );
$post_types = is_array( ghostpool_option( 'author_post_types' ) ) ? implode( ',', ghostpool_option( 'author_post_types' ) ) : ghostpool_option( 'author_post_types' );
$orderby = ghostpool_option( 'author_orderby' );
$per_page = ghostpool_option( 'author_per_page' );
$offset = ghostpool_option( 'author_offset' );
$image_size = ghostpool_option( 'author_image_size' );
$content_display = ghostpool_option( 'author_content_display' );
$excerpt_length = ghostpool_option( 'author_excerpt_length' );
$meta_author = ghostpool_option( 'author_meta', 'author' );
$meta_date = ghostpool_option( 'author_meta', 'date' );
$meta_comment_count = ghostpool_option( 'author_meta', 'comment_count' );
$meta_views = ghostpool_option( 'author_meta', 'views' );
$meta_likes = ghostpool_option( 'author_meta', 'likes' );
$meta_cats = ghostpool_option( 'author_meta', 'cats' );
$meta_tags = ghostpool_option( 'author_meta', 'tags' );
$read_more_link = ghostpool_option( 'author_read_more_link' );
$pagination = ghostpool_option( 'author_pagination' );

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

<?php ghostpool_page_header( 
	$post_id = '', 
	$type = $header,
	$bg = ghostpool_option( 'author_page_header_bg' ),
	$height = ghostpool_option( 'author_page_header_height', 'height' )
); ?>

<?php ghostpool_page_title( '', $header ); ?>

<div id="gp-content-wrapper" class="gp-container">

	<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>
		
	<div id="gp-inner-container">

		<div id="gp-content">

			<div class="<?php echo esc_attr( $css_classes ); ?>" data-type="author"<?php if ( function_exists( 'ghostpool_filter_variables' ) ) { echo ghostpool_filter_variables( '', '', $post_types, $format, $style, $orderby, $per_page, $offset, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $pagination ); } ?>>
				
				<?php ghostpool_filter( ghostpool_option( 'author_filters' ), '', $orderby, $pagination ); ?>
		
				<div class="gp-section-loop <?php echo sanitize_html_class( ghostpool_option( 'ajax' ) ); ?>">

					<?php if ( have_posts() ) : ?>
					
						<div class="gp-section-loop-inner">							
							<?php if ( $format == 'gp-posts-masonry' ) { ?><div class="gp-gutter-size"></div><?php } ?>							
							<?php while ( have_posts() ) : the_post(); ?>
								<?php if ( function_exists( 'ghostpool_post_loop' ) ) { ghostpool_post_loop( $format, $style, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link ); } ?>
							<?php endwhile; ?>
						</div>

						<?php echo ghostpool_pagination( $wp_query->max_num_pages, $pagination ); ?>

					<?php else : ?>

						<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark' ); ?></strong>

					<?php endif; ?>
				
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