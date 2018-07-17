<?php $post_preview = get_post( $_GET['id'] ); ?>
	
<article>

	<?php if ( has_post_thumbnail( $post_preview->ID ) && get_post_format( $post_preview->ID ) == '0' ) { ?>

		<div class="gp-post-thumbnail gp-entry-featured">
			<?php echo get_the_post_thumbnail( $post_preview->ID, 'gp_featured_image' ); ?>
			<?php $attachment_id = get_post( get_post_thumbnail_id( $post_preview->ID ) ); if ( $attachment_id->post_excerpt ) { ?><div class="wp-caption-text"><?php echo esc_attr( $attachment_id->post_excerpt ); ?></div><?php } ?>
		</div>

	<?php } elseif ( get_post_format( $post_preview->ID ) == 'gallery' ) { ?>

		<div class="gp-entry-featured">
			<?php get_template_part( 'lib/sections/post/entry-gallery' ); ?>
		</div>

	<?php } ?>
																
	<div class="gp-entry-content" itemprop="text">
			
		<?php echo apply_filters( 'the_content', $post_preview->post_content ); ?>

		<?php wp_link_pages( array(
			'before' => '<div class="gp-entry-pagination">',
			'after'  => '</div>',
			'next_or_number' => 'ghostpool_next_and_number',
			'nextpagelink' => '',
			'previouspagelink' => '',
		) ); ?>

	</div>					
	
	<?php if ( ghostpool_option( 'post_author_info' ) == 'enabled' ) { ?>
		<?php get_template_part( 'lib/sections/post/author-info' ); ?>
	<?php } ?>
	
	<?php wp_nonce_field( 'ghostpool_post_preview_action', '_wpnonce' ); ?>

</article>