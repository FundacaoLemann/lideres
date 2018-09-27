<?php
defined( 'ABSPATH' ) || exit;

function ghostpool_carousel_posts( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(
				'widget_title'           => '',
				'cats'                   => '',
				'page_ids'               => '',
				'post_types'             => 'post',
				'style'                  => 'gp-style-classic',
				'alignment'              => 'gp-align-left',
				'orderby'                => 'newest',
				'items_in_view'          => '3',
				'per_page'               => '12',
				'offset'                 => '',
				'image_size'             => 'gp_column_image',
				'slider_speed'           => '0',
				'animation_speed'        => '0.6',
				'buttons'                => 'enabled',
				'arrows'                 => 'enabled',
				'classes'                => '',
				'css'                    => '',
				'icon_color'             => '',
				'icon'                   => '',
				'title_color'            => '',
				'post_title_color'       => '',
				'post_title_hover_color' => '',
				'post_link_color'        => '',
				'post_link_hover_color'  => '',
				'post_text_color'        => '',
				'meta_text_color'        => '',
			),
			$atts
		)
	);

	// Unique Name
	static $i = 0;
	$i++;
	$name = 'gp_carousel_posts_wrapper_' . $i;

	// CSS Editor
	$css_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $classes . vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

	// Add CSS styling to header
	if ( function_exists( 'ghostpool_posts_css' ) ) {
		ghostpool_posts_css( $name, $title_color, $icon_color, $post_title_color, $post_title_hover_color, $post_link_color, $post_link_hover_color, $post_text_color, $meta_text_color );
	}

	// Get image dimensions
	global $_wp_additional_image_sizes;
	if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
		$image_width  = get_option( "{$image_size}_size_w" );
		$image_height = get_option( "{$image_size}_size_h" );
	} else {
		$image_width  = $_wp_additional_image_sizes[ $image_size ]['width'];
		$image_height = $_wp_additional_image_sizes[ $image_size ]['height'];
	}

	$args = array(
		'post_status'                    => 'publish',
		'post_type'                      => $post_types ? explode( ',', $post_types ) : '',
		'post__in'                       => $page_ids ? explode( ',', $page_ids ) : '',
		ghostpool_cats( $cats, 'param' ) => ghostpool_cats( $cats, 'variables' ),
		'orderby'                        => ghostpool_orderby( $orderby, 'orderby' ),
		'order'                          => ghostpool_orderby( $orderby, 'order' ),
		'meta_key'                       => ghostpool_orderby( $orderby, 'meta_key' ),
		'meta_query'                     => ghostpool_orderby( $orderby, 'meta_query' ),
		'posts_per_page'                 => $per_page,
		'offset'                         => $offset,
		'paged'                          => 1,
		'no_found_rows'                  => true,
		'ignore_sticky_posts'            => 1,
	);

	$args = apply_filters( 'ghostpool_carousel_posts_element_query', $args, $post_types, $page_ids, $cats, $orderby, $per_page, $offset );

	$is_vagas_slider = ( 'job_listing' == current( $args['post_type'] ) );

	$gp_query = new WP_Query( $args );

	// Classes
	$css_classes = array(
		'gp-carousel-wrapper',
		'gp-slider',
		$style,
		$alignment,
		$classes,
	);
	$css_classes = trim( implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
	$css_classes = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_classes . vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

	ob_start(); ?>

	<div id="<?php echo sanitize_html_class( $name ); ?>" class="<?php echo esc_attr( $css_classes ); ?>">

		<div class="gp-widget-title">
			<?php
			if ( $icon ) {
				?>
				<i class="gp-element-icon <?php echo esc_attr( $icon ); ?>"></i><?php } ?>
			<?php
			if ( $widget_title ) {
				?>
				<h3 class="widgettitle"><?php echo esc_attr( $widget_title ); ?></h3><?php } ?>
		</div>

		<?php if ( $gp_query->have_posts() ) : ?>

			<ul class="slides">

				<?php
				while ( $gp_query->have_posts() ) :
					$gp_query->the_post();

					if ( $is_vagas_slider ) {
						get_template_part( 'job_manager/content-job_listing' );
					} else {
						?>

						<li>

							<section <?php post_class( 'gp-post-item' ); ?> itemscope itemtype="http://schema.org/Blog">

								<?php if ( has_post_thumbnail() ) { ?>

									<div class="gp-post-thumbnail gp-loop-featured">
										<a href="
										<?php
										if ( get_post_format() == 'link' ) {
											echo esc_url( get_post_meta( get_the_ID(), 'link', true ) );
										} else {
											the_permalink(); }
										?>
										" title="<?php the_title_attribute(); ?>"
											<?php
											if ( get_post_format() == 'link' ) {
												?>
		target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>>
											<?php the_post_thumbnail( $image_size ); ?>
										</a>
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

									<h2 class="gp-loop-title"><a href="
									<?php
									if ( get_post_format() == 'link' ) {
										echo esc_url( get_post_meta( get_the_ID(), 'link', true ) );
									} else {
										the_permalink(); }
									?>
									" title="<?php the_title_attribute(); ?>"
											<?php
											if ( get_post_format() == 'link' ) {
												?>
		target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>><?php the_title(); ?></a></h2>

									<div class="gp-loop-meta">
										<time class="gp-post-meta gp-meta-date" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
									</div>

								</div>

							</section>

						</li>

						<?php
					}

				endwhile;
				?>

			</ul>

			<script>
			jQuery( document ).ready( function( $ ) {

				'use strict';

				var $window = $(window),
					flexslider = { vars:{} };

				function getGridSize() {
					return ( $window.width() <= 567 ) ? 1 : ( $window.width() <= 1023 ) ?
					<?php
					if ( $items_in_view == 1 ) {
						?>
						1
						<?php
					} else {
						?>
						2<?php } ?> : <?php echo esc_js( $items_in_view ); ?>;
				}

				if ( $( 'body' ).hasClass( 'gp-theme' ) ) {

					$window.load(function() {
						$( '#<?php echo esc_js( $name ); ?>' ).flexslider({
							animation: 'slide',
							animationLoop: false,
							itemWidth: 537,
							itemMargin: 30,
							slideshowSpeed:
							<?php
							if ( $slider_speed != '0' ) {
								echo esc_js( $slider_speed ) * 1000;
							} else {
								echo '9999999'; }
							?>
							,
							animationSpeed: <?php echo esc_js( $animation_speed * 1000 ); ?>,
							directionNav:
							<?php
							if ( $arrows == 'enabled' ) {
								?>
								true
								<?php
							} else {
								?>
								false<?php } ?>,
							controlNav:
							<?php
							if ( $buttons == 'enabled' ) {
								?>
								true
								<?php
							} else {
								?>
								false<?php } ?>,
							pauseOnAction: true,
							pauseOnHover: false,
							prevText: '',
							nextText: '',
							minItems: getGridSize(),
							maxItems: getGridSize(),
							start: function(slider){
								flexslider = slider;
							}
						});
					});

					$window.resize( function() {
						var gridSize = getGridSize();
						flexslider.vars.minItems = gridSize;
						flexslider.vars.maxItems = gridSize;
					});

				}

			});
			</script>

		<?php else : ?>

			<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark-plugin' ); ?></strong>

		<?php
		endif;
wp_reset_postdata();
?>

	</div>

	<?php

	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
