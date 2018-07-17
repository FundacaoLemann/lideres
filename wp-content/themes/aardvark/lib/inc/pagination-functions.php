<?php
									
/**
 * Pagination numbers/load more
 *
 */	
if ( ! function_exists( 'ghostpool_pagination' ) ) {
	function ghostpool_pagination( $query, $pagination = 'disabled' ) {
		
		$big = 999999999;
		
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
		
		if ( $query > 1 && $pagination != 'disabled' ) {
		
			$output = '';
			
			if ( $pagination == 'load-more' ) {
				$output .= '<div class="gp-load-more">
					<div class="gp-load-more-button button">' . esc_html__( 'Load More', 'aardvark' ) . '</div>';
			}
							
				$output .= '<div class="gp-pagination gp-pagination-numbers gp-standard-pagination">' . paginate_links( array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, $paged ),
					'total'     => $query,
					'type'      => 'list',
					'prev_text' => '',
					'next_text' => '',
					'end_size'  => 1,
					'mid_size'  => 1, 
				) ) . '</div>';
			
			if ( $pagination == 'load-more' ) {
				$output .= '</div>';
			}
			
			return $output;
				
		}
	}
}

/**
 * Pagination arrows
 *
 */	
if ( ! function_exists( 'ghostpool_pagination_arrows' ) ) {
	function ghostpool_pagination_arrows( $max_page = 0 ) {
		
		global $paged;
		
		$output = '';
		
		if ( ! $paged ) {
			$paged = 1;
		}	
		
		$nextpage = intval( $paged ) - 1;
		if ( $nextpage < 1 ) {
			$nextpage = 1;
		}	
		if ( $paged > 1 ) {
			$output .= '<a href="#" data-pagelink="' . esc_attr( $nextpage ) . '" class="prev"></a>';
		} else {
			$output .= '<span class="prev gp-disabled"></span>';
		}

		$nextpage = intval( $paged ) + 1;
		if ( ! $max_page || $max_page >= $nextpage ) {
			$output .= '<a href="#" data-pagelink="' . esc_attr( $nextpage ) . '" class="next"></a>';
		} else {
			$output .= '<span class="next gp-disabled"></span>';
		}
		
		return $output;
		
	}
}

/**
 * Previous/next post navigation
 *
 */	
if ( ! function_exists( 'ghostpool_post_navigation' ) ) {
	function ghostpool_post_navigation() {
	
		// Get prev/next post IDs						
		$prev_post = get_adjacent_post( false, '', true );
		$next_post = get_adjacent_post( false, '', false );

		$post_nav = '';

		// Add prev/next post links
		if ( $prev_post ) { 		        
			$post_nav .= '<a href="' . get_permalink( $prev_post->ID ) . '" title="' . esc_attr( $prev_post->post_title ) . '" class="gp-prev-link" rel="prev"><span class="gp-post-link-header">' . esc_html__( 'Previous Article', 'aardvark' ) . '</span><span class="gp-post-link-title">' . get_the_title( $prev_post->ID ) . '</span></a>';
		}

		if ( $next_post ) { 		        
			$post_nav .= '<a href="' . get_permalink( $next_post->ID ) . '" title="' . esc_attr( $next_post->post_title ) . '" class="gp-next-link" rel="next"><span class="gp-post-link-header">' . esc_html__( 'Next Article', 'aardvark' ) . '</span><span class="gp-post-link-title">' . get_the_title( $next_post->ID ) . '</span></a>';
		}
		
		if ( $prev_post OR $next_post ) { 		        
			return '<div id="gp-post-navigation">' . $post_nav . '</div>';
		} else {
			return '';
		}
		
	}
}

/**
 * Post pagination <!--nextpage-->
 *
 */
function ghostpool_add_next_and_number( $args ) {
    if ( $args['next_or_number'] == 'ghostpool_next_and_number' ) {
        global $page, $numpages, $multipage, $more, $pagenow;
        $prev = '';
        $next = '';
        $page_count = '';
        if ( $multipage ) {
            if ( $more ) {
                $i = $page - 1;
                if ( $i && $more ) {
                    $prev .= _wp_link_page( $i );
                    $prev .= '<span class="gp-previous-page">' . esc_html__( 'Previous', 'aardvark' ) . '</span>' . '</a>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
                    $next .= _wp_link_page( $i );
                    $next .= '<span class="gp-next-page">' . esc_html__( 'Next', 'aardvark' ) . '</span>' . '</a>';
                }
            }
            $page_count = '<span class="gp-page-count">' . esc_html__( 'Page', 'aardvark' ) . ' ' . $page . ' ' . esc_html__( 'of', 'aardvark' ) . ' ' . $numpages . '</span>';
        }
        $args['before'] = $args['before'] . $prev . $page_count;
        $args['after'] = $next . $args['after'];    
    }
    return $args;
}
add_filter( 'wp_link_pages_args','ghostpool_add_next_and_number' );

