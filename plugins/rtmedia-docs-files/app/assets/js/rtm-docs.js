/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery( document ).ready( function( $ ) {

	// delete media-[document] from gallery page under the user's profile when user clicks the delete button on the gallery item.
	jQuery( '.rtmedia-list' ).on( 'click', '.rtmp-delete-media-document', function( e ) {
		e.preventDefault();

		if( confirm( rtmedia_media_delete_confirmation ) ) { // if user confirms, send ajax request to delete the selected media
			var curr_tr  = jQuery( this ).closest( 'li' ),
				nonce    = jQuery(this).closest('.doc-delete').find('#rtm_other_file_delete_nonce').val(),
				group_id = jQuery(this).closest('.doc-delete').find('#rtm_group_id').val(),
				data = {
					action: 'rtmedia_docs_other_file_delete_user_media',
					media_id: curr_tr.attr( 'id' ),
					rtm_group_id: group_id,
					delete_nonce: nonce,
				};
			jQuery.ajax( {
				url: ajaxurl,
				type: 'post',
				data: data,
				success: function( data ) {

					if( data == '1' ) {

						var doc_list = $( '.rtmedia-list .rtmedia-list-document-row' );

						//media delete
						curr_tr.remove();

						// Reduce one after delete the doc.
						total_length = doc_list.length - 1;

						// Append no doc found message after deleting all docs.
						if ( 0 === total_length ) {

							var no_doc_container     = $( '<li>' ),
							    no_doc_msg_container = $( '<p>' );

							// Add class to container.
							no_doc_msg_container.attr( {
								'class': 'rtmedia-no-media-found'
							} );

							// Add text to container.
							no_doc_msg_container.text( rtmedia_other_files_main_js.rtmedia_file_no_doc_msg );
							no_doc_container.append( no_doc_msg_container );

							// Display message for no docs found.
							$( '.rtmedia-list' ).append( no_doc_container );
						}

					} else { // show alert message
						typeof rtmedia_gallery_action_alert_message != 'undefined' ? rtmedia_gallery_action_alert_message( rtmedia_other_files_main_js.rtmedia_file_not_deleted, 'warning' ) : alert( rtmedia_other_files_main_js.rtmedia_file_not_deleted );
					}
				}
			} );
		}
	} );

} );
