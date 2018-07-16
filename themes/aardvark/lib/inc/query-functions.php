<?php

/* Page/paged query
 *
 */	
if ( ! function_exists( 'ghostpool_paged' ) ) {
	function ghostpool_paged() {
		if ( get_query_var( 'paged' ) ) {
			return get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			return get_query_var( 'page' );
		} else {
			return 1;
		}
	}
}	

/**
 * Get categories
 *
 */
if ( ! function_exists( 'ghostpool_cats' ) ) {
	function ghostpool_cats( $cats = '', $type = 'param' ) {

		// Convert array to string
		if ( is_array( $cats ) ) {
			$cats = implode( ',', $cats );
		}
		
		if ( ! empty( $cats ) && preg_match( '/^[1-9, ][0-9, ]*$/', $cats ) ) {
			$param = 'cat';
		} elseif ( ! empty( $cats ) ) {
			$param = 'category_name';
		} else {
			$param = null;
		}
		
		if ( $type == 'param' ) {
			return $param;
		} elseif ( $type == 'variables' ) {
			return $cats;
		}				
						
	}
}		

/**
 * Get orderby values
 *
 */
if ( ! function_exists( 'ghostpool_orderby' ) ) {
	function ghostpool_orderby( $value, $type = '' ) {
	
		$orderby = '';
		$order = '';	
		$meta_key = '';		
		$meta_query = '';

		if ( $value == 'newest' ) {
			$orderby = 'date';
			$order = 'desc';
		} elseif ( $value == 'oldest' ) {
			$orderby = 'date';
			$order = 'asc';		
		} elseif ( $value  == 'title_az' ) {
			$orderby = 'title';
			$order = 'asc';
		} elseif ( $value  == 'title_za' ) {
			$orderby = 'title';
			$order = 'desc';								
		} elseif ( $value == 'comment_count' ) {
			$orderby = 'comment_count';
			$order = 'desc';
		} elseif ( $value == 'views' ) {
			$orderby = 'meta_value_num';
			$order = 'desc';
			$meta_key = apply_filters( 'ghostpool_views_meta_key', 'views_total' );	
		} elseif ( $value == 'likes' ) {
			$orderby = 'meta_value_num';
			$order = 'desc';
			$meta_key = 'ghostpool_voting_up';
		} elseif ( $value == 'menu_order' ) {
			$orderby = 'menu_order';
			$order = 'asc';
		} elseif ( $value == 'rand' ) {
			$orderby = 'rand';
			$order = 'asc';	
		} elseif ( $value == 'relevance' ) {
			$orderby = 'relevance';
			$order = 'desc';
		}
					
		if ( $type == 'orderby' ) {
			return $orderby;
		} elseif ( $type == 'order' ) {	
			return $order;
		} elseif ( $type == 'meta_key' ) {
			return $meta_key;
		} elseif ( $type == 'meta_query' ) {
			return array(
				'relation' => 'AND',
				$meta_query
			);
		}	

	}
}

/**
 * Alter taxonomy queries
 *
 */	
if ( ! function_exists( 'ghostpool_category_queries' ) ) {
	function ghostpool_category_queries( $query ) {	
		if ( is_admin() OR ! $query->is_main_query() ) { 
			return;
		} elseif ( is_archive() OR is_search() OR is_author() OR $query->get( 'wc_query' ) === 'product_query' ) {

			// Load variables for specific taxonomy type
			if ( function_exists( 'is_woocommerce' ) && is_shop() ) {
				$per_page = ghostpool_option( 'wc_shop_per_page' );
			} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() && ( is_product_category() OR is_product_tag() OR is_tax() ) ) {
				$per_page = ghostpool_option( 'wc_product_cat_per_page' );	
			} elseif ( is_search() ) {
				$orderby = ghostpool_option( 'search_orderby' );
				$per_page = ghostpool_option( 'search_per_page' );
				$post_type = ghostpool_option( 'search_post_types' );
			} elseif ( is_author() ) {
				$orderby = ghostpool_option( 'author_orderby' );
				$per_page = ghostpool_option( 'author_per_page' );
				$post_type = ghostpool_option( 'author_post_types' );	
			} elseif ( is_archive() ) {
				$orderby = ghostpool_option( 'cat_orderby' );
				$per_page = ghostpool_option( 'cat_per_page' );
			}

			// Set global taxonomy queries
			if ( isset( $per_page ) ) {
				$query->set( 'posts_per_page', $per_page );
			}
			if ( isset( $orderby ) ) {
				$query->set( 'orderby', ghostpool_orderby( $orderby, 'orderby' ) );	
				$query->set( 'order', ghostpool_orderby( $orderby, 'order' ) );
				$query->set( 'meta_key', ghostpool_orderby( $orderby, 'meta_key' ) );
			}
			if ( isset( $post_type ) ) {
				$query->set( 'post_type', $post_type );
			}
			if ( isset( $meta_query ) ) {
				$query->set( 'meta_query', $meta_query );
			}
			
			return;
		}
	}
}	
add_action( 'pre_get_posts', 'ghostpool_category_queries', 1 );

/**
 * Load category and orderby filters
 *
 */
