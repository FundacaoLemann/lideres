<?php

/**
 * Enqueues scripts and styles.
 *
 */	
if ( ! function_exists( 'ghostpool_wc_scripts' ) ) {	
	function ghostpool_wc_scripts() {
		wp_enqueue_style( 'ghostpool-woocommerce', get_template_directory_uri() . '/lib/css/woocommerce.css', array( 'woocommerce-general' ) );						
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_wc_scripts' );

/**
 * Disable activation redirect
 *
 */
if ( ! function_exists( 'ghostpool_wc_disable_redirect' ) ) {
	function ghostpool_wc_disable_redirect() {
		return true;
	}
}
add_filter( 'woocommerce_prevent_automatic_wizard_redirect', 'ghostpool_wc_disable_redirect' );
		
/**
 * Remove default WooCommerce content wrappers
 *
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Remove shop/category titles and descriptions
 *
 */
add_filter( 'woocommerce_show_page_title', create_function( '$result', 'return false;' ), 20 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

/**
 * Remove breadcrumbs
 *
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/**
 * Use custom pagination for product categories 
 *
 */
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
if ( ! function_exists( 'woocommerce_pagination' ) ) {
	function woocommerce_pagination() {
		global $wp_query;
		echo ghostpool_pagination( $wp_query->max_num_pages, 'page-numbers' );
	}
}	
add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );

/**
 * Opening WooCommerce content wrappers 
 *
 */
if ( ! function_exists( 'ghostpool_wc_page_wrapper_start' ) ) {
	function ghostpool_wc_page_wrapper_start() {
		
		// Page options
		if ( is_shop() ) {
			$header = ghostpool_option( 'wc_shop_page_header' );
			$bg = ghostpool_option( 'wc_shop_page_header_bg' );
			$height = ghostpool_option( 'wc_shop_page_header_height', 'height' );
		} elseif ( is_archive() ) {
			// Get category options
			$term_data = null;
			if ( isset( get_queried_object()->term_id ) ) {
				$term_id = get_queried_object()->term_id;
				$term_data = get_option( "taxonomy_$term_id" );
			}
			$header = ! isset( $term_data['page_header'] ) || $term_data['page_header'] == 'default' ? ghostpool_option( 'wc_product_cat_page_header' ) : $term_data['page_header'];
			$bg = isset( $term_data['page_header_bg'] ) ? $term_data['page_header_bg'] : '';
			$height = ghostpool_option( 'wc_product_cat_page_header_height', 'height' );
		} elseif ( is_singular( 'product' ) ) {
			$header = ghostpool_option( 'page_header' ) == 'default' ? ghostpool_option( 'wc_product_page_header' ) : ghostpool_option( 'page_header' );
			$bg = get_post_meta( get_the_ID(), 'page_header_bg', true );
			$height = ghostpool_option( 'page_header_height', 'height' ) != '' ? ghostpool_option( 'page_header_height', 'height' ) : ghostpool_option( 'wc_product_page_header_height', 'height' );
		} ?>

		<?php if ( ! is_singular( 'product' ) ) { ghostpool_page_title( '', $header ); } ?>

		<?php ghostpool_page_header( 
			$post_id = '', 
			$type = $header,
			$bg = $bg,
			$height = $height
		); ?>
		
		<div id="gp-content-wrapper" class="gp-container">
		
			<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>
		
			<div id="gp-inner-container">
		
				<div id="gp-content">
					
	<?php }
}
add_action( 'woocommerce_before_main_content', 'ghostpool_wc_page_wrapper_start', 10 );

/**
 * Closing WooCommerce content wrappers 
 *
 */
if ( ! function_exists( 'ghostpool_wc_page_wrapper_end' ) ) {
	function ghostpool_wc_page_wrapper_end() { ?>		
													
				</div>
			
				<?php get_sidebar( 'left' ); ?>
	
				<?php get_sidebar( 'right' ); ?>
	
			</div>

			<?php do_action( 'ghostpool_end_content_wrapper' ); ?>
		
			<div class="gp-clear"></div>

		</div>

	<?php }
}
add_action( 'woocommerce_after_main_content', 'ghostpool_wc_page_wrapper_end', 10 );

/**
 * Alter dropdown cart product name tag
 *
 */
if ( ! function_exists( 'ghostpool_woocommerce_cart_item_name' ) ) {
	function ghostpool_woocommerce_cart_item_name( $link_text, $product_data ) {
		 $title = get_the_title($product_data['product_id']);
		$product_name = '<span class="gp-product-name">' . $title . '</span>';
		return $product_name; 
	}
}
add_filter( 'woocommerce_cart_item_name', 'ghostpool_woocommerce_cart_item_name', 10, 2 );

/**
 * WooCommerce standard dropdown cart
 *
 */
if ( ! function_exists( 'ghostpool_dropdown_cart' ) ) {														
	function ghostpool_dropdown_cart() {
		if ( ! is_cart() && ! is_checkout() ) { ?>	
			<div class="gp-cart-button gp-header-button menu-item gp-standard-menu">
				<a href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart', 'aardvark' ); ?>">
					<span class="gp-cart-bag">
						<span class="gp-cart-handle"></span>
						<span class="gp-cart-counter"><?php echo sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'aardvark' ), WC()->cart->get_cart_contents_count() ); ?></span>
					</span>	
				</a>		
				<div class="sub-menu">
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>		
				</div>
			</div>
	<?php }
	}
}

/**
 * WooCommerce ajax dropdown cart
 *
 */
if ( ! function_exists( 'ghostpool_woocommerce_add_to_cart_fragment' ) ) {
	function ghostpool_woocommerce_add_to_cart_fragment( $fragments ) {
		ob_start(); ?>
			<span class="gp-cart-counter"><?php echo sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'aardvark' ), WC()->cart->get_cart_contents_count() ); ?></span>
		<?php $fragments['.gp-cart-button .gp-cart-counter'] = ob_get_clean();
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'ghostpool_woocommerce_add_to_cart_fragment' );

/**
 * WooCommerce secondary hover image
 *
 */
function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0 ) {
	
	global $product;
	
	$output = '';
	
	$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

	// Hover product image
	if ( ghostpool_option( 'wc_secondary_hover_image' ) == 'enabled' ) {
		$attachment_ids = $product->get_gallery_image_ids();
	} else {
		$attachment_ids = array();
	}
	
	// Reverse array to load second gallery image
	$attachment_ids = array_reverse( $attachment_ids );	

	// If product gallery is found		
	if ( $attachment_ids ) {
	
		$output .= '<div class="gp-product-image-container">';

			foreach ( $attachment_ids as $attachment_id ) {
		
				$output .= $attachment_id != get_post_thumbnail_id() ? wp_get_attachment_image( $attachment_id, $image_size, false, array( 'class' => 'gp-hover-image' ) ) : '';
				break;
		
			}
	
	}
	
	$output .= $product ? $product->get_image( $image_size ) : '';
	
	if ( $attachment_ids ) {
		$output .= '</div>';	
	}
		
	return $output;
	
}

/**
 * WooCommerce products per row
 *
 */
if ( ! function_exists( 'ghostpool_products_per_row' ) ) {
	function ghostpool_products_per_row() {
		return ghostpool_option( 'wc_products_per_row' ) ? ghostpool_option( 'wc_products_per_row' ) : 3;
	}
}
add_filter( 'loop_shop_columns', 'ghostpool_products_per_row' );

?>