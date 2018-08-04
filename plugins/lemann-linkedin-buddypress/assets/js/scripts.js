(function ($) {
	'use strict';
	$(function () {
		var linkedin_window = null;

		$( '.linkedin-bp__button' ).click(function() {
			var $$ = $( this );

			$.post(
				lemann_linkedin_bp.ajax_url,
				{
					action: 'lemann_linkedin_bp',
					nonce: lemann_linkedin_bp.ajax_nonce,
					url: window.location.href
				},
				function ( response ) {
					if ( response.status == 'need_auth' ) {
						if ( window.confirm( 'Para importar do LinkedIn é preciso autorizar o app. Deseja fazer isso agora? Edições não salvas serão perdidas.' ) ) {
							window.location = response.message;
						}
					}
					if ( response.status == 'success' && '' !== response.message ) {
						var $wrapper = $$.closest( '.editfield' ),
							$textarea  = $wrapper.find( '.wp-editor-area' );

						if ( $textarea.length ) {
							var editor_id = $textarea.attr( 'id' ),
								editor    = tinyMCE.get( editor_id );

							editor.execCommand( 'mceInsertContent', false, response.message );
						}
					}
				},
				'json'
			);
			return false;
		});
	});
}(jQuery));
