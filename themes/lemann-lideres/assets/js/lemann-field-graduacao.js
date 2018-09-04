(function ($) {
	'use strict';
	$(function () {
		$('.lemann-campos-graduacao-add').click(function() {
			var $new_group = $('.lemann-campos-graduacao').eq(0).clone(),
				count      = $('.lemann-campos-graduacao').length;
			$new_group
				.find( 'input:text, select, textarea' )
					.val( '' )
					.end()
				.find( 'input:checkbox' )
					.prop( 'checked', false )
					.end()
				.find( 'input, select, textarea' )
					.each( function() {
						var name = $( this ).attr( 'name' ),
							id   = $( this ).attr( 'id' );
						$( this ).attr( 'name', name.replace( '[0]', '[' + count + ']' ) );
						if ( 'undefined' != typeof id ) {
							$( this ).attr( 'id', id.replace( '[0]', '[' + count + ']' ) );
						}
					} )
					.end()
				.find( 'label' )
					.each( function() {
						var for_id = $( this ).attr( 'for' );
						if ( 'undefined' != typeof for_id ) {
							$( this ).attr( 'for', for_id.replace( '[0]', '[' + count + ']' ) );
						}
					} )
					.end()
				.append( '<input type="button" class="lemann-campos-graduacao-remove" value="Remover">' );
			$('.lemann-campos-graduacao').last().after( $new_group );
			$( 'body' ).on( 'click', '.lemann-campos-graduacao-remove', function() {
				$( this ).closest( '.lemann-campos-graduacao' ).remove();
			} );
		})
	});
}(jQuery));
