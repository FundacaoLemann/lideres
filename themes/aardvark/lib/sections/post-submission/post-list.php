<?php if ( is_user_logged_in() ) {

	if ( get_option( 'permalink_structure' ) ) {
		$permalink_structure = '?';
	} else { 
		$permalink_structure = '&';
	}
					
	$current_user = wp_get_current_user();

	$args = array(
		'post_status' => 'publish',
		'author' => $current_user->ID,
		'post_type' => 'post',
		'meta_key' => 'ghostpool_post_submission_form_id',
		'paged' => 1,
		'posts_per_page' => -1,
	);
	
	$args = apply_filters( 'ghostpool_published_posts_query', $args, $current_user->ID );

	$gp_query = new WP_Query( $args ); ?>

	<div class="gp-posts-wrapper gp-approved-posts-wrapper gp-posts-list gp-style-classic gp-align-left">

		<div class="gp-divider-title-bg">
			<div class="gp-divider-title"><?php esc_html_e( 'Approved Posts', 'aardvark' ); ?></div>
		</div>	

		<?php if ( $gp_query->have_posts() ) : ?>
			
			<div class="gp-section-loop">
			
				<div class="gp-section-loop-inner">
			
					<?php while ( $gp_query->have_posts() ) : $gp_query->the_post(); ?>

					   <section <?php post_class( 'gp-post-item' ); ?>>
					   
					   		<?php if ( has_post_thumbnail() ) { ?>
								<div class="gp-post-thumbnail gp-loop-featured">
									<a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>>
										<?php the_post_thumbnail( 'gp_small_image' ); ?>
									</a>					
								</div>
							<?php } ?>
											
							<div class="gp-loop-content">
							
								<div class="gp-loop-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>
							
								<div class="gp-loop-meta">
									<?php if ( ghostpool_option( 'post_editing' ) != 'disabled' ) { ?><span class="gp-post-meta"><a href="<?php echo get_permalink( ghostpool_option( 'post_submission_page' ) ) . $permalink_structure; ?>post_edit=1&id=<?php the_ID(); ?>"><?php esc_html_e( 'Edit', 'aardvark' ); ?></a></span><?php } ?>
									<?php if ( ghostpool_option( 'post_deleting' ) == 'enabled' ) { ?><span class="gp-post-meta"><a href="<?php echo get_delete_post_link( get_the_ID() ); ?>" onClick="if ( confirm( '<?php esc_html_e( 'Are you sure you want to delete this post?', 'aardvark' ); ?>' ) ) return true; else return false;"><?php esc_html_e( 'Delete', 'aardvark' ); ?></a></span><?php } ?>
								</div>
								
							</div>
												
						</section>
								
					<?php endwhile; ?>
					
				</div>	

			</div>

		<?php else : ?>

			<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark' ); ?></strong>

		<?php endif; wp_reset_postdata(); ?>

	</div>

	<?php

	$args = array(
		'post_status' => 'pending',
		'author' => $current_user->ID,
		'post_type' => 'post',
		'meta_key' => 'ghostpool_post_submission_form_id',
		'paged' => 1,
		'posts_per_page' => -1,
	);
	
	$args = apply_filters( 'ghostpool_pending_posts_query', $args, $current_user->ID );

	$gp_query = new WP_Query( $args ); ?>

	<div class="gp-posts-wrapper gp-pending-posts-wrapper gp-posts-list gp-style-classic gp-align-left">

		<div class="gp-divider-title-bg">
			<div class="gp-divider-title"><?php esc_html_e( 'Pending Posts', 'aardvark' ); ?></div>
		</div>	

		<?php if ( $gp_query->have_posts() ) : ?>
		
			<div class="gp-section-loop">
		
				<div class="gp-section-loop-inner">
				
					<?php while ( $gp_query->have_posts() ) : $gp_query->the_post(); ?>
	   
						<section <?php post_class( 'gp-post-item' ); ?>>

					   		<?php if ( has_post_thumbnail() ) { ?>
								<div class="gp-post-thumbnail gp-loop-featured">
									<a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?>>
										<?php the_post_thumbnail( 'gp_small_image' ); ?>
									</a>					
								</div>
							<?php } ?>

							<div class="gp-loop-content">
							
								<div class="gp-loop-title"><a href="<?php echo get_permalink( ghostpool_option( 'post_submission_page' ) ) . $permalink_structure; ?>post_preview=1&id=<?php the_ID(); ?>&_wpnonce=<?php echo wp_create_nonce( 'ghostpool_post_preview_action' ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>
							
								<div class="gp-loop-meta">
									<?php if ( ghostpool_option( 'post_editing' ) != 'disabled' ) { ?><span class="gp-post-meta"><a href="<?php echo get_permalink( ghostpool_option( 'post_submission_page' ) ) . $permalink_structure; ?>post_edit=1&id=<?php the_ID(); ?>"><?php esc_html_e( 'Edit', 'aardvark' ); ?></a></span><?php } ?>
									<?php if ( ghostpool_option( 'post_deleting' ) == 'enabled' ) { ?><span class="gp-post-meta"><a href="<?php echo get_delete_post_link( get_the_ID() ); ?>" onClick="if ( confirm( '<?php esc_html_e( 'Are you sure you want to delete this post?', 'aardvark' ); ?>' ) ) return true; else return false;"><?php esc_html_e( 'Delete', 'aardvark' ); ?></a></span><?php } ?>
								</div>
								
							</div>
						
						</section>	

					<?php endwhile; ?>
					
				</div>	

			</div>

		<?php else : ?>

			<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark' ); ?></strong>

		<?php endif; wp_reset_postdata(); ?>

	</div>

<?php } else { ?>

	<strong class="gp-no-items-found"><?php esc_html_e( 'You must be logged in to view your posts.', 'aardvark' ); ?></strong>

<?php } ?>