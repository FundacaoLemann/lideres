<?php

/**
* Override default page builder settings
*
*/
if ( ! class_exists( 'ghostpool_page_builder_functions' ) ) {
	function ghostpool_page_builder_functions() {
		vc_set_as_theme(); // Disable design options
		vc_set_default_editor_post_types( array( 'page' ) ); // Check VC post type checkboxes by default
	}				
}				
add_action( 'vc_before_init', 'ghostpool_page_builder_functions', 9 );

/**
 * Disable activation redirect
 *
 */
remove_action( 'admin_init', 'vc_page_welcome_redirect' );

/**
* Remove Visual Composer activation notice
*
*/
setcookie( 'vchideactivationmsg', '1', strtotime( '+3 years' ), '/' );
setcookie( 'vchideactivationmsg_vc11', ( defined( 'WPB_VC_VERSION' ) ? WPB_VC_VERSION : '1' ), strtotime( '+3 years' ), '/' );
	
/**
 * Load page builder styles and scripts
 *
 */
if ( ! function_exists( 'ghostpool_page_builder_enqueue' ) ) {
	function ghostpool_page_builder_enqueue() {
		wp_enqueue_script( 'ghostpool-page-builder', get_template_directory_uri() . '/lib/framework/page-builder/assets/page-builder.js', array( 'jquery' ), '', true );			
	}
}
add_action( 'admin_enqueue_scripts', 'ghostpool_page_builder_enqueue' );
	
/**
* Load custom options for default elements
*
*/
require_once( get_template_directory() . '/lib/framework/page-builder/page-builder-custom-options.php' );

/**
* Load custom element options
*
*/
require_once( get_template_directory() . '/lib/framework/page-builder/bp-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/bp-profile-search-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/carousel-posts-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/carousel-images-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/events-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/events-calendar-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/featured-box-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/login-register-form-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/particles-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/pmp-register-form-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/posts-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/post-submission-form-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/pricing-column-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/sensei-courses-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/showcase-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/statistics-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/team-options.php' );
require_once( get_template_directory() . '/lib/framework/page-builder/testimonial-slider-options.php' );
			
/**
* Remove WPB page builder lightbox
*
*/	
if ( ! function_exists( 'ghostpool_remove_wpb_lightbox' ) ) {	
	function ghostpool_remove_wpb_lightbox(){
		wp_enqueue_script( 'prettyphoto' );
		wp_deregister_script( 'prettyphoto' );
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_remove_wpb_lightbox', 100 );
			
/**
* Custom image size field
*
*/	
if ( ! function_exists( 'ghostpool_wpb_image_size_field' ) ) {	
	function ghostpool_wpb_image_size_field( $default = true ) {
		global $_wp_additional_image_sizes;
		$output = array();
		$sizes = array();
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				);
			}
			$name = $_size . ' (' . $sizes[ $_size ]['width'] . ' x ' . $sizes[ $_size ]['height'] . ')';
			$output[ $name ] = $_size;		
		}
		if ( $default == true ) {			
			return array_merge( array( esc_html__( 'Default', 'aardvark' ) => 'default' ), $output );
		} else {
			return $output;
		}	
	}
}

/**
 * Add GP Posts element CSS to header
 *
 */	
