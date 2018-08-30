<?php
/**
 * Table item for docs.
 */

global $rtmedia_backbone, $doc_fields;

$rtmedia_backbone = array(
	'backbone'        => false,
	'is_album'        => false,
	'is_edit_allowed' => false,
);

// todo: nonce verification.
$rtmedia_backbone['backbone'] = filter_input( INPUT_POST, 'backbone', FILTER_VALIDATE_BOOLEAN );

$is_edit_allowed = filter_input( INPUT_POST, 'is_edit_allowed', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
if ( isset( $is_edit_allowed[0] ) ) {
	$rtmedia_backbone['is_edit_allowed'] = $is_edit_allowed[0];
}
?>
<li class="rtmedia-list-document-row rtmedia-list-item" id="<?php echo rtmedia_id();  // @codingStandardsIgnoreLine ?>">
	<div class="rtmedia-item-container">
		<div class="doc-title" data-value="<?php echo esc_attr( str_replace( ' ', '-', strtolower( rtmedia_title() ) ) ); ?>">
			<a href="<?php rtmedia_permalink(); ?>"><?php echo esc_html( rtmedia_title() ); ?></a>

			<div class="rtm-docs-options">

			<?php
			if ( is_user_logged_in() && rtmedia_edit_allowed() ) {
			?>
				<span class="doc-edit doc-action"><a href="<?php rtmedia_permalink(); ?>edit" class="no-popup" target="_blank" title="<?php esc_html_e( 'Edit this media', 'rtmedia' ); ?>"> <?php echo esc_html__( 'Edit', 'rtmedia' ); ?></a></span>
			<?php
			}

			if ( is_user_logged_in() && rtmedia_delete_allowed() ) {
			?>
				<span class="doc-delete doc-action"><a href="#" class="no-popup rtmp-delete-media-document" title="<?php esc_html_e( 'Delete this media', 'rtmedia' ); ?>"><?php echo esc_html__( 'Delete', 'rtmedia' ); ?></a>
				<?php wp_nonce_field( 'rtm_other_file_delete_nonce' . rtmedia_id(), 'rtm_other_file_delete_nonce' ); ?>
				<input type="hidden" name="rtm_group_id" id="rtm_group_id" value="<?php echo esc_attr( function_exists( 'bp_get_group_id' ) ? bp_get_group_id() : '' ); ?>" />
				</span>
			<?php
			}

			do_action( 'rtm_docs_list_operation', rtmedia_id() );
			?>
			</div>
		</div>

		<div class="doc-date" data-value="<?php echo esc_attr( rtm_other_files_document_other_files_list_date() ); ?>">
			<?php echo esc_html( rtm_other_files_document_other_files_list_date() ); ?>
		</div>

		<div class="doc-size" data-value="<?php echo esc_attr( rtmedia_file_size() ); ?>">
			<?php
			if ( function_exists( 'rtmedia_file_size' ) ) {

				/**
				 * If it's backbone rquest, then call function only.
				 * Because conversion in MB is done in that using filter
				 * at rtmedia-docs-files/app/RTMediaOtherFiles.php:35
				 */
				if ( $rtmedia_backbone['backbone'] ) {
					echo rtmedia_file_size() . ' MB'; // @codingStandardsIgnoreLine
				} else {
					echo esc_html( round( rtmedia_file_size() / ( 1024 * 1024 ), 2 ) ) . ' MB';
				}
			} else {
				echo '--';
			}
			?>
		</div>
		<?php

		// Set custom fileds.
		if ( ! empty( $doc_fields ) && is_array( $doc_fields ) ) {
			foreach ( $doc_fields as $doc_field ) {
				if ( ! empty( $doc_field ) && is_array( $doc_field ) ) {
					call_user_func( $doc_field['callback'], rtmedia_id() );
				}
			}
		}
		?>
	</div>
</li>
