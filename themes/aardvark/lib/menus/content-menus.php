<?php if ( ! function_exists( 'ghostpool_content_menu' ) ) {
	function ghostpool_content_menu( $menu_type = '', $item = '', $submenu_depth_class_names = '', $class_names = '' ) {

		// Posts per page depending on menu type
		if ( $menu_type == 'gp-content-menu' ) {
			$per_page = 5;
		} else {
			$per_page = 4;
		}
			
		$content_args = array(
			'post_status' 	      => 'publish',
			'post_type'           => array( 'post', 'page' ),
			'cat' 				  => $item->object_id,
			'orderby'             => 'date',
			'order'           	  => 'desc',
			'posts_per_page'      => $per_page,
			'paged'               => 1,
		);

		$gp_query = new WP_Query( $content_args );

		$output = '<ul class="sub-menu ' . $submenu_depth_class_names . '">
		<li id="tab-nav-menu-item-'. $item->ID . '" class="' . $class_names . '"' . ' data-type="menu" data-cats="' . $item->object_id . '" data-perpage="' . $per_page . '">';

			if ( $gp_query->have_posts() ) :

				if ( $menu_type == 'gp-tab-content-menu' ) {
			
					if ( wp_is_mobile() ) {
						$mobile_menu_class = 'gp-mobile-menu-tabs';
					} else {
						$mobile_menu_class = '';
					}
		
					$terms = get_terms( array( 
						'taxonomy' => $item->object, 
						'parent'  => $item->object_id,
					) );
					
					if ( ! empty( $terms ) ) {
						$output .= '<ul class="gp-menu-tabs ' . $mobile_menu_class . '">
							<li id="' . $item->object_id . '" class="menu-item gp-selected"><a href="' . $item->url . '">' . esc_html__( 'All', 'aardvark' ) . '</a></li>';		
							foreach( $terms as $term ) {
								if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
									$output .= '<li id="' . $term->term_id . '" class="menu-item"><a href="' . get_term_link( $term->term_id ) . '">' . $term->name . '</a></li>';
								}
							}
						$output .= '</ul>';
					}
						
				}

				$output .= '<div class="gp-section-loop ' . ghostpool_option( 'ajax' ) . '">';
			
					if ( ghostpool_option( 'ajax' ) == 'gp-ajax-loop' ) {
						$output .= '<div class="gp-pagination gp-standard-pagination gp-pagination-arrows">' . ghostpool_pagination_arrows( $gp_query->max_num_pages ) . '</div>';
					}	
	
					$output .= '<div class="gp-section-loop-inner">';

						while ( $gp_query->have_posts() ) : $gp_query->the_post();
										
							// Post link
							if ( get_post_format() == 'link' ) { 
								$link = esc_url( get_post_meta( get_the_ID(), 'link', true ) );
								$target = 'target="' . get_post_meta( get_the_ID(), 'link_target', true ) . '"';
							} else {
								$link = get_permalink();
								$target = '';
							}
									
							$output .= '<section class="' . implode( ' ' , get_post_class( 'gp-post-item' ) ) . '">';

								if ( has_post_thumbnail() ) {
				
									$output .= '<div class="gp-post-thumbnail gp-loop-featured">
										<a href="' . $link . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '"' . $target . '>' . get_the_post_thumbnail( get_the_ID(), 'gp_list_image' ) . '</a>
									</div>';
		
								} elseif ( get_post_format() == 'gallery' && get_post_meta( get_the_ID(), 'gallery_slider', true ) ) {
		
									$output .= '<div class="gp-post-gallery gp-loop-featured">' . ghostpool_gallery_slider_loop_content( 'gp_list_image', 250, 135 ) . '</div>';
			
								} elseif ( get_post_format() == 'video' ) {
		
									$output .= '<div class="gp-post-video gp-loop-featured">' . ghostpool_video_loop_content( 250, 135 ) . '</div>';
		
								}
		
								if ( get_post_format() == 'audio' ) {
									$output .= '<div class="gp-post-audio gp-loop-featured">' . get_template_part( 'lib/sections/taxonomies/loop-audio' ) . '</div>';
								}
		
								$output .= '<div class="gp-loop-title"><a href="' . $link . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '"'. $target. '>' . get_the_title() . '</a></div>
					
								<div class="gp-loop-meta">';
							
									$output .= '<time class="gp-post-meta gp-meta-date" datetime="' . get_the_date( 'c' ) . '">' . get_the_time( get_option( 'date_format' ) ) . '</time>';
							
								$output .= '</div>
	
							</section>';
	
						endwhile; 

					$output .= '</div>
		
				</div>';
						
			endif; wp_reset_postdata();

		$output .= '</li></ul>';
	
		return $output;
		
	}
		
} ?>