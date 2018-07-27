<?php
/**
 * Template name: Sem título
 */

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

	// Page options
	$header = ghostpool_option( 'page_header' ) == 'default' ? ghostpool_option( 'page_page_header' ) : ghostpool_option( 'page_header' );

	?>

	<?php ghostpool_page_header(
		$post_id = get_the_ID(),
		$type = $header,
		$bg = ghostpool_option( 'page_header_bg' ),
		$height = ghostpool_option( 'page_header_height', 'height' ) != '' ? ghostpool_option( 'page_header_height', 'height' ) : ghostpool_option( 'page_page_header_height', 'height' )
	); ?>

	<div id="gp-content-wrapper" class="gp-container">

		<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

		<div id="gp-inner-container">

			<div id="gp-content">

				<?php if ( isset( $_GET['post_edit'] ) && $_GET['post_edit'] == 1 ) {

					get_template_part( 'lib/sections/post-submission/post-edit-form' );

				} elseif ( isset( $_GET['post_preview'] ) && $_GET['post_preview'] == 1 && isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'ghostpool_post_preview_action' ) ) {

					get_template_part( 'lib/sections/post-submission/post-preview' );

				} elseif ( ghostpool_option( 'post_submission_page' ) && is_page( ghostpool_option( 'post_submission_page' ) ) ) {

					get_template_part( 'lib/sections/post-submission/post-list' );
				} else {

					get_template_part( 'lib/sections/page/page-content' );

				} ?>

			</div>

			<?php get_sidebar( 'left' ); ?>

			<?php get_sidebar( 'right' ); ?>

		</div>

		<?php do_action( 'ghostpool_end_content_wrapper' ); ?>

		<div class="gp-clear"></div>

	</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
