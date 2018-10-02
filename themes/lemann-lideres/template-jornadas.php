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

				<p>Conheça aqui as jornadas de destaque dos membros da nossa rede de líderes.</p>
				<div class="jornadas-carousel"></div>
				<div class="jornadas-list"></div>
				<div class="jornadas-pagination"></div>

				<script>
					$('body').removeClass('gp-fullwidth');

					var jornadas = <?php echo json_encode( $jornadas ); ?>.filter(function(jornada) {
						return !!jornada.thumbnail;
					});

					var PAGE_SIZE = 16;
					var pageNumber = 1;
					var slideNumber = 0;
					var page = [];

					function jornadasSlider(slideNumber) {
						var jornada = page[slideNumber];
						var slide = '<div class="slide-wrapper" style="background-image: url(' + jornada.thumbnail + ')"><a href="' + jornada.url + '">' +
							'<div class="slide"><div class="slide-content">' +
								'<strong>' + jornada.title + '</strong>' +
								'<span>' + jornada.excerpt + '</span>' +
							'</div></div>' +
						'</a></div>';

						$('.jornadas-carousel').html(slide);
					}

					function paginate(pageNumber) {
						var count = Math.ceil(jornadas.length / PAGE_SIZE);
						if (count === 1) {
							return '';
						}
						var list = '<ul>';
						for (var i = 1; i <= count; i++) {
							if (i == pageNumber) {
								list += '<li><span class="active">' + i + '</span></li>'
							} else {
								list += '<li><a onclick="javascript:showJornadasPage(' + i + ')">' + i + '</a></li>';
							}
						}
						return list + '</ul>';
					}

					function showJornadasPage(pageNumber) {
						pageNumber = pageNumber;
						page = jornadas.slice((pageNumber - 1) * PAGE_SIZE, pageNumber * PAGE_SIZE);

						var list = page.map(function(jornada) {
							return '<div class="jornadas-list--item-wrapper" style="background-image: url(' + jornada.thumbnail + ')"><a href="' + jornada.url + '">' +
								'<div class="jornadas-list--item"><div class="jornadas-list--item-content">' +
									'<strong>' + jornada.title + '</strong>' +
									'<span>' + jornada.excerpt + '</span>' +
								'</div></div>' +
							'</a></div>';
						}).join('');

						$('.jornadas-list').html(list);
						$('.jornadas-pagination').html(paginate(pageNumber));
					}

					showJornadasPage(pageNumber);

					jornadasSlider(slideNumber);
					setInterval(function() {
						slideNumber = (slideNumber + 1) % page.length;
						jornadasSlider(slideNumber);
					}, 5000);
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
