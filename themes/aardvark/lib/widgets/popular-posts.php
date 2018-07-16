<?php if ( ! function_exists( 'ghostpool_custom_popular_posts_html_list' ) ) {
	function ghostpool_custom_popular_posts_html_list( $mostpopular, $instance ) { 
	
		$counter = 0;

		// Count number of posts
		$post_count = count( $mostpopular );
			
		?>
		
		<div class="gp-showcase-wrapper gp-posts-vertical gp-ranking">
		
			<div class="gp-section-loop">
			
				<div class="gp-section-loop-inner">
			
					<?php
		
					// loop the array of popular posts objects
					foreach( $mostpopular as $popular ) {
		
						$counter++;

						$stats = array(); // placeholder for the stats tag

						// Author option checked
						if ( $instance['stats_tag']['author'] ) {
							$stats[] = '<span class="gp-post-meta gp-meta-author">' . ghostpool_author_name( $popular->uid ). '</span>';
						}

						// Date option checked
						if ( $instance['stats_tag']['date']['active'] ) {
							$date = date_i18n( $instance['stats_tag']['date']['format'], strtotime( $popular->date ) );
							$stats[] = '<a href=\"#\" class="gp-post-meta gp-meta-date"><time itemprop="datePublished" datetime="">' . the_time( get_option( 'date_format' ) ) . '</time></a>';
						}

						// Comment count option active, display comments
						if ( $instance['stats_tag']['comment_count'] ) {
							// display text in singular or plural, according to comments count
							$stats[] = '<span class="gp-post-meta gp-meta-comments">' . sprintf(
								_n( '1 comment', '%s comments', $popular->comment_count, 'aardvark' ),
								number_format_i18n( $popular->comment_count )
							) . '</span>';
						}

						// Pageviews option checked, display views
						if ( $instance['stats_tag']['views'] ) {

							// If sorting posts by average views
							if ($instance['order_by'] == 'avg') {
								// display text in singular or plural, according to views count
								$stats[] = '<span class="gp-post-meta gp-meta-views">' . sprintf(
									_n( '1 view per day', '%s views per day', intval( $popular->pageviews ), 'aardvark' ),
									number_format_i18n( $popular->pageviews, 2 )
								) . '</span>';
							} else { // Sorting posts by views
								// display text in singular or plural, according to views count
								$stats[] = '<span class="gp-post-meta gp-meta-views">' . sprintf(
									_n( '1 view', '%s views', intval( $popular->pageviews ), 'aardvark' ),
									number_format_i18n( $popular->pageviews )
								) . '</span>';
							}
						}
		
						// Category option checked
						if ( $instance['stats_tag']['category'] ) {
							$post_cat = get_the_category( $popular->id );
							$post_cat = ( isset( $post_cat[0] ) )
							  ? '<a href="' . get_category_link( $post_cat[0]->term_id ) . '">' . $post_cat[0]->cat_name . '</a>'
							  : '';

							if ( $post_cat != '' ) {
								$stats[] = '<span class="gp-post-meta gp-meta-cats">' . sprintf( esc_html__( '%s', 'aardvark' ), $post_cat ) . '</span>';
							}
						}

						// Build stats tag
						if ( ! empty( $stats ) ) {
							$stats = '<div class="gp-loop-meta">' . join( '', $stats ) . '</div>';
						} else {
							$stats = '';
						}

						$excerpt = ''; // Excerpt placeholder

						// Excerpt option checked, build excerpt tag
						if ( $instance['post-excerpt']['active'] ) {

							$excerpt = get_excerpt_by_id( $popular->id, $instance );
							if ( ! empty( $excerpt ) ) {
								$excerpt = '<div class="wpp-excerpt">' . $excerpt . '</div>';
							}

						}
					
						// Format
						if ( $counter > 1 ) {
							$format = 'gp-posts-list';
						} else {
							$format = '';
						}
			
						// Default image sizes	
						if ( $counter > 1 ) {
							$image_size = 'gp_small_image';
						} else {
							$image_size = 'gp_column_image';
						} 
						
						// Get image dimensions
						global $_wp_additional_image_sizes;
						if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
							$image_width  = get_option( "{$image_size}_size_w" );
							$image_height  = get_option( "{$image_size}_size_h" );			
						} else {
							$image_width = $_wp_additional_image_sizes[$image_size]['width'];
							$image_height = $_wp_additional_image_sizes[$image_size]['height'];
						} 
	
						?>
			
						<?php if ( isset( $counter ) && $counter == 2 ) { ?>
							</div>
							<div class="gp-small-posts">
						<?php } elseif ( isset( $counter ) && $counter == 1 ) { ?>
							<div class="gp-large-post">
						<?php } ?>
			
							<section class="gp-post-item">
			
								<?php if ( $instance['thumbnail']['active'] ) { ?>
										
									<?php if ( has_post_thumbnail( $popular->id ) && ( ! get_post_meta( $popular->id, 'gallery_slider', true ) ) ) { ?>
									
										<div class="gp-post-thumbnail gp-loop-featured">
											<a href="<?php echo get_the_permalink( $popular->id ); ?>" title="<?php echo esc_attr( $popular->title ); ?>">											
												<div class="gp-ranking-counter"><span><?php echo absint( $counter ); ?></span></div>
												<?php echo get_the_post_thumbnail( $popular->id, $image_size ); ?>
											</a>					
										</div>
							
									<?php } elseif ( get_post_format( $popular->id ) == 'gallery' && get_post_meta( get_the_ID(), 'gallery_slider', true ) ) { ?>

										<div class="gp-post-gallery gp-loop-featured">
											<div class="gp-ranking-counter"><span><?php echo absint( $counter ); ?></span></div>
											<?php echo ghostpool_gallery_slider_loop_content( $image_size, $image_width, $image_height, $format, $popular->id ); ?>
										</div>

									<?php } elseif ( get_post_format( $popular->id ) == 'video' ) { ?>
						
										<div class="gp-post-video gp-loop-featured"<?php if ( $format == 'gp-posts-list' ) { ?> style="width: <?php echo absint( $image_width ); ?>px;"<?php } ?>>
											<div class="gp-ranking-counter"><?php echo absint( $counter ); ?></div>
											<?php echo ghostpool_video_loop_content( $image_width, $image_height, $format, $popular->id ); ?>
										</div>
			
									<?php } ?>
	
									<?php if ( get_post_format( $popular->id ) == 'audio' && $counter == '1' ) { ?>
										<div class="gp-post-audio gp-loop-featured">
											<?php get_template_part( 'lib/sections/taxonomies/loop-audio' ); ?>
										</div>
									<?php } ?>
				
								<?php } else { ?>
								
									<div class="gp-ranking-counter"><span><?php echo absint( $counter ); ?></span></div>
								
								<?php } ?>
			
								<div class="gp-loop-content">
					
									<h3 class="gp-loop-title"><a href="<?php echo get_the_permalink( $popular->id ); ?>" title="<?php echo esc_attr( $popular->title ); ?>"><?php echo get_title_sub_by_id( $popular->id, $instance ); ?></a></h3>
						
									<?php echo wp_kses_post( $stats ); ?>
						
									<?php echo wp_kses_post( $excerpt ); ?>
						
								</div>
					
							</section>
			
						<?php if ( isset( $counter ) && $counter == $post_count ) { ?>
							</div>
						<?php } ?>

					<?php } ?>

				</div>
			</div>
		</div>
	<?php }
}
add_filter( 'wpp_custom_html', 'ghostpool_custom_popular_posts_html_list', 10, 2 );

