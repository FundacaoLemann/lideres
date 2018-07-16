<?php

// Page options
$display_image = ghostpool_option( 'image' ) == 'default' ? ghostpool_option( 'page_image' ) : ghostpool_option( 'image' );

if ( has_post_thumbnail() && $display_image == 'enabled' ) { ?>
	<div class="gp-post-thumbnail gp-entry-featured">
		<?php the_post_thumbnail( 'gp_featured_image' ); ?>
		<?php $attachment_id = get_post( get_post_thumbnail_id() ); if ( $attachment_id->post_excerpt ) { ?><div class="wp-caption-text"><?php echo esc_attr( $attachment_id->post_excerpt ); ?></div><?php } ?>
	</div>
<?php } ?>

<div class="gp-entry-content" itemprop="text">

	<?php the_content(); ?>

	<?php wp_link_pages( array(
		'before' => '<div class="gp-entry-pagination">',
		'after'  => '</div>',
		'next_or_number' => 'ghostpool_next_and_number',
		'nextpagelink' => '',
		'previouspagelink' => '',
	) ); ?>

</div>

<?php if ( function_exists( 'ghostpool_voting' ) && ghostpool_option( 'page_voting' ) == 'enabled' ) {
	echo ghostpool_voting( '', '', ghostpool_option( 'page_voting_title' ) );
} ?>	
	
<?php if ( ghostpool_option( 'page_author_info' ) == 'enabled' ) {
	get_template_part( 'lib/sections/post/author-info' );
} ?>

<?php comments_template(); ?>