<?php
defined( 'ABSPATH' ) || exit;

/**
 * Declarando aqui para proder sobrescrever os formatos.
 */
function ghostpool_wpb_featured_box_options() {
	vc_map(
		array(
			'name'        => esc_html__( 'Featured Box', 'aardvark' ),
			'base'        => 'gp_featured_box',
			'description' => esc_html__( 'Featured box.', 'aardvark' ),
			'class'       => 'wpb_vc_featured_box',
			'controls'    => 'full',
			'icon'        => 'gp-icon-featured-box',
			'category'    => esc_html__( 'Theme', 'aardvark' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Categories', 'aardvark' ),
					'description' => esc_html__( 'Enter the slugs or IDs separating each one with a comma e.g. xbox,ps3,pc.', 'aardvark' ),
					'param_name'  => 'cats',
					'type'        => 'textfield',
				),
				array(
					'heading'     => esc_html__( 'Page IDs', 'aardvark' ),
					'description' => esc_html__( 'Enter the IDs of the pages you want to include, separating each with a comma e.g. 48,142.', 'aardvark' ),
					'param_name'  => 'page_ids',
					'type'        => 'textfield',
				),
				array(
					'heading'    => esc_html__( 'Post Types', 'aardvark' ),
					'param_name' => 'post_types',
					'type'       => 'posttypes',
					'value'      => 'post',
				),
				array(
					'heading'     => esc_html__( 'Format', 'aardvark' ),
					'param_name'  => 'format',
					'value'       => array(
						esc_html__( '4 Columns (2-2-2-2)', 'aardvark' ) => 'gp-featured-box-2-2-2-2',
						esc_html__( '3 Columns (2-1-2)', 'aardvark' ) => 'gp-featured-box-2-1-2',
						esc_html__( '3 Columns (1-2-2)', 'aardvark' ) => 'gp-featured-box-1-2-2',
						esc_html__( '2 Columns (1-2)', 'aardvark' ) => 'gp-featured-box-1-2',
						esc_html__( '2 Columns (1-1)', 'aardvark' ) => 'gp-featured-box-1-1',
						esc_html__( '1 Column (1)', 'aardvark' ) => 'gp-featured-box-1',
					),
					'type'        => 'dropdown',
					'admin_label' => true,
				),
				array(
					'heading'    => esc_html__( 'Layout', 'aardvark' ),
					'param_name' => 'layout',
					'value'      => array(
						esc_html__( 'Wide', 'aardvark' )  => 'gp-wide',
						esc_html__( 'Boxed', 'aardvark' ) => 'gp-boxed',
					),
					'type'       => 'dropdown',
				),
				array(
					'heading'     => esc_html__( 'Spacing (px)', 'aardvark' ),
					'description' => esc_html__( 'The spacing between each item.', 'aardvark' ),
					'param_name'  => 'spacing',
					'value'       => '0',
					'type'        => 'textfield',
				),
				array(
					'heading'    => esc_html__( 'Order By', 'aardvark' ),
					'param_name' => 'orderby',
					'value'      => array(
						esc_html__( 'Newest', 'aardvark' ) => 'newest',
						esc_html__( 'Oldest', 'aardvark' ) => 'oldest',
						esc_html__( 'Title (A-Z)', 'aardvark' ) => 'title_az',
						esc_html__( 'Title (Z-A)', 'aardvark' ) => 'title_za',
						esc_html__( 'Most Comments', 'aardvark' ) => 'comment_count',
						esc_html__( 'Most Views', 'aardvark' ) => 'views',
						esc_html__( 'Most Likes', 'aardvark' ) => 'likes',
						esc_html__( 'Menu Order', 'aardvark' ) => 'menu_order',
						esc_html__( 'Random', 'aardvark' ) => 'rand',
					),
					'type'       => 'dropdown',
				),
				array(
					'heading'     => esc_html__( 'Offset', 'aardvark' ),
					'description' => esc_html__( 'E.g. set to 3 to exclude the first 3 posts.', 'aardvark' ),
					'param_name'  => 'offset',
					'value'       => '',
					'type'        => 'textfield',
				),
				array(
					'heading'    => esc_html__( 'Title', 'aardvark' ),
					'param_name' => 'title',
					'value'      => array(
						esc_html__( 'Enabled', 'aardvark' ) => 'enabled',
						esc_html__( 'Disabled', 'aardvark' ) => 'disabled',
					),
					'type'       => 'dropdown',
				),
				array(
					'heading'     => esc_html__( 'Title Length', 'aardvark' ),
					'description' => esc_html__( 'The number of characters in caption titles (set to 0 to set no limit).', 'aardvark' ),
					'param_name'  => 'title_length',
					'value'       => '0',
					'type'        => 'textfield',
					'dependency'  => array(
						'element' => 'title',
						'value'   => 'enabled',
					),
				),
				array(
					'heading'     => esc_html__( 'Excerpt Length', 'aardvark' ),
					'description' => esc_html__( 'The number of characters in excerpts.', 'aardvark' ),
					'param_name'  => 'excerpt_length',
					'value'       => '0',
					'type'        => 'textfield',
				),
				array(
					'heading'    => esc_html__( 'Post Meta', 'aardvark' ),
					'param_name' => 'meta_author',
					'value'      => array( esc_html__( 'Author Name', 'aardvark' ) => '1' ),
					'type'       => 'checkbox',
				),
				array(
					'param_name' => 'meta_date',
					'value'      => array( esc_html__( 'Post Date', 'aardvark' ) => '1' ),
					'type'       => 'checkbox',
				),
				array(
					'param_name' => 'meta_comment_count',
					'value'      => array( esc_html__( 'Comment Count', 'aardvark' ) => '1' ),
					'type'       => 'checkbox',
				),
				array(
					'param_name' => 'meta_views',
					'value'      => array( esc_html__( 'Views', 'aardvark' ) => '1' ),
					'type'       => 'checkbox',
				),
				array(
					'param_name' => 'meta_likes',
					'value'      => array( esc_html__( 'Likes', 'aardvark' ) => '1' ),
					'type'       => 'checkbox',
				),
				array(
					'param_name' => 'meta_cats',
					'value'      => array( esc_html__( 'Post Categories', 'aardvark' ) => '1' ),
					'type'       => 'checkbox',
				),
				array(
					'heading'     => esc_html__( 'Extra Class Name', 'aardvark' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'aardvark' ),
					'param_name'  => 'classes',
					'value'       => '',
					'type'        => 'textfield',
				),
				array(
					'heading'    => esc_html__( 'CSS', 'aardvark' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'aardvark' ),
				),

			),
		)
	);
}