if ( ! function_exists( 'ghostpool_posts_css' ) ) {
	function ghostpool_posts_css( $name = '', $title_color = '', $icon_color = '', $post_title_color = '', $post_title_hover_color = '', $post_link_color = '', $post_link_hover_color = '', $post_text_color = '', $meta_text_color = '', $bg_color = '', $border_color = '', $ranking_bg_color = '', $ranking_text_color = '' ) {

		$custom_css = '';

		if ( $title_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-widget-title h3{color:' . esc_attr( $title_color ) . ';}';
		}
		if ( $icon_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-element-icon{color:' . esc_attr( $icon_color ) . ';}';
		}
		if ( $post_title_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-loop-title a, #' . sanitize_html_class( $name ) . ' ul.page-numbers .page-numbers, #' . sanitize_html_class( $name ) . ' ul.page-numbers a.page-numbers:hover{color:' . esc_attr( $post_title_color ) . ';}';
		} 
		if ( $post_title_hover_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-loop-title a:hover, #' . sanitize_html_class( $name ) . ' ul.page-numbers a.page-numbers{color:' . esc_attr( $post_title_hover_color ) . ';}';
		}
		if ( $post_link_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-loop-content a{color:' . esc_attr( $post_link_color ) . ';}';
		}
		if ( $post_link_hover_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-loop-text a:hover{color:' . esc_attr( $post_link_hover_color ) . ';}';
		}		
		if ( $post_text_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-loop-text{color:' . esc_attr( $post_text_color ) . ';}';
		}
		if ( $meta_text_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-loop-meta, #' . sanitize_html_class( $name ) . ' .gp-loop-meta a{color:' . esc_attr( $meta_text_color ) . ';}';
		}	
		if ( $bg_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . '.gp-posts-masonry .gp-loop-content, #' . sanitize_html_class( $name ) . ' .gp-posts-masonry .gp-loop-content{background-color:' . esc_attr( $bg_color ) . ';}';
		}
		if ( $border_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . '.gp-posts-list .gp-post-item, #' . sanitize_html_class( $name ) . '.gp-posts-vertical .gp-post-item, #' . sanitize_html_class( $name ) . ' .gp-posts-masonry .gp-loop-content{border-color:' . esc_attr( $border_color ) . ';}';
		}			
		if ( $ranking_bg_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-ranking-counter{background-color:' . esc_attr( $ranking_bg_color ) . ';}';
		}						
		if ( $ranking_text_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-ranking-counter{color:' . esc_attr( $ranking_text_color ) . ';}';
		}	

		if ( $ranking_text_color ) {
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-ranking-counter{color:' . esc_attr( $ranking_text_color ) . ';}';
		}	
				
		echo '<style>' . $custom_css . '</style>';
	}
}

/**
 * Add pricing table CSS to header
 *
 */	
if ( ! function_exists( 'ghostpool_pricing_table_css' ) ) {
	function ghostpool_pricing_table_css( $name = '', $title_bg_color = '', $highlight_title_bg_color = '', $title_text_color = '', $highlight_title_text_color = '', $price_bg_color = '', $price_circle_color = '', $price_text_color = '', $content_bg_color = '', $content_bg_color_alt = '', $content_text_color = '', $footer_bg_color = '', $button_bg_color = '', $button_bg_hover_color = '', $button_text_color = '', $divider_color = '' ) {
		
		$custom_css = '';

		if ( $title_bg_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-header{background-color:' . esc_attr( $title_bg_color ) . ';}';
		}	
			
		if ( $highlight_title_bg_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . '.gp-highlight-column .gp-pricing-column-header{background-color:' . esc_attr( $highlight_title_bg_color ) . ';}';
		}
		
		if ( $title_text_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-title{color:' . esc_attr( $title_text_color ) . ';}';
		}	

		if ( $highlight_title_text_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . '.gp-highlight-column .gp-pricing-column-highlight-text{color:' . esc_attr( $highlight_title_text_color ) . ';}';
		}
		
		if ( $price_bg_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-costs{background-color:' . esc_attr( $price_bg_color ) . ';}';
		}	
		
		if ( $price_circle_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . '.gp-style-2 .gp-pricing-column-circle{background-color:' . esc_attr( $price_circle_color ) . ';}';
		}	
			
		if ( $price_text_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-costs h5, #' . sanitize_html_class( $name ) . ' .gp-pricing-column-costs h6{color:' . esc_attr( $price_text_color ) . ';}';
		}
			
		if ( $content_bg_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-content{background-color:' . esc_attr( $content_bg_color ) . ';}';
		}		

		if ( $content_bg_color_alt ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . '.gp-style-2 .gp-pricing-column-content li:nth-child(odd){background-color:' . esc_attr( $content_bg_color_alt ) . ';}';
		}	
					
		if ( $content_text_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-content{color:' . esc_attr( $content_text_color ) . ';}';
		}		
		
		if ( $footer_bg_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-footer,
			#' . sanitize_html_class( $name ) . '.gp-pricing-column{background-color:' . esc_attr( $footer_bg_color ) . ';}';
		}
			
		if ( $button_bg_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-button{background-color:' . esc_attr( $button_bg_color ) . ';}';
		}
			
		if ( $button_bg_hover_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-button:hover{background-color:' . esc_attr( $button_bg_hover_color ) . ';}';
		}		
			
		if ( $button_text_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-button{color:' . esc_attr( $button_text_color ) . ';}';
		}		
			
		if ( $divider_color ) { 
			$custom_css .= '#' . sanitize_html_class( $name ) . ' .gp-pricing-column-divider{border-color:' . esc_attr( $divider_color ) . ';}';
		}
								
		echo '<style>' . $custom_css . '</style>';
	}
}

