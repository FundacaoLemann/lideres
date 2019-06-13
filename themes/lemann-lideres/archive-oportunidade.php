<?php get_header();

// Get category options
$term_data = null;
if ( isset( get_queried_object()->term_id ) ) {
	$term_id = get_queried_object()->term_id;
	$term_data = get_option( "taxonomy_$term_id" );
}

// Page options
$header = ! isset( $term_data['page_header'] ) || $term_data['page_header'] == 'default' ? ghostpool_option( 'cat_page_header' ) : $term_data['page_header'];
$format = ! isset( $term_data['format'] ) || $term_data['format'] == 'default' ? ghostpool_option( 'cat_format' ) : $term_data['format'];
$style = ! isset( $term_data['style'] ) || $term_data['style'] == 'default' ? ghostpool_option( 'cat_style' ) : $term_data['style'];
$alignment = ! isset( $term_data['alignment'] ) || $term_data['alignment'] == 'default' ? ghostpool_option( 'cat_alignment' ) : $term_data['alignment'];
$orderby = ghostpool_option( 'cat_orderby' );
$per_page = ghostpool_option( 'cat_per_page' );
$offset = ghostpool_option( 'cat_offset' );
$image_size = ghostpool_option( 'cat_image_size' );
$content_display = ghostpool_option( 'cat_content_display' );
$excerpt_length = ghostpool_option( 'cat_excerpt_length' );
$meta_author = ghostpool_option( 'cat_meta', 'author' );
$meta_date = ghostpool_option( 'cat_meta', 'date' );
$meta_comment_count = ghostpool_option( 'cat_meta', 'comment_count' );
$meta_views = ghostpool_option( 'cat_meta', 'views' );
$meta_likes = ghostpool_option( 'cat_meta', 'likes' );
$meta_cats = ghostpool_option( 'cat_meta', 'cats' );
$meta_tags = ghostpool_option( 'cat_meta', 'tags' );
$read_more_link = ghostpool_option( 'cat_read_more_link' );
$pagination = ghostpool_option( 'cat_pagination' );

// Classes
$css_classes = array(
	'gp-posts-wrapper',
	'gp-archive-wrapper',
	$format,
	$style,
	$alignment,
);
$css_classes = trim( implode( ' ', array_filter( array_unique( $css_classes ) ) ) );

$temas_interesse = get_terms([
	'taxonomy'   => 'temas_oportunidade',
	'hide_empty' => false
]);
$tema_url = $_GET['cat'];
$term = get_term_by('slug', $tema_url, 'temas_oportunidade');

$data_inicial = $_GET['data_inicial'];
$data_final = $_GET['data_final'];
?>

<?php ghostpool_page_header(
	$post_id = '',
	$type = $header,
	$bg = isset( $term_data['page_header_bg'] ) ? $term_data['page_header_bg'] : '',
	$height = ghostpool_option( 'cat_page_header_height', 'height' )
); ?>

