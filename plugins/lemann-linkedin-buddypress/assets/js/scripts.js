(function ($) {
	'use strict';
	$(function () {
		var linkedin_window = null;

		$( '.linkedin-bp__button' ).click(function() {
			var $$ = $( this ),
				$loading = $$.next( '.linkedin-bp__loading' );

			$$.hide();
			$loading.show();

			$.post(
				lemann_linkedin_bp.ajax_url,
				{
					action: 'lemann_linkedin_bp',
					nonce: lemann_linkedin_bp.ajax_nonce,
					url: window.location.href,
					field: $$.data( 'field' )
				},
				function ( response ) {
					if ( response.status == 'need_auth' ) {
						if ( window.confirm( 'Para importar do LinkedIn é preciso autorizar o app. Deseja fazer isso agora? Edições não salvas serão perdidas.' ) ) {
							window.location = response.message;
						}
					}
					if ( response.status == 'success' && '' !== response.message ) {
						if ( 'EMPTY_FIELD' == response.message ) {
							alert( 'O campo não está preenchido no LinkedIn' );
							return;
						}
						var $wrapper = $$.closest( '.editfield' ),
							$text  = $wrapper.find( 'input[type="text"]' ),
							$textarea  = $wrapper.find( '.wp-editor-area' );

						if ( $textarea.length ) {
							var editor_id = $textarea.attr( 'id' ),
								editor    = tinyMCE.get( editor_id );

							editor.execCommand( 'mceInsertContent', false, response.message );
						} else if ( $text.length ) {
							$text.val( response.message );
						}
					}
				},
				'json'
			).always(function() {
				$$.show();
				$loading.hide();
			})
			return false;
		});
	});
}(jQuery));