/**
 * Altera os argumentos da query WP quando o nosso formato está sendo usado.
 *
 * @param array $args Argumentos que serão passados para a WP_Query da Featured Box.
 * @return array
 */
function lemann_featured_box_element_query( $args ) {
	global $format;
	if ( 'gp-featured-box-1-2' == $format ) {
		$args['posts_per_page'] = 3;
	}
	return $args;
}
add_filter( 'ghostpool_featured_box_element_query', 'lemann_featured_box_element_query' );

function ghostpool_featured_box_css( $name = '', $spacing = 0, $layout = 'gp-wide' ) {
	global $format;

	$custom_css = '';

	if ( $spacing ) {
		$spacing = str_replace( 'px', '', $spacing );
	} else {
		$spacing = 0;
	}

	$extra_widths = 0;
	$extra_width  = 0;

	if ( ghostpool_option( 'theme_layout' ) == 'gp-wide-layout' ) {
		$extra_width += 30;
	} else {
		$extra_width += 0;
	}

	if ( $layout == 'gp-wide' ) {
		$extra_width += 30;
	} else {
		$extra_width += 0;
	}

	$extra_widths = $extra_width;

	$custom_css .= '
	#' . sanitize_html_class( $name ) . ' .gp-featured-caption {
		left:' . $spacing . 'px;
		bottom:' . $spacing . 'px;
	}
	#' . sanitize_html_class( $name ) . ' .gp-featured-large,
	#' . sanitize_html_class( $name ) . ' .gp-featured-small {
		padding:' . $spacing . 'px;
	}
	#' . sanitize_html_class( $name ) . ' .gp-featured-small {
		width: ' . ( 250 - ( $spacing * 2 ) ) . 'px;
		height: ' . ( 200 - $spacing ) . 'px;
	}
	#' . sanitize_html_class( $name ) . ' .gp-featured-box-scroll {
		margin-top:' . ( $spacing * 2 ) . 'px;
		margin-left:' . $spacing . 'px;
		margin-right:-' . $spacing . 'px;
	}
	#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-box-scroll {
		margin-right:-' . ( $spacing + 30 ) . 'px;
	}
	#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-box-scroll .gp-col-1 .gp-featured-small:first-child{
		margin-left:-' . $spacing . 'px;
	}

	@media only screen and (max-width : 767px) {
		#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-large,
		#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-box-scroll {
			width: calc(100% + 30px);
		}
	}';

	// Se está no nosso formato acrescenta à largura principal
	// a largura de uma coluna pequena.
	if ( 'gp-featured-box-1-2' == $format ) {
		$col_width_768  = 339 + 169.5;
		$col_width_992  = 455 + 227.5;
		$col_width_1200 = 540 + 270;
		$col_width_1470 = 570 + 285;
	} else {
		$col_width_768  = 339;
		$col_width_992  = 455;
		$col_width_1200 = 540;
		$col_width_1470 = 570;
	}

	$custom_css .= '
	@media only screen and (min-width : 768px) {
		#' . sanitize_html_class( $name ) . ' .gp-featured-large-col {
			width: ' . ( $col_width_768 + $extra_widths ) . 'px;
			height: 294px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small-col {
			width: ' . ( ( 169.5 + ( $extra_widths / 2 ) ) - ( $spacing * 2 ) ) . 'px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small {
			height: ' . ( 147 - $spacing ) . 'px;
		}
	}

	@media only screen and (min-width : 992px) {
		#' . sanitize_html_class( $name ) . ' .gp-featured-large-col {
			width: ' . ( $col_width_992 + $extra_widths ) . 'px;
			height: 388px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small-col {
			width: ' . ( ( 227.5 + ( $extra_widths / 2 ) ) - ( $spacing * 2 ) ) . 'px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small {
			height: ' . ( 194 - $spacing ) . 'px;
		}
	}

	@media only screen and (min-width : 1200px) {
		#' . sanitize_html_class( $name ) . ' .gp-featured-large-col {
			width: ' . ( $col_width_1200 + $extra_widths ) . 'px;
			height: 456px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small-col {
			width: ' . ( ( 270 + ( $extra_widths / 2 ) ) - ( $spacing * 2 ) ) . 'px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small {
			height: ' . ( 228 - $spacing ) . 'px;
		}
	}

	@media only screen and (min-width : 1470px) {
		#' . sanitize_html_class( $name ) . ' .gp-featured-large-col {
			width: ' . ( $col_width_1470 + $extra_widths ) . 'px;
			height: 480px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small-col {
			width: ' . ( 285 + ( $extra_widths / 2 ) ) . 'px;
		}
		#' . sanitize_html_class( $name ) . ' .gp-featured-small {
			height: 240px;
		}
	}';

	echo '<style>' . $custom_css . '</style>';

}