<?php
add_filter('ghostpool_archives_title', function () {
	return 'Oportunidades';
});
ghostpool_page_title( '', $header ); ?>
<div id="gp-content-wrapper" class="gp-container">

	<?php do_action( 'ghostpool_begin_content_wrapper' ); ?>

	<div id="gp-inner-container">

		<div id="gp-content">

			<form id="filters" method="GET" action="">
				<?php if ($tema_url || $data_inicial || $data_final): ?>
					<p>Exibindo resultados
					<?php if ($tema_url) : ?>
						para "<strong><?= $term->name ?></strong>"
					<?php endif;
					if ($data_inicial) : ?>
						desde <?= date_format(date_create($data_inicial), 'd/m/Y') ?>
					<?php endif;
					if ($data_final) : ?>
						até <?= date_format(date_create($data_final), 'd/m/Y') ?>
					<?php endif; ?>
					</p>
				<?php endif; ?>

				<div class="field-group">
					<label for="cat">Categoria</label>
					<select id="cat" name="cat">
						<?php if ($tema_url): ?>
							<option value="">--- Remover filtro ---</option>
						<?php else: ?>
							<option value="">--- Selecionar opção ---</option>
						<?php endif; ?>

						<?php foreach ($temas_interesse as $tema): ?>
							<option value="<?= $tema->slug ?>" <?= $tema_url == $tema->slug ? 'selected' : '' ?>><?= $tema->name ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="field-group">
					<label for="data_inicial">Data inicial</label>
					<input type="date" id="data_inicial" name="data_inicial" value="<?= $data_inicial ?>">
				</div>

				<div class="field-group">
					<label for="data_final">Data final</label>
					<input type="date" id="data_final" name="data_final" value="<?= $data_final ?>">
				</div>

				<div class="field-group field-group--button">
					<button type="submit">Filtrar</button>
				</div>
			</form>

			<div class="<?php echo esc_attr( $css_classes ); ?>" data-type="<?php if ( is_home() ) { ?>home<?php } else { ?>taxonomy<?php } ?>"<?php if ( function_exists( 'ghostpool_filter_variables' ) ) { echo ghostpool_filter_variables( '', '', '', $format, $style, $orderby, $per_page, $offset, $image_size, $content_display, $excerpt_length, $meta_author, $meta_date, $meta_comment_count, $meta_views, $meta_likes, $meta_cats, $meta_tags, $read_more_link, $pagination ); } ?>>

				<?php ghostpool_filter( ghostpool_option( 'cat_filters' ), '', $orderby, $pagination ); ?>

				<div class="gp-section-loop <?php echo sanitize_html_class( ghostpool_option( 'ajax' ) ); ?>">

					<?php if ( have_posts() ) : ?>

						<div class="gp-section-loop-inner">
							<div class="oportunidade-cards">
								<?php while ( have_posts() ) : the_post();
									$post_id = get_the_ID();
									$item_cat = get_the_terms($post_id, 'temas_oportunidade');
									$item_data_inicial = get_post_meta($post_id, 'data_inicial', true);
									$item_data_final = get_post_meta($post_id, 'data_final', true);
								?>
									<article class="oportunidade-card">
										<a class="oportunidade-card__image" href="<?= get_the_permalink() ?>" style="background-image: url(<?= get_the_post_thumbnail_url($post_id, 'medium_large')?>)"></a>
										<div class="oportunidade-card__content">
											<?php if (is_array($item_cat)): ?>
												<span class="oportunidade-card__category"><?= $item_cat[0]->name ?></span>
											<?php endif; ?>
											<?php if ($item_data_inicial): ?>
												<span class="oportunidade-card__date">
													<?= date_format(date_create($item_data_inicial), 'd/m/Y') ?>
													<?php if ($item_data_inicial != $item_data_final): ?>
														a <?= date_format(date_create($item_data_final), 'd/m/Y') ?>
													<?php endif; ?>
												</span>
											<?php endif; ?>
											<a class="oportunidade-card__title" href="<?= get_the_permalink(); ?>"><?= get_the_title() ?></a>
											<div class="oportunidade-card__details">
												<?= ghostpool_author_name($meta_author) ?>
											</div>
											<div class="oportunidade-card__excerpt"><?= ghostpool_excerpt($excerpt_length, $read_more_link, $style) ?></div>
										</div>
									</article>
								<?php endwhile; ?>
							</div>
						</div>

						<?php echo ghostpool_pagination( $wp_query->max_num_pages, $pagination ); ?>

					<?php else : ?>

						<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'aardvark' ); ?></strong>

					<?php endif; ?>

				</div>

			</div>

		</div>

		<?php // get_sidebar( 'left' ); ?>

		<?php // get_sidebar( 'right' ); ?>

	</div>

	<?php do_action( 'ghostpool_end_content_wrapper' ); ?>

	<div class="gp-clear"></div>

</div>

<?php get_footer(); ?>