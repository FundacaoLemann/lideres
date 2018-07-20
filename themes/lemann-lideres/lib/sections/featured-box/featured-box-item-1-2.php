<?php

global $gp_counter, $format, $title, $title_length, $excerpt_length, $meta_cats, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes;

// Video class
if ( get_post_format() == 'video' && ! has_post_thumbnail() ) {
	$video_class = ' gp-has-video';
} else {
	$video_class = '';
}

?>

<a href="
<?php
if ( get_post_format() == 'link' ) {
	echo esc_url( get_post_meta( get_the_ID(), 'link', true ) );
} else {
	the_permalink(); }
?>
" title="<?php the_title_attribute(); ?>"
										<?php
										if ( get_post_format() == 'link' ) {
											?>
	 target="<?php echo esc_attr( get_post_meta( get_the_ID(), 'link_target', true ) ); ?>"<?php } ?> class="gp-featured-box-link
	<?php
	if ( $video_class ) {
		echo esc_attr( $video_class ); }
	?>
">


	<?php
	if ( has_post_thumbnail() ) {

		if ( $gp_counter % 5 == 1 ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'gp_featured_box_large_image' );
		} else {

			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'gp_featured_box_small_image' );
		}

		if ( $image ) {
			?>
			<span class="gp-featured-box-image" style="background-image: url(<?php echo esc_url( $image[0] ); ?>);"></span>
			<?php
		}
	} elseif ( get_post_format() == 'video' ) {
		?>

		<span class="gp-featured-box-video">
			<?php echo ghostpool_video_loop_content(); ?>
		</span>

		<?php
	}
	?>

</a>

<?php if ( $title == 'enabled' or $excerpt_length > 0 ) { ?>

	<div class="gp-featured-caption">

		<div class="gp-featured-caption-inner">

			<?php if ( $meta_cats == '1' ) { ?>
				<div class="gp-featured-box-cats"><?php echo ghostpool_exclude_cats( get_the_ID(), true, true ); ?></div>
			<?php } ?>

			<?php
			if ( $title == 'enabled' ) {
				$featured_caption_title = get_the_title();
				if ( $title_length > 0 && ( strlen( $featured_caption_title ) > $title_length ) ) {
					$featured_caption_title = substr( $featured_caption_title, 0, $title_length ) . '...';
				}
				?>

				<h3 class="gp-featured-caption-title"><?php echo esc_attr( $featured_caption_title ); ?></h3>
			<?php } ?>

			<?php if ( $excerpt_length > 0 ) { ?>
				<div class="gp-featured-caption-text"><?php echo ghostpool_excerpt( $excerpt_length ); ?></div>
			<?php } ?>

			<?php if ( $meta_author == '1' or $meta_date == '1' or $meta_comment_count == '1' or $meta_views == '1' or $meta_likes == '1' ) { ?>

				<div class="gp-loop-meta">

					<?php if ( $meta_author == '1' ) { ?>
						<span class="gp-post-meta gp-meta-author"><?php echo ghostpool_author_name( get_the_ID() ); ?></span>
					<?php } ?>

					<?php if ( $meta_date == '1' ) { ?>
						<time class="gp-post-meta gp-meta-date" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
					<?php } ?>

					<?php if ( $meta_comment_count == '1' ) { ?>
						<span class="gp-post-meta gp-meta-comments"><?php comments_popup_link( esc_html__( 'No Comments', 'aardvark' ), esc_html__( '1 Comment', 'aardvark' ), esc_html__( '% Comments', 'aardvark' ), 'comments-link', esc_html__( 'Comments Closed', 'aardvark' ) ); ?></span>
					<?php } ?>

					<?php if ( function_exists( 'wpp_get_views' ) && $meta_views == '1' ) { ?>
						<span class="gp-post-meta gp-meta-views">
						<?php
						if ( function_exists( 'wpp_get_views' ) ) {
							echo wpp_get_views( get_the_ID() ); }
						?>
						 <?php esc_html_e( 'views', 'aardvark' ); ?></span>
					<?php } ?>

					<?php if ( $meta_likes == '1' ) { ?>
						<span class="gp-post-meta gp-meta-likes">
						<?php
						if ( function_exists( 'ghostpool_voting_show_up_votes' ) ) {
							echo ghostpool_voting_show_up_votes(); }
						?>
						</span>
					<?php } ?>

				</div>

			<?php } ?>

		</div>

	</div>

<?php } ?>