/**
 * Custom next and prev rel links
 *
 */
if ( function_exists( 'wpseo_auto_load' ) ) {
	if ( ! function_exists( 'ghostpool_rel_prev_next' ) ) {
		function ghostpool_rel_prev_next() {
			
			global $paged, $wp_query;
		
			$custom_query = false;

			if ( is_page_template( 'blog-template.php' ) ) {
		
				$custom_query = true;
			
				$args = array(
					'post_status' 	      => 'publish',
					'post_type'           => implode( ',', ghostpool_option( 'blog_post_types' ) ),
					ghostpool_cats( ghostpool_option( 'blog_cats' ), 'param' ) => ghostpool_cats( ghostpool_option( 'blog_cats' ), 'variables' ),
					'orderby'             => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'orderby' ),
					'order'               => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'order' ),
					'meta_key'            => ghostpool_orderby( ghostpool_option( 'blog_orderby' ), 'meta_key' ),
					'posts_per_page'      => ghostpool_option( 'blog_per_page' ),
				);	
			
			}	
		
			if ( $custom_query == true ) {

				// Contains query data
				$query = new WP_Query( $args );
		
				// Get maximum pages from query
				$max_page = $query->max_num_pages;
		
				if ( ! $paged ) {
					$paged = 1;
				}
	
				// Prev rel link
				$prevpage = intval( $paged ) - 1;
				if ( $prevpage < 1 ) {
					$prevpage = 1;
				}	
				if ( $paged > 1 ) {
					echo '<link rel="prev" href="' . get_pagenum_link( $prevpage ) . '">';
				}
	
				// Next rel link
				$nextpage = intval( $paged ) + 1;	
				if ( ! $max_page OR $max_page >= $nextpage ) {
					echo '<link rel="next" href="' . get_pagenum_link( $nextpage ) . '">';
				}

				// Meta noindex,follow on paginated page templates
				if ( $paged > 1 ) {
					echo '<meta name="robots" content="noindex,follow">';
				}
		
			}
				
		}
		
	}	
	add_action( 'wp_head', 'ghostpool_rel_prev_next' );
}
	
/**
 * Custom canonical link
 *
 */
if ( function_exists( 'wpseo_auto_load' ) ) {
	if ( ! function_exists( 'ghostpool_canonical_link' ) ) {	
		function ghostpool_canonical_link( $canonical ) {
	
			global $wp_query;
		
			// Tab Parameters
			$reviews_tab_parameter = ghostpool_option( 'reviews_tab_parameter' );
			$previews_tab_parameter = ghostpool_option( 'previews_tab_parameter' );
			$news_tab_parameter = ghostpool_option( 'news_tab_parameter' );
			$images_tab_parameter = ghostpool_option( 'images_tab_parameter' );
			$videos_tab_parameter = ghostpool_option( 'videos_tab_parameter' );
			$forums_tab_parameter = ghostpool_option( 'forums_tab_parameter' );

			// Permalink structure for tab URls
			if ( ! get_option( 'permalink_structure' ) ) {
				$permalink_structure = '&';
			}  else {
				$permalink_structure = '';
			}
		
			if ( is_page_template( 'blog-template.php' ) ) {
			
				global $paged;		
				if ( ! $paged ) {
					$paged = 1;
				}
				return get_pagenum_link( $paged );
	
			} elseif ( isset( $wp_query->query[$reviews_tab_parameter] ) ) {		
					
				return get_permalink() . $permalink_structure . $reviews_tab_parameter;

			} elseif ( isset( $wp_query->query[$previews_tab_parameter] ) ) {		
			
				return get_permalink() . $permalink_structure . $previews_tab_parameter;
							
			} elseif ( isset( $wp_query->query[$news_tab_parameter] ) ) {		
			
				 return get_permalink() . $permalink_structure . $news_tab_parameter;
		
			} elseif ( isset( $wp_query->query[$images_tab_parameter] ) ) {		
			
				return get_permalink() . $permalink_structure . $images_tab_parameter;
		
			} elseif ( isset( $wp_query->query[$videos_tab_parameter] ) ) {		
			
				return get_permalink() . $permalink_structure . $videos_tab_parameter;
		
			} elseif ( isset( $wp_query->query[$forums_tab_parameter] ) ) {		
			
				return get_permalink() . $permalink_structure . $forums_tab_parameter;

			} else {
		
				return $canonical;
			
			}
		}
	}
	add_filter( 'wpseo_canonical', 'ghostpool_canonical_link' );
}

?>