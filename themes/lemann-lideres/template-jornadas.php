<?php
/*
 * Template name: Jornadas
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

	<?php ghostpool_page_title( '', $header ); ?>

	<div id="gp-content-wrapper" class="gp-container">

		<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

		<div id="gp-inner-container">

			<div id="gp-content">

				<?php
				$jornadas = get_posts(
					array(
						'post_type' => 'jornada',
						'posts_per_page' => -1,
					)
				);
				$jornadas = array_map(
					function( $jornada ) {
						$jornada = (array) $jornada;
						$jornada = [
							'title'     => $jornada['post_title'],
							'excerpt'   => $jornada['post_excerpt'],
							'url'       => get_permalink( $jornada['ID'] ),
							'thumbnail' => get_the_post_thumbnail_url( $jornada['ID'], 'full' ),
						];
						return $jornada;
					},
					$jornadas
				);
				?>
				<script>
				var jornadas = <?php echo json_encode( $jornadas ); ?>
				</script>


			</div>

			<?php get_sidebar( 'left' ); ?>

			<?php get_sidebar( 'right' ); ?>

		</div>

		<?php do_action( 'ghostpool_end_content_wrapper' ); ?>

		<div class="gp-clear"></div>

	</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
