<?php
/**
 * Template for tabular view.
 *
 * @package rtMedia
 */

// Generate random number for gallery container.
// This will be useful when multiple gallery shortcodes are used in a single page.
$rand_id = rand( 0, 1000 );

?>
<div class="rtmedia-container" id="rtmedia_gallery_container_<?php echo esc_attr( $rand_id ); ?>">
<?php
do_action( 'rtmedia_before_media_gallery' );

$title = get_rtmedia_gallery_title();

global $rtmedia_query;

if ( isset( $rtmedia_query->is_gallery_shortcode ) && true === $rtmedia_query->is_gallery_shortcode ) { // if gallery is displayed using gallery shortcode.
	?>
	<h2><?php esc_html_e( 'Media Gallery', 'rtmedia' ); ?></h2>
	<?php
} else {
	?>
	<div id="rtm-gallery-title-container" class="clearfix">
		<h2 class="rtm-gallery-title">
			<?php
			if ( $title ) {
				echo esc_html( $title );
			} else {
				esc_html_e( 'Media Gallery', 'rtmedia' );
			}
			?>
		</h2>
		<div id="rtm-media-options" class="rtm-media-options"><?php do_action( 'rtmedia_media_gallery_actions' ); ?></div>
	</div>
	<div id="rtm-media-gallery-uploader" class="rtm-media-gallery-uploader">
		<?php rtmedia_uploader( array(
			'is_up_shortcode' => false,
			)
		);
		?>
	</div>
	<?php
}

do_action( 'rtmedia_after_media_gallery_title' );

global $doc_fields;
// Filter to add new column.
$doc_fields = apply_filters( 'rtm_docs_file_add_column', array() );

?>

<table class="rtmedia-list-media rtmedia-list-document <?php echo esc_attr( rtmedia_media_gallery_class() ); ?>">
	<thead>
	<tr class="rtmedia-list-document-row">
		<th class="rtmedia-list-document-td-title"><?php esc_html_e( 'Title', 'rtmedia' ); ?></th>
		<th class="rtmedia-list-document-td-date"><?php esc_html_e( 'Uploaded', 'rtmedia' ); ?></th>
		<th class="rtmedia-list-document-td-size"><?php esc_html_e( 'Size', 'rtmedia' ); ?></th>
		<?php
		if ( ! empty( $doc_fields ) ) {
			foreach ( $doc_fields as $doc_field ) {
				if ( ! empty( $doc_field ) && is_array( $doc_field ) ) {
					echo '<th class="' . esc_attr( $doc_field['class'] ) . '">' . esc_html( $doc_field['columns'] ) . '</th>';
				}
			}
		}
		?>
	</tr>
	</thead>
	<tbody>
		<tr class="doc-container-tr">
			<td class="doc-data" colspan="3">
				<?php if ( have_rtmedia() ) : ?>
					<ul class="rtmedia-list doc-data-container">
						<?php
						while ( have_rtmedia() ) :
							rtmedia();
							include( 'document-list-item.php' );
						endwhile;
						?>
					</ul>
				<?php else : ?>
					<p class="rtmedia-no-media-found">
						<?php
							$message = esc_html__( "Oops !! There's no media found for the request !!", 'rtmedia' );

							echo esc_html( apply_filters( 'rtmedia_no_media_found_message_filter', $message ) );
						?>
					</p>
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>

<?php

do_action( 'rtmedia_after_media_gallery' );

?>
</div>
