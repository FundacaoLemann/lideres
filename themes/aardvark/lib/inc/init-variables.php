<?php

if ( ! function_exists( 'ghostpool_init_variables' ) ) {
	function ghostpool_init_variables() {

		/*--------------------------------------------------------------
		BuddyPress
		--------------------------------------------------------------*/

		if ( function_exists( 'bp_is_active' ) && ! bp_is_blog_page() ) {

			if ( bp_is_user() ) {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bp_profile_page_header' ) != 'default' ? ghostpool_option( 'bp_profile_page_header' ) : ghostpool_option( 'bp_page_header' );
			
				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bp_profile_layout' ) != 'default' ? ghostpool_option( 'bp_profile_layout' ) : ghostpool_option( 'bp_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bp_members_left_sidebar' ) != 'default' ? ghostpool_option( 'bp_members_left_sidebar' ) : ghostpool_option( 'bp_left_sidebar' );
			
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bp_members_right_sidebar' ) != 'default' ? ghostpool_option( 'bp_members_right_sidebar' ) : ghostpool_option( 'bp_right_sidebar' );
							
										
			} elseif ( bp_is_activity_component() ) {
				
				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bp_activity_page_header' ) != 'default' ? ghostpool_option( 'bp_activity_page_header' ) : ghostpool_option( 'bp_page_header' );
			
				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bp_activity_layout' ) != 'default' ? ghostpool_option( 'bp_activity_layout' ) : ghostpool_option( 'bp_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bp_activity_left_sidebar' ) != 'default' ? ghostpool_option( 'bp_activity_left_sidebar' ) : ghostpool_option( 'bp_left_sidebar' );
			
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bp_activity_right_sidebar' ) != 'default' ? ghostpool_option( 'bp_activity_right_sidebar' ) : ghostpool_option( 'bp_right_sidebar' );
				
			} elseif ( bp_is_members_component() ) {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bp_members_page_header' ) != 'default' ? ghostpool_option( 'bp_members_page_header' ) : ghostpool_option( 'bp_page_header' );
			
				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bp_members_layout' ) != 'default' ? ghostpool_option( 'bp_members_layout' ) : ghostpool_option( 'bp_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bp_members_left_sidebar' ) != 'default' ? ghostpool_option( 'bp_members_left_sidebar' ) : ghostpool_option( 'bp_left_sidebar' );
			
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bp_members_right_sidebar' ) != 'default' ? ghostpool_option( 'bp_members_right_sidebar' ) : ghostpool_option( 'bp_right_sidebar' );

			} elseif ( bp_is_groups_component() ) {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bp_groups_page_header' ) != 'default' ? ghostpool_option( 'bp_groups_page_header' ) : ghostpool_option( 'bp_page_header' );
			
				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bp_groups_layout' ) != 'default' ? ghostpool_option( 'bp_groups_layout' ) : ghostpool_option( 'bp_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bp_groups_left_sidebar' ) != 'default' ? ghostpool_option( 'bp_groups_left_sidebar' ) : ghostpool_option( 'bp_left_sidebar' );
			
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bp_groups_right_sidebar' ) != 'default' ? ghostpool_option( 'bp_groups_right_sidebar' ) : ghostpool_option( 'bp_right_sidebar' );

			} elseif ( bp_is_register_page() ) {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bp_register_page_header' ) != 'default' ? ghostpool_option( 'bp_register_page_header' ) : ghostpool_option( 'bp_page_header' );
			
				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bp_register_layout' ) != 'default' ? ghostpool_option( 'bp_register_layout' ) : ghostpool_option( 'bp_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bp_register_left_sidebar' ) != 'default' ? ghostpool_option( 'bp_register_left_sidebar' ) : ghostpool_option( 'bp_left_sidebar' );
			
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bp_register_right_sidebar' ) != 'default' ? ghostpool_option( 'bp_register_right_sidebar' ) : ghostpool_option( 'bp_right_sidebar' );
								
			} else {
			
				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bp_page_header' );
			
				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bp_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bp_left_sidebar' );
			
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bp_right_sidebar' );
				
			}
			

		/*--------------------------------------------------------------
		bbPress
		--------------------------------------------------------------*/

		} elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
							
			$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'bbpress_page_header' );
			
			$GLOBALS['ghostpool_layout'] = ghostpool_option( 'bbpress_layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'bbpress_left_sidebar' );
			
			$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'bbpress_right_sidebar' );
			
				
		/*--------------------------------------------------------------
		WooCommerce shop page
		--------------------------------------------------------------*/

		} elseif ( function_exists( 'is_woocommerce' ) && is_shop() ) {

			$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'wc_shop_page_header' );

			$GLOBALS['ghostpool_layout'] = ghostpool_option( 'wc_shop_layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'wc_shop_left_sidebar' ); 
			
			$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'wc_shop_right_sidebar' );


		/*--------------------------------------------------------------
		WooCommerce product categories/tags
		--------------------------------------------------------------*/

		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() && ( is_product_category() OR is_product_tag() OR is_tax() ) ) {

			// Get category option
			$term_data = null;
			if ( isset( get_queried_object()->term_id ) ) {
				$term_id = get_queried_object()->term_id;
				$term_data = get_option( "taxonomy_$term_id" );
			}
			
			$GLOBALS['ghostpool_page_header'] = ! isset( $term_data['page_header'] ) || $term_data['page_header'] == 'default' ? ghostpool_option( 'wc_product_cat_page_header' ) : $term_data['page_header'];
			
			$GLOBALS['ghostpool_layout'] = ! isset( $term_data['layout'] ) || $term_data['layout'] == 'default' ? ghostpool_option( 'wc_product_cat_layout' ) : $term_data['layout'];
			
			$GLOBALS['ghostpool_left_sidebar'] = ! isset( $term_data['left_sidebar'] ) || $term_data['left_sidebar'] == 'default' ? ghostpool_option( 'wc_product_cat_left_sidebar' ) : $term_data['left_sidebar']; 
						
			$GLOBALS['ghostpool_right_sidebar'] = ! isset( $term_data['right_sidebar'] ) || $term_data['right_sidebar'] == 'default' ? ghostpool_option( 'wc_product_cat_right_sidebar' ) : $term_data['right_sidebar'];
			
		
		/*--------------------------------------------------------------
		WooCommerce products
		--------------------------------------------------------------*/

		} elseif ( function_exists( 'is_woocommerce' ) && is_singular( 'product' ) ) {

			$GLOBALS['ghostpool_page_header'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) == 'default' ? ghostpool_option( 'wc_product_page_header' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' );

			$GLOBALS['ghostpool_layout'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' ) == 'default' ? 
			ghostpool_option( 'wc_product_layout' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' ) == 'default' ? ghostpool_option( 'wc_product_left_sidebar' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' );	
					
			$GLOBALS['ghostpool_right_sidebar'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' ) == 'default' ? ghostpool_option( 'wc_product_right_sidebar' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' );
			
		/*--------------------------------------------------------------
		Sensei
		--------------------------------------------------------------*/

		} elseif ( function_exists( 'is_sensei' ) && is_sensei() ) {
		
			if ( is_singular( 'lesson' ) OR is_singular( 'quiz' )  ) {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'lesson_page_header' );

				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'lesson_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'lesson_left_sidebar' );	
					
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'lesson_right_sidebar' );
				
			} elseif ( is_singular( 'course' ) ) {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'course_page_header' );

				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'course_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'course_left_sidebar' );	
					
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'course_right_sidebar' );
				
			} else {

				$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'courses_page_header' );

				$GLOBALS['ghostpool_layout'] = ghostpool_option( 'courses_layout' );
			
				$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'courses_left_sidebar' );	
					
				$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'courses_right_sidebar' );
				
			}
			
		
		/*--------------------------------------------------------------
		Search/author results
		--------------------------------------------------------------*/

		} elseif ( is_search() ) {
			
			$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'search_page_header' );

			$GLOBALS['ghostpool_layout'] = ghostpool_option( 'search_layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'search_left_sidebar' ); 
			
			$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'search_right_sidebar' );


		/*--------------------------------------------------------------
		Search/author results
		--------------------------------------------------------------*/

		} elseif ( is_author() ) {
			
			$GLOBALS['ghostpool_page_header'] = ghostpool_option( 'author_page_header' );

			$GLOBALS['ghostpool_layout'] = ghostpool_option( 'author_layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = ghostpool_option( 'author_left_sidebar' ); 
			
			$GLOBALS['ghostpool_right_sidebar'] = ghostpool_option( 'author_right_sidebar' );


		/*--------------------------------------------------------------
		Attachment page
		--------------------------------------------------------------*/

		} elseif ( is_attachment() ) {

			$GLOBALS['ghostpool_page_header'] = 'gp-standard-page-header';
			
			$GLOBALS['ghostpool_layout'] = apply_filters( 'ghostpool_attachment_layout', 'gp-no-sidebar' );
	
			$GLOBALS['ghostpool_left_sidebar'] = apply_filters( 'ghostpool_attachment_left_sidebar', 'gp-left-sidebar' );
			
			$GLOBALS['ghostpool_right_sidebar'] = apply_filters( 'ghostpool_attachment_right_sidebar', 'gp-right-sidebar' );
			
												
		/*--------------------------------------------------------------
		Error 404 page
		--------------------------------------------------------------*/

		} elseif ( is_404() ) {
		
			$GLOBALS['ghostpool_page_header'] = 'gp-standard-page-header';

			$GLOBALS['ghostpool_layout'] = apply_filters( 'ghostpool_error_layout', 'gp-no-sidebar' );
	
			$GLOBALS['ghostpool_left_sidebar'] = apply_filters( 'ghostpool_error_left_sidebar', 'gp-left-sidebar' );
			
			$GLOBALS['ghostpool_right_sidebar'] = apply_filters( 'ghostpool_error_right_sidebar', 'gp-right-sidebar' );
			
								
		/*--------------------------------------------------------------
		Post Categories, Archives & Tags
		--------------------------------------------------------------*/

		} elseif ( is_home() OR is_archive() ) {

			// Get category option
			$term_data = null;
			if ( isset( get_queried_object()->term_id ) ) {
				$term_id = get_queried_object()->term_id;
				$term_data = get_option( "taxonomy_$term_id" );
			}
			
			$GLOBALS['ghostpool_page_header'] = ! isset( $term_data['page_header'] ) || $term_data['page_header'] == 'default' ? ghostpool_option( 'cat_page_header' ) : $term_data['page_header'];
			
			$GLOBALS['ghostpool_layout'] = ! isset( $term_data['layout'] ) || $term_data['layout'] == 'default' ? ghostpool_option( 'cat_layout' ) : $term_data['layout'];
			
			$GLOBALS['ghostpool_left_sidebar'] = ! isset( $term_data['left_sidebar'] ) || $term_data['left_sidebar'] == 'default' ? ghostpool_option( 'cat_left_sidebar' ) : $term_data['left_sidebar']; 
						
			$GLOBALS['ghostpool_right_sidebar'] = ! isset( $term_data['right_sidebar'] ) || $term_data['right_sidebar'] == 'default' ? ghostpool_option( 'cat_right_sidebar' ) : $term_data['right_sidebar'];
			
		/*--------------------------------------------------------------
		Posts
		--------------------------------------------------------------*/

		} elseif ( is_singular( 'post' ) ) {

			$GLOBALS['ghostpool_page_header'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) == 'default' ? ghostpool_option( 'post_page_header' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' );

			$GLOBALS['ghostpool_layout'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' ) == 'default' ? 
			ghostpool_option( 'post_layout' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' ) == 'default' ? ghostpool_option( 'post_left_sidebar' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' );	
					
			$GLOBALS['ghostpool_right_sidebar'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' ) == 'default' ? ghostpool_option( 'post_right_sidebar' ) : redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' );

	
		/*--------------------------------------------------------------
		Pages
		--------------------------------------------------------------*/

		} else {

			$GLOBALS['ghostpool_page_header'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) != 'default' ? redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'page_header' ) : ghostpool_option( 'page_page_header' );

			$GLOBALS['ghostpool_layout'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' ) != 'default' ? redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'layout' ) : ghostpool_option( 'page_layout' );
			
			$GLOBALS['ghostpool_left_sidebar'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' ) != 'default' ? redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'left_sidebar' ) : ghostpool_option( 'page_left_sidebar' );	
					
			$GLOBALS['ghostpool_right_sidebar'] = redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' ) && redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' ) != 'default' ? redux_post_meta( 'ghostpool_aardvark', get_the_ID(), 'right_sidebar' ) : ghostpool_option( 'page_right_sidebar' );

		}
		
		
		/*--------------------------------------------------------------
		Add init variables via your child theme using this function
		--------------------------------------------------------------*/

		if ( function_exists( 'ghostpool_custom_init_variables' ) ) {
			ghostpool_custom_init_variables();
		}
		
	}
}

?>