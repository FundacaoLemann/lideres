<?php get_header();

// Get category options
$term_data = null;
if ( isset( get_queried_object()->term_id ) ) {
	$term_id = get_queried_object()->term_id;
	$term_data = get_option( "taxonomy_$term_id" );
}

// Page options
$header = ! isset( $term_data['page_header'] ) || $term_data['page_header'] == 'default' ? ghostpool_option( 'cat_page_header' ) : $term_data['page_header'];
$format = ! isset( $term_data['format'] ) || $term_data['format'] == 'default' ? ghostpool_option( 'cat_format' ) : $term_data['format'];
$style = ! isset( $term_data['style'] ) || $term_data['style'] == 'default' ? ghostpool_option( 'cat_style' ) : $term_data['style'];
$alignment = ! isset( $term_data['alignment'] ) || $term_data['alignment'] == 'default' ? ghostpool_option( 'cat_alignment' ) : $term_data['alignment'];
$orderby = ghostpool_option( 'cat_orderby' );
$per_page = ghostpool_option( 'cat_per_page' );
$offset = ghostpool_option( 'cat_offset' );
$image_size = ghostpool_option( 'cat_image_size' );
$content_display = ghostpool_option( 'cat_content_display' );	
$excerpt_length = ghostpool_option( 'cat_excerpt_length' );	
$meta_author = ghostpool_option( 'cat_meta', 'author' );
$meta_date = ghostpool_option( 'cat_meta', 'date' );
$meta_comment_count = ghostpool_option( 'cat_meta', 'comment_count' );
$meta_views = ghostpool_option( 'cat_meta', 'views' );
$meta_likes = ghostpool_option( 'cat_meta', 'likes' );
$meta_cats = ghostpool_option( 'cat_meta', 'cats' );
$meta_tags = ghostpool_option( 'cat_meta', 'tags' );
$read_more_link = ghostpool_option( 'cat_read_more_link' );
$pagination = ghostpool_option( 'cat_pagination' );

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
	$bg = isset( $term_data['page_header_bg'] ) ? $term_data['page_header_bg'] : '',
	$height = ghostpool_option( 'cat_page_header_height', 'height' )
); ?>

<?php ghostpool_page_title( '', $header ); ?>

<div id="gp-content-wrapper" class="gp-container">

	<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

	<div id="gp-inner-container">

		<div id="gp-content">

			<div class="<?php echo esc_attr( $css_classes ); ?>" data-type="<?php if ( is_home() ) { ?>home<?php } else { ?>taxonomy<?php } ?>"<?php if ( function_exists( 'ghostpool_filter_variables' ) ) { echo ghostpool_filter_variables( '', '', '', $format, $style, $orderby, $per_page, $offset, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $pagination ); } ?>>

				<?php ghostpool_filter( ghostpool_option( 'cat_filters' ), '', $orderby, $pagination ); ?>
									
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