if ( ! function_exists( 'ghostpool_filter' ) ) {
	function ghostpool_filter( $type = '', $cat_id = '', $orderby = '', $pagination = '', $page = true ) {
	
		// Sorting options
		$relevance = ( isset( $type['relevance'] ) && $type['relevance'] != '' && $type['relevance'] != 0 ) ? '1' : '0';
		$date = ( isset( $type['date'] ) && $type['date'] != '' && $type['date'] != 0 ) ? '1' : '0';
		$title = ( isset( $type['title'] ) && $type['title'] != '' && $type['title'] != 0 ) ? '1' : '0';
		$comment_count = ( isset( $type['comment_count'] ) && $type['comment_count'] != '' && $type['comment_count'] != 0 ) ? '1' : '0';
		$views = ( isset( $type['views'] ) && $type['views'] != '' && $type['views'] != 0 ) ? '1' : '0';
		$likes = ( isset( $type['likes'] ) && $type['likes'] != '' && $type['likes'] != 0 ) ? '1' : '0';

		if ( ( $cat_id != '' OR $relevance OR $date OR $title OR $comment_count OR $views OR $likes ) && ghostpool_option( 'ajax' ) == 'gp-ajax-loop' && $pagination != 'load-more' ) { ?>
		
			<?php if ( $page == true ) { ?><div class="gp-filter-wrapper"><?php } ?>
			
				<div class="gp-filter-menus">

					<?php if ( $cat_id != '' ) { 

						// Add slug support for filter categories option
						if ( ! preg_match( '/^[1-9][0-9]*$/', $cat_id ) ) {
							$cats_slug = get_term_by( 'slug', $cat_id, 'category' );
							if ( $cats_slug ) {
								$cat_id = $cats_slug->term_id;
							}
						}
						
						$term = term_exists( (int) $cat_id, 'category' );
						if ( $term === 0 OR $term === null ) {
							$cat_id = '';
						}

						$args = array(
							'taxonomy'   => 'category',
							'parent' 	 => (int) $cat_id,
							'hide_empty' => false,
						);	
						
						$terms = get_terms( $args );				
		
						if ( $terms ) { ?>
							<select name="gp-filter-cats" class="gp-filter-menu gp-filter-cats">	
								<option value="<?php echo esc_attr( $cat_id ); ?>"><?php esc_html_e( 'All', 'aardvark' ); ?></option>		
								<?php foreach( $terms as $term ) {
									if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { ?>
										<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_attr( $term->name ); ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						<?php } ?>
					<?php }
		
					if ( $relevance OR $date OR $title OR $comment_count OR $views OR $likes ) { ?>

						<select name="gp-filter-orderby" class="gp-filter-menu gp-filter-orderby">

							<?php if ( ( isset( $type['relevance'] ) && $type['relevance'] == '1' ) ) { ?>
								<option value="relevance"<?php if ( $orderby == 'relevance' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Relevance', 'aardvark' ); ?></option>
							<?php } ?>
					
							<?php if ( $type['date'] == '1' ) { ?>
								<option value="newest"<?php if ( $orderby == 'newest' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Newest', 'aardvark' ); ?></option>
								<option value="oldest"<?php if ( $orderby == 'oldest' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Oldest', 'aardvark' ); ?></option>
							<?php } ?>

							<?php if ( $type['title'] == '1' ) { ?>
								<option value="title_az"<?php if ( $orderby == 'title_az' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Title (A-Z)', 'aardvark' ); ?></option>
								<option value="title_za"<?php if ( $orderby == 'title_za' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Title (Z-A)', 'aardvark' ); ?></option>
							<?php } ?>		
									
							<?php if ( $type['comment_count'] == '1' ) { ?>
								<option value="comment_count"<?php if ( $orderby == 'comment_count' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Most Comments', 'aardvark' ); ?></option>
							<?php } ?>		
				
							<?php if ( $type['views'] ) { ?>
								<option value="views"<?php if ( $orderby == 'views' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Most Views', 'aardvark' ); ?></option>
							<?php } ?>

							<?php if ( $type['likes'] ) { ?>
								<option value="likes"<?php if ( $orderby == 'likes' ) { ?> selected="selected"<?php } ?>><?php esc_html_e( 'Most Likes', 'aardvark' ); ?></option>
							<?php } ?>
														
						</select>

					<?php } ?>			
			
				</div>
			
			<?php if ( $page == true ) { ?></div><?php } ?>
						
		<?php }
	}
}

/**
 * Get total search results number
 *
 */
if ( ! function_exists( 'ghostpool_search_results_total' ) ) {
	function ghostpool_search_results_total( $query = '' ) {	
		if ( $query > 1 ) {
			$results_text = esc_html__( 'results found', 'aardvark' );
		} else {
			$results_text = esc_html__( 'result found', 'aardvark' );
		}	
		return '<div class="gp-divider-title-bg"><div class="gp-divider-title">' . absint( $query ) . ' ' . $results_text . '</div></div>';
	}
}

/**
 * Storing WordPress Popular Posts views as meta key
 *
 */
if ( ! function_exists( 'ghostpool_wpp_postviews' ) ) {
	function ghostpool_wpp_postviews( $post_id ) {
		// Accuracy:
		//   10  = 1 in 10 visits will update view count. (Recommended for high traffic sites.)
		//   30 = 30% of visits. (Medium traffic websites)
		//   100 = Every visit. Creates many db write operations every request.
		$accuracy = apply_filters( 'ghostpool_wpp_postviews_accuracy', '50' );
		if ( function_exists( 'wpp_get_views' ) && ( mt_rand( 0, 100 ) < $accuracy ) ) {
			update_post_meta( $post_id, 'views_total', wpp_get_views( $post_id ) );
			//update_post_meta( $post_id, 'views_daily', wpp_get_views( $post_id, 'daily' )  );
			//update_post_meta( $post_id, 'views_weekly', wpp_get_views( $post_id, 'weekly' ) );
			//update_post_meta( $post_id, 'views_monthly', wpp_get_views( $post_id, 'monthly' ) );
		}
	}
}
add_action( 'wpp_post_update_views', 'ghostpool_wpp_postviews' );

?>