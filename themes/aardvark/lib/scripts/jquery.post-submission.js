jQuery( document ).ready( function( $ ) {

	'use strict';

	if ( $( '#gp-upload-image' ).length > 0 ) {
		
		// Load plupload parameters
		var gpUploader = new plupload.Uploader({
			browse_button: 'gp-upload-image',
			multipart: true,
			url: ghostpool_post_submission_ajax.ajaxurl,
			max_file_count: 1,
			filters : [
            	{
					extensions: 'jpg,jpeg,gif,png'
            	}
        	]
		});

		// Initialise plupload uploader
		gpUploader.init();
		
		// Get image preview
		function gpImagePreview( file ) {
			var item = $( '<span class="gp-image-preview"></span>' ).prependTo( $( '.gp-uploads' ) );
			var image = $( new Image() ).appendTo( item );
			var preloader = new mOxie.Image();
			preloader.onload = function() {
				preloader.downsize( 150, 150 );
				image.prop( 'src', preloader.getAsDataURL() );
			};
			preloader.load( file.getSource() );
		}

		// Upload files
		gpUploader.bind( 'FilesAdded', function( up, files ) {
				
			if ( up.files.length > 1 ) {
				while( up.files.length > 1 ) {
					if ( up.files.length > 1 ) {
						gpUploader.removeFile(up.files[0]);
					}
				}
				
				$( '.gp-image-preview' ).remove();
				
			}
			
			$( '#gp-upload-image' ).text( $( '#gp-upload-image' ).data( 'image-added' ) );				
			gpImagePreview( files[0] );
	
		});
		
	}
	
	// Process form
	function gpProcessForm( form, ret ) {
	
		form.removeClass( 'gp-loading' );

		if ( ret == 'success' ) {

			form.find( '.gp-post-form' )[0].reset();		
			form.find( '.gp-image-preview' ).remove();	
			form.find( '#gp-upload-image' ).text( $( '#gp-upload-image' ).data( 'upload-image' ) );
			form.find( '.gp-error' ).removeClass( 'gp-error' );		
			form.find( '.gp-success' ).addClass( 'gp-show-message' );
			form.find( '.gp-image-preview' ).removeClass( 'gp-image-removed' );

		} else {

			// Remove image preview
			form.find( '.gp-image-preview img' ).remove();
			form.find( '.gp-image-preview' ).addClass( 'gp-image-removed' );

			// Hide success message
			form.find( '.gp-success' ).removeClass( 'gp-show-message' );

			// Show error messages
			form.find( '.gp-error' ).removeClass( 'gp-error' );		
			form.find( '.gp-field-container' ).each( function() {
				var fieldContainer = $( this ),
					field = fieldContainer.find( '[name]' ),
					value = field.val();
				if ( value == '' ) {
					fieldContainer.addClass( 'gp-error' );
				} else if ( value == '1' && ! form.find( 'input[type="checkbox"]' ).is( ':checked' ) ) {
					fieldContainer.addClass( 'gp-error' );
				}
			});

		}

	}
							
	// Submit form					
	$( '.gp-post-submission-form .gp-submit' ).click( function( e ) { 		   
		
		e.preventDefault();
		
		// Get container ID
		var form = $( this ).parent().parent().parent();
		
		// Loading screen				
		form.addClass( 'gp-loading' );

		// Get fields
		var form_id = form.find( '.gp-post-submission-form-id' ).val(),
			email_address = form.find( '.gp-post-submission-email-address' ).val(),
			subject = form.find( '.gp-post-submission-subject' ).val(),
			title = form.find( '.gp-post-form-title input' ).val(),
			name = form.find( '.gp-post-form-name input' ).val(),
			email = form.find( '.gp-post-form-email input' ).val(),
			cats = form.find( '.gp-post-form-categories select' ).val(),
			formats = form.find( '.gp-post-form-formats select' ).val(),
			content = form.find( '.gp-post-form-content textarea' ).val(),
			tags = form.find( '.gp-post-form-tags input' ).val(),
			toc = form.find( '.gp-post-form-toc input' ),
			submit_status = form.find( '.gp-post-form-status' ).val(),
			email_notification = form.find( '.gp-post-form-notification' ).val();

		// Check if terms of use are checked
		if ( toc.length > 0 && toc.is( ':checked' ) ) {
			var toc = '1';
		} else {
			var toc = '0';
		}

		var formParameters = {
			action: 'ghostpool_post_submission_action',		
			nonce: ghostpool_post_submission_ajax.nonce,
			form_id: form_id,
			email_address: email_address,
			subject: subject,
			title: title,
			name: name,
			email: email,
			cats: cats,
			formats: formats,
			content: content,
			tags: tags,
			toc: toc,
			submit_status: submit_status,
			email_notification: email_notification
		};
						
		if ( $( '#gp-upload-image' ).length > 0 && gpUploader.files.length > 0 && ! $( '.gp-image-preview' ).hasClass( 'gp-image-removed' ) ) {

			// Before uploading files
			gpUploader.bind( 'BeforeUpload', function( up ) {
				gpUploader.settings.multipart_params = formParameters;									
			});
    
			// Upload files
			gpUploader.bind( 'FileUploaded', function( up, file, ret ) {
				var ret = $.parseJSON(ret.response);
				//console.log( 'uploader ' +  ret.status);
				gpProcessForm( form, ret.status );
			});
			
			if ( gpUploader.files.length > 0 ) {
				gpUploader.start();
			} else {
				gpProcessForm( form );
			}
		
		} else {
	
			$.ajax({
				type: 'POST',
				url: ghostpool_post_submission_ajax.ajaxurl,
				data: formParameters,	
				dataType: 'json',
				success: function( data ) {
					//console.log( 'ajax ' + data.status);
					gpProcessForm( form, data.status );
				}
			});

		}
								
	});
				
});