/**
 * Add BuddyPress element CSS to header
 *
 */	
if ( ! function_exists( 'ghostpool_buddypress_css' ) ) {
	function ghostpool_buddypress_css( $name = '', $link_color = '', $bg_color = '', $border_color = '', $title_color = '', $text_color = '' ) {

		$custom_css = '';

		if ( $link_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .item-options a {
			color:' . esc_attr( $link_color ) . ';
			}';
		}

		if ( $bg_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-loop-content {
			background-color:' . esc_attr( $bg_color ) . ';
			}
			#' . sanitize_html_class( $name ) . ' .gp-post-thumbnail .gp-bp-col-avatar img.avatar {
			border-color:' . esc_attr( $bg_color ) . ';
			}';
		}
				
		if ( $border_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-loop-content,
			#' . sanitize_html_class( $name ) . ' .gp-no-cover-image img.avatar,
			#' . sanitize_html_class( $name ) . ' .gp-bp-avatar img.avatar,
			#' . sanitize_html_class( $name ) . ' .item-avatar img.avatar {
			border-color:' . esc_attr( $border_color ) . ';
			}';
		}

		if ( $title_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-loop-title a {
			color:' . esc_attr( $title_color ) . ';
			}';
		}

		if ( $text_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-loop-meta,
			#' . sanitize_html_class( $name ) . ' .gp-loop-text {
			color:' . esc_attr( $text_color ) . ';
			}';
		}
								
		echo '<style>' . $custom_css . '</style>';
		
	}
}

/**
 * Add BP profile search element CSS to header
 *
 */	
 
if ( ! function_exists( 'ghostpool_bp_profile_search_css' ) ) {
	function ghostpool_bp_profile_search_css( $name = '', $text_color = '', $bg_color = '', $border_color = '' ) {

		$custom_css = '';
		
		if ( $text_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . '.gp-bps-wrapper {
			color:' . esc_attr( $text_color ) . ';
			}';
		}

		if ( $bg_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . '.gp-bps-wrapper {
			background-color:' . esc_attr( $bg_color ) . ';
			}';
		}
		
		if ( $border_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . '.gp-bps-wrapper {
			border-color:' . esc_attr( $border_color ) . ';
			}';
		}
												
		echo '<style>' . $custom_css . '</style>';
		
	}
}
		
/**
 * Add Testimonial Slider element CSS to header
 *
 */	
 
