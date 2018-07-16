<?php

require_once( get_template_directory() . '/lib/inc/post-loop.php' );
require_once( get_template_directory() . '/lib/inc/post-loop-showcase.php' );

/**
 * Remove hentry tag from post loop
 *
 */
if ( ! function_exists( 'ghostpool_remove_hentry' ) ) {
	function ghostpool_remove_hentry( $classes ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		return $classes;
	}
}
add_filter( 'post_class', 'ghostpool_remove_hentry' );


/**
 * Exclude categories from post loop
 *
 */
if ( ! function_exists( 'ghostpool_exclude_cats' ) ) {
	function ghostpool_exclude_cats( $post_id, $no_comma = false ) {
					
		// Get all post categories
		$cats = wp_get_object_terms( $post_id, 'category', array( 'fields' => 'ids' ) );
					
		// Construct categories loop
		if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) { 		
			$cat_link = '';
			foreach( $cats as $cat ) {
				if ( has_term( $cat, 'category', $post_id ) ) {
					$term = get_term( $cat, 'category' );
					$term_link = get_term_link( $term, 'category' );	
					if ( ! $term_link OR is_wp_error( $term_link ) ) {
						continue;
					}
					$term_id = $term->term_id;
					$term_data = get_option( "taxonomy_$term_id" );
					if ( isset( $term_data['exclude'] ) && $term_data['exclude'] == 'enabled' ) {
					} else {
						if ( $no_comma == true ) {
							$cat_link .= '<a href="' . esc_url( $term_link ) . '">' . esc_attr( $term->name ) . '</a>';
						} else {
							$cat_link .= '<a href="' . esc_url( $term_link ) . '">' . esc_attr( $term->name ) . '</a>, ';
						}
					}	
				}
			}
			$cat_link = rtrim ( $cat_link, ', ' );
			return $cat_link;
		}

	}
}

/**
 * Change excerpt character length
 *
 */	
if ( ! function_exists( 'ghostpool_excerpt_length' ) ) {
	function ghostpool_excerpt_length() {
		if ( function_exists( 'buddyboss_global_search_init' ) && is_search() ) {
			return 50;
		} else {
			return 10000;
		}	
	}
}
add_filter( 'excerpt_length', 'ghostpool_excerpt_length' );

/**
 * Custom excerpt format
 *
 */	
if ( ! function_exists( 'ghostpool_excerpt' ) ) {
	function ghostpool_excerpt( $length, $read_more_link = 'disabled', $style = '' ) {
		if ( $read_more_link == 'enabled' ) {
			if ( $style == 'gp-style-modern' ) {
				$more_text = '...<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="gp-read-more" title="' . the_title_attribute( 'echo=0&post=' . get_the_ID() ) . '"><span class="button">' . esc_html__( 'Read More', 'aardvark' ) . '</span></a>';
			} else {
				$more_text = '...<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="gp-read-more" title="' . the_title_attribute( 'echo=0&post=' . get_the_ID() ) . '">' . esc_html__( 'Read More', 'aardvark' ) . '</a>';
			}	
		} else {
			$more_text = '...';
		}
		$excerpt = get_the_excerpt();					
		$excerpt = strip_tags( $excerpt );
		if ( function_exists( 'mb_strlen' ) && function_exists( 'mb_substr' ) ) { 
			if ( mb_strlen( $excerpt ) > $length ) {
				$excerpt = mb_substr( $excerpt, 0, $length ) . $more_text;
			}
		} else {
			if ( strlen( $excerpt ) > $length ) {
				$excerpt = substr( $excerpt, 0, $length ) . $more_text;
			}	
		}
		return $excerpt;
	}
}

/**
 * Loop meta
 *
 */	
if ( ! function_exists( 'ghostpool_loop_meta' ) ) {	
	function ghostpool_loop_meta( $author = '', $date = '', $comment_count = '', $views = '', $likes = '', $cats = '' ) {

		if ( $author == 1 OR $date == 1 OR $comment_count == 1 OR $views == 1 OR $likes == 1 OR $cats == 1 ) { ?>

			<div class="gp-loop-meta">
		
				<?php if ( $author == '1' ) { ?><span class="gp-post-meta gp-meta-author"><?php echo ghostpool_author_name( get_the_ID() ); ?></span><?php } ?>

				<?php if ( $date == '1' ) { ?>	
					<span class="gp-post-meta gp-meta-date"><a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>><time itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time></a></span>
				<?php } ?>

				<?php if ( $comment_count == '1' ) { ?><span class="gp-post-meta gp-meta-comments"><?php comments_popup_link( esc_html__( 'No Comments', 'aardvark' ), esc_html__( '1 Comment', 'aardvark' ), esc_html__( '% Comments', 'aardvark' ), 'comments-link', esc_html__( 'Comments Closed', 'aardvark' ) ); ?></span><?php } ?>

				<?php if ( function_exists( 'wpp_get_views' ) && $views == '1' ) { ?><span class="gp-post-meta gp-meta-views"><?php if ( function_exists( 'wpp_get_views' ) ) { echo wpp_get_views( get_the_ID() ); } ?> <?php esc_html_e( 'views', 'aardvark' ); ?></span><?php } ?>		
	
				<?php if ( $likes == '1' ) { ?>
					<span class="gp-post-meta gp-meta-likes"><?php if ( function_exists( 'ghostpool_voting_show_up_votes' ) ) { echo ghostpool_voting_show_up_votes(); } ?></span>
				<?php } ?>

				<?php if ( $cats == '1' ) { ?>
					<span class="gp-post-meta gp-meta-cats"><?php echo ghostpool_exclude_cats( get_the_ID(), false, true ); ?></span>
				<?php } ?>
			
			</div>

		<?php }
	}
}

