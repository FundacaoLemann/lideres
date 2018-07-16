<?php if ( ! function_exists( 'ghostpool_page_title' ) ) {

	function ghostpool_page_title( $post_id = '', $header = 'gp-standard-page-header' ) {

		if ( $post_id == '' ) {
			$post_id = get_the_ID();
		}
		
		if ( ( ! function_exists( 'bp_is_active' ) OR ( function_exists( 'bp_is_active' ) && ! bp_is_user() && ! bp_is_group_single() ) ) ) { ?>

				<header id="gp-page-title" class="gp-container">
				
					<div class="gp-container">
					
						<?php echo ghostpool_breadcrumbs(); ?>
					
						<div id="gp-page-title-text">
					
							<h1>
	
								<?php global $wp_query;
							
								if ( isset( $_GET['post_edit'] ) && $_GET['post_edit'] == 1 ) {
								
									echo apply_filters( 'ghostpool_post_edit_title', esc_html__( 'Editing: ', 'aardvark' ) ) . get_the_title( $_GET['id'] );
						
								} elseif ( isset( $_GET['post_preview'] ) && $_GET['post_preview'] == 1 ) {
								
									echo get_the_title( $_GET['id'] );
								
								} elseif ( is_404() ) {
							
									echo apply_filters( 'ghostpool_404_title', esc_html__( 'Error 404: Page not found', 'aardvark' ) );
								
								} elseif ( is_singular() OR function_exists( 'is_bbpress' ) && is_bbpress() OR ( function_exists( 'is_woocommerce' ) && is_shop() ) ) { 
									
									// Get WooCommerce shop page ID 
									if ( function_exists( 'is_woocommerce' ) && is_shop() ) {
										$post_id = get_option( 'woocommerce_shop_page_id' );
									}
								
									if ( ghostpool_option( 'custom_title' ) ) { echo esc_attr( ghostpool_option( 'custom_title' ) ); } else { echo get_the_title( $post_id ); }
							
								} elseif ( is_search() ) { global $s;
							
									if ( isset( $_GET['s'] ) && ( $_GET['s'] != '' ) ) {
										echo apply_filters( 'ghostpool_search_results_title', esc_html__( 'search results for', 'aardvark' ) ) . ' "' . $s . '"';
									} else {
										apply_filters( 'ghostpool_search_title', esc_html__( 'Search', 'aardvark' ) );
									}
								} elseif ( is_author() ) {
								
									echo apply_filters( 'ghostpool_author_results_title', esc_html__( 'Author: ', 'aardvark' ) ) . get_the_author_meta( 'display_name', get_query_var( 'author' ) );
									
								} elseif ( is_category() OR is_tag() ) {
							
									single_cat_title();
								
								} elseif ( isset( $wp_query->query_vars['course_results'] ) ) {
								
									global $course;
									$course = get_page_by_path( $wp_query->query_vars['course_results'], OBJECT, 'course' );
									echo esc_attr( $course->post_title );
								
								} elseif ( is_post_type_archive( 'course' ) ) {
								
									ghostpool_sensei_archive_header();
							
								} elseif ( is_archive() ) {
							
									if ( ! function_exists( '_wp_render_title_tag' ) && ! function_exists( 'ghostpool_render_title' ) ) { 
										echo apply_filters( 'ghostpool_archives_title', esc_html__( 'Archives', 'aardvark' ) );
									} else { 
										echo apply_filters( 'ghostpool_archives_title', get_the_archive_title() );
									}
								
								} elseif ( is_front_page() ) {
					
									echo apply_filters( 'ghostpool_blog_title', esc_html__( 'Blog', 'aardvark' ) ); 

								} else {
								
									wp_title( '' ); 
									
								} ?>
							
							</h1>	
				
							<?php if ( category_description() != '' ) { ?>
								<h2 id="gp-page-title-subtitle"><?php echo str_replace( array( '<p>', '</p>' ), '', category_description() ); ?></h2>
							<?php } elseif ( is_author() && get_the_author_meta( 'description', get_query_var( 'author' ) ) ) { ?>
								<h2 id="gp-page-title-subtitle"><?php echo get_the_author_meta( 'description', get_query_var( 'author' ) ); ?></h2>
							<?php } elseif ( is_singular() && ghostpool_option( 'subtitle' ) ) { ?>
								<h2 id="gp-page-title-subtitle"><?php echo esc_attr( ghostpool_option( 'subtitle' ) ); ?></h2>
							<?php } ?>
					
							<?php if ( is_singular( 'post' ) ) { get_template_part( 'lib/sections/post/entry-meta' ); } ?>
						
						</div>
								
					</div>
			
					<div class="gp-clear"></div>

				</header>		
		
		<?php } 
	}		
} ?>