if ( ! function_exists( 'ghostpool_testimonial_slider_css' ) ) {
	function ghostpool_testimonial_slider_css( $name = '', $headline_font_size = '', $headline_line_height = '', $quote_font_size = '', $quote_line_height = '', $name_font_size = '', $name_line_height = '', $avatar_border_color = '', $headline_color = '', $quote_color = '', $name_color = '' ) {

		$custom_css = '';

		if ( $headline_font_size ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-headline {
			font-size:' . esc_attr( $headline_font_size ) . ';
			}';
		}

		if ( $headline_line_height ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-headline {
			line-height:' . esc_attr( $headline_line_height ) . ';
			}';
		}

		if ( $quote_font_size ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-text {
			font-size:' . esc_attr( $quote_font_size ) . ';
			}';
		}

		if ( $quote_line_height ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-text {
			line-height:' . esc_attr( $quote_line_height ) . ';
			}';
		}
		
		if ( $name_font_size ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-name {
			font-size:' . esc_attr( $name_font_size ) . ';
			}';
		}

		if ( $name_line_height ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-name {
			line-height:' . esc_attr( $name_line_height ) . ';
			}';
		}
								
		if ( $avatar_border_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . '.gp-slider .slides li .gp-testimonial-image img {
			border-color:' . esc_attr( $avatar_border_color ) . ';
			}
			#' . sanitize_html_class( $name ) . ' .gp-pointer {
			border-left-color:' . esc_attr( $avatar_border_color ) . ';
			}';
		}
		
		if ( $headline_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-headline {
			color:' . esc_attr( $headline_color ) . ';
			}';
		}

		if ( $quote_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-text {
			color:' . esc_attr( $quote_color ) . ';
			}';
		}

		if ( $name_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-testimonial-name {
			color:' . esc_attr( $name_color ) . ';
			}';
		}
								
		echo '<style>' . $custom_css . '</style>';
		
	}
}

/**
 * Add Featured box element CSS to header
 *
 */	
if ( ! function_exists( 'ghostpool_featured_box_css' ) ) {
	function ghostpool_featured_box_css( $name = '', $spacing = 0, $layout = 'gp-wide' ) {

		$custom_css = '';
		
		if ( $spacing ) {
			$spacing = str_replace( 'px', '', $spacing );
		} else {
			$spacing = 0;
		}
	
		$extra_widths = 0;
		$extra_width = 0;

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
		margin-right:-'. $spacing .'px;
		}
		#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-box-scroll {
		margin-right:-'. ( $spacing + 30 ) . 'px;
		}
		#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-box-scroll .gp-col-1 .gp-featured-small:first-child{
		margin-left:-' . $spacing . 'px;
		}

		@media only screen and (max-width : 767px) {		
			#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-large,
			#' . sanitize_html_class( $name ) . '.gp-wide .gp-featured-box-scroll {				
			width: calc(100% + 30px);
			}			
		}
				
		@media only screen and (min-width : 768px) {
			#' . sanitize_html_class( $name ) . ' .gp-featured-large-col {
			width: ' . ( 339 + $extra_widths ) . 'px;
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
			width: ' . ( 455 + $extra_widths ) . 'px;
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
			width: ' . ( 540 + $extra_widths ) . 'px;
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
			width: '. ( 570 + $extra_widths ) . 'px;
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
}

/**
 * Add Contact Details element CSS to header
 *
 */	
if ( ! function_exists( 'ghostpool_contact_details_css' ) ) {
	function ghostpool_contact_details_css( $name = '', $icon_color = '', $text_color = '' ) {

		$custom_css = '';

		if ( $icon_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-contact-detail:before {
			color:' . esc_attr( $icon_color ) . ';
			}';
		}

		if ( $text_color ) { 
			$custom_css .= '
			#' . sanitize_html_class( $name ) . ' .gp-contact-detail {
			color:' . esc_attr( $text_color ) . ';
			}';
		}
						
		echo '<style>' . $custom_css . '</style>';
		
	}
}

