<?php

// Page options
$display_image = ghostpool_option( 'image' ) == 'default' ? ghostpool_option( 'post_image' ) : ghostpool_option( 'image' );

?>

<article <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">

	<?php echo ghostpool_meta_data( get_the_ID() ); ?>

	<?php if ( ! function_exists( 'pmpro_has_membership_access' ) OR ( function_exists( 'pmpro_has_membership_access' ) && pmpro_has_membership_access() ) ) { ?>

		<?php if ( has_post_thumbnail() && $display_image == 'enabled' && get_post_format() != 'gallery' && get_post_format() != 'video' ) { ?>

			<div class="gp-post-thumbnail gp-entry-featured">
				<?php the_post_thumbnail( 'gp_featured_image' ); ?>
				<?php $attachment_id = get_post( get_post_thumbnail_id() ); if ( $attachment_id->post_excerpt ) { ?><div class="wp-caption-text"><?php echo esc_attr( $attachment_id->post_excerpt ); ?></div><?php } ?>
			</div>

		<?php } elseif ( get_post_format() == 'video' ) { ?>

			<div class="gp-entry-featured">
				<?php get_template_part( 'lib/sections/post/entry-video' ); ?>
			</div>

		<?php } elseif ( get_post_format() == 'gallery' ) { ?>

			<div class="gp-entry-featured">
				<?php get_template_part( 'lib/sections/post/entry-gallery' ); ?>
			</div>

		<?php } ?>

		<?php if ( get_post_format() == 'audio' ) { ?>

			<div class="gp-entry-featured">
				<?php get_template_part( 'lib/sections/post/entry-audio' ); ?>
			</div>

		<?php } ?>

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

	<?php if ( ! function_exists( 'pmpro_has_membership_access' ) OR ( function_exists( 'pmpro_has_membership_access' ) && pmpro_has_membership_access() ) ) { ?>

		<?php if ( ghostpool_option( 'post_meta', 'tags' ) == '1' ) {
			the_tags( '<div class="gp-entry-tags">' . esc_html__( 'Tags: ', 'aardvark' ), ', ', '</div>' );
		} ?>

		<?php
		/*
		Tire do comentário para exibir uma barra de compartilhar.
		if ( function_exists( 'ghostpool_share_icons' ) && ghostpool_option( 'post_meta', 'share_icons' ) == '1' ) {
			echo ghostpool_share_icons();
		}
		*/
		?>

		<?php if ( ghostpool_option( 'post_author_info' ) == 'enabled' ) {
			get_template_part( 'lib/sections/post/author-info' );
		} ?>

		<?php if ( ! is_singular( [ 'oportunidade', 'job_listing' ] ) && function_exists( 'ghostpool_voting' ) && ghostpool_option( 'post_voting' ) == 'enabled' ) {
			echo ghostpool_voting( '', '', ghostpool_option( 'post_voting_title' ) );
		} ?>

		<?php if ( ! is_singular( 'job_listing' ) && ghostpool_option( 'post_meta', 'post_nav' ) == '1' ) {
			echo ghostpool_post_navigation();
		} ?>

		<?php if ( ghostpool_option( 'post_related_items' ) == 'enabled' ) {
			get_template_part( 'lib/sections/post/related-items' );
		} ?>

		<?php comments_template(); ?>

	<?php } ?>

</article>