/**
 * Loop gallery
 *
 */	
if ( ! function_exists( 'ghostpool_gallery_slider_loop_content' ) ) {
	function ghostpool_gallery_slider_loop_content( $image_size = '', $image_width = '', $image_height = '', $format = '', $post_id = '' ) {
	
		if ( $post_id == '' ) {
			$post_id = get_the_ID();
		}
		
		$output = '';

		// Get image IDs
		$image_ids = array_filter( explode( ',', get_post_meta( $post_id, 'gallery_slider', true ) ) );
		
		if ( $image_ids ) {
		
			if ( $format == 'gp-posts-list' ) {
				$width = ' style="width: ' . absint( $image_width ) . 'px;"';
			} else {
				$width = '';
			}	
			
			$output .= '<div class="gp-post-format-gallery-slider gp-slider"' . $width . '> 
		
				 <ul class="slides">';
			
					foreach ( $image_ids as $image_id ) { 
					
						$image = wp_get_attachment_image_src( $image_id, $image_size );
						
						if ( get_post_meta( $image_id, '_wp_attachment_image_alt', true) ) { 
							$alt_text = esc_attr( get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ); 
						} else { 
							$alt_text = the_title_attribute( 'echo=0' ); 
						}
				
						$output .= '<li>';
							if ( $image[0] ) {
								$output .= '<img src="' . esc_url( $image[0] ) . '" width="' . absint( $image_width ) . '" height="' . absint( $image_height ) . '" alt="' . $alt_text . '" />';
							}
						$output .= '</li>';
				
					}
			
				$output .= '</ul>
		
			</div>';

		}
					
		return $output;

	}
}

/**
 * Loop video
 *
 */	
if ( ! function_exists( 'ghostpool_video_loop_content' ) ) {
	function ghostpool_video_loop_content( $image_width = '', $image_height = '', $format = '', $post_id = '' ) {	

		global $wp_embed;

		if ( $post_id == '' ) {
			$post_id = get_the_ID();
		}
				
		 if ( get_post_meta( $post_id, 'video_embed_url', true ) ) {

			$output = do_shortcode( $wp_embed->run_shortcode( '[embed width="' . absint( $image_width ) . '" height="' . absint( $image_height ) . '"]' . esc_url( get_post_meta( $post_id, 'video_embed_url', true ) ) . '[/embed]' ) ); 
	
		} else {

			$mp4 = '';
			$m4v = '';
			$webm = '';
			$ogv = '';
	
			if ( get_post_meta( $post_id, 'video_mp4_url', true ) ) {	
				$mp4 = get_post_meta( $post_id, 'video_mp4_url', true );
				$mp4 = $mp4['url'];
			}

			if ( get_post_meta( $post_id, 'video_m4v_url', true ) ) {		
				$m4v = get_post_meta( $post_id, 'video_m4v_url', true );
				$m4v = $m4v['url'];
			}

			if ( get_post_meta( $post_id, 'video_webm_url', true ) ) {	
				$webm = get_post_meta( $post_id, 'video_webm_url', true );
				$webm = $webm['url'];
			}

			if ( get_post_meta( $post_id, 'video_ogv_url', true ) ) {	
				$ogv = get_post_meta( $post_id, 'video_ogv_url', true );
				$ogv = $ogv['url'];
			}

			$output = do_shortcode( '[video mp4="' . esc_url( $mp4 ) . '" m4v="' . esc_url( $m4v ) . '" webm="' . esc_url( $webm ). '" ogv="' . esc_url( $ogv ) . '" width="' . absint( $image_width ) . '" height="' . absint( $image_height ) . '"][/video]' );

		}
		
		if ( $format == 'gp-posts-list' ) {
			$style = ' style="height: ' . absint( $image_height ) . 'px;"';
		} else {
			$style = '';
		}
		
		if ( ! empty( $output ) ) {
			return '<div class="gp-video-wrapper"' . $style . '>' . $output . '</div>';
		}
		
	}
}

?>