/**
* Change alignments for RTL support
*
*/
function ghostpool_rtl_update_vc_rows() {

	if ( is_rtl() ) {
	
		$args = array(
			'post_type'  => 'page',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => '_ghostpool_imported',
					'value'   => 1,					
					'compare' => '=',
				),
				array(
					'key'     => '_ghostpool_rtl',
					'compare' => 'NOT EXISTS',
				),
			),
			'posts_per_page'      => -1,
			'paged'          	  => 1,
		);

		$gp_query = new WP_Query( $args );
	
		if ( $gp_query->have_posts() ) : while ( $gp_query->have_posts() ) : $gp_query->the_post();
	
			global $post;

			$search = array( 'background_position="right center"', 'text_align:left', 'align="left"' );
			$replace = array( 'background_position="left center"', 'text_align:right', 'align="right"' );
		
			$post_content = str_replace( $search, $replace, $post->post_content );

			$update_post = array(
				'ID' => get_the_ID(),
				'post_content' => $post_content,
			);

			wp_update_post( $update_post );

			delete_post_meta( get_the_ID(), '_ghostpool_ltr' );
			add_post_meta( get_the_ID(), '_ghostpool_rtl', 1, true );
			
		endwhile; endif; wp_reset_postdata();

	} else {

		$args = array(
			'post_type'  => 'page',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => '_ghostpool_imported',
					'value'   => 1,					
					'compare' => '=',
				),
				array(
					'key'     => '_ghostpool_ltr',
					'compare' => 'NOT EXISTS',
				),
			),
			'posts_per_page'      => -1,
			'paged'          	  => 1,
		);

		$gp_query = new WP_Query( $args );
	
		if ( $gp_query->have_posts() ) : while ( $gp_query->have_posts() ) : $gp_query->the_post();
	
			global $post;

			$search = array( 'background_position="left center"', 'text_align:right', 'align="right"' );
			$replace = array( 'background_position="right center"', 'text_align:left', 'align="left"' );
		
			$post_content = str_replace( $search, $replace, $post->post_content );

			$update_post = array(
				'ID' => get_the_ID(),
				'post_content' => $post_content,
			);

			wp_update_post( $update_post );

			delete_post_meta( get_the_ID(), '_ghostpool_rtl' );
			add_post_meta( get_the_ID(), '_ghostpool_ltr', 1, true );
			
		endwhile; endif; wp_reset_postdata();
			
	}

}
add_action( 'after_setup_theme', 'ghostpool_rtl_update_vc_rows' );	

/**
* Login page builder template
*
*/
if ( ! function_exists( 'ghostpool_login_wpb_template' ) ) {
	function ghostpool_login_wpb_template( $data ) {
		$template = array();
		$template['name'] = esc_html__( 'Login Page', 'aardvark' );
		$template['custom_class'] = 'ghostpool-login-wpb-template';
		$template['content'] = '[vc_row full_width="stretch_row" full_height="yes" content_placement="middle" animated_bg="true" gradient_color_1="rgba(236,77,59,0.7)" gradient_color_2="rgba(242,109,60,0.7)" gradient_color_3="rgba(236,77,59,0.7)" gradient_color_4="rgba(255,178,171,0.7)" css=".vc_custom_1519134581072{padding-right: 30px !important;padding-left: 30px !important;}"][vc_column width="1/12" offset="vc_col-lg-4 vc_col-md-3 vc_hidden-xs"][/vc_column][vc_column width="5/6" css=".vc_custom_1519135457300{padding-top: 30px !important;padding-right: 30px !important;padding-bottom: 30px !important;padding-left: 30px !important;background-color: #ffffff !important;border-radius: 3px !important;}" offset="vc_col-lg-4 vc_col-md-6 vc_col-xs-12" bb_tab_container=""][vc_single_image image="713" img_size="150x31" alignment="center"][gp_login_register_form][/vc_column][vc_column width="1/12" offset="vc_col-lg-4 vc_col-md-3 vc_hidden-xs"][/vc_column][/vc_row]';
		array_unshift( $data, $template );
		return $data;
	}
}	
add_filter( 'vc_load_default_templates', 'ghostpool_login_wpb_template' );
  				
?>