/*
 * Get custom title
 *
 */
function get_title_sub_by_id($id, $instance) {
	/*$cache = &$this->__cache(__FUNCTION__, array());
	if ( isset($cache[$id]) ) {
		return $cache[$id];
	}*/
	// TITLE
	$title_sub = get_the_title( $id );
	// truncate title
	if ($instance['shorten_title']['active']) {
		// by words
		if (isset($instance['shorten_title']['words']) && $instance['shorten_title']['words']) {
			$words = explode(" ", $title_sub, $instance['shorten_title']['length'] + 1);
			if (count($words) > $instance['shorten_title']['length']) {
				array_pop($words);
				$title_sub = rtrim( implode(" ", $words), ",." ) . " ...";
			}
		}
		elseif (strlen($title_sub) > $instance['shorten_title']['length']) {
			$title_sub = rtrim( mb_substr($title_sub, 0, $instance['shorten_title']['length'], get_bloginfo( 'charset' ) ), " ,." ) . "...";
		}
	}
	return $title_sub;
}
		
/*
 * Get custom excerpt
 *
 */
function get_excerpt_by_id($id, $instance){

	$excerpt = "";
	// WPML support, get excerpt for current language
	if ( defined('ICL_LANGUAGE_CODE') && function_exists('icl_object_id') ) {
		$current_id = icl_object_id( $id, get_post_type( $id ), true, ICL_LANGUAGE_CODE );
		$the_post = get_post( $current_id );
		$excerpt = ( empty($the_post->post_excerpt) )
		  ? $the_post->post_content
		  : $the_post->post_excerpt;
	} // Use ol' plain excerpt
	else {
		$the_post = get_post( $id );
		$excerpt = ( empty($the_post->post_excerpt) )
		  ? $the_post->post_content
		  : $the_post->post_excerpt;
		// RRR added call to the_content filters, allows qTranslate to hook in.
		if ( function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage') )
			$excerpt = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage( $excerpt );
	}
	// remove caption tags
	$excerpt = preg_replace( "/\[caption.*\[\/caption\]/", "", $excerpt );
	// remove Flash objects
	$excerpt = preg_replace( "/<object[0-9 a-z_?*=\":\-\/\.#\,\\n\\r\\t]+/smi", "", $excerpt );
	// remove Iframes
	$excerpt = preg_replace( "/<iframe.*?\/iframe>/i", "", $excerpt);
	// remove WP shortcodes
	$excerpt = strip_shortcodes( $excerpt );
	
	// remove style/script tags
	$excerpt = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $excerpt );
	// remove HTML tags if requested
	if ( $instance['post-excerpt']['keep_format'] ) {
		$excerpt = strip_tags($excerpt, '<a><b><i><em><strong>');
	} else {
		$excerpt = strip_tags($excerpt);
		// remove URLs, too
		$excerpt = preg_replace( '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS', '', $excerpt );
	}
	// Fix RSS CDATA tags
	$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
	// do we still have something to display?
	if ( !empty($excerpt) ) {
		// truncate excerpt
		if ( isset($instance['post-excerpt']['words']) && $instance['post-excerpt']['words'] ) { // by words
			$words = explode(" ", $excerpt, $instance['post-excerpt']['length'] + 1);
			if ( count($words) > $instance['post-excerpt']['length'] ) {
				array_pop($words);
				$excerpt = rtrim( implode(" ", $words), ".," ) . " ...";
			}
		} else { // by characters
			if ( strlen($excerpt) > $instance['post-excerpt']['length'] ) {
				$excerpt = rtrim( mb_substr( $excerpt, 0, $instance['post-excerpt']['length'], get_bloginfo('charset') ), ".," ) . "...";
			}
		}
	}
	// Balance tags, if needed
	if ( $instance['post-excerpt']['keep_format'] ) {
		$excerpt = force_balance_tags($excerpt);
	}
	return $excerpt;
}

?>