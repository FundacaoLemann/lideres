<?php 

/**
 * Registered filter scripts
 *
 */
if ( ! function_exists( 'ghostpool_register_filter_scripts' ) ) {
	function ghostpool_register_filter_scripts() {
		if ( ghostpool_option( 'ajax' ) == 'gp-ajax-loop' ) {			

			global $query_string;
	
			// Determine http or https for admin-ajax.php URL
			if ( is_ssl() ) { $scheme = 'https'; } else { $scheme = 'http'; }

			// Load scripts
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );			
			wp_enqueue_script( 'jquery-flexslider' );
			wp_enqueue_script( 'ghostpool-filters', get_template_directory_uri() . '/lib/scripts/jquery.filters.js', array( 'jquery', 'ghostpool-custom' ), '', true );
			wp_localize_script( 'ghostpool-filters', 'ghostpool_filters', array(
				'ajaxurl' => admin_url( 'admin-ajax.php', $scheme ),
				'nonce' => wp_create_nonce( 'ghostpool_filters_action' ),
				'query_string' => $query_string,
			) ); 
		
		}	
	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_register_filter_scripts' );

/**
 * Output filter variables in loop wrappers
 *
 */
if ( ! function_exists( 'ghostpool_filter_variables' ) ) {
	function ghostpool_filter_variables(
			$c_post_id = '',
			$cats = '', 
			$post_types = '', 
			$format = '', 
			$style = '', 
			$orderby = '', 
			$per_page = '', 
			$offset = '', 
			$image_size = '', 
			$content_display = '', 
			$excerpt_length = '', 
			$meta_author = '', 
			$meta_date = '', 
			$meta_comment_count = '', 
			$meta_views = '', 
			$meta_likes = '', 
			$meta_cats = '', 
			$meta_tags = '', 
			$read_more_link = '', 
			$pagination = '', 
			$page_arrows = '', 
			$ranking = '', 
			$large_excerpt_length = '', 
			$small_excerpt_length = '', 
			$large_meta_author = '', 
			$small_meta_author = '', 
			$large_meta_date = '', 
			$small_meta_date = '', 
			$large_meta_comment_count = '', 
			$small_meta_comment_count = '', 
			$large_meta_views = '', 
			$small_meta_views = '', 
			$large_meta_likes = '', 
			$small_meta_likes = '', 
			$large_meta_cats = '', 
			$small_meta_cats = '', 
			$large_meta_tags = '', 
			$small_meta_tags = '', 
			$large_read_more_link = '', 
			$small_read_more_link = '' 
		) {
		if ( ghostpool_option( 'ajax' ) != 'gp-ajax-loop' ) {	
			return;
		} else {	
			$output = '';
			$output .= ' data-cpostid="' . $c_post_id . '"';
			$output .= ' data-cats="' . $cats . '"';
			$output .= ' data-posttypes="' . $post_types . '"';
			$output .= ' data-format="' . $format . '"';
			$output .= ' data-style="' . $style . '"';
			$output .= ' data-orderby="' . $orderby . '"';
			$output .= ' data-perpage="' . $per_page . '"';
			$output .= ' data-offset="' . $offset . '"';
			$output .= ' data-imagesize="' . $image_size . '"';
			$output .= ' data-contentdisplay="' . $content_display . '"';
			$output .= ' data-excerptlength="' . $excerpt_length . '"';
			$output .= ' data-metaauthor="' . $meta_author . '"';
			$output .= ' data-metadate="' . $meta_date . '"';
			$output .= ' data-metacommentcount="' . $meta_comment_count . '"';
			$output .= ' data-metaviews="' . $meta_views . '"';
			$output .= ' data-metalikes="' . $meta_likes . '"'; 
			$output .= ' data-metacats="' . $meta_cats . '"';
			$output .= ' data-metatags="' . $meta_tags . '"';
			$output .= ' data-readmorelink="' . $read_more_link . '"';
			$output .= ' data-pagination="' . $pagination . '"';
			$output .= ' data-pagearrows="' . $page_arrows . '"';
			$output .= ' data-ranking="' . $ranking . '"';
			$output .= ' data-largeexcerptlength="' . $large_excerpt_length . '"';
			$output .= ' data-smallexcerptlength="' . $small_excerpt_length . '"';
			$output .= ' data-largemetaauthor="' . $large_meta_author . '"'; 
			$output .= ' data-smallmetaauthor="' . $small_meta_author . '"';
			$output .= ' data-largemetadate="' . $large_meta_date . '"';
			$output .= ' data-smallmetadate="' . $small_meta_date . '"';
			$output .= ' data-largemetacommentcount="' . $large_meta_comment_count . '"';
			$output .= ' data-smallmetacommentcount="' . $small_meta_comment_count . '"';
			$output .= ' data-largemetaviews="' . $large_meta_views . '"';
			$output .= ' data-smallmetaviews="' . $small_meta_views . '"';
			$output .= ' data-largemetalikes="' . $large_meta_likes . '"';
			$output .= ' data-smallmetalikes="' . $small_meta_likes . '"';
			$output .= ' data-largemetacats="' . $large_meta_cats . '"';
			$output .= ' data-smallmetacats="' . $small_meta_cats . '"';
			$output .= ' data-largemetatags="' . $large_meta_tags . '"';
			$output .= ' data-smallmetatags="' . $small_meta_tags . '"';
			$output .= ' data-largereadmorelink="' . $large_read_more_link . '"';
			$output .= ' data-smallreadmorelink="' . $small_read_more_link . '"';
			return apply_filters( 'ghostpool_filter_variables', $output );
		}	
	}
}

/**
 * Filter queries
 *
 */
if ( ! function_exists( 'ghostpool_filter_queries' ) ) {
	function ghostpool_filter_queries() {
		if ( ghostpool_option( 'ajax' ) == 'gp-ajax-loop' ) {			
			
			if ( ! wp_verify_nonce( $_GET['ghostpool_filters_nonce'], 'ghostpool_filters_action' ) )
				die();
	
			// Use filtered category if selected
			if ( isset( $_GET['cats_filtered'] ) && $_GET['cats_filtered'] != '0' ) {
				$cats = $_GET['cats_filtered'];
			} elseif ( isset( $_GET['tab_cat_filtered'] ) && $_GET['tab_cat_filtered'] != '0' ) {
				$cats = $_GET['tab_cat_filtered'];	
			} else {
				$cats = $_GET['cats'];
			}
						
			// Use filtered template if selected
			if ( isset( $_GET['templates_filtered'] ) && $_GET['templates_filtered'] != '0' ) {
				$templates = explode( ',', $_GET['templates_filtered'] );
			} else {
				$templates = explode( ',', $_GET['templates'] );
			}
			
			// Use filtered orderby if selected
			if ( isset( $_GET['orderby_filtered'] ) && $_GET['orderby_filtered'] != '0' ) {
				$orderby = $_GET['orderby_filtered'];
			} else {
				$orderby = $_GET['orderby'];
			}	

			// Page IDs
			if ( isset( $_GET['pageids'] ) ) {
				$page_ids = explode( ',', $_GET['pageids'] );
			} else {
				$page_ids = '';
			}
		
			// Get theme options from filter values
			$ranking = isset( $_GET['ranking'] ) ? $_GET['ranking'] : '';
			$format = isset( $_GET['format'] ) ? $_GET['format'] : '';
			$style = isset( $_GET['style'] ) ? $_GET['style'] : '';
			$per_page = isset( $_GET['perpage'] ) ? $_GET['perpage'] : '';
			$image_size = isset( $_GET['imagesize'] ) ? $_GET['imagesize'] : '';
			$content_display = isset( $_GET['contentdisplay'] ) ? $_GET['contentdisplay'] : '';
			$excerpt_length = isset( $_GET['excerptlength'] ) ? $_GET['excerptlength'] : '0';
			$meta_author = isset( $_GET['metaauthor'] ) ? $_GET['metaauthor'] : '';
			$meta_date = isset( $_GET['metadate'] ) ? $_GET['metadate'] : '';
			$meta_comment_count = isset( $_GET['metacommentcount'] ) ? $_GET['metacommentcount'] : '';
			$meta_views = isset( $_GET['metaviews'] ) ? $_GET['metaviews'] : '';
			$meta_likes = isset( $_GET['metalikes'] ) ? $_GET['metalikes'] : '';
			$meta_cats = isset( $_GET['metacats'] ) ? $_GET['metacats'] : '';
			$meta_tags = isset( $_GET['metatags'] ) ? $_GET['metatags'] : '';
			$read_more_link = isset( $_GET['readmorelink'] ) ? $_GET['readmorelink'] : '';
									
			// Query														
			if ( $_GET['type'] == 'menu' ) {	
				$args = array(
					'post_status' 	  => 'publish',
					'post_type'       => array( 'post', 'page' ),
					ghostpool_cats( $cats, 'param' ) => ghostpool_cats( $cats, 'variables' ),
					'orderby'         => 'date',
					'order'           => 'desc',
					'posts_per_page'  => $_GET['perpage'],
					'paged'           => $_GET['pagenumber'],		
				);
			} elseif ( $_GET['type'] == 'home' ) {			
			
				$args = $_GET['query_string'] . "&post_status=publish&paged=" . $_GET['pagenumber'];		
				$args = wp_parse_args( $args );		

			} elseif ( $_GET['type'] == 'search' OR $_GET['type'] == 'author' ) {	
			
				$defaults = array(
					'post_type' => explode( ',', $_GET['posttypes'] ),
				);
			
				$args = $_GET['query_string'] . "&post_status=publish&orderby=" . ghostpool_orderby( $orderby, 'orderby' ) . "&order=" . ghostpool_orderby( $orderby, 'order' ) . "&meta_key=" . ghostpool_orderby( $orderby, 'meta_key' ) . "&posts_per_page=" . $_GET['perpage'] . "&paged=" . $_GET['pagenumber'];	
					
				$args = wp_parse_args( $args, $defaults );	
							
			} elseif ( $_GET['type'] == 'taxonomy' ) {	
			
				$defaults = array(
					'post_type' => explode( ',', $_GET['posttypes'] ),
				);
			
				$args = $_GET['query_string'] . "&post_status=publish&orderby=" . ghostpool_orderby( $orderby, 'orderby' ) . "&order=" . ghostpool_orderby( $orderby, 'order' ) . "&meta_key=" . ghostpool_orderby( $orderby, 'meta_key' ) . "&posts_per_page=" . $_GET['perpage'] . "&paged=" . $_GET['pagenumber'];	
					
				$args = wp_parse_args( $args, $defaults );			
					
			} else {
				$args = array(
					'post_status' 	 => 'publish',
					'post_type' 	 => explode( ',', $_GET['posttypes'] ),
					'post__in'       => $page_ids,
					ghostpool_cats( $cats, 'param' ) => ghostpool_cats( $cats, 'variables' ),
					'orderby' 		 => ghostpool_orderby( $orderby, 'orderby' ),
					'order' 		 => ghostpool_orderby( $orderby, 'order' ),
					'meta_key' 		 => ghostpool_orderby( $orderby, 'meta_key' ),					
					'meta_query' 	 => ghostpool_orderby( $orderby, 'meta_query' ),
					'posts_per_page' => $_GET['perpage'],
					'offset' 		 => $_GET['offset'],
					'paged'          => $_GET['pagenumber'],					
					'post__not_in' 	 => apply_filters( 'ghostpool_post_not_in', array( $_GET['cpostid'] ) ),
				);
			}
	
			//print_r($args);
	
			$gp_query = new WP_Query( $args );
	
			// Showcase post counter
			$counter = 1;
		
			// Ranking counter
			if ( $_GET['pagenumber'] > 1 ) {
				$ranking_counter = 1 + ( $_GET['perpage'] * ( $_GET['pagenumber'] - 1 ) );
			} else {
				$ranking_counter = 1;
			}

			if ( $gp_query->have_posts() ) :
	
				$total_pages = $gp_query->max_num_pages;

				// Pagination (Arrows)
				if ( $_GET['pagearrows'] == 'enabled' OR $_GET['type'] == 'menu' ) {
					echo '<div class="gp-pagination-arrows gp-ajax-pagination">';
						if ( $_GET['pagenumber'] > 1 ) {
							echo '<a href="#" data-pagelink="' . ( $_GET['pagenumber'] - 1 ) . '" class="prev"></a>';
						} else {
							echo '<span class="prev gp-disabled"></span>';
						}
						if ( $_GET['pagenumber'] < $total_pages ) {
							echo '<a href="#" data-pagelink="' . ( $_GET['pagenumber'] + 1 ) . '" class="next"></a>';
						} else {
							echo '<span class="next gp-disabled"></span>';
						}
					echo '</div>'; 
				}
		
				if ( $_GET['type'] == 'search' ) {
					echo ghostpool_search_results_total( $gp_query->found_posts );
				}
				
				echo '<div class="gp-section-loop-inner">';
			
					if ( $_GET['format'] == 'gp-posts-masonry' ) { echo '<div class="gp-gutter-size"></div>'; }
		
					while ( $gp_query->have_posts() ) : $gp_query->the_post(); 	
			
						// Load Visual Composer shortcodes
						if ( function_exists( 'vc_set_as_theme' ) ) {
							WPBMap::addAllMappedShortcodes();
						}
						
						// Large and small options for showcase element
						if ( $_GET['type'] == 'showcase' ) {
							if ( $counter % $_GET['perpage'] == 1 ) {
								$excerpt_length = isset( $_GET['largeexcerptlength'] ) ? $_GET['largeexcerptlength'] : '0';
								$meta_author = isset( $_GET['largemetaauthor'] ) ? $_GET['largemetaauthor'] : '';
								$meta_date = isset( $_GET['largemetadate'] ) ? $_GET['largemetadate'] : '';
								$meta_comment_count = isset( $_GET['largemetacommentcount'] ) ? $_GET['largemetacommentcount'] : '';
								$meta_views = isset( $_GET['largemetaviews'] ) ? $_GET['largemetaviews'] : '';
								$meta_likes = isset( $_GET['largemetalikes'] ) ? $_GET['largemetalikes'] : '';
								$meta_cats = isset( $_GET['largemetacats'] ) ? $_GET['largemetacats'] : '';
								$meta_tags = isset( $_GET['largemetatags'] ) ? $_GET['largemetatags'] : '';
								$read_more_link = isset( $_GET['largereadmorelink'] ) ? $_GET['largereadmorelink'] : '';
							} else {
								$excerpt_length = isset( $_GET['smallexcerptlength'] ) ? $_GET['smallexcerptlength'] : '0';
								$meta_author = isset( $_GET['smallmetaauthor'] ) ? $_GET['smallmetaauthor'] : '';
								$meta_date = isset( $_GET['smallmetadate'] ) ? $_GET['smallmetadate'] : '';
								$meta_comment_count = isset( $_GET['smallmetacommentcount'] ) ? $_GET['smallmetacommentcount'] : '';
								$meta_views = isset( $_GET['smallmetaviews'] ) ? $_GET['smallmetaviews'] : '';
								$meta_likes = isset( $_GET['smallmetalikes'] ) ? $_GET['smallmetalikes'] : '';
								$meta_cats = isset( $_GET['smallmetacats'] ) ? $_GET['smallmetacats'] : '';
								$meta_tags = isset( $_GET['smallmetatags'] ) ? $_GET['smallmetatags'] : '';
								$read_more_link = isset( $_GET['smallreadmorelink'] ) ? $_GET['smallreadmorelink'] : '';
							}
						}
										
						?>

							<?php if ( $_GET['type'] == 'menu' ) {
														
								// Post link
								if ( get_post_format() == 'link' ) { 
									$link = esc_url( get_post_meta( get_the_ID(), 'link', true ) );
								} else {
									$link = get_permalink();
								}
					
								echo '<section class="' . implode( ' ' , get_post_class( 'gp-post-item' ) ) . '">';
					
									if ( has_post_thumbnail() && ! get_post_meta( get_the_ID(), 'gallery_slider', true ) ) {
								
										echo '<div class="gp-post-thumbnail gp-loop-featured"><a href="' . $link . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" target="' . get_post_meta( get_the_ID(), 'link_target', true ) . '">' . get_the_post_thumbnail( get_the_ID(), 'gp_list_image' ) . '</a></div>';
			
									} elseif ( get_post_format() == 'gallery' && get_post_meta( get_the_ID(), 'gallery_slider', true ) ) {
		
										echo '<div class="gp-post-gallery gp-loop-featured">' . ghostpool_gallery_slider_loop_content( 'gp_list_image', 250, 135 ) . '</div>';
				
									} elseif ( get_post_format() == 'video' ) {
			
										echo '<div class="gp-post-video gp-loop-featured">' . ghostpool_video_loop_content( 250, 135 ) . '</div>';
			
									}
			
									if ( get_post_format() == 'audio' ) {
										echo '<div class="gp-post-audio gp-loop-featured">' . get_template_part( 'lib/sections/taxonomies/loop-audio' ) . '</div>';
									}
			
									echo '<div class="gp-loop-title"><a href="' . $link . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" target="' . get_post_meta( get_the_ID(), 'link_target', true ) . '">' . get_the_title() . '</a></div>		
						
									<div class="gp-loop-meta">';
											
										echo '<time class="gp-post-meta gp-meta-date" datetime="' . get_the_date( 'c' ) . '">' . get_the_time( get_option( 'date_format' ) ) . '</time>';
								
									echo '</div>
									
								</section>';						

							} elseif ( $_GET['type'] == 'showcase' ) {
		
								if ( function_exists( 'ghostpool_post_loop_showcase' ) ) { ghostpool_post_loop_showcase( $style, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $counter, $ranking, $ranking_counter, $per_page ); }
						
							} elseif ( $_GET['format'] == 'gp-posts-minimal' ) {
		
								if ( function_exists( 'ghostpool_post_loop_minimal' ) ) { ghostpool_post_loop_minimal( $format, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $counter, $ranking, $ranking_counter, $per_page ); }

							} else {
		
								if ( function_exists( 'ghostpool_post_loop' ) ) { ghostpool_post_loop( $format, $style, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $counter, $ranking, $ranking_counter ); }		
													
							} ?>

					<?php $counter++; $ranking_counter++; endwhile;
			
				echo '</div>';
		
				// Pagination (Numbers)		
				if ( $total_pages > 1 && $_GET['type'] != 'menu' && $_GET['pagination'] == 'page-numbers' ) { 
					  echo '<div class="gp-pagination gp-pagination-numbers gp-ajax-pagination">';
					  echo paginate_links( array(  
						'base'      => '%_%',  
						'format'    => '/page/%#%',
						'current'   => $_GET['pagenumber'],  
						'total'     => $total_pages,  
						'type'      => 'list',
						'prev_text' => '',
						'next_text' => '',
						'end_size'  => 1,
						'mid_size'  => 1,      
					  ));
					  echo '</div>'; 
				}
				?>
	
			<?php else : ?>

				<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark' ); ?></strong>

			<?php endif; wp_reset_postdata();

			die();
			
		}		
	}	
}
add_action( 'wp_ajax_ghostpool_filters_action', 'ghostpool_filter_queries' );
add_action( 'wp_ajax_nopriv_ghostpool_filters_action', 'ghostpool_filter_queries' );

?>