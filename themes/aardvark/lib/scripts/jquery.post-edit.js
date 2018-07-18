jQuery( document ).ready( function( $ ) {

	'use strict';

	if ( $( '#gp-upload-edit-image' ).length > 0 ) {
		
		// Load plupload parameters
		var gpUploader = new plupload.Uploader({
			browse_button: 'gp-upload-edit-image',
			multipart: true,
			url: ghostpool_post_edit_ajax.ajaxurl,
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
				
			if ( up.files.length > 0 ) {
				while( up.files.length > 1 ) {
					if ( up.files.length > 1 ) {
						gpUploader.removeFile( up.files[0] );
					}
				}
				
				$( '.gp-image-preview' ).remove();
				
			}
			
			$( '#gp-upload-edit-image' ).text( $( '#gp-upload-edit-image' ).data( 'image-added' ) );				
			gpImagePreview( files[0] );

		});
		
	}
	
	// Process form
	function gpProcessForm( form, ret ) {
	
		form.removeClass( 'gp-loading' );

		if ( ret == 'success' ) {
	
			form.find( '#gp-upload-edit-image' ).text( $( '#gp-upload-edit-image' ).data( 'upload-image' ) );
			form.find( '.gp-error' ).removeClass( 'gp-error' );		
			form.find( '.gp-success' ).addClass( 'gp-show-message' );

		} else {

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
	$( '.gp-post-edit-form .gp-submit' ).click( function( e ) { 		   
		
		e.preventDefault();
		
		// Get container ID
		var form = $( this ).parent().parent().parent();
		
		// Loading screen				
		form.addClass( 'gp-loading' );

		// Get fields
		var title = form.find( '.gp-post-form-title input' ).val(),
			cats = form.find( '.gp-post-form-categories select' ).val(),
			formats = form.find( '.gp-post-form-formats select' ).val(),
			content = form.find( '.gp-post-form-content textarea' ).val(),
			tags = form.find( '.gp-post-form-tags input' ).val(),
			post_id = form.find( '.gp-post-form-post-id' ).val();

		var formParameters = {
			action: 'ghostpool_post_edit_action',		
			nonce: ghostpool_post_edit_ajax.nonce,
			title: title,
			cats: cats,
			formats: formats,
			content: content,
			tags: tags,
			post_id: post_id
		};
						
		if ( $( '#gp-upload-edit-image' ).length > 0 && gpUploader.files.length > 0 ) {

			// Before uploading files
			gpUploader.bind( 'BeforeUpload', function( up ) {
				gpUploader.settings.multipart_params = formParameters;									
			});
    
			// Upload files
			gpUploader.bind( 'FileUploaded', function( up, file, ret ) {
				var ret = $.parseJSON(ret.response);
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
				url: ghostpool_post_edit_ajax.ajaxurl,
				data: formParameters,	
				dataType: 'json',
				success: function( data ) {
					gpProcessForm( form, data.status );
				}
			});

		}
								
	